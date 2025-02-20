<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];
$conn = new mysqli('localhost', 'root', '', 'ecommerce_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT Username FROM Users WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-left">
            <h1 class="site-title">E-Commerce Dashboard  <a href="home.php" class="home-link">Home</a></h1>
        </div>
       
        <div class="navbar-right">
           <button class="account"> <a href="account.php" class="account-link">Account</a></button>
        </div>
    </div>


    <div>
        <div class="welcome-section">
            <h2>Welcome to Our E-Commerce Dashboard!</h2>
            <p>Manage your business, track sales, view customer orders, and optimize product performance with ease.</p>
        </div>



    <!-- Main Content -->
    <div class="main-content">
        <div class="box">
            <a href="analytics.php">
                <h2>Analytics Dashboard</h2>
                <p>Track sales, customer behavior, and overall trends here.</p>
            </a>
        </div>
        <div class="box">
            <a href="orders.php">
                <h2>Customer Orders</h2>
                <p>View details of all customer orders and their status.</p>
            </a>
        </div>
        <div class="box">
            <a href="products.php">
                <h2>Product Performance</h2>
                <p>Analyze how your products are performing in the market.</p>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 E-Commerce Dashboard. All rights reserved.</p>
    </div>
</body>
</html>
