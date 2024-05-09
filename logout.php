<?php
session_start();

session_destroy();

header("Location: Tiktak.php");
exit;
?>