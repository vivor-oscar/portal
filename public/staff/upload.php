<?php
include 'include/side-bar.php';
include '../../includes/database.php';

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

$error = '';
$success = '';

if (!$class_row) {
  $error = "No class assigned to you.";
} else {
  $class_name = $class_row['class_name'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
    $target_dir = "../../resultroom/";
    $target_file = $target_dir . basename($_FILES['file']['name']);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_type = array("pdf", "png", "jpeg", "gif");
    if (!in_array($file_type, $allowed_type)) {
      $error = "Invalid file type. Only PDF, PNG, JPEG, and GIF are allowed.";
    } else {
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $student_id = $_REQUEST["student_id"];
        $filename = $_FILES["file"]["name"];
        $filesize = $_FILES["file"]["size"];
        $filetype = $_FILES["file"]["type"];
        include('../../includes/database.php');
        if ($conn->connect_error) {
          $error = "Connection failed: " . $conn->connect_error;
        }

        $sql = "INSERT INTO results (student_id, filename, filesize, filetype) VALUES ('$student_id', '$filename', $filesize, '$filetype')";
        if ($conn->query($sql) === TRUE) {
          // log upload
          if (file_exists(__DIR__ . '/../../includes/logger.php')) {
            include_once __DIR__ . '/../../includes/logger.php';
            session_start();
            $user_id = $_SESSION['staff_id'] ?? '';
            $username = $_SESSION['username'] ?? '';
            log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'staff', 'upload_result', "student={$student_id};file={$filename};size={$filesize}");
          }
          $success = "✓ File uploaded successfully! The student result has been saved.";
        } else {
          $error = "Database error: " . $conn->error;
        }
        //$conn->close();
      } else {
        $error = "Failed to upload file. Please try again.";
      }
    }
  } else {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $error = "Please select a file to upload.";
    }
  }
}
?>

