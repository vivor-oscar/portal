<?php
session_start();

// Simple, self-contained clean rebuild of the Mark Payment page for staff.
// - Uses prepared statements
// - Fetches staff -> staff_id -> assigned class via staff_classes
// - Loads students for that class and service_fees
// - Matches students to each service by the service's student_location_field (case-insensitive)
// - Shows per-service checkbox lists with "select all" and bulk mark handler
// - Shows debug summary to help troubleshooting

// Adjust include path as needed (this workspace uses ../../includes/database.php)
include '../../includes/database.php';

// Allow a debug bypass when ?debug=1 is supplied so we can inspect why nothing shows
$bypass_debug = (isset($_GET['debug']) && $_GET['debug'] === '1');

// Basic role check (allow bypass for debug)
if (!isset($_SESSION['username']) || ($_SESSION['role'] ?? '') !== 'staff') {
  if ($bypass_debug) {
    // continue for debugging; session values may be null
  } else {
    header('Location: ../../index.php');
    exit;
  }
}

$debug = [];
$username = $_SESSION['username'] ?? null;
$debug['session_username'] = $username;
if ($bypass_debug) $debug['bypass_role'] = true;

// Resolve staff_id
$staff_id = null;
$stmt = $conn->prepare("SELECT staff_id FROM staff WHERE username = ? LIMIT 1");
if ($stmt) {
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($sid);
    if ($stmt->fetch()) $staff_id = $sid;
    $stmt->close();
}
$debug['staff_id'] = $staff_id;

// Resolve assigned class via staff_classes -> class
$staff_class = null;
if ($staff_id) {
    $stmt = $conn->prepare("SELECT sc.class_name FROM staff_classes sc WHERE sc.staff_id = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param('s', $staff_id);
        $stmt->execute();
        $stmt->bind_result($cname);
        if ($stmt->fetch()) $staff_class = $cname;
        $stmt->close();
    }
}
$debug['staff_class'] = $staff_class;

// Load students in that class (attendance.php style)
$students = [];
$debug['class_candidates_tried'] = [];
$matched_candidate = null;

// If staff_class not set from staff_classes, try to fall back to the staff table's class column
if (empty($staff_class) && $staff_id) {
  $sst = $conn->prepare("SELECT class FROM staff WHERE staff_id = ? LIMIT 1");
  if ($sst) {
    $sst->bind_param('s', $staff_id);
    $sst->execute();
    $sst->bind_result($scfromstaff);
    if ($sst->fetch()) $staff_class = $scfromstaff;
    $sst->close();
  }
}

// Build candidate class names to try (exact, and common variants)
if ($staff_class) {
  $staff_class = trim((string)$staff_class);
  $cands = [$staff_class];
  // Common variants: Class <-> Basic
  if (stripos($staff_class, 'Class') !== false) {
    $cands[] = str_ireplace('Class', 'Basic', $staff_class);
  }
  if (stripos($staff_class, 'Basic') !== false) {
    $cands[] = str_ireplace('Basic', 'Class', $staff_class);
  }
  // whitespace-normalized
  $cands[] = preg_replace('/\s+/', ' ', $staff_class);
  // unique and preserve order
  $seen = [];
  $candidates = [];
  foreach ($cands as $x) {
    $y = trim($x);
    if ($y === '' || isset($seen[mb_strtolower($y)])) continue;
    $seen[mb_strtolower($y)] = true;
    $candidates[] = $y;
  }
  $debug['class_candidates_tried'] = $candidates;

  // Try each candidate until we find students
  foreach ($candidates as $cand) {
    $stmt = $conn->prepare("SELECT student_id, first_name, last_name, curaddress, class FROM students WHERE class = ? LIMIT 1000");
    if ($stmt) {
      $stmt->bind_param('s', $cand);
      $stmt->execute();
      $res = $stmt->get_result();
      $tmp = [];
      while ($r = $res->fetch_assoc()) $tmp[] = $r;
      $stmt->close();
      if (!empty($tmp)) {
        $students = $tmp;
        $matched_candidate = $cand;
        break;
      }
    } else {
      $debug['student_query_prepare_error'] = $conn->error;
    }
  }
}

