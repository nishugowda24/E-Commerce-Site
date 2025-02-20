<?php
$conn = new mysqli('localhost', 'root', '', 'ecommerce_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO Users (Username, Password, Email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo "<div class='success-message'>Registration successful. <a href='login.php'>Login here</a></div>";
    } else {
        echo "<div class='error-message'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2 class="title">Register</h2>
        <form method="POST" action="" class="form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" required class="input">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" required class="input">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required class="input">
            </div>
            <button type="submit" class="button">Register</button><br>
            <b>Alredy have an account?<a href="login.php"><u> Login here</u></a></b>
        </form>
    </div>
</body>
</html>
