
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
        <div class="box form-box">
    <h2>Admin Login</h2>
    <form action="admin_authenticate.php" method="post">
    <div class="field input">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
</div>
<div class="field input">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
</div>
<div class="field input">
        <input type="submit" value="Login">
</div>
    </form>
</div>
</div>
</body>
</html>