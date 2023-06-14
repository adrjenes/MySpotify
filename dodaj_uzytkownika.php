<?php
if ($_POST['user'] == "" || $_POST['pass']  == "" || $_POST['pass2']  == "") 
 {
     echo("Nie wprowadzono danych");
	 echo '<form method="POST" action="logowanie.php">
    <input type="submit" value="wróć"/>
  </form>';
 } else if ($_POST['pass']!= $_POST['pass2'])
 {
    echo("Wprowadzone hasła różnią się");
	echo '<form method="POST" action="logowanie.php">
    <input type="submit" value="wróć"/>
  </form>';
 }
else {
$user = htmlentities ($_POST['user'], ENT_QUOTES, "UTF-8");
$pass = htmlentities ($_POST['pass'], ENT_QUOTES, "UTF-8"); 
$link = mysqli_connect('localhost', 'UR_USER', 'UR_PASSWORD', 'UR_DATABASE'); 
if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } 
mysqli_query($link, "SET NAMES 'utf8'");
$result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'"); 
$rekord = mysqli_fetch_array($result);
if(!$rekord) 
{
	mysqli_query($link,"INSERT INTO user (login, password) VALUES ('$user', '$pass')"); 

echo "Konto utworzone!";
echo '<form method="POST" action="logowanie.php">
<input type="submit" value="wróć"/>
</form>';
}
else {
 mysqli_close($link);
 echo "login już istnieje"; 
 echo '<form method="POST" action="logowanie.php">
    <input type="submit" value="wróć"/>
  </form>';
}}
?>

