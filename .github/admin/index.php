<?php
include_once "../includes/check_admin.php"; // Bảo vệ trang
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .header { background-color: #ff914d; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .header a { color: white; text-decoration: none; font-weight: bold; }
        .container { max-width: 900px; margin: 40px auto; padding: 20px; }
        .dashboard-menu { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        .menu-item { background-color: white; padding: 30px; text-align: center; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-decoration: none; color: #333; font-size: 18px; font-weight: bold; transition: transform 0.2s, box-shadow 0.2s; }
        .menu-item:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
    </style>
</head>
<body>
    <div class="header">
        <h1>Chào mừng, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h1>
        <a href="logout.php">Đăng xuất</a>
    </div>

    <div class="container">
        <div class="dashboard-menu">
            <a href="quanly_tonghop.php" class="menu-item">
                🛍️ Quản lý món ăn
            </a>
            <a href="quanly_khachhang_tonghop.php" class="menu-item">
                👥 Quản lý tài khoản 
            </a>
            <a href="quanlykhuyenmai.php" class="menu-item">
                🎉 Quản lý Khuyến mãi
            </a>
            <a href="quanlymonnuoc.php" class="menu-item">
              🛍️ Quản Lý Món Nước
            </a>
            <a href="quanly_trangmieng.php" class="menu-item">
                 🛍️ Quản Lý TM
            </a>
             <a href="quanly_combo.php" class="menu-item">
                 🛍️ Quản Lý CB
            </a>
            <a href="quanly_donhang" class ="menu-item">
                QUẢN Lý ĐƠN HÀNG
            </a>
            
            <a href="monnoibat.php" class ="menu-item">
                QUẢN MÓN NỔI BẬC
            </a>
             <a href="quanli_taixe.php" class ="menu-item">
                QUẢN LÝ TÀI XẾ
            </a>

        </div>
    </div>
</body>
</html>