$debug['matched_class_candidate'] = $matched_candidate;
$debug['students_count'] = count($students);

// Extra debug diagnostics when bypassing role (help find class mismatches)
if ($bypass_debug) {
  // Show distinct class values present in students table
  $classes = [];
  $cres = $conn->query("SELECT DISTINCT(class) AS class FROM students ORDER BY class LIMIT 200");
  if ($cres) {
    while ($row = $cres->fetch_assoc()) $classes[] = $row['class'];
  }
  $debug['distinct_student_classes_sample'] = $classes;

  // Show up to 5 sample students that match using exact equality
  $sample_exact = [];
  if ($staff_class) {
    $sstmt = $conn->prepare("SELECT student_id, first_name, last_name, class, curaddress FROM students WHERE class = ? LIMIT 5");
    if ($sstmt) {
      $sstmt->bind_param('s', $staff_class);
      $sstmt->execute();
      $res = $sstmt->get_result();
      while ($r = $res->fetch_assoc()) $sample_exact[] = $r;
      $sstmt->close();
    } else {
      $debug['students_exact_prepare_error'] = $conn->error;
    }
  }
  $debug['sample_students_exact_match'] = $sample_exact;

  // Case-insensitive / trimmed count using SQL LOWER/TRIM
  $ci_count = null;
  if ($staff_class) {
    $q = $conn->prepare("SELECT COUNT(*) FROM students WHERE LOWER(TRIM(class)) = LOWER(TRIM(?))");
    if ($q) {
      $q->bind_param('s', $staff_class);
      $q->execute();
      $q->bind_result($ci_count);
      $q->fetch();
      $q->close();
    } else {
      $debug['students_ci_prepare_error'] = $conn->error;
    }
  }
  $debug['ci_class_count'] = $ci_count;
}

// Load services
$services = [];
$sr = $conn->query("SELECT * FROM service_fees ORDER BY service_name, location");
if ($sr) {
    while ($row = $sr->fetch_assoc()) $services[] = $row;
}
$debug['services_count'] = count($services);

// Popular locations quick-filter (user-requested list)
$popular_locations = [
  'Akwatia','Kade','Nkwatanang','Boadua','Bamenase','Apinamang','Topremang','Cayco'
];

// Collect selected locations from GET for the UI (array of strings)
$selected_locations = [];
if (!empty($_GET['locations']) && is_array($_GET['locations'])) {
    foreach ($_GET['locations'] as $l) {
        $l = trim((string)$l);
        if ($l !== '') $selected_locations[] = $l;
    }
}

// Helper: case-insensitive equals (trimmed)
// Normalize strings: lowercase, remove non-alphanumeric characters
function normalize_for_match($s) {
  $s = mb_strtolower(trim((string)$s));
  // replace non-alphanumeric with empty
  $s = preg_replace('/[^a-z0-9]+/u', '', $s);
  return $s;
}

// Match location: normalized equality or substring (so "Akwatia" matches "Akwatia Central" etc.)
function match_location($studentVal, $loc) {
  $a = normalize_for_match($studentVal);
  $b = normalize_for_match($loc);
  if ($a === '' || $b === '') return false;
  if ($a === $b) return true;
  if (mb_strpos($a, $b) !== false) return true;
  if (mb_strpos($b, $a) !== false) return true;
  return false;
}

