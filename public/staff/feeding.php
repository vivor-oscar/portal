<?php

// debug mode: add ?debug=1 to the URL to enable error display
$DEBUG = isset($_GET['debug']) && $_GET['debug'] == '1';
if ($DEBUG) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}
include 'include/side-bar.php';
include '../../includes/database.php';


// Determine staff username and assigned class using staff_classes mapping
$staff_username = $_SESSION['username'];
$staff_class = '';
$staff_result = $conn->query("SELECT staff_id FROM staff WHERE username = '" . $conn->real_escape_string($staff_username) . "'");
$staff_data = $staff_result ? $staff_result->fetch_assoc() : null;
$staff_id = $staff_data['staff_id'] ?? null;

if ($staff_id) {
    $class_query = $conn->query("SELECT c.class_name FROM staff_classes sc JOIN class c ON sc.class_name = c.class_name WHERE sc.staff_id = '" . $conn->real_escape_string($staff_id) . "'");
    $class_row = $class_query ? $class_query->fetch_assoc() : null;
    if ($class_row) $staff_class = $class_row['class_name'];
}

// Fetch students in this class (use attendance.php style)
$students = [];
if ($staff_class) {
    $student_query = "SELECT s.student_id, s.first_name, s.last_name, s.email, s.username, s.class, s.curaddress FROM students s WHERE s.class = '" . $conn->real_escape_string($staff_class) . "'";
    $sr = $conn->query($student_query);
    if ($sr) $students = $sr->fetch_all(MYSQLI_ASSOC);

    // create lookup map by student_id for friendly display names
    $studentsById = [];
    foreach ($students as $s) {
        $studentsById[$s['student_id']] = $s;
    }

    // Exclude students who already have a full week's score (5) for the current week
    $week_start = date('Y-m-d', strtotime('monday this week'));
    $excludedIds = [];
    if (!empty($staff_class)) {
        $q = "SELECT w.student_id FROM weekly_service_scores w JOIN students s ON w.student_id=s.student_id WHERE w.week_start='" . $conn->real_escape_string($week_start) . "' AND s.class='" . $conn->real_escape_string($staff_class) . "' AND w.score>=5";
        $rr = $conn->query($q);
        if ($rr) {
            while ($r = $rr->fetch_assoc()) {
                $excludedIds[$r['student_id']] = true;
            }
        }
    }

    // students to show in the marking UI (filter out excluded)
    $students_display = array_filter($students, function ($r) use ($excludedIds) {
        return !isset($excludedIds[$r['student_id']]);
    });

    // friendly count for notice
    $excluded_count = count($students) - count($students_display);
}

// Fetch services
$services = [];
$fr = $conn->query("SELECT * FROM service_fees ORDER BY service_name, location");
if ($fr) $services = $fr->fetch_all(MYSQLI_ASSOC);

