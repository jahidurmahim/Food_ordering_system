<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'customer') {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Query to fetch orders along with item details
$order_query = "
    SELECT 
        o.order_id, 
        o.orderdate, 
        o.status, 
        mi.name AS item_name, 
        mi.price AS item_price
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN menu_items mi ON oi.product_id = mi.item_id
    WHERE o.user_id = ?
    ORDER BY o.orderdate DESC";
$stmt = $conn->prepare($order_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$order_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="Styles/userpanel.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .nav-pills .nav-link.active {
            background-color: #f01543;
        }
        .tab-content {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <SECTION id="UserPanelPage">
    <div class="co"><h1>CUSTOMER DASHBOARD</h1></div>        
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <ul class="nav flex-column nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" id="user-details-tab" data-toggle="pill" href="#user-details">User Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="recent-orders-tab" data-toggle="pill" href="#recent-orders">Recent Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="user-details">
                        <h2>User Details</h2>
                        <ul>
                            <li>Username: <?php echo htmlspecialchars($user['username']); ?></li>
                            <li>Email: <?php echo htmlspecialchars($user['email']); ?></li>
                            <li>Role: <?php echo htmlspecialchars($user['role']); ?></li>
                            <li>Visit Our Store - <a target="_blank" href="index.php">TheNerds</a></li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="recent-orders">
                        <h2>Recent Orders</h2>
                        <?php if ($order_result->num_rows > 0): ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Order Date</th>
                                        <th>Status</th>
                                        <th>Item Name</th>
                                        <th>Item Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($order = $order_result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $order['order_id']; ?></td>
                                            <td><?php echo $order['orderdate']; ?></td>
                                            <td><?php echo $order['status']; ?></td>
                                            <td><?php echo $order['item_name']; ?></td>
                                            <td><?php echo $order['item_price']; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No recent orders found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </SECTION>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
