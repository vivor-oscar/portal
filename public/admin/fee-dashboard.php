<?php

// Database connection
include '../../includes/database.php';

// Fetch classes with error handling
$classes_query = "SELECT class_name FROM class";
$classes_result = $conn->query($classes_query);
$classes = [];
if ($classes_result->num_rows > 0) {
    $classes = $classes_result->fetch_all(MYSQLI_ASSOC);
}

// Fetch fees structure with error handling
$fs_query = "SELECT * FROM fee_structures";
$fs_result = $conn->query($fs_query);
$feeStructures = [];
if ($fs_result->num_rows > 0) {
    $feeStructures = $fs_result->fetch_all(MYSQLI_ASSOC);
}

// Fetch students with error handling
$student_query = "SELECT * FROM students";
$student_result = $conn->query($student_query);
$students = [];
if ($student_result->num_rows > 0) {
    $students = $student_result->fetch_all(MYSQLI_ASSOC);
}




// Calculate outstanding fees
$outstandingFees_query = "SELECT s.student_id, s.first_name, s.last_name, s.class, 
                                fs.fee_id, fs.fee_type, fs.amount, fs.due_date
                         FROM students s
                         JOIN fee_structures fs ON s.class = fs.class_name
                         LEFT JOIN payments p ON s.student_id = p.student_id AND fs.fee_id = p.fee_id
                         WHERE p.payment_id IS NULL";
$outstandingFees_result = $conn->query($outstandingFees_query);
$outstandingFees = [];
if ($outstandingFees_result && $outstandingFees_result->num_rows > 0) {
    $outstandingFees = $outstandingFees_result->fetch_all(MYSQLI_ASSOC);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {


            case 'add_fee_structure':
                $className = $conn->real_escape_string($_POST['class_name']);
                $feeType = $conn->real_escape_string($_POST['fee_type']);
                $amount = (float)$_POST['amount'];
                $dueDate = $conn->real_escape_string($_POST['due_date']);
                $conn->query("INSERT INTO fee_structures (class_name, fee_type, amount, due_date) 
                             VALUES ('$className', '$feeType', $amount, '$dueDate')");
                $_SESSION['message'] = "Fee structure added successfully!";
                // log
                session_start();
                if (file_exists(__DIR__ . '/../../includes/logger.php')) {
                    require_once __DIR__ . '/../../includes/logger.php';
                    $user_id = $_SESSION['admin_id'] ?? '';
                    $username = $_SESSION['username'] ?? '';
                    log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'administrator', 'add_fee_structure', "class={$className};type={$feeType};amount={$amount}");
                }
                break;

            case 'save_fee':
                // Save feeding/transport service fee (from feeding_transport partial)
                $service = $conn->real_escape_string($_POST['service'] ?? 'feeding');
                $location = $conn->real_escape_string($_POST['location'] ?? '');
                $amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0.00;
                $stmt = $conn->prepare("INSERT INTO service_fees (service_name, location, amount) VALUES (?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param('ssd', $service, $location, $amount);
                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Service fee saved.';
                        // log
                        session_start();
                        if (file_exists(__DIR__ . '/../../includes/logger.php')) {
                            require_once __DIR__ . '/../../includes/logger.php';
                            $user_id = $_SESSION['admin_id'] ?? '';
                            $username = $_SESSION['username'] ?? '';
                            log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'administrator', 'save_service_fee', "service={$service};location={$location};amount={$amount}");
                        }
                    } else {
                        $_SESSION['message'] = 'Error saving service fee: ' . $stmt->error;
                    }
                } else {
                    $_SESSION['message'] = 'Prepare failed: ' . $conn->error;
                }
                break;

            case 'collect_fee':
            case 'collect_fee':
                // Validate required fields
                if (
                    isset($_POST['student_id'], $_POST['fee_id'], $_POST['amount_paid'], $_POST['payment_method']) &&
                    $_POST['student_id'] !== '' &&
                    $_POST['fee_id'] !== '' &&
                    $_POST['amount_paid'] !== '' &&
                    $_POST['payment_method'] !== ''
                ) {
                    $studentId = $conn->real_escape_string($_POST['student_id']);
                    $feeId = (int)$_POST['fee_id'];
                    $amountPaid = (float)$_POST['amount_paid'];
                    $paymentMethod = $conn->real_escape_string($_POST['payment_method']);
                    $receiptNumber = 'RCPT-' . time() . rand(100, 999);

                    $insert = $conn->query("INSERT INTO payments (student_id, fee_id, amount_paid, payment_method, receipt_number, payment_date) 
                        VALUES ('$studentId', $feeId, $amountPaid, '$paymentMethod', '$receiptNumber', NOW())");

                    if ($insert) {
                        $_SESSION['message'] = "Payment recorded successfully! Receipt #: $receiptNumber";
                        // log payment
                        session_start();
                        if (file_exists(__DIR__ . '/../../includes/logger.php')) {
                            require_once __DIR__ . '/../../includes/logger.php';
                            $user_id = $_SESSION['admin_id'] ?? '';
                            $username = $_SESSION['username'] ?? '';
                            log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'administrator', 'collect_fee', "student={$studentId};fee_id={$feeId};amount={$amountPaid};receipt={$receiptNumber}");
                        }
                    } else {
                        $_SESSION['message'] = "Error recording payment: " . $conn->error;
                    }
                } else {
                    $_SESSION['message'] = "Please fill in all required fields.";
                }
                break;

            case 'send_reminder':
                $studentId = (int)$_POST['student_id'];
                $feeId = (int)$_POST['fee_id'];
                $_SESSION['message'] = "Reminder sent successfully!";
                break;
        }
    }
    // Redirect to the same tab after form submission
    $redirectTab = isset($_GET['tab']) ? $_GET['tab'] : 'fee-structure';
    header("Location: " . $_SERVER['PHP_SELF'] . "?tab=" . urlencode($redirectTab));
    exit();
}

