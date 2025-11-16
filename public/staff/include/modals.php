<?php
// Prevent multiple inclusions of staff modals to avoid duplicate IDs in the DOM
$__vo_modal_guard = 'PORTAL_MODALS_INCLUDED_' . md5(__FILE__);
if (defined($__vo_modal_guard)) {
  return;
}
define($__vo_modal_guard, true);
?>

<!-- ADD TEST MODAL -->
<div id="testFormModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white dark:bg-gray-800 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-lg shadow-lg p-6 relative m-4 sm:m-6">
    <form action="../../controller/exam.php" method="post" class="space-y-8">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <button
          onclick="document.getElementById('testFormModal').classList.add('hidden')"
          class="absolute top-20 right-3 text-red-400 hover:text-gray-800 text-xl">
          &times;
        </button>
        <div>
          <label class="block mb-1 font-medium dark:text-gray-200">Test ID:</label>
          <input class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" type="text" name="test_id" placeholder="eg. TS00000">
        </div>
        <div>
          <label class="block mb-1 font-medium dark:text-gray-200">Term</label>
          <select name="term" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <option>Select Term</option>
            <option value="First Term">First Term</option>
            <option value="Second Term" >Second Term</option>
            <option value="Third Term">Third Term</option>
          </select>
        </div>
        <div>
          <label class="block mb-1 font-medium dark:text-gray-200">Type</label>
          <select name="type" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <option>Select Type</option>
            <option value="Class Test">Class Test</option>
            <option value="Examination">Examination</option>
          </select>
        </div>
        <div>
          <label class="block mb-1 font-medium dark:text-gray-200">Class</label>
          <select name="class_nm" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <option>Select Class<?php
                                                              include('../../includes/database.php');
                                                              $sql = "SELECT * FROM class";
                                                              $result = $conn->query($sql);
                                                              while ($row = $result->fetch_assoc()) {
                                                                echo '<option name="class_nm" value="' . $row["class_name"] . '">' . $row["class_name"] . ' </option>';
                                                              }
                                                              //$conn->close(); ?></option>
          </select>
        </div>
        <div>
          <label class="block mb-1 font-medium dark:text-gray-200">Start Date:</label>
          <input class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" type="date" name="start_date" required>
        </div>
        <div>
          <label class="block mb-1 font-medium dark:text-gray-200">End Date:</label>
          <input class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" type="date" name="end_date" required>
        </div>
      </div>
      <div class="text-center">
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
          Save
        </button>
      </div>
    </form>
  </div>
</div>
