<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['cart_items'])) {
    $_SESSION['cart_items'] = [];
}

$name = $_POST['item_name'] ?? '';
$price = isset($_POST['item_price']) ? floatval($_POST['item_price']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
$size = $_POST['size'] ?? '';
$image = $_POST['item_image'] ?? '';

if ($name && $price > 0 && $quantity > 0) {
    $found = false;

    // Update quantity if item already in cart
    foreach ($_SESSION['cart_items'] as &$item) {
        if ($item['name'] === $name && $item['size'] === $size) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }
    unset($item);

    // Add new item if not found
    if (!$found) {
        $_SESSION['cart_items'][] = [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'size' => $size,
            'image' => $image
        ];
    }
}

// Redirect to cart page
header("Location: cart.php");
exit();