// Handle deletions
if (isset($_GET['delete'])) {
    $type = $_GET['delete'];
    $id = (int)$_GET['id'];
    switch ($type) {
        case 'fee_structure':
            $conn->query("DELETE FROM fee_structures WHERE fee_id = $id");
            $_SESSION['message'] = "Fee structure deleted successfully!";
            // log
            session_start();
            if (file_exists(__DIR__ . '/../../includes/logger.php')) {
                require_once __DIR__ . '/../../includes/logger.php';
                $user_id = $_SESSION['admin_id'] ?? '';
                $username = $_SESSION['username'] ?? '';
                log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'administrator', 'delete_fee_structure', "id={$id}");
            }
            break;
        case 'student':
            $conn->query("DELETE FROM students WHERE student_id = $id");
            $_SESSION['message'] = "Student deleted successfully!";
            // log
            session_start();
            if (file_exists(__DIR__ . '/../../includes/logger.php')) {
                require_once __DIR__ . '/../../includes/logger.php';
                $user_id = $_SESSION['admin_id'] ?? '';
                $username = $_SESSION['username'] ?? '';
                log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'administrator', 'delete_student', "id={$id}");
            }
            break;
        case 'payment':
            $conn->query("DELETE FROM payments WHERE payment_id = $id");
            $_SESSION['message'] = "Payment record deleted successfully!";
            // log
            session_start();
            if (file_exists(__DIR__ . '/../../includes/logger.php')) {
                require_once __DIR__ . '/../../includes/logger.php';
                $user_id = $_SESSION['admin_id'] ?? '';
                $username = $_SESSION['username'] ?? '';
                log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'administrator', 'delete_payment', "id={$id}");
            }
            break;
    }
    $redirectTab = isset($_GET['tab']) ? $_GET['tab'] : 'fee-structure';
    header("Location: " . $_SERVER['PHP_SELF'] . "?tab=" . urlencode($redirectTab));
    exit();
}




// Tab logic
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'fee-structure';
$tabs = [
    'fee-structure' => ['icon' => 'fa-calculator', 'label' => 'Fee Structure'],
    'fee-collection' => ['icon' => 'fa-money-bill-wave', 'label' => 'Fee Collection'],
    'feeding-transport' => ['icon' => 'fa-utensils', 'label' => 'Feeding & Transport'],
    'reminders' => ['icon' => 'fa-bell', 'label' => 'Due Fee Reminders'],
    'transactions' => ['icon' => 'fa-history', 'label' => 'Transaction History'],

];


