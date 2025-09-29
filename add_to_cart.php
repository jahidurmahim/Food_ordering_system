<?php
session_start();
$product_id = $_GET['product_id'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (!isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] = 1;
} else {
    $_SESSION['cart'][$product_id]++;
}

header("Location: cart.php");
exit();
?>
