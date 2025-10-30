<?php include('include/side-bar.php'); ?>

<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
        <!-- TESTS CARD -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden md:col-span-2 lg:col-span-1">
            <div class="bg-pink-600 p-4">
                <h4 class="text-white font-bold">TESTS</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Term</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Class Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Start Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">End Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        include('../../includes/database.php');
                        $sql = "SELECT * FROM test";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $row['term'] . "</td>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $row['type'] . "</td>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $row['class_nm'] . "</td>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $row['start_date'] . "</td>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $row['end_date'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>
</main>
</body>