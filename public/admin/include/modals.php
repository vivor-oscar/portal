<!-- Add Admin -->
<style>
/* Student modal responsive behavior: expand fields to full width when any input is focused */
#studentFormModal .student-grid,
#studentFormModal .student-subgrid {
  display: grid;
  gap: 1rem;
  grid-template-columns: 1fr;
  transition: grid-template-columns 180ms ease;
}
@media (min-width: 768px) {
  #studentFormModal .student-grid { grid-template-columns: repeat(2, minmax(0,1fr)); }
  #studentFormModal .student-subgrid { grid-template-columns: repeat(2, minmax(0,1fr)); }
  /* collapse to single column when any child receives focus */
  #studentFormModal .student-grid:focus-within { grid-template-columns: 1fr; }
  #studentFormModal .student-subgrid:focus-within { grid-template-columns: 1fr; }
}
#studentFormModal .form-group { width: 100%; }
#studentFormModal label { display: block; }
#studentFormModal input, #studentFormModal select, #studentFormModal textarea { width: 100%; box-sizing: border-box; }
</style>
<div id="adminFormModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden" role="dialog" aria-modal="true" aria-labelledby="adminFormModalTitle">
  <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-6 relative">

    <!-- Close Button -->
    <button type="button" onclick="document.getElementById('adminFormModal').classList.add('hidden')" aria-label="Close admin modal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl">&times;</button>

    <!-- Form -->
    <form action="../../controller/admin.php" method="post" novalidate>
  <h1 id="adminFormModalTitle" class="text-xl font-semibold mb-4">Add Administrator</h1>
      <div class="ajax-result hidden p-2 rounded mt-2" role="status" aria-live="polite" style="display:none;"></div>

      <div class="grid grid-cols-1 gap-4">
        <div class="form-group">
          <label for="administrator_id" class="block mb-1 text-sm font-medium text-gray-700">Admin ID</label>
          <input id="administrator_id" type="text" name="administrator_id" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="form-group">
          <label for="admin_fullname" class="block mb-1 text-sm font-medium text-gray-700">Full Name</label>
          <input id="admin_fullname" type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="form-group">
          <label for="admin_role" class="block mb-1 text-sm font-medium text-gray-700">Role</label>
          <select id="admin_role" name="role" class="w-full border rounded px-3 py-2" required>
            <option value="">Select Role</option>
            <option value="administrator">administrator</option>
          </select>
        </div>

        <div class="form-group">
          <label for="admin_username" class="block mb-1 text-sm font-medium text-gray-700">Username</label>
          <input id="admin_username" type="text" name="username" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="form-group">
          <label for="admin_password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
          <input id="admin_password" type="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="form-group">
          <label for="admin_conpassword" class="block mb-1 text-sm font-medium text-gray-700">Confirm Password</label>
          <input id="admin_conpassword" type="password" name="conpassword" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="text-right mt-4">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        </div>
      </div>
        <!-- Centralized AJAX handler for modal forms -->
        <script>
        document.addEventListener('DOMContentLoaded', function(){
          const modalForms = document.querySelectorAll('form[action^="../../controller/"]');
          modalForms.forEach(form => {
            // ensure result area exists
            let result = form.querySelector('.ajax-result');
            if (!result) {
              result = document.createElement('div');
              result.className = 'ajax-result hidden p-2 rounded mt-2';
              result.setAttribute('role','status');
              result.setAttribute('aria-live','polite');
              form.insertBefore(result, form.firstChild);
            }

            form.addEventListener('submit', async function(e){
              e.preventDefault();
              const submitBtn = form.querySelector('button[type="submit"]');
              if (!submitBtn) return;
              if (submitBtn.dataset.busy === '1') return;
              submitBtn.dataset.busy = '1';
              submitBtn.disabled = true;

              // hide previous
              result.style.display = 'none';
              result.className = 'ajax-result hidden p-2 rounded mt-2';
              result.textContent = '';

              const action = form.getAttribute('action');
              const fd = new FormData(form);
              try {
                const res = await fetch(action, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: fd });
                const txt = await res.text();
                let data = null;
                try { data = JSON.parse(txt); } catch (err) { data = null; }

                if (data && data.status === 'ok') {
                  result.className = 'ajax-result p-2 rounded mt-2 bg-green-100 text-green-800';
                  result.textContent = data.message || 'Saved successfully';
                  result.style.display = 'block';
                  // clear inputs
                  form.querySelectorAll('input[type="text"], input[type="password"], input[type="email"], input[type="date"], textarea, select').forEach(i => {
                    if (i.hasAttribute('readonly')) return;
                    if (i.type === 'checkbox' || i.type === 'radio') i.checked = false; else i.value = '';
                  });
                } else if (data && data.status === 'duplicate') {
                  result.className = 'ajax-result p-2 rounded mt-2 bg-yellow-100 text-yellow-800';
                  result.textContent = data.message || 'Duplicate entry detected';
                  result.style.display = 'block';
                } else if (data && data.status === 'error') {
                  result.className = 'ajax-result p-2 rounded mt-2 bg-red-100 text-red-800';
                  result.textContent = data.message || 'Error saving';
                  result.style.display = 'block';
                } else {
                  if (/saved successfully/i.test(txt)) {
                    result.className = 'ajax-result p-2 rounded mt-2 bg-green-100 text-green-800';
                    result.textContent = 'Saved successfully';
                    result.style.display = 'block';
                    form.querySelectorAll('input[type="text"], input[type="password"], input[type="email"], input[type="date"], textarea, select').forEach(i => { if (i.hasAttribute('readonly')) return; if (i.type === 'checkbox' || i.type === 'radio') i.checked = false; else i.value = ''; });
                  } else {
                    result.className = 'ajax-result p-2 rounded mt-2 bg-red-100 text-red-800';
                    result.textContent = txt || 'Unknown response';
                    result.style.display = 'block';
                  }
                }
              } catch (err) {
                result.className = 'ajax-result p-2 rounded mt-2 bg-red-100 text-red-800';
                result.textContent = err.message || 'Network error';
                result.style.display = 'block';
              } finally {
                submitBtn.dataset.busy = '0';
                submitBtn.disabled = false;
              }
            });
          });
        });
        </script>
    </form>
  </div>
