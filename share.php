<?php

declare(strict_types=1); // włączenie typowania zmiennych w PHP >=7
session_start();


include 'dbConn.php';
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$file = htmlentities($_POST['fileToShare'], ENT_QUOTES, "UTF-8");
$user = htmlentities($_POST['userToShare'], ENT_QUOTES, "UTF-8");



$tokens = explode('/', $file);
$str = trim(end($tokens));
$moveto = $user . "/" . $str;
echo $moveto;



copy($file, $moveto);
$str2 = $_SESSION['sessionLink'];
header("Location: http://wilkowskidawid.pl" . $str2);
