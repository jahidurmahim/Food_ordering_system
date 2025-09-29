<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    
    // Calculate total amount from the cart
    $total_amount = 0.0;
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $product_query = "SELECT price FROM menu_items WHERE item_id = ?";
        $stmt = $conn->prepare($product_query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $total_amount += $product['price'] * $quantity;
        $stmt->close();
    }

    // Insert into orders table
    $order_query = "INSERT INTO orders (user_id, total_amount, orderdate, status) VALUES (?, ?, NOW(), 'pending')";
    $stmt = $conn->prepare($order_query);
    $stmt->bind_param("id", $user_id, $total_amount);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Insert into order_items table
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $product_query = "SELECT price FROM menu_items WHERE item_id = ?";
            $stmt = $conn->prepare($product_query);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

            $item_price = $product['price'];

            $item_query = "INSERT INTO order_items (order_id, product_id, quantity, item_price) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($item_query);
            $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $item_price);
            $stmt->execute();
        }

        // Clear the cart
        unset($_SESSION['cart']);

        // Redirect to order confirmation or another page
        header("Location: thank_you.php?order_id=" . $order_id);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <form action="checkout.php" method="post">
            <p>Total: $<?php echo htmlspecialchars($total); ?></p>
            <input type="hidden" name="total" value="<?php echo htmlspecialchars($total); ?>">
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
    </div>
</body>
</html>
