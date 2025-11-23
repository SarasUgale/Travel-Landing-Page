<?php
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = new mysqli('localhost', 'root', '', 'saras');

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $con->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION["id"] = $row['id'];
        $_SESSION["name"] = $row['username'];
        header("Location: index.php");
        exit();
    } else {
        $message = "Invalid Username or Password!";
    }

    $stmt->close();
    $con->close();
}

if (isset($_SESSION["id"])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Travel Website</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="user_name">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p><?php echo $message; ?></p>
        <p>Don't have an account? <a href="signup.php">Register here</a></p>
    </div>
</body>
</html>
