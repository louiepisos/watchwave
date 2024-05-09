<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: Tiktak.php");
    exit;
}

require_once('db_connect.php');

$username = $_SESSION['username'];

// Query to fetch user information
$sql_user = "SELECT * FROM users WHERE username = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $username);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows == 1) {
    $user = $result_user->fetch_assoc();
} else {
    echo "Error: User not found.";
}

$stmt_user->close();

// Query to fetch videos uploaded by the current user
$sql_videos = "SELECT * FROM uploaded_videos WHERE username = ?";
$stmt_videos = $conn->prepare($sql_videos);
$stmt_videos->bind_param("s", $username);
$stmt_videos->execute();
$result_videos = $stmt_videos->get_result();

$stmt_videos->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="flex-div">
    <div class="nav-left flex-div">
        <img src="images/logo.png" class="logo">
    </div>
    
    <div class="nav-right flex-div">
        <button class="btn"><a href="home.php">Home</a></button>
        <button class="btn"><a href="logout.php">Log out</a></button>
    </div>
</nav>

<div class="profile-container">
    <?php if(isset($user['profile_picture'])): ?>
    <img src="<?php echo $user['profile_picture']; ?>" alt="Profile Picture" class="profile-picture" style="width: 50px; height: 50px; border-radius: 50%; display: block; margin-left: auto; margin-right: auto;">
    <?php endif; ?>
    <h2 style="text-align: center;">Welcome, <?php echo $user['username']; ?>!</h2>
    <H2 style="text-align: center;">Here is your Uploaded videos</H2>
    </div>
    <div class="video-grid">
        <?php while ($row = $result_videos->fetch_assoc()): ?>
            <div class="video-thumbnail">
                <video controls class="thumbnail-preview">
                    <source src="<?php echo $row['upload_video']; ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php endwhile; ?>
    </div>

</body>
</html>