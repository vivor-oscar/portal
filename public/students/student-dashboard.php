<?php include('include/side-bar.php'); ?>
<?php
include('../../includes/database.php');

$username = $_SESSION['username'];
$sql = "SELECT * FROM students WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($result);
?>

<div class="flex min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 md:p-6 lg:p-8 overflow-x-hidden">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400">Welcome back! Here's your academic overview.</p>
        </div>

        <!-- Main Grid Section -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
                <!-- Card Header with Gradient -->
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2"></div>
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Profile</h2>
                        <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                            <i class="fas fa-user text-purple-600 dark:text-purple-400"></i>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-start">
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Student ID</span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white bg-purple-50 dark:bg-purple-900 px-3 py-1 rounded-full"><?php echo htmlspecialchars($student['student_id']); ?></span>
                        </div>
                        
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-id-card text-purple-500"></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Full Name</span>
                            </div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white ml-6"><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></p>
                        </div>
                        
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-envelope text-purple-500"></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Email</span>
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-300 ml-6 break-all"><?php echo htmlspecialchars($student['email']); ?></p>
                        </div>
                        
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-book text-purple-500"></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Class</span>
                            </div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white ml-6"><?php echo htmlspecialchars($student['class']); ?></p>
                        </div>
                        
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-phone text-purple-500"></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Parent's Phone</span>
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-300 ml-6"><?php echo htmlspecialchars($student['parent_number']); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Overview Card -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
                <!-- Card Header with Gradient -->
                <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-2"></div>
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Recent Result</h2>
                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                            <i class="fas fa-chart-line text-blue-600 dark:text-blue-400"></i>
                        </div>
                    </div>
                    
                    <?php
                    $sql_result = "SELECT * FROM results WHERE student_id='{$student['student_id']}' ORDER BY upload_date DESC LIMIT 1";
                    $res_result = mysqli_query($conn, $sql_result);
                    if (mysqli_num_rows($res_result) > 0) {
                        $latest = mysqli_fetch_assoc($res_result);
                    ?>
                        <div class="space-y-4">
                            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900 dark:to-cyan-900 p-4 rounded-xl border border-blue-200 dark:border-blue-700">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-file-pdf text-blue-600 dark:text-blue-400"></i>
                                    <span class="text-xs font-semibold text-blue-700 dark:text-blue-300 uppercase tracking-wide">Result File</span>
                                </div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white break-all"><?php echo htmlspecialchars($latest['filename']); ?></p>
                            </div>
                            
                            <div class="flex items-center gap-2 text-sm">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                                <span class="text-gray-600 dark:text-gray-400">Uploaded on</span>
                                <span class="font-semibold text-gray-900 dark:text-white"><?php echo date('M d, Y', strtotime($latest['upload_date'])); ?></span>
                            </div>
                            
                            <a href="view-result.php" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-eye"></i>
                                View Full Results
                            </a>
                        </div>
                    <?php } else { ?>
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                                <i class="fas fa-inbox text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 font-medium">No results yet</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Your results will appear here once uploaded</p>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Notifications Card -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
                <!-- Card Header with Gradient -->
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-2"></div>
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Latest Notification</h2>
                        <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center">
                            <i class="fas fa-bell text-emerald-600 dark:text-emerald-400"></i>
                        </div>
                    </div>
                    
                    <?php
                    $sql_notify = "SELECT * FROM notifications ORDER BY created_at DESC LIMIT 1";
                    $not_result = mysqli_query($conn, $sql_notify);
                    if (mysqli_num_rows($not_result) > 0) {
                        $latest_notification = mysqli_fetch_assoc($not_result);
                    ?>
                        <div class="space-y-3">
                            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900 dark:to-teal-900 p-4 rounded-xl border border-emerald-200 dark:border-emerald-700">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-3 h-3 rounded-full bg-emerald-500 mt-1.5"></div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">New Notification</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">From: <span class="font-bold text-emerald-600 dark:text-emerald-400"><?php echo htmlspecialchars($latest_notification['sender_name']); ?></span></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2 text-sm">
                                <i class="fas fa-clock text-gray-400"></i>
                                <span class="text-gray-600 dark:text-gray-400">Created at</span>
                                <span class="font-semibold text-gray-900 dark:text-white"><?php echo date('M d, Y \a\t h:i A', strtotime($latest_notification['created_at'])); ?></span>
                            </div>
                            
                            <a href="notification.php" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-envelope-open"></i>
                                View All
                            </a>
                        </div>
                    <?php } else { ?>
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                                <i class="fas fa-check-circle text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 font-medium">All caught up!</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">You have no new notifications</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <!-- Quick Actions Section -->
        <section class="mt-12">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="view-result.php" class="group bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 hover:shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900 group-hover:bg-blue-500 flex items-center justify-center transition-colors duration-200">
                            <i class="fas fa-chart-bar text-blue-600 dark:text-blue-400 group-hover:text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">View Results</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Your academic scores</p>
                        </div>
                    </div>
                </a>

                <a href="notification.php" class="group bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-emerald-500 dark:hover:border-emerald-500 transition-all duration-200 hover:shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900 group-hover:bg-emerald-500 flex items-center justify-center transition-colors duration-200">
                            <i class="fas fa-bell text-emerald-600 dark:text-emerald-400 group-hover:text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Latest updates</p>
                        </div>
                    </div>
                </a>

                <a href="settings.php" class="group bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-orange-500 dark:hover:border-orange-500 transition-all duration-200 hover:shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-orange-100 dark:bg-orange-900 group-hover:bg-orange-500 flex items-center justify-center transition-colors duration-200">
                            <i class="fas fa-cog text-orange-600 dark:text-orange-400 group-hover:text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Settings</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Manage profile</p>
                        </div>
                    </div>
                </a>
            </div>
        </section>
    </main>
</div>

