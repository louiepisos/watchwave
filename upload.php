<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Upload</header>
            <form action="upload_connect.php" method="post" enctype="multipart/form-data">
                <div class="field input">
                    <label for="upload_video">Upload Video</label>
                    <input type="file" name="upload_video" id="upload_video" accept="video/*">
                </div>
                <div class="field">
                    <input type="submit" name="submit" class="btn" value="Upload">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
