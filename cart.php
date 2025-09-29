<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="Styles/cart.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <section id="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="index.php"><img src="Img/logo.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav m-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" target="_blank" href="about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Shop</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Categories
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Organic Foods</a>
                                <a class="dropdown-item" href="#">Sea Foods</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Fast Foods</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" target="_blank" href="contact.php">Contact</a>
                        </li>
                    </ul>
                    <div class="navButton">
                        <a href="login.html" class="btn btn-primary login">Log In</a>
                        <a href="register.html" class="btn btn-primary signup">Sign Up</a>
                    </div>
                </div>
            </nav>
        </div>
    </section>
    <section id="CartPage">
    <div class="container">
        <div class="row cartTitle"><h1>Your Cart</h1></div>
        <div class="row">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $product_id => $quantity) {
                    $query = "SELECT * FROM menu_items WHERE item_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $product_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $product = $result->fetch_assoc();
                    
                    $subtotal = $product['price'] * $quantity;
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                        <td>$<?php echo $subtotal; ?></td>
                        <td><a href="remove_from_cart.php?product_id=<?php echo $product_id; ?>" class="btn btn-danger">Remove</a></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        </div>
        <div class="row">
        <h3>Total: $<?php echo $total; ?></h3>
        <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
        </div>
    </div>
</section>
</body>
</html>
