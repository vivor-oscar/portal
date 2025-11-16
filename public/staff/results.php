<?php
include 'include/side-bar.php';

$staff_username = $_SESSION['username'];
$staff_result = $conn->query("SELECT staff_id FROM staff WHERE username = '$staff_username'");
$staff_data = $staff_result->fetch_assoc();
$staff_id = $staff_data['staff_id'];

// Get assigned class
$class_query = $conn->query("
    SELECT c.class_name FROM staff_classes sc 
    JOIN class c ON sc.class_name = c.class_name
    WHERE sc.staff_id = '$staff_id'
");
$class_row = $class_query->fetch_assoc();
$class_name = $class_row ? $class_row['class_name'] : '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Terminal Report Sheet Generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
        }

        .page {
            width: 8.5in;
            height: 11in;
            padding: 0.4in;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input,
        select {
            outline: none;
            width: 100%;
        }

        input:focus,
        select:focus {
            border-bottom: 2px solid #3b82f6;
        }

        .grade-select {
            width: 50px;
        }

        .logo-placeholder,
        .student-photo {
            width: 128px;
            height: 128px;
            border: 2px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 200ms ease-in-out;
        }

        .logo-placeholder:hover,
        .student-photo:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }

        /* Dark mode support for hover */
        :is(.dark) .logo-placeholder:hover,
        :is(.dark) .student-photo:hover {
            border-color: #0ea5e9;
            background-color: rgba(14, 165, 233, 0.1);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <div class="flex min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100">
        <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 md:p-6 lg:p-8 overflow-x-hidden">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">Report Sheet Generator</h1>
                <p class="text-gray-600 dark:text-gray-400">Create and manage student terminal report sheets</p>
            </div>

            <div class="max-w-7xl mx-auto">

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
                    <!-- Header with Gradient -->
                    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 h-2"></div>

                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                <i class="fas fa-school text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">School Information</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">School Name</label>
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg font-bold text-gray-900 dark:text-white">ROYAL WEBSTERS ACADEMY</div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Address</label>
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white">P. O. BOX 139, BOADUA-E/R</div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Phone Number</label>
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white">TEL: 0244730220/0243261890</div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Email</label>
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white">info@webstersmontessori.com</div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Motto</label>
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg italic text-gray-900 dark:text-white">ACADEMIC EXCELLENCE</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                    <i class="fas fa-image text-blue-500 mr-2"></i>School Logo
                                </label>
                                <div class="logo-placeholder w-32 h-32 rounded-xl border-2 border-dashed border-blue-300 dark:border-blue-600 bg-blue-50 dark:bg-blue-900 cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors flex items-center justify-center" id="logoPlaceholder" onclick="document.getElementById('logoUpload').click()">
                                    <span class="text-center text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-cloud-upload-alt text-2xl block mb-2"></i>
                                        Click to upload
                                    </span>
                                </div>
                                <input type="file" id="logoUpload" accept="image/*" class="hidden" onchange="handleLogoUpload(event)">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                    <i class="fas fa-user-circle text-blue-500 mr-2"></i>Student Photo
                                </label>
                                <div class="student-photo w-32 h-32 rounded-xl border-2 border-dashed border-blue-300 dark:border-blue-600 bg-blue-50 dark:bg-blue-900 cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors flex items-center justify-center" id="studentPhotoPlaceholder" onclick="document.getElementById('studentPhotoUpload').click()">
                                    <span class="text-center text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-cloud-upload-alt text-2xl block mb-2"></i>
                                        Click to upload
                                    </span>
                                </div>
                                <input type="file" id="studentPhotoUpload" accept="image/*" class="hidden" onchange="handleStudentPhotoUpload(event)">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
                    <!-- Header with Gradient -->
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 h-2"></div>

                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                                <i class="fas fa-user-graduate text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Student Information</h2>
                        </div>

                        <!-- Personal Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-user text-purple-500 mr-2"></i>Student Name
                                </label>
                                <select id="studentName" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" onchange="onStudentSelected(this)">
                                    <option value="">-- Select a Student --</option>
                                    <?php
                                    // Query students for selected class
                                    if (!empty($class_name)) {
                                        $student_query = "SELECT s.student_id, s.first_name, s.last_name FROM students s WHERE s.class = '$class_name' ORDER BY s.first_name ASC";
                                        $students_result = $conn->query($student_query);
                                        if ($students_result && $students_result->num_rows > 0) {
                                            while ($s = $students_result->fetch_assoc()): ?>
                                                <option value="<?php echo htmlspecialchars($s['student_id']); ?>" data-student-name="<?php echo htmlspecialchars($s['first_name'] . ' ' . $s['last_name']); ?>">
                                                    <?php echo htmlspecialchars($s['first_name'] . ' ' . $s['last_name']); ?>
                                                </option>
                                    <?php endwhile;
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-id-card text-purple-500 mr-2"></i>Student ID
                                </label>
                                <input type="text" id="studentId" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="Auto-populated" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-list-ol text-purple-500 mr-2"></i>No. on Roll
                                </label>
                                <input type="text" id="rollNumber" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="Enter roll number">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-book text-purple-500 mr-2"></i>Form/Class
                                </label>
                                <input type="text" id="studentClass" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="Enter class">
                            </div>
                        </div>

                        <!-- Academic Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Term</label>
                                <input type="text" id="term" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="Term 1/2/3">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Academic Year</label>
                                <input type="text" id="academicYear" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="2024/2025">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-calculator text-purple-500 mr-1"></i>Total Score
                                </label>
                                <input type="text" id="totalScore" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="Auto-calculated" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-chart-line text-purple-500 mr-1"></i>Aggregate
                                </label>
                                <input type="text" id="aggregate" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="Auto-calculated" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-position-top text-purple-500 mr-1"></i>Position
                                </label>
                                <input type="text" id="position" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="Enter position">
                            </div>
                        </div>

                        <!-- Date & Additional Info Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-calendar-alt text-purple-500 mr-2"></i>Term Closing Date
                                </label>
                                <input type="date" id="termClosingDate" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-calendar-plus text-purple-500 mr-2"></i>Next Term Begins
                                </label>
                                <input type="date" id="nextTermBegins" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-check-circle text-purple-500 mr-2"></i>Attendance
                                </label>
                                <input type="text" id="attendance" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="Attendance record">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-arrow-right text-purple-500 mr-2"></i>Promoted To
                                </label>
                                <input type="text" id="promotedTo" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="Enter next class">
                            </div>
                        </div>

                        <!-- Behavioral Assessments Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-handshake text-purple-500 mr-2"></i>Conduct
                                </label>
                                <select id="conduct" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                                    <option value="">Select</option>
                                    <option value="Excellent">Excellent</option>
                                    <option value="Good">Good</option>
                                    <option value="Satisfactory">Satisfactory</option>
                                    <option value="Needs Improvement">Needs Improvement</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-face-smile text-purple-500 mr-2"></i>Attitude
                                </label>
                                <select id="attitude" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                                    <option value="">Select</option>
                                    <option value="Positive">Positive</option>
                                    <option value="Cooperative">Cooperative</option>
                                    <option value="Respectful">Respectful</option>
                                    <option value="Needs Improvement">Needs Improvement</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-star text-purple-500 mr-2"></i>Interest
                                </label>
                                <select id="interest" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                                    <option value="">Select</option>
                                    <option value="Academics">Academics</option>
                                    <option value="Sports">Sports</option>
                                    <option value="Arts">Arts</option>
                                    <option value="Technology">Technology</option>
                                </select>
                            </div>
                        </div>

                        <!-- Teacher Remarks -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-comment-dots text-purple-500 mr-2"></i>Class Teacher's Remarks
                            </label>
                            <textarea id="teacherRemarks" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="Enter teacher's remarks"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Navigation and Control Buttons -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden mb-8 p-6">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-book-reader text-purple-600 dark:text-purple-400 text-lg"></i>
                            <span id="pageCounter" class="text-lg font-semibold text-purple-700 dark:text-purple-300"></span>
                        </div>
                        <div class="flex flex-wrap gap-2 justify-center md:justify-end">
                            <button id="prevStudentBtn" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white font-medium rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                <i class="fas fa-arrow-left"></i>
                                Previous
                            </button>
                            <button id="nextStudentBtn" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-arrow-right"></i>
                                Next
                            </button>
                            <button id="saveAllBtn" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-save"></i>
                                Save All
                            </button>
                            <button id="clearDataBtn" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-trash-alt"></i>
                                Clear Data
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Subject Scores Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
                    <!-- Header with Gradient -->
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 h-2"></div>

                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center">
                                    <i class="fas fa-book text-emerald-600 dark:text-emerald-400"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Subject Scores</h2>
                            </div>
                            <button onclick="addSubjectRow()" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-plus"></i>
                                Add Subject
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white dark:bg-gray-800" id="subjectsTable">
                                <thead>
                                    <tr class="bg-gradient-to-r from-emerald-100 to-teal-100 dark:from-emerald-900 dark:to-teal-900">
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700">Subject</th>
                                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700">Class Score</th>
                                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700">Exam Score</th>
                                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700">Total</th>
                                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700">Grade</th>
                                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700">Position</th>
                                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700">Remarks</th>
                                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="subjectRows">
                                    <!-- Rows will be added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Generate PDF Button -->
                <div class="flex justify-center mb-12">
                    <button onclick="generatePDF()" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-lg shadow-lg transition-all duration-200 text-lg">
                        <i class="fas fa-file-pdf text-2xl"></i>
                        Generate Report Sheet
                    </button>
                </div>
            </div>

            <!-- Template for PDF generation -->
            <div id="pdfTemplate" style="background: white; font-family: 'Roboto', sans-serif; width: 8.5in; padding: 0.4in; display: none; color: #000;">
                <!-- Header Section -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 3px solid #000;">
                    <!-- School Logo -->
                    <div id="pdfLogoContainer" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <div style="color: #999; font-size: 12px;">School Logo</div>
                    </div>

                    <!-- School Information -->
                    <div style="text-align: center; flex: 1; padding: 0 20px;">
                        <h1 id="pdfSchoolName" style="font-size: 18px; font-weight: bold; margin: 0; text-transform: uppercase;">ROYAL WEBSTERS ACADEMY</h1>
                        <p id="pdfSchoolAddress" style="font-size: 11px; margin: 3px 0; color: #333;">P. O. BOX 139, BOADUA-E/R</p>
                        <p id="pdfSchoolContact" style="font-size: 11px; margin: 3px 0; color: #333;">TEL: 0244730220/0243261890</p>
                        <p id="pdfSchoolEmail" style="font-size: 11px; margin: 3px 0; color: #333;">info@webstersmontessori.com</p>
                        <p id="pdfSchoolMotto" style="font-size: 11px; margin: 5px 0 0; color: #555; font-style: italic;">ACADEMIC EXCELLENCE</p>
                    </div>

                    <!-- Student Photo -->
                    <div id="pdfStudentPhotoContainer" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; border: 2px solid #000; flex-shrink: 0;">
                        <div style="color: #999; font-size: 12px;">Student Photo</div>
                    </div>
                </div>

                <!-- Report Title -->
                <h2 style="text-align: center; font-size: 16px; font-weight: bold; text-transform: uppercase; margin: 15px 0; letter-spacing: 1px;">Student Terminal Report Sheet</h2>

                <!-- Student Information Grid -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; font-size: 11px;">
                    <div>
                        <span style="font-weight: bold; color: #333;">Name:</span><br />
                        <span id="pdfStudentName" style="font-weight: 600;"></span>
                    </div>
                    <div>
                        <span style="font-weight: bold; color: #333;">No. on Roll:</span><br />
                        <span id="pdfRollNumber"></span>
                    </div>
                    <div>
                        <span style="font-weight: bold; color: #333;">Class:</span><br />
                        <span id="pdfStudentClass"></span>
                    </div>
                    <div>
                        <span style="font-weight: bold; color: #333;">Term:</span><br />
                        <span id="pdfTerm"></span>
                    </div>
                    <div>
                        <span style="font-weight: bold; color: #333;">Total Score:</span><br />
                        <span id="pdfTotalScore" style="font-weight: 600; color: #0066cc;"></span>
                    </div>
                    <div>
                        <span style="font-weight: bold; color: #333;">Academic Year:</span><br />
                        <span id="pdfAcademicYear"></span>
                    </div>
                    <div>
                        <span style="font-weight: bold; color: #333;">Position:</span><br />
                        <span id="pdfPosition" style="font-weight: 600;"></span>
                    </div>
                    <div>
                        <span style="font-weight: bold; color: #333;">Term Closing:</span><br />
                        <span id="pdfTermClosingDate" style="font-size: 10px;"></span>
                    </div>
                    <div>
                        <span style="font-weight: bold; color: #333;">Aggregate:</span><br />
                        <span id="pdfAggregate" style="font-weight: 600; color: #cc0000;"></span>
                    </div>
                    <div>
                        <span style="font-weight: bold; color: #333;">Next Term:</span><br />
                        <span id="pdfNextTermBegins" style="font-size: 10px;"></span>
                    </div>
                    <div>
                        <span style="font-weight: bold; color: #333;">Attendance:</span><br />
                        <span id="pdfAttendance"></span>
                    </div>
                    <div>
                        <span style="font-weight: bold; color: #333;">Promoted To:</span><br />
                        <span id="pdfPromotedTo"></span>
                    </div>
                </div>

                <!-- Subject Scores Table -->
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 10px;">
                    <thead>
                        <tr style="background-color: #e0e0e0;">
                            <th style="border: 1px solid #333; padding: 6px; text-align: left; font-weight: bold;">SUBJECT</th>
                            <th style="border: 1px solid #333; padding: 6px; text-align: center; font-weight: bold;">CLASS SCORE</th>
                            <th style="border: 1px solid #333; padding: 6px; text-align: center; font-weight: bold;">EXAM SCORE</th>
                            <th style="border: 1px solid #333; padding: 6px; text-align: center; font-weight: bold;">TOTAL</th>
                            <th style="border: 1px solid #333; padding: 6px; text-align: center; font-weight: bold;">GRADE</th>
                            <th style="border: 1px solid #333; padding: 6px; text-align: center; font-weight: bold;">POS.</th>
                            <th style="border: 1px solid #333; padding: 6px; text-align: left; font-weight: bold;">REMARKS</th>
                        </tr>
                    </thead>
                    <tbody id="pdfSubjectRows">
                        <!-- Subject rows will be inserted here -->
                    </tbody>
                </table>

                <!-- Behavioral Assessment -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px; font-size: 11px;">
                    <div>
                        <span style="font-weight: bold; color: #333;">Conduct:</span><br />
                        <span id="pdfConduct" style="font-weight: 600;"></span>
                    </div>
                    <div>
                        <span style="font-weight: bold; color: #333;">Attitude:</span><br />
                        <span id="pdfAttitude" style="font-weight: 600;"></span>
                    </div>
                    <div>
                        <span style="font-weight: bold; color: #333;">Interest:</span><br />
                        <span id="pdfInterest" style="font-weight: 600;"></span>
                    </div>
                </div>

                <!-- Teacher Remarks Section -->
                <div style="margin-bottom: 20px;">
                    <p style="font-weight: bold; font-size: 11px; margin-bottom: 5px; color: #333;">Class Teacher's Remarks:</p>
                    <div id="pdfTeacherRemarks" style="border-bottom: 1px solid #000; min-height: 30px; font-size: 10px; line-height: 1.5; padding-bottom: 5px;"></div>
                </div>

                <!-- Signature Section -->
                <div style="display: flex; justify-content: space-between; margin-top: 30px; font-size: 10px;">
                    <div style="text-align: center; width: 45%;">
                        <div style="border-top: 1px solid #000; padding-top: 5px; height: 40px;"></div>
                        <p style="margin: 0; font-weight: bold;">Class Teacher</p>
                        <p style="margin: 2px 0; font-size: 9px; color: #666;">Date: ___________</p>
                    </div>
                    <div style="text-align: center; width: 45%;">
                        <div style="border-top: 1px solid #000; padding-top: 5px; height: 40px;"></div>
                        <p style="margin: 0; font-weight: bold;">Head Teacher</p>
                        <p style="margin: 2px 0; font-size: 9px; color: #666;">Date: ___________</p>
                    </div>
                </div>

                <!-- Footer -->
                <div style="text-align: center; margin-top: 20px; padding-top: 10px; border-top: 1px solid #ccc; font-size: 8px; color: #999;">
                    <p style="margin: 0;">Generated Report Sheet - Confidential</p>
                </div>
            </div>

            <script>
                // Initialize jsPDF
                const {
                    jsPDF
                } = window.jspdf;

                // School logo and student photo variables
                let schoolLogo = null;
                let studentPhoto = null;

                // Handle student selection
                function onStudentSelected(selectElement) {
                    const studentId = selectElement.value;
                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                    const studentName = selectedOption.getAttribute('data-student-name') || '';
                    
                    // Populate student ID field
                    document.getElementById('studentId').value = studentId;
                    
                    // If you need to store the full name separately, uncomment:
                    // Populate the student name in the form for display in PDF
                    if (studentId && studentName) {
                        // You can set a display field if needed
                        // document.getElementById('studentDisplayName').value = studentName;
                    }
                }

                // Handle logo upload
                function handleLogoUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            schoolLogo = e.target.result;
                            document.getElementById('logoPlaceholder').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-contain">`;
                        };
                        reader.readAsDataURL(file);
                    }
                }

                // Handle student photo upload
                function handleStudentPhotoUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            studentPhoto = e.target.result;
                            document.getElementById('studentPhotoPlaceholder').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-contain">`;
                        };
                        reader.readAsDataURL(file);
                    }
                }

                // Add subject row with auto remarks
                function addSubjectRow(subject = '', classScore = '', examScore = '', grade = '', position = '', remarks = '') {
                    const row = document.createElement('tr');
                    row.className = 'subject-row border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200';
                    row.innerHTML = `
                <td class="py-3 px-4">
                    <input type="text" class="subject-name w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500" value="${subject}" placeholder="Subject name">
                </td>
                <td class="py-3 px-4 text-center">
                    <input type="number" class="class-score w-20 px-3 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white text-center focus:ring-2 focus:ring-emerald-500" value="${classScore}" placeholder="0" min="0" max="100" step="0.1" onchange="calculateTotalScore(this)">
                </td>
                <td class="py-3 px-4 text-center">
                    <input type="number" class="exam-score w-20 px-3 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white text-center focus:ring-2 focus:ring-emerald-500" value="${examScore}" placeholder="0" min="0" max="100" step="0.1" onchange="calculateTotalScore(this)">
                </td>
                <td class="py-3 px-4 text-center">
                    <input type="number" class="total-score w-20 px-3 py-2 rounded border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-center" placeholder="0" readonly>
                </td>
                <td class="py-3 px-4 text-center">
                    <select class="grade w-16 px-2 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white text-center focus:ring-2 focus:ring-emerald-500">
                        <option value="">-</option>
                        <option value="1" ${grade === '1' ? 'selected' : ''}>1</option>
                        <option value="2" ${grade === '2' ? 'selected' : ''}>2</option>
                        <option value="3" ${grade === '3' ? 'selected' : ''}>3</option>
                        <option value="4" ${grade === '4' ? 'selected' : ''}>4</option>
                        <option value="5" ${grade === '5' ? 'selected' : ''}>5</option>
                        <option value="6" ${grade === '6' ? 'selected' : ''}>6</option>
                        <option value="7" ${grade === '7' ? 'selected' : ''}>7</option>
                        <option value="8" ${grade === '8' ? 'selected' : ''}>8</option>
                        <option value="9" ${grade === '9' ? 'selected' : ''}>9</option>
                    </select>
                </td>
                <td class="py-3 px-4 text-center">
                    <input type="text" class="subject-position w-16 px-3 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white text-center focus:ring-2 focus:ring-emerald-500" value="${position}" placeholder="Pos">
                </td>
                <td class="py-3 px-4">
                    <input type="text" class="subject-remarks w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-emerald-500" value="${remarks}" placeholder="Auto" readonly>
                </td>
                <td class="py-3 px-4 text-center">
                    <button onclick="removeSubjectRow(this)" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-bold text-lg transition-colors">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
                    document.getElementById('subjectRows').appendChild(row);

                    // Calculate total and remarks if values exist
                    if (classScore !== '' && examScore !== '') {
                        calculateTotalScore(row.querySelector('.class-score'));
                    }
                }

                // Algorithm for remarks
                function getRemarks(total) {
                    if (total > 79) return "HIGHLY PROFICIENT";
                    if (total >= 68) return "PROFICIENT";
                    if (total >= 54) return "APPROACHING PROFICIENCY";
                    if (total >= 40) return "DEVELOPING";
                    if (total < 40) return "EMERGING";
                    return "0";
                }

                // Algorithm for grade
                function getGrade(total) {
                    if (total > 79) return "1";
                    if (total > 69) return "2";
                    if (total > 64) return "3";
                    if (total > 59) return "4";
                    if (total > 54) return "5";
                    if (total > 49) return "6";
                    if (total > 44) return "7";
                    if (total > 34) return "8";
                    if (total < 35) return "9";
                    return "";
                }

                // Calculate total score for a subject, auto remarks and grade
                function calculateTotalScore(input) {
                    const row = input.closest('tr');
                    const classScore = parseFloat(row.querySelector('.class-score').value) || 0;
                    const examScore = parseFloat(row.querySelector('.exam-score').value) || 0;
                    const totalScoreInput = row.querySelector('.total-score');
                    const remarksInput = row.querySelector('.subject-remarks');
                    const gradeSelect = row.querySelector('.grade');

                    const total = classScore + examScore;
                    totalScoreInput.value = total.toFixed(1);
                    remarksInput.value = getRemarks(total);
                    gradeSelect.value = getGrade(total);

                    updateOverallTotalScore();
                    calculateAggregate();
                }

                // Remove subject row
                function removeSubjectRow(button) {
                    const row = button.closest('tr');
                    row.remove();
                    updateOverallTotalScore();
                }

                // Update overall total score
                function updateOverallTotalScore() {
                    const totalScores = document.querySelectorAll('.total-score');
                    let overallTotal = 0;

                    totalScores.forEach(input => {
                        overallTotal += parseFloat(input.value) || 0;
                    });

                    document.getElementById('totalScore').value = overallTotal.toFixed(1);
                }

                // Calculate aggregate score
                function calculateAggregate() {
                    // Get all subject rows and their grades
                    const subjectRows = Array.from(document.querySelectorAll('.subject-row'));
                    let grades = [];

                    // Core subjects
                    const coreSubjects = ["ENGLISH LANGUAGE", "MATHEMATICS", "INT. SCIENCE", "SOCIAL STUDIES"];
                    let coreGrades = [];

                    subjectRows.forEach(row => {
                        const subjectName = (row.querySelector('.subject-name').value || '').trim().toUpperCase();
                        const grade = parseInt(row.querySelector('.grade').value, 10);

                        if (coreSubjects.includes(subjectName) && !isNaN(grade)) {
                            coreGrades.push({
                                subject: subjectName,
                                grade
                            });
                        } else if (!isNaN(grade)) {
                            grades.push({
                                subject: subjectName,
                                grade
                            });
                        }
                    });

                    // Sort other subjects by best grade (lowest number is best)
                    grades.sort((a, b) => a.grade - b.grade);

                    // Pick best two grades from non-core subjects
                    const bestTwo = grades.slice(0, 2).map(g => g.grade);

                    // Aggregate is sum of core grades + best two other grades
                    const aggregate = coreGrades.map(g => g.grade).reduce((a, b) => a + b, 0) + bestTwo.reduce((a, b) => a + b, 0);

                    document.getElementById('aggregate').value = aggregate || '';
                }

                // Handle student selection from dropdown
                function onStudentSelected() {
                    const studentNameSelect = document.getElementById('studentName');
                    const studentIdInput = document.getElementById('studentId');
                    const selectedOption = studentNameSelect.options[studentNameSelect.selectedIndex];

                    if (selectedOption && selectedOption.value) {
                        // Get student ID from data attribute
                        const studentId = selectedOption.getAttribute('data-student-id');
                        studentIdInput.value = studentId || '';
                    } else {
                        studentIdInput.value = '';
                    }
                }

                // Format date for display
                function formatDate(dateString) {
                    if (!dateString) return '';
                    const date = new Date(dateString);
                    const day = date.getDate();
                    const month = date.toLocaleString('default', {
                        month: 'long'
                    });
                    const year = date.getFullYear();

                    // Add ordinal suffix to day
                    let suffix = 'th';
                    if (day % 10 === 1 && day !== 11) {
                        suffix = 'st';
                    } else if (day % 10 === 2 && day !== 12) {
                        suffix = 'nd';
                    } else if (day % 10 === 3 && day !== 13) {
                        suffix = 'rd';
                    }

                    return `${day}${suffix} ${month}, ${year}`;
                }

                // Helper function to escape HTML
                function escapeHtml(text) {
                    const map = {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;'
                    };
                    return String(text).replace(/[&<>"']/g, m => map[m]);
                }

                // Generate PDF
                function generatePDF() {
                    // Populate the PDF template with explicit rendering
                    const fillPDFElement = (elementId, value) => {
                        const elem = document.getElementById(elementId);
                        if (elem) {
                            elem.textContent = value;
                            elem.innerText = value;
                        }
                    };

                    // Populate the PDF template
                    fillPDFElement('pdfSchoolName', 'ROYAL WEBSTERS ACADEMY');
                    fillPDFElement('pdfSchoolAddress', 'P. O. BOX 139, BOADUA-E/R');
                    fillPDFElement('pdfSchoolContact', 'TEL: 0244730220/0243261890');
                    fillPDFElement('pdfSchoolEmail', 'info@webstersmontessori.com');
                    fillPDFElement('pdfSchoolMotto', 'ACADEMIC EXCELLENCE');

                    // Add logo and student photo if available
                    const pdfLogoContainer = document.getElementById('pdfLogoContainer');
                    const pdfStudentPhotoContainer = document.getElementById('pdfStudentPhotoContainer');

                    if (schoolLogo) {
                        pdfLogoContainer.innerHTML = `<img src="${schoolLogo}" style="width: 100%; height: 100%; object-fit: contain;">`;
                    } else {
                        pdfLogoContainer.innerHTML = '<div style="color: #999; font-size: 12px;">School Logo</div>';
                    }

                    if (studentPhoto) {
                        pdfStudentPhotoContainer.innerHTML = `<img src="${studentPhoto}" style="width: 100%; height: 100%; object-fit: contain;">`;
                    } else {
                        pdfStudentPhotoContainer.innerHTML = '<div style="color: #999; font-size: 12px;">Student Photo</div>';
                    }

                    // Student information
                    // Get student name from the selected option's display text (not the value which is the ID)
                    const studentNameSelect = document.getElementById('studentName');
                    const selectedStudentOption = studentNameSelect.options[studentNameSelect.selectedIndex];
                    const displayStudentName = selectedStudentOption ? selectedStudentOption.textContent : 'Student Name';
                    
                    fillPDFElement('pdfStudentName', displayStudentName || 'Student Name');
                    fillPDFElement('pdfRollNumber', document.getElementById('rollNumber').value || '');
                    fillPDFElement('pdfStudentClass', document.getElementById('studentClass').value || '');
                    fillPDFElement('pdfTerm', document.getElementById('term').value || '');
                    fillPDFElement('pdfAcademicYear', document.getElementById('academicYear').value || '');
                    fillPDFElement('pdfTotalScore', document.getElementById('totalScore').value || '');
                    fillPDFElement('pdfPosition', document.getElementById('position').value || '');
                    fillPDFElement('pdfTermClosingDate', formatDate(document.getElementById('termClosingDate').value));
                    fillPDFElement('pdfAggregate', document.getElementById('aggregate').value || '');
                    fillPDFElement('pdfNextTermBegins', formatDate(document.getElementById('nextTermBegins').value));
                    fillPDFElement('pdfAttendance', document.getElementById('attendance').value || '');
                    fillPDFElement('pdfPromotedTo', document.getElementById('promotedTo').value || '');
                    fillPDFElement('pdfConduct', document.getElementById('conduct').value || '');
                    fillPDFElement('pdfAttitude', document.getElementById('attitude').value || '');
                    fillPDFElement('pdfInterest', document.getElementById('interest').value || '');
                    fillPDFElement('pdfTeacherRemarks', document.getElementById('teacherRemarks').value || '');

                    // Add subject rows
                    const pdfSubjectRows = document.getElementById('pdfSubjectRows');
                    pdfSubjectRows.innerHTML = '';

                    const subjectRows = document.querySelectorAll('.subject-row');
                    subjectRows.forEach(row => {
                        const subjectName = row.querySelector('.subject-name').value || '';
                        const classScore = row.querySelector('.class-score').value || '0';
                        const examScore = row.querySelector('.exam-score').value || '0';
                        const totalScore = row.querySelector('.total-score').value || '0';
                        const grade = row.querySelector('.grade').value || '';
                        const position = row.querySelector('.subject-position').value || '';
                        const remarks = row.querySelector('.subject-remarks').value || '';

                        if (subjectName) {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td style="border: 1px solid #333; padding: 6px; text-align: left; font-size: 10px; color: #000;">${escapeHtml(subjectName)}</td>
                                <td style="border: 1px solid #333; padding: 6px; text-align: center; background-color: #f9f9f9; font-size: 10px; color: #000;">${escapeHtml(classScore)}</td>
                                <td style="border: 1px solid #333; padding: 6px; text-align: center; background-color: #f9f9f9; font-size: 10px; color: #000;">${escapeHtml(examScore)}</td>
                                <td style="border: 1px solid #333; padding: 6px; text-align: center; font-weight: bold; background-color: #f0f0f0; font-size: 10px; color: #000;">${escapeHtml(totalScore)}</td>
                                <td style="border: 1px solid #333; padding: 6px; text-align: center; font-weight: bold; font-size: 10px; color: #000;">${escapeHtml(grade)}</td>
                                <td style="border: 1px solid #333; padding: 6px; text-align: center; font-size: 10px; color: #000;">${escapeHtml(position)}</td>
                                <td style="border: 1px solid #333; padding: 6px; text-align: left; font-size: 9px; color: #000;">${escapeHtml(remarks)}</td>
                            `;
                            pdfSubjectRows.appendChild(tr);
                        }
                    });

                    // Convert to PDF with better error handling and visibility
                    const pdfTemplate = document.getElementById('pdfTemplate');

                    // Make template visible and positioned properly for capture
                    pdfTemplate.style.display = 'block';
                    pdfTemplate.style.position = 'absolute';
                    pdfTemplate.style.left = '0';
                    pdfTemplate.style.top = '-10000px';
                    pdfTemplate.style.width = '8.5in';
                    pdfTemplate.style.zIndex = '9999';
                    pdfTemplate.style.backgroundColor = '#ffffff';

                    // Ensure all text is visible by checking computed styles
                    if (!document.body.contains(pdfTemplate)) {
                        document.body.appendChild(pdfTemplate);
                    }

                    // Small delay to ensure DOM is updated before capture
                    setTimeout(() => {
                        html2canvas(pdfTemplate, {
                            scale: 2,
                            logging: false,
                            useCORS: true,
                            allowTaint: true,
                            backgroundColor: '#ffffff',
                            windowWidth: 612,
                            windowHeight: 1200,
                            ignoreElements: (el) => {
                                // Ignore elements with hidden class
                                return el.classList && el.classList.contains('hidden');
                            }
                        }).then(canvas => {
                            try {
                                if (!canvas || canvas.width === 0 || canvas.height === 0) {
                                    throw new Error('Canvas generation failed');
                                }

                                const imgData = canvas.toDataURL('image/png');
                                const pdf = new jsPDF({
                                    orientation: 'portrait',
                                    unit: 'mm',
                                    format: 'a4'
                                });

                                const pageWidth = pdf.internal.pageSize.getWidth();
                                const pageHeight = pdf.internal.pageSize.getHeight();
                                const imgWidth = pageWidth;
                                const imgHeight = (canvas.height * pageWidth) / canvas.width;

                                pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);

                                // Handle multiple pages if needed
                                let heightLeft = imgHeight - pageHeight;
                                let position = pageHeight;

                                while (heightLeft >= 0) {
                                    position = heightLeft - pageHeight;
                                    pdf.addPage();
                                    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                                    heightLeft -= pageHeight;
                                }

                                // Get student name and ID for filename
                               const studentNameSelect = document.getElementById('studentName');
                                const selectedStudentOption = studentNameSelect.options[studentNameSelect.selectedIndex];
                                const studentName = (selectedStudentOption ? selectedStudentOption.textContent : 'Student').replace(/[^a-z0-9]/gi, ' ').trim();
                                const studentId = (studentNameSelect.value || 'ID').replace(/[^a-z0-9]/gi, '');
                                const filename = `${studentName}_${studentId}_ReportSheet.pdf`;

                                pdf.save(filename);

                                // Cleanup
                                pdfTemplate.style.display = 'none';
                                pdfTemplate.style.position = 'relative';
                                pdfTemplate.style.top = 'auto';
                                pdfTemplate.style.zIndex = 'auto';
                            } catch (error) {
                                console.error('PDF generation error:', error);
                                alert('Error generating PDF. Please try again.\n\nError: ' + error.message);
                                pdfTemplate.style.display = 'none';
                                pdfTemplate.style.position = 'relative';
                                pdfTemplate.style.zIndex = 'auto';
                            }
                        }).catch(error => {
                            console.error('Canvas conversion error:', error);
                            alert('Error converting template to image. Please try again.\n\nError: ' + error.message);
                            pdfTemplate.style.display = 'none';
                            pdfTemplate.style.position = 'relative';
                            pdfTemplate.style.zIndex = 'auto';
                        });
                    }, 200);
                }

                // Student data array and index
                let students = [];
                let currentStudentIndex = 0;

                // Fields to keep constant for all students
                const constantFields = [
                    'rollNumber', 'studentClass', 'term', 'academicYear',
                    'termClosingDate', 'nextTermBegins'
                ];

                // Save current student data
                function saveCurrentStudent() {
                    // Get all input values
                    const studentData = {};
                    const studentNameSelect = document.getElementById('studentName');
                    
                    // Store the selected student ID (value from select)
                    studentData.studentId = studentNameSelect.value;
                    // Store the display name from the selected option
                    const selectedOption = studentNameSelect.options[studentNameSelect.selectedIndex];
                    studentData.studentName = selectedOption.getAttribute('data-student-name') || selectedOption.textContent;
                    
                    constantFields.forEach(f => studentData[f] = document.getElementById(f).value);
                    studentData.totalScore = document.getElementById('totalScore').value;
                    studentData.aggregate = document.getElementById('aggregate').value;
                    studentData.position = document.getElementById('position').value;
                    studentData.attendance = document.getElementById('attendance').value;
                    studentData.promotedTo = document.getElementById('promotedTo').value;
                    studentData.conduct = document.getElementById('conduct').value;
                    studentData.attitude = document.getElementById('attitude').value;
                    studentData.interest = document.getElementById('interest').value;
                    studentData.teacherRemarks = document.getElementById('teacherRemarks').value;
                    studentData.subjects = [];

                    document.querySelectorAll('.subject-row').forEach(row => {
                        studentData.subjects.push({
                            subjectName: row.querySelector('.subject-name').value,
                            classScore: row.querySelector('.class-score').value,
                            examScore: row.querySelector('.exam-score').value,
                            totalScore: row.querySelector('.total-score').value,
                            grade: row.querySelector('.grade').value,
                            position: row.querySelector('.subject-position').value,
                            remarks: row.querySelector('.subject-remarks').value
                        });
                    });

                    students[currentStudentIndex] = studentData;
                }

                // Load student data into form
                function loadStudent(index) {
                    if (students[index]) {
                        const data = students[index];
                        // Set student name dropdown using the stored student ID
                        const studentNameSelect = document.getElementById('studentName');
                        studentNameSelect.value = data.studentId || '';
                        
                        // The student ID field will be auto-populated by onStudentSelected
                        // But since we're loading from storage, manually set it
                        document.getElementById('studentId').value = data.studentId || '';

                        constantFields.forEach(f => document.getElementById(f).value = data[f] || '');
                        document.getElementById('totalScore').value = data.totalScore || '';
                        document.getElementById('aggregate').value = data.aggregate || '';
                        document.getElementById('position').value = data.position || '';
                        document.getElementById('attendance').value = data.attendance || '';
                        document.getElementById('promotedTo').value = data.promotedTo || '';
                        document.getElementById('conduct').value = data.conduct || '';
                        document.getElementById('attitude').value = data.attitude || '';
                        document.getElementById('interest').value = data.interest || '';
                        document.getElementById('teacherRemarks').value = data.teacherRemarks || '';

                        // Clear and reload subjects
                        document.getElementById('subjectRows').innerHTML = '';
                        data.subjects.forEach(sub => {
                            addSubjectRow(
                                sub.subjectName,
                                sub.classScore,
                                sub.examScore,
                                sub.grade,
                                sub.position,
                                sub.remarks
                            );
                        });
                    } else {
                        // New student: clear name/id, keep constants
                        document.getElementById('studentName').value = '';
                        document.getElementById('studentId').value = '';
                        constantFields.forEach(f => {}); // keep as is
                        document.getElementById('totalScore').value = '';
                        document.getElementById('aggregate').value = '';
                        document.getElementById('position').value = '';
                        document.getElementById('attendance').value = '';
                        document.getElementById('promotedTo').value = '';
                        document.getElementById('conduct').value = '';
                        document.getElementById('attitude').value = '';
                        document.getElementById('interest').value = '';
                        document.getElementById('teacherRemarks').value = '';
                        document.getElementById('subjectRows').innerHTML = '';
                        // Add default subjects
                        const defaultSubjects = [
                            "ENGLISH LANGUAGE",
                            "MATHEMATICS",
                            "INT. SCIENCE",
                            "SOCIAL STUDIES",
                            "COMPUTING",
                            "AKUAPEM TWI",
                            "RELIGIOUS & MORAL EDU.",
                            "CAREER TECHNOLOGY",
                            "CREATIVE ARTS"
                        ];
                        defaultSubjects.forEach(sub => addSubjectRow(sub));
                    }
                    // Update navigation buttons
                    document.getElementById('prevStudentBtn').disabled = index === 0;
                    document.getElementById('nextStudentBtn').textContent = (students.length - 1 === index) ? 'Add Next Student' : 'Next Student';
                    updatePageCounter();
                }

                // Update page counter
                function updatePageCounter() {
                    document.getElementById('pageCounter').textContent =
                        `Student ${currentStudentIndex + 1} of ${students.length || 1}`;
                }

                // Next/Previous button handlers
                document.getElementById('nextStudentBtn').onclick = function() {
                    saveCurrentStudent();
                    currentStudentIndex++;
                    loadStudent(currentStudentIndex);
                };

                document.getElementById('prevStudentBtn').onclick = function() {
                    saveCurrentStudent();
                    if (currentStudentIndex > 0) currentStudentIndex--;
                    loadStudent(currentStudentIndex);
                };

                // Save all reports (generate PDFs for all students)
                document.getElementById('saveAllBtn').onclick = function() {
                    saveCurrentStudent();
                    students.forEach((student, idx) => {
                        // Fill form with student data
                        loadStudent(idx);
                        // Generate PDF for each student
                        setTimeout(() => generatePDF(), 500 * idx); // delay to allow DOM update
                    });
                };

                // Clear localStorage handler
                document.getElementById('clearDataBtn').onclick = function() {
                    if (confirm("Are you sure you want to delete all saved data?")) {
                        localStorage.removeItem('students');
                        localStorage.removeItem('currentStudentIndex');
                        students = [];
                        currentStudentIndex = 0;
                        loadStudent(0);
                        updatePageCounter();
                        alert("All saved data cleared.");
                    }
                };

                // Save to localStorage after every change
                function saveToLocalStorage() {
                    localStorage.setItem('students', JSON.stringify(students));
                    localStorage.setItem('currentStudentIndex', currentStudentIndex);
                }

                // Load from localStorage on page load
                window.onload = function() {
                    const savedStudents = localStorage.getItem('students');
                    const savedIndex = localStorage.getItem('currentStudentIndex');
                    if (savedStudents) {
                        students = JSON.parse(savedStudents);
                        currentStudentIndex = savedIndex ? parseInt(savedIndex, 10) : 0;
                    }
                    loadStudent(currentStudentIndex);
                    updatePageCounter();
                };

                // Call saveToLocalStorage after every change
                function saveCurrentStudent() {
                    // Get all input values
                    const studentData = {};
                    studentData.studentName = document.getElementById('studentName').value;
                    studentData.studentId = document.getElementById('studentId').value;
                    constantFields.forEach(f => studentData[f] = document.getElementById(f).value);
                    studentData.totalScore = document.getElementById('totalScore').value;
                    studentData.aggregate = document.getElementById('aggregate').value;
                    studentData.position = document.getElementById('position').value;
                    studentData.attendance = document.getElementById('attendance').value;
                    studentData.promotedTo = document.getElementById('promotedTo').value;
                    studentData.conduct = document.getElementById('conduct').value;
                    studentData.attitude = document.getElementById('attitude').value;
                    studentData.interest = document.getElementById('interest').value;
                    studentData.teacherRemarks = document.getElementById('teacherRemarks').value;
                    studentData.subjects = [];

                    document.querySelectorAll('.subject-row').forEach(row => {
                        studentData.subjects.push({
                            subjectName: row.querySelector('.subject-name').value,
                            classScore: row.querySelector('.class-score').value,
                            examScore: row.querySelector('.exam-score').value,
                            totalScore: row.querySelector('.total-score').value,
                            grade: row.querySelector('.grade').value,
                            position: row.querySelector('.subject-position').value,
                            remarks: row.querySelector('.subject-remarks').value
                        });
                    });

                    students[currentStudentIndex] = studentData;
                    saveToLocalStorage();
                }
                document.getElementById('nextStudentBtn').onclick = function() {
                    saveCurrentStudent();
                    currentStudentIndex++;
                    loadStudent(currentStudentIndex);
                    saveToLocalStorage();
                };
                document.getElementById('prevStudentBtn').onclick = function() {
                    saveCurrentStudent();
                    if (currentStudentIndex > 0) currentStudentIndex--;
                    loadStudent(currentStudentIndex);
                    saveToLocalStorage();
                };
                document.getElementById('saveAllBtn').onclick = function() {
                    saveCurrentStudent();
                    saveToLocalStorage();
                    students.forEach((student, idx) => {
                        loadStudent(idx);
                        setTimeout(() => generatePDF(), 500 * idx);
                    });
                };
            </script>
</body>

</html>