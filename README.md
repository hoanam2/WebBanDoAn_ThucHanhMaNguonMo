# WebBanDoAn_ThucHanhMaNguonMo


Dự án web bán đồ ăn (PHP + MySQL) tối giản để thực hành.

## Yêu cầu
- PHP 8+
- MySQL
- warm

## Cài đặt
1. Tạo database `foodshop`.
2. Tạo bảng:
   ```sql
   CREATE TABLE users (
     id INT AUTO_INCREMENT PRIMARY KEY,
     email VARCHAR(255) UNIQUE NOT NULL,
     password VARCHAR(255) NOT NULL,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

   CREATE TABLE products (
     id INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(255) NOT NULL,
     price INT NOT NULL,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