// detect if service_payments has a days_paid column
$has_days_column = false;
$colq = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . $conn->real_escape_string($conn->query("SELECT DATABASE() as db")->fetch_assoc()['db']) . "' AND TABLE_NAME='service_payments' AND COLUMN_NAME='days_paid'");
if ($colq && $colq->num_rows > 0) $has_days_column = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mark_paid') {
    $student_id = $conn->real_escape_string($_POST['student_id']);
    $service_fee_id = (int)$_POST['service_fee_id'];
    $amount_paid = (float)($_POST['amount_paid'] ?? 0);
    // days to pay (1-5). empty or invalid -> 1
    $days = isset($_POST['days']) && is_numeric($_POST['days']) ? (int)$_POST['days'] : 1;
    if ($days < 1) $days = 1;
    if ($days > 5) $days = 5;
    try {

        // Prevent double-marking: check if there's already a payment for this student/service for today
        $today = date('Y-m-d');
        $checkQ = "SELECT COUNT(*) AS c FROM service_payments WHERE student_id='" . $student_id . "' AND service_fee_id=$service_fee_id AND DATE(payment_date)='" . $today . "'";
        $cres = $conn->query($checkQ);
        $already = false;
        if ($cres && $crow = $cres->fetch_assoc()) {
            $already = ((int)$crow['c'] > 0);
        }

        if ($already) {
            // show friendly name when available
            $displayName = $student_id;
            if (isset($studentsById[$student_id])) {
                $sn = $studentsById[$student_id];
                $displayName = trim((($sn['first_name'] ?? '') . ' ' . ($sn['last_name'] ?? '')));
                if ($displayName === '') $displayName = $student_id;
            }
            $_SESSION['message'] = $displayName . ' has already been marked as paid for this service today.';
            // don't redirect/exit; render the page with the message to avoid disappearance
        }

        // Insert payment
        $receipt = 'RCPT-' . time() . rand(100, 999);
        // prefer numeric staff_id if available
        $pay_staff_id = $staff_id ? $conn->real_escape_string($staff_id) : $conn->real_escape_string($_SESSION['username'] ?? '');
        // multiply amount by days and store total amount_paid
        $total_amount = $amount_paid * $days;
        $amount_paid_safe = number_format((float)$total_amount, 2, '.', '');
        if ($has_days_column) {
            $insertQ = "INSERT INTO service_payments (student_id, service_fee_id, amount_paid, days_paid, staff_id, receipt_number, payment_date) VALUES ('" .
                $student_id . "', $service_fee_id, $amount_paid_safe, $days, '" . $pay_staff_id . "', '$receipt', NOW())";
        } else {
            $insertQ = "INSERT INTO service_payments (student_id, service_fee_id, amount_paid, staff_id, receipt_number, payment_date) VALUES ('" .
                $student_id . "', $service_fee_id, $amount_paid_safe, '" . $pay_staff_id . "', '$receipt', NOW())";
        }
        if ($conn->query($insertQ)) {
            // update weekly score: find week start (Monday)
            $week_start = date('Y-m-d', strtotime('monday this week', strtotime($today)));
            // get service name
            $srv = $conn->query("SELECT service_name FROM service_fees WHERE service_fee_id=$service_fee_id");
            $service_name = 'service';
            if ($srv && $rrow = $srv->fetch_assoc()) $service_name = $rrow['service_name'];

            // set weekly score = days (capped at 5)
            $newScore = min(5, intval($days));
            $wq = "INSERT INTO weekly_service_scores (student_id, week_start, service_name, score) VALUES ('" . $student_id . "', '" . $week_start . "', '" . $service_name . "', " . $newScore . ")
          ON DUPLICATE KEY UPDATE score = " . $newScore;
            $conn->query($wq);

            $_SESSION['message'] = 'Payment recorded and score updated.';
            // Update class summaries (daily and weekly)
            try {
                // determine class for this student
                $cres = $conn->query("SELECT class FROM students WHERE student_id='" . $student_id . "' LIMIT 1");
                $className = '';
                if ($cres && $crow = $cres->fetch_assoc()) $className = $crow['class'];
                if ($className !== '') {
                    $className = trim($className);
                    // compute expected and received totals for the class for today
                    $summaryDate = date('Y-m-d');
                    $expected = 0.00;
                    // expected = sum of service_fees.amount for students in class that match fee location
                    $sf = $conn->query("SELECT * FROM service_fees");
                    if ($sf) {
                        while ($fee = $sf->fetch_assoc()) {
                            $field = $conn->real_escape_string($fee['student_location_field'] ?? 'curaddress');
                            $loc = $conn->real_escape_string($fee['location']);
                            // count students in class matching this fee
                            $q = "SELECT COUNT(*) AS c FROM students WHERE class='" . $conn->real_escape_string($className) . "' AND COALESCE(`" . $field . "`, '') = '" . $loc . "'";
                            $r = $conn->query($q);
                            if ($r && $rr = $r->fetch_assoc()) {
                                $expected += (float)$fee['amount'] * (int)$rr['c'];
                            }
                        }
                    }
                    // received total today for this class
                    $rq = $conn->query("SELECT IFNULL(SUM(amount_paid),0) AS s FROM service_payments sp JOIN students st ON sp.student_id=st.student_id WHERE st.class='" . $conn->real_escape_string($className) . "' AND DATE(sp.payment_date)='" . $summaryDate . "'");
                    $received = 0.00;
                    if ($rq && $rr = $rq->fetch_assoc()) $received = (float)$rr['s'];

                    // upsert into daily_class_summaries
                    $u = $conn->prepare("INSERT INTO daily_class_summaries (class_name, summary_date, expected_total, received_total) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE expected_total = VALUES(expected_total), received_total = VALUES(received_total)");
                    if ($u) {
                        $u->bind_param('ssdd', $className, $summaryDate, $expected, $received);
                        if (!$u->execute()) {
                            error_log('daily_class_summaries upsert failed: ' . $u->error . PHP_EOL, 3, __DIR__ . '/../../logs/payment_errors.log');
                        }
                        $u->close();
                    } else {
                        error_log('prepare for daily_class_summaries failed: ' . $conn->error . PHP_EOL, 3, __DIR__ . '/../../logs/payment_errors.log');
                    }

                    // weekly summary: week_start (Monday)
                    $weekStart = date('Y-m-d', strtotime('monday this week', strtotime($summaryDate)));
                    // expected for week: sum per student across 7 days. Simpler approach: expected per week = expected per day * 5 (or 7?)
                    // We'll use 5 as business rule (week-of-service = 5 days). If you want 7, adjust here.
                    $expected_week = $expected * 5;
                    $rqq = $conn->query("SELECT IFNULL(SUM(amount_paid),0) AS s FROM service_payments sp JOIN students st ON sp.student_id=st.student_id WHERE st.class='" . $conn->real_escape_string($className) . "' AND DATE(sp.payment_date) BETWEEN '" . $weekStart . "' AND DATE_ADD('" . $weekStart . "', INTERVAL 6 DAY)");
                    $received_week = 0.00;
                    if ($rqq && $rrr = $rqq->fetch_assoc()) $received_week = (float)$rrr['s'];

                    $u2 = $conn->prepare("INSERT INTO weekly_class_summaries (class_name, week_start, expected_total, received_total) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE expected_total = VALUES(expected_total), received_total = VALUES(received_total)");
                    if ($u2) {
                        $u2->bind_param('ssdd', $className, $weekStart, $expected_week, $received_week);
                        if (!$u2->execute()) {
                            error_log('weekly_class_summaries upsert failed: ' . $u2->error . PHP_EOL, 3, __DIR__ . '/../../logs/payment_errors.log');
                        }
                        $u2->close();
                    } else {
                        error_log('prepare for weekly_class_summaries failed: ' . $conn->error . PHP_EOL, 3, __DIR__ . '/../../logs/payment_errors.log');
                    }
                }
            } catch (Throwable $ex) {
                error_log('Error updating class summaries: ' . $ex->getMessage() . PHP_EOL, 3, __DIR__ . '/../../logs/payment_errors.log');
            }
        } else {
            $_SESSION['message'] = 'Error recording payment: ' . $conn->error;
        }
        // allow the page to continue rendering instead of redirecting away
    } catch (Throwable $e) {
        $msg = "Exception in mark_paid: " . $e->getMessage();
        error_log($msg . PHP_EOL, 3, __DIR__ . '/../../logs/payment_errors.log');
        if ($DEBUG) echo '<pre>' . htmlspecialchars($msg) . '</pre>';
        $_SESSION['message'] = 'Error processing payment. Check logs.';
        // continue rendering page so user sees the message
    }
}

