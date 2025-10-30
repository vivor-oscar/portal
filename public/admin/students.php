<?php

session_start();
error_reporting(0);

@ini_set('display_errors', 0);

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'administrator') {
  header("Location: ../../index.php");
  exit;
}

include('../../includes/database.php');

// Helper to build an absolute redirect URL for this script while preserving query params
function build_redirect_url($queryParams = []) {
  // Use SCRIPT_NAME (path to current script) to avoid including query string
  $script = $_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'];
  $host = $_SERVER['HTTP_HOST'] ?? '';
  // Determine scheme
  $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
  $url = $scheme . '://' . $host . $script;
  if (!empty($queryParams)) {
    $url .= '?' . http_build_query($queryParams);
  }
  return $url;
}

// Handle CSV Import
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['import_csv'])) {
  if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == UPLOAD_ERR_OK) {
    $fileName = $_FILES['csv_file']['tmp_name'];
    
    if ($_FILES['csv_file']['size'] > 0) {
      $file = fopen($fileName, "r");
      
      // Skip header row
      fgetcsv($file);
      
      $importSuccess = 0;
      $importErrors = 0;
      $errorMessages = [];
      
      while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
        // Validate required fields
        if (empty($column[0]) || empty($column[1]) || empty($column[2])) {
          $importErrors++;
          $errorMessages[] = "Row skipped: Missing required fields (Student ID, First Name, or Last Name)";
          continue;
        }
        
        $student_id = mysqli_real_escape_string($conn, $column[0]);
        $first_name = mysqli_real_escape_string($conn, $column[1]);
        $mid_name = mysqli_real_escape_string($conn, $column[2] ?? '');
        $last_name = mysqli_real_escape_string($conn, $column[3] ?? '');
        $class = mysqli_real_escape_string($conn, $column[4] ?? '');
        $email = mysqli_real_escape_string($conn, $column[5] ?? '');
        $number = mysqli_real_escape_string($conn, $column[6] ?? '');
        $curaddress = mysqli_real_escape_string($conn, $column[7] ?? '');
        $cityname = mysqli_real_escape_string($conn, $column[8] ?? '');
        $username = mysqli_real_escape_string($conn, $column[9] ?? $student_id);
        
        // Generate a default password (you might want to change this)
        $defaultPassword = password_hash('password123', PASSWORD_BCRYPT);
        
        // Check if student already exists
        $checkSql = "SELECT student_id FROM students WHERE student_id = '$student_id'";
        $result = mysqli_query($conn, $checkSql);
        
        if (mysqli_num_rows($result) > 0) {
          // Update existing student
          $sql = "UPDATE students SET 
                  first_name = '$first_name',
                  mid_name = '$mid_name', 
                  last_name = '$last_name',
                  class = '$class',
                  email = '$email',
                  number = '$number',
                  curaddress = '$curaddress',
                  cityname = '$cityname',
                  username = '$username'
                  WHERE student_id = '$student_id'";
        } else {
          // Insert new student
          $sql = "INSERT INTO students (student_id, first_name, mid_name, last_name, class, email, number, curaddress, cityname, username, password) 
                  VALUES ('$student_id', '$first_name', '$mid_name', '$last_name', '$class', '$email', '$number', '$curaddress', '$cityname', '$username', '$defaultPassword')";
        }
        
          if (mysqli_query($conn, $sql)) {
            $importSuccess++;
          } else {
            $importErrors++;
            $errorMessages[] = "Error with student ID $student_id: " . mysqli_error($conn);
          }
      }
      fclose($file);
      
      // Store import results in session to display
      $_SESSION['import_result'] = [
        'success' => $importSuccess,
        'errors' => $importErrors,
        'messages' => $errorMessages
      ];

      // Log import event
      if (file_exists(__DIR__ . '/../../includes/logger.php')) {
        require_once __DIR__ . '/../../includes/logger.php';
        session_start();
        $user_id = $_SESSION['admin_id'] ?? '';
        $username = $_SESSION['username'] ?? '';
        log_activity($conn, $user_id, $username, 'administrator', 'import_students', "imported={$importSuccess};errors={$importErrors}");
      }
      
      // Redirect to avoid form resubmission (prefer posted filter/page if available)
      $returnFilter = $_POST['filter_class'] ?? ($_GET['filter_class'] ?? '');
      $returnPage = isset($_POST['page']) ? (int)$_POST['page'] : (isset($_GET['page']) ? (int)$_GET['page'] : 1);
      $queryParams = [];
      if (!empty($returnFilter)) {
        $queryParams['filter_class'] = $returnFilter;
      }
      if ($returnPage > 1) {
        $queryParams['page'] = $returnPage;
      }
      header("Location: " . build_redirect_url($queryParams));
      exit;
    }
  } else {
    $_SESSION['import_result'] = [
      'success' => 0,
      'errors' => 1,
      'messages' => ['Please select a valid CSV file to upload.']
    ];
  }
}