// POST handler: bulk mark selected
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mark_selected') {
    // Basic validation
    $service_fee_id = isset($_POST['service_fee_id']) ? (int)$_POST['service_fee_id'] : 0;
    $student_ids = $_POST['student_ids'] ?? [];
    $amount_paid = isset($_POST['amount_paid']) ? floatval($_POST['amount_paid']) : 0.00;
    $manual_service_name = isset($_POST['service_name']) ? trim($_POST['service_name']) : null;

    if (empty($student_ids)) {
        $_SESSION['message'] = 'No students selected.';
        header('Location: ' . $_SERVER['REQUEST_URI']); exit;
    }

    $today = date('Y-m-d');
    $receiptBase = 'RCPT-' . time();
    $success = 0; $skipped = 0; $errors = 0;

    // Prepare insert statement for payments
    $pstmt = $conn->prepare("INSERT INTO service_payments (student_id, service_fee_id, amount_paid, staff_id, receipt_number, payment_date) VALUES (?, ?, ?, ?, ?, NOW())");
    $wstmt = $conn->prepare("INSERT INTO weekly_service_scores (student_id, week_start, service_name, score) VALUES (?, ?, ?, 1) ON DUPLICATE KEY UPDATE score = LEAST(7, score + 1)");

    foreach ($student_ids as $s) {
        $sid = $s;
        // duplicate check
        $chk = $conn->prepare("SELECT COUNT(*) FROM service_payments WHERE student_id = ? AND service_fee_id = ? AND DATE(payment_date) = ?");
        if (!$chk) { $errors++; continue; }
        $chk->bind_param('sis', $sid, $service_fee_id, $today);
        $chk->execute();
        $chk->bind_result($cnt); $chk->fetch(); $chk->close();
        if ($cnt > 0) { $skipped++; continue; }

        $receipt = $receiptBase . rand(100,999);
        $staff_ident = $staff_id ?? $username; // use staff_id if available else username
        $amount_safe = number_format((float)$amount_paid, 2, '.', '');

        if ($pstmt) {
            $pstmt->bind_param('iisss', $sid, $service_fee_id, $amount_safe, $staff_ident, $receipt);
            // Above binding types: i (student_id?) but student_id is varchar in your schema — switch to s
            // To be safe we'll re-bind with strings
            $pstmt->bind_param('sssss', $sid, (string)$service_fee_id, (string)$amount_safe, (string)$staff_ident, $receipt);
            $ok = $pstmt->execute();
            if (!$ok) { $errors++; continue; }
        } else {
            $errors++; continue;
        }

        // determine service name
        if ($service_fee_id === 0 && $manual_service_name) {
            $sname = $manual_service_name;
        } else {
            $sr2 = $conn->prepare("SELECT service_name FROM service_fees WHERE service_fee_id = ? LIMIT 1");
            if ($sr2) { $sr2->bind_param('i', $service_fee_id); $sr2->execute(); $sr2->bind_result($sname); $sr2->fetch(); $sr2->close(); }
            $sname = $sname ?? 'service';
        }

        // weekly upsert
        $week_start = date('Y-m-d', strtotime('monday this week', strtotime($today)));
        if ($wstmt) { $wstmt->bind_param('sss', $sid, $week_start, $sname); $wstmt->execute(); }

        $success++;
    }

    if ($pstmt) $pstmt->close();
    if ($wstmt) $wstmt->close();

    $_SESSION['message'] = "Bulk done: $success recorded, $skipped skipped, $errors errors.";
    header('Location: ' . $_SERVER['REQUEST_URI']); exit;
}

// Build per-service matching arrays (case-insensitive)
$service_matches = [];
foreach ($services as $sv) {
    $field = $sv['student_location_field'] ?? 'curaddress';
    $loc = trim((string)$sv['location']);
    $matches = [];
  foreach ($students as $st) {
    $val = trim((string)($st[$field] ?? ''));
    $cur = trim((string)($st['curaddress'] ?? ''));
    // Primary check: the configured field OR curaddress (many students have location in curaddress)
    if (($val !== '' && match_location($val, $loc)) || ($cur !== '' && match_location($cur, $loc))) {
      $matches[] = $st;
    }
  }
    // fallback
    if (empty($matches)) {
    foreach ($students as $st) {
      if (match_location($st['curaddress'] ?? '', $loc) || match_location($st['curaddress'] ?? '', $loc) || match_location($st['class'] ?? '', $loc) || match_location($st['student_id'] ?? '', $loc)) {
        $matches[] = $st;
      }
    }
    }
    if (!empty($matches)) $service_matches[$sv['service_fee_id']] = ['service'=>$sv, 'students'=>$matches];
}

