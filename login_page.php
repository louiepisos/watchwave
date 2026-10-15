<?php
session_start();

if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in · WatchWave</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="box form-box">
        <header>Welcome back</header>
        <p style="color:var(--muted);margin:0 0 20px">Sign in to continue watching and sharing.</p>
        <?php if (!empty($error)): ?><div class="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
        <form action="log in.php" method="post">
            <div class="field">
                <label for="username">Username or email</label>
                <input type="text" name="username" id="username" autocomplete="username" required>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" autocomplete="current-password" required>
            </div>
            <div class="field"><input type="submit" name="submit" class="btn" value="Log in"></div>
        </form>
        <div class="links">New to WatchWave? <a href="signup.php">Create an account</a></div>
    </div>
</div>
</body>
</html>