// Pagination setup
$limit = 50;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Handle class filter
$classFilter = $_GET['filter_class'] ?? '';
$classWhere = $classFilter ? "WHERE class = '" . mysqli_real_escape_string($conn, $classFilter) . "'" : "";

// CSV Export
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="students.csv"');
  $output = fopen("php://output", "w");
  fputcsv($output, ['Student ID', 'First Name', 'Middle Name', 'Last Name', 'Class', 'Email', 'Phone', 'Current Address', 'City', 'Username']);
  $exportSql = "SELECT * FROM students $classWhere";
  $res = mysqli_query($conn, $exportSql);
  while ($row = mysqli_fetch_assoc($res)) {
    fputcsv($output, [
      $row['student_id'],
      $row['first_name'],
      $row['mid_name'],
      $row['last_name'],
      $row['class'],
      $row['email'],
      $row['number'],
      $row['curaddress'],
      $row['cityname'],
      $row['username']
    ]);
  }
  fclose($output);
  exit;
}

// Handle AJAX fetch for edit
if (isset($_GET['action']) && $_GET['action'] === 'fetch') {
  // Add validation to ensure ID is provided
  if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo "Student ID is required";
    exit;
  }
  
  $id = mysqli_real_escape_string($conn, $_GET['id']);
  $result = mysqli_query($conn, "SELECT * FROM students WHERE student_id='$id'");
  
  // Check if student exists
  if (mysqli_num_rows($result) === 0) {
    http_response_code(404);
    echo "Student not found";
    exit;
  }

  $row = mysqli_fetch_assoc($result);

  // Build curaddress select options and escape values
  $locations = array('Akwatia', 'Kade', 'Nkwatanang', 'Boadua', 'Bamenase', 'Apinamang', 'Topremang', 'Cayco');
  $optionsHtml = '<option value="">Select location</option>';
  foreach ($locations as $loc) {
    $sel = ($row['curaddress'] === $loc) ? ' selected' : '';
    $locEsc = htmlspecialchars($loc, ENT_QUOTES);
    $optionsHtml .= "<option value=\"$locEsc\"$sel>$locEsc</option>";
  }

  // Escape row values for safe HTML output
  $sid = htmlspecialchars($row['student_id'], ENT_QUOTES);
  $first = htmlspecialchars($row['first_name'], ENT_QUOTES);
  $mid = htmlspecialchars($row['mid_name'], ENT_QUOTES);
  $last = htmlspecialchars($row['last_name'], ENT_QUOTES);
  $num = htmlspecialchars($row['number'], ENT_QUOTES);
  $email = htmlspecialchars($row['email'], ENT_QUOTES);
  $classVal = htmlspecialchars($row['class'], ENT_QUOTES);
  $city = htmlspecialchars($row['cityname'], ENT_QUOTES);
  $usernameVal = htmlspecialchars($row['username'], ENT_QUOTES);

  // Build form action URL with current filter parameters
  $formAction = $_SERVER["PHP_SELF"];
  $queryParams = [];
  if (!empty($classFilter)) {
    $queryParams['filter_class'] = $classFilter;
  }
  if ($page > 1) {
    $queryParams['page'] = $page;
  }
  
  if (!empty($queryParams)) {
    $formAction .= '?' . http_build_query($queryParams);
  }
  echo '<form id="editForm" method="POST" action="' . htmlspecialchars($formAction) . '" class="space-y-4">'
    . '<input type="hidden" name="student_id" value="' . $sid . '">'
    // preserve current filter and page so postbacks return to same view
    . '<input type="hidden" name="filter_class" value="' . htmlspecialchars($classFilter, ENT_QUOTES) . '">'
    . '<input type="hidden" name="page" value="' . intval($page) . '">'
    . '<h3 class="text-lg font-semibold">Edit Student</h3>'
    . '<div class="grid md:grid-cols-3 gap-4">'
    . '<div><label class="block">First Name</label><input type="text" name="first_name" value="' . $first . '" class="w-full border rounded p-2"></div>'
    . '<div><label class="block">Middle Name</label><input type="text" name="mid_name" value="' . $mid . '" class="w-full border rounded p-2"></div>'
    . '<div><label class="block">Last Name</label><input type="text" name="last_name" value="' . $last . '" class="w-full border rounded p-2"></div>'
    . '<div><label class="block">Phone Number</label><input type="text" name="number" value="' . $num . '" class="w-full border rounded p-2"></div>'
    . '<div><label class="block">Email</label><input type="email" name="email" value="' . $email . '" class="w-full border rounded p-2"></div>'
    . '<div><label class="block">Class</label><input type="text" name="class" value="' . $classVal . '" class="w-full border rounded p-2"></div>'
    . '<div><label class="block">Current Address</label><select name="curaddress" class="w-full border rounded p-2">' . $optionsHtml . '</select></div>'
    . '<div><label class="block">Username</label><input type="text" name="username" value="' . $usernameVal . '" class="w-full border rounded p-2"></div>'
    . '<div><label class="block">Password</label><input type="password" name="password" class="w-full border rounded p-2"></div>'
    . '<div><label class="block">Confirm Password</label><input type="password" name="conpassword" class="w-full border rounded p-2"></div>'
    . '</div>'
    . '<div class="text-right"><button type="submit" name="update" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save Changes</button></div>'
    . '</form>';

  exit;
}

