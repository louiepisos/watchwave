<?php
require_once __DIR__ . '/auth.php';
$user = require_user($conn);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect_to('upload.php');
require_csrf();
$file = $_FILES['upload_video'] ?? null;
if (!$file && (int)($_SERVER['CONTENT_LENGTH'] ?? 0) > 520 * 1024 * 1024) { $_SESSION['flash'] = 'This upload is too large. The maximum is 500 MB.'; redirect_to('upload.php'); }
$title = trim($_POST['title'] ?? 'Untitled video'); $description = trim($_POST['description'] ?? '');
if (!$file || $file['error'] !== UPLOAD_ERR_OK || $file['size'] > 500 * 1024 * 1024) { $_SESSION['flash'] = 'Choose a video smaller than 500 MB.'; redirect_to('upload.php'); }
$allowed = ['mp4'=>'video/mp4','webm'=>'video/webm','mov'=>'video/quicktime']; $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!isset($allowed[$ext]) || !str_starts_with((string)$file['type'], 'video/')) { $_SESSION['flash'] = 'Only MP4, WebM, and MOV videos are allowed.'; redirect_to('upload.php'); }
$name = bin2hex(random_bytes(16)) . '.' . $ext; $relative = 'vid/' . $name; $target = __DIR__ . '/' . $relative;
if (!move_uploaded_file($file['tmp_name'], $target)) { $_SESSION['flash'] = 'The upload could not be saved.'; redirect_to('upload.php'); }
$stmt = $conn->prepare('INSERT INTO uploaded_videos (upload_video,username,title,description) VALUES (?,?,?,?)'); $stmt->bind_param('ssss',$relative,$user['username'],$title,$description); $stmt->execute(); redirect_to('home.php');
