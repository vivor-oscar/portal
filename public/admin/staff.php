<?php

session_start();

error_reporting(0);

@ini_set('display_errors', 0);



if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'administrator') {

  header("Location: ../../index.php");

  exit;
}



include('../../includes/database.php');


// Process Assign Staff form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign_staff'])) {
  $staff_id = $conn->real_escape_string($_POST['staff_id']);
  $class_name = $conn->real_escape_string($_POST['class_name']);

  $sql = "INSERT INTO staff_classes (staff_id, class_name) 
        VALUES ('$staff_id', 
               (SELECT class_name FROM class WHERE class_name = '$class_name'))";

  if ($conn->query($sql)) {
    $assign_success = "Staff member successfully assigned to class!";
  } else {
    $assign_error = "Error assigning staff to class: " . $conn->error;
  }

  $updatesql ="UPDATE staff SET class='$class_name' ";
  
  $updatesql .= " WHERE staff_id='$staff_id'";
  if (mysqli_query($conn, $updatesql)) {
    // Log assignment/update
    if (file_exists(__DIR__ . '/../../includes/logger.php')) {
      require_once __DIR__ . '/../../includes/logger.php';
      // session already started at top
      $user_id = $_SESSION['admin_id'] ?? '';
      $username = $_SESSION['username'] ?? '';
      log_activity($conn, $user_id, $username, 'administrator', 'assign_staff', "staff_id={$staff_id};class={$class_name}");
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  } else {
    echo "Error updating: " . mysqli_error($conn);
  }
}

// Fetch staff and classes for dropdowns
$staff_result = $conn->query("SELECT staff_id, CONCAT(first_name, ' ', last_name) AS name FROM staff");
$classes_result = $conn->query("SELECT class_id, class_name FROM class");
// Pagination setup

$limit = 10;

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;

$offset = ($page - 1) * $limit;



// Handle class filter

$classFilter = $_GET['class_filter'] ?? '';

$classWhere = $classFilter ? "WHERE class = '" . mysqli_real_escape_string($conn, $classFilter) . "'" : "";



// CSV Export

if (isset($_GET['export']) && $_GET['export'] == 'csv') {

  header('Content-Type: text/csv');

  header('Content-Disposition: attachment; filename="staff.csv"');

  $output = fopen("php://output", "w");

  fputcsv($output, ['Staff ID', 'Full Name', 'Class', 'Email', 'Phone', 'Qualification', 'Position']);

  $exportSql = "SELECT * FROM staff $classWhere";

  $res = mysqli_query($conn, $exportSql);

  while ($row = mysqli_fetch_assoc($res)) {

    fputcsv($output, [

      $row['staff_id'],

      $row['first_name'] . ' ' . $row['mid_name'] . ' ' . $row['last_name'],

      $row['class'],

      $row['email'],

      $row['number'],

      $row['qualification'],

      $row['curr_position']

    ]);
  }

  fclose($output);

  exit;
}



// Handle AJAX fetch for edit

if (isset($_GET['action']) && $_GET['action'] === 'fetch') {

  $id = mysqli_real_escape_string($conn, $_GET['id']);

  $result = mysqli_query($conn, "SELECT * FROM staff WHERE staff_id='$id'");

  $row = mysqli_fetch_assoc($result);

  echo '

  <form id="editForm" method="POST" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" class="space-y-4">

    <input type="hidden" name="staff_id" value="' . $row['staff_id'] . '">

    <h3 class="text-lg font-semibold">Edit Staff</h3>

    <div class="grid md:grid-cols-3 gap-4">

      <div><label class="block">First Name</label><input type="text" name="first_name" value="' . $row['first_name'] . '" class="w-full border rounded p-2"></div>

      <div><label class="block">Middle Name</label><input type="text" name="mid_name" value="' . $row['mid_name'] . '" class="w-full border rounded p-2"></div>

      <div><label class="block">Last Name</label><input type="text" name="last_name" value="' . $row['last_name'] . '" class="w-full border rounded p-2"></div>

      <div><label class="block">Phone Number</label><input type="text" name="number" value="' . $row['number'] . '" class="w-full border rounded p-2"></div>

      <div><label class="block">Email</label><input type="email" name="email" value="' . $row['email'] . '" class="w-full border rounded p-2"></div>

      <div><label class="block">Class</label><input type="text" name="class" value="' . $row['class'] . '" class="w-full border rounded p-2"></div>

      <div><label class="block">Current Address</label><input type="text" name="curaddress" value="' . $row['curaddress'] . '" class="w-full border rounded p-2"></div>

      <div><label class="block">City Name</label><input type="text" name="cityname" value="' . $row['cityname'] . '" class="w-full border rounded p-2"></div>

      <div><label class="block">Qualification</label><input type="text" name="qualification" value="' . $row['qualification'] . '" class="w-full border rounded p-2"></div>

      <div><label class="block">Current Position</label><input type="text" name="curr_position" value="' . $row['curr_position'] . '" class="w-full border rounded p-2"></div>

      <div><label class="block">Username</label><input type="text" name="username" value="' . $row['username'] . '" class="w-full border rounded p-2"></div>

      <div><label class="block">Password</label><input type="password" name="password" class="w-full border rounded p-2"></div>

      <div><label class="block">Confirm Password</label><input type="password" name="conpassword" class="w-full border rounded p-2"></div>

    </div>

    <div class="text-right">

      <button type="submit" name="update" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save Changes</button>

    </div>

  </form>';

  exit;
}

