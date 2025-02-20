<?php
// Database connection
$host = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "";     // Replace with your MySQL password
$dbname = "ecommerce_db";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch JSON data from Orders_Customers table
$sql = "SELECT JSONData FROM Orders_Customers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-left">
        <h1 class="site-title">E-Commerce Dashboard  <a href="home.php" class="home-link">Home</a></h1>

        </div>
        <div class="navbar-right">
            <button class="account"><a href="account.php" class="account-link">Account</a></button>
        </div>
    </div>

    <!-- Orders Section -->
    <div class="orders-container">
        <h2>Customer Orders</h2>
        <div class="orders-wrapper">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php 
                    $data = json_decode($row['JSONData'], true);
                    $customers = $data['customers'];
                    $orders = $data['orders'];
                    foreach ($customers as $index => $customer): ?>
                        <?php if (isset($orders[$index])): // Match customer with their corresponding order ?>
                            <div class="order-box">
                                <h3>Customer Details</h3>
                                <p><strong>Name:</strong> <?= $customer['name']; ?></p>
                                <p><strong>Email:</strong> <?= $customer['email']; ?></p>
                                <h3>Order Details</h3>
                                <p><strong>Order ID:</strong> <?= $orders[$index]['order_id']; ?></p>
                                <p><strong>Product:</strong> <?= $orders[$index]['product']; ?></p>
                                <p><strong>Amount:</strong> ₹<?= number_format($orders[$index]['amount'], 2); ?></p>
                                <p><strong>Date:</strong> <?= $orders[$index]['order_date']; ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No orders found in the database.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 E-Commerce Dashboard. All rights reserved.</p>
    </div>
</body>
</html>

<?php $conn->close(); ?>