</div>

<!-- Add Staff -->

<div id="staffFormModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" role="dialog" aria-modal="true" aria-labelledby="staffFormModalTitle">
  <div class="bg-white dark:bg-gray-800 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-lg shadow-lg p-6 relative m-4 sm:m-6">
    <!-- Staff Form -->
    <form id="staffForm" action="../../controller/staff.php" method="POST" class="space-y-6">
      <h1 id="staffFormModalTitle" class="text-2xl font-bold text-gray-800 dark:text-white mb-4">New Staff</h1>
      <div class="ajax-result hidden p-2 rounded mt-2" style="display:none;"></div>

      <!-- Personal Details -->
      <section>
        <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">Personal Details</h2>
        <button type="button"
          onclick="document.getElementById('staffFormModal').classList.add('hidden')"
          aria-label="Close staff modal"
          class="absolute top-20 right-3 text-red-400 hover:text-gray-800 text-xl">
          &times;
        </button>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-group">
            <label for="staff_id" class="block mb-1 font-medium">Staff ID</label>
            <input id="staff_id" type="text" name="staff_id" placeholder="Auto-Generated" readonly class="w-full border rounded px-3 py-2 bg-gray-100 dark:bg-gray-700 dark:text-white">
          </div>

          <div class="form-group">
            <label for="staff_gender" class="block mb-1 font-medium">Gender</label>
            <select id="staff_gender" name="gender" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
              <option value="">Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>

          <div class="form-group">
            <label for="staff_first_name" class="block mb-1 font-medium">Surname</label>
            <input id="staff_first_name" type="text" name="first_name" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div class="form-group">
            <label for="staff_mid_name" class="block mb-1 font-medium">Middle Name</label>
            <input id="staff_mid_name" type="text" name="mid_name" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" placeholder="Optional">
          </div>

          <div class="form-group">
            <label for="staff_last_name" class="block mb-1 font-medium">Last Name</label>
            <input id="staff_last_name" type="text" name="last_name" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div class="form-group">
            <label for="staff_dob" class="block mb-1 font-medium">Date of Birth</label>
            <input id="staff_dob" type="date" name="dob" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div class="form-group">
            <label for="staff_number" class="block mb-1 font-medium">Phone Number</label>
            <input id="staff_number" type="text" name="number" placeholder="233 xxx xxx xxx" minlength="12" maxlength="15" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div class="form-group">
            <label for="staff_email" class="block mb-1 font-medium">Email</label>
            <input id="staff_email" type="email" name="email" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

        </div>
      </section>

      <!-- Address -->
      <section>
        <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">Address</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-group">
            <label for="staff_curaddress" class="block mb-1 font-medium">Current Address</label>
            <input id="staff_curaddress" type="text" name="curaddress" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>
        </div>
      </section>

      <!-- Employment Details -->
      <section>
        <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">Employment Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
           <div class="form-group">
              <label for="staff_qualification" class="block font-medium mb-1">Qualification</label>
              <select id="staff_qualification" name="qualification" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option value="">Select</option>
                <option value="Degree">Degree</option>
                <option value="Masters">Masters</option>
                <option value="PhD">PhD</option>
                <option value="WASSCE">WASSCE</option>
              </select>
            </div>
          <div class="form-group">
            <label for="staff_join_date" class="block mb-1 font-medium">Join Date</label>
            <input id="staff_join_date" type="date" name="join_date" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>
        </div>
      </section>

      <!-- Account Details -->
      <section>
        <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">Account Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-group">
            <label for="account_role_staff" class="block mb-1 font-medium">Select Role</label>
            <select id="account_role_staff" name="role" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
              <option value="staff">staff</option>
            </select>
          </div>

          <div class="form-group">
            <label for="staff_username" class="block mb-1 font-medium">Username</label>
            <input id="staff_username" type="text" name="username" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div class="form-group">
            <label for="staff_password" class="block mb-1 font-medium">Password</label>
            <input id="staff_password" type="password" name="password" minlength="4" maxlength="15" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <button type="button" class="text-sm text-blue-500 mt-1" onclick="show(); btnShow()">Toggle</button>
          </div>

          <div class="form-group">
            <label for="staff_conpassword" class="block mb-1 font-medium">Confirm Password</label>
            <input id="staff_conpassword" type="password" name="conpassword" minlength="4" maxlength="15" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
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
      <div class="ajax-result hidden p-2 rounded mt-2" style="display:none;"></div>
      <!-- Personal Details -->
  <div class="student-grid md:student-grid student-subgrid gap-4">
        <section>
          <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Personal Details</h2>
          <button type="button" onclick="document.getElementById('studentFormModal').classList.add('hidden')" aria-label="Close student modal" class="absolute top-20 right-3 text-red-400 hover:text-gray-800 text-xl">&times;</button>
          <div class="student-subgrid md:student-subgrid gap-4">
            <div class="form-group">
              <label for="student_id_input" class="block font-medium mb-1">Student ID</label>
              <input id="student_id_input" type="text" name="student_id" placeholder="Auto-Generate" readonly class="w-full border rounded px-3 py-2 bg-gray-100 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="form-group">
              <label for="student_gender" class="block font-medium mb-1">Gender</label>
              <select id="student_gender" name="gender" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>

            <div class="form-group">
              <label for="student_first_name" class="block font-medium mb-1">First Name</label>
              <input id="student_first_name" type="text" name="first_name" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="form-group">
              <label for="student_mid_name" class="block font-medium mb-1">Middle Name</label>
              <input id="student_mid_name" type="text" name="mid_name" placeholder="Optional" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="form-group">
              <label for="student_last_name" class="block font-medium mb-1">Last Name</label>
              <input id="student_last_name" type="text" name="last_name" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="form-group">
              <label for="student_dob" class="block font-medium mb-1">Date of Birth</label>
              <input id="student_dob" type="date" name="dob" value="<?php echo date('Y-m-d'); ?>" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="form-group">
              <label for="student_number" class="block font-medium mb-1">Phone Number</label>
              <input id="student_number" type="text" name="number" placeholder="0xxxxxxxxx" minlength="9" maxlength="10" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="form-group">
              <label for="student_email" class="block font-medium mb-1">Email</label>
              <input id="student_email" type="email" name="email" placeholder="Optional" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="md:col-span-2 form-group">
              <label for="student_class" class="block font-medium mb-1">Class</label>
              <select id="student_class" name="class" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option value="">Select Class</option>
                <?php
                include('../../includes/database.php');
                $sql = "SELECT * FROM class";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                  echo '<option value="' . $row["class_name"] . '">' . $row["class_name"] . '</option>';
                }
                //$conn->close();
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
          <div class="form-group">
            <label for="student_curaddress" class="block font-medium mb-1">Current Address</label>
            <select id="student_curaddress" name="curaddress" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
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
          <div class="form-group">
            <label for="parent_name" class="block font-medium mb-1">Parent Name</label>
            <input id="parent_name" type="text" name="parent_name" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>


          <div class="form-group">
            <label for="parent_email" class="block font-medium mb-1">Email</label>
            <input id="parent_email" type="email" name="parent_email" placeholder="Optional" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div class="form-group">
            <label for="parent_number" class="block font-medium mb-1">Phone Number</label>
            <input id="parent_number" type="text" name="parent_number" placeholder="0xxxxxxxxx" minlength="9" maxlength="10" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>
        </div>
      </section>


      <!-- Account Details -->
      <section>
        <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Account Details</h2>
        <div class="grid md:grid-cols-2 gap-4">
          <div class="form-group">
            <label for="account_role" class="block font-medium mb-1">Select Role</label>
            <select id="account_role" name="role" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
              <option value="student">student</option>
            </select>
          </div>

          <div class="form-group">
            <label for="account_username" class="block font-medium mb-1">Username</label>
            <input id="account_username" type="text" name="username" autocomplete="username" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div class="form-group">
            <label for="account_password" class="block font-medium mb-1">Password</label>
            <input id="account_password" type="password" name="password" minlength="4" maxlength="15" autocomplete="new-password" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <button type="button" class="text-sm text-blue-500 mt-1" onclick="show(); btnShow()">Toggle</button>
          </div>

          <div class="form-group">
            <label for="account_conpassword" class="block font-medium mb-1">Confirm Password</label>
            <input id="account_conpassword" type="password" name="conpassword" minlength="4" maxlength="15" autocomplete="new-password" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <button type="button" class="text-sm text-blue-500 mt-1" onclick="showc(); btnShow2()">Toggle</button>
            <div id="password_strength" class="text-xs text-gray-500 mt-1"></div>
          </div>
        </div>
      </section>


      <!-- Submit -->
      <div class="text-center">
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">Save</button>
      </div>

    </form>
  </div>
