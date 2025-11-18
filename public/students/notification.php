
    <?php include('include/side-bar.php'); ?>
        <?php
        // Include database connection (already included by side-bar, but keep for clarity)
        include('../../includes/database.php');

        // Resolve current student_id from session username
        $student_id = '';
        $username = $_SESSION['username'] ?? '';
        if (!empty($username)) {
            $sstmt = $conn->prepare("SELECT student_id FROM students WHERE username = ? LIMIT 1");
            if ($sstmt) {
                $sstmt->bind_param('s', $username);
                $sstmt->execute();
                $sres = $sstmt->get_result();
                if ($sres && $srow = $sres->fetch_assoc()) {
                    $student_id = $srow['student_id'];
                }
                $sstmt->close();
            }
        }

        // Handle mark-as-read requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['mark_read_notification_id'])) {
                $nid = intval($_POST['mark_read_notification_id']);
                $now = date('Y-m-d H:i:s');
                // Check if recipient row exists
                $chk = $conn->prepare("SELECT id FROM notification_recipients WHERE notification_id = ? AND user_type = 'student' AND user_id = ? LIMIT 1");
                if ($chk) {
                    $chk->bind_param('is', $nid, $student_id);
                    $chk->execute();
                    $cres = $chk->get_result();
                    if ($cres && $crow = $cres->fetch_assoc()) {
                        // update read_at
                        $upd = $conn->prepare("UPDATE notification_recipients SET read_at = ? WHERE id = ? LIMIT 1");
                        if ($upd) { $upd->bind_param('si', $now, $crow['id']); $upd->execute(); $upd->close(); }
                    } else {
                        // insert recipient marked read
                        $ins = $conn->prepare("INSERT INTO notification_recipients (notification_id, user_type, user_id, read_at) VALUES (?, 'student', ?, ?)");
                        if ($ins) { $ins->bind_param('iss', $nid, $student_id, $now); $ins->execute(); $ins->close(); }
                    }
                    $chk->close();
                }
            } elseif (isset($_POST['mark_all_read'])) {
                $now = date('Y-m-d H:i:s');
                // For all notifications applicable to this student, ensure a recipient row exists and mark read_at
                $sel = $conn->prepare("SELECT n.notification_id, nr.id AS nrid
                    FROM notifications n
                    LEFT JOIN notification_recipients nr ON nr.notification_id = n.notification_id AND nr.user_type = 'student' AND nr.user_id = ?
                    WHERE (n.target_role IN ('all','student') OR nr.id IS NOT NULL)");
                if ($sel) {
                    $sel->bind_param('s', $student_id);
                    $sel->execute();
                    $r = $sel->get_result();
                    if ($r) {
                        while ($row = $r->fetch_assoc()) {
                            if (!empty($row['nrid'])) {
                                $u = $conn->prepare("UPDATE notification_recipients SET read_at = ? WHERE id = ? LIMIT 1");
                                if ($u) { $u->bind_param('si', $now, $row['nrid']); $u->execute(); $u->close(); }
                            } else {
                                $i = $conn->prepare("INSERT INTO notification_recipients (notification_id, user_type, user_id, read_at) VALUES (?, 'student', ?, ?)");
                                if ($i) { $i->bind_param('iss', $row['notification_id'], $student_id, $now); $i->execute(); $i->close(); }
                            }
                        }
                    }
                    $sel->close();
                }
            }
        }

        // Fetch notifications relevant to the student (per-user recipients prioritized; legacy target_role fallback)
        $student_notifications = [];
        $q = "SELECT n.notification_id, n.message, n.sender_name, n.created_at, nr.id AS recipient_id, nr.read_at
            FROM notifications n
            LEFT JOIN notification_recipients nr ON nr.notification_id = n.notification_id AND nr.user_type = 'student' AND nr.user_id = ?
            WHERE (nr.id IS NOT NULL) OR (n.target_role IN ('all','student'))
            ORDER BY n.created_at DESC";
        $stmt = $conn->prepare($q);
        if ($stmt) {
            $stmt->bind_param('s', $student_id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res) $student_notifications = $res->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        }
        ?>

    <div class="flex min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100">
        <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 md:p-6 lg:p-8 overflow-x-hidden">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">Notifications</h1>
                <p class="text-gray-600 dark:text-gray-400">Stay updated with the latest messages from your school</p>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Your Notifications</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Recent messages targeted to you</p>
                    </div>
                    <form method="POST" onsubmit="return confirm('Mark all notifications as read?');">
                        <input type="hidden" name="mark_all_read" value="1">
                        <button type="submit" class="px-3 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 text-sm">Mark all as read</button>
                    </form>
                </div>

                <?php if (!empty($student_notifications)): ?>
                    <div class="grid grid-cols-1 gap-4">
                        <?php foreach ($student_notifications as $index => $notification): ?>
                            <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
                                <!-- Top Accent Bar -->
                                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-1"></div>
                                
                                <div class="p-6">
                                    <!-- Header with Index and Time -->
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0">
                                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900 dark:to-teal-900">
                                                    <i class="fas fa-bell text-emerald-600 dark:text-emerald-400"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wide">Notification <?php echo htmlspecialchars(count($student_notifications) - $index); ?></p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">From: <span class="font-bold text-emerald-600 dark:text-emerald-400"><?php echo htmlspecialchars($notification['sender_name']); ?></span></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <?php $isUnread = empty($notification['read_at']); ?>
                                            <?php if ($isUnread): ?>
                                                <span class="inline-flex items-center gap-1 text-xs text-white bg-red-500 px-2 py-0.5 rounded">Unread</span>
                                            <?php else: ?>
                                                <span class="inline-flex items-center gap-1 text-xs text-gray-500">Read</span>
                                            <?php endif; ?>
                                            <span class="ml-auto inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                            <i class="fas fa-clock"></i>
                                            <?php echo date('M d, Y', strtotime($notification['created_at'])); ?>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Divider -->
                                    <div class="my-4 border-t border-gray-200 dark:border-gray-700"></div>

                                    <!-- Message Content -->
                                    <div class="mb-4">
                                        <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-wrap">
                                            <?php echo htmlspecialchars($notification['message']); ?>
                                        </p>
                                    </div>

                                    <!-- Timestamp and actions -->
                                    <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 justify-between">
                                        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-info-circle"></i>
                                            <span>Created at <?php echo date('h:i A', strtotime($notification['created_at'])); ?></span>
                                        </div>
                                        <div>
                                            <?php if (empty($notification['read_at'])): ?>
                                                <form method="POST" class="inline-block">
                                                    <input type="hidden" name="mark_read_notification_id" value="<?php echo intval($notification['notification_id']); ?>">
                                                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">Mark as read</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-400">Marked: <?php echo date('M d, h:i A', strtotime($notification['read_at'])); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 p-12">
                        <div class="flex flex-col items-center justify-center text-center">
                            <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                                <i class="fas fa-inbox text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Notifications</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">You're all caught up! Check back soon for new updates</p>
                            <a href="student-dashboard.php" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-arrow-left"></i>
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