// Handle update request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
  $id = mysqli_real_escape_string($conn, $_POST['student_id']);
  $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
  $mid_name = mysqli_real_escape_string($conn, $_POST['mid_name']);
  $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
  $number = mysqli_real_escape_string($conn, $_POST['number']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $class = mysqli_real_escape_string($conn, $_POST['class']);
  $curaddress = mysqli_real_escape_string($conn, $_POST['curaddress']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = $_POST['password'];
  $conpassword = $_POST['conpassword'];

  $sql = "UPDATE students SET 
      first_name='$first_name',
      mid_name='$mid_name',
      last_name='$last_name',
      number='$number',
      email='$email',
      class='$class',
      curaddress='$curaddress',
      username='$username'";

  if (!empty($password) && !empty($conpassword)) {
    if ($password === $conpassword) {
      $hashPassword = password_hash($password, PASSWORD_BCRYPT);
      $sql .= ", password='$hashPassword'";
    } else {
      echo "Passwords do not match.";
      exit;
    }
  }

  $sql .= " WHERE student_id='$id'";
  if (mysqli_query($conn, $sql)) {
    // Build redirect URL with current filter parameters.
    // Prefer values posted from the edit form (so filtered page stays after update), fall back to GET.
    $returnFilter = isset($_POST['filter_class']) ? $_POST['filter_class'] : ($_GET['filter_class'] ?? '');
    $returnPage = isset($_POST['page']) ? (int)$_POST['page'] : (isset($_GET['page']) ? (int)$_GET['page'] : 1);

    // Build absolute redirect URL and preserve filter/page parameters
    $queryParams = [];
    if (!empty($returnFilter)) {
      $queryParams['filter_class'] = $returnFilter;
    }
    if ($returnPage > 1) {
      $queryParams['page'] = $returnPage;
    }
    $redirectUrl = build_redirect_url($queryParams);
    
    // log update
    if (file_exists(__DIR__ . '/../../includes/logger.php')) {
      require_once __DIR__ . '/../../includes/logger.php';
      session_start();
      $user_id = $_SESSION['admin_id'] ?? '';
      $username = $_SESSION['username'] ?? '';
      log_activity($conn, $user_id, $username, 'administrator', 'update_student', "student_id={$id}");
    }

    header("Location: " . $redirectUrl);
    exit();
  } else {
    echo "Error updating: " . mysqli_error($conn);
  }
}

// Handle multiple deletion - FIXED VERSION
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_selected'])) {
  $ids = $_POST['selected_students'] ?? [];
  if (!empty($ids)) {
    // Escape each ID and wrap in quotes for VARCHAR
    $escaped_ids = array_map(function ($id) use ($conn) {
      return "'" . mysqli_real_escape_string($conn, $id) . "'";
    }, $ids);

    $idList = implode(",", $escaped_ids);
    $deleteSql = "DELETE FROM students WHERE student_id IN ($idList)";

    if (mysqli_query($conn, $deleteSql)) {
      // Build redirect URL and prefer posted filter/page if available
      $returnFilter = $_POST['filter_class'] ?? $classFilter;
      $returnPage = isset($_POST['page']) ? (int)$_POST['page'] : $page;
      $queryParams = [];
      if (!empty($returnFilter)) {
        $queryParams['filter_class'] = $returnFilter;
      }
      if ($returnPage > 1) {
        $queryParams['page'] = $returnPage;
      }
      $redirectUrl = build_redirect_url($queryParams);
      
      // Log deletion action
      if (file_exists(__DIR__ . '/../../includes/logger.php')) {
        require_once __DIR__ . '/../../includes/logger.php';
        session_start();
        $user_id = $_SESSION['admin_id'] ?? '';
        $username = $_SESSION['username'] ?? '';
        log_activity($conn, $user_id, $username, 'administrator', 'delete_students', 'deleted_ids=' . $idList);
      }

      header("Location: " . $redirectUrl);
      exit;
    } else {
      echo "Error deleting records: " . mysqli_error($conn);
    }
  }
}
?>
<?php include('include/side-bar.php'); ?>

