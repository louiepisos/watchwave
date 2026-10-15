<?php
require_once __DIR__ . '/auth.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect_to('admin_login.php');
$username=trim($_POST['username']??''); $password=$_POST['password']??'';
$stmt=$conn->prepare('SELECT id,username,password,is_banned,ban_reason FROM users WHERE username=? AND is_admin=1 LIMIT 1'); $stmt->bind_param('s',$username);$stmt->execute();$row=$stmt->get_result()->fetch_assoc();
if(!$row || $row['is_banned'] || !password_verify($password,$row['password'])) { $_SESSION['login_error']='Invalid administrator credentials.'; redirect_to('admin_login.php'); }
session_regenerate_id(true);$_SESSION['user_id']=(int)$row['id'];$_SESSION['username']=$row['username'];redirect_to('admin.php');
