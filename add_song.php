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
$idpl = $_GET['idpl'];
echo $idpl;
?>
<form action="insert.php" method="post" enctype="multipart/form-data">
  Wyślij utwór: 
  <input type="file" name="fileToUpload" id="fileToUpload"><br><br>
  Tytuł utworu: <input type="text" name="title"><br>
  Imię i nazwisko autora: <input type="text" name="musician"><br>
  Tekst: <input type="text" name="lyrics"><br>
  <input type="hidden" name="idpl" value="<?php echo $idpl; ?>">
  <a>Jaki to gatunek muzyczny?</a><br>
  <select name="gatunek" id="gatunek">
  <?php
  $dbhost='localhost'; $dbuser='UR_USER'; $dbpassword='UR_PASSWORD'; $dbname='UR_DATABASE';
  $connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
  $query = "select * from musictype";
  $user = $_SESSION['who'];
  $res = mysqli_query($connection, $query); 
  while($row = mysqli_fetch_array ($res)){
  print "<option value='$row[1]'>$row[1]</option>";
}
?>
</select><br>
  Czy playlista ma być publiczna? <br><input type="checkbox" name="ispublic"><br><br>
  <input type="submit" value="Dodaj utwór">
</form>
