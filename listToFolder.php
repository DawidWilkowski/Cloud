<?php
session_start();
$mytext = $_POST['submit'];
echo $mytext;
$_SESSION['submitType'] = $mytext;
$str2 = $_SESSION['sessionLink'];
header("Location: http://wilkowskidawid.pl" . $str2);