// Handle AJAX request to load staff table rows without full page reload
if (isset($_GET['action']) && $_GET['action'] === 'load_staff') {
  // Respect current filter and pagination
  $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : $page;
  $classFilter = $_GET['class_filter'] ?? $classFilter;
  $classWhere = $classFilter ? "WHERE class = '" . mysqli_real_escape_string($conn, $classFilter) . "'" : "";

  $offset = ($page - 1) * $limit;
  $sql = "SELECT * FROM staff $classWhere LIMIT $limit OFFSET $offset";
  $res = mysqli_query($conn, $sql);
  $html = '';
  if (mysqli_num_rows($res) > 0) {
    $counter = ($page - 1) * $limit + 1;
    while ($row = mysqli_fetch_assoc($res)) {
      $html .= "<tr class='hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors'>";
      $html .= "<td class='py-3 px-4'><input type='checkbox' name='selected_staff[]' value='" . $row['staff_id'] . "' class='rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50'></td>";
      $html .= "<td class='py-3 px-4 text-gray-800 dark:text-gray-100'>" . $counter . "</td>";
      $html .= "<td class='py-3 px-4 text-gray-800 dark:text-gray-100'>" . $row['staff_id'] . "</td>";
      $html .= "<td class='py-3 px-4 text-gray-800 dark:text-gray-100'>" . $row['first_name'] . ' ' . $row['mid_name'] . ' ' . $row['last_name'] . "</td>";
      $html .= "<td class='py-3 px-4 text-gray-800 dark:text-gray-100'>" . $row['class'] . "</td>";
      $html .= "<td class='py-3 px-4'><span class='px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 rounded-full'>Active</span></td>";
      $html .= "<td class='py-3 px-4'> <div class='flex justify-center gap-2'> <a href=\"#\" title=\"Edit\" class=\"edit text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 p-1.5 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/30 transition\" data-id=\"" . $row['staff_id'] . "\"> <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'> <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z' /> </svg> </a> <a href=\"delete.php?table=staff&id=" . $row['staff_id'] . "\" title=\"Delete\" class=\"text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 p-1.5 rounded-full hover:bg-red-100 dark:hover:bg-red-900/30 transition\" onclick=\"return confirm('Are you sure you want to delete this staff member?');\"> <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'> <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' /> </svg> </a> </div> </td>";
      $html .= "</tr>";
      $counter++;
    }
  } else {
    $html .= "<tr><td colspan='8' class='py-8 px-4 text-center text-gray-500 dark:text-gray-300'> <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-12 w-12 mx-auto text-gray-300 dark:text-gray-600 mb-2\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"> <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z\" /> </svg> No staff members found </td></tr>";
  }
  echo $html;
  exit;
}



