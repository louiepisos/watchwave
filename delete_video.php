<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_POST['video_path'])) {
    header("Location: home.php");
    exit();
}

$video_path = $_POST['video_path'];

$database_name = 'signup';
$conn = new mysqli('localhost', 'root', '', $database_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$sql_admin = "SELECT * FROM users WHERE username='$username' AND is_admin=1";
$result_admin = $conn->query($sql_admin);

if ($result_admin->num_rows == 0) {
    header("Location: home.php");
    exit();
}

$sql_delete = "DELETE FROM uploaded_videos WHERE upload_video='$video_path'";
if ($conn->query($sql_delete) === TRUE) {
    if (unlink($video_path)) {
        echo "Video deleted successfully.";
    } else {
        echo "Error deleting video file.";
    }
} else {
    echo "Error deleting video from database.";
}

$conn->close();
?>