<?php
include('include/side-bar.php');
?>
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
        <div>
            <div>
                <div class="tab">
                    <?php
                    // filter inputs (by name and date)
                    include('../../includes/database.php');

                    $filter_name = isset($_GET['name']) ? trim($_GET['name']) : '';
                    $filter_date = isset($_GET['date']) ? trim($_GET['date']) : '';

                    ?>

                    <div class="bg-white shadow rounded-lg p-4 mb-4">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <h2 class="text-lg font-medium">Staff Attendance</h2>
                            <form method="get" class="flex flex-wrap gap-2 items-center">
                                <input type="text" name="name" placeholder="Filter by name" class="std-input-box" value="<?php echo htmlspecialchars($filter_name); ?>">
                                <input type="date" name="date" class="std-input-box" value="<?php echo htmlspecialchars($filter_date); ?>">
                                <label class="text-sm">Show</label>
                                <select name="page_size" class="std-input-box">
                                    <?php
                                    $allowed = [10, 20, 50, 100];
                                    $curSize = isset($_GET['page_size']) ? (int)$_GET['page_size'] : 20;
                                    foreach ($allowed as $a) {
                                        $s = ($a == $curSize) ? 'selected' : '';
                                        echo "<option value=\"$a\" $s>$a</option>";
                                    }
                                    ?>
                                </select>
                                <button type="submit" class="sort-btn" style="background-color: black; color:white; border:none; border-radius:5px; padding:6px 10px;">Apply</button>
                                <a href="view-attendance.php" class="sort-btn" style="background-color: #666; color:#fff; padding:6px 10px; border-radius:5px; text-decoration:none;">Clear</a>
                            </form>
                        </div>
                    </div>

                    <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border-0 p-6 transition-all hover:shadow-lg hover:-translate-y-1 overflow-hidden">
                        <div class="overflow-x-auto -mx-6 px-6">
                            <table class="min-w-[900px] w-full text-left text-[clamp(0.75rem,1.5vw,1rem)]">
                                <thead class="bg-gray-100 dark:bg-gray-900">
                                    <th class="tab-head">Staff ID</th>
                                    <th class="tab-head">Staff Full Name</th>
                                    <th class="tab-head">Date Checked In</th>
                                    <th class="tab-head">Time Checked In</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    // Build query with optional filters
                                    $where = [];
                                    if ($filter_name !== '') {
                                        $esc = $conn->real_escape_string($filter_name);
                                        $where[] = "(CONCAT(IFNULL(s.first_name,''),' ',IFNULL(s.mid_name,''),' ',IFNULL(s.last_name,'')) LIKE '%$esc%')";
                                    }
                                    if ($filter_date !== '') {
                                        $esc_d = $conn->real_escape_string($filter_date);
                                        $where[] = "DATE(sa.check_in_time) = '$esc_d'";
                                    }

                                    $sql = "SELECT sa.*, s.first_name, s.mid_name, s.last_name FROM staff_attendance sa LEFT JOIN staff s ON sa.staff_id = s.staff_id";
                                    if (!empty($where)) {
                                        $sql .= ' WHERE ' . implode(' AND ', $where);
                                    }
                                    $sql .= ' ORDER BY sa.check_in_time DESC';

                                    $result = mysqli_query($conn, $sql);
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $full = trim($row['first_name'] . ' ' . $row['mid_name'] . ' ' . $row['last_name']);
                                            $check = $row['check_in_time'];
                                            $date = '';
                                            $time = '';
                                            if (!empty($check) && $check !== '0000-00-00 00:00:00') {
                                                try {
                                                    $dt = new DateTime($check, new DateTimeZone('Africa/Accra'));
                                                    $date = $dt->format('d F Y');
                                                    $time = $dt->format('H:i:s');
                                                } catch (Exception $e) {
                                                    $ts = strtotime($check);
                                                    if ($ts !== false) {
                                                        $date = date('d F Y', $ts);
                                                        $time = date('H:i:s', $ts);
                                                    } else {
                                                        $date = $check;
                                                    }
                                                }
                                            }

                                            echo '<tr>';
                                            echo '<td class="py-2 px-4 text-gray-900 dark:text-gray-100">' . htmlspecialchars($row['staff_id']) . '</td>';
                                            echo '<td class="py-2 px-4 text-gray-900 dark:text-gray-100">' . htmlspecialchars($full ?: 'Unknown') . '</td>';
                                            echo '<td class="py-2 px-4 text-gray-900 dark:text-gray-100">' . htmlspecialchars($date) . '</td>';
                                            echo '<td class="py-2 px-4 text-gray-900 dark:text-gray-100">' . htmlspecialchars($time) . '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="4">No records found</td></tr>';
                                    }

                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <!-- Pagination controls -->
                        <div class="mt-3 flex items-center justify-between text-sm">
                            <div class="text-gray-600">Showing <?php echo ($total > 0 ? ($offset + 1) : 0); ?> to <?php echo min($total, $offset + $page_size); ?> of <?php echo $total; ?> entries</div>
                            <div class="flex items-center gap-2">
                                <?php if ($page > 1): ?>
                                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>" class="px-3 py-1 bg-white border rounded">Prev</a>
                                <?php else: ?>
                                    <span class="px-3 py-1 bg-gray-200 border rounded text-gray-500">Prev</span>
                                <?php endif; ?>

                                <?php
                                $start = max(1, $page - 3);
                                $end = min($total_pages, $page + 3);
                                for ($p = $start; $p <= $end; $p++):
                                ?>
                                    <?php if ($p == $page): ?>
                                        <span class="px-3 py-1 bg-black text-white rounded"><?php echo $p; ?></span>
                                    <?php else: ?>
                                        <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $p])); ?>" class="px-3 py-1 bg-white border rounded"><?php echo $p; ?></a>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <?php if ($page < $total_pages): ?>
                                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>" class="px-3 py-1 bg-white border rounded">Next</a>
                                <?php else: ?>
                                    <span class="px-3 py-1 bg-gray-200 border rounded text-gray-500">Next</span>
                                <?php endif; ?>
                            </div>
                        </div>

                </div>
            </div>
        </div>
        <?php include('include/head.php'); ?>