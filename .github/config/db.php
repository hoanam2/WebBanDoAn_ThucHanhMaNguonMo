<?php
$DB_HOST = 'localhost';
$DB_NAME = 'foodshop';
$DB_USER = 'root';
$DB_PASS = '';

try {
    // DSN (Data Source Name)
    $dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";

    // Tạo đối tượng PDO
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS);

    // Thiết lập chế độ báo lỗi
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Thiết lập chế độ fetch mặc định
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
