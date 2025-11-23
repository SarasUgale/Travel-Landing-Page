<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Travel Website</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php if(isset($_SESSION["name"])): ?>
        <h1>Welcome <?php echo htmlspecialchars($_SESSION["name"]); ?></h1>
        <p>Click here to <a href="logout.php" title="Logout">Logout</a>.</p>
    <?php else: ?>
        <h1>Please login first.</h1>
        <p>Click here to <a href="login.php" title="Login">Login</a>.</p>
    <?php endif; ?>
</body>
</html>
