<?php
session_start();
require_once 'includes/database.php';
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["user_name"]))
{
    header("Location: dangnhap.php");
    exit();
}
$username = $_SESSION["user_name"]; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="assets/css/style.css"> 
    <title>Document</title>
    <style>
     
      .combo {
  background: #fff0e6;
  padding: 50px 20px;
  text-align: center;
}

.combo h2 {
  font-size: 2em;
  color: #ff6600;
  margin-bottom: 30px;
}

.combo-list {
  display: flex;
  justify-content: center;
  gap: 30px;
  flex-wrap: wrap;
}

.combo-item {
  background: white;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  padding: 20px;
  width: 300px;
  transition: 0.3s;
}

.combo-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

.combo-item img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 15px;
}

.combo-item h3 {
  font-size: 1.4em;
  color: #ff6600;
  margin-bottom: 10px;
}

.combo-item p {
  font-size: 1em;
  color: #555;
  margin-bottom: 10px;
}

.combo-item .price {
  font-weight: bold;
  color: #e65c00;
}

.combo-item button {
  background: #ff6600;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  font-size: 1em;
  cursor: pointer;
  transition: 0.3s;
}

.combo-item button:hover {
  background: #e65c00;
}

        /* Thanh header chính */
header {
  background-color: #ff914d; /* Màu cam tươi */
  color: white;
  display: flex;
  justify-content: space-between; /* Logo trái, menu phải */
  align-items: center;
  padding: 15px 40px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
  position: relative; /* Added for dropdown positioning */
}

/* Logo */
.logo {
  font-size: 24px;
  font-weight: bold;
  cursor: pointer;
}

/* Menu */
nav ul {
  list-style: none;
  display: flex;
  gap: 30px; /* Khoảng cách giữa các mục */
}

/* Liên kết menu */
nav ul li {
  position: relative; /* Make parent li a positioning context */
}

nav ul li a {
  text-decoration: none;
  color: white;
  font-size: 16px;
  font-weight: 500;
  transition: 0.3s;
  padding: 5px 0; /* Add padding for better hover area */
  display: block; /* Make the whole area clickable */
}

/* Hiệu ứng hover cho menu chính */
nav ul li a:hover {
  color: #ffe082; /* vàng nhạt */
  text-decoration: underline;
}

/* Dropdown menu */
nav ul li ul {
  display: none; /* Hide by default */
  position: absolute;
  background-color: #ff914d; /* Same as header */
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  top: 100%; /* Position below the parent */
  left: 0;
  padding: 10px 0;
  border-radius: 0 0 8px 8px; /* Rounded corners at the bottom */
  flex-direction: column; /* Stack items vertically */
  gap: 0; /* Remove gap for dropdown items */
}

nav ul li ul li {
  width: 100%; /* Full width for dropdown items */
}

nav ul li ul li a {
  padding: 10px 20px; /* Padding for dropdown links */
  white-space: nowrap; /* Prevent text wrapping */
}

/* Show dropdown on hover */
nav ul li:hover > ul {
  display: flex; /* Show dropdown as flex column */
}


/* ----- PHẦN BANNER ----- */
.banner {
    text-align: center;
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(assets/images/pexels-ash-craig-122861-376464.jpg) center / cover no-repeat;
    color: white;
    padding: 55px 20px;
    border-radius: 10px;
    margin: 20px auto;
    max-width: 1454px;
}

.banner h1 {
    font-size: 48px;
    font-weight: bold;
    margin-bottom: 15px;
    text-shadow: 2px 2px 5px rgba(0,0,0,0.6); /* Đổ bóng chữ */
}

.banner p {
    font-size: 20px;
    margin-bottom: 25px;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.4);
}

.banner img {
    margin-top: 20px;
    width: 600px;
    max-width: 100%;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    transition: transform 0.3s ease;
}

.banner img:hover {
    transform: scale(1.05);  /* Phóng to nhẹ khi hover */
}
/* --- PHẦN MÓN NỔI BẬT --- */
.featured {
  text-align: center;
  padding: 50px 20px;
  background: #fff8f0;
}

.featured h2 {
  font-size: 2em;
  margin-bottom: 30px;
  color: #333;
  font-weight: 700;
}

/* Danh sách món ăn */
.food-list {
  display: flex;
  justify-content: center;
  gap: 30px;
  flex-wrap: wrap;
}

/* Từng món ăn */
.food-item {
  background: white;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  padding: 20px;
  width: 300px;
  transition: 0.3s;
}

.food-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

/* Ảnh món ăn */
.food-item img {
  width: 100%;
  height: 200px;
  border-radius: 10px;
  object-fit: cover;
  margin-bottom: 15px;
}

/* Tên món */
.food-item h3 {
  font-size: 1.3em;
  color: #ff6600;
  margin-bottom: 10px;
}

/* Giá */
.food-item p {
  font-size: 1.1em;
  color: #555;
  margin-bottom: 15px;
}

/* Nút đặt */
.food-item button {
  background: #ff6600;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  font-size: 1em;
  cursor: pointer;
  transition: 0.3s;
}

.food-item button:hover {
  background: #e65c00;
}


    </style>
</head>
<body>
  <!--HEADER-->
<?php include("layouts/header.php"); ?>
<!-- PHẦN BANNER -->
<?php include("layouts/banner.php") ?>
<!-- MÓN NỔI BẬT-->
 <?php  include("layouts/monnoibac.php")?>
<!-- COMBO KM ------>
<?php include("layouts/combokm.php") 
?>
<!-- giới thiệu----->
<section class="about">
  <div class="about-content">
    <h2>🍽️ Giới thiệu về FoodZone</h2>
    <p>
      FoodZone là điểm đến lý tưởng cho những tín đồ ẩm thực hiện đại. Với không gian ấm cúng, thực đơn đa dạng từ món Âu đến món Á, chúng tôi cam kết mang đến trải nghiệm ăn uống tuyệt vời nhất cho mọi khách hàng.
    </p>
    <p>
      Đội ngũ đầu bếp chuyên nghiệp, nguyên liệu tươi ngon mỗi ngày, cùng dịch vụ giao hàng nhanh chóng giúp bạn thưởng thức món ngon mọi lúc mọi nơi.
    </p>
    <p>
      Hãy đến với FoodZone để cảm nhận sự khác biệt trong từng món ăn và từng nụ cười phục vụ!
    </p>
  </div>
</section>
<!--GOOGLE-->
  <h2>📍 Vị trí quán FoodZone</h2>
<iframe
  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.123456789!2d106.700000!3d10.800000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1234567890abcdef%3A0xabcdef1234567890!2sFoodZone!5e0!3m2!1svi!2s!4v1234567890"
  width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
</iframe>
<!--CHÂN TRANG-->
 <?php include("layouts/footer.php"); ?>
</body>
</html>

