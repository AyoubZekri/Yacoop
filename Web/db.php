<?php

$host="db";
$user="root";
$pass="root";
$db="docker";

$conn=new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
    die("connection failed");
}

// التأكد من وجود الجداول
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS debts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payment_status ENUM('paid', 'unpaid') DEFAULT 'unpaid',
    debt_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// إضافة عمود user_id إذا لم يكن موجوداً (للمنشآت القديمة)
$check_column = $conn->query("SHOW COLUMNS FROM debts LIKE 'user_id'");
if ($check_column && $check_column->num_rows == 0) {
    $conn->query("ALTER TABLE debts ADD user_id INT NOT NULL AFTER id");
}
?>

