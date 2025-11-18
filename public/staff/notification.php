<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <?php include('include/side-bar.php'); ?>
    <?php
    // Include database connection
    include('../../includes/database.php');

    // Resolve staff_id for current user
    $staff_id = '';
    $username = $_SESSION['username'] ?? '';
    if (!empty($username)) {
        $sstmt = $conn->prepare("SELECT staff_id FROM staff WHERE username = ? LIMIT 1");
        if ($sstmt) {
            $sstmt->bind_param('s', $username);
            $sstmt->execute();
            $sres = $sstmt->get_result();
            if ($sres && $srow = $sres->fetch_assoc()) {
                $staff_id = $srow['staff_id'];
            }
            $sstmt->close();
        }
    }

    // Handle mark-as-read requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['mark_read_notification_id'])) {
            $nid = intval($_POST['mark_read_notification_id']);
            $now = date('Y-m-d H:i:s');
            $chk = $conn->prepare("SELECT id FROM notification_recipients WHERE notification_id = ? AND user_type = 'staff' AND user_id = ? LIMIT 1");
            if ($chk) {
                $chk->bind_param('is', $nid, $staff_id);
                $chk->execute();
                $cres = $chk->get_result();
                if ($cres && $crow = $cres->fetch_assoc()) {
                    $upd = $conn->prepare("UPDATE notification_recipients SET read_at = ? WHERE id = ? LIMIT 1");
                    if ($upd) { $upd->bind_param('si', $now, $crow['id']); $upd->execute(); $upd->close(); }
                } else {
                    $ins = $conn->prepare("INSERT INTO notification_recipients (notification_id, user_type, user_id, read_at) VALUES (?, 'staff', ?, ?)");
                    if ($ins) { $ins->bind_param('iss', $nid, $staff_id, $now); $ins->execute(); $ins->close(); }
                }
                $chk->close();
            }
        } elseif (isset($_POST['mark_all_read'])) {
            $now = date('Y-m-d H:i:s');
            $sel = $conn->prepare("SELECT n.notification_id, nr.id AS nrid
                FROM notifications n
                LEFT JOIN notification_recipients nr ON nr.notification_id = n.notification_id AND nr.user_type = 'staff' AND nr.user_id = ?
                WHERE (n.target_role IN ('all','staff') OR nr.id IS NOT NULL)");
            if ($sel) {
                $sel->bind_param('s', $staff_id);
                $sel->execute();
                $r = $sel->get_result();
                if ($r) {
                    while ($row = $r->fetch_assoc()) {
                        if (!empty($row['nrid'])) {
                            $u = $conn->prepare("UPDATE notification_recipients SET read_at = ? WHERE id = ? LIMIT 1");
                            if ($u) { $u->bind_param('si', $now, $row['nrid']); $u->execute(); $u->close(); }
                        } else {
                            $i = $conn->prepare("INSERT INTO notification_recipients (notification_id, user_type, user_id, read_at) VALUES (?, 'staff', ?, ?)");
                            if ($i) { $i->bind_param('iss', $row['notification_id'], $staff_id, $now); $i->execute(); $i->close(); }
                        }
                    }
                }
                $sel->close();
            }
        }
    }

    // Fetch notifications relevant to this staff user (per-user recipients prioritized; legacy fallback)
    $staff_notifications = [];
    $q = "SELECT n.notification_id, n.message, n.sender_name, n.created_at, nr.id AS recipient_id, nr.read_at
        FROM notifications n
        LEFT JOIN notification_recipients nr ON nr.notification_id = n.notification_id AND nr.user_type = 'staff' AND nr.user_id = ?
        WHERE (nr.id IS NOT NULL) OR (n.target_role IN ('all','staff'))
        ORDER BY n.created_at DESC
        LIMIT 50";
    $stmt = $conn->prepare($q);
    if ($stmt) {
        $stmt->bind_param('s', $staff_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res) $staff_notifications = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }

    //$conn->close();
    ?>

    <div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
            <div class="mt-16"> <!-- Added margin-top for header spacing -->
                <div class="w-full max-w-3xl">
                    <div class="bg-white rounded-xl container-shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Notifications</h2>
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Recent messages targeted to you</p>
                            </div>
                            <form method="POST" onsubmit="return confirm('Mark all notifications as read?');">
                                <input type="hidden" name="mark_all_read" value="1">
                                <button type="submit" class="px-3 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 text-sm">Mark all as read</button>
                            </form>
                        </div>
                        <div class="space-y-3">
                            <?php if (!empty($staff_notifications)): ?>
                                <?php foreach ($staff_notifications as $notification): ?>
                                    <?php $isUnread = empty($notification['read_at']); ?>
                                    <div class="border border-gray-200 rounded-lg p-3 <?php echo $isUnread ? 'bg-blue-50' : 'bg-white dark:bg-gray-800'; ?>">
                                        <div class="flex justify-between items-center mb-1">
                                            <div>
                                                <span class="text-xs text-gray-600">From: <?php echo htmlspecialchars($notification['sender_name']); ?></span>
                                                <?php if ($isUnread): ?>
                                                    <span class="ml-2 inline-block text-xs bg-red-500 text-white px-2 py-0.5 rounded">Unread</span>
                                                <?php else: ?>
                                                    <span class="ml-2 inline-block text-xs text-gray-500">Read</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <span class="text-xs text-gray-500"><?php echo date('M d, Y H:i', strtotime($notification['created_at'])); ?></span>
                                                <?php if ($isUnread): ?>
                                                    <form method="POST" class="inline-block">
                                                        <input type="hidden" name="mark_read_notification_id" value="<?php echo intval($notification['notification_id']); ?>">
                                                        <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">Mark as read</button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-xs text-gray-400">Marked: <?php echo date('M d, h:i A', strtotime($notification['read_at'])); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <p class="text-gray-800 text-sm"><?php echo nl2br(htmlspecialchars($notification['message'])); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-center text-gray-500 text-sm">No new notifications for you.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
</body>

</html>
