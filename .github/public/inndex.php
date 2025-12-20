<?php
require_once __DIR__ . '/../config/session.php';
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Web Bán Đồ Ăn</title>
  <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
  <header>
    <h1>Web Bán Đồ Ăn</h1>
    <nav>
      <a href="../products/list.php">Món ăn</a>
      <a href="../cart/index.php">Giỏ hàng</a>
      <?php if (!empty($_SESSION['user_id'])): ?>
        <a href="../admin/index.php">Admin</a>
        <a href="../auth/logout.php">Đăng xuất</a>
      <?php else: ?>
        <a href="../auth/login.php">Đăng nhập</a>
        <a href="../auth/register.php">Đăng ký</a>
      <?php endif; ?>
    </nav>
  </header>
  <main>
    <p>Chào mừng bạn đến với cửa hàng đồ ăn trực tuyến!</p>
  </main>
</body>
</html>
