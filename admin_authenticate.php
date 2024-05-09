<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'signup');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username' AND is_admin=1";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        header("location: home.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Invalid admin password!";
        header("location: admin_login.php");
        exit();
    }
} else {
    $_SESSION['login_error'] = "Invalid admin username!";
    header("location: admin_login.php");
    exit();
}

$conn->close();
?>