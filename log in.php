<?php
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect_to('tiktak.php');
$username = trim($_POST['username'] ?? ''); $password = $_POST['password'] ?? '';
$stmt = $conn->prepare('SELECT id, username, password, is_banned, ban_reason FROM users WHERE username = ? OR email = ? LIMIT 1');
$stmt->bind_param('ss', $username, $username); $stmt->execute(); $user = $stmt->get_result()->fetch_assoc();
if (!$user || !password_verify($password, $user['password'])) { $_SESSION['login_error'] = 'Invalid username or password.'; redirect_to('tiktak.php'); }
if ((int)$user['is_banned']) { $_SESSION['login_error'] = 'This account is banned: ' . ($user['ban_reason'] ?: 'policy violation'); redirect_to('tiktak.php'); }
session_regenerate_id(true); $_SESSION['user_id'] = (int)$user['id']; $_SESSION['username'] = $user['username']; redirect_to('home.php');