// Prepare service fees view data (moved from feeding_transport partial)
$fees = [];
$fr = $conn->query("SELECT * FROM service_fees ORDER BY service_name, location");
if ($fr) $fees = $fr->fetch_all(MYSQLI_ASSOC);

// classes list (simple array of names) - reuse existing $classes var if present
$class_names = [];
if (!empty($classes)) {
    foreach ($classes as $c) {
        // $classes may be array of assoc rows with 'class_name' or simple strings
        if (is_array($c) && isset($c['class_name'])) $class_names[] = $c['class_name'];
        elseif (is_string($c)) $class_names[] = $c;
    }
}

// selected class filter
$selected_class = isset($_GET['class']) && $_GET['class'] !== '' ? $conn->real_escape_string($_GET['class']) : '';

// Compute expected totals per class and per student
$totals_per_class = [];
$totals_per_student = [];
foreach ($fees as $f) {
    $field = $conn->real_escape_string($f['student_location_field'] ?? 'curaddress');
    $loc = $conn->real_escape_string($f['location']);
    $amt = (float)$f['amount'];

    // totals per class for this fee
    $q = "SELECT s.class AS class_name, COUNT(*) AS students_count, SUM($amt) AS expected_total
          FROM students s WHERE COALESCE(s.`" . $field . "`, '') = '" . $loc . "'";
    $q .= " GROUP BY s.class";
    $rq = $conn->query($q);
    if ($rq) {
        while ($row = $rq->fetch_assoc()) {
            $key = $row['class_name'];
            if (!isset($totals_per_class[$key])) $totals_per_class[$key] = ['students_count' => 0, 'expected_total' => 0];
            $totals_per_class[$key]['students_count'] += (int)$row['students_count'];
            $totals_per_class[$key]['expected_total'] += (float)$row['expected_total'];
        }
    }

    // per-student expected amount
    // per-student expected amount - only compute when a class filter is selected
    if ($selected_class !== '') {
        $q2 = "SELECT s.student_id, s.first_name, s.last_name, IF(COALESCE(s.`" . $field . "`, '') = '" . $loc . "', $amt, 0) AS expected_amount, s.class
               FROM students s WHERE s.class='" . $selected_class . "'";
        $rq2 = $conn->query($q2);
        if ($rq2) {
            while ($row = $rq2->fetch_assoc()) {
                $sid = $row['student_id'];
                if (!isset($totals_per_student[$sid])) {
                    $totals_per_student[$sid] = $row;
                } else {
                    $totals_per_student[$sid]['expected_amount'] = (float)$totals_per_student[$sid]['expected_amount'] + (float)$row['expected_amount'];
                }
            }
        }
    }
}

// normalize into arrays for the view
$totals_per_class = array_map(function ($v) {
    return $v;
}, $totals_per_class);
$totals_per_student = array_values($totals_per_student);

// Fetch latest 'feeding' score for each student (when class filter is selected) and compute scored amount
$class_scored_totals = [];
if ($selected_class !== '' && !empty($totals_per_student)) {
    foreach ($totals_per_student as &$stu) {
        $sidRaw = $stu['student_id'];
        $sid = $conn->real_escape_string($sidRaw);
        $score = 0;
        $sres = $conn->query("SELECT score FROM weekly_service_scores WHERE student_id = '" . $sid . "' AND service_name = 'feeding' ORDER BY week_start DESC LIMIT 1");
        if ($sres && $srow = $sres->fetch_assoc()) {
            $score = (int)$srow['score'];
        }
        $stu['score'] = $score;
        $stu['scored_amount'] = (float)$stu['expected_amount'] * $score;
        $className = $stu['class'];
        if (!isset($class_scored_totals[$className])) $class_scored_totals[$className] = 0;
        $class_scored_totals[$className] += $stu['scored_amount'];
    }
    unset($stu);
}

// Compute received totals for today per class so admin can compare Received/Expected
$today_date = date('Y-m-d');
foreach ($totals_per_class as $cn => &$cv) {
    $esc = $conn->real_escape_string($cn);
    $r = $conn->query("SELECT IFNULL(SUM(amount_paid),0) AS s FROM service_payments sp JOIN students st ON sp.student_id=st.student_id WHERE st.class='" . $esc . "' AND DATE(sp.payment_date)='" . $today_date . "'");
    $cv['received_total'] = 0.00;
    if ($r && $rr = $r->fetch_assoc()) {
        $cv['received_total'] = (float)$rr['s'];
    }
}
unset($cv);

