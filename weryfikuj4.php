<?php
ini_set('display_errors', 1);
session_start();
$user = htmlentities ($_POST['user'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $user
$pass = htmlentities ($_POST['pass'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $pass
$link = mysqli_connect('localhost', 'UR_USER', 'UR_PASSWORD', 'UR_DATABASE'); 
if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD
mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
$result = mysqli_query($link, "SELECT * FROM user WHERE login='$user'"); 
$rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
if(!$rekord) //Jeśli brak, to nie ma użytkownika o podanym loginie
{
    mysqli_close($link); 
    echo "Brak użytkownika o takim loginie !"; 
}
else
{ // jeśli $rekord istnieje
if($rekord['password']==$pass) // czy hasło zgadza się z BD
{
	$_SESSION ['loggedin'] = true;
	$_SESSION['who'] = $user;
if (isset($_SESSION['loggedin']))
{
	 header('location: createplaylist.php');
	 exit();
}
else 
{
	 header('location: logowanie.php');
	 exit();
	 mysqli_close($link); 
}}
else
{
 mysqli_close($link);
 echo "Błąd w haśle !"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
}}
?>