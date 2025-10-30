<?php
include('include/side-bar.php');

?>

<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">Overview</h1>
            <div class="flex items-center gap-3">
                <input type="search" id="adminSearch" placeholder="Search..." class="px-3 py-2 border rounded-md bg-white text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <a href="#" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-3 py-2 rounded-md text-sm shadow hover:bg-indigo-700">New Item</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Classes -->
            <section class="bg-white rounded-xl shadow p-4 dark:bg-gray-800 dark:shadow-none dark:border dark:border-gray-700">
                <header class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-pink-600">Classes</h2>
                </header>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr class="dark:bg-gray-700">
                                <th class="px-4 py-2 text-left font-medium text-gray-600">ID</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Name</th>
                                <th class="px-4 py-2 text-right font-medium text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:bg-gray-800 dark:divide-gray-700">
                            <?php
                            include('../../includes/database.php');
                            $sql = "SELECT * FROM class";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) :
                                while ($row = mysqli_fetch_assoc($result)) :
                            ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-gray-800 dark:text-gray-100"><?php echo htmlspecialchars($row['class_id']); ?></td>
                                        <td class="px-4 py-3 text-gray-800"><?php echo htmlspecialchars($row['class_name']); ?></td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="inline-flex gap-2 items-center justify-end">
                                                <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm">Edit</a>
                                                <form action="delete.php" method="post" onsubmit="return confirm('Delete this class?');" class="inline-block">
                                                    <input type="hidden" name="delete_type" value="class">
                                                    <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($row['class_id']); ?>">
                                                    <button type="submit" class="inline-flex items-center gap-2 px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                endwhile;
                            else :
                                ?>
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Subjects -->
            <section class="bg-white rounded-xl shadow p-4 dark:bg-gray-800 dark:shadow-none dark:border dark:border-gray-700">
                <header class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-blue-600">Subjects</h2>
                </header>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr class="dark:bg-gray-700">
                                <th class="px-4 py-2 text-left font-medium text-gray-600">ID</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Name</th>
                                <th class="px-4 py-2 text-right font-medium text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:bg-gray-800 dark:divide-gray-700">
                            <?php
                            $sql = "SELECT * FROM subjects";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) :
                                while ($row = mysqli_fetch_assoc($result)) :
                            ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-gray-800 dark:text-gray-100"><?php echo htmlspecialchars($row['subject_id']); ?></td>
                                        <td class="px-4 py-3 text-gray-800"><?php echo htmlspecialchars($row['subject_name']); ?></td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="inline-flex gap-2 items-center justify-end">
                                                <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm">Edit</a>
                                                <form action="delete.php" method="post" onsubmit="return confirm('Delete this subject?');" class="inline-block">
                                                    <input type="hidden" name="delete_type" value="subject">
                                                    <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($row['subject_id']); ?>">
                                                    <button type="submit" class="inline-flex items-center gap-2 px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                endwhile;
                            else :
                                ?>
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Tests (spans full width on large) -->
            <section class="lg:col-span-3 bg-white rounded-xl shadow p-4 dark:bg-gray-800 dark:shadow-none dark:border dark:border-gray-700">
                <header class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-pink-600">Tests</h2>
                </header>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr class="dark:bg-gray-700">
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Term</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Type</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Class</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Start</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">End</th>
                                <th class="px-4 py-2 text-right font-medium text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:bg-gray-800 dark:divide-gray-700">
                            <?php
                            $sql = "SELECT * FROM test";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) :
                                while ($row = mysqli_fetch_assoc($result)) :
                            ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-gray-800 dark:text-gray-100"><?php echo htmlspecialchars($row['term']); ?></td>
                                        <td class="px-4 py-3 text-gray-800"><?php echo htmlspecialchars($row['type']); ?></td>
                                        <td class="px-4 py-3 text-gray-800"><?php echo htmlspecialchars($row['class_nm']); ?></td>
                                        <td class="px-4 py-3 text-gray-800"><?php echo htmlspecialchars($row['start_date']); ?></td>
                                        <td class="px-4 py-3 text-gray-800"><?php echo htmlspecialchars($row['end_date']); ?></td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="inline-flex gap-2 items-center justify-end">
                                                <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm">Edit</a>
                                                <form action="delete.php" method="post" onsubmit="return confirm('Delete this test?');" class="inline-block">
                                                    <input type="hidden" name="delete_type" value="test">
                                                    <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($row['test_id'] ?? $row['test_id'] ?? ''); ?>">
                                                    <button type="submit" class="inline-flex items-center gap-2 px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                endwhile;
                            else :
                                ?>
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
    </body>
    <?php include('include/head.php'); ?>