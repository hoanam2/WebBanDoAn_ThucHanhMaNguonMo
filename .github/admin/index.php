<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../utils/helpers.php';

if (!is_logged_in()) {
    redirect('../auth/login.php');
}
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><title>Admin</title></head>
<body>
<h2>Trang quản trị</h2>
<nav>
  <a href="./products.php">Quản lý sản phẩm</a>
</nav>
</body>
</html>
