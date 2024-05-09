<?php
session_start();

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password !== $confirm_password) {
    $_SESSION['signup_error'] = "Passwords do not match!";
    header("Location: signup.php");
    exit();
}
$profile_picture = $_FILES['profile_picture']['name'];
$profile_picture_temp = $_FILES['profile_picture']['tmp_name'];
$profile_picture_path = 'profile/' . $profile_picture;
move_uploaded_file($profile_picture_temp, $profile_picture_path);

$conn = new mysqli('localhost', 'root', '', 'signup');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
} else {
    $check_query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['signup_error'] = "Username already taken!";
        header("Location: signup.php");
        exit();
    } else {
        $check_query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['signup_error'] = "Email already used!";
            header("Location: signup.php");
            exit();
        } else {
            $insert_query = "INSERT INTO users (username, email, password, profile_picture) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ssss", $username, $email, $password, $profile_picture_path);
            if ($stmt->execute()) {
                header("Location: Tiktak.php");
                exit();
            } else {
                $_SESSION['signup_error'] = "Error: " . $stmt->error;
                header("Location: signup.php");
                exit();
            }
        }
    }
    $conn->close();
}
?>
