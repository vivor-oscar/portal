<?php
session_start();
error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../../logs/ad_error.log');
@ini_set('display_error', 0);
if (!isset($_SESSION['username']) && ($_SESSION['role'] !== 'administrator')) {
  header("Location:../../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Management - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#1e40af',
                        success: '#10b981',
                        warning: '#f59e0b',
                        danger: '#ef4444'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <i class="fas fa-chalkboard-teacher text-2xl text-primary mr-3"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Teacher Management System</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Admin</span>
                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold">A</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-primary mr-4">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Teachers</p>
                        <h3 class="text-2xl font-bold text-gray-900" id="totalTeachers">0</h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-success mr-4">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Trained Teachers</p>
                        <h3 class="text-2xl font-bold text-gray-900" id="trainedTeachers">0</h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-warning mr-4">
                        <i class="fas fa-book-reader text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Untrained Teachers</p>
                        <h3 class="text-2xl font-bold text-gray-900" id="untrainedTeachers">0</h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                        <i class="fas fa-school text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Public Schools</p>
                        <h3 class="text-2xl font-bold text-gray-900" id="publicSchools">0</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers Table -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
                    <h2 class="text-lg font-semibold text-gray-800">All Teachers</h2>
                    <div class="flex space-x-3">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Search teachers..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button id="refreshBtn" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors">
                            <i class="fas fa-sync-alt mr-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Professional Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Registered</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="teachersTableBody" class="bg-white divide-y divide-gray-200">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="p-8 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
                <p class="mt-2 text-gray-600">Loading teachers data...</p>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden p-8 text-center">
                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">No teachers found</h3>
                <p class="text-gray-600">No teacher records available in the system.</p>
            </div>

            <!-- Pagination -->
            <div id="pagination" class="px-6 py-4 border-t border-gray-200 hidden">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <span id="showingFrom">0</span> to <span id="showingTo">0</span> of <span id="totalRecords">0</span> results
                    </div>
                    <div class="flex space-x-2">
                        <button id="prevPage" class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50">
                            Previous
                        </button>
                        <button id="nextPage" class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Teacher Details Modal -->
    <div id="teacherModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-800">Teacher Details</h3>
                <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="teacherDetails" class="p-6">
                <!-- Teacher details will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        let currentPage = 1;
        const teachersPerPage = 10;
        let allTeachers = [];
        let filteredTeachers = [];

        // Load teachers data
        async function loadTeachers() {
            showLoadingState();

            try {
                const response = await fetch('get_teachers.php');
                const data = await response.json();

                if (data.success) {
                    allTeachers = data.teachers;
                    filteredTeachers = [...allTeachers];
                    updateStats();
                    renderTeachersTable();
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                console.error('Error loading teachers:', error);
                showEmptyState('Failed to load teachers data.');
            }
        }

        // Update statistics
        function updateStats() {
            const total = allTeachers.length;
            const trained = allTeachers.filter(t => t.professional_status === 'Trained').length;
            const untrained = allTeachers.filter(t => t.professional_status === 'Untrained').length;
            const publicSchools = allTeachers.filter(t => t.school_status === 'Public').length;

            document.getElementById('totalTeachers').textContent = total;
            document.getElementById('trainedTeachers').textContent = trained;
            document.getElementById('untrainedTeachers').textContent = untrained;
            document.getElementById('publicSchools').textContent = publicSchools;
        }

        // Render teachers table
        function renderTeachersTable() {
            const tableBody = document.getElementById('teachersTableBody');
            const startIndex = (currentPage - 1) * teachersPerPage;
            const endIndex = startIndex + teachersPerPage;
            const teachersToShow = filteredTeachers.slice(startIndex, endIndex);

            if (teachersToShow.length === 0) {
                showEmptyState('No teachers match your search criteria.');
                return;
            }

            tableBody.innerHTML = teachersToShow.map(teacher => `
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-primary rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold">${teacher.first_name.charAt(0)}${teacher.surname.charAt(0)}</span>
                            </div>
                            <div class="ml-4">
                                <button onclick="showTeacherDetails(${teacher.id})" class="text-left">
                                    <div class="text-sm font-medium text-primary hover:text-secondary cursor-pointer">
                                        ${teacher.first_name} ${teacher.surname}
                                    </div>
                                </button>
                                <div class="text-sm text-gray-500">${teacher.teacher_code}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                            teacher.professional_status === 'Trained' 
                                ? 'bg-green-100 text-green-800' 
                                : 'bg-yellow-100 text-yellow-800'
                        }">
                            ${teacher.professional_status}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${teacher.school_status}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>${teacher.phone_number}</div>
                        <div class="text-gray-500">${teacher.email || 'No email'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${new Date(teacher.created_at).toLocaleDateString()}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="showTeacherDetails(${teacher.id})" class="text-primary hover:text-secondary mr-3">
                            <i class="fas fa-eye mr-1"></i>View
                        </button>
                        <button onclick="editTeacher(${teacher.id})" class="text-warning hover:text-orange-700 mr-3">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </button>
                        <button onclick="deleteTeacher(${teacher.id})" class="text-danger hover:text-red-700">
                            <i class="fas fa-trash mr-1"></i>Delete
                        </button>
                    </td>
                </tr>
            `).join('');

            hideLoadingState();
            updatePagination();
        }

        // Show teacher details
        async function showTeacherDetails(teacherId) {
            try {
                const response = await fetch(`get_teacher_details.php?id=${teacherId}`);
                const data = await response.json();

                if (data.success) {
                    displayTeacherDetails(data.teacher);
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                console.error('Error loading teacher details:', error);
                alert('Failed to load teacher details.');
            }
        }

        // Display teacher details in modal
        function displayTeacherDetails(teacher) {
            const modal = document.getElementById('teacherModal');
            const detailsContainer = document.getElementById('teacherDetails');

            // Format classes if available
            const classes = teacher.classes && teacher.classes.length > 0 ?
                teacher.classes.join(', ') :
                'None';

            detailsContainer.innerHTML = `
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-gray-800 border-b pb-2">Personal Information</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Teacher Code</label>
                                <p class="text-gray-900">${teacher.teacher_code}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Full Name</label>
                                <p class="text-gray-900">${teacher.first_name} ${teacher.surname} ${teacher.other_names || ''}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Date of Birth</label>
                                <p class="text-gray-900">${teacher.date_of_birth}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Sex</label>
                                <p class="text-gray-900">${teacher.sex}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Marital Status</label>
                                <p class="text-gray-900">${teacher.marital_status}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">SSNIT Number</label>
                                <p class="text-gray-900">${teacher.ssnit_number}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-gray-800 border-b pb-2">Contact Information</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Phone Number</label>
                                <p class="text-gray-900">${teacher.phone_number}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Email</label>
                                <p class="text-gray-900">${teacher.email || 'Not provided'}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">GH Card Number</label>
                                <p class="text-gray-900">${teacher.gh_card_number || 'Not provided'}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="space-y-4 lg:col-span-2">
                        <h4 class="text-lg font-semibold text-gray-800 border-b pb-2">Professional Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-600">School Status</label>
                                <p class="text-gray-900">${teacher.school_status}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Professional Status</label>
                                <p class="text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                                        teacher.professional_status === 'Trained' 
                                            ? 'bg-green-100 text-green-800' 
                                            : 'bg-yellow-100 text-yellow-800'
                                    }">
                                        ${teacher.professional_status}
                                    </span>
                                </p>
                            </div>
                            ${teacher.teacher_type ? `
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Teacher Type</label>
                                    <p class="text-gray-900">${teacher.teacher_type}</p>
                                </div>
                            ` : ''}
                            ${teacher.basic_level ? `
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Basic Level</label>
                                    <p class="text-gray-900">${teacher.basic_level}</p>
                                </div>
                            ` : ''}
                            ${teacher.basic_subject ? `
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Basic Subject</label>
                                    <p class="text-gray-900">${teacher.basic_subject}</p>
                                </div>
                            ` : ''}
                            ${teacher.mode_of_qualification ? `
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Mode of Qualification</label>
                                    <p class="text-gray-900">${teacher.mode_of_qualification}</p>
                                </div>
                            ` : ''}
                            ${teacher.academic_qualification ? `
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Academic Qualification</label>
                                    <p class="text-gray-900">${teacher.academic_qualification}</p>
                                </div>
                            ` : ''}
                            ${teacher.professional_certificate ? `
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Professional Certificate</label>
                                    <p class="text-gray-900">${teacher.professional_certificate}</p>
                                </div>
                            ` : ''}
                            <div class="md:col-span-2 lg:col-span-3">
                                <label class="text-sm font-medium text-gray-600">Classes</label>
                                <p class="text-gray-900">${classes}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            modal.classList.remove('hidden');
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();

            if (searchTerm.trim() === '') {
                filteredTeachers = [...allTeachers];
            } else {
                filteredTeachers = allTeachers.filter(teacher =>
                    teacher.first_name.toLowerCase().includes(searchTerm) ||
                    teacher.surname.toLowerCase().includes(searchTerm) ||
                    teacher.teacher_code.toLowerCase().includes(searchTerm) ||
                    teacher.phone_number.includes(searchTerm) ||
                    (teacher.email && teacher.email.toLowerCase().includes(searchTerm))
                );
            }

            currentPage = 1;
            renderTeachersTable();
        });

        // Pagination functions
        function updatePagination() {
            const pagination = document.getElementById('pagination');
            const totalPages = Math.ceil(filteredTeachers.length / teachersPerPage);

            if (totalPages > 1) {
                pagination.classList.remove('hidden');
                document.getElementById('showingFrom').textContent = ((currentPage - 1) * teachersPerPage) + 1;
                document.getElementById('showingTo').textContent = Math.min(currentPage * teachersPerPage, filteredTeachers.length);
                document.getElementById('totalRecords').textContent = filteredTeachers.length;

                document.getElementById('prevPage').disabled = currentPage === 1;
                document.getElementById('nextPage').disabled = currentPage === totalPages;
            } else {
                pagination.classList.add('hidden');
            }
        }

        document.getElementById('prevPage').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderTeachersTable();
            }
        });

        document.getElementById('nextPage').addEventListener('click', () => {
            const totalPages = Math.ceil(filteredTeachers.length / teachersPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderTeachersTable();
            }
        });

        // UI State Management
        function showLoadingState() {
            document.getElementById('loadingState').classList.remove('hidden');
            document.getElementById('emptyState').classList.add('hidden');
            document.getElementById('teachersTableBody').innerHTML = '';
            document.getElementById('pagination').classList.add('hidden');
        }

        function hideLoadingState() {
            document.getElementById('loadingState').classList.add('hidden');
        }

        function showEmptyState(message = 'No teachers found.') {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('emptyState').classList.remove('hidden');
            document.getElementById('emptyState').querySelector('h3').nextElementSibling.textContent = message;
            document.getElementById('teachersTableBody').innerHTML = '';
            document.getElementById('pagination').classList.add('hidden');
        }

        // Event Listeners
        document.getElementById('refreshBtn').addEventListener('click', loadTeachers);
        document.getElementById('closeModal').addEventListener('click', () => {
            document.getElementById('teacherModal').classList.add('hidden');
        });

        // Placeholder functions for edit and delete
        function editTeacher(teacherId) {
            alert(`Edit teacher with ID: ${teacherId} - This feature would open an edit form.`);
        }

        function deleteTeacher(teacherId) {
            if (confirm('Are you sure you want to delete this teacher? This action cannot be undone.')) {
                alert(`Delete teacher with ID: ${teacherId} - This would call a delete API.`);
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', loadTeachers);
    </script>
</body>

</html>