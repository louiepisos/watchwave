<?php
session_start();

if(isset($_SESSION['login_error'])) {
    echo "<p>Error: ".$_SESSION['login_error']."</p>";
    unset($_SESSION['login_error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form action="log in.php" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="field input">
                    <label for="Password">Password</label>
                    <input type="password" name="password" id="Password" required>
                </div>
                <div class="field">
                    <input type="submit" name="submit" class="btn" value="Login">
                </div>
                <div class="links">
                    Don't have account? <a href="signup.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>