<?php
session_start();

// Include MongoDB connection
require 'mongodb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Find user by email
    $user = $usersCollection->findOne(['email' => $email]);

    if ($user) {

        // Verify hashed password
        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = (string) $user['_id'];
            $_SESSION['user_name'] = $user['fullname'];

            header("Location: dashboard.php");
            exit();

        } else {
            echo "Incorrect password!";
        }

    } else {
        echo "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | Course Era</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>