<?php
// settings.php

// Include database connection
include('../../includes/database.php');

// --- Form Submission Handlers ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check which form was submitted using a hidden input
    $form_type = $_POST['form_type'] ?? '';

    // Handle School Details Update
    if ($form_type === 'school_details') {
        // Sanitize and validate input
        $school_name = mysqli_real_escape_string($conn, $_POST['school_name']);
        $type_of_institution = mysqli_real_escape_string($conn, $_POST['type_of_institution']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $enrollment_capacity = mysqli_real_escape_string($conn, $_POST['enrollment_capacity']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $facilities = mysqli_real_escape_string($conn, $_POST['facilities']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact']);
        $academic_year = mysqli_real_escape_string($conn, $_POST['academic_year']);

        // Use a prepared statement for security
        $update_sql = "UPDATE school_details SET 
            school_name = ?, 
            type_of_institution = ?, 
            address = ?, 
            facilities = ?, 
            email = ?, 
            contact = ?, 
            enrollment_capacity = ?, 
            academic_year = ? 
        WHERE id = 1"; // Assuming a single row for school details with id = 1

        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssss",
            $school_name,
            $type_of_institution,
            $address,
            $facilities,
            $email,
            $contact,
            $enrollment_capacity,
            $academic_year
        );

        if (mysqli_stmt_execute($stmt)) {
            $message = "School details updated successfully!";
            $alert_type = "success";
        } else {
            $message = "Error updating school details: " . mysqli_error($conn);
            $alert_type = "error";
        }

        mysqli_stmt_close($stmt);

        // Handle Add New Administrator
    } elseif ($form_type === 'add_administrator') {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Always hash passwords
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Use a prepared statement for security
        $insert_sql = "INSERT INTO administrator (name, username, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($stmt, "sss", $name, $username, $hashed_password);

        if (mysqli_stmt_execute($stmt)) {
            $message = "Administrator added successfully!";
            $alert_type = "success";
        } else {
            $message = "Error adding administrator: " . mysqli_error($conn);
            $alert_type = "error";
        }

        mysqli_stmt_close($stmt);
    }
}

// --- Data Retrieval ---
// Retrieve school details
$sql_school = "SELECT * FROM school_details WHERE id = 1";
$result_school = mysqli_query($conn, $sql_school);
$school_details = mysqli_fetch_assoc($result_school);

// Retrieve administrator details
$sql_admins = "SELECT * FROM administrator";
$result_admins = mysqli_query($conn, $sql_admins);
$administrators = mysqli_fetch_all($result_admins, MYSQLI_ASSOC);

?>
<?php include('include/side-bar.php') ?>
<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 sm:px-2 md:px-6 lg:px-8 xl:px-12 overflow-x-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white">System Settings</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Manage school information and administrator accounts</p>
        </div>

        <?php if (isset($message)): ?>
            <div class="p-4 mb-6 rounded-lg 
                <?php echo $alert_type === 'success' ? 'text-green-800 bg-green-50 dark:bg-green-900/30 dark:text-green-300' : 'text-red-800 bg-red-50 dark:bg-red-900/30 dark:text-red-300'; ?>" 
                role="alert">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 <?php echo $alert_type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'; ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $alert_type === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'; ?>" />
                    </svg>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- School Information Section -->
            <section class="col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-md border-0 p-6">
                <div class="flex items-center mb-6">
                    <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">School Information</h2>
                </div>
                
                <form method="POST" action="" enctype="multipart/form-data" class="space-y-6">
                    <input type="hidden" name="form_type" value="school_details">
                    
                    <div class="flex items-center gap-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-grow">
                            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">School Logo</label>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">JPG, PNG or GIF - Max 5MB</p>
                            <input type="file" name="image" class="block w-full text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50 transition-colors" />
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">School Name</label>
                            <input type="text" name="school_name" value="<?php echo htmlspecialchars($school_details['school_name']); ?>" class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-3 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">Type of Institution</label>
                            <input type="text" name="type_of_institution" value="<?php echo htmlspecialchars($school_details['type_of_institution']); ?>" class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-3 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">Address</label>
                            <input type="text" name="address" value="<?php echo htmlspecialchars($school_details['address']); ?>" class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-3 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">Enrollment Capacity</label>
                            <input type="number" name="enrollment_capacity" value="<?php echo htmlspecialchars($school_details['enrollment_capacity']); ?>" class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-3 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">Facilities</label>
                            <input type="text" name="facilities" value="<?php echo htmlspecialchars($school_details['facilities']); ?>" class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-3 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">Email</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($school_details['email']); ?>" class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-3 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">Contact</label>
                            <input type="text" name="contact" value="<?php echo htmlspecialchars($school_details['contact']); ?>" class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-3 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">Academic Year</label>
                            <input type="text" name="academic_year" value="<?php echo htmlspecialchars($school_details['academic_year']); ?>" class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-3 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm" />
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow-md transition flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save School Details
                        </button>
                    </div>
                </form>
            </section>

            <!-- Administrators Table Section -->
            <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border-0 p-6 h-fit">
                <div class="flex items-center mb-6">
                    <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Administrators</h2>
                </div>
                
                <div class="flex justify-between items-center mb-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Manage system administrators</p>
                    <button onclick="document.getElementById('adminFormModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg flex items-center transition shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Admin
                    </button>
                </div>
                
                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="py-3 px-4 text-left text-sm font-medium">Name</th>
                                <th class="py-3 px-4 text-left text-sm font-medium">Username</th>
                                <th class="py-3 px-4 text-center text-sm font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php if ($administrators): ?>
                                <?php foreach ($administrators as $admin): ?>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class='py-3 px-4 text-gray-800 dark:text-gray-100'><?php echo htmlspecialchars($admin['name']); ?></td>
                                        <td class='py-3 px-4 text-gray-800 dark:text-gray-100'><?php echo htmlspecialchars($admin['username']); ?></td>
                                        <td class='py-3 px-4 text-center'>
                                            <div class="flex justify-center space-x-2">
                                                <a href="#" onclick="document.getElementById('editAdminModal_<?php echo $admin['id']; ?>').classList.remove('hidden')" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 p-1 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/30 transition" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <a href="delete.php?table=administrator&id=<?php echo $admin['id']; ?>" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 p-1 rounded-full hover:bg-red-100 dark:hover:bg-red-900/30 transition" title="Delete" onclick="return confirm('Are you sure you want to delete this administrator?');">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan='3' class='py-6 px-4 text-center text-gray-500 dark:text-gray-300'>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 dark:text-gray-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        No administrators found
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>

    <!-- Modal for Add Admin -->
    <div id="adminFormModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity">
        <div class="relative top-20 mx-auto p-5 w-full max-w-md">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Add New Administrator</h3>
                </div>
                <div class="px-6 py-5">
                    <form method="POST" action="">
                        <input type="hidden" name="form_type" value="add_administrator">
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">Name</label>
                            <input type="text" name="name" required class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-3 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm" />
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">Username</label>
                            <input type="text" name="username" required class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-3 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm" />
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">Password</label>
                            <input type="password" name="password" required class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-3 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm" />
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg shadow-md transition">
                                Add Admin
                            </button>
                            <button type="button" onclick="document.getElementById('adminFormModal').classList.add('hidden')" class="flex-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium py-3 px-4 rounded-lg shadow-md transition">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 640px) {
            main {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
        }
    </style>
</div>