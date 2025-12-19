<?php
include_once "../includes/check_admin.php";
include "../includes/database.php";

$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);

// Xóa tráng miệng
if ($action === 'delete' && $id > 0) {
    $stmt = $conn->prepare("DELETE FROM TrangMieng WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: quanly_trangmieng.php?status=deleted");
    exit();
}

// Thêm / Cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = $_POST['ten'];
    $gia = $_POST['gia'];
    $chitiet = $_POST['chitiet'];
    $hinh = '';

    if (!empty($_FILES['hinh']['name'])) {
        $hinh = basename($_FILES['hinh']['name']);
        move_uploaded_file($_FILES['hinh']['tmp_name'], "../uploads/" . $hinh);
    }

    if (isset($_POST['add_trangmieng'])) {
        $stmt = $conn->prepare("INSERT INTO TrangMieng (TenTM, Gia, HinhAnh, ChiTiet) VALUES (?, ?, ?, ?)");
        $stmt->execute([$ten, $gia, $hinh, $chitiet]);
        header("Location: quanly_trangmieng.php?status=added");
        exit();
    }

    if (isset($_POST['update_trangmieng'])) {
        $id_update = (int)$_POST['id'];
        if ($hinh) {
            $stmt = $conn->prepare("UPDATE TrangMieng SET TenTM=?, Gia=?, HinhAnh=?, ChiTiet=? WHERE id=?");
            $stmt->execute([$ten, $gia, $hinh, $chitiet, $id_update]);
        } else {
            $stmt = $conn->prepare("UPDATE TrangMieng SET TenTM=?, Gia=?, ChiTiet=? WHERE id=?");
            $stmt->execute([$ten, $gia, $chitiet, $id_update]);
        }
        header("Location: quanly_trangmieng.php?status=updated");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Tráng Miệng</title>
    <style>
       body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 20px;
}

.container {
    max-width: 1000px;
    margin: auto;
    background: #fff;
    padding: 20px;
    border: 1px solid #ccc;
}

h1 {
    margin-top: 0;
    text-align: center;
}

form {
    margin-bottom: 20px;
}

form label {
    display: block;
    margin: 8px 0 4px;
}

form input[type="text"],
form input[type="number"],
form input[type="date"],
form textarea,
form select {
    width: 100%;
    padding: 6px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

form button {
    margin-top: 10px;
    padding: 8px 15px;
    border: 1px solid #ccc;
    background: #eee;
    cursor: pointer;
}

form button:hover {
    background: #ddd;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
}

th {
    background: #f9f9f9;
}

.action-links a {
    margin-right: 10px;
    text-decoration: none;
    color: #333;
}
.action-links a.delete {
    color: red;
}

    </style>
</head>
<body>
<div class="container">
    <a href="index.php">❮ Trở về Dashboard</a>
    <h1>Quản Lý Tráng Miệng</h1>

    <?php if ($action === 'add' || $action === 'edit'): 
        $tm = ['TenTM'=>'','Gia'=>'','HinhAnh'=>'','ChiTiet'=>'','id'=>''];
        if ($action === 'edit' && $id > 0) {
            $stmt = $conn->prepare("SELECT * FROM TrangMieng WHERE id=?");
            $stmt->execute([$id]);
            $tm = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $tm['id'] ?>">
        Tên tráng miệng: <input type="text" name="ten" value="<?= htmlspecialchars($tm['TenTM']) ?>" required><br>
        Giá: <input type="number" name="gia" value="<?= htmlspecialchars($tm['Gia']) ?>" required><br>
        Hình hiện tại: <br>
        <?php if ($tm['HinhAnh']): ?>
            <img src="../uploads/<?= htmlspecialchars($tm['HinhAnh']) ?>" width="100"><br>
        <?php endif; ?>
        Chọn hình mới: <input type="file" name="hinh"><br>
        Chi tiết: <textarea name="chitiet"><?= htmlspecialchars($tm['ChiTiet']) ?></textarea><br>
        <button type="submit" name="<?= $action==='add'?'add_trangmieng':'update_trangmieng' ?>">
            <?= $action==='add'?'Thêm':'Cập nhật' ?>
        </button>
        <a href="quanly_trangmieng.php">Hủy</a>
    </form>
    <?php endif; ?>

    <a href="?action=add" class="btn-add">+ Thêm Tráng Miệng</a>
    <table>
        <tr>
            <th>ID</th><th>Hình</th><th>Tên tráng miệng</th><th>Giá</th><th>Hành động</th>
        </tr>
        <?php
        $stmt = $conn->query("SELECT * FROM TrangMieng ORDER BY id DESC");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?php if ($row['HinhAnh']): ?><img src="../uploads/<?= htmlspecialchars($row['HinhAnh']) ?>" width="80"><?php endif; ?></td>
            <td><?= htmlspecialchars($row['TenTM']) ?></td>
            <td><?= number_format($row['Gia']) ?> đ</td>
            <td class="action-links">
                <a href="?action=edit&id=<?= $row['id'] ?>">Sửa</a>
                <a href="?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Xóa tráng miệng này?')" class="delete">Xóa</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
