<?php
// login.php
session_start();
require_once '../includes/database.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $conn->prepare("SELECT admin_id, password FROM administrator WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $hash);
            $stmt->fetch();

            if (password_verify($password, $hash)) {
                // Login success
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id']       = $id;
                $_SESSION['admin_user']     = $username;

                header("Location: add-book.php");
                exit;
            } else {
                $msg = "❌ Incorrect username or password.";
            }
        } else {
            $msg = "❌ Incorrect username or password.";
        }
        $stmt->close();
    } else {
        $msg = "⚠️ Please enter both username and password.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">
  <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">
    <h1 class="text-2xl font-bold mb-6 text-center">🔐 Admin Login</h1>

    <!-- Error Message -->
    <?php if ($msg): ?>
      <div class="mb-4 p-3 rounded bg-red-100 text-red-700 text-sm">
        <?= htmlspecialchars($msg) ?>
      </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="post" class="space-y-5">
      <div>
        <label class="block text-sm font-medium mb-1">Username</label>
        <input name="username" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 outline-none" required>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Password</label>
        <div class="relative">
          <input id="password" name="password" type="password" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 outline-none" required>
          <button type="button" onclick="togglePassword()" class="absolute right-2 top-2 text-xs text-gray-500 hover:text-gray-700">Show</button>
        </div>
      </div>

      <div class="flex items-center justify-between">
        <button class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Login</button>
        <a href="view-books.php" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">← Back to Shop</a>
      </div>
    </form>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      const btn   = event.target;
      if (input.type === "password") {
        input.type = "text";
        btn.textContent = "Hide";
      } else {
        input.type = "password";
        btn.textContent = "Show";
      }
    }
  </script>
</body>
</html>
