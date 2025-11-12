<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$conn = getDB();

$product_id = $_GET['id'] ?? '';
if ($product_id === '') {
    die('Invalid request – product id missing.');
}
$stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
$stmt->bind_param("s", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    die('Product not found.');
}

$product       = $result->fetch_assoc();
$product_name  = $product['name'];
$product_price = (int)$product['price'];

$stmt->close();

$user_email   = $_SESSION['email'];
$purchase_id  = uniqid('buy_', true);

$insert = $conn->prepare(
    "INSERT INTO buys (id, email, product, price) VALUES (?, ?, ?, ?)"
);
$insert->bind_param("sssi", $purchase_id, $user_email, $product_name, $product_price);

if ($insert->execute()) {
    $insert->close();
    $conn->close();
    header('Location: products.php?msg=purchased');
    exit;
} else {
    $error = 'Purchase failed: ' . $conn->error;
    $insert->close();
    $conn->close();
    die($error);
}
?>