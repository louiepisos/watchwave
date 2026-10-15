<?php
session_start();

session_destroy();

header("Location: tiktak.php");
exit;
?>