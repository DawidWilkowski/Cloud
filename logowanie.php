<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<HEAD>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</HEAD>

<BODY>
   <?php
   include 'dbConn.php';
   ini_set('display_errors', '1');
   ini_set('display_startup_errors', '1');
   error_reporting(E_ALL);
   $user = htmlentities($_POST['user'], ENT_QUOTES, "UTF-8");
   $pass = htmlentities($_POST['pass'], ENT_QUOTES, "UTF-8");
   $link = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname); // połączenie z BD – wpisać swoje dane
   if (!$link) {
      echo "Błąd: " . mysqli_connect_errno() . " " . mysqli_connect_error();
   } // obsługa błędu połączenia z BD
   mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
   $result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'"); // wiersza, w którym login=login z formularza
   $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD

   if (!$rekord) //Jeśli brak, to nie ma użytkownika o podanym loginie
   {
      mysqli_close($link); // zamknięcie połączenia z BD

      header('Location: http://wilkowskidawid.pl/6_Semestr/z7/index.php');
   } else { // jeśli $rekord istnieje
      if ($rekord['pass'] == $pass) // czy hasło zgadza się z BD
      {
         session_start();
         $_SESSION['loggedin'] = true;
         $_SESSION['usersession'] = $user;
         header('Location: http://wilkowskidawid.pl/6_Semestr/z7/dashboard.php');
         $sql = "INSERT INTO logi (id,datetime,stan,user) VALUES (NULL,DEFAULT,'pomyslne','$user');";
         $link->query($sql);
         mysqli_close($link);
      } else {
         //"Błąd w haśle !"
         $sql = "INSERT INTO logi (id,datetime,stan,user) VALUES (NULL,DEFAULT,'nieudane','$user');";
         $link->query($sql);
         $sql_u = "SELECT * FROM logi WHERE stan ='nieudane' AND datetime >= now() - interval 5 minute";
         $res_u = mysqli_query($link, $sql_u);

         $ile = "";
         while ($row = mysqli_fetch_array($res_u)) {
            $ile .= $row['user'];
         }
         mysqli_close($link);
         $uwaga = substr_count($ile, $user);
         if ($uwaga >= 3) {
            session_start();
            $_SESSION['tooMuchLogin'] = true;
         }
         header('Location: http://wilkowskidawid.pl/6_Semestr/z7/index.php');
      }
   }
   ?>
</BODY>

</HTML>