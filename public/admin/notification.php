<?php
// notifications.php (improved)
include 'include/side-bar.php';
// Display errors for debugging (remove in production)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include('../../includes/database.php');
include('../../includes/logger.php');

session_start();

// Fetch lists of students and staff for the UI
$students = [];
$staffs = [];
try {
    $sr = $conn->query("SELECT student_id, CONCAT(first_name, ' ', COALESCE(last_name,'')) AS name FROM students ORDER BY first_name, last_name");
    if ($sr) $students = $sr->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
}
try {
    $rr = $conn->query("SELECT staff_id, CONCAT(first_name, ' ', COALESCE(last_name,'')) AS name FROM staff ORDER BY first_name, last_name");
    if ($rr) $staffs = $rr->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
}

// --- Handle Notification Submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'send_notification') {
    $message = trim($_POST['message'] ?? '');
    $targetRole = $_POST['target_role'] ?? 'all';
    $senderName = $_SESSION['username'] ?? ($_SESSION['admin_name'] ?? 'Administrator');
    $senderId = $_SESSION['admin_id'] ?? null;

    if (empty($message)) {
        $status_message = "Please provide a message.";
        $status_type = "error";
    } elseif (!in_array($targetRole, ['all', 'student', 'staff', 'individual'])) {
        $status_message = "Invalid target audience.";
        $status_type = "error";
    } else {
        // Insert notification record
        $ins = $conn->prepare("INSERT INTO notifications (message, target_type, target_role, sender_name, sender_id) VALUES (?, ?, ?, ?, ?)");
        $ins->bind_param("sssss", $message, $targetRole, $targetRole, $senderName, $senderId);
        if (!$ins->execute()) {
            $status_message = "Error saving notification: " . $ins->error;
            $status_type = "error";
        } else {
            $notification_id = $conn->insert_id;
            // Build recipient list
            $recipients = [];
            if ($targetRole === 'all') {
                // get all students
                $r1 = $conn->query("SELECT student_id FROM students");
                if ($r1) while ($row = $r1->fetch_assoc()) $recipients[] = ['user_type' => 'student', 'user_id' => $row['student_id']];
                // get all staff
                $r2 = $conn->query("SELECT staff_id FROM staff");
                if ($r2) while ($row = $r2->fetch_assoc()) $recipients[] = ['user_type' => 'staff', 'user_id' => $row['staff_id']];
            } elseif ($targetRole === 'student') {
                $r = $conn->query("SELECT student_id FROM students");
                if ($r) while ($row = $r->fetch_assoc()) $recipients[] = ['user_type' => 'student', 'user_id' => $row['student_id']];
            } elseif ($targetRole === 'staff') {
                $r = $conn->query("SELECT staff_id FROM staff");
                if ($r) while ($row = $r->fetch_assoc()) $recipients[] = ['user_type' => 'staff', 'user_id' => $row['staff_id']];
            } else { // individual
                // Expecting values like student:123 or staff:45
                $posted = $_POST['recipients'] ?? [];
                if (!is_array($posted)) $posted = [$posted];
                foreach ($posted as $val) {
                    $parts = explode(':', $val, 2);
                    if (count($parts) === 2 && in_array($parts[0], ['student','staff']) && strlen($parts[1])>0) {
                        $recipients[] = ['user_type' => $parts[0], 'user_id' => $parts[1]];
                    }
                }
            }

            // Insert recipients
            if (!empty($recipients)) {
                $conn->begin_transaction();
                $prep = $conn->prepare("INSERT INTO notification_recipients (notification_id, user_type, user_id) VALUES (?, ?, ?)");
                foreach ($recipients as $r) {
                    $prep->bind_param('iss', $notification_id, $r['user_type'], $r['user_id']);
                    $prep->execute();
                }
                $conn->commit();
            }

            $status_message = "Notification queued/sent successfully!";
            $status_type = "success";
            log_activity($conn, $senderId ?? '', $senderName, $_SESSION['role'] ?? 'administrator', 'send_notification', "id={$notification_id};target={$targetRole};recipients=" . count($recipients));
        }
    }
}

// --- Handle Notification Deletion ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_notification_id'])) {
    $delete_id = intval($_POST['delete_notification_id']);
    $del = $conn->prepare("DELETE FROM notifications WHERE notification_id = ? LIMIT 1");
    $del->bind_param('i', $delete_id);
    if ($del->execute()) {
        $status_message = "Notification deleted successfully!";
        $status_type = "success";
        log_activity($conn, $_SESSION['admin_id'] ?? '', $_SESSION['username'] ?? 'Administrator', $_SESSION['role'] ?? 'administrator', 'delete_notification', "id={$delete_id}");
    } else {
        $status_message = "Error deleting notification: " . $conn->error;
        $status_type = "error";
    }
}

// --- Fetch Notifications for Display ---
$all_notifications_query = "SELECT * FROM notifications ORDER BY created_at DESC";
$all_notifications_result = $conn->query($all_notifications_query);
$all_notifications = $all_notifications_result ? $all_notifications_result->fetch_all(MYSQLI_ASSOC) : [];

?>
<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f3f4f6;
    }

    /* .container-shadow {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    } */
