<?php

declare(strict_types=1); // włączenie typowania zmiennych w PHP >=7
session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku

include 'dbConn.php';
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$user = htmlentities($_POST['user'], ENT_QUOTES, "UTF-8");
$pass = htmlentities($_POST['pass'], ENT_QUOTES, "UTF-8");
$passagain = htmlentities($_POST['passagain'], ENT_QUOTES, "UTF-8");

if ($passagain != $pass) {
  header("Location: http://wilkowskidawid.pl/6_Semestr/z7/errorhaslopowtorz.php");
  die('Passwords do not match');
}

$link = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname); // połączenie z BD – wpisać swoje dane
if (!$link) {
  echo "Błąd: " . mysqli_connect_errno() . " " . mysqli_connect_error();
} // obsługa błędu połączenia z BD
mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
$sql_u = "SELECT * FROM users WHERE username='$user'";
$res_u = mysqli_query($link, $sql_u);
if (mysqli_num_rows($res_u) > 0) {
  header("Location: http://wilkowskidawid.pl/6_Semestr/z7/errorloginzajety.php");
  die('Login already exists');
}

$sql = "INSERT INTO users (id,username, pass) VALUES (NULL,'$user','$pass');";
$link->query($sql);
mkdir($user);
header("Location: http://wilkowskidawid.pl/6_Semestr/z7/index.php");
mysqli_close($link); // zamknięcie połączenia z BD
