<?php
// Ensure session is started
if (session_status() === PHP_SESSION_NONE) session_start();
include('include/side-bar.php');
include('../../includes/database.php');

// Ensure user is logged in as staff
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    header("Location:../../index.php");
    exit();
}

// Resolve staff id from session username safely
$staff_username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$staff_id = null;
if ($staff_username !== '') {
    $esc_staff_username = $conn->real_escape_string($staff_username);
    $staff_result = $conn->query("SELECT staff_id FROM staff WHERE username = '$esc_staff_username' LIMIT 1");
    if ($staff_result && $row = $staff_result->fetch_assoc()) {
        $staff_id = $row['staff_id'];
    }
}

if (empty($staff_id)) {
    $error = "Unable to determine your staff id. Please contact admin.";
}

// Get assigned class
    // Find assigned class for this staff
    $class_row = null;
    if (!empty($staff_id)) {
        $esc_sid = $conn->real_escape_string($staff_id);
        $class_query = $conn->query("SELECT c.class_name FROM staff_classes sc JOIN class c ON sc.class_name = c.class_name WHERE sc.staff_id = '$esc_sid' LIMIT 1");
        if ($class_query) $class_row = $class_query->fetch_assoc();
    }

if (!$class_row) {
    $error = "No class assigned to you.";
    $class_name = '';
} else {
    $class_name = $class_row['class_name'];
}

// Query students for the assigned class
$students_result = false;
if (!empty($class_name)) {
    $esc_class = $conn->real_escape_string($class_name);
    $student_query = "SELECT s.student_id, s.first_name, s.last_name, s.mid_name FROM students s WHERE s.class = '$esc_class'";
    $students_result = $conn->query($student_query);
    if ($students_result === false) {
        $error = "Error fetching students: " . $conn->error;
    }
}
?>

<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
                <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">Learner in my class</h1>

                <?php if (!empty($error)): ?>
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

        <div class="overflow-x-auto shadow rounded-lg border border-gray-300 dark:border-gray-700">
            <table class="min-w-full bg-white dark:bg-gray-800">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">First Name</th>
                        <th class="px-4 py-2 border">Middle Name</th>
                        <th class="px-4 py-2 border">Last Name</th>
                        <th class="px-4 py-2 border">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($students_result && mysqli_num_rows($students_result) > 0): ?>
                        <?php while ($student = $students_result->fetch_assoc()): ?>
                            <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-2 border"><?= htmlspecialchars($student['student_id']) ?></td>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($student['first_name']) ?></td>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($student['mid_name']) ?></td>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($student['last_name']) ?></td>
                                <td class='py-3 px-4'><span class='px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 rounded-full'>Active</span></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-600">No students found for your class.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>