</style>
</head>

<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
            <div class="min-h-screen p-6 bg-gray-100 dark:bg-gray-900 flex flex-col items-center">
                <header class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-xl container-shadow p-6 mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Notification Management</h1>
                    <p class="text-gray-500 dark:text-gray-300 mt-2">Send and view announcements for students and staff.</p>
                </header>

                <div class="w-full max-w-4xl grid grid-cols-1 gap-6">

                    <!-- Status Message Display -->
                    <?php if (isset($status_message)): ?>
                        <div class="p-4 rounded-lg <?php echo $status_type === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'; ?> container-shadow">
                            <?php echo htmlspecialchars($status_message); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Button to open modal -->
                    <div class="flex justify-end">
                        <button onclick="document.getElementById('modal-form').classList.remove('hidden')"
                            class="bg-blue-600 text-white font-medium py-2 px-6 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-800 transition duration-200 ease-in-out">
                            <i class="fas fa-plus mr-2"></i>Send New Notification
                        </button>
                    </div>

                    <!-- Modal Popup Form -->
                    <div id="modal-form" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                        <div class="bg-white dark:bg-gray-800 rounded-xl container-shadow p-6 w-full max-w-lg relative">
                            <button onclick="document.getElementById('modal-form').classList.add('hidden')"
                                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white text-2xl">&times;</button>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Send New Notification</h2>
                            <form action="" method="POST" class="space-y-4">
                                <input type="hidden" name="form_type" value="send_notification">
                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Message</label>
                                    <textarea id="message" name="message" rows="4" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2"
                                        placeholder="Type your announcement here..."></textarea>
                                </div>
                                <div>
                                    <label for="target_role" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Send To</label>
                                    <select id="target_role" name="target_role" required onchange="toggleRecipients()"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                        <option value="all">All (Students & Staff)</option>
                                        <option value="student">Students Only</option>
                                        <option value="staff">Staff Only</option>
                                        <option value="individual">Individual Recipients</option>
                                    </select>
                                    <div id="recipients-container" class="mt-3 hidden">
                                        <label for="recipients" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Select Recipients (hold Ctrl / Cmd to select multiple)</label>
                                        <select id="recipients" name="recipients[]" multiple size="8"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm p-2">
                                            <?php if (!empty($students)): ?>
                                            <optgroup label="Students">
                                                <?php foreach ($students as $s): ?>
                                                    <option value="student:<?php echo htmlspecialchars($s['student_id']); ?>"><?php echo htmlspecialchars($s['name'] . ' (' . $s['student_id'] . ')'); ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                            <?php endif; ?>
                                            <?php if (!empty($staffs)): ?>
                                            <optgroup label="Staff">
                                                <?php foreach ($staffs as $sf): ?>
                                                    <option value="staff:<?php echo htmlspecialchars($sf['staff_id']); ?>"><?php echo htmlspecialchars($sf['name'] . ' (' . $sf['staff_id'] . ')'); ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-600 text-white font-medium py-2 px-6 rounded-lg 
                                                        hover:bg-blue-700 dark:hover:bg-blue-800 transition duration-200 ease-in-out">
                                        <i class="fas fa-paper-plane mr-2"></i>Send Notification
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Modal -->

                    <!-- Sent Notifications List -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl container-shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Sent Notifications</h2>
                        <div class="space-y-4">
                            <?php if (!empty($all_notifications)): ?>
                                <?php foreach ($all_notifications as $notification): ?>
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-900 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                        <div>
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                                        To: <span class="capitalize font-semibold"><?php echo htmlspecialchars($notification['target_type'] ?? $notification['target_role'] ?? 'all'); ?></span>
                                                    </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    Sent by: <?php echo htmlspecialchars($notification['sender_name']); ?> on <?php echo date('M d, Y H:i', strtotime($notification['created_at'])); ?>
                                                </span>
                                            </div>
                                            <p class="text-gray-800 dark:text-gray-200 text-base"><?php echo nl2br(htmlspecialchars($notification['message'])); ?></p>
                                        </div>
                                        <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this notification?');">
                                            <input type="hidden" name="delete_notification_id" value="<?php echo $notification['notification_id']; ?>">
                                            <button type="submit" class="mt-2 md:mt-0 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 dark:hover:bg-red-800 transition">
                                                <i class="fas fa-trash-alt mr-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-center text-gray-500 dark:text-gray-400">No notifications sent yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
            <script>
                // Optional: Close modal on ESC key
                document.addEventListener('keydown', function(e) {
                    if (e.key === "Escape") {
                        document.getElementById('modal-form').classList.add('hidden');
                    }
                });
                function toggleRecipients() {
                    var sel = document.getElementById('target_role');
                    var container = document.getElementById('recipients-container');
                    if (!sel || !container) return;
                    if (sel.value === 'individual') {
                        container.classList.remove('hidden');
                    } else {
                        container.classList.add('hidden');
                        // clear selection
                        var r = document.getElementById('recipients');
                        if (r) {
                            for (var i=0;i<r.options.length;i++) r.options[i].selected = false;
                        }
                    }
                }
            </script>
</body>

</html>
<?php include 'include/modals.php'; ?>