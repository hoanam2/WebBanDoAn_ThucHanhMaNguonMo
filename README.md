# Web Bán Đồ Ăn - Thực Hành Mã Nguồn Mở

## 🚀 Cài đặt môi trường
Dự án này sử dụng **PHP + MySQL** và chạy trên **WAMP**.

### 1. Cài đặt WAMP
- Tải và cài đặt WAMP từ [https://www.wampserver.com](https://www.wampserver.com).
- Sau khi cài đặt, khởi động WAMP và đảm bảo Apache + MySQL đang chạy (biểu tượng màu xanh lá cây).

### 2. Tạo database
Mở **phpMyAdmin** (http://localhost/phpmyadmin) và tạo database tên `foodshop`.

```sql
CREATE DATABASE foodshop;
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

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