<body class="w-screen h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <div class="flex w-full h-full">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden overflow-y-auto">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
          <h2 class="text-[clamp(1.25rem,2.5vw,1.75rem)] font-bold text-gray-800 dark:text-white">
            Staff Management
          </h2>
          <p class="text-[clamp(0.85rem,1.5vw,1rem)] text-gray-500 dark:text-gray-400 mt-1">
            Manage all students
          </p>
        </div>

        <div class="flex flex-wrap gap-3 mt-4 md:mt-0">
          <!-- Import CSV Button -->
          <button onclick="document.getElementById('importModal').classList.remove('hidden')"
            class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition flex items-center text-[clamp(0.85rem,1.5vw,1rem)]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
            </svg>
            Import CSV
          </button>
          
          <button onclick="document.getElementById('studentFormModal').classList.remove('hidden')"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition flex items-center text-[clamp(0.85rem,1.5vw,1rem)]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            New Student
          </button>
        </div>
      </div>

      <!-- Display Import Results -->
      <?php if (isset($_SESSION['import_result'])): ?>
        <div class="mb-4 p-4 rounded-lg <?php echo $_SESSION['import_result']['errors'] > 0 ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200'; ?>">
          <h3 class="font-semibold">Import Results:</h3>
          <p>Successfully imported: <?php echo $_SESSION['import_result']['success']; ?> records</p>
          <p>Errors: <?php echo $_SESSION['import_result']['errors']; ?> records</p>
          <?php if (!empty($_SESSION['import_result']['messages'])): ?>
            <ul class="mt-2 text-sm">
              <?php foreach ($_SESSION['import_result']['messages'] as $message): ?>
                <li><?php echo htmlspecialchars($message); ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
        <?php unset($_SESSION['import_result']); ?>
      <?php endif; ?>

      <!-- Page Heading -->
      <h2 class="text-[clamp(1rem,2vw,1.75rem)] font-semibold mb-4 text-gray-800 dark:text-white">
        All Students
      </h2>

      <!-- Filter + Export -->
      <form method="GET" class="flex flex-wrap items-center gap-4 mb-4">
        <select name="filter_class" onchange="this.form.submit()"
          class="w-60 p-2 border rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-[clamp(0.75rem,1.5vw,1rem)]">
          <option value="">All Classes</option>
          <?php
          include('../../includes/database.php');
          $res = $conn->query("SELECT DISTINCT class_name FROM class");
          while ($row = $res->fetch_assoc()) {
            $selected = ($row['class_name'] === $classFilter) ? 'selected' : '';
            echo "<option value='{$row['class_name']}' $selected>{$row['class_name']}</option>";
          }
          ?>
        </select>
        <a href="?export=csv<?php echo $classFilter ? '&filter_class=' . $classFilter : ''; ?>"
          class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-[clamp(0.75rem,1.5vw,1rem)]">
          Export CSV
        </a>
        <a href="download_template.php" 
          class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-[clamp(0.75rem,1.5vw,1rem)]">
          Download Template
        </a>
      </form>

      <!-- Students Table -->
      <form method="POST" class="w-full">
        <input type="hidden" name="filter_class" value="<?php echo htmlspecialchars($classFilter, ENT_QUOTES); ?>">
        <input type="hidden" name="page" value="<?php echo intval($page); ?>">
        <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border-0 p-6 transition-all hover:shadow-lg hover:-translate-y-1 overflow-hidden">
          <div class="overflow-x-auto -mx-6 px-6">
            <table class="min-w-[900px] w-full text-left text-[clamp(0.75rem,1.5vw,1rem)]">
              <thead class="bg-gray-100 dark:bg-gray-900">
                <tr>
                  <th class="py-3 px-4"><input type="checkbox" id="select_all"></th>
                  <th class="py-3 px-4">#</th>
                  <th class="py-3 px-4">Full Name</th>
                  <th class="py-3 px-4">Class</th>
                  <th class="py-3 px-4">Status</th>
                  <th class="py-3 px-4">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT * FROM students $classWhere LIMIT $limit OFFSET $offset";
                $res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($res) > 0) {
                  $counter = ($page - 1) * $limit + 1;
                  while ($row = mysqli_fetch_assoc($res)) {
                    echo "<tr class='border-t dark:border-gray-700'>";
                    echo "<td class='py-2 px-4'><input type='checkbox' name='selected_students[]' value='{$row['student_id']}'></td>";
                    echo "<td class='py-2 px-4'>{$counter}</td>";
                    echo "<td class='py-2 px-4 text-gray-900 dark:text-gray-100'>{$row['first_name']} {$row['mid_name']} {$row['last_name']}</td>";
                    echo "<td class='py-2 px-4 text-gray-900 dark:text-gray-100'>{$row['class']}</td>";
                    echo "<td class='py-2 px-4 text-green-600 dark:text-green-400 font-medium'>Active</td>";
                    echo "<td class='py-2 px-4 flex gap-2'>
                          <a href='#' class='edit text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300' data-id='{$row['student_id']}' title='Edit'>
                            <i class='fas fa-edit'></i>
                          </a>
                          <a href='delete.php?table=students&id={$row['student_id']}' class='text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300' title='Delete'>
                            <i class='fas fa-trash-alt'></i>
                          </a>
                        </td>";
                    echo "</tr>";
                    $counter++;
                  }
                } else {
                  echo "<tr><td colspan='7' class='py-4 px-4 text-center text-gray-500 dark:text-gray-400'>No students found</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>

          <div class="mt-4">
            <button type="submit" name="delete_selected"
              class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 dark:hover:bg-red-800 text-[clamp(0.75rem,1.5vw,1rem)]">
              Delete Selected
            </button>
          </div>
        </section>
      </form>

      <?php
      $countRes = mysqli_query($conn, "SELECT COUNT(*) as total FROM students $classWhere");
      $totalRows = mysqli_fetch_assoc($countRes)['total'];
      $totalPages = ceil($totalRows / $limit);
      ?>

      <div class="mt-4 flex justify-center gap-2">
        <?php if ($page > 1): ?>
          <a href="?page=<?php echo $page - 1; ?><?php echo $classFilter ? '&filter_class=' . $classFilter : ''; ?>"
            class="px-3 py-1 bg-gray-300 hover:bg-gray-400 rounded">Previous</a>
        <?php endif; ?>

        <?php if ($page < $totalPages): ?>
          <a href="?page=<?php echo $page + 1; ?><?php echo $classFilter ? '&filter_class=' . $classFilter : ''; ?>"
            class="px-3 py-1 bg-gray-300 hover:bg-gray-400 rounded">Next</a>
        <?php endif; ?>
      </div>
    </main>

    <!-- Import Modal -->
    <div id="importModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center">
      <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-md p-6 relative">
        <button onclick="document.getElementById('importModal').classList.add('hidden')" 
          class="absolute top-3 right-3 text-gray-500 dark:text-gray-300 hover:text-black dark:hover:text-white text-xl">&times;</button>
        
        <h3 class="text-lg font-semibold mb-4">Import Students from CSV</h3>
        
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
          <input type="hidden" name="filter_class" value="<?php echo htmlspecialchars($classFilter, ENT_QUOTES); ?>">
          <input type="hidden" name="page" value="<?php echo intval($page); ?>">
          <div>
            <label class="block text-sm font-medium mb-2">Select CSV File</label>
            <input type="file" name="csv_file" accept=".csv" required
              class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
          </div>
          
          <div class="bg-blue-50 dark:bg-blue-900 p-3 rounded text-sm">
            <p class="font-semibold">CSV Format:</p>
            <p>Student ID, First Name, Middle Name, Last Name, Class, Email, Phone, Current Address, City, Username</p>
            <p class="mt-2"><strong>Note:</strong> Student ID, First Name, and Last Name are required.</p>
          </div>
          
          <div class="flex justify-end gap-3 mt-4">
            <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')"
              class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-400 dark:hover:bg-gray-500">
              Cancel
            </button>
            <button type="submit" name="import_csv"
              class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
              Import
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Edit Modal -->
    <div id="modal_container" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center">
      <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-3xl p-6 relative">
        <button id="close" class="absolute top-3 right-3 text-gray-500 dark:text-gray-300 hover:text-black dark:hover:text-white text-xl">&times;</button>
        <div id="modalContent">
          <!-- Content will be loaded here via AJAX -->
        </div>
      </div>
    </div>

    <script>
      $(function() {
        // Select all checkbox functionality
        $("#select_all").change(function() {
          $("input[name='selected_students[]']").prop('checked', $(this).prop("checked"));
        });

        $(".edit").click(function(e) {
          e.preventDefault();
          const studentId = $(this).data("id");
          $("#modal_container").removeClass("hidden");

          // Load the form via AJAX
          $.get("<?php echo $_SERVER['PHP_SELF']; ?>", {
            action: "fetch",
            id: studentId
          }, function(data) {
            $("#modalContent").html(data);
            // Apply dark mode classes to modal form elements
            $("#modalContent label").addClass("text-gray-700 dark:text-gray-200");
            $("#modalContent input, #modalContent select").addClass("bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700");
          }).fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response:", xhr.responseText);
            alert("Error loading student data. Please try again.");
          });
        });

        $("#close").click(() => $("#modal_container").addClass("hidden"));
      });
    </script>
</body>