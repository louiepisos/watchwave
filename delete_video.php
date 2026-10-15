<?php
require_once __DIR__ . '/auth.php';
require_admin($conn); if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect_to('home.php'); require_csrf();
$id = (int)($_POST['video_id'] ?? 0); $stmt = $conn->prepare('SELECT upload_video FROM uploaded_videos WHERE id=?'); $stmt->bind_param('i',$id); $stmt->execute(); $video=$stmt->get_result()->fetch_assoc();
if ($video) { $stmt=$conn->prepare('DELETE FROM uploaded_videos WHERE id=?'); $stmt->bind_param('i',$id); $stmt->execute(); $stmt=$conn->prepare('DELETE FROM comments WHERE video_id=?'); $stmt->bind_param('i',$id); $stmt->execute(); $path=__DIR__.'/'.$video['upload_video']; if (is_file($path)) unlink($path); } redirect_to('home.php');
