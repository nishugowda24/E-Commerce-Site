<?php
// Start session for user authentication
session_start();


// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce_db"; // Updated database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Sales Report Data
$sales_query = "SELECT ProductName, SUM(TotalSales) AS total_sales, SUM(TotalOrders) AS total_orders 
                FROM SalesReport 
                GROUP BY ProductName";
$sales_result = $conn->query($sales_query);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-left">
        <h1 class="site-title">E-Commerce Dashboard  <a href="home.php" class="home-link">Home</a></h1>
        </div>
        <div class="navbar-right">
            <button class="account">
                <a href="account.php" class="account-link">Account</a>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2 class="page-title">Analytics Dashboard</h2>
    </div>
        <!-- Dashboard Boxes -->
        <div class="dashboard-container">
            <!-- Box 1: Sales Data -->
            <div class="dashboard-box">
                <h3>Sales Overview</h3>
                <p>Analyze sales performance across different products.</p>
                <canvas id="salesChart" width="700" height="300"></canvas>
            </div>
        
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 E-Commerce Dashboard. All rights reserved.</p>
    </div>

    <script>
        // Fetch Sales Data and Render Chart
        var productNames = [];
        var salesData = [];
        var orderData = [];
        
        <?php if ($sales_result->num_rows > 0) {
            while($row = $sales_result->fetch_assoc()) {
                echo "productNames.push('" . $row['ProductName'] . "');";
                echo "salesData.push(" . $row['total_sales'] . ");";
                echo "orderData.push(" . $row['total_orders'] . ");";
            }
        } ?>

        // Render the Sales Chart using Chart.js
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [
                    {
                        label: 'Total Sales (USD)',
                        data: salesData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Orders',
                        data: orderData,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>
</html>
