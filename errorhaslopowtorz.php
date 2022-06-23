<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<BODY>
    <?php
    session_start();
    ?>
    Formularz rejestracji
    <form method="POST" action="addUser.php" enctype="multipart/form-data">
        Login:<input type="text" name="user" maxlength="20" size="20"><br>
        Hasło:<input type="password" name="pass" maxlength="20" size="20"><br>
        Powtórz hasło:<input type="password" name="passagain" maxlength="20" size="20"><br>
        <input type="submit" value="Send" />
    </form>
    HASŁA NIE SĄ TAKIE SAME
</BODY>

</HTML>