<?php
require 'mongodb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $existingUser = $usersCollection->findOne(['email' => $email]);

    if ($existingUser) {
        echo "Email already registered!";
    } else {

        $insertResult = $usersCollection->insertOne([
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'course' => $course,
            'password' => $password
        ]);

        if ($insertResult->getInsertedCount() > 0) {
            echo "Registration successful! <a href='login.php'>Login here</a>";
        } else {
            echo "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register | Course Era</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST">
        <input type="text" name="fullname" placeholder="Full Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="tel" name="phone" placeholder="Phone" required><br><br>

        <input type="text" name="course" placeholder="Course" required><br><br>

        <input type="password" name="password" placeholder="Password" required><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>