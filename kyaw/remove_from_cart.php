<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['cart_items'])) {
    $_SESSION['cart_items'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = isset($_POST['index']) ? intval($_POST['index']) : -1;

    if ($index >= 0 && $index < count($_SESSION['cart_items'])) {
        array_splice($_SESSION['cart_items'], $index, 1);
    }
}

header('Location: cart.php');
exit();
