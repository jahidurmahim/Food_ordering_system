<?php
session_start();
include 'db_connect.php';

// Check if product_id is set in the URL
if (!isset($_GET['product_id'])) {
    echo "Product ID is missing.";
    exit();
}

// Fetch product details based on product_id
$product_id = $_GET['product_id'];
$query = "SELECT * FROM menu_items WHERE item_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Check if product exists
if (!$product) {
    echo "Product not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="Styles/product_page.css">
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
    <section id="ProductPageSec">
        <div class="container productPageCon">
            <div class="row productPageBox1">
                <h1>TheNerds Product Page</h1>
            </div>
            <div class="row productPageBox2">
                <div class="col-md-6">
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product Image" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>
                    <a href="add_to_cart.php?product_id=<?php echo $product_id; ?>" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
