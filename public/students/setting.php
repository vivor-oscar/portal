<?php
include('include/side-bar.php');
include('../../includes/database.php'); // Should set $conn = mysqli_connect(...);

$current_username = $_SESSION['username'];
$error = '';
$success = '';

// Fetch current student data
$query = "SELECT * FROM students WHERE username = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $current_username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);

if (!$student) {
    $error = "Student not found!";
} else {
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $first_name = trim($_POST['first_name']);
        $mid_name = trim($_POST['mid_name']);
        $last_name = trim($_POST['last_name']);
        $number = trim($_POST['number']);
        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $current_password = trim($_POST['current_password']);
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);

        // Validate current password if changing password
        if (!empty($new_password)) {
            if (!password_verify($current_password, $student['password'])) {
                $error = "Current password is incorrect";
            } elseif ($new_password !== $confirm_password) {
                $error = "New passwords do not match";
            } elseif (strlen($new_password) < 8) {
                $error = "Password must be at least 8 characters long";
            }
        }

        // Check if new username or email already exists (excluding current user)
        if (empty($error) && $username !== $current_username) {
            $query = "SELECT student_id FROM students WHERE username = ? AND student_id != ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "si", $username, $student['student_id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_fetch_assoc($result)) {
                $error = "Username already taken";
            }
        }

        if (empty($error) && $email !== $student['email']) {
            $query = "SELECT student_id FROM students WHERE email = ? AND student_id != ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "si", $email, $student['student_id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_fetch_assoc($result)) {
                $error = "Email already in use";
            }
        }

        // If no errors, update the record
        if (empty($error)) {
            $fields = "first_name=?, mid_name=?, last_name=?, number=?, email=?, username=?";
            $params = [$first_name, $mid_name, $last_name, $number, $email, $username];
            $types = "ssssss";

            if (!empty($new_password)) {
                $fields .= ", password=?";
                $params[] = password_hash($new_password, PASSWORD_BCRYPT);
                $types .= "s";
            }

            $params[] = $student['student_id'];
            $types .= "i";

            $query = "UPDATE students SET $fields WHERE student_id=?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, $types, ...$params);

            if (mysqli_stmt_execute($stmt)) {
                $success = "Profile updated successfully!";
                if ($username !== $current_username) {
                    $_SESSION['username'] = $username;
                }
                // Refresh student data
                $query = "SELECT * FROM students WHERE username = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $student = mysqli_fetch_assoc($result);
            } else {
                $error = "Error updating profile";
            }
        }
    }
}
?>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <div class="flex min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100">
        <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 md:p-6 lg:p-8 overflow-x-hidden">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">Settings</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage your profile and account preferences</p>
            </div>

            <div class="max-w-4xl mx-auto">
                <!-- Alert Messages -->
                <?php if (!empty($error)): ?>
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-2xl flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-xl"></i>
                        <p class="text-red-700 dark:text-red-300 text-sm font-medium"><?php echo htmlspecialchars($error); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-2xl flex items-center gap-3">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                        <p class="text-green-700 dark:text-green-300 text-sm font-medium"><?php echo htmlspecialchars($success); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Main Settings Form -->
                <form method="POST" class="space-y-6">
                    <!-- Personal Information Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2"></div>
                        
                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                                    <i class="fas fa-user text-purple-600 dark:text-purple-400"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Personal Information</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <!-- First Name -->
                                <div>
                                    <label for="first_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">First Name</label>
                                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name'] ?? ''); ?>"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                                </div>

                                <!-- Middle Name -->
                                <div>
                                    <label for="mid_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Middle Name</label>
                                    <input type="text" id="mid_name" name="mid_name" value="<?php echo htmlspecialchars($student['mid_name'] ?? ''); ?>"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                                </div>

                                <!-- Last Name -->
                                <div>
                                    <label for="last_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['last_name'] ?? ''); ?>"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-6">
                                <label for="number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-phone text-purple-500"></i>
                                    <input type="text" id="number" name="number" value="<?php echo htmlspecialchars($student['number'] ?? ''); ?>"
                                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-6">
                                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-envelope text-purple-500"></i>
                                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email'] ?? ''); ?>"
                                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" required>
                                </div>
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Username</label>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-at text-purple-500"></i>
                                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($student['username'] ?? ''); ?>"
                                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 h-2"></div>
                        
                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-900 flex items-center justify-center">
                                    <i class="fas fa-lock text-orange-600 dark:text-orange-400"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Change Password</h2>
                            </div>

                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Update your password to keep your account secure</p>

                            <!-- Current Password -->
                            <div class="mb-6">
                                <label for="current_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-key text-orange-500"></i>
                                    <input type="password" id="current_password" name="current_password"
                                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                                        placeholder="Enter your current password">
                                </div>
                            </div>

                            <!-- New Password -->
                            <div class="mb-6">
                                <label for="new_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-key text-orange-500"></i>
                                    <input type="password" id="new_password" name="new_password"
                                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                                        placeholder="Enter your new password">
                                </div>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 ml-10">Minimum 8 characters. Leave blank to keep current password</p>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-6">
                                <label for="confirm_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Confirm New Password</label>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-key text-orange-500"></i>
                                    <input type="password" id="confirm_password" name="confirm_password"
                                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                                        placeholder="Confirm your new password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-end">
                        <a href="student-dashboard.php" class="px-6 py-3 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 text-center">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-medium rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
<?php
include('include/head.php'); // Should include necessary head elements
?>