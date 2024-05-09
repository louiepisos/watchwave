<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$database_name = 'signup';
$conn = new mysqli('localhost', 'root', '', $database_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$is_admin = false;

$sql = "SELECT * FROM users WHERE username='$username' AND is_admin=1";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $is_admin = true;
}

$sql = "SELECT * FROM uploaded_videos";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="flex-div">
    <div class="nav-left flex-div">
        <img src="images/logo.png" class="logo">
    </div>

    <div class="nav-right flex-div">
        <button class="btn"><a href="upload.php">Upload</a></button>
        <div class="nav-buttons">
            <button class="btn"><a href="profile.php">Profile</a></button> 
            <button class="btn"><a href="logout.php">Log out</a></button>
        </div>
    </div>
</nav>

<div class="video-grid">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $upload_video_path = $row['upload_video'];
            $uploader_username = $row['username'];
            ?>
            <div class="video-thumbnail">
                <video controls class="thumbnail-preview">
                    <source src="<?php echo $upload_video_path; ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <p class="uploader">Uploaded by: <?php echo $uploader_username; ?></p>
                <?php if ($is_admin): ?>
                <form action="delete_video.php" method="post">
                    <input type="hidden" name="video_path" value="<?php echo $upload_video_path; ?>">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
                <?php endif; ?>
            </div>
            <?php
        }
    } else {
        echo "<p>No videos uploaded yet.</p>";
    }
    ?>
</div>

</body>
</html>
