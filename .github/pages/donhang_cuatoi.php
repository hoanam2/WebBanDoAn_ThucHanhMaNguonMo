<?php
session_start();
include("../includes/database.php");
include("../includes/OrderService.php");

$orderService = new OrderService($conn);

// ✅ Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    die("❌ Vui lòng đăng nhập để xem đơn hàng của bạn.");
}

$user_id = $_SESSION['user_id'];

// ✅ Lấy danh sách đơn hàng của khách
$donhangs = $orderService->getOrdersByUser($user_id);

// ✅ Hàm hiển thị trạng thái theo ENUM
function hienThiTrangThai($trang_thai)
{
    switch ($trang_thai)
    {
        case 'cho_duyet': return "⏳ Chờ phê duyệt";
        case 'dang_xu_ly': return "✅ Đã duyệt – Chờ giao";
        case 'dang_giao': return "🚚 Đang giao";
        case 'hoan_thanh': return "🎉 Hoàn tất";
        case 'huy': return "❌ Đã hủy";
        default: return "Không xác định";
    }
}

// ✅ CSS class theo trạng thái
function trangThaiClass($trang_thai)
{
    return [
        'cho_duyet' => "pending",
        'dang_xu_ly' => "approved",
        'dang_giao' => "shipping",
        'hoan_thanh' => "completed",
        'huy' => "cancelled"
    ][$trang_thai] ?? "";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đơn hàng của tôi</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f4f4f4; padding:20px; }
    h1 { text-align:center; color:#333; }
    table { width:100%; border-collapse:collapse; margin-top:20px; background:#fff; }
    th, td { border:1px solid #ccc; padding:10px; text-align:center; }
    th { background:#eee; }
    .status { font-weight:bold; }
    .pending { color:#ff9800; }
    .approved { color:#2196f3; }
    .shipping { color:#4caf50; }
    .completed { color:#673ab7; }
    .cancelled { color:#f44336; }
    button { cursor:pointer; }
  </style>
</head>
<body>

<!-- Nút quay về trang chủ -->
<button onclick="window.location.href='/web_bandoan/index.php'" 
        style="padding:10px 20px; background-color:#ff6600; 
        color:white; border:none; border-radius:8px;">
    🏠 Quay về trang chủ
</button>

<h1>📦 Đơn hàng của tôi</h1>

<table>
    <tr>
      <th>ID</th>
      <th>Ngày đặt</th>
      <th>Tổng tiền</th>
      <th>Trạng thái</th>
      <th>Hủy đơn</th>
    </tr>

    <?php if (empty($donhangs)): ?>
      <tr><td colspan="5">Bạn chưa có đơn hàng nào.</td></tr>

    <?php else: ?>
      <?php foreach ($donhangs as $dh): ?>

        <tr>
          <td><?= $dh['don_hang_id'] ?></td>
          <td><?= $dh['ngay_dat'] ?></td>
          <td><?= number_format($dh['tong_tien'], 0, ',', '.') ?> VND</td>

          <!-- ✅ Hiển thị trạng thái -->
          <td class="status <?= trangThaiClass($dh['trang_thai']) ?>">
            <?= hienThiTrangThai($dh['trang_thai']) ?>
          </td>

          <!-- ✅ Chỉ cho hủy khi trạng thái = cho_duyet -->
          <td>
            <?php if ($dh['trang_thai'] === 'cho_duyet'): ?>
                <form action="huydon.php" method="post" 
                      onsubmit="return confirm('Bạn có chắc muốn hủy đơn này?')">
                    <input type="hidden" name="cancel_order" value="1">
                    <input type="hidden" name="don_hang_id" value="<?= $dh['don_hang_id'] ?>">
                    <input type="hidden" name="ly_do" value="Người dùng tự hủy">
                    <button type="submit">❌ Hủy</button>
                </form>
            <?php else: ?>
                ❌ Không thể hủy
            <?php endif; ?>
          </td>
        </tr>

      <?php endforeach; ?>
    <?php endif; ?>
</table>

</body>
</html>