// Handle bulk marking selected students
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mark_selected') {
    $service_fee_id = (int)($_POST['service_fee_id'] ?? 0);
    $student_ids = $_POST['student_ids'] ?? [];
    $amount_paid = isset($_POST['amount_paid']) ? (float)$_POST['amount_paid'] : 0.00;
    try {

        if (empty($service_fee_id) || empty($student_ids)) {
            $_SESSION['message'] = 'No students or service selected.';
            // do not redirect/exit; render the page so the message is visible
        }

        $today = date('Y-m-d');
        $receiptBase = 'RCPT-' . time();
        $successCount = 0;
        $skippedCount = 0;
        $skipped_reasons = [];
        // bulk days: a single days value for all selected (optional)
        $bulk_days = isset($_POST['days']) && is_numeric($_POST['days']) ? (int)$_POST['days'] : 1;
        if ($bulk_days < 1) $bulk_days = 1;
        if ($bulk_days > 5) $bulk_days = 5;

        // Precompute a map of students by id for quick lookup and a function to compute expected amount per student
        $studentsById = [];
        foreach ($students as $s) $studentsById[$s['student_id']] = $s;
        $computeExpected = function ($sid) use ($studentsById, $services) {
            $amt = 0.00;
            if (!isset($studentsById[$sid])) return $amt;
            $st = $studentsById[$sid];
            foreach ($services as $svv) {
                $field = isset($svv['student_location_field']) && !empty($svv['student_location_field']) ? $svv['student_location_field'] : 'curaddress';
                $locPlain = trim($svv['location']);
                $val = isset($st[$field]) ? trim($st[$field]) : '';
                if ($val !== '' && strcasecmp($val, $locPlain) === 0) {
                    $amt += (float)$svv['amount'];
                }
            }
            return $amt;
        };

        foreach ($student_ids as $sid) {
            $sidEsc = $conn->real_escape_string($sid);
            // check duplicate: if a specific service is selected we check for that service; if using expected amounts (service_fee_id==0) skip service-specific duplicate check
            $already = false;
            if ($service_fee_id !== 0) {
                $checkQ = "SELECT COUNT(*) AS c FROM service_payments WHERE student_id='" . $sidEsc . "' AND service_fee_id=$service_fee_id AND DATE(payment_date)='$today'";
                $cres = $conn->query($checkQ);
                if ($cres && $crow = $cres->fetch_assoc()) $already = ((int)$crow['c'] > 0);
            } else {
                // when using expected amounts, check if any payment exists for this student today (avoid double-marking for any service)
                $checkQ = "SELECT COUNT(*) AS c FROM service_payments WHERE student_id='" . $sidEsc . "' AND DATE(payment_date)='$today'";
                $cres = $conn->query($checkQ);
                if ($cres && $crow = $cres->fetch_assoc()) $already = ((int)$crow['c'] > 0);
            }
            if ($already) {
                $skippedCount++;
                // prefer friendly name in skipped reasons
                $friendly = $sidEsc;
                if (isset($studentsById[$sid])) {
                    $sn = $studentsById[$sid];
                    $friendly = trim((($sn['first_name'] ?? '') . ' ' . ($sn['last_name'] ?? '')));
                    if ($friendly === '') $friendly = $sidEsc;
                }
                $skipped_reasons[] = $friendly . ': has already paid today';
                continue;
            }

            $receipt = $receiptBase . rand(100, 999);
            $pay_staff_id = $staff_id ? $conn->real_escape_string($staff_id) : $conn->real_escape_string($_SESSION['username'] ?? '');

            // Determine the insert amount: either use the provided bulk amount or compute expected per-student amount when service_fee_id==0
            if ($service_fee_id === 0) {
                $studentAmt = $computeExpected($sid);
                $total_amount = $studentAmt * $bulk_days; // still multiply by days
            } else {
                $total_amount = $amount_paid * $bulk_days;
            }
            $amount_paid_safe = number_format((float)$total_amount, 2, '.', '');
            if ($has_days_column) {
                $insertQ = "INSERT INTO service_payments (student_id, service_fee_id, amount_paid, days_paid, staff_id, receipt_number, payment_date) VALUES ('" .
                    $sidEsc . "', $service_fee_id, $amount_paid_safe, $bulk_days, '" . $pay_staff_id . "', '$receipt', NOW())";
            } else {
                $insertQ = "INSERT INTO service_payments (student_id, service_fee_id, amount_paid, staff_id, receipt_number, payment_date) VALUES ('" .
                    $sidEsc . "', $service_fee_id, $amount_paid_safe, '" . $pay_staff_id . "', '$receipt', NOW())";
            }
            if ($conn->query($insertQ)) {
                // update weekly score for each student
                $week_start = date('Y-m-d', strtotime('monday this week', strtotime($today)));
                if ($service_fee_id === 0) {
                    $service_name = $conn->real_escape_string($_POST['service_name'] ?? 'service');
                } else {
                    $srv = $conn->query("SELECT service_name FROM service_fees WHERE service_fee_id=$service_fee_id");
                    $service_name = 'service';
                    if ($srv && $rrow = $srv->fetch_assoc()) $service_name = $rrow['service_name'];
                }

                // set weekly score = bulk_days (capped at 5)
                $newScore = min(5, intval($bulk_days));
                $wq = "INSERT INTO weekly_service_scores (student_id, week_start, service_name, score) VALUES ('" . $sidEsc . "', '" . $week_start . "', '" . $conn->real_escape_string($service_name) . "', " . $newScore . ")
            ON DUPLICATE KEY UPDATE score = " . $newScore;
                $conn->query($wq);
                $successCount++;
                // update class summaries for this student's class (same logic as single insert)
                try {
                    $cres = $conn->query("SELECT class FROM students WHERE student_id='" . $sidEsc . "' LIMIT 1");
                    $className = '';
                    if ($cres && $crow = $cres->fetch_assoc()) $className = $crow['class'];
                    if ($className !== '') {
                        $className = trim($className);
                        $summaryDate = date('Y-m-d');
                        $expected = 0.00;
                        $sf = $conn->query("SELECT * FROM service_fees");
                        if ($sf) {
                            while ($fee = $sf->fetch_assoc()) {
                                $field = $conn->real_escape_string($fee['student_location_field'] ?? 'curaddress');
                                $loc = $conn->real_escape_string($fee['location']);
                                $q = "SELECT COUNT(*) AS c FROM students WHERE class='" . $conn->real_escape_string($className) . "' AND COALESCE(`" . $field . "`, '') = '" . $loc . "'";
                                $r = $conn->query($q);
                                if ($r && $rr = $r->fetch_assoc()) {
                                    $expected += (float)$fee['amount'] * (int)$rr['c'];
                                }
                            }
                        }
                        $rq = $conn->query("SELECT IFNULL(SUM(amount_paid),0) AS s FROM service_payments sp JOIN students st ON sp.student_id=st.student_id WHERE st.class='" . $conn->real_escape_string($className) . "' AND DATE(sp.payment_date)='" . $summaryDate . "'");
                        $received = 0.00;
                        if ($rq && $rr = $rq->fetch_assoc()) $received = (float)$rr['s'];
                        $u = $conn->prepare("INSERT INTO daily_class_summaries (class_name, summary_date, expected_total, received_total) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE expected_total = VALUES(expected_total), received_total = VALUES(received_total)");
                        if ($u) {
                            $u->bind_param('ssdd', $className, $summaryDate, $expected, $received);
                            if (!$u->execute()) {
                                error_log('daily_class_summaries upsert failed (bulk): ' . $u->error . PHP_EOL, 3, __DIR__ . '/../../logs/payment_errors.log');
                            }
                            $u->close();
                        } else {
                            error_log('prepare for daily_class_summaries failed (bulk): ' . $conn->error . PHP_EOL, 3, __DIR__ . '/../../logs/payment_errors.log');
                        }

                        $weekStart = date('Y-m-d', strtotime('monday this week', strtotime($summaryDate)));
                        $expected_week = $expected * 5;
                        $rqq = $conn->query("SELECT IFNULL(SUM(amount_paid),0) AS s FROM service_payments sp JOIN students st ON sp.student_id=st.student_id WHERE st.class='" . $conn->real_escape_string($className) . "' AND DATE(sp.payment_date) BETWEEN '" . $weekStart . "' AND DATE_ADD('" . $weekStart . "', INTERVAL 6 DAY)");
                        $received_week = 0.00;
                        if ($rqq && $rrr = $rqq->fetch_assoc()) $received_week = (float)$rrr['s'];
                        $u2 = $conn->prepare("INSERT INTO weekly_class_summaries (class_name, week_start, expected_total, received_total) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE expected_total = VALUES(expected_total), received_total = VALUES(received_total)");
                        if ($u2) {
                            $u2->bind_param('ssdd', $className, $weekStart, $expected_week, $received_week);
                            if (!$u2->execute()) {
                                error_log('weekly_class_summaries upsert failed (bulk): ' . $u2->error . PHP_EOL, 3, __DIR__ . '/../../logs/payment_errors.log');
                            }
                            $u2->close();
                        } else {
                            error_log('prepare for weekly_class_summaries failed (bulk): ' . $conn->error . PHP_EOL, 3, __DIR__ . '/../../logs/payment_errors.log');
                        }
                    }
                } catch (Throwable $ex) {
                    error_log('Error updating class summaries (bulk): ' . $ex->getMessage() . PHP_EOL, 3, __DIR__ . '/../../logs/payment_errors.log');
                }
            } else {
                // record the insert error and continue
                $skippedCount++;
                $err = $conn->error;
                $skipped_reasons[] = $sidEsc . ':insert_failed:' . $err;
                error_log("service_payments insert failed for $sidEsc (service_fee_id=$service_fee_id): $err" . PHP_EOL, 3, __DIR__ . '/../../logs/payment_errors.log');
            }
        }
        $msg = "Bulk operation finished: $successCount recorded, $skippedCount skipped.";
        if (!empty($skipped_reasons)) {
            $msg .= ' Skipped details: ' . implode('; ', $skipped_reasons);
        }
        $_SESSION['message'] = $msg;
        // do not redirect; let the page render the result message

    } catch (Throwable $e) {
        $msg = "Exception in mark_selected: " . $e->getMessage();
        error_log($msg . PHP_EOL, 3, __DIR__ . '/../../logs/payment_errors.log');
        if ($DEBUG) echo '<pre>' . htmlspecialchars($msg) . '</pre>';
        $_SESSION['message'] = 'Error processing bulk payment. Check logs.';
        // continue rendering to show message
    }
}

