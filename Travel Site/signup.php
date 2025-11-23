<?php
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = new mysqli('localhost', 'root', '', 'saras');

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $username = $_POST["user_name"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $con->prepare("INSERT INTO login (user_name, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION["id"] = $stmt->insert_id;
        $_SESSION["name"] = $username;
        header("Location: index.php?message=Registration successful!");
        exit();
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Travel Website</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="signup-container">
        <h2>Signup</h2>
        <form action="signup.php" method="POST">
            <div class="form-group">
                <label for="user_name">Username:</label>
                <input type="text" id="user_name" name="user_name" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Signup</button>
        </form>
        <p><?php echo $message; ?></p>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
