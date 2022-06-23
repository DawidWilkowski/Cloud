<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<BODY>

   <?php
   include "dbConn.php";
   $ip = $_SERVER['REMOTE_ADDR'];




   session_start();
   $_SESSION['loggedin'] = false;
   $_SESSION['usersession'] = false;
   $_SESSION['submitType'] = "Lista";


   if ($_SESSION["tooMuchLogin"] == true) {
      ini_set('display_errors', '1');
      ini_set('display_startup_errors', '1');
      error_reporting(E_ALL);
      $link = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname); // połączenie z BD – wpisać swoje dane
      if (!$link) {
         echo "Błąd: " . mysqli_connect_errno() . " " . mysqli_connect_error();
      } // obsługa błędu połączenia z BD
      mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
      $sql = "INSERT INTO bledneLogowania (id,datatime, IP) VALUES (NULL,DEFAULT,'$ip');";
      $link->query($sql);
      mysqli_close($link);
      echo "Przekroczono limit logowan - 5 sekund blokada<br>";
      $_SESSION["tooMuchLogin"] = false;
      echo "<script>var tooMuch = 1;</script>";
   }
   ?>




   Formularz logowania
   <form method="post" action="logowanie.php " id="form1">
      Login:<input type="text" name="user" maxlength="20" size="20"><br>
      Hasło:<input type="password" name="pass" maxlength="20" size="20"><br>
   </form>
   <button id="submit" type="submit" form="form1" value="Submit">Submit</button>
   <br>
   <a href="rejestruj.php">Lub załóż konto </a><br />
   <a href="/6_Semestr/index.php">Wróć</a>
   <script>
      if (tooMuch == 1) {
         tooMuch = 0;
         document.getElementById("submit").disabled = true;
         setTimeout(function() {
            document.getElementById("submit").disabled = false;
         }, 5000);

      }
   </script>
</BODY>

</HTML>