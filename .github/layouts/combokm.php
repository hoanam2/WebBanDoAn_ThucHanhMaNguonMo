<?php
include("includes/database.php");

// Lấy 3 combo khuyến mãi từ bảng combo
$stmt = $conn->prepare("SELECT * FROM combo LIMIT 3");
$stmt->execute();
$combos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
.combo {
    padding: 40px 20px;
    background: linear-gradient(135deg, #ffe9d6, #ffd1b3);
    border-radius: 12px;
    margin: 20px auto;
    max-width: 1200px;
}

.combo h2 {
    text-align: center;
    font-size: 28px;
    color: #d35400;
    margin-bottom: 25px;
    font-weight: bold;
}

.combo-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
}

.combo-item {
    background: #ffffffcc;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: 0.3s;
    text-align: center;
    backdrop-filter: blur(4px);
}

.combo-item:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.combo-item img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
}

.combo-item h3 {
    margin: 12px 0 8px;
    font-size: 20px;
    color: #333;
}

.combo-item p {
    font-size: 14px;
    color: #666;
}

.old-price {
    text-decoration: line-through;
    color: #999;
}

.price {
    color: #e60000;
    font-size: 18px;
    font-weight: bold;
}

.combo-item button {
    margin-top: 10px;
    padding: 8px 14px;
    background: #e67e22;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.2s;
}

.combo-item button:hover {
    background: #d35400;
}

.btn {
    display: inline-block;
    padding: 10px 18px;
    background: #3498db;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    transition: 0.2s;
}

.btn:hover {
    background: #217dbb;
}
</style>

<section class="combo">
  <h2>🎁 Combo Khuyến Mãi</h2>

  <div class="combo-list">
    <?php if ($combos): ?>
      <?php foreach ($combos as $c): ?>
        <div class="combo-item">

          <!-- Ảnh combo -->
          <?php if (!empty($c['HinhAnh'])): ?>
            <img src="uploads/<?= htmlspecialchars($c['HinhAnh']) ?>" alt="<?= htmlspecialchars($c['TenCombo']) ?>">
          <?php else: ?>
            <img src="assets/images/no-image.png" alt="No image">
          <?php endif; ?>

          <!-- Tên combo -->
          <h3><?= htmlspecialchars($c['TenCombo']) ?></h3>

          <!-- Mô tả -->
          <p><?= htmlspecialchars($c['ChiTiet']) ?></p>

          <!-- Giá gốc -->
          <p class="old-price">Giá gốc: <?= number_format($c['GiaGoc'], 0, ',', '.') ?> VND</p>

          <!-- Giảm giá -->
          <p>Giảm giá: <?= htmlspecialchars($c['GiamGia']) ?>%</p>

          <!-- Giá cuối -->
          <p class="price">Giá sau giảm: <?= number_format($c['GiaCuoi'], 0, ',', '.') ?> VND</p>

          <!-- Nút đặt -->
          <button>Đặt Combo</button>

        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Chưa có combo nào trong hệ thống.</p>
    <?php endif; ?>
  </div>

  <!-- Liên kết sang trang combo.php -->
  <div style="text-align:center; margin-top:20px;">
    <a href="pages/combo.php" class="btn">Xem tất cả Combo</a>
  </div>
</section>
