<?php
$host="mysql_host";
$user="root";
$pass="root";
$db="docker";

$max_retries = 5;
$retry_count = 0;
$conn = null;

while ($retry_count < $max_retries) {
    try {
        $conn = new mysqli($host, $user, $pass, $db);
        if (!$conn->connect_error) {
            break;
        }
    } catch (Exception $e) {
        sleep(2);
        $retry_count++;
    }
}

if (!$conn || $conn->connect_error) {
    die("تعذر الاتصال بقاعدة البيانات. يرجى التأكد من تشغيل حاوية MySQL.");
}

$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    customer_name VARCHAR(255),
    total_amount DECIMAL(10, 2) NOT NULL,
    sale_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS sale_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL
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

$check_column = $conn->query("SHOW COLUMNS FROM debts LIKE 'user_id'");
if ($check_column && $check_column->num_rows == 0) {
    $conn->query("ALTER TABLE debts ADD user_id INT NOT NULL AFTER id");
}