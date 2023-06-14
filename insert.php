<?php error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING); ini_set('display_errors', 1);
session_start();
$conn = mysqli_connect('localhost', 'UR_USER', 'UR_PASSWORD', 'UR_DATABASE'); 
if (!$conn) { echo"Błąd: ".mysqli_connect_errno()."".mysqli_connect_error(); } mysqli_query($conn, "SET NAMES 'utf8'");

$user = $_SESSION['who'];
$query = "SELECT idu FROM user WHERE login='$user'"; 
$res = mysqli_query($conn, $query); 
$row = mysqli_fetch_array($res);
$idu = intval($row[0]);
$title = $_POST['title'];
$musician = $_POST['musician'];
$lyrics = $_POST['lyrics'];
$idpl = $_POST['idpl'];
$gatunek = $_POST['gatunek'];
$ispublic = $_POST['ispublic'];
if ($ispublic == 'on') { $ispublic = 1; } else { $ispublic = 0; }
$query2 = "SELECT idmt FROM musictype WHERE name='$gatunek'"; 
$res2 = mysqli_query($conn, $query2); 
$row = mysqli_fetch_array($res2);
$wynikgatunku = intval($row[0]);

$file = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));

$target_file = songs . "/". basename($_FILES["fileToUpload"]["name"]);
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
{ echo htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " uploaded. <br>"; 
} else {
    echo "LIpaaaaaaaaaa";
}
 $sql = "INSERT INTO song (title, musician, filename, lyrics, idu, idmt) VALUES ('$title', '$musician', '$file', '<audio controls><source src=songs/$file></audio>', $idu, $wynikgatunku)";
if (mysqli_query($conn, $sql)) {
    $last_id = mysqli_insert_id($conn);
    $sql1 = "INSERT INTO playlistdatabase (idpl, ids) VALUES ('$idpl', '$last_id')";
    if (mysqli_query($conn, $sql1)) {
        echo "Utwór został dodany!";
    } else {
        echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
    }
} else {
     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

 mysqli_close($conn);
?>
<br><a href='createplaylist.php'>Wróć</a>