<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EMIS | Teacher's Registration</title>
  <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
  <link rel="manifest" href="../assets/favicon/site.webmanifest">
  <script src="https://cdn.tailwindcss.com"></script> 
  <script src="//unpkg.com/alpinejs" defer></script>
  <!-- Add this to your <head> if Font Awesome is not already included -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" /> -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#3b82f6',
            secondary: '#1e40af',
          }
        }
      }
    }
  </script>
</head>

<body class="bg-gray-100 min-h-screen py-8">
  <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary to-secondary text-white p-6">
      <h1 class="text-3xl font-bold">Education Management Information System</h1>
      <h5 class="text-2xl font-bold">EMIS | Teacher's Registration Page</h5>
      <p class="text-blue-100">Complete all required fields marked with *</p>
    </div>

    <!-- Form -->
    <form id="teacherForm" class="p-6" method="POST" action="process-forms.php">
      <!-- Personal Information Section -->
      <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Personal Information</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Teacher Code -->
          <div>
            <label for="teacherCode" class="block text-sm font-medium text-gray-700 mb-1">Teacher Code *</label>
            <input type="text" id="teacherCode" name="teacherCode" required placeholder="e.g ~ RW0000000001"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
          </div>

          <!-- School Status -->
          <div>
            <label for="schoolStatus" class="block text-sm font-medium text-gray-700 mb-1">School Status *</label>
            <select id="schoolStatus" name="schoolStatus" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
              <option value="" disabled selected>Select Status</option>
              <option value="Public">Public</option>
              <option value="Private">Private</option>
            </select>
          </div>

          <!-- First Name -->
          <div>
            <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
            <input type="text" id="firstName" name="firstName" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
          </div>

          <!-- Surname -->
          <div>
            <label for="surname" class="block text-sm font-medium text-gray-700 mb-1">Surname *</label>
            <input type="text" id="surname" name="surname" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
          </div>

          <!-- Other Names -->
          <div>
            <label for="otherNames" class="block text-sm font-medium text-gray-700 mb-1">Other Name(s)</label>
            <input type="text" id="otherNames" name="otherNames"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
          </div>

          <!-- Date of Birth -->
          <div>
            <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth *</label>
            <input type="date" id="dob" name="dob" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
          </div>

          <!-- Sex -->
          <div>
            <label for="sex" class="block text-sm font-medium text-gray-700 mb-1">Sex *</label>
            <select id="sex" name="sex" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
              <option value="" disabled selected>Select Sex</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>

          <!-- Marital Status -->
          <div>
            <label for="maritalStatus" class="block text-sm font-medium text-gray-700 mb-1">Marital Status *</label>
            <select id="maritalStatus" name="maritalStatus" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
              <option value="" disabled selected>Select Status</option>
              <option value="Single">Single</option>
              <option value="Married">Married</option>
              <option value="Divorced">Divorced</option>
              <option value="Widowed">Widowed</option>
            </select>
          </div>

          <!-- Phone Number -->
          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
            <input type="tel" id="phone" name="phone" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" id="email" name="email"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
          </div>

          <!-- GH Card Number -->
          <div>
            <label for="ghCard" class="block text-sm font-medium text-gray-700 mb-1">GH Card Number</label>
            <input type="text" id="ghCard" name="ghCard"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
          </div>

          <!-- SSNIT Number -->
          <div>
            <label for="ssnit" class="block text-sm font-medium text-gray-700 mb-1">SSNIT Number</label>
            <input type="text" id="ssnit" name="ssnit" 
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
          </div>
        </div>
      </div>

      <!-- Professional Information Section -->
      <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Professional Information</h2>

        <!-- Professional Status -->
        <div class="mb-6">
          <label for="profStatus" class="block text-sm font-medium text-gray-700 mb-1">Professional Status *</label>
          <div class="flex space-x-4">
            <label class="inline-flex items-center">
              <input type="radio" name="profStatus" value="Trained" class="form-radio text-primary" required>
              <span class="ml-2">Trained</span>
            </label>
            <label class="inline-flex items-center">
              <input type="radio" name="profStatus" value="Untrained" class="form-radio text-primary">
              <span class="ml-2">Untrained</span>
            </label>
          </div>
        </div>

        <!-- Dynamic Fields based on Professional Status -->
        <div id="trainedFields" class="hidden">
          <!-- Type of Teacher -->
          <div class="mb-6">
            <label for="teacherType" class="block text-sm font-medium text-gray-700 mb-1">Type of Teacher</label>
            <div class="flex space-x-4">
              <label class="inline-flex items-center">
                <input type="radio" name="teacherType" value="Class" class="form-radio text-primary">
                <span class="ml-2">Class</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="teacherType" value="Subject" class="form-radio text-primary">
                <span class="ml-2">Subject</span>
              </label>
            </div>
          </div>

          <!-- Dynamic Fields for Class/Subject -->
          <div id="classSubjectFields" class="hidden mb-6">
            <!-- Basic Level -->
            <div class="mb-4">
              <label for="basicLevel" class="block text-sm font-medium text-gray-700 mb-1">Basic Level</label>
              <select id="basicLevel" name="basicLevel"
                class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="" disabled selected>Select Basic Level</option>
                <option value="Creche/Nursery">Creche/Nursery</option>
                <option value="KG">KG</option>
                <option value="Primary">Primary</option>
                <option value="JHS">JHS</option>
              </select>
            </div>

            <!-- Basic Class Options -->
            <div id="basicClassOptions" class="hidden mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-1">Basic Class</label>
              <div id="classCheckboxes" class="grid grid-cols-2 md:grid-cols-3 gap-2"></div>
            </div>

            <!-- Basic Subject Options -->
            <div id="basicSubjectOptions" class="hidden mb-4">
              <label for="basicSubject" class="block text-sm font-medium text-gray-700 mb-1">Basic Subject</label>
              <select id="basicSubject" name="basicSubject"
                class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="" disabled selected>Select Subject</option>
                <option value="Mathematics">Mathematics</option>
                <option value="Science">Science</option>
                <option value="English Language">English Language</option>
                <option value="Computing">Computing</option>
                <option value="Creative Arts">Creative Arts</option>
                <option value="French">French</option>
                <option value="Career Tech">Career Tech</option>
                <option value="RME">RME</option>
                <option value="Twi">Twi</option>
              </select>
            </div>
          </div>

          <!-- Mode of Qualification -->
          <div class="mb-4">
            <label for="modeQualification" class="block text-sm font-medium text-gray-700 mb-1">Mode of Qualification</label>
            <select id="modeQualification" name="modeQualification"
              class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
              <option value="" disabled selected>Select Mode</option>
              <option value="College of Education">College of Education</option>
              <option value="Distance Education">Distance Education</option>
              <option value="Sandwich Programme">Sandwich Programme</option>
              <option value="University of Education">University of Education</option>
            </select>
          </div>

          <!-- Academic Qualification -->
          <div class="mb-4">
            <label for="academicQualification" class="block text-sm font-medium text-gray-700 mb-1">Academic Qualification</label>
            <select id="academicQualification" name="academicQualification"
              class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
              <option value="" disabled selected>Select Qualification</option>
              <option value="BECE">BECE</option>
              <option value="DEGREE">DEGREE</option>
              <option value="DIPLOMA">DIPLOMA</option>
              <option value="HND">HND</option>
              <option value="MASTERS DEGREE">MASTERS DEGREE</option>
              <option value="TECHNICIAN">TECHNICIAN</option>
              <option value="SSCE/WASSCE">SSCE/WASSCE</option>
              <option value="MSLC">MSLC</option>
              <option value="PHD">PHD</option>
              <option value="POST GRADUATE DEGREE">POST GRADUATE DEGREE</option>
              <option value="POST GRADUATE CERTIFICATE">POST GRADUATE CERTIFICATE</option>
              <option value="GCE A LEVEL">GCE A LEVEL</option>
              <option value="GCE O LEVEL">GCE O LEVEL</option>
            </select>
          </div>

          <!-- Professional Certificate -->
          <div class="mb-6">
            <label for="professionalCert" class="block text-sm font-medium text-gray-700 mb-1">Professional Certificate</label>
            <select id="professionalCert" name="professionalCert"
              class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
              <option value="" disabled selected>Select Certificate</option>
              <option value="CERT A">CERT A</option>
              <option value="DEGREE IN EDUCATION">DEGREE IN EDUCATION</option>
              <option value="DIPLOMA IN EDUCATION">DIPLOMA IN EDUCATION</option>
              <option value="MASTERS DEGREE IN EDUCATION">MASTERS DEGREE IN EDUCATION</option>
              <option value="PHD IN EDUCATION">PHD IN EDUCATION</option>
              <option value="POST GRADUATE CERTIFICATE IN EDUCATION">POST GRADUATE CERTIFICATE IN EDUCATION</option>
              <option value="POST GRADUATE DEGREE IN EDUCATION">POST GRADUATE DEGREE IN EDUCATION</option>
              <option value="OTHERS">OTHERS</option>
            </select>
          </div>
        </div>

        <div id="untrainedFields" class="hidden">
          <!-- Type of Teacher for Untrained -->
          <div class="mb-6">
            <label for="teacherTypeUntrained" class="block text-sm font-medium text-gray-700 mb-1">Type of Teacher</label>
            <div class="flex space-x-4">
              <label class="inline-flex items-center">
                <input type="radio" name="teacherTypeUntrained" value="Class" class="form-radio text-primary">
                <span class="ml-2">Class</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="teacherTypeUntrained" value="Subject" class="form-radio text-primary">
                <span class="ml-2">Subject</span>
              </label>
            </div>
          </div>

          <!-- Dynamic Fields for Class/Subject for Untrained -->
          <div id="classSubjectFieldsUntrained" class="hidden mb-6">
            <!-- Basic Level -->
            <div class="mb-4">
              <label for="basicLevelUntrained" class="block text-sm font-medium text-gray-700 mb-1">Basic Level</label>
              <select id="basicLevelUntrained" name="basicLevelUntrained"
                class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="" disabled selected>Select Basic Level</option>
                <option value="Creche/Nursery">Creche/Nursery</option>
                <option value="KG">KG</option>
                <option value="Primary">Primary</option>
                <option value="JHS">JHS</option>
              </select>
            </div>

            <!-- Basic Class Options -->
            <div id="basicClassOptionsUntrained" class="hidden mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-1">Basic Class</label>
              <div id="classCheckboxesUntrained" class="grid grid-cols-2 md:grid-cols-3 gap-2"></div>
            </div>

            <!-- Basic Subject Options -->
            <div id="basicSubjectOptionsUntrained" class="hidden mb-4">
              <label for="basicSubjectUntrained" class="block text-sm font-medium text-gray-700 mb-1">Basic Subject</label>
              <select id="basicSubjectUntrained" name="basicSubjectUntrained"
                class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="" disabled selected>Select Subject</option>
                <option value="Mathematics">Mathematics</option>
                <option value="Science">Science</option>
                <option value="English Language">English Language</option>
                <option value="Computing">Computing</option>
                <option value="Creative Arts">Creative Arts</option>
                <option value="French">French</option>
                <option value="Career Tech">Career Tech</option>
                <option value="RME">RME</option>
                <option value="Twi">Twi</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-end space-x-4 pt-4 border-t">
        <button type="button" id="closeBtn" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
          Close
        </button>
        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors flex items-center">
          <i class="fas fa-save mr-2"></i> Save
        </button>
      </div>
    </form>
  </div>

  <script>
    // Professional Status Toggle
    document.querySelectorAll('input[name="profStatus"]').forEach(radio => {
      radio.addEventListener('change', function() {
        const trainedFields = document.getElementById('trainedFields');
        const untrainedFields = document.getElementById('untrainedFields');

        if (this.value === 'Trained') {
          trainedFields.classList.remove('hidden');
          untrainedFields.classList.add('hidden');
        } else if (this.value === 'Untrained') {
          trainedFields.classList.add('hidden');
          untrainedFields.classList.remove('hidden');
        }
      });
    });

    // Teacher Type Toggle for Trained
    document.querySelectorAll('input[name="teacherType"]').forEach(radio => {
      radio.addEventListener('change', function() {
        const classSubjectFields = document.getElementById('classSubjectFields');
        const basicClassOptions = document.getElementById('basicClassOptions');
        const basicSubjectOptions = document.getElementById('basicSubjectOptions');

        classSubjectFields.classList.remove('hidden');

        if (this.value === 'Class') {
          basicClassOptions.classList.remove('hidden');
          basicSubjectOptions.classList.add('hidden');
        } else if (this.value === 'Subject') {
          basicClassOptions.classList.add('hidden');
          basicSubjectOptions.classList.remove('hidden');
        }
      });
    });

    // Teacher Type Toggle for Untrained
    document.querySelectorAll('input[name="teacherTypeUntrained"]').forEach(radio => {
      radio.addEventListener('change', function() {
        const classSubjectFields = document.getElementById('classSubjectFieldsUntrained');
        const basicClassOptions = document.getElementById('basicClassOptionsUntrained');
        const basicSubjectOptions = document.getElementById('basicSubjectOptionsUntrained');

        classSubjectFields.classList.remove('hidden');

        if (this.value === 'Class') {
          basicClassOptions.classList.remove('hidden');
          basicSubjectOptions.classList.add('hidden');
        } else if (this.value === 'Subject') {
          basicClassOptions.classList.add('hidden');
          basicSubjectOptions.classList.remove('hidden');
        }
      });
    });

    // Basic Level Change for Trained
    document.getElementById('basicLevel').addEventListener('change', function() {
      const classCheckboxes = document.getElementById('classCheckboxes');
      classCheckboxes.innerHTML = '';

      let classes = [];

      switch (this.value) {
        case 'Creche/Nursery':
          classes = ['Creche/Nursery'];
          break;
        case 'KG':
          classes = ['KG1', 'KG2'];
          break;
        case 'Primary':
          classes = ['P1', 'P2', 'P3', 'P4', 'P5', 'P6'];
          break;
        case 'JHS':
          classes = ['JHS 1', 'JHS 2', 'JHS 3'];
          break;
      }

      classes.forEach(className => {
        const checkboxDiv = document.createElement('div');
        checkboxDiv.className = 'flex items-center';

        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = `class-${className.replace(/\s+/g, '-')}`;
        checkbox.name = 'basicClasses[]';
        checkbox.value = className;
        checkbox.className = 'mr-2 text-primary focus:ring-primary';

        const label = document.createElement('label');
        label.htmlFor = `class-${className.replace(/\s+/g, '-')}`;
        label.textContent = className;
        label.className = 'text-sm text-gray-700';

        checkboxDiv.appendChild(checkbox);
        checkboxDiv.appendChild(label);
        classCheckboxes.appendChild(checkboxDiv);
      });
    });

    // Basic Level Change for Untrained
    document.getElementById('basicLevelUntrained').addEventListener('change', function() {
      const classCheckboxes = document.getElementById('classCheckboxesUntrained');
      classCheckboxes.innerHTML = '';

      let classes = [];

      switch (this.value) {
        case 'Creche/Nursery':
          classes = ['Creche/Nursery'];
          break;
        case 'KG':
          classes = ['KG1', 'KG2'];
          break;
        case 'Primary':
          classes = ['P1', 'P2', 'P3', 'P4', 'P5', 'P6'];
          break;
        case 'JHS':
          classes = ['JHS 1', 'JHS 2', 'JHS 3'];
          break;
      }

      classes.forEach(className => {
        const checkboxDiv = document.createElement('div');
        checkboxDiv.className = 'flex items-center';

        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = `class-untrained-${className.replace(/\s+/g, '-')}`;
        checkbox.name = 'basicClassesUntrained[]';
        checkbox.value = className;
        checkbox.className = 'mr-2 text-primary focus:ring-primary';

        const label = document.createElement('label');
        label.htmlFor = `class-untrained-${className.replace(/\s+/g, '-')}`;
        label.textContent = className;
        label.className = 'text-sm text-gray-700';

        checkboxDiv.appendChild(checkbox);
        checkboxDiv.appendChild(label);
        classCheckboxes.appendChild(checkboxDiv);
      });
    });

    // Close button functionality
    document.getElementById('closeBtn').addEventListener('click', function() {
      if (confirm('Are you sure you want to close? Any unsaved changes will be lost.')) {
        window.location.href = 'staff-details.php';
      }
    });

    // Form submission
    document.getElementById('teacherForm').addEventListener('submit', function(e) {
      e.preventDefault();
      // Here you would typically send the form data to the server
      alert('Form submitted successfully!');
      // In a real application, you would use AJAX to submit the form
       this.submit(); 
    });
  </script>
</body>

</html>