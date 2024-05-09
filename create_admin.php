<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli('localhost', 'root', '', 'signup');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, is_admin) VALUES (?, ?, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['admin_username'] = $username;
        header("location: admin_login.php");
        exit();
    } else {
        $_SESSION['signup_error'] = "Error creating admin account: " . $stmt->error;
        header("location: admin_signup.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("location: admin_signup.php");
    exit();
}
?>
