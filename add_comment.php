<?php
require_once __DIR__ . '/auth.php';
$user = require_user($conn);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect_to('home.php'); require_csrf();
$video_id = (int)($_POST['video_id'] ?? 0); $body = trim($_POST['body'] ?? '');
if ($video_id < 1 || $body === '' || strlen($body) > 2000) redirect_to('home.php');
$stmt = $conn->prepare('INSERT INTO comments (video_id,username,body) VALUES (?,?,?)'); $stmt->bind_param('iss',$video_id,$user['username'],$body); $stmt->execute(); redirect_to('home.php');
