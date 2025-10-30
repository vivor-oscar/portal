<?php
require_once('include/side-bar.php');

// Include database connection
include('../../includes/database.php');
function getUserCountSummary($conn)
{
    $sql = "
        SELECT 'STUDENTS' AS user_type, COUNT(*) AS total_users FROM students
        UNION
        SELECT 'STAFFS', COUNT(*) FROM staff
        UNION
        SELECT 'TOTAL', 
            (SELECT COUNT(*) FROM students) + (SELECT COUNT(*) FROM staff)
    ";
    $result = mysqli_query($conn, $sql);

    $summary = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $summary[$row['user_type']] = $row['total_users'];
    }
    return $summary;
}
function getTotalStaffs($conn)
{
    $sql = "SELECT COUNT(*) AS total_staffs FROM staff";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_staffs'];
}

function getTotalStudents($conn)
{
    $sql = "SELECT COUNT(*) AS total_students FROM students";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_students'];
}

$totalStaffs = getTotalStaffs($conn);
$totalStudents = getTotalStudents($conn);
$userSummary = getUserCountSummary($conn);

// Calculate total expected revenue (sum of all fees assigned to all students)
$totalExpectedQuery = "
    SELECT SUM(fs.amount) AS total_expected
    FROM students s
    JOIN fee_structures fs ON s.class = fs.class_name
";
$totalExpectedResult = $conn->query($totalExpectedQuery);
$totalExpected = $totalExpectedResult ? $totalExpectedResult->fetch_assoc()['total_expected'] : 0;

// Calculate total collected revenue (sum of all payments)
$totalCollectedQuery = "SELECT SUM(amount_paid) AS total_collected FROM payments";
$totalCollectedResult = $conn->query($totalCollectedQuery);
$totalCollected = $totalCollectedResult ? $totalCollectedResult->fetch_assoc()['total_collected'] : 0;

$toBePaid = $totalExpected - $totalCollected;
// Calculate total expenses (sum of all expenses)
$totalExpensesQuery = "SELECT SUM(amount) AS total_expenses FROM expenses";
$totalExpensesResult = $conn->query($totalExpensesQuery);
$totalExpenses = $totalExpensesResult ? $totalExpensesResult->fetch_assoc()['total_expenses'] : 0;

// Analysis
$profitOrLoss = $totalCollected - $totalExpenses;
$analysisText = $profitOrLoss >= 0 ? "Profit" : "Loss";

// Handle reset button
if (isset($_POST['reset_financials'])) {
    // Log the reset action
    if (file_exists(__DIR__ . '/../../includes/logger.php')) {
        require_once __DIR__ . '/../../includes/logger.php';
        session_start();
        $user_id = $_SESSION['admin_id'] ?? '';
        $username = $_SESSION['username'] ?? '';
        log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'administrator', 'reset_financials', 'Cleared payments and expenses');
    }
    $conn->query("DELETE FROM payments");
    $conn->query("DELETE FROM expenses");
    $_SESSION['message'] = "Financial records have been reset!";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Main container -->
