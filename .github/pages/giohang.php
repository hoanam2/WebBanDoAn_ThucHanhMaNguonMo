<?php
session_start();
include("../includes/database.php");

// ================== XỬ LÝ THÊM MÓN VÀO GIỎ ==================
if (isset($_GET['add']) && isset($_GET['loai'])) {
    $id = (int)$_GET['add'];
    
    $loai = $_GET['loai']; // MonAn, MonNuoc, TrangMieng, Combo
    $soluong = isset($_GET['soluong']) ? (int)$_GET['soluong'] : 1;

    // Lấy thông tin món từ DB
    $stmt = $conn->prepare("SELECT * FROM $loai WHERE id = ?");
    $stmt->execute([$id]);
    $mon = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($mon) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Key duy nhất cho giỏ hàng (id + loại)
        $key = $loai . "_" . $id;

        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['soluong'] += $soluong;
        } else {
            // Xác định tên và giá theo loại
            $ten = $mon['TenMon'] ?? $mon['TenNuoc'] ?? $mon['TenTM'] ?? $mon['TenCombo'];
            $gia = $mon['Gia'] ?? $mon['GiaCuoi'];

            $_SESSION['cart'][$key] = [
                'id' => $id,
                'loai' => $loai,
                'ten' => $ten,
                'gia' => $gia,
                'soluong' => $soluong
            ];
        }
    }
    header("Location: giohang.php");
    exit();
}

// ================== XỬ LÝ TĂNG/GIẢM SỐ LƯỢNG ==================
if (isset($_GET['update']) && isset($_GET['action'])) {
    $key = $_GET['update'];
    $action = $_GET['action'];

    if (isset($_SESSION['cart'][$key])) {
        if ($action === 'increase') {
            $_SESSION['cart'][$key]['soluong']++;
        } elseif ($action === 'decrease') {
            $_SESSION['cart'][$key]['soluong']--;
            if ($_SESSION['cart'][$key]['soluong'] <= 0) {
                unset($_SESSION['cart'][$key]); // nếu giảm về 0 thì xóa luôn
            }
        }
    }
    header("Location: giohang.php");
    exit();
}

// ================== XỬ LÝ XÓA MÓN ==================
if (isset($_GET['remove'])) {
    $key = $_GET['remove'];
    if (isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
    }
    header("Location: giohang.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng - FoodZone</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 20px; }
        main { max-width: 900px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        h1 { text-align: center; margin-bottom: 20px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { border: 1px solid #ddd; padding: 12px; text-align: center; }
        table th { background-color: #f9f9f9; font-weight: bold; color: #444; }
        table tr:nth-child(even) { background-color: #fafafa; }
        .price, td strong { color: #e60000; font-weight: bold; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        p { text-align: center; color: #555; }
        .qty-btn {
            background-color: #007bff;   /* xanh dương */
            color: #fff;
            border: none;
            padding: 4px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin: 0 3px;
        }
        .qty-btn:hover {
            background-color: #0056b3;   /* xanh đậm khi hover */
        }
        .btn {
            display: inline-block;
            background-color: #28a745;
            color: #fff;
            padding: 10px 18px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 15px;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php include("../layouts/header.php"); ?>
    <main>
        <h1>🛒  GIỎ HÀNG CỦA BẠN</h1>
        <?php if (!empty($_SESSION['cart'])): ?>
            <table>
                <tr>
                    <th>Tên món</th>
                    <th>Loại</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                    <th>Hành động</th>
                </tr>
                <?php $tong = 0; ?>
                <?php foreach ($_SESSION['cart'] as $key => $item): ?>
                    <?php $thanhtien = $item['gia'] * $item['soluong']; $tong += $thanhtien; ?>
                    <tr>
                        <td><?= htmlspecialchars($item['ten']) ?></td>
                        <td><?= htmlspecialchars($item['loai']) ?></td>
                        <td>
                            <form method="get" action="giohang.php" style="display:inline;">
                                <input type="hidden" name="update" value="<?= $key ?>">
                                <input type="hidden" name="action" value="decrease">
                                <button type="submit" class="qty-btn">-</button>
                            </form>
                            <strong><?= $item['soluong'] ?></strong>
                            <form method="get" action="giohang.php" style="display:inline;">
                                <input type="hidden" name="update" value="<?= $key ?>">
                                <input type="hidden" name="action" value="increase">
                                <button type="submit" class="qty-btn">+</button>
                            </form>
                        </td>
                        <td><?= number_format($item['gia'], 0, ',', '.') ?> VND</td>
                        <td><?= number_format($thanhtien, 0, ',', '.') ?> VND</td>
                        <td><a href="giohang.php?remove=<?= $key ?>">Xóa</a></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4"><strong>Tổng cộng</strong></td>
                    <td colspan="2"><strong><?= number_format($tong, 0, ',', '.') ?> VND</strong></td>
                </tr>
            </table>
            <a href="thanhtoan.php" class="btn">Thanh toán</a>
        <?php else: ?>
            <p>Giỏ hàng đang trống.</p>
        <?php endif; ?>
    </main>

    <?php include("../layouts/footer.php"); ?>
</body>
</html>
