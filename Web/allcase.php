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

// Debt Management
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customer_name'], $_POST['amount'])) {
    $customer_name = $conn->real_escape_string($_POST['customer_name']);
    $amount = (float)$_POST['amount'];
    $debt_date = $conn->real_escape_string($_POST['debt_date']);
    $payment_status = $_POST['payment_status'];
    
    if (isset($_POST['debt_id']) && !empty($_POST['debt_id'])) {
        // Edit (Strict check on user_id)
        $id = (int)$_POST['debt_id'];
        $conn->query("UPDATE debts SET customer_name='$customer_name', amount=$amount, debt_date='$debt_date', payment_status='$payment_status' WHERE id=$id AND user_id=$user_id");
    } else {
        // Add
        $conn->query("INSERT INTO debts (user_id, customer_name, amount, debt_date, payment_status) VALUES ($user_id, '$customer_name', $amount, '$debt_date', '$payment_status')");
    }
    header("Location: list_debts.php");
    exit();
}

// Delete
if (isset($_GET['delete_debt'])) {
    $id = (int)$_GET['delete_debt'];
    $conn->query("DELETE FROM debts WHERE id = $id AND user_id = $user_id");
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'list_debts.php';
    header("Location: $redirect");
    exit();
}

// Toggle Status
if (isset($_GET['toggle_status'])) {
    $id = (int)$_GET['toggle_status'];
    $conn->query("UPDATE debts SET payment_status = IF(payment_status='paid', 'unpaid', 'paid') WHERE id = $id AND user_id = $user_id");
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'list_debts.php';
    header("Location: $redirect");
    exit();
}

// Fetch (User Specific)
$debts = [];
if ($user_id > 0) {
    $result = $conn->query("SELECT * FROM debts WHERE user_id = $user_id ORDER BY created_at DESC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $debts[] = $row;
        }
    }
}