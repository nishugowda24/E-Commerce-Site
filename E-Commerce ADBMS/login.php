<?php
$conn = new mysqli('localhost', 'root', '', 'ecommerce_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT Password, Username FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $username);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['email'] = $email;
            header("Location: home.php");
        } else {
            echo "<div class='error-message'>Invalid email or password.</div>";
        }
    } else {
        echo "<div class='error-message'>User not found.</div>";
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2 class="title">Login</h2>
        <form method="POST" action="" class="form">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required class="input">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" required class="input">
            </div>
            <button type="submit" class="button">Login</button>
            <br><b>New User! <a href="register.php"><u>Register here</u></a> </b>

        </form>
    </div>
</body>
</html>