<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            
            <div class="flex items-center gap-4">
                <?php
                $result = $conn->query("SELECT * FROM school_details LIMIT 1");
                $school_details = $result->fetch_assoc();
                if ($school_details) {
                    echo "<div class='flex items-center gap-4'>";
                    echo "<h1 class='text-3xl font-bold text-gray-800 dark:text-white'>" . $school_details['school_name'] . "</h1>";
                    echo "<a href='system-report.php' class='ml-4 inline-flex items-center gap-2 px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm'><i class='fas fa-file-alt'></i> System Report</a>";
                    echo "</div>";
                }
                ?>
            </div>
            <div class="bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 px-4 py-2 rounded-lg">
                <p class="text-blue-800 dark:text-blue-200 font-medium">Academic Year: <?php echo $school_details['academic_year'] ?? '2024/2025'; ?></p>
            </div>
        </div>

        <!-- Stats Cards -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Students Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border-0 p-6 transition-all hover:shadow-lg hover:-translate-y-1 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 rounded-full -m-4 opacity-10 bg-blue-500"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Students</h2>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400"><?php echo $totalStudents; ?></p>
                    </div>
                    <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total enrolled students</p>
                </div>
            </div>

            <!-- Staff Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border-0 p-6 transition-all hover:shadow-lg hover:-translate-y-1 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 rounded-full -m-4 opacity-10 bg-green-500"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Staff</h2>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400"><?php echo $totalStaffs; ?></p>
                    </div>
                    <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Teaching and administrative staff</p>
                </div>
            </div>

            <!-- Total Users Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border-0 p-6 transition-all hover:shadow-lg hover:-translate-y-1 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 rounded-full -m-4 opacity-10 bg-purple-500"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Users</h2>
                        <p class="text-3xl font-bold text-purple-600 dark:text-purple-400"><?php echo $userSummary['TOTAL']; ?></p>
                    </div>
                    <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400">All system users combined</p>
                </div>
            </div>

            <!-- Financial Overview Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border-0 p-6 transition-all hover:shadow-lg hover:-translate-y-1 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 rounded-full -m-4 opacity-10 bg-indigo-500"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Revenue</h2>
                        <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">GHS <?php echo number_format($totalCollected, 0); ?></p>
                    </div>
                    <div class="bg-indigo-100 dark:bg-indigo-900/30 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Collected out of GHS <?php echo number_format($totalExpected, 0); ?></p>
                </div>
            </div>
        </section>

        <!-- Chart Section -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- User Distribution Chart -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md border-0">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">User Distribution</h2>
                    <span class="text-xs bg-blue-100 text-blue-800 py-1 px-2 rounded-full">Updated today</span>
                </div>
                <canvas id="userChart" class="w-full"></canvas>
            </div>
            
            <!-- Financial Details Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border-0 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Financial Overview</h2>
                    <span class="text-xs bg-indigo-100 text-indigo-800 py-1 px-2 rounded-full">Current</span>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="flex items-center">
                            <div class="bg-blue-100 dark:bg-blue-800 p-2 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <span class="text-gray-600 dark:text-gray-300">Expected Revenue</span>
                        </div>
                        <span class="font-semibold text-blue-600 dark:text-blue-400">GHS <?php echo number_format($totalExpected, 2); ?></span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div class="flex items-center">
                            <div class="bg-green-100 dark:bg-green-800 p-2 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-gray-600 dark:text-gray-300">Collected</span>
                        </div>
                        <span class="font-semibold text-green-600 dark:text-green-400">GHS <?php echo number_format($totalCollected, 2); ?></span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                        <div class="flex items-center">
                            <div class="bg-red-100 dark:bg-red-800 p-2 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-gray-600 dark:text-gray-300">To Be Paid</span>
                        </div>
                        <span class="font-semibold text-red-600 dark:text-red-400">GHS <?php echo number_format($toBePaid, 2); ?></span>
                    </div>
                    
                
                </div>

                <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Financial Status</p>
                        <p class="text-lg font-bold <?php echo $profitOrLoss >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'; ?>">
                            <?php echo $analysisText; ?> (GHS <?php echo number_format(abs($profitOrLoss), 2); ?>)
                        </p>
                    </div>

                    <form method="POST" onsubmit="return confirm('Are you sure you want to reset all financial records? This cannot be undone.');">
                        <button type="submit" name="reset_financials" class="bg-red-600 text-white text-sm px-3 py-2 rounded-lg hover:bg-red-700 transition-colors shadow-md flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset Financials
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Additional Stats Section -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Quick Stats -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md border-0">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Quick Stats</h2>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Student to Staff Ratio</p>
                            <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 py-1 px-2 rounded-full">Balance</span>
                        </div>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                            <?php echo round($totalStudents / max($totalStaffs, 1), 1); ?>:1
                        </p>
                    </div>
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Enrollment Capacity</p>
                            <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 py-1 px-2 rounded-full">Capacity</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">
                                <?php echo $school_details['enrollment_capacity'] ?? 'N/A'; ?>
                            </p>
                            <?php if (isset($school_details['enrollment_capacity'])): ?>
                                <?php
                                $capacity = $school_details['enrollment_capacity'];
                                $percentage = min(round(($totalStudents / $capacity) * 100), 100);
                                $color = $percentage > 90 ? 'bg-red-500' : ($percentage > 75 ? 'bg-yellow-500' : 'bg-green-500');
                                ?>
                                <div class="flex-1">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                        <div class="h-2.5 rounded-full <?php echo $color; ?>" style="width: <?php echo $percentage; ?>%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?php echo $percentage; ?>% filled</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- School Details Summary -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md border-0">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">School Information</h2>
                <div class="space-y-4">
                    <?php
                    $result = $conn->query("SELECT * FROM school_details LIMIT 1");
                    if ($result && $row = $result->fetch_assoc()) {
                        echo '<div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">';
                        echo '<div class="bg-blue-100 dark:bg-blue-800 p-2 rounded-lg mr-3">';
                        echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">';
                        echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />';
                        echo '</svg>';
                        echo '</div>';
                        echo '<div>';
                        echo '<p class="text-sm text-gray-500 dark:text-gray-400">School Name</p>';
                        echo '<p class="font-medium text-gray-800 dark:text-white">' . $row['school_name'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        
                        echo '<div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">';
                        echo '<div class="bg-green-100 dark:bg-green-800 p-2 rounded-lg mr-3">';
                        echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">';
                        echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />';
                        echo '</svg>';
                        echo '</div>';
                        echo '<div>';
                        echo '<p class="text-sm text-gray-500 dark:text-gray-400">Institution Type</p>';
                        echo '<p class="font-medium text-gray-800 dark:text-white">' . ($row['type_of_institution'] ?? 'N/A') . '</p>';
                        echo '</div>';
                        echo '</div>';
                        
                        echo '<div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">';
                        echo '<div class="bg-purple-100 dark:bg-purple-800 p-2 rounded-lg mr-3">';
                        echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">';
                        echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />';
                        echo '</svg>';
                        echo '</div>';
                        echo '<div>';
                        echo '<p class="text-sm text-gray-500 dark:text-gray-400">Address</p>';
                        echo '<p class="font-medium text-gray-800 dark:text-white">' . ($row['address'] ?? 'N/A') . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
    const ctx = document.getElementById('userChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Students', 'Staff'],
            datasets: [{
                label: 'User Distribution',
                data: [<?php echo $totalStudents; ?>, <?php echo $totalStaffs; ?>],
                backgroundColor: ['#3b82f6', '#10b981'],
                borderColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#1f2937' : '#ffffff',
                borderWidth: 3,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#d1d5db' : '#374151',
                        font: {
                            size: 14,
                            weight: '500'
                        },
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#1f2937' : '#ffffff',
                    titleColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#d1d5db' : '#374151',
                    bodyColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#d1d5db' : '#374151',
                    borderColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#374151' : '#d1d5db',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6
                }
            },
            cutout: '70%'
        }
    });
</script>

<?php include('include/header.php'); ?>