<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/helpers.php';

if (!is_logged_in()) redirect('../auth/login.php');

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = (int)($_POST['price'] ?? 0);
    if ($name && $price > 0) {
        $stmt = $conn->prepare("INSERT INTO products(name, price) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $price);
        if ($stmt->execute()) $msg = 'Thêm sản phẩm thành công';
    }
}
$products = $conn->query("SELECT id, name, price FROM products ORDER BY id DESC");
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><title>Quản lý sản phẩm</title></head>
<body>
<h2>Quản lý sản phẩm</h2>
<?php if ($msg): ?><p style="color:green"><?= htmlspecialchars($msg) ?></p><?php endif; ?>
<form method="post">
  <input name="name" placeholder="Tên món" required>
  <input name="price" type="number" placeholder="Giá (VND)" required>
  <button type="submit">Thêm</button>
</form>
<hr>
<ul>
<?php while ($p = $products->fetch_assoc()): ?>
  <li><?= htmlspecialchars($p['name']) ?> - <?= number_format($p['price']) ?> VND</li>
<?php endwhile; ?>
</ul>
</body>
</html>
