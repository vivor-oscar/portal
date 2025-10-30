<?php
require_once('include/side-bar.php');
include('../../includes/database.php');
include('../../includes/logger.php');

// Only administrators should access
session_start();
if (empty($_SESSION['role']) || $_SESSION['role'] !== 'administrator') {
    header('Location: ../session/logout.php');
    exit();
}

$where = [];
$params = [];

// Filters
$start = $_GET['start_date'] ?? null;
$end = $_GET['end_date'] ?? null;
$user = $_GET['user'] ?? null;
$action = $_GET['action'] ?? null;

// Pagination params
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$pageSize = isset($_GET['page_size']) && is_numeric($_GET['page_size']) ? max(10, intval($_GET['page_size'])) : 50;

// Handle clear logs POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_logs'])) {
    session_start();
    $user_id = $_SESSION['admin_id'] ?? '';
    $username = $_SESSION['username'] ?? '';
    // write external audit for the clear action
    $msg = date('Y-m-d H:i:s') . " - Logs cleared by " . ($username ?: 'unknown') . " (user_id=" . $user_id . ")\n";
    @file_put_contents(__DIR__ . '/../../logs/clear_actions.log', $msg, FILE_APPEND);
    // truncate audit_logs
    $conn->query('TRUNCATE TABLE audit_logs');
    $_SESSION['message'] = 'Audit logs cleared.';
    header('Location: system-report.php');
    exit();
}

if ($start) {
    $where[] = "created_at >= '" . $conn->real_escape_string($start) . " 00:00:00'";
}
if ($end) {
    $where[] = "created_at <= '" . $conn->real_escape_string($end) . " 23:59:59'";
}
if ($user) {
    $where[] = "(username LIKE '%" . $conn->real_escape_string($user) . "%' OR user_id LIKE '%" . $conn->real_escape_string($user) . "%')";
}
if ($action) {
    $where[] = "action = '" . $conn->real_escape_string($action) . "'";
}

// Build base query
$baseSql = "FROM audit_logs";
if (count($where) > 0) $baseSql .= " WHERE " . implode(' AND ', $where);

// total count for pagination
$countRes = $conn->query("SELECT COUNT(*) AS total " . $baseSql);
$totalRows = $countRes ? intval($countRes->fetch_assoc()['total']) : 0;
$totalPages = max(1, ceil($totalRows / $pageSize));
$offset = ($page - 1) * $pageSize;

$sql = "SELECT * " . $baseSql . " ORDER BY created_at DESC LIMIT $offset, $pageSize";
$result = $conn->query($sql);

// CSV export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="system-report.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['id','user_id','username','role','action','details','ip','created_at']);
    while ($row = $result->fetch_assoc()) {
        fputcsv($out, [$row['id'],$row['user_id'],$row['username'],$row['role'],$row['action'],$row['details'],$row['ip'],$row['created_at']]);
    }
    fclose($out);
    exit();
}

?>
<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-semibold">System Audit Report</h2>
            <div class="flex items-center gap-2">
                <a href="?export=csv" class="px-3 py-2 bg-green-600 text-white rounded">Export CSV</a>
                <form method="post" onsubmit="return confirm('Are you sure you want to clear all audit logs? This action cannot be undone.');" style="display:inline">
                    <button name="clear_logs" type="submit" class="ml-2 px-3 py-2 bg-red-600 text-white rounded">Clear Logs</button>
                </form>
            </div>
        </div>

        <?php
        // actions list for dropdown
        $actRes = $conn->query("SELECT DISTINCT action FROM audit_logs ORDER BY action ASC");
        $actionsList = [];
        if ($actRes) {
            while ($r = $actRes->fetch_assoc()) $actionsList[] = $r['action'];
        }
        ?>
        <form method="get" class="mb-6 grid grid-cols-1 md:grid-cols-6 gap-3">
            <input type="date" name="start_date" value="<?= htmlspecialchars($start) ?>" class="p-2 border rounded" />
            <input type="date" name="end_date" value="<?= htmlspecialchars($end) ?>" class="p-2 border rounded" />
            <input type="text" name="user" placeholder="User or ID" value="<?= htmlspecialchars($user) ?>" class="p-2 border rounded" />
            <select name="action" class="p-2 border rounded">
                <option value="">All Actions</option>
                <?php foreach ($actionsList as $a): ?>
                    <option value="<?= htmlspecialchars($a) ?>" <?= ($a === $action) ? 'selected' : '' ?>><?= htmlspecialchars($a) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="page_size" class="p-2 border rounded">
                <?php foreach ([10,25,50,100] as $ps): ?>
                    <option value="<?= $ps ?>" <?= ($ps == $pageSize) ? 'selected' : '' ?>><?= $ps ?> per page</option>
                <?php endforeach; ?>
            </select>
            <div class="md:col-span-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
                <a href="system-report.php" class="ml-2 px-4 py-2 bg-gray-200 rounded">Clear</a>
            </div>
        </form>

        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left">
                        <th class="p-2">#</th>
                        <th class="p-2">When</th>
                        <th class="p-2">User</th>
                        <th class="p-2">Role</th>
                        <th class="p-2">Action</th>
                        <th class="p-2">Details</th>
                        <th class="p-2">IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border-t">
                            <td class="p-2"><?= htmlspecialchars($row['id']) ?></td>
                            <td class="p-2"><?= htmlspecialchars($row['created_at']) ?></td>
                            <td class="p-2"><?= htmlspecialchars($row['username'] ?: $row['user_id']) ?></td>
                            <td class="p-2"><?= htmlspecialchars($row['role']) ?></td>
                            <td class="p-2"><?= htmlspecialchars($row['action']) ?></td>
                            <td class="p-2"><?= htmlspecialchars($row['details']) ?></td>
                            <td class="p-2"><?= htmlspecialchars($row['ip']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="mt-4 flex items-center justify-between">
                <div class="text-sm text-gray-600">Showing page <?= $page ?> of <?= $totalPages ?> (<?= $totalRows ?> records)</div>
                <div class="flex gap-2">
                    <?php if ($page > 1): ?>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page-1])); ?>" class="px-3 py-1 bg-gray-200 rounded">Previous</a>
                    <?php endif; ?>
                    <?php if ($page < $totalPages): ?>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page+1])); ?>" class="px-3 py-1 bg-gray-200 rounded">Next</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include('include/header.php'); ?>