?>

<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-auto">
        <h2 class="text-xl font-bold mb-4">Mark Feeding/Transport Payment (Class: <?php echo htmlspecialchars($staff_class); ?>)</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="bg-green-100 p-2 mb-3"><?php echo $_SESSION['message'];
                                                unset($_SESSION['message']); ?></div>
        <?php endif; ?>

        <?php
        // Consolidated student table: show all students in the staff's class with their location and expected amount
        if (empty($staff_class)) {
            echo '<div class="bg-yellow-100 p-2 mb-4">No class assigned to you. Ask admin to assign a class.</div>';
        } else {
            // Precompute expected amount per student (sum of matching service fees)
            $expected_map = [];
            foreach ($students as $s) {
                $expected_map[$s['student_id']] = 0.00;
                foreach ($services as $svv) {
                    $field = isset($svv['student_location_field']) && !empty($svv['student_location_field']) ? $svv['student_location_field'] : 'curaddress';
                    $locPlain = trim($svv['location']);
                    $val = isset($s[$field]) ? trim($s[$field]) : '';
                    if ($val !== '' && strcasecmp($val, $locPlain) === 0) {
                        $expected_map[$s['student_id']] += (float)$svv['amount'];
                    }
                }
            }
        ?>
            <div class="mb-6 bg-white p-3 rounded shadow dark:bg-gray-800 dark:shadow-none dark:border dark:border-gray-700">
                <h4 class="font-semibold mb-2">Students in <?php echo htmlspecialchars($staff_class); ?></h4>
                <form method="post" class="mb-2">
                    <input type="hidden" name="action" value="mark_selected">
                    <!-- service_fee_id == 0 means use per-student expected amounts calculated from service_fees -->
                    <input type="hidden" name="service_fee_id" value="0">
                    <div class="mb-2">
                        <label class="inline-flex items-center mr-4"><input type="radio" name="amount_mode" value="expected" checked> Use expected amount per student</label>
                        <label class="inline-flex items-center"><input type="radio" name="amount_mode" value="manual"> Use manual amount for all selected</label>
                    </div>

                    <div class="overflow-x-auto rounded-lg border p-2 dark:border-gray-700">
                        <table class="min-w-full text-left text-sm divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-2">Select</th>
                                    <th class="px-2">Student</th>
                                    <th class="px-2">Location</th>
                                    <th class="px-2">Expected Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students_display as $ms): ?>
                                    <tr>
                                        <td class="px-2"><input type="checkbox" name="student_ids[]" value="<?php echo htmlspecialchars($ms['student_id']); ?>"></td>
                                        <td class="px-2 text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($ms['first_name'] . ' ' . $ms['last_name']); ?></td>
                                        <td class="px-2 text-gray-700 dark:text-gray-300"><?php echo htmlspecialchars($ms['curaddress']); ?></td>
                                        <td class="px-2 text-gray-700 dark:text-gray-300"><?php echo number_format($expected_map[$ms['student_id']] ?? 0, 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2 grid grid-cols-3 gap-2">
                        <input type="number" step="0.01" name="amount_paid" placeholder="Amount paid (per student)" class="p-2 border rounded" value="0.00">
                        <select name="days" class="p-2 border rounded">
                            <option value="1">1 day</option>
                            <option value="2">2 days</option>
                            <option value="3">3 days</option>
                            <option value="4">4 days</option>
                            <option value="5">5 days</option>
                        </select>
                        <div></div>
                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">Mark Selected Paid</button>
                    </div>
                </form>
            </div>
            <?php
        }
        // If there are no defined services, show a generic block listing all students (attendance-style)
        if (empty($services)) {
            if (!empty($students)) {
            ?>
                <div class="mb-6 bg-white p-3 rounded shadow">
                    <h4 class="font-semibold mb-2">All students in <?php echo htmlspecialchars($staff_class); ?></h4>
                    <form method="post">
                        <input type="hidden" name="action" value="mark_selected">
                        <input type="hidden" name="service_fee_id" value="0">
                        <div class="mb-2">
                            <label class="block text-sm">Service name</label>
                            <select name="service_name" class="p-2 border rounded">
                                <option value="feeding">Feeding & Transport</option>
                            </select>
                        </div>
                        <?php if ($excluded_count > 0): ?>
                            <div class="mb-3 bg-yellow-50 dark:bg-yellow-900 p-3 rounded text-sm text-gray-800 dark:text-gray-100">
                                <strong>Excluded students (will reappear on <?php echo date('M j, Y', strtotime($week_start . ' +7 days')); ?>):</strong>
                                <ul class="mt-2 list-disc list-inside">
                                    <?php foreach (array_keys($excludedIds) as $eid):
                                        $sn = $studentsById[$eid] ?? null;
                                        $display = $sn ? trim((($sn['first_name'] ?? '') . ' ' . ($sn['last_name'] ?? ''))) : $eid;
                                        if ($display === '') $display = $eid;
                                    ?>
                                        <li><?php echo htmlspecialchars($display); ?> <span class="text-xs text-gray-600 dark:text-gray-300">(<?php echo htmlspecialchars($eid); ?>)</span></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="overflow-x-auto rounded-lg border p-2 dark:border-gray-700">
                            <table class="min-w-full text-left text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-2">Select</th>
                                        <th class="px-2">Student</th>
                                        <th class="px-2">Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students_display as $ms): ?>
                                        <tr>
                                            <td class="px-2"><input type="checkbox" name="student_ids[]" value="<?php echo htmlspecialchars($ms['student_id']); ?>"></td>
                                            <td class="px-2 text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($ms['first_name'] . ' ' . $ms['last_name']); ?></td>
                                            <td class="px-2 text-gray-700 dark:text-gray-300"><?php echo htmlspecialchars($ms['curaddress']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-2 grid grid-cols-3 gap-2">
                            <input type="number" step="0.01" name="amount_paid" placeholder="Amount paid (per student)" class="p-2 border rounded" value="0.00">
                            <select name="days" class="p-2 border rounded">
                                <option value="1">1 day</option>
                                <option value="2">2 days</option>
                                <option value="3">3 days</option>
                                <option value="4">4 days</option>
                                <option value="5">5 days</option>
                            </select>
                            <div></div>
                            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">Mark Selected Paid</button>
                        </div>
                    </form>
                </div>
        <?php
            }
        }
        ?>

        <h3 class="font-semibold">Weekly Scores (this week)</h3>
        <?php
        $week_start = date('Y-m-d', strtotime('monday this week'));
        $scores = [];
        $sq = $conn->query("SELECT w.student_id, w.service_name, w.score, s.first_name, s.last_name FROM weekly_service_scores w JOIN students s ON w.student_id=s.student_id WHERE w.week_start='" . $week_start . "' AND s.class='" . $conn->real_escape_string($staff_class) . "'");
        if ($sq) $scores = $sq->fetch_all(MYSQLI_ASSOC);
        ?>
        <table class="w-full text-center text-sm">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Service</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scores as $sc): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sc['first_name'] . ' ' . $sc['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($sc['service_name']); ?></td>
                        <td><?php echo (int)$sc['score']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div style="border-top: 10px solid cyan;">
            <?php if ($excluded_count > 0): ?>
                <div class="mb-2 text-sm text-yellow-600 dark:text-yellow-400">Note: <?php echo $excluded_count; ?> student(s) already have a full score for this week and are hidden from this list.</div>
                <div class="mb-3 bg-yellow-50 dark:bg-yellow-900 p-3 rounded text-sm text-gray-800 dark:text-gray-100">
                    <strong>Excluded students (will reappear on <?php echo date('M j, Y', strtotime($week_start . ' +7 days')); ?>):</strong>
                    <ul class="mt-2 list-disc list-inside">
                        <?php foreach (array_keys($excludedIds) as $eid):
                            $sn = $studentsById[$eid] ?? null;
                            $display = $sn ? trim((($sn['first_name'] ?? '') . ' ' . ($sn['last_name'] ?? ''))) : $eid;
                            if ($display === '') $display = $eid;
                        ?>
                            <li><?php echo htmlspecialchars($display); ?> <span class="text-xs text-gray-600 dark:text-gray-300">(<?php echo htmlspecialchars($eid); ?>)</span></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
</div>
<?php
// flush output buffer
if (ob_get_level() > 0) ob_end_flush();
?>