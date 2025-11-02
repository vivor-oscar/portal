<?php
// This partial expects these variables prepared by fee-dashboard.php:
// $fees, $classes, $selected_class, $totals_per_class, $totals_per_student
?>
<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Feeding & Transport Fees</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="bg-green-100 p-2 mb-3"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <form method="post" class="mb-4">
        <input type="hidden" name="action" value="save_fee">
        <div class="grid grid-cols-3 gap-2">
            <select name="service" required>
                <option value="feeding">Feeding & Transport</option>
            </select>
            <input name="location" placeholder="Location (e.g. Town name)" required>
            <input name="amount" type="number" step="0.01" placeholder="Amount" required>
        </div>
        <button type="submit" class="mt-2 bg-blue-600 text-white px-3 py-1">Save</button>
    </form>

    <div class="mb-4">
        <form method="get" class="flex items-center gap-2">
            <input type="hidden" name="tab" value="feeding-transport">
            <label class="text-sm">Filter by class:</label>
            <select name="class" class="p-2 border rounded">
                <option value="">All classes</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?php echo htmlspecialchars($c); ?>" <?php echo ($selected_class === $c) ? 'selected' : ''; ?>><?php echo htmlspecialchars($c); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="bg-gray-200 px-3 py-1 rounded">Apply</button>
        </form>
    </div>

    <h3 class="font-semibold">Configured Service Fees</h3>
    <table class="w-full text-left text-sm">
        <thead><tr><th>Service</th><th>Location</th><th>Amount</th></tr></thead>
        <tbody>
            <?php foreach ($fees as $f): ?>
                <?php $service_display = in_array($f['service_name'], ['feeding','transport']) ? 'Feeding & Transport' : $f['service_name']; ?>
                <tr>
                    <td><?php echo htmlspecialchars($service_display); ?></td>
                    <td><?php echo htmlspecialchars($f['location']); ?></td>
                    <td><?php echo number_format($f['amount'],2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3 class="mt-6 font-semibold">Expected Totals Per Class</h3>
    <table class="w-full text-left text-sm">
        <thead><tr><th>Class</th><th>Students</th><th>Expected Total</th></tr></thead>
        <tbody>
            <?php foreach ($totals_per_class as $className => $t): ?>
                <tr>
                    <td><?php echo htmlspecialchars($className); ?></td>
                    <td><?php echo (int)$t['students_count']; ?></td>
                    <td><?php echo number_format($t['expected_total'] ?? 0,2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3 class="mt-6 font-semibold">Expected Amount Per Student (by location)</h3>
    <?php if ($selected_class === ''): ?>
        <div class="text-sm text-gray-600">Please select a class and click Apply to view student-level expected amounts.</div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expected Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($totals_per_student)): ?>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">No students found for the selected class.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($totals_per_student as $s): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($s['first_name'].' '.$s['last_name'].' ('.$s['student_id'].')'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($s['class']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">GHS <?php echo number_format($s['expected_amount'],2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <h3 class="mt-6 font-semibold">Class Summaries</h3>
    <?php
    // show daily and weekly summary for selected class or list recent summaries for all classes
    if ($selected_class !== '') {
        $stmt = $conn->prepare("SELECT summary_date, expected_total, received_total, updated_at FROM daily_class_summaries WHERE class_name = ? ORDER BY summary_date DESC LIMIT 14");
        $stmt->bind_param('s', $selected_class);
        $stmt->execute();
        $daily = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $wstmt = $conn->prepare("SELECT week_start, expected_total, received_total, updated_at FROM weekly_class_summaries WHERE class_name = ? ORDER BY week_start DESC LIMIT 12");
        $wstmt->bind_param('s', $selected_class);
        $wstmt->execute();
        $weekly = $wstmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $wstmt->close();
    } else {
        $daily = [];
        $weekly = [];
    }
    ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
        <div class="bg-white rounded p-3 shadow">
            <h4 class="font-semibold">Recent Daily Summaries</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead><tr><th>Date</th><th>Expected</th><th>Received</th><th>Updated</th></tr></thead>
                    <tbody>
                        <?php if (empty($daily)): ?>
                            <tr><td colspan="4" class="p-2 text-gray-500">No daily summaries for this class.</td></tr>
                        <?php else: ?>
                            <?php foreach ($daily as $d): ?>
                                <tr>
                                    <td class="px-2"><?php echo htmlspecialchars($d['summary_date']); ?></td>
                                    <td class="px-2">GHS <?php echo number_format($d['expected_total'],2); ?></td>
                                    <td class="px-2">GHS <?php echo number_format($d['received_total'],2); ?></td>
                                    <td class="px-2"><?php echo htmlspecialchars($d['updated_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="bg-white rounded p-3 shadow">
            <h4 class="font-semibold">Recent Weekly Summaries</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead><tr><th>Week Start</th><th>Expected (week)</th><th>Received (week)</th><th>Updated</th></tr></thead>
                    <tbody>
                        <?php if (empty($weekly)): ?>
                            <tr><td colspan="4" class="p-2 text-gray-500">No weekly summaries for this class.</td></tr>
                        <?php else: ?>
                            <?php foreach ($weekly as $w): ?>
                                <tr>
                                    <td class="px-2"><?php echo htmlspecialchars($w['week_start']); ?></td>
                                    <td class="px-2">GHS <?php echo number_format($w['expected_total'],2); ?></td>
                                    <td class="px-2">GHS <?php echo number_format($w['received_total'],2); ?></td>
                                    <td class="px-2"><?php echo htmlspecialchars($w['updated_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
