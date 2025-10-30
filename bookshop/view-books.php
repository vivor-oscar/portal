<?php
// bookshop.php
require_once '../includes/database.php';

$classes = [
    "Creche","Nursery 1","Nursery 2","K.G 1","K.G 2",
    "Basic 1","Basic 2","Basic 3","Basic 4","Basic 5","Basic 6",
    "Basic 7","Basic 8","Basic 9"
];

$class      = $_POST['class'] ?? '';
$books      = [];
$totalPrice = 0.0;

if ($class) {
    $stmt = $conn->prepare("SELECT id, title, price FROM books WHERE class = ? ORDER BY title ASC");
    $stmt->bind_param("s", $class);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $books[]      = $row;
        $totalPrice  += (float)$row['price'];
    }
    $stmt->close();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Bookshop</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 font-sans">
  <div class="max-w-2xl mx-auto bg-white p-6 rounded-2xl shadow space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-bold">📖 School Bookshop</h1>
      <a href="login.php" class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Admin Login</a>
    </div>

    <!-- Select Class Form -->
    <form method="POST" class="flex gap-3">
      <select name="class" class="border p-2 rounded flex-1" required>
        <option value="">-- Select Class --</option>
        <?php foreach ($classes as $c): ?>
          <option value="<?= htmlspecialchars($c) ?>" <?= $class === $c ? 'selected' : '' ?>>
            <?= htmlspecialchars($c) ?>
          </option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">View</button>
    </form>

    <!-- Results -->
    <?php if (!empty($books)): ?>
      <div>
        <h2 class="text-xl font-semibold mb-2">Books for <?= htmlspecialchars($class) ?>:</h2>
        <table class="w-full border rounded text-sm">
          <thead>
            <tr class="bg-gray-200 text-left">
              <th class="p-2 border">#</th>
              <th class="p-2 border">Title</th>
              <th class="p-2 border">Price (GH₵)</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($books as $i => $book): ?>
              <tr class="hover:bg-gray-50">
                <td class="p-2 border"><?= $i + 1 ?></td>
                <td class="p-2 border"><?= htmlspecialchars($book['title']) ?></td>
                <td class="p-2 border"><?= number_format($book['price'], 2) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <!-- Total -->
        <div class="mt-4 bg-green-100 text-green-800 p-3 rounded font-bold text-right">
          Total Price: GH₵<?= number_format($totalPrice, 2) ?>
        </div>
      </div>
    <?php elseif ($class !== ''): ?>
      <div class="p-3 rounded bg-yellow-100 text-yellow-800">
        ⚠️ No books found for <?= htmlspecialchars($class) ?>.
      </div>
    <?php endif; ?>

  </div>
</body>
</html>
