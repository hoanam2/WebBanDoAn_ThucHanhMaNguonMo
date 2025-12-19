<?php
include_once "../includes/check_admin.php";

if (!is_admin()) {
    die("Bạn không có quyền truy cập trang này.");
}

include "../includes/database.php";

//======================================================================
// PHẦN XỬ LÝ LOGIC (THÊM, SỬA, XÓA)
//======================================================================

$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);

// --- XÓA MÓN ĂN ---
if ($action === 'delete_monan' && $id > 0) {
    $stmt = $conn->prepare("DELETE FROM MonAn WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: quanly_tonghop.php?tab=monan&status=deleted");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Thêm món ăn
    if (isset($_POST['add_monan'])) {
        $ten = $_POST['ten'];
        $gia = $_POST['gia'];
        $chitiet = $_POST['chitiet'];
        $loaimonan = $_POST['loaimonan'];
        $hinh = '';
        if (!empty($_FILES['hinh']['name'])) {
            $hinh = basename($_FILES['hinh']['name']);
            move_uploaded_file($_FILES['hinh']['tmp_name'], "../uploads/" . $hinh);
        }
        $stmt = $conn->prepare("INSERT INTO MonAn (TenMon, Gia, HinhAnh, ChiTiet, LoaiMonAn) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$ten, $gia, $hinh, $chitiet, $loaimonan]);
        header("Location: quanly_tonghop.php?tab=monan&status=added");
        exit();
    }

    // Cập nhật món ăn
    if (isset($_POST['update_monan'])) {
        $id_update = $_POST['id'];
        $ten = $_POST['ten'];
        $gia = $_POST['gia'];
        $chitiet = $_POST['chitiet'];
        $loaimonan = $_POST['loaimonan'];

        if (!empty($_FILES['hinh']['name'])) {
            $hinh = basename($_FILES['hinh']['name']);
            move_uploaded_file($_FILES['hinh']['tmp_name'], "../uploads/" . $hinh);
            $stmt = $conn->prepare("UPDATE MonAn SET TenMon=?, Gia=?, HinhAnh=?, ChiTiet=?, LoaiMonAn=? WHERE id=?");
            $stmt->execute([$ten, $gia, $hinh, $chitiet, $loaimonan, $id_update]);
        } else {
            $stmt = $conn->prepare("UPDATE MonAn SET TenMon=?, Gia=?, ChiTiet=?, LoaiMonAn=? WHERE id=?");
            $stmt->execute([$ten, $gia, $chitiet, $loaimonan, $id_update]);
        }
        header("Location: quanly_tonghop.php?tab=monan&status=updated");
        exit();
    }
}
//======================================================================
// PHẦN HIỂN THỊ GIAO DIỆN (VIEW)
//======================================================================
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Cửa Hàng</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 20px; }
        .container { max-width: 1200px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1, h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f7f7f7; }
        .action-links a { margin-right: 10px; text-decoration: none; color: #007bff; }
        .action-links a.delete { color: #dc3545; }
        .tabs { border-bottom: 2px solid #ddd; padding-bottom: 10px; margin-bottom: 20px; }
        .tabs a { padding: 10px 20px; text-decoration: none; color: #555; font-weight: bold; }
        .tabs a.active { color: #ff914d; border-bottom: 2px solid #ff914d; }
        .form-container { background-color: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        input, textarea, select { width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #ff914d; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-add { display: inline-block; background-color: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin-bottom: 20px; }
        .admin-nav { margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="admin-nav">
        <a href="index.php">❮ Trở về Dashboard</a>
    </div>
    <h1>Quản LÝ Món ĂN</h1>

    <?php $tab = $_GET['tab'] ?? 'monan'; ?>
    <div class="tabs">
        <a href="?tab=monan" class="<?= $tab === 'monan' ? 'active' : '' ?>">Quản lý Món ăn</a>
    </div>

    <?php if ($tab === 'monan'): ?>
        <?php
        // HIỂN THỊ FORM THÊM/SỬA MÓN ĂN
        if ($action === 'add' || $action === 'edit') {
            $mon = ['TenMon' => '', 'Gia' => '', 'HinhAnh' => '', 'ChiTiet' => '', 'LoaiMonAn' => 'Món ăn', 'id' => ''];
            if ($action === 'edit' && $id > 0) {
                $stmt = $conn->prepare("SELECT * FROM MonAn WHERE id = ?");
                $stmt->execute([$id]);
                $mon = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        ?>
            <div class="form-container">
                <h2><?= $action === 'add' ? 'Thêm Món Ăn Mới' : 'Chỉnh Sửa Món Ăn' ?></h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $mon['id'] ?>">
                    Tên món: <input type="text" name="ten" value="<?= htmlspecialchars($mon['TenMon']) ?>" required><br>
                    Giá: <input type="number" name="gia" value="<?= htmlspecialchars($mon['Gia']) ?>" required><br>
                
                    Hình hiện tại: <br>
                    <?php if (!empty($mon['HinhAnh'])): ?>
                        <img src="../uploads/<?= htmlspecialchars($mon['HinhAnh']) ?>" width="100"><br>
                    <?php endif; ?>
                    Chọn hình mới: <input type="file" name="hinh"><br>
                    Chi tiết: <br>
                    <textarea name="chitiet"><?= htmlspecialchars($mon['ChiTiet']) ?></textarea><br>
                    <button type="submit" name="<?= $action === 'add' ? 'add_monan' : 'update_monan' ?>">
                        <?= $action === 'add' ? 'Thêm' : 'Cập nhật' ?>
                    </button>
                    <a href="?tab=monan">Hủy</a>
                </form>
            </div>
        <?php } ?>

        <!-- HIỂN THỊ DANH SÁCH MÓN ĂN -->
        <a href="?tab=monan&action=add" class="btn-add">+ Thêm Món Ăn</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Hình</th>
                <th>Tên món</th>
                <th>Loại</th>
                <th>Giá</th>
                <th>Hành động</th>
            </tr>
            <?php
            // Lấy dữ liệu bằng PDO
            $stmt = $conn->query("SELECT * FROM MonAn ORDER BY id DESC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td>
                    <?php if (!empty($row['HinhAnh'])): ?>
                        <img src="../uploads/<?= htmlspecialchars($row['HinhAnh']) ?>" width="80">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['TenMon']) ?></td>
               
                <td><?= number_format($row['Gia']) ?> đ</td>
                <td class="action-links">
                    <a href="?tab=monan&action=edit&id=<?= $row['id'] ?>">Sửa</a>
                    <a href="?tab=monan&action=delete_monan&id=<?= $row['id'] ?>"
                       onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                       class="delete">Xóa</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
