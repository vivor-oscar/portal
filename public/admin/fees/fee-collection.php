<?php

// Add this at the top of your file if not already present

include '../../includes/database.php';
//include 'get_students.php';



// Fetch payments with student and fee info

$payments_query = "SELECT p.*, s.first_name, s.last_name, fs.fee_type

                   FROM payments p

                   JOIN students s ON p.student_id = s.student_id

                   JOIN fee_structures fs ON p.fee_id = fs.fee_id

                   ORDER BY p.payment_date DESC";

$payments_result = $conn->query($payments_query);

$payments = [];

if ($payments_result && $payments_result->num_rows > 0) {

    $payments = $payments_result->fetch_all(MYSQLI_ASSOC);
}

?>
<!-- Add JS for dynamic student loading -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#class-options').on('change', function() {
        var className = $(this).val();
        $('#student-options').html('<option value="">Loading...</option>');
        if (className) {
            $.get('get_students.php', { class_name: className }, function(data) {
                var options = '<option value="">Select Student</option>';
                if (data.length > 0) {
                    $.each(data, function(i, student) {
                        options += '<option value="' + student.student_id + '">' + student.first_name + ' ' + student.last_name + '</option>';
                    });
                } else {
                    options += '<option value="">No students found</option>';
                }
                $('#student-options').html(options);
            }, 'json');
        } else {
            $('#student-options').html('<option value="">Select Student</option>');
        }
    });
});
</script>
<!-- Fee Collection Tab -->

<div id="fee-collection" class="tab-content">

    <h2 class="text-lg sm:text-xl md:text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Fee Collection</h2>



    <div class="mb-6">

        <h3 class="text-xl font-semibold mb-3">Collect Payment</h3>

        <form method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <input type="hidden" name="action" value="collect_fee">



            <!-- Class Dropdown -->

            <div>

                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Class</label>

                <select name="class_name" id="class-options" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm">

                    <option value="">Select Class</option>

                    <?php

                    // Fetch classes from database

                    $class_query = "SELECT class_id, class_name FROM class";

                    $class_result = $conn->query($class_query);



                    if ($class_result && $class_result->num_rows > 0) {

                        while ($class = $class_result->fetch_assoc()) {

                            echo '<option value="' . htmlspecialchars($class['class_name']) . '">' . htmlspecialchars($class['class_name']) . '</option>';

                        }

                    }

                    ?>

                </select>

            </div>



            <!-- Student Dropdown (populated by JS) -->

            <div>

                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Student</label>

                <select name="student_id" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm"

                    id="student-options">

                    <option value="">Select Student</option>

                </select>

            </div>



            <div>

                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fee Type</label>

                <select name="fee_id" required id="fee-options" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm">

                    <option value="">Select Fee</option>

                    <?php foreach ($feeStructures as $fee): ?>

                        <option value="<?php echo htmlspecialchars($fee['fee_id']); ?>">

                            <?php echo htmlspecialchars($fee['fee_type'] . ' (' . number_format($fee['amount'], 2) . ')'); ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>



            <div>

                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount Paid</label>

                <input type="number" name="amount_paid" step="0.01" required class="mt-1 pb-5 text-center block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm" >

            </div>



            <div>

                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method</label>

                <select name="payment_method" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm">

                    <option value="Cash">Cash</option>

                    <option value="Momo">Momo</option>

                    <option value="Cheque">Cheque</option>

                    <option value="Bank Transfer">Bank Transfer</option>

                </select>

            </div>



            <div class="md:col-span-4">

                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">

                    <i class="fas fa-money-bill-wave mr-2"></i>Record Payment

                </button>

            </div>

        </form>

    </div>



    <div>

        <h3 class="text-base sm:text-lg md:text-xl font-semibold mb-3 text-gray-800 dark:text-gray-200">Recent Payments</h3>

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm sm:text-base">

                <thead class="bg-gray-50 dark:bg-gray-900">

                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Receipt #</th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee Type</th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>

                    </tr>

                </thead>
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600">
                                <i class="fas fa-money-bill-wave mr-2"></i>Record Payment
                            </button>
                    <?php if (empty($payments)): ?>

                        <tr>

                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No payments found</td>

                        </tr>

                    <?php else: ?>

                        <?php foreach ($payments as $payment): ?>

                            <tr>

                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['receipt_number']); ?></td>

                                <td class="px-6 py-4 whitespace-nowrap">

                                    <?php echo htmlspecialchars($payment['first_name'] . ' ' . $payment['last_name']); ?>

                                </td>

                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['fee_type']); ?></td>

                                <td class="px-6 py-4 whitespace-nowrap">GHS <?php echo number_format($payment['amount_paid'], 2); ?></td>

                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['payment_method']); ?></td>

                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['payment_date']); ?></td>

                                <td class="px-6 py-4 whitespace-nowrap">

                                    <button onclick="printReceipt('<?php echo $payment['receipt_number']; ?>')"

                                        class="text-blue-600 hover:text-blue-900 mr-3">

                                        <i class="fas fa-print mr-1"></i>Print

                                    </button>

                                    <a href="?delete=payment&id=<?php echo $payment['payment_id']; ?>"

                                        class="text-red-600 hover:text-red-900"

                                        onclick="return confirm('Are you sure you want to delete this payment record?')">

                                        <i class="fas fa-trash mr-1"></i>Delete

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

