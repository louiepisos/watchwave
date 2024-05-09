<?php
if (isset($_POST['submit'])) {
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('mp4', 'mpeg-4', 'mov', 'avi', 'webm');

    if (in_array($fileActualExt, $allowed)) {
       if ($fileError === 0) {
        if ($fileSize < 500000) {
            $fileNameNew = uniqid('', true).".".$fileActualExt;
            $fileDestination = 'vid/'.$fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);
            header("location: home.php?uploadsuccess");
        }else {
            echo "Your Video Size is too big!";
        }
       }else {
        echo "There was an error uploading your Video";
       }
    }else {
        echo "You cannot Upload Video of this type";
    }
}