</div>

<!-- ADD CLASS MODAL -->
<div id="classFormModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white dark:bg-gray-800 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-lg shadow-lg p-6 relative m-4 sm:m-6">
    
    <form action="../../controller/class.php" method="post" class="space-y-8">
  <div class="ajax-result hidden p-2 rounded mt-2" role="status" aria-live="polite" style="display:none;"></div>
      <div class="space-y-4">
        <button type="button" onclick="document.getElementById('classFormModal').classList.add('hidden')" aria-label="Close class modal" class="absolute top-20 right-3 text-red-400 hover:text-gray-800 text-xl">&times;</button>
        
        <div class="form-group">
          <label for="class_name_input" class="block mb-1 font-medium dark:text-gray-200">Class Name:</label>
          <input id="class_name_input" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" type="text" name="class_name">
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
  <div class="ajax-result hidden p-2 rounded mt-2" role="status" aria-live="polite" style="display:none;"></div>
      <button type="button" onclick="document.getElementById('subjectFormModal').classList.add('hidden')" aria-label="Close subject modal" class="absolute top-20 right-3 text-red-400 hover:text-gray-800 text-xl">&times;</button>
      <div class="space-y-4">
        <div class="form-group">
          <label for="subject_code" class="block mb-1 font-medium dark:text-gray-200">Subject Code:</label>
          <input id="subject_code" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" type="text" name="subject_id"  placeholder="eg. SUBC00000">
        </div>
        <div class="form-group">
          <label for="subject_name" class="block mb-1 font-medium dark:text-gray-200">Subject Name:</label>
          <input id="subject_name" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" type="text" name="subject_name" >
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
  <div class="ajax-result hidden p-2 rounded mt-2" role="status" aria-live="polite" style="display:none;"></div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <button type="button" onclick="document.getElementById('testFormModal').classList.add('hidden')" aria-label="Close test modal" class="absolute top-20 right-3 text-red-400 hover:text-gray-800 text-xl">&times;</button>
        <div class="form-group">
          <label for="test_id_input" class="block mb-1 font-medium dark:text-gray-200">Test ID:</label>
          <input id="test_id_input" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" type="text" name="test_id" placeholder="eg. TS00000">
        </div>
        <div class="form-group">
          <label for="term_select" class="block mb-1 font-medium dark:text-gray-200">Term</label>
          <select id="term_select" name="term" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <option value="">Select Term</option>
            <option value="First Term">First Term</option>
            <option value="Second Term" >Second Term</option>
            <option value="Third Term">Third Term</option>
          </select>
        </div>
        <div class="form-group">
          <label for="type_select" class="block mb-1 font-medium dark:text-gray-200">Type</label>
          <select id="type_select" name="type" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <option value="">Select Type</option>
            <option value="Class Test">Class Test</option>
            <option value="Examination">Examination</option>
          </select>
        </div>
        <div class="form-group">
          <label for="class_select_test" class="block mb-1 font-medium dark:text-gray-200">Class</label>
          <select id="class_select_test" name="class_nm" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <option value="">Select Class</option>
            <?php
                                                              include('../../includes/database.php');
                                                              $sql = "SELECT * FROM class";
                                                              $result = $conn->query($sql);
                                                              while ($row = $result->fetch_assoc()) {
                                                                echo '<option name="class_nm" value="' . $row["class_name"] . '">' . $row["class_name"] . ' </option>';
                                                              }
                                                              //$conn->close(); ?>
          </select>
        </div>
        <div class="form-group">
          <label for="start_date" class="block mb-1 font-medium dark:text-gray-200">Start Date:</label>
          <input id="start_date" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" type="date" name="start_date" required>
        </div>
        <div class="form-group">
          <label for="end_date" class="block mb-1 font-medium dark:text-gray-200">End Date:</label>
          <input id="end_date" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" type="date" name="end_date" required>
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
