
    <?php include('include/side-bar.php'); ?>
    <?php
    // Include database connection
    include('../../includes/database.php');

    // Fetch notifications relevant to the student
    $notifications_query = "
        SELECT message, sender_name, created_at
        FROM notifications
        WHERE target_role = 'all' OR target_role = 'student'
        ORDER BY created_at DESC;
    ";
    $notifications_result = $conn->query($notifications_query);
    $student_notifications = $notifications_result ? $notifications_result->fetch_all(MYSQLI_ASSOC) : [];
    ?>

    <div class="flex min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100">
        <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 md:p-6 lg:p-8 overflow-x-hidden">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">Notifications</h1>
                <p class="text-gray-600 dark:text-gray-400">Stay updated with the latest messages from your school</p>
            </div>

            <div class="max-w-4xl mx-auto">
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
                                        <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                            <i class="fas fa-clock"></i>
                                            <?php echo date('M d, Y', strtotime($notification['created_at'])); ?>
                                        </span>
                                    </div>

                                    <!-- Divider -->
                                    <div class="my-4 border-t border-gray-200 dark:border-gray-700"></div>

                                    <!-- Message Content -->
                                    <div class="mb-4">
                                        <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-wrap">
                                            <?php echo htmlspecialchars($notification['message']); ?>
                                        </p>
                                    </div>

                                    <!-- Timestamp -->
                                    <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-info-circle"></i>
                                        <span>Created at <?php echo date('h:i A', strtotime($notification['created_at'])); ?></span>
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
