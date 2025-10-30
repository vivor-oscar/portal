<?php
// admin_add_book.php
session_start();
require_once '../includes/database.php';
require_once '../includes/logger.php';

// --- Security: protect page ---
if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$msg = '';

// --- Handle Book Addition ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titles  = $_POST['title'] ?? [];
    $prices  = $_POST['price'] ?? [];
    $classes = $_POST['class'] ?? [];

    $added   = 0;
    $skipped = 0;

    foreach ($titles as $i => $title) {
        $title = trim($title);
        $price = $prices[$i] ?? '';
        $class = $classes[$i] ?? '';

        if ($title === '' || $price === '' || $class === '') {
            $skipped++;
            continue;
        }

        $stmt = $conn->prepare("INSERT INTO books (title, price, class) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $title, $price, $class);

        if ($stmt->execute()) {
            $added++;
      // log add book
      session_start();
      $user_id = $_SESSION['admin_id'] ?? '';
      $username = $_SESSION['username'] ?? '';
      log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'administrator', 'add_book', "title={$title};class={$class};price={$price}");
        }
        $stmt->close();
    }

    if ($added > 0 && $skipped === 0) {
        $msg = "✅ $added book(s) added successfully!";
    } elseif ($added > 0 && $skipped > 0) {
        $msg = "⚠️ $added book(s) added, but $skipped skipped due to missing fields.";
    } else {
        $msg = "❌ No books added. Please fill all fields.";
    }
}

// --- Handle Book Deletion ---
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $stmt   = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $del_id);
    $stmt->execute();
    $stmt->close();
  // log deletion
  session_start();
  $user_id = $_SESSION['admin_id'] ?? '';
  $username = $_SESSION['username'] ?? '';
  log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'administrator', 'delete_book', "id={$del_id}");

    header("Location: add-book.php?class=" . urlencode($_GET['class'] ?? ''));
    exit;
}

// --- Pagination & Class Filter ---
$classes        = ["Creche","Nursery 1","Nursery 2","K.G 1","K.G 2",
                   "Basic 1","Basic 2","Basic 3","Basic 4","Basic 5","Basic 6",
                   "Basic 7","Basic 8","Basic 9"];

$selected_class = $_GET['class'] ?? '';
$per_page       = 10;
$page           = max(1, intval($_GET['page'] ?? 1));
$where          = $selected_class ? "WHERE class = ?" : "";

// Count total
if ($selected_class) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM books WHERE class = ?");
    $stmt->bind_param("s", $selected_class);
} else {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM books");
}
$stmt->execute();
$stmt->bind_result($total_books);
$stmt->fetch();
$stmt->close();

$offset = ($page - 1) * $per_page;

// Fetch books
if ($selected_class) {
    $stmt = $conn->prepare("SELECT * FROM books WHERE class = ? ORDER BY id DESC LIMIT ?, ?");
    $stmt->bind_param("sii", $selected_class, $offset, $per_page);
} else {
    $stmt = $conn->prepare("SELECT * FROM books ORDER BY id DESC LIMIT ?, ?");
    $stmt->bind_param("ii", $offset, $per_page);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Add Book</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 font-sans">
  <div class="max-w-3xl mx-auto space-y-8">

    <!-- Top Section -->
    <div class="bg-white p-6 rounded-2xl shadow">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">📚 Manage Books</h1>
        <div class="text-sm">
          <a href="view-books.php" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Bookshop -></a>
          <a href="../logout.php" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700">Logout</a>
        </div>
      </div>

      <!-- Status Message -->
      <?php if (!empty($msg)): ?>
        <div class="bg-blue-100 text-blue-800 p-3 rounded mb-4"><?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>

      <!-- Add Book Form -->
      <form method="POST" class="space-y-4" id="booksForm">
        <div id="booksContainer">
          <div class="book-row grid grid-cols-3 gap-2 mb-2">
            <input type="text" name="title[]" placeholder="Book Title" class="border p-2 rounded" required>
            <input type="number" step="0.01" name="price[]" placeholder="Price" class="border p-2 rounded" required>
            <select name="class[]" class="border p-2 rounded" required>
              <option value="">-- Select Class --</option>
              <?php foreach ($classes as $c): ?>
                <option value="<?= htmlspecialchars($c) ?>"><?= htmlspecialchars($c) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="flex gap-3">
          <button type="button" onclick="addBookRow()" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">+ Add Another</button>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Save Book(s)</button>
        </div>
      </form>
    </div>

    <!-- Book List -->
    <div class="bg-white p-6 rounded-2xl shadow">
      <form method="GET" class="mb-4 flex gap-2 items-center">
        <label class="font-semibold">Filter:</label>
        <select name="class" onchange="this.form.submit()" class="border p-2 rounded">
          <option value="">All Classes</option>
          <?php foreach ($classes as $c): ?>
            <option value="<?= htmlspecialchars($c) ?>" <?= $selected_class == $c ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
          <?php endforeach; ?>
        </select>
      </form>

      <h2 class="text-xl font-bold mb-2">Books <?= $selected_class ? ' - ' . htmlspecialchars($selected_class) : '' ?></h2>
      <table class="w-full border mb-4 text-sm">
        <thead>
          <tr class="bg-gray-200 text-left">
            <th class="p-2 border">Title</th>
            <th class="p-2 border">Price</th>
            <th class="p-2 border">Class</th>
            <th class="p-2 border">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr class="hover:bg-gray-50">
                <td class="p-2 border"><?= htmlspecialchars($row['title']) ?></td>
                <td class="p-2 border">₵<?= number_format($row['price'], 2) ?></td>
                <td class="p-2 border"><?= htmlspecialchars($row['class']) ?></td>
                <td class="p-2 border">
                  <a href="?delete=<?= $row['id'] ?>&class=<?= urlencode($selected_class) ?>" 
                     onclick="return confirm('Delete this book?')" 
                     class="text-red-600 hover:underline">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="4" class="p-2 border text-center text-gray-500">No books found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>

      <!-- Pagination -->
      <?php if ($total_books > $per_page): ?>
        <div class="flex gap-2 justify-center">
          <?php for ($i = 1; $i <= ceil($total_books / $per_page); $i++): ?>
            <a href="?class=<?= urlencode($selected_class) ?>&page=<?= $i ?>" 
               class="px-3 py-1 rounded <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' ?>">
              <?= $i ?>
            </a>
          <?php endfor; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- JS: Dynamic Book Row -->
  <script>
    function addBookRow() {
      const container = document.getElementById('booksContainer');
      const row = document.createElement('div');
      row.className = 'book-row grid grid-cols-3 gap-2 mb-2';
      row.innerHTML = `
        <input type="text" name="title[]" placeholder="Book Title" class="border p-2 rounded" required>
        <input type="number" step="0.01" name="price[]" placeholder="Price" class="border p-2 rounded" required>
        <select name="class[]" class="border p-2 rounded" required>
          <option value="">-- Select Class --</option>
          <?php foreach ($classes as $c): ?>
            <option value="<?= htmlspecialchars($c) ?>"><?= htmlspecialchars($c) ?></option>
          <?php endforeach; ?>
        </select>
      `;
      container.appendChild(row);
    }
  </script>
</body>
</html>
