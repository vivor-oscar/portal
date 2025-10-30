<?php
// Include database connection
include '../../includes/database.php';

// Get all fee assignments with payment status
$feeStatusQuery = "
    SELECT 
        s.student_id, 
        s.first_name, 
        s.last_name, 
        s.class,
        s.email,
        fs.fee_id, 
        fs.fee_type, 
        fs.amount AS total_amount,
        fs.due_date,
        COALESCE(SUM(p.amount_paid), 0) AS amount_paid,
        (fs.amount - COALESCE(SUM(p.amount_paid), 0)) AS amount_remaining
    FROM students s
    JOIN fee_structures fs ON s.class = fs.class_name
    LEFT JOIN payments p ON p.student_id = s.student_id AND p.fee_id = fs.fee_id
    GROUP BY s.student_id, fs.fee_id
    HAVING amount_remaining > 0
    ORDER BY s.class, s.last_name, s.first_name
";

$feeStatusResult = $conn->query($feeStatusQuery);
$outstandingFees = [];
if ($feeStatusResult && $feeStatusResult->num_rows > 0) {
    $outstandingFees = $feeStatusResult->fetch_all(MYSQLI_ASSOC);
}
?>
<!-- Due Fee Reminders Tab -->
<div id="reminders" class="tab-content">
    <h2 class="text-lg sm:text-xl md:text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Due Fee Reminders</h2>

    <div class="mb-4">
        <div class="bg-yellow-100 dark:bg-yellow-900 border-l-4 border-yellow-500 dark:border-yellow-400 text-yellow-700 dark:text-yellow-100 p-4">
            <p class="font-bold">Note:</p>
            <p>This system displays outstanding balances. Green indicates fully paid, yellow indicates partial payments.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm sm:text-base">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Class</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Fee Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Total Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Amount Paid</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Amount Due</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <?php if (empty($outstandingFees)): ?>
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">No outstanding fees found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($outstandingFees as $fee):
                        $paymentPercentage = ($fee['amount_paid'] / $fee['total_amount']) * 100;
                        $statusClass = $paymentPercentage == 0 ? 'bg-red-100 text-red-800' : ($paymentPercentage < 100 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800');
                        $statusText = $paymentPercentage == 0 ? 'Unpaid' : ($paymentPercentage < 100 ? 'Partial' : 'Paid');
                    ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php echo htmlspecialchars($fee['first_name'] . ' ' . htmlspecialchars($fee['last_name'])); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($fee['class']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($fee['fee_type']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo number_format($fee['total_amount'], 2); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo number_format($fee['amount_paid'], 2); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                <?php echo number_format($fee['amount_remaining'], 2); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($fee['due_date']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo $statusClass; ?>">
                                    <?php echo $statusText; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="mailto:<?php echo $fee['email']; ?>?subject=Fee%20Reminder&body=Dear%20<?php echo urlencode($fee['first_name'] . ' ' . $fee['last_name']); ?>,%0D%0AYou%20have%20an%20outstanding%20fee%20of%20GHS%20<?php echo number_format($fee['amount_remaining'], 2); ?>.%0D%0AThank%20you."
                                    class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-envelope mr-1"></i>Reminder
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>