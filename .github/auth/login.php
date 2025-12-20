<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/helpers.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if ($email && $password) {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                redirect('../public/index.php');
            } else {
                $error = 'Sai mật khẩu';
            }
        } else {
            $error = 'Email không tồn tại';
        }
    } else {
        $error = 'Vui lòng nhập đầy đủ thông tin';
    }
}
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><title>Đăng nhập</title></head>
<body>
<h2>Đăng nhập</h2>
<?php if ($error): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post">
  <label>Email: <input type="email" name="email" required></label><br>
  <label>Mật khẩu: <input type="password" name="password" required></label><br>
  <button type="submit">Đăng nhập</button>
</form>
</body>
</html>
