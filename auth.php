<?php
session_start();
require_once __DIR__ . '/db_connect.php';

function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function redirect_to(string $path): never { header('Location: ' . $path); exit; }
function csrf_token(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function require_csrf(): void { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(419); exit('Invalid request token.'); } }
function current_user(mysqli $conn): ?array {
    if (empty($_SESSION['user_id'])) return null;
    $stmt = $conn->prepare('SELECT id, username, email, profile_picture, is_admin, is_banned, ban_reason FROM users WHERE id = ?');
    $stmt->bind_param('i', $_SESSION['user_id']); $stmt->execute(); $user = $stmt->get_result()->fetch_assoc();
    if (!$user || $user['is_banned']) { session_destroy(); return null; } return $user;
}
function require_user(mysqli $conn): array { $user = current_user($conn); if (!$user) redirect_to('tiktak.php'); return $user; }
function require_admin(mysqli $conn): array { $user = require_user($conn); if (!(int)$user['is_admin']) { http_response_code(403); exit('Administrator access required.'); } return $user; }
