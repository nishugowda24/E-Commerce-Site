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

$stmt = $conn->prepare("SELECT Username, Email FROM Users WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($username, $user_email);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Account Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="navbar">
        <div class="navbar-left">
        <h1 class="site-title">E-Commerce Dashboard  <a href="home.php" class="home-link">Home</a></h1>
        </div>
        <div class="navbar-right">
           <button class="account"> <a href="account.php" class="account-link">Account</a></button>
        </div>
    </div>

    <div class="container">
        <h2>Account Details</h2>
        <div class="account-info">
            <p><strong>Username:</strong> <?php echo $username; ?></p>
            <p><strong>Email:</strong> <?php echo $user_email; ?></p>
        </div>
    </div>
    <!-- Account Info Section -->
<div class="account-info">
    <a href="logout.php" class="logout-btn">Logout</a>
</div>
<div class="footer">
        <p>&copy; 2024 E-Commerce Dashboard. All rights reserved.</p>
    </div>
</body>
</html>