<div class="flex min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100">
  <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 md:p-6 lg:p-8 overflow-x-hidden">
    <!-- Page Header -->
    <div class="mb-8">
      <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">Upload Student Results</h1>
      <p class="text-gray-600 dark:text-gray-400">Upload academic results for your assigned class</p>
    </div>

    <!-- Main Content -->
    <div class="max-w-3xl mx-auto">
      <!-- Alert Messages -->
      <?php if (!empty($error)): ?>
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-2xl flex items-start gap-3">
          <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-xl flex-shrink-0 mt-0.5"></i>
          <div>
            <p class="text-red-700 dark:text-red-300 font-medium"><?php echo htmlspecialchars($error); ?></p>
          </div>
        </div>
      <?php endif; ?>

      <?php if (!empty($success)): ?>
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-2xl flex items-start gap-3">
          <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl flex-shrink-0 mt-0.5"></i>
          <div>
            <p class="text-green-700 dark:text-green-300 font-medium"><?php echo htmlspecialchars($success); ?></p>
            <p class="text-sm text-green-600 dark:text-green-400 mt-1">The file has been added to the student's record.</p>
          </div>
        </div>
      <?php endif; ?>

      <!-- Main Form Card -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">
        <!-- Header with Gradient -->
        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 h-2"></div>

        <div class="p-8">
          <!-- Form Steps Indicator -->
          <div class="mb-8">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-bold">1</div>
                <span class="ml-2 text-sm font-semibold text-gray-900 dark:text-white">Select Student</span>
              </div>
              <div class="flex-1 h-1 bg-gray-300 dark:bg-gray-600 mx-4"></div>
              <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-300 font-bold">2</div>
                <span class="ml-2 text-sm font-semibold text-gray-600 dark:text-gray-300">Upload File</span>
              </div>
            </div>
          </div>

          <!-- Upload Form -->
          <form action="#" method="post" enctype="multipart/form-data" id="uploadForm" class="space-y-6">
            <!-- Student Selection -->
            <div>
              <div class="flex items-center gap-2 mb-3">
                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                  <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
                </div>
                <label for="student_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Select Student</label>
              </div>
              <select name="student_id" id="student_id" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                <option value="">-- Choose a student --</option>
                <?php
                // Query students for selected date
                if (!empty($class_name)) {
                  $student_query = "SELECT s.student_id, s.first_name, s.last_name FROM students s WHERE s.class = '$class_name' ORDER BY s.first_name ASC";
                  $students_result = $conn->query($student_query);
                  if ($students_result && $students_result->num_rows > 0) {
                    while ($s = $students_result->fetch_assoc()): ?>
                      <option value="<?php echo htmlspecialchars($s['student_id']); ?>">
                        <?php echo htmlspecialchars($s['first_name'] . ' ' . $s['last_name'] . ' (' . $s['student_id'] . ')'); ?>
                      </option>
                    <?php endwhile;
                  }
                }
                ?>
              </select>
              <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                <i class="fas fa-info-circle mr-1"></i>Showing students in your assigned class
              </p>
            </div>

            <!-- File Upload Section -->
            <div>
              <div class="flex items-center gap-2 mb-3">
                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                  <i class="fas fa-file-upload text-blue-600 dark:text-blue-400"></i>
                </div>
                <label for="file" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Select Result File</label>
              </div>

              <!-- File Input with Drag & Drop -->
              <div class="relative">
                <input type="file" name="file" id="file" required class="hidden" accept=".pdf,.png,.jpeg,.jpg,.gif">
                <label for="file" class="block p-6 border-2 border-dashed border-blue-300 dark:border-blue-600 rounded-lg bg-blue-50 dark:bg-blue-900 cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors duration-200 text-center" id="fileLabel">
                  <i class="fas fa-cloud-upload-alt text-3xl text-blue-600 dark:text-blue-400 mb-2"></i>
                  <p class="text-sm font-semibold text-gray-900 dark:text-white mt-2">Click to upload or drag and drop</p>
                  <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">PDF, PNG, JPEG, or GIF (Max 50MB)</p>
                </label>
                <div id="filePreview" class="mt-4 hidden">
                  <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center gap-3">
                      <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-100 to-cyan-100 dark:from-blue-900 dark:to-cyan-900 flex items-center justify-center">
                        <i class="fas fa-file-pdf text-2xl text-blue-600 dark:text-blue-400" id="fileIcon"></i>
                      </div>
                      <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white" id="fileName"></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400" id="fileSize"></p>
                      </div>
                      <button type="button" id="removeFile" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                        <i class="fas fa-times-circle text-xl"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <p class="mt-3 text-xs text-gray-600 dark:text-gray-400">
                <i class="fas fa-check-circle text-green-500 mr-1"></i>Accepted formats: PDF, PNG, JPEG, GIF
              </p>
            </div>

            <!-- Class Information -->
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900 dark:to-cyan-900 p-4 rounded-lg border border-blue-200 dark:border-blue-700">
              <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 mt-0.5"></i>
                <div>
                  <p class="text-sm font-semibold text-blue-900 dark:text-blue-100">Uploading for Class:</p>
                  <p class="text-sm text-blue-800 dark:text-blue-200 mt-1">
                    <strong><?php echo htmlspecialchars($class_name ?? 'Not assigned'); ?></strong>
                  </p>
                </div>
              </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
              <a href="javascript:history.back()" class="px-6 py-3 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 text-center">
                Cancel
              </a>
              <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-medium rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                <i class="fas fa-upload"></i>
                Upload Result
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- File Upload Guidelines -->
      <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Guide Card 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 p-6">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
              <i class="fas fa-check-double text-purple-600 dark:text-purple-400"></i>
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white">File Format</h3>
          </div>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            Use PDF for documents or PNG/JPEG for images. Ensure the file is clear and readable.
          </p>
        </div>

        <!-- Guide Card 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 p-6">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center">
              <i class="fas fa-database text-emerald-600 dark:text-emerald-400"></i>
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white">File Size</h3>
          </div>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            Keep files under 50MB. Compress images if needed to reduce file size.
          </p>
        </div>

        <!-- Guide Card 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 p-6">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-900 flex items-center justify-center">
              <i class="fas fa-shield-alt text-orange-600 dark:text-orange-400"></i>
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white">Security</h3>
          </div>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            All uploads are logged and secure. Files are stored safely in the system.
          </p>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- JavaScript for File Handling -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const fileInput = document.getElementById('file');
  const fileLabel = document.getElementById('fileLabel');
  const filePreview = document.getElementById('filePreview');
  const fileName = document.getElementById('fileName');
  const fileSize = document.getElementById('fileSize');
  const removeFile = document.getElementById('removeFile');
  const fileIcon = document.getElementById('fileIcon');

  // File icon mapping
  const getFileIcon = (extension) => {
    const icons = {
      'pdf': 'fas fa-file-pdf',
      'png': 'fas fa-image',
      'jpg': 'fas fa-image',
      'jpeg': 'fas fa-image',
      'gif': 'fas fa-image'
    };
    return icons[extension.toLowerCase()] || 'fas fa-file';
  };

  // Format file size
  const formatFileSize = (bytes) => {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i];
  };

  // Handle file selection
  fileInput.addEventListener('change', function(e) {
    const file = this.files[0];
    if (file) {
      const extension = file.name.split('.').pop();
      fileName.textContent = file.name;
      fileSize.textContent = formatFileSize(file.size);
      fileIcon.className = getFileIcon(extension) + ' text-2xl text-blue-600 dark:text-blue-400';
      filePreview.classList.remove('hidden');
      fileLabel.classList.add('hidden');
    }
  });

  // Handle file removal
  removeFile.addEventListener('click', function(e) {
    e.preventDefault();
    fileInput.value = '';
    filePreview.classList.add('hidden');
    fileLabel.classList.remove('hidden');
  });

  // Drag and drop handling
  fileLabel.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('bg-blue-200', 'dark:bg-blue-700');
  });

  fileLabel.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('bg-blue-200', 'dark:bg-blue-700');
  });

  fileLabel.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('bg-blue-200', 'dark:bg-blue-700');
    const files = e.dataTransfer.files;
    if (files.length > 0) {
      fileInput.files = files;
      const event = new Event('change', { bubbles: true });
      fileInput.dispatchEvent(event);
    }
  });
});
</script>