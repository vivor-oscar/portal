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
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input, select {
            border-bottom: 1px solid #000;
            outline: none;
            width: 100%;
        }
        input:focus, select:focus {
            border-bottom: 2px solid #3b82f6;
        }
        .grade-select {
            width: 50px;
        }
        .logo-placeholder, .student-photo {
            width: 100px;
            height: 100px;
            border: 1px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .logo-placeholder:hover, .student-photo:hover {
            border-color: #3b82f6;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6 text-center">Student Terminal Report Sheet Generator</h1>
        
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4">School Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">School Name</label>
                    <div class="p-1 font-bold">ROYAL WEBSTERS ACADEMY</div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Address</label>
                    <div class="p-1">P. O. BOX 139, BOADUA-E/R</div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Phone Number</label>
                    <div class="p-1">TEL: 0244730220/0243261890</div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <div class="p-1">info@webstersmontessori.com</div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Motto</label>
                    <div class="p-1 italic">ACADEMIC EXCELLENCE</div>
                </div>
            </div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">School Logo</label>
                    <div class="logo-placeholder" id="logoPlaceholder" onclick="document.getElementById('logoUpload').click()">
                        <span class="text-gray-500">Click to upload logo</span>
                    </div>
                    <input type="file" id="logoUpload" accept="image/*" class="hidden" onchange="handleLogoUpload(event)">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Student Photo</label>
                    <div class="student-photo" id="studentPhotoPlaceholder" onclick="document.getElementById('studentPhotoUpload').click()">
                        <span class="text-gray-500">Click to upload photo</span>
                    </div>
                    <input type="file" id="studentPhotoUpload" accept="image/*" class="hidden" onchange="handleStudentPhotoUpload(event)">
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4">Student Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Student Name</label>
                    <input type="text" id="studentName" class="p-1" placeholder="Enter student name">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Student ID</label>
                    <input type="text" id="studentId" class="p-1" placeholder="Enter student ID">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">No. on Roll</label>
                    <input type="text" id="rollNumber" class="p-1" placeholder="Enter roll number">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Form/Class</label>
                    <input type="text" id="studentClass" class="p-1" placeholder="Enter class">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Term</label>
                    <input type="text" id="term" class="p-1" placeholder="Enter term">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Academic Year</label>
                    <input type="text" id="academicYear" class="p-1" placeholder="Enter academic year">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Total Score</label>
                    <input type="text" id="totalScore" class="p-1" placeholder="Auto-calculated" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Term Closing Date</label>
                    <input type="date" id="termClosingDate" class="p-1">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Next Term Begins</label>
                    <input type="date" id="nextTermBegins" class="p-1">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Aggregate</label>
                    <input type="text" id="aggregate" class="p-1" placeholder="Enter aggregate">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Position in Class</label>
                    <input type="text" id="position" class="p-1" placeholder="Enter position">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Attendance</label>
                    <input type="text" id="attendance" class="p-1" placeholder="Enter attendance">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Conduct</label>
                    <select id="conduct" class="p-1">
                        <option value="">Select</option>
                        <option value="Excellent">Excellent</option>
                        <option value="Good">Good</option>
                        <option value="Satisfactory">Satisfactory</option>
                        <option value="Needs Improvement">Needs Improvement</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Attitude</label>
                    <select id="attitude" class="p-1">
                        <option value="">Select</option>
                        <option value="Positive">Positive</option>
                        <option value="Cooperative">Cooperative</option>
                        <option value="Respectful">Respectful</option>
                        <option value="Needs Improvement">Needs Improvement</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Interest</label>
                    <select id="interest" class="p-1">
                        <option value="">Select</option>
                        <option value="Academics">Academics</option>
                        <option value="Sports">Sports</option>
                        <option value="Arts">Arts</option>
                        <option value="Technology">Technology</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Promoted To</label>
                    <input type="text" id="promotedTo" class="p-1" placeholder="Enter next class">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Class Teacher's Remarks</label>
                <textarea id="teacherRemarks" rows="2" class="w-full p-2 border rounded" placeholder="Enter teacher's remarks"></textarea>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4">Subject Scores</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white" id="subjectsTable">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border">Subject</th>
                            <th class="py-2 px-4 border">Class Score</th>
                            <th class="py-2 px-4 border">Exam Score</th>
                            <th class="py-2 px-4 border">Total Score</th>
                            <th class="py-2 px-4 border">Grade</th>
                            <th class="py-2 px-4 border">Position</th>
                            <th class="py-2 px-4 border">Remarks</th>
                            <th class="py-2 px-4 border">Action</th>
                        </tr>
                    </thead>
                    <tbody id="subjectRows">
                        <!-- Rows will be added here -->
                    </tbody>
                </table>
            </div>
            <button onclick="addSubjectRow()" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Subject</button>
        </div>
        
        <div class="flex justify-center">
            <button onclick="generatePDF()" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 text-lg font-semibold">Generate Report Sheet</button>
        </div>
    </div>
    
    <!-- Template for PDF generation -->
    <div id="pdfTemplate" class="page hidden">
        <div class="flex justify-between items-center mb-4">
            <div id="pdfLogoContainer" class="w-24 h-24 flex items-center justify-center">
                <!-- Logo will be inserted here -->
            </div>
            <div class="text-center">
                <h1 id="pdfSchoolName" class="text-xl font-bold uppercase"></h1>
                <p id="pdfSchoolAddress" class="text-sm"></p>
                <p id="pdfSchoolContact" class="text-sm"></p>
                <p id="pdfSchoolEmail" class="text-sm"></p>
                <p id="pdfSchoolMotto" class="text-sm italic text-center mt-1"></p>
            </div>
            <div id="pdfStudentPhotoContainer" class="w-24 h-24 flex items-center justify-center border">
                <!-- Student photo will be inserted here -->
            </div>
        </div>
        
        <hr class="border-t-2 border-black my-2">
        
        <h2 class="text-center text-lg font-bold uppercase my-2">STUDENT TERMINAL REPORT SHEET</h2>
        
        <div class="grid grid-cols-4 gap-2 mb-4 text-sm">
            <div><span class="font-semibold">Name:</span> <span id="pdfStudentName"></span></div>
            <div><span class="font-semibold">No. on Roll:</span> <span id="pdfRollNumber"></span></div>
            <div><span class="font-semibold">Class:</span> <span id="pdfStudentClass"></span></div>
            <div><span class="font-semibold">Term:</span> <span id="pdfTerm"></span></div>
            <div><span class="font-semibold">Total Score:</span> <span id="pdfTotalScore"></span></div>
            <div><span class="font-semibold">Academic Year:</span> <span id="pdfAcademicYear"></span></div>
            <div><span class="font-semibold">Position:</span> <span id="pdfPosition"></span></div>
            <div><span class="font-semibold">Term Closing On:</span> <span id="pdfTermClosingDate"></span></div>
            <div><span class="font-semibold">Aggregate:</span> <span id="pdfAggregate"></span></div>
            <div><span class="font-semibold">Next Term Begins:</span> <span id="pdfNextTermBegins"></span></div>
            <div><span class="font-semibold">Attendance:</span> <span id="pdfAttendance"></span></div>
            <div><span class="font-semibold">Promoted To:</span> <span id="pdfPromotedTo"></span></div>
        </div>
        
        <table class="w-full border-collapse border border-gray-400 mb-4 text-xs">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-400 py-1 px-2">SUBJECT</th>
                    <th class="border border-gray-400 py-1 px-2">CLASS SCORE</th>
                    <th class="border border-gray-400 py-1 px-2">EXAMS SCORE</th>
                    <th class="border border-gray-400 py-1 px-2">TOTAL SCORE</th>
                    <th class="border border-gray-400 py-1 px-2">GRADE</th>
                    <th class="border border-gray-400 py-1 px-2">POSITION</th>
                    <th class="border border-gray-400 py-1 px-2">REMARKS</th>
                </tr>
            </thead>
            <tbody id="pdfSubjectRows">
                <!-- Subject rows will be inserted here -->
            </tbody>
        </table>
        
        <div class="grid grid-cols-4 gap-2 mb-4 text-sm">
            <div><span class="font-semibold">Conduct:</span> <span id="pdfConduct"></span></div>
            <div><span class="font-semibold">Attitude:</span> <span id="pdfAttitude"></span></div>
            <div><span class="font-semibold">Interest:</span> <span id="pdfInterest"></span></div>
        </div>
        
        <div class="mb-4">
            <p class="font-semibold">Class Teacher's Remarks:</p>
            <p id="pdfTeacherRemarks" class="border-b border-black min-h-6"></p>
        </div>
        
        <div class="flex justify-between mt-8">
            <div class="text-center">
                <p class="border-t border-black pt-1 w-32 mx-auto">Class Teacher</p>
            </div>
            <div class="text-center">
                <p class="border-t border-black pt-1 w-32 mx-auto">Head Teacher</p>
            </div>
        </div>
    </div>

    <script>
        // Initialize jsPDF
        const { jsPDF } = window.jspdf;
        
        // School logo and student photo variables
        let schoolLogo = null;
        let studentPhoto = null;
        
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
            row.className = 'subject-row';
            row.innerHTML = `
                <td class="border py-2 px-4">
                    <input type="text" class="subject-name p-1" value="${subject}" placeholder="Subject name">
                </td>
                <td class="border py-2 px-4">
                    <input type="number" class="class-score p-1" value="${classScore}" placeholder="0" min="0" max="100" step="0.1" onchange="calculateTotalScore(this)">
                </td>
                <td class="border py-2 px-4">
                    <input type="number" class="exam-score p-1" value="${examScore}" placeholder="0" min="0" max="100" step="0.1" onchange="calculateTotalScore(this)">
                </td>
                <td class="border py-2 px-4">
                    <input type="number" class="total-score p-1" placeholder="0" readonly>
                </td>
                <td class="border py-2 px-4">
                    <select class="grade grade-select p-1">
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
                <td class="border py-2 px-4">
                    <input type="text" class="subject-position p-1" value="${position}" placeholder="Position">
                </td>
                <td class="border py-2 px-4">
                    <input type="text" class="subject-remarks p-1" value="${remarks}" placeholder="Auto" readonly>
                </td>
                <td class="border py-2 px-4 text-center">
                    <button onclick="removeSubjectRow(this)" class="text-red-500 hover:text-red-700">×</button>
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
        
        // Format date for display
        function formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            const day = date.getDate();
            const month = date.toLocaleString('default', { month: 'long' });
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
        
        // Generate PDF
        function generatePDF() {
            // Populate the PDF template
            document.getElementById('pdfSchoolName').textContent = 'ROYAL WEBSTERS ACADEMY';
            document.getElementById('pdfSchoolAddress').textContent = 'P. O. BOX 139, BOADUA-E/R';
            document.getElementById('pdfSchoolContact').textContent = 'TEL: 0244730220/0243261890';
            document.getElementById('pdfSchoolEmail').textContent = 'info@webstersmontessori.com';
            if (document.getElementById('pdfSchoolMotto')) {
                document.getElementById('pdfSchoolMotto').textContent = 'ACADEMIC EXCELLENCE';
            }
            
            // Add logo and student photo if available
            const pdfLogoContainer = document.getElementById('pdfLogoContainer');
            const pdfStudentPhotoContainer = document.getElementById('pdfStudentPhotoContainer');
            
            if (schoolLogo) {
                pdfLogoContainer.innerHTML = `<img src="${schoolLogo}" class="w-full h-full object-contain">`;
            } else {
                pdfLogoContainer.innerHTML = '<div class="text-gray-400 text-xs">School Logo</div>';
            }
            
            if (studentPhoto) {
                pdfStudentPhotoContainer.innerHTML = `<img src="${studentPhoto}" class="w-full h-full object-contain">`;
            } else {
                pdfStudentPhotoContainer.innerHTML = '<div class="text-gray-400 text-xs">Student Photo</div>';
            }
            
            // Student information
            document.getElementById('pdfStudentName').textContent = document.getElementById('studentName').value || 'Student Name';
            document.getElementById('pdfRollNumber').textContent = document.getElementById('rollNumber').value || '';
            document.getElementById('pdfStudentClass').textContent = document.getElementById('studentClass').value || '';
            document.getElementById('pdfTerm').textContent = document.getElementById('term').value || '';
            document.getElementById('pdfAcademicYear').textContent = document.getElementById('academicYear').value || '';
            document.getElementById('pdfTotalScore').textContent = document.getElementById('totalScore').value || '';
            document.getElementById('pdfPosition').textContent = document.getElementById('position').value || '';
            document.getElementById('pdfTermClosingDate').textContent = formatDate(document.getElementById('termClosingDate').value);
            document.getElementById('pdfAggregate').textContent = document.getElementById('aggregate').value || '';
            document.getElementById('pdfNextTermBegins').textContent = formatDate(document.getElementById('nextTermBegins').value);
            document.getElementById('pdfAttendance').textContent = document.getElementById('attendance').value || '';
            document.getElementById('pdfPromotedTo').textContent = document.getElementById('promotedTo').value || '';
            document.getElementById('pdfConduct').textContent = document.getElementById('conduct').value || '';
            document.getElementById('pdfAttitude').textContent = document.getElementById('attitude').value || '';
            document.getElementById('pdfInterest').textContent = document.getElementById('interest').value || '';
            document.getElementById('pdfTeacherRemarks').textContent = document.getElementById('teacherRemarks').value || '';
            
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
                        <td class="border border-gray-400 py-1 px-2">${subjectName}</td>
                        <td class="border border-gray-400 py-1 px-2 text-right">${classScore}</td>
                        <td class="border border-gray-400 py-1 px-2 text-right">${examScore}</td>
                        <td class="border border-gray-400 py-1 px-2 text-right">${totalScore}</td>
                        <td class="border border-gray-400 py-1 px-2 text-center">${grade}</td>
                        <td class="border border-gray-400 py-1 px-2 text-center">${position}</td>
                        <td class="border border-gray-400 py-1 px-2">${remarks}</td>
                    `;
                    pdfSubjectRows.appendChild(tr);
                }
            });
            
            // Convert to PDF
            const pdfTemplate = document.getElementById('pdfTemplate');
            pdfTemplate.classList.remove('hidden');
            
            html2canvas(pdfTemplate, {
                scale: 2,
                logging: false,
                useCORS: true,
                allowTaint: true
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF({
                    orientation: 'portrait',
                    unit: 'in',
                    format: 'letter'
                });
                
                const imgWidth = 8.5;
                const imgHeight = canvas.height * imgWidth / canvas.width;
                
                pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
                pdf.save('Student_Report_Sheet.pdf');
                
                pdfTemplate.classList.add('hidden');
            });
        }
        
        // Initialize with 9 default subjects
        window.onload = function() {
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
        };
    </script>
</body>
</html>