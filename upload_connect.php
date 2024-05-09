<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["upload_video"])) {
    $upload_video = $_FILES['upload_video']['name'];
    $upload_video_temp = $_FILES['upload_video']['tmp_name'];
    $upload_video_path = 'vid/' . $upload_video;
    move_uploaded_file($upload_video_temp, $upload_video_path);
    
    $_SESSION['uploaded_videos'] = $upload_video_path;

    $database_name = 'signup';
    $conn = new mysqli('localhost', 'root', '', $database_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $table_name = 'uploaded_videos';
    $username = $_SESSION['username'];

    $sql = "INSERT INTO $table_name (upload_video, username) VALUES ('$upload_video_path', '$username')";

    if ($conn->query($sql) === TRUE) {
        echo "New record inserted successfully.";
        header("Location: home.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>