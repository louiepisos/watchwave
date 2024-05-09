<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'signup');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $_SESSION["username"] = $username;
    header("location: home.php");
    exit();
} else {
    $_SESSION['login_error'] = "Invalid username or password!";
    header("location: tiktak.php");
    exit();
}

$conn->close();
?>
