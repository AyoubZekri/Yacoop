<?php
session_start();
include 'db.php';

// Authentication Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'register') {
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        if ($conn->query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')")) {
            header("Location: login.php?msg=success");
        } else {
            header("Location: register.php?error=exists");
        }
        exit();
    }
    
    if ($_POST['action'] === 'login') {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];
        $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit();
            }
        }
        header("Location: login.php?error=invalid");
        exit();
    }
}

// Logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Redirect if not logged in
$current_page = basename($_SERVER['PHP_SELF']);
if (!isset($_SESSION['user_id']) && !in_array($current_page, ['login.php', 'register.php'])) {
    header("Location: login.php");
    exit();
}

$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

// Product Management
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_product') {
        $name = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['description']);
        $price = (float)$_POST['price'];
        $stock = (int)$_POST['stock'];
        
        if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
            $id = (int)$_POST['product_id'];
            $conn->query("UPDATE products SET name='$name', description='$description', price=$price, stock=$stock WHERE id=$id AND user_id=$user_id");
        } else {
            $conn->query("INSERT INTO products (user_id, name, description, price, stock) VALUES ($user_id, '$name', '$description', $price, $stock)");
        }
        header("Location: products.php");
        exit();
    }

    if ($_POST['action'] === 'add_sale') {
        $customer_name = $conn->real_escape_string($_POST['customer_name']);
        $sale_date = $conn->real_escape_string($_POST['sale_date']);
        $total_amount = (float)$_POST['total_amount'];
        $products_data = $_POST['products']; // JSON or array of {id, qty, price}

        $conn->query("INSERT INTO sales (user_id, customer_name, total_amount, sale_date) VALUES ($user_id, '$customer_name', $total_amount, '$sale_date')");
        $sale_id = $conn->insert_id;

        foreach ($products_data as $item) {
            $p_id = (int)$item['id'];
            $qty = (int)$item['qty'];
            $u_price = (float)$item['price'];
            $subtotal = $qty * $u_price;
            $conn->query("INSERT INTO sale_items (sale_id, product_id, quantity, unit_price, subtotal) VALUES ($sale_id, $p_id, $qty, $u_price, $subtotal)");
            // Update stock
            $conn->query("UPDATE products SET stock = stock - $qty WHERE id = $p_id");
        }
        header("Location: list_sales.php");
        exit();
    }
}

// Delete Product
if (isset($_GET['delete_product'])) {
    $id = (int)$_GET['delete_product'];
    $conn->query("DELETE FROM products WHERE id = $id AND user_id = $user_id");
    header("Location: products.php");
    exit();
}

// Fetch Data
$products = [];
$sales = [];
$debts = [];

if ($user_id > 0) {
    // Products
    $res = $conn->query("SELECT * FROM products WHERE user_id = $user_id ORDER BY name ASC");
    while ($row = $res->fetch_assoc()) $products[] = $row;

    // Sales
    $res = $conn->query("SELECT * FROM sales WHERE user_id = $user_id ORDER BY created_at DESC");
    while ($row = $res->fetch_assoc()) $sales[] = $row;

    // Debts (Keep for compatibility)
    $res = $conn->query("SELECT * FROM debts WHERE user_id = $user_id ORDER BY created_at DESC");
    while ($row = $res->fetch_assoc()) $debts[] = $row;
}