<?php

declare(strict_types=1); // włączenie typowania zmiennych w PHP >=7
session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
if (isset($_SESSION['loggedin']) == false) {
  header('Location: http://wilkowskidawid.pl/6_Semestr/z6/index3.php');
  exit();
}
include 'dbConn.php';
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

ini_set('display_errors', 'On');
$user = $_SESSION['usersession'];

$target_file = basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$directory = $_SESSION['sessionLink'];
if (strstr($directory, "dir=") !== false) {
  $dirr = strstr($directory, "dir=");
  $str2 = substr($dirr, 4);
  $str3 = "/" . $str2 . "/";
}
// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
} else {

  if (strstr($directory, "dir=") !== false) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $user . $str3 . $target_file)) {
      echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $user . "/" . $target_file)) {
      echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}







if ($_SESSION['sessionLink'] == "/6_Semestr/z7/dashboard.php") {

  header("Location: http://wilkowskidawid.pl/6_Semestr/z7/dashboard.php");
} else {
  header("Location: http://wilkowskidawid.pl/6_Semestr/z7/dashboard.php?dir=" . $str2);
}