// Prepare recent payments for JS and partials (prevents undefined variable notices)
$payments = [];
$pr = $conn->query("SELECT p.*, s.first_name, s.last_name, fs.fee_type FROM payments p JOIN students s ON p.student_id = s.student_id LEFT JOIN fee_structures fs ON p.fee_id = fs.fee_id ORDER BY p.payment_date DESC");
if ($pr) $payments = $pr->fetch_all(MYSQLI_ASSOC);

// Expose $classes as simple names for the partial
$classes = $class_names;

include 'include/side-bar.php';
?>

<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 overflow-x-hidden">
    <main class="flex-1 ml-20 sm:ml-10 md:ml-48 lg:ml-64 pt-20 p-4 overflow-y-auto">
        <div class="container mx-auto px-2 sm:px-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-center mb-6 text-blue-800">Fees Management System</h1>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 dark:bg-green-900 dark:border-green-700 dark:text-green-200">
                    <?php echo $_SESSION['message'];
                    unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <!-- Responsive Tabs -->
                <div class="flex flex-col sm:flex-row border-b overflow-x-auto">
                    <?php foreach ($tabs as $tabId => $tabInfo): ?>
                        <a href="?tab=<?php echo $tabId; ?>"
                            class="tab-button py-3 px-4 sm:py-4 sm:px-6 font-medium text-sm sm:text-base whitespace-nowrap flex items-center <?php echo ($activeTab === $tabId) ? ' bg-blue-600 text-white' : ' text-gray-700 hover:bg-gray-100'; ?>">
                            <i class="fas <?php echo $tabInfo['icon']; ?> mr-2"></i><?php echo $tabInfo['label']; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <!-- Tab Contents -->
                <div class="p-2 sm:p-6 overflow-x-auto">
                    <?php if ($activeTab === 'fee-structure'): ?>
                        <div id="fee-structure" class="tab-content active w-full">
                            <div class="w-full overflow-x-auto">
                                <?php include 'fees/fee-structure.php'; ?>
                            </div>
                        </div>
                    <?php elseif ($activeTab === 'feeding-transport'): ?>
                        <div id="feeding-transport" class="tab-content active w-full">
                            <div class="w-full overflow-x-auto">
                                <?php include 'fees/feeding.php'; ?>
                            </div>
                        </div>
                    <?php elseif ($activeTab === 'fee-collection'): ?>
                        <div id="fee-collection" class="tab-content active w-full">
                            <div class="w-full overflow-x-auto">
                                <?php include 'fees/fee-collection.php'; ?>
                            </div>
                        </div>
                    <?php elseif ($activeTab === 'reminders'): ?>
                        <div id="reminders" class="tab-content active w-full">
                            <div class="w-full overflow-x-auto">
                                <?php include 'fees/fee-reminder.php'; ?>
                            </div>
                        </div>
                    <?php elseif ($activeTab === 'transactions'): ?>
                        <div id="transactions" class="tab-content active w-full">
                            <div class="w-full overflow-x-auto">
                                <?php include 'fees/transaction-history.php'; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="tab-content active w-full">
                            <h2 class="text-xl sm:text-2xl font-bold mb-4">Welcome to the Fees Management System</h2>
                            <p class="text-gray-600">Please select a tab to manage fees, view transactions, or manage data.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Receipt Modal -->
            <div id="receiptModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
                <div class="flex items-center justify-center min-h-screen p-2 sm:p-4 text-center">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 dark:text-gray-100 rounded-lg text-left overflow-hidden shadow-xl transform transition-all w-full max-w-md sm:my-8 sm:align-middle">
                        <div class="bg-white dark:bg-gray-800 px-2 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div id="receiptContent" class="p-2 sm:p-4 overflow-x-auto">
                                <!-- Receipt content will be loaded here -->
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 px-2 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" onclick="printReceiptContent()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
                                <i class="fas fa-print mr-2"></i>Print Receipt
                            </button>
                            <button type="button" onclick="hideModal('receiptModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600 text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
    <script>
        // Make openTab globally available
        window.openTab = function(tabId, event) {
            if (event) event.preventDefault();

            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Deactivate all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });

            // Show the selected tab content
            document.getElementById(tabId).classList.add('active');

            // Activate the clicked button
            if (event) {
                event.currentTarget.classList.add('active');
            }
        };

        // Initialize active tab as per PHP variable on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Get active tab from PHP
            const activeTab = "<?php echo $activeTab; ?>";

            // Activate the correct tab button
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
                if (button.getAttribute('href').includes(activeTab)) {
                    button.classList.add('active');
                }
            });

            // Show the correct tab content
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
                if (tab.id === activeTab) {
                    tab.classList.add('active');
                }
            });
        });

        // Modal functionality
        function showModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hideModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Update fee options based on selected student
        function updateFeeOptions(studentId) {
            if (!studentId) {
                document.getElementById('fee-options').innerHTML = '<option value="">Select Fee</option>';
                return;
            }

            // In a real application, you would fetch this data via AJAX
            // For this demo, we'll use the PHP data passed to JavaScript
            const students = <?php echo json_encode($students); ?>;
            const feeStructures = <?php echo json_encode($feeStructures); ?>;
            const outstandingFees = <?php echo json_encode($outstandingFees); ?>;

            const student = students.find(s => s.student_id == studentId);
            if (!student) return;

            const studentClass = student.class_name;
            const feesForClass = feeStructures.filter(fee => fee.class_name == studentClass);

            let options = '<option value="">Select Fee</option>';

            feesForClass.forEach(fee => {
                // Check if this fee is outstanding for the student
                const isOutstanding = outstandingFees.some(of =>
                    of.student_id == studentId && of.fee_id == fee.fee_id
                );

                if (isOutstanding) {
                    options += `<option value="${fee.fee_id}">${fee.fee_type} (Due: ${fee.due_date})</option>`;
                }
            });

            document.getElementById('fee-options').innerHTML = options;
        }

        // Print receipt
        function printReceipt(receiptNumber) {
            // In a real application, you would fetch the receipt data via AJAX
            // For this demo, we'll use the PHP data passed to JavaScript
            const payments = <?php echo json_encode($payments); ?>;
            const payment = payments.find(p => p.receipt_number == receiptNumber);

            if (payment) {
                const receiptContent = `
                    <div class="text-center mb-4">
                        <h2 class="text-xl sm:text-2xl font-bold">School Fees Receipt</h2>
                        <p class="text-gray-600 text-sm">${payment.receipt_number}</p>
                    </div>
                    
                    <div class="mb-4">
                        <div class="grid grid-cols-2 gap-2 sm:gap-4 mb-2">
                            <div>
                                <p class="font-semibold text-sm sm:text-base">Date:</p>
                                <p class="text-sm">${payment.payment_date}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-sm sm:text-base">Payment Method:</p>
                                <p class="text-sm">${payment.payment_method}</p>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <p class="font-semibold text-sm sm:text-base">Student:</p>
                            <p class="text-sm">${payment.first_name} ${payment.last_name}</p>
                            
                        </div>
                        
                        <div class="border-t border-b border-gray-200 py-3">
                            <p class="font-semibold text-sm sm:text-base">Fee Details:</p>
                            <p class="text-sm">${payment.fee_type}</p>
                        </div>
                        
                        <div class="mt-3 text-right">
                            <p class="font-semibold text-sm sm:text-base">Amount Paid:</p>
                            <p class="text-xl sm:text-2xl">GHS ${parseFloat(payment.amount_paid).toFixed(2)}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-3 border-t border-gray-200 text-center text-xs sm:text-sm text-gray-500">
                        <p>Thank you for your payment!</p>
                        <p>Generated on ${new Date().toLocaleString()}</p>
                    </div>
                `;

                document.getElementById('receiptContent').innerHTML = receiptContent;
                showModal('receiptModal');
            }
        }

        function printReceiptContent() {
            const printContent = document.getElementById('receiptContent').innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = `
                <div class="p-4 max-w-md mx-auto">
                    ${printContent}
                </div>
                <script>
                    setTimeout(() => {
                        window.print();
                        document.body.innerHTML = \`${originalContent}\`;
                        window.location.reload();
                    }, 500);
                <\/script>
            `;
        }
    </script>
    <?php include 'include/modals.php'; ?>