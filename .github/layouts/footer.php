<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
         .footer {
  background-color: #ff914d;
  color: white;
  padding: 40px 20px 20px;
  font-size: 14px;
}

.footer-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 30px;
  max-width: 1200px;
  margin: 0 auto;
}

.footer-about,
.footer-links,
.footer-contact {
  flex: 1;
  min-width: 250px;
}

.footer h3,
.footer h4 {
  margin-bottom: 15px;
  font-size: 18px;
  color: #fffde7;
}

.footer p,
.footer a {
  color: white;
  text-decoration: none;
  margin-bottom: 8px;
  display: block;
}

.footer a:hover {
  text-decoration: underline;
  color: #ffe082;
}

.footer-bottom {
  text-align: center;
  margin-top: 30px;
  border-top: 1px solid rgba(255,255,255,0.3);
  padding-top: 15px;
  font-size: 13px;
}

      .about {
  background: #fff8f0;
  padding: 60px 20px;
  text-align: center;
}

.about-content {
  max-width: 800px;
  margin: 0 auto;
}

.about h2 {
  font-size: 2.2em;
  color: #ff6600;
  margin-bottom: 25px;
}

.about p {
  font-size: 1.1em;
  color: #444;
  line-height: 1.6;
  margin-bottom: 20px;
}
    </style>
</head>
<body>
    <footer class="footer">
  <div class="footer-container">
    <div class="footer-about">
      <h3>🍔 FoodZone</h3>
      <p>FoodZone là nơi hội tụ những món ăn ngon, phục vụ nhanh chóng và tận tâm. Cảm ơn bạn đã đồng hành cùng chúng tôi!</p>
    </div>
    <div class="footer-links">
      <h4>Liên kết nhanh</h4>
      <ul>
        <li><a href="#">Trang chủ</a></li>
        <li><a href="#">Menu</a></li>
        <li><a href="#">Khuyến mãi</a></li>
        <li><a href="giohang.php">Giỏ hàng</a></li>
      </ul>
    </div>
    <div class="footer-contact">
      <h4>Liên hệ</h4>
      <p>📍 123 Đường Ăn Uống, Quận 1, TP.HCM</p>
      <p>📞 0909 123 456</p>
      <p>📧 support@foodzone.vn</p>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; 2025 FoodZone. All rights reserved.</p>
  </div>
</footer>
</body>
</html>