// Render simple HTML
?><!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Mark Payments (clean)</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>body{font-family:Arial,Helvetica,sans-serif;margin:16px}table{border-collapse:collapse;width:100%}td,th{border:1px solid #ddd;padding:6px}</style>
  <script>
    function toggleAll(cb, name) {
      document.querySelectorAll('input[name="'+name+'[]"]').forEach(i=>i.checked=cb.checked);
    }
  </script>
</head>
<body>
<h2>Mark Feeding/Transport Payment - Clean Page</h2>
<p><strong>Staff:</strong> <?php echo htmlspecialchars($username); ?> &nbsp; <strong>Class:</strong> <?php echo htmlspecialchars($staff_class ?? 'N/A'); ?></p>

<?php if (isset($_SESSION['message'])) { echo '<div style="background:#e0ffd8;padding:8px;margin-bottom:8px">'.htmlspecialchars($_SESSION['message']).'</div>'; unset($_SESSION['message']); } ?>

<h3>Debug</h3>
<pre><?php echo htmlspecialchars(json_encode($debug, JSON_PRETTY_PRINT)); ?></pre>

<section style="border:1px solid #ddd;padding:8px;margin:12px 0">
  <h3>Quick filter: popular locations</h3>
  <form method="get">
    <?php foreach ($popular_locations as $loc): ?>
      <label style="margin-right:8px"><input type="checkbox" name="locations[]" value="<?php echo htmlspecialchars($loc); ?>" <?php echo in_array($loc, $selected_locations) ? 'checked' : ''; ?>> <?php echo htmlspecialchars($loc); ?></label>
    <?php endforeach; ?>
    <button type="submit">Filter</button>
  </form>

  <?php if (!empty($selected_locations)): ?>
    <?php
      // Find students whose curaddress or cityname matches any selected location
      $loc_matches = [];
      $placeholders = array_map(function($x){return '?';}, $selected_locations);
      // We'll do server-side in PHP using existing $students (staff class scope)
      foreach ($students as $st) {
        $saddr = $st['curaddress'] ?? '';
        $scity = $st['cityname'] ?? '';
        foreach ($selected_locations as $sl) {
          if (match_location($saddr, $sl) || match_location($scity, $sl)) {
            $loc_matches[$st['student_id']] = $st;
            break;
          }
        }
      }

      // For each matched student compute expected total: sum of amounts from service_fees that match their location
      $student_expected = [];
      foreach ($loc_matches as $sid => $st) {
        $sum = 0.0;
        foreach ($services as $svc) {
          $field = $svc['student_location_field'] ?? 'curaddress';
          $svc_loc = trim((string)$svc['location']);
          $studentVal = $st[$field] ?? ($st['curaddress'] ?? '');
          if (match_location($studentVal, $svc_loc) || match_location($st['curaddress'] ?? '', $svc_loc) || match_location($st['cityname'] ?? '', $svc_loc)) {
            $sum += floatval($svc['amount']);
          }
        }
        $student_expected[$sid] = $sum;
      }
    ?>

    <h4>Results: <?php echo count($loc_matches); ?> students matched</h4>
    <table style="width:100%"><thead><tr><th>Student</th><th>Class</th><th>Location</th><th>Expected total</th></tr></thead><tbody>
      <?php foreach ($loc_matches as $st): $sid = $st['student_id']; ?>
        <tr>
          <td><?php echo htmlspecialchars($st['first_name'].' '.$st['last_name'].' ('.$sid.')'); ?></td>
          <td><?php echo htmlspecialchars($st['class'] ?? ''); ?></td>
          <td><?php echo htmlspecialchars(($st['cityname'] ?? '').', '.($st['curaddress'] ?? '')); ?></td>
          <td><?php echo number_format($student_expected[$sid] ?? 0, 2); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody></table>
  <?php endif; ?>
</section>

<?php if (empty($service_matches) && empty($services)): ?>
  <div style="background:#fff3cd;padding:8px">No service fees defined. Admin should add service_fees rows.</div>
<?php endif; ?>

<?php foreach ($service_matches as $sfid => $block): $svc = $block['service']; $slist = $block['students']; ?>
  <section style="border:1px solid #ccc;padding:8px;margin-bottom:12px">
    <h4><?php echo htmlspecialchars($svc['service_name'].' - '.$svc['location'].' ('.number_format($svc['amount'],2).')'); ?></h4>
    <form method="post">
      <input type="hidden" name="action" value="mark_selected">
      <input type="hidden" name="service_fee_id" value="<?php echo (int)$sfid; ?>">
      <label><input type="checkbox" onchange="toggleAll(this,'student_ids')"> Select/Deselect all</label>
      <table>
        <thead><tr><th>Select</th><th>Student</th><th>Location</th></tr></thead>
        <tbody>
        <?php foreach ($slist as $s): ?>
          <tr>
            <td><input type="checkbox" name="student_ids[]" value="<?php echo htmlspecialchars($s['student_id']); ?>"></td>
            <td><?php echo htmlspecialchars($s['first_name'].' '.$s['last_name'].' ('.$s['student_id'].')'); ?></td>
            <td><?php echo htmlspecialchars(($s['curaddress'] ?? '')); ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <div style="margin-top:8px">
        Amount (per student): <input type="number" step="0.01" name="amount_paid" value="<?php echo htmlspecialchars($svc['amount']); ?>"> 
        <button type="submit">Mark Selected Paid</button>
      </div>
    </form>
  </section>
<?php endforeach; ?>

<?php if (empty($service_matches) && !empty($students)): // fallback show all students ?>
  <section style="border:1px solid #ccc;padding:8px;margin-bottom:12px">
    <h4>All students in <?php echo htmlspecialchars($staff_class); ?></h4>
    <form method="post">
      <input type="hidden" name="action" value="mark_selected">
      <input type="hidden" name="service_fee_id" value="0">
      <label>Service name: <select name="service_name"><option value="feeding">feeding</option><option value="transport">transport</option></select></label>
      <label><input type="checkbox" onchange="toggleAll(this,'student_ids')"> Select/Deselect all</label>
      <table>
        <thead><tr><th>Select</th><th>Student</th><th>Location</th></tr></thead>
        <tbody>
        <?php foreach ($students as $s): ?>
          <tr>
            <td><input type="checkbox" name="student_ids[]" value="<?php echo htmlspecialchars($s['student_id']); ?>"></td>
            <td><?php echo htmlspecialchars($s['first_name'].' '.$s['last_name'].' ('.$s['student_id'].')'); ?></td>
            <td><?php echo htmlspecialchars(($s['cityname'] ?? '').', '.($s['curaddress'] ?? '')); ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <div style="margin-top:8px">Amount (per student): <input type="number" step="0.01" name="amount_paid" value="0.00"> <button type="submit">Mark Selected Paid</button></div>
    </form>
  </section>
<?php endif; ?>

<h3>Weekly Scores (this week)</h3>
<?php
$week_start = date('Y-m-d', strtotime('monday this week'));
$stmt = $conn->prepare("SELECT w.student_id, w.service_name, w.score, s.first_name, s.last_name FROM weekly_service_scores w JOIN students s ON w.student_id = s.student_id WHERE w.week_start = ? AND s.class = ?");
if ($stmt) {
    $stmt->bind_param('ss', $week_start, $staff_class);
    $stmt->execute();
    $res = $stmt->get_result();
    echo '<table><thead><tr><th>Student</th><th>Service</th><th>Score</th></tr></thead><tbody>';
    while ($r = $res->fetch_assoc()) {
        echo '<tr><td>'.htmlspecialchars($r['first_name'].' '.$r['last_name'].' ('.$r['student_id'].')').'</td><td>'.htmlspecialchars($r['service_name']).'</td><td>'.(int)$r['score'].'</td></tr>';
    }
    echo '</tbody></table>';
    $stmt->close();
}
?>

</body>
</html>
