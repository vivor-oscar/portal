
<div class="p-4">
    <h2 class="text-lg sm:text-xl md:text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Feeding & Transport Fees</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="bg-green-100 dark:bg-green-800 p-2 mb-3 text-gray-800 dark:text-gray-100"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <form method="post" class="mb-4">
        <input type="hidden" name="action" value="save_fee">
        <div class="grid grid-cols-3 gap-2">
            <select name="service" required class="p-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                <option value="feeding">Feeding & Transport</option>
            </select>
            <input name="location" placeholder="Location (e.g. Town name)" required class="p-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            <input name="amount" type="number" step="0.01" placeholder="Amount" required class="p-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
        </div>
        <button type="submit" class="mt-2 bg-blue-600 text-white px-3 py-1 rounded dark:bg-blue-500">Save</button>
    </form>

    <div class="mb-4">
        <form method="get" class="flex items-center gap-2">
            <input type="hidden" name="tab" value="feeding-transport">
            <label class="text-sm text-gray-700 dark:text-gray-300">Filter by class:</label>
            <select name="class" class="p-2 border rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                <option value="">All classes</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?php echo htmlspecialchars($c); ?>" <?php echo ($selected_class === $c) ? 'selected' : ''; ?>><?php echo htmlspecialchars($c); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-100">Apply</button>
        </form>
    </div>

    <h3 class="font-semibold text-gray-800 dark:text-gray-200">Configured Service Fees</h3>
    <table class="w-full text-left text-sm text-sm sm:text-base">
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

    <h3 class="mt-6 font-semibold text-gray-800 dark:text-gray-200">Expected Totals Per Class</h3>
    <table class="w-full text-left text-sm text-sm sm:text-base">
        <thead><tr><th>Class</th><th>Students</th><th>Expected Total</th></tr></thead>
        <tbody>
            <?php foreach ($totals_per_class as $className => $t): ?>
                <tr>
                    <td><?php echo htmlspecialchars($className); ?></td>
                    <td><?php echo (int)$t['students_count']; ?></td>
                    <?php $expected = (float)($t['expected_total'] ?? 0); ?>
                    <?php $received = (float)($t['received_total'] ?? 0); ?>
                    <?php
                        $colorClass = 'text-gray-700 dark:text-gray-300';
                        if ($received < $expected) $colorClass = 'text-red-600 dark:text-red-400';
                        elseif ($received > $expected) $colorClass = 'text-green-600 dark:text-green-400';
                    ?>
                    <td class="<?php echo $colorClass; ?>">GHS <?php echo number_format($received,2); ?> / <?php echo number_format($expected,2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3 class="mt-6 font-semibold text-gray-800 dark:text-gray-200">Expected Amount Per Student (by location)</h3>
    <?php if ($selected_class === ''): ?>
        <div class="text-sm text-gray-600">Please select a class and click Apply to view student-level expected amounts.</div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs sm:text-sm md:text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Student</th>
                        <th class="px-6 py-3 text-left text-xs sm:text-sm md:text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Class</th>
                        <th class="px-6 py-3 text-left text-xs sm:text-sm md:text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Expected Amount</th>
                        <th class="px-6 py-3 text-left text-xs sm:text-sm md:text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Score</th>
                        <th class="px-6 py-3 text-left text-xs sm:text-sm md:text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if (empty($totals_per_student)): ?>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">No students found for the selected class.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($totals_per_student as $s): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($s['first_name'].' '.$s['last_name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($s['class']); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">GHS <?php echo number_format($s['expected_amount'],2); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap"><?php echo isset($s['score']) ? (int)$s['score'] : 0; ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">GHS <?php echo number_format($s['scored_amount'] ?? 0,2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <h3 class="mt-6 font-semibold text-gray-800 dark:text-gray-200">Class Summaries</h3>
    <?php
    // debug helper: visit this page with &debug=1 to show counts and recent rows from the summary tables
    if (isset($_GET['debug']) && $_GET['debug'] === '1') {
        $dcount = 0; $wcount = 0;
        $dres = $conn->query("SELECT COUNT(*) AS c FROM daily_class_summaries");
        if ($dres && $dr = $dres->fetch_assoc()) $dcount = (int)$dr['c'];
        $wres = $conn->query("SELECT COUNT(*) AS c FROM weekly_class_summaries");
        if ($wres && $wr = $wres->fetch_assoc()) $wcount = (int)$wr['c'];
        echo '<div class="mb-2 p-2 bg-yellow-50 border rounded">';
        echo '<strong>Debug:</strong> daily_class_summaries rows: ' . $dcount . ' &nbsp; weekly_class_summaries rows: ' . $wcount . '<br/>';
        // show a few recent rows for quick inspection
        $sampleD = $conn->query("SELECT class_name, summary_date, expected_total, received_total, updated_at FROM daily_class_summaries ORDER BY updated_at DESC LIMIT 5");
        if ($sampleD && $sampleD->num_rows > 0) {
            echo '<div class="text-xs mt-1">Recent daily summaries:<ul>';
            while ($r = $sampleD->fetch_assoc()) {
                echo '<li>' . htmlspecialchars($r['class_name']) . ' - ' . htmlspecialchars($r['summary_date']) . ' expected: ' . number_format($r['expected_total'],2) . ' received: ' . number_format($r['received_total'],2) . ' ('.htmlspecialchars($r['updated_at']).')</li>';
            }
            echo '</ul></div>';
        }
        $sampleW = $conn->query("SELECT class_name, week_start, expected_total, received_total, updated_at FROM weekly_class_summaries ORDER BY updated_at DESC LIMIT 5");
        if ($sampleW && $sampleW->num_rows > 0) {
            echo '<div class="text-xs mt-1">Recent weekly summaries:<ul>';
            while ($r = $sampleW->fetch_assoc()) {
                echo '<li>' . htmlspecialchars($r['class_name']) . ' - ' . htmlspecialchars($r['week_start']) . ' expected: ' . number_format($r['expected_total'],2) . ' received: ' . number_format($r['received_total'],2) . ' ('.htmlspecialchars($r['updated_at']).')</li>';
            }
            echo '</ul></div>';
        }
        echo '</div>';
    }

    // show daily and weekly summary for selected class or list recent summaries for all classes
    if ($selected_class !== '') {
        // use direct queries (escaped) instead of prepared + get_result for compatibility
        $esc_class = $conn->real_escape_string($selected_class);
        $dqr = "SELECT summary_date, expected_total, received_total, updated_at FROM daily_class_summaries WHERE class_name = '" . $esc_class . "' ORDER BY summary_date DESC LIMIT 14";
        $dr = $conn->query($dqr);
        $daily = [];
        if ($dr) {
            $daily = $dr->fetch_all(MYSQLI_ASSOC);
        }

        $wqr = "SELECT week_start, expected_total, received_total, updated_at FROM weekly_class_summaries WHERE class_name = '" . $esc_class . "' ORDER BY week_start DESC LIMIT 12";
        $wr = $conn->query($wqr);
        $weekly = [];
        if ($wr) {
            $weekly = $wr->fetch_all(MYSQLI_ASSOC);
        }
    } else {
        $daily = [];
        $weekly = [];
    }
    ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
        <div class="bg-white dark:bg-gray-800 rounded p-3 shadow">
            <h4 class="font-semibold text-gray-800 dark:text-gray-200">Recent Daily Summaries</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead><tr><th class="text-xs sm:text-sm">Date</th><th class="text-xs sm:text-sm">Expected</th><th class="text-xs sm:text-sm">Received</th><th class="text-xs sm:text-sm">Updated</th></tr></thead>
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
        <div class="bg-white dark:bg-gray-800 rounded p-3 shadow">
            <h4 class="font-semibold text-gray-800 dark:text-gray-200">Recent Weekly Summaries</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead><tr><th class="text-xs sm:text-sm">Week Start</th><th class="text-xs sm:text-sm">Expected (week)</th><th class="text-xs sm:text-sm">Received (week)</th><th class="text-xs sm:text-sm">Updated</th></tr></thead>
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