// Handle update request

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {

  $id = mysqli_real_escape_string($conn, $_POST['staff_id']);

  $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);

  $mid_name = mysqli_real_escape_string($conn, $_POST['mid_name']);

  $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);

  $number = mysqli_real_escape_string($conn, $_POST['number']);

  $email = mysqli_real_escape_string($conn, $_POST['email']);

  $class = mysqli_real_escape_string($conn, $_POST['class']);

  $curaddress = mysqli_real_escape_string($conn, $_POST['curaddress']);

  $cityname = mysqli_real_escape_string($conn, $_POST['cityname']);

  $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);

  $curr_position = mysqli_real_escape_string($conn, $_POST['curr_position']);

  $username = mysqli_real_escape_string($conn, $_POST['username']);

  $password = $_POST['password'];

  $conpassword = $_POST['conpassword'];



  $sql = "UPDATE staff SET 

      first_name='$first_name',

      mid_name='$mid_name',

      last_name='$last_name',

      number='$number',

      email='$email',

      class='$class',

      curaddress='$curaddress',

      cityname='$cityname',

      qualification='$qualification',

      curr_position='$curr_position',

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



  $sql .= " WHERE staff_id='$id'";

  if (mysqli_query($conn, $sql)) {

    header("Location: " . $_SERVER['PHP_SELF']);

    exit();
  } else {

    echo "Error updating: " . mysqli_error($conn);
  }
}



// Handle multiple deletion

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_selected'])) {

  $ids = $_POST['selected_staff'] ?? [];

  if (!empty($ids)) {

    // Escape each ID and wrap in quotes for VARCHAR

    $escaped_ids = array_map(function ($id) use ($conn) {

      return "'" . mysqli_real_escape_string($conn, $id) . "'";
    }, $ids);



    $idList = implode(",", $escaped_ids);

    $deleteSql = "DELETE FROM staff WHERE staff_id IN ($idList)";



    if (mysqli_query($conn, $deleteSql)) {

      // Log deletion
      if (file_exists(__DIR__ . '/../../includes/logger.php')) {
        require_once __DIR__ . '/../../includes/logger.php';
        $user_id = $_SESSION['admin_id'] ?? '';
        $username = $_SESSION['username'] ?? '';
        log_activity($conn, $user_id, $username, 'administrator', 'delete_staff', 'deleted_ids=' . $idList);
      }

      header("Location: " . $_SERVER['PHP_SELF']);

      exit;
    } else {

      echo "Error deleting records: " . mysqli_error($conn);
    }
  }
}



include('include/side-bar.php');

?>



