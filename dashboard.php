<?php

session_start();
$_SESSION['sessionLink'] = $_SERVER['REQUEST_URI'];

function createDirectory()
{

    $directory = $_SERVER['REQUEST_URI'];
    if (strstr($directory, "dir=") !== false) {
        $dirr = strstr($directory, "dir=");
        $str2 = substr($dirr, 4);
        session_start();
        $add = $_POST["add"];
        $user = $_SESSION['usersession'];
        echo ($user . "/" . $str2 . "/" . $add);
        mkdir($user . "/" . $str2 . "/" . $add);
        header("Refresh:0; url=dashboard.php?dir=" . $str2);
    } else {
        session_start();
        $add = $_POST["add"];
        $user = $_SESSION['usersession'];
        echo ($user . "/" . $add);
        mkdir($user . "/" . $add);
        header("Refresh:0");
    }
}

?>
<?php
include 'dbConn.php';
$connect = mysqli_connect("", "", "", "");
function fill_brand($connect)
{
    $output = '';
    $sql = "SELECT * FROM users";
    $result = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $output .= '<option>' . $row["username"] . '</option>';
    }
    return $output;
}
?>


<HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<BODY>
    <a href="index.php">Wyloguj</a><br>
    Upload pliku:<br>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="image" src="upload.png" alt="Submit" style="width:30px;height 30px;" />

    </form>
    Utworzenie folderu:
</body>
<?php
if (!isset($_POST['submit'])) {
?>

    <form action="" method="post">

        <table>
            <tr>
                <td style=" border-style: none;"></td>
                <td bgcolor="lightgreen" style="font-weight: bold">
                    Nazwa:
                </td>

                <td bgcolor="lightred">
                    <input type="text" style="width: 220px;" class="form-control" name="add" id="add" />
                </td>

                <td bgcolor="lightgreen" colspan="2">
                    <input type="submit" name="submit" value="Utwórz folder" />
                </td>
            </tr>
        </table>

    </form>
    Zmień wyświetlanie:
    <form method="post" name="myform" action="listToFolder.php">
        <input type="submit" name="submit" value="Lista">
        <input type="submit" name="submit" value="Folder">
    </form>

<?php
} else {
    createDirectory();
}
?>
Lista plików:<br>
<?php
if (!isset($_SESSION)) {
    session_start();
}


$pathToScan = ""; //the variable that will contain the directory name to scan

$path = getcwd() . "/" . $_SESSION['usersession']; //default directory to browse, getcwd() returns the folder in which this script is located
$pathToScan = $path;
if (isset($_GET['dir'])) { //check if a directory name has been passed via the url
    $_GET['dir'] = htmlspecialchars($_GET['dir']); //escape the string just in case
    $dir = "" . $path . "/" . $_GET['dir'] . ""; //we want to make sure the directory to scan is INSIDE our default directory
    if (is_dir($dir)) { //if the directory actually exists, we set it as the path to scan
        $pathToScan = $dir;
    }
}


$scan = scandir($pathToScan); // Here we scan the whole directory
$scan = array_diff($scan, array('.', '..')); //Let's remove the 'previous folder' and 'root folder'

//And now we print the array

if ($pathToScan != $path) { //If we are not at the default directory, let's show a link to get back there
    echo '<a href="dashboard.php"><img src="back.png" alt="BACK" style="width:42px;height:42px;"></a>';
}
echo '<ul>';

if ($_SESSION['submitType'] == "Lista") {
    foreach ($scan as $a) {
        $pathToFile = "" . $pathToScan . "/" . $a . "";

        if (is_dir($pathToFile)) {

            if (isset($_GET['dir'])) { //if we are already in a subdirectory, we need to add the directory name to the url
                $linkToDir = '' . $_GET['dir'] . '/' . $a . '';
                $linkToDir = '' . $_GET['dir'] . '/' . $a . '';
            } else {
                $linkToDir = $a;
            }

            echo '<li><a href="dashboard.php?dir=' . $linkToDir . '">' . $a . '</a></li>';
        } else { //otherwise, link to the file

            if (isset($_GET['dir'])) { //if we are not in the default directory, let's add the current directory name to the file
                $linkToFile = '' . $_GET['dir'] . '/' . $a . '';
            } else {
                $linkToFile = $a;
            }

            echo '<li><a href=' . $_SESSION['usersession'] . "/" . $linkToFile . '>' . $a . '</a></li>';
        }
    }

    echo '</ul>';
} else {
    foreach ($scan as $a) {
        $pathToFile = "" . $pathToScan . "/" . $a . "";

        if (is_dir($pathToFile)) {

            if (isset($_GET['dir'])) { //if we are already in a subdirectory, we need to add the directory name to the url
                $linkToDir = '' . $_GET['dir'] . '/' . $a . '';
                $linkToDir = '' . $_GET['dir'] . '/' . $a . '';
            } else {
                $linkToDir = $a;
            }
            $filepath = "folder.png";
            echo '<img src="' . $filepath . '" style= "width:42px;height:42px;">';
            echo '<li><a href="dashboard.php?dir=' . $linkToDir . '">' . $a . '</a></li>';
        } else { //otherwise, link to the file

            if (isset($_GET['dir'])) { //if we are not in the default directory, let's add the current directory name to the file
                $linkToFile = '' . $_GET['dir'] . '/' . $a . '';
            } else {
                $linkToFile = $a;
            }
            $ext = strstr($a, ".");
            if ($ext == ".png" || $ext == ".jpg" || $ext == ".jpeg") {

                echo '<img src="' . $_SESSION['usersession'] . "/" . $linkToFile . '" style= "width:42px;height:42px;">';
                echo '<li><a href=' . $_SESSION['usersession'] . "/" . $linkToFile . '>' . $a . '</a></li>';
            } else if ($ext == ".mp4" || $ext == ".avi") {
                echo '<img src="' . 'play.png' . '" style= "width:42px;height:42px;">';
                echo '<li><a href=' . $_SESSION['usersession'] . "/" . $linkToFile . '>' . $a . '</a></li>';
            } else if ($ext == ".mp3") {
                echo '<img src="' . 'mp3ico.png' . '" style= "width:42px;height:42px;">';
                echo '<li><a href=' . $_SESSION['usersession'] . "/" . $linkToFile . '>' . $a . '</a></li>';
            } else {
                echo '<li><a href=' . $_SESSION['usersession'] . "/" . $linkToFile . '>' . $a . '</a></li>';
            }
        }
    }

    echo '</ul>';
}
?>
<br>
Udostępnianie plików:
<?php

$dirpath = $_SESSION['usersession'];
$url = $_SESSION['sessionLink'];
if (substr_count($url, 'dir=') == 1) {
    $dirr = strstr($url, "dir=");
    $str2 = substr($dirr, 4);
    $dirpath .= "/" . $str2;
}

$filenames = "";
if (is_dir($dirpath)) {
    $files = opendir($dirpath);
    if ($files) {
        while (($filename = readdir($files)) != false) {
            if ($filename != "." && $filename != "..") {
                $filenames = $filenames . "<option>$dirpath" . "/" . "$filename</option>";
            }
        }
    }
}

?>


<form action="share.php" method="post" enctype="multipart/form-data">
    Udostępnij:
    <select name="fileToShare" id="fileToShare">
        <?php echo $filenames; ?>
    </select>
    Dla:
    <select name="userToShare" id="userToShare">

        <?php echo fill_brand($connect); ?>
    </select>
    <input type="image" src="share.png" alt="Submit" style="width:65px;height:42px;" />
</form>


<br>
<br>
<br>
</BODY>

</HTML>