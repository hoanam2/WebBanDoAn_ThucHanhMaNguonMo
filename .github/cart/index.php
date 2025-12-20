<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';

$_SESSION['cart'] = $_SESSION['cart'] ?? [];

$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);

if ($action === 'add' && $id) {
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    header('Location: ./index.php');
    exit;
}

$total = 0;
$items = [];
if ($_SESSION['cart']) {
    $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
    $res = $conn->query("SELECT id, name, price FROM products WHERE id IN ($ids)");
    while ($row = $res->fetch_assoc()) {
        $qty = $_SESSION['cart'][$row['id']];
        $row['qty'] = $qty;
        $row['line_total'] = $qty * $row['price'];
        $total += $row['line_total'];
        $items[] = $row;
    }
}
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><title>Giỏ hàng</title></head>
<body>
<h2>Giỏ hàng</h2>
<?php if (!$items): ?>
  <p>Giỏ hàng trống</p>
<?php else: ?>
  <ul>
    <?php foreach ($items as $it): ?>
      <li><?= htmlspecialchars($it['name']) ?> x <?= $it['qty'] ?> = <?= number_format($it['line_total']) ?> VND</li>
    <?php endforeach; ?>
  </ul>
  <p><strong>Tổng:</strong> <?= number_format($total) ?> VND</p>
  <a href="./checkout.php">Thanh toán</a>
<?php endif; ?>
</body>
</html>