<body class="w-screen h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <div class="flex w-full h-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden overflow-y-auto">

      <!-- Header Section -->
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
          <h2 class="text-[clamp(1.25rem,2.5vw,1.75rem)] font-bold text-gray-800 dark:text-white">
            Staff Management
          </h2>
          <p class="text-[clamp(0.85rem,1.5vw,1rem)] text-gray-500 dark:text-gray-400 mt-1">
            Manage all staff members and their assignments
          </p>
        </div>

        <div class="flex flex-wrap gap-3 mt-4 md:mt-0">
          <button onclick="document.getElementById('assignStaffModal').classList.remove('hidden')"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition flex items-center text-[clamp(0.85rem,1.5vw,1rem)]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Assign Staff
          </button>

          <button onclick="document.getElementById('staffFormModal').classList.remove('hidden')"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition flex items-center text-[clamp(0.85rem,1.5vw,1rem)]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            New Staff
          </button>
        </div>
      </div>

      <!-- Filter and Export Section -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 mb-6">
        <div class="flex flex-col md:flex-row md:items-center gap-4">
          <form method="GET" class="flex-1 flex flex-col md:flex-row md:items-center gap-4">
            <div class="flex-1">
              <label
                class="block text-[clamp(0.8rem,1.2vw,0.95rem)] font-medium mb-2 text-gray-700 dark:text-gray-200">
                Filter by Class
              </label>
              <div class="flex gap-2">
                <select name="class_filter" onchange="this.form.submit()"
                  class="w-full md:w-60 border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-2.5 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm text-[clamp(0.8rem,1.5vw,1rem)]">
                  <option value="">All Classes</option>
                  <?php
                  include('../../includes/database.php');
                  $res = $conn->query("SELECT DISTINCT class FROM staff");
                  while ($row = $res->fetch_assoc()) {
                    $selected = ($row['class'] === $classFilter) ? 'selected' : '';
                    echo "<option value='{$row['class']}' $selected>{$row['class']}</option>";
                  }
                  ?>
                </select>
                <a href="?export=csv<?php echo $classFilter ? '&class_filter=' . $classFilter : ''; ?>"
                  class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition flex items-center text-[clamp(0.8rem,1.5vw,1rem)]">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                  </svg>
                  Export CSV
                </a>
                <button type="button" id="reloadStaffBtn" title="Reload staff list" class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v6h6M20 20v-6h-6M4 20l16-16" />
                  </svg>
                  Reload Staff
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Staff Table -->
      <form method="POST">
        <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
          <div class="overflow-x-auto">
            <table class="min-w-full w-full text-[clamp(0.8rem,1.4vw,0.95rem)]">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th class="py-3 px-4 text-left"><input type="checkbox" id="select_all"
                      class="rounded border-gray-300 text-blue-600 shadow-sm"></th>
                  <th class="py-3 px-4 text-left font-medium text-gray-700 dark:text-gray-200">#</th>
                  <th class="py-3 px-4 text-left font-medium text-gray-700 dark:text-gray-200">Staff
                    ID</th>
                  <th class="py-3 px-4 text-left font-medium text-gray-700 dark:text-gray-200">Full
                    Name</th>
                  <th class="py-3 px-4 text-left font-medium text-gray-700 dark:text-gray-200">Assigned Class
                  </th>
                  
                  <th class="py-3 px-4 text-left font-medium text-gray-700 dark:text-gray-200">Status
                  </th>
                  <th class="py-3 px-4 text-center font-medium text-gray-700 dark:text-gray-200">
                    Actions</th>
                </tr>
              </thead>
              <tbody id="staffTableBody" class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php $sql = "SELECT * FROM staff $classWhere LIMIT $limit OFFSET $offset";
                $res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($res) > 0) {
                  $counter = ($page - 1) * $limit + 1;
                  while ($row = mysqli_fetch_assoc($res)) {
                    echo "<tr class='hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors'>";
                    echo "<td class='py-3 px-4'><input type='checkbox' name='selected_staff[]' value='{$row['staff_id']}' class='rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50'></td>";
                    echo "<td class='py-3 px-4 text-gray-800 dark:text-gray-100'>{$counter}</td>";
                    echo "<td class='py-3 px-4 text-gray-800 dark:text-gray-100'>{$row['staff_id']}</td>";
                    echo "<td class='py-3 px-4 text-gray-800 dark:text-gray-100'>{$row['first_name']} {$row['mid_name']} {$row['last_name']}</td>";
                    echo "<td class='py-3 px-4 text-gray-800 dark:text-gray-100'>{$row['class']}</td>";
                    
                    echo "<td class='py-3 px-4'><span class='px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 rounded-full'>Active</span></td>";
                    echo "<td class='py-3 px-4'> <div class='flex justify-center gap-2'> <a href=\"#\" title=\"Edit\" class=\"edit text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 p-1.5 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/30 transition\" data-id=\"{$row['staff_id']}\"> <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-5 w-5\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"> <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z\" /> </svg> </a> <a href=\"delete.php?table=staff&id={$row['staff_id']}\" title=\"Delete\" class=\"text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 p-1.5 rounded-full hover:bg-red-100 dark:hover:bg-red-900/30 transition\" onclick=\"return confirm('Are you sure you want to delete this staff member?');\"> <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-5 w-5\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"> <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16\" /> </svg> </a> </div> </td>";
                    echo "</tr>";
                    $counter++;
                  }
                } else {
                  echo "<tr><td colspan='8' class='py-8 px-4 text-center text-gray-500 dark:text-gray-300'> <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-12 w-12 mx-auto text-gray-300 dark:text-gray-600 mb-2\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"> <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z\" /> </svg> No staff members found </td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
          <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700">
            <button type="submit" name="delete_selected"
              class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition flex items-center text-[clamp(0.85rem,1.5vw,1rem)]">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              Delete Selected
            </button>
          </div>
        </section>
      </form>




      <?php

      $countRes = mysqli_query($conn, "SELECT COUNT(*) as total FROM staff $classWhere");

      $totalRows = mysqli_fetch_assoc($countRes)['total'];

      $totalPages = ceil($totalRows / $limit);

      ?>



      <div class="mt-4 flex justify-center gap-2">

        <?php if ($page > 1): ?>

          <a href="?page=<?php echo $page - 1; ?><?php echo $classFilter ? '&class_filter=' . $classFilter : ''; ?>"

            class="px-3 py-1 bg-gray-300 hover:bg-gray-400 rounded">Previous</a>

        <?php endif; ?>



        <?php if ($page < $totalPages): ?>

          <a href="?page=<?php echo $page + 1; ?><?php echo $classFilter ? '&class_filter=' . $classFilter : ''; ?>"

            class="px-3 py-1 bg-gray-300 hover:bg-gray-400 rounded">Next</a>

        <?php endif; ?>

      </div>

    </main>

<!-- Assign Staff Modal -->
    <div id="assignStaffModal"
      class="hidden fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center p-4">
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md">
        <div class="p-6">
          <div class="flex items-center mb-4">
            <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg mr-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Assign Staff to Class</h3>
          </div>

          <?php if (isset($assign_success)): ?>
            <div
              class="mb-4 p-3 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg">
              <?= $assign_success ?>
            </div>
          <?php endif; ?>

          <?php if (isset($assign_error)): ?>
            <div class="mb-4 p-3 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg">
              <?= $assign_error ?>
            </div>
          <?php endif; ?>

          <form method="POST">
            <input type="hidden" name="assign_staff" value="1">
            <div class="mb-4">
              <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">Staff
                Member</label>
              <select name="staff_id"
                class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-2.5 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                required>
                <option value="">Select Staff</option>
                <?php while ($s = $staff_result->fetch_assoc()): ?>
                  <option value="<?= $s['staff_id'] ?>"><?= $s['name'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="mb-6">
              <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">Class</label>
              <select name="class_name"
                class="w-full border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-2.5 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                required>
                <option value="">Select Class</option>
                <?php
                // Reset pointer for classes result
                $classes_result->data_seek(0);
                while ($c = $classes_result->fetch_assoc()): ?>
                  <option value="<?= $c['class_name'] ?>"><?= $c['class_name'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="flex gap-3">
              <button type="submit"
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg shadow-md transition">
                Assign to Class
              </button>
              <button type="button"
                onclick="document.getElementById('assignStaffModal').classList.add('hidden')"
                class="flex-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium py-2.5 px-4 rounded-lg shadow-md transition">
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal -->

    <div id="modal_container" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center">

      <div class="bg-white rounded-lg w-full max-w-3xl p-6 relative">

        <button id="close" class="absolute top-3 right-3 text-gray-500 hover:text-black text-xl">&times;</button>

        <div id="modalContent">

          <!-- Content will be loaded here via AJAX -->

        </div>

      </div>

    </div>



    <script>
        $(function() {

        // Select all checkbox functionality
        $("#select_all").change(function() {
          $("input[name='selected_staff[]']").prop('checked', $(this).prop("checked"));
        });

        // Delegated handler for edit links so it works after AJAX reload
        $(document).on('click', '.edit', function(e) {
          e.preventDefault();
          const staffId = $(this).data("id");
          $("#modal_container").removeClass("hidden");

          // Load the form via AJAX
          $.get("<?php echo $_SERVER['PHP_SELF']; ?>", {
            action: "fetch",
            id: staffId
          }, function(data) {
            $("#modalContent").html(data);
          });
        });

        // JS vars for current filter/page (fallbacks)
        const staffCurrentFilter = "<?php echo addslashes($classFilter); ?>";
        const staffCurrentPage = <?php echo intval($page); ?>;

        // Reload button triggers AJAX load of staff rows
        $(document).on('click', '#reloadStaffBtn', function() {
          const filter = $("select[name='class_filter']").val() || staffCurrentFilter;
          const page = staffCurrentPage;
          $.get("<?php echo $_SERVER['PHP_SELF']; ?>", { action: 'load_staff', class_filter: filter, page: page }, function(data) {
            $("#staffTableBody").html(data);
            // uncheck select_all after reload
            $("#select_all").prop('checked', false);
          }).fail(function() {
            alert('Error loading staff. Please try again.');
          });
        });

        $("#close").click(() => $("#modal_container").addClass("hidden"));

      });
    </script>

</body>



<?php include('include/modals.php'); ?>

<?php include('include/head.php'); ?>