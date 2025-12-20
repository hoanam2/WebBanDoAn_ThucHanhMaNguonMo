<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/helpers.php';

$msg = ''; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if ($email && $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users(email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hash);
        if ($stmt->execute()) {
            $msg = 'Đăng ký thành công, hãy đăng nhập';
        } else {
            $error = 'Email đã tồn tại hoặc lỗi hệ thống';
        }
    } else {
        $error = 'Vui lòng nhập đầy đủ thông tin';
    }
}
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><title>Đăng ký</title></head>
<body>
<h2>Đăng ký</h2>
<?php if ($msg): ?><p style="color:green"><?= htmlspecialchars($msg) ?></p><?php endif; ?>
<?php if ($error): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post">
  <label>Email: <input type="email" name="email" required></label><br>
  <label>Mật khẩu: <input type="password" name="password" required></label><br>
  <button type="submit">Đăng ký</button>
</form>
</body>
</html>
