<!-- Add Admin -->
<div id="adminFormModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-6 relative">

    <!-- Close Button -->
    <button
      onclick="document.getElementById('adminFormModal').classList.add('hidden')"
      class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl">
      &times;
    </button>

    <!-- Form -->
    <form action="../../controller/admin.php" method="post">
      <h1 class="text-xl font-semibold mb-4">Add Administrator</h1>

      <div class="grid grid-cols-1 gap-4">
        <div>
          <label for="administrator_id" class="block mb-1 text-sm font-medium text-gray-700">Admin ID</label>
          <input type="text" name="administrator_id" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Full Name</label>
          <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Role</label>
          <select name="role" class="w-full border rounded px-3 py-2" required>
            <option value="">Select Role</option>
            <option value="administrator">administrator</option>
          </select>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Username</label>
          <input type="text" name="username" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Password</label>
          <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Confirm Password</label>
          <input type="password" name="conpassword" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="text-right mt-4">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Add Staff -->

<div id="staffFormModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white dark:bg-gray-800 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-lg shadow-lg p-6 relative m-4 sm:m-6">
    <!-- Staff Form -->
    <form action="../../controller/staff.php" method="POST" class="space-y-6">
      <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">New Staff</h1>

      <!-- Personal Details -->
      <section>
        <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">Personal Details</h2>
        <button
          onclick="document.getElementById('staffFormModal').classList.add('hidden')"
          class="absolute top-20 right-3 text-red-400 hover:text-gray-800 text-xl">
          &times;
        </button>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block mb-1 font-medium">Staff ID</label>
            <input type="text" name="" placeholder="Auto-Generated" readonly required class="w-full border rounded px-3 py-2 bg-gray-100 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block mb-1 font-medium">Gender</label>
            <select name="gender" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
              <option>Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>

          <div>
            <label class="block mb-1 font-medium">Surname</label>
            <input type="text" name="first_name" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block mb-1 font-medium">Middle Name</label>
            <input type="text" name="mid_name" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" placeholder="Optional">
          </div>

          <div>
            <label class="block mb-1 font-medium">Last Name</label>
            <input type="text" name="last_name" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block mb-1 font-medium">Date of Birth</label>
            <input type="date" name="dob" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block mb-1 font-medium">Phone Number</label>
            <input type="text" name="number" placeholder="233 xxx xxx xxx" minlength="12" maxlength="15" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          
        </div>
      </section>

      <!-- Address -->
      <section>
        <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">Address</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block mb-1 font-medium">Current Address</label>
            <input type="text" name="curaddress" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>          
        </div>
      </section>

      <!-- Employment Details -->
      <section>
        <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">Employment Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
           <div>
              <label class="block font-medium mb-1">Qualification</label>
              <select name="qualification" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option>Select</option>
                <option value="Degree">Degree</option>
                <option value="Masters">Masters</option>
                <option value="PhD">PhD</option>
                <option value="WASSCE">WASSCE</option>
              </select>
            </div>
          <div>
            <label class="block mb-1 font-medium">Join Date</label>
            <input type="date" name="join_date" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>
          
        </div>
      </section>

      <!-- Account Details -->
      <section>
        <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">Account Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block mb-1 font-medium">Select Role</label>
            <select name="role" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
              <option value="staff">staff</option>
            </select>
          </div>

          <div>
            <label class="block mb-1 font-medium">Username</label>
            <input type="text" name="username" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block mb-1 font-medium">Password</label>
            <input type="password" name="password" minlength="4" maxlength="15" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <button type="button" class="text-sm text-blue-500 mt-1" onclick="show(); btnShow()">Toggle</button>
          </div>

          <div>
            <label class="block mb-1 font-medium">Confirm Password</label>
            <input type="password" name="conpassword" minlength="4" maxlength="15" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <button type="button" class="text-sm text-blue-500 mt-1" onclick="showc(); btnShow2()">Toggle</button>
            <div id="password_strength" class="text-xs text-gray-500 mt-1"></div>
          </div>
        </div>
      </section>

      <!-- Submit -->
      <div class="text-right pt-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
          Save
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ADD STUDENTS -->

