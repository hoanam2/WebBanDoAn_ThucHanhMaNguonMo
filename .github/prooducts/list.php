<?php
require_once __DIR__ . '/../config/db.php';
$result = $conn->query("SELECT id, name, price FROM products ORDER BY id DESC");
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><title>Danh sách món</title></head>
<body>
<h2>Món ăn</h2>
<ul>
<?php while ($p = $result->fetch_assoc()): ?>
  <li>
    <?= htmlspecialchars($p['name']) ?> - <?= number_format($p['price']) ?> VND
    <a href="../cart/index.php?action=add&id=<?= $p['id'] ?>">Thêm vào giỏ</a>
  </li>
<?php endwhile; ?>
</ul>
</body>
</html>
