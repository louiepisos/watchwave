<?php
require_once __DIR__ . '/auth.php';
require_admin($conn); if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect_to('home.php'); require_csrf();
$id=(int)($_POST['comment_id']??0); $stmt=$conn->prepare('DELETE FROM comments WHERE id=?'); $stmt->bind_param('i',$id); $stmt->execute(); redirect_to('home.php');
