<?php
include("path.php");

session_start();

unset($SESSION['id']);
unset($_SESSION['username']);
unset($_SESSION['admin']);

session_destroy();

header('location: '.BASE_URL."/index.php");


?>