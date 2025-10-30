<?php
session_start();
include('include/side-bar.php');
include('../../includes/database.php');

// Determine staff id for the currently logged-in user
$staff_id = '';
$staff_name = '';
if (!empty($_SESSION['staff_id'])) {
    $staff_id = $_SESSION['staff_id'];
    $res = $conn->query("SELECT first_name, last_name FROM staff WHERE staff_id='" . $conn->real_escape_string($staff_id) . "' LIMIT 1");
    if ($res && $r = $res->fetch_assoc()) {
        $staff_name = trim(($r['first_name'] ?? '') . ' ' . ($r['last_name'] ?? ''));
    }
} elseif (!empty($_SESSION['username'])) {
    $username = $conn->real_escape_string($_SESSION['username']);
    $res = $conn->query("SELECT staff_id, first_name, last_name FROM staff WHERE username='$username' LIMIT 1");
    if ($res && $r = $res->fetch_assoc()) {
        $staff_id = $r['staff_id'];
        $staff_name = trim(($r['first_name'] ?? '') . ' ' . ($r['last_name'] ?? ''));
    }
}
?>


<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">CHECK IN HERE</h2>
            <div class="checkin-container mb-8">
                <form id="checkInForm" class="space-y-6">
                    <div>
                        <div class="flex items-center gap-3">
                            <label for="staff_display" class="block text-sm font-medium text-gray-700 mb-1">Staff ID</label>
                            <input type="text" id="staff_id" name="staff_id" value="<?= htmlspecialchars($staff_id) ?>" readonly>
                        </div>
                    </div>
                    <div>
                        <label for="checkin_code" class="block text-sm font-medium text-gray-700 mb-1">Check-in Code</label>
                        <input type="text" class="chk-input-box w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" id="checkin_code" name="checkin_code" required>
                    </div>
                    <div>
                        <button type="submit" id="checkinBtn" class="input-btn w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition">Check In</button>
                    </div>
                </form>
                <div id="message" class="message mt-4 text-center text-sm"></div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-gray-200 rounded-lg shadow">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="tab-head px-4 py-2 text-left font-semibold text-gray-700">Your ID</th>
                            <th class="tab-head px-4 py-2 text-left font-semibold text-gray-700">Check In Time</th>
                            <th class="tab-head px-4 py-2 text-left font-semibold text-gray-700">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display data
                        // Use resolved $staff_id (from session) to fetch user's attendance records
                        $sql = "SELECT * FROM staff_attendance WHERE staff_id='" . $conn->real_escape_string($staff_id) . "' ORDER BY check_in_time DESC LIMIT 50";
                        $result = mysqli_query($conn, $sql);
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $check = $row['check_in_time'];
                                $display = '';
                                if (!empty($check) && $check !== '0000-00-00 00:00:00') {
                                    try {
                                        $dt = new DateTime($check, new DateTimeZone('Africa/Accra'));
                                        $display = $dt->format('d F Y') . ' - ' . $dt->format('H:i:s');
                                    } catch (Exception $e) {
                                        $ts = strtotime($check);
                                        if ($ts !== false) {
                                            $display = date('d F Y', $ts) . ' - ' . date('H:i:s', $ts);
                                        } else {
                                            $display = $check;
                                        }
                                    }
                                }

                                echo "<tr>";
                                echo "<td class='tab-data px-4 py-2 border-t'>" . htmlspecialchars($row['staff_id']) . "</td>";
                                echo "<td class='tab-data px-4 py-2 border-t'>" . htmlspecialchars($display) . "</td>";
                                echo "<td class='tab-data px-4 py-2 border-t'><a class='delete text-red-600 hover:underline' id='autoDelete' href='delete.php?id=" . htmlspecialchars($row['id']) . "'>Delete</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='px-4 py-4 text-center text-gray-500'>You haven't entered any code today.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        (function() {
            const form = document.getElementById('checkInForm');
            const msg = document.getElementById('message');
            const btn = document.getElementById('checkinBtn');

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                msg.textContent = '';
                const staffId = document.getElementById('staff_id').value.trim();
                const code = document.getElementById('checkin_code').value.trim();

                if (!staffId) {
                    msg.textContent = 'Unable to determine your staff id. Please contact admin.';
                    msg.className = 'message mt-4 text-center text-red-600';
                    return;
                }
                if (!code) {
                    msg.textContent = 'Please enter the check-in code.';
                    msg.className = 'message mt-4 text-center text-red-600';
                    return;
                }

                btn.disabled = true;
                btn.textContent = 'Checking...';

                const data = new FormData();
                data.append('staff_id', staffId);
                data.append('checkin_code', code);

                fetch('../../controller/checkin-process.php', {
                        method: 'POST',
                        body: data
                    })
                    .then(res => res.text())
                    .then(text => {
                        msg.textContent = text;
                        // success message contains 'successful' in controller
                        if (/successful/i.test(text)) {
                            msg.className = 'message mt-4 text-center text-green-600';
                            // reload to refresh table and clear input after a short delay
                            setTimeout(() => location.reload(), 900);
                        } else {
                            msg.className = 'message mt-4 text-center text-red-600';
                            btn.disabled = false;
                            btn.textContent = 'Check In';
                        }
                    })
                    .catch(err => {
                        msg.textContent = 'Network error. Please try again.';
                        msg.className = 'message mt-4 text-center text-red-600';
                        btn.disabled = false;
                        btn.textContent = 'Check In';
                    });
            });
        })();
    </script>