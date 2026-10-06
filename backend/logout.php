<?php

require(__DIR__ . '/../helpers/DB.php');


session_start();
$_SESSION['loggedin'] = false;
$_SESSION['user_id'] = null;
$_SESSION['email'] = null;
header("Location: login.php");
exit();