<div id="studentFormModal"
  class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white dark:bg-gray-800 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-lg shadow-lg p-6 relative m-4 sm:m-6">
    <!-- Full Form -->
    <form action="../../controller/student.php" method="post" class="space-y-8">
      <h1 class="text-2xl font-bold text-center text-gray-800 dark:text-white">New Student</h1>
      <!-- Personal Details -->
      <div class="grid md:grid-cols-2 gap-4">
        <section>
          <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Personal Details</h2>
          <button
            onclick="document.getElementById('studentFormModal').classList.add('hidden')"
            class="absolute top-20 right-3 text-red-400 hover:text-gray-800 text-xl">
            &times;
          </button>
          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <label class="block font-medium mb-1">Student ID</label>
              <input type="text" name="student_id" placeholder="Auto-Generate" readonly
                class="w-full border rounded px-3 py-2 bg-gray-100 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
              <label class="block font-medium mb-1">Gender</label>
              <select name="gender" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>

            <div>
              <label class="block font-medium mb-1">First Name</label>
              <input type="text" name="first_name" required
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
              <label class="block font-medium mb-1">Middle Name</label>
              <input type="text" name="mid_name" placeholder="Optional"
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
              <label class="block font-medium mb-1">Last Name</label>
              <input type="text" name="last_name" required
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
              <label class="block font-medium mb-1">Date of Birth</label>
              <input type="date" name="dob" value="<?php echo date('Y-m-d'); ?>"
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
              <label class="block font-medium mb-1">Phone Number</label>
              <input type="text" name="number" placeholder="0xxxxxxxxx" minlength="9" maxlength="10"
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
              <label class="block font-medium mb-1">Email</label>
              <input type="email" name="email" placeholder="Optional"
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="md:col-span-2">
              <label class="block font-medium mb-1">Class</label>
              <select name="class" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option>Select Class</option>
                <?php
                include('../../includes/database.php');
                $sql = "SELECT * FROM class";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                  echo '<option value="' . $row["class_name"] . '">' . $row["class_name"] . '</option>';
                }
                $conn->close();
                ?>
              </select>
            </div>

            
          </div>
      </div>
      </section>

      <!-- Address -->
      <section>
        <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Address</h2>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Current Address</label>
            <select name="curaddress" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
              <option value="">Select location</option>
              <option value="Akwatia">Akwatia</option>
              <option value="Kade">Kade</option>
              <option value="Nkwatanang">Nkwatanang</option>
              <option value="Boadua">Boadua</option>
              <option value="Bamenase">Bamenase</option>
              <option value="Apinamang">Apinamang</option>
              <option value="Topremang">Topremang</option>
              <option value="Cayco">Cayco</option>
            </select>
          </div>
        </div>
      </section>


      <!-- Parent Details -->
      <section>
        <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Parent Details</h2>
        <div class="grid md:grid-cols-3 gap-4">
          <div>
            <label class="block font-medium mb-1">Parent Name</label>
            <input type="text" name="parent_name" 
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>


          <div>
            <label class="block font-medium mb-1">Email</label>
            <input type="email" name="parent_email" placeholder="Optional"
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block font-medium mb-1">Phone Number</label>
            <input type="text" name="parent_number" placeholder="0xxxxxxxxx" minlength="9" maxlength="10" 
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>
        </div>
      </section>


      <!-- Account Details -->
      <section>
        <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Account Details</h2>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Select Role</label>
            <select name="role" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
              <option value="student">student</option>
            </select>
          </div>

          <div>
            <label class="block font-medium mb-1">Username</label>
            <input type="text" name="username" autocomplete="username"
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block font-medium mb-1">Password</label>
            <input type="password" name="password" minlength="4" maxlength="15" autocomplete="new-password"
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <button type="button" class="text-sm text-blue-500 mt-1" onclick="show(); btnShow()">Toggle</button>
          </div>

          <div>
            <label class="block font-medium mb-1">Confirm Password</label>
            <input type="password" name="conpassword" minlength="4" maxlength="15" autocomplete="new-password"
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <button type="button" class="text-sm text-blue-500 mt-1" onclick="showc(); btnShow2()">Toggle</button>
            <div id="password_strength" class="text-xs text-gray-500 mt-1"></div>
          </div>
        </div>
      </section>


      <!-- Submit -->
      <div class="text-center">
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
          Save
        </button>
      </div>

    </form>
  </div>
</div>

<!-- ADD CLASS MODAL -->
<div id="classFormModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white dark:bg-gray-800 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-lg shadow-lg p-6 relative m-4 sm:m-6">
    
    <form action="../../controller/class.php" method="post" class="space-y-8">
      <div class="space-y-4">
        <button
          onclick="document.getElementById('classFormModal').classList.add('hidden')"
          class="absolute top-20 right-3 text-red-400 hover:text-gray-800 text-xl">
          &times;
        </button>
        
        <div>
          <label class="block mb-1 font-medium dark:text-gray-200">Class Name:</label>
          <input class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" type="text" name="class_name">
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
<!-- ADD SUBJECT MODAL -->
<div id="subjectFormModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white dark:bg-gray-800 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-lg shadow-lg p-6 relative m-4 sm:m-6">
    <form action="../../controller/subject.php" method="post" class="space-y-8">
      <button
          onclick="document.getElementById('subjectFormModal').classList.add('hidden')"
          class="absolute top-20 right-3 text-red-400 hover:text-gray-800 text-xl">
          &times;
        </button>
      <div class="space-y-4">
        <div>
          <label class="block mb-1 font-medium dark:text-gray-200">Subject Code:</label>
          <input class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" type="text" name="subject_id"  placeholder="eg. SUBC00000">
        </div>
        <div>
          <label class="block mb-1 font-medium dark:text-gray-200">Subject Name:</label>
          <input class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" type="text" name="subject_name" >
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
                                                              $conn->close(); ?></option>
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
