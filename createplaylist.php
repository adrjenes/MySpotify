<?php error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING); ini_set('display_errors', 1);
session_start();
$conn = mysqli_connect('localhost', 'UR_USER', 'UR_PASSWORD', 'UR_DATABASE'); 
if (!$conn) { echo"Błąd: ".mysqli_connect_errno()."".mysqli_connect_error(); } mysqli_query($conn, "SET NAMES 'utf8'");

 // ---- ZNALEZIENIE ID UŻYTKOWNIKA -------

$user = $_SESSION['who'];
$query = "SELECT idu FROM user WHERE login='$user'"; 
$res = mysqli_query($conn, $query); 
$row = mysqli_fetch_array($res);

$idu = intval($row[0]);
$name = $_POST['title'];
$ispublic = $_POST['ispublic'];
if ($ispublic == 'on') { $ispublic = 1; } else { $ispublic = 0; }



$query = "INSERT INTO playlistname (idu, name, public) VALUES ('$idu', '$name', '$ispublic')";
mysqli_query($conn, $query);

$sql = "SELECT DISTINCT playlistname.idpl, playlistname.name, playlistname.public, GROUP_CONCAT(song.idmt SEPARATOR ' | ') as idmt ,GROUP_CONCAT(song.filename SEPARATOR ' | ') as filename ,GROUP_CONCAT(song.musician SEPARATOR ' | ') as musician, GROUP_CONCAT(song.lyrics SEPARATOR ' | ') as lyrics, GROUP_CONCAT(song.title SEPARATOR ' | ') as title, GROUP_CONCAT(musictype.name SEPARATOR ' | ') as gatunek FROM playlistname LEFT JOIN playlistdatabase ON playlistname.idpl = playlistdatabase.idpl LEFT JOIN song ON song.ids = playlistdatabase.ids LEFT JOIN musictype on musictype.idmt = song.idmt WHERE playlistname.idu = '$idu' GROUP BY playlistname.name";



$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $idpl = $row["idpl"];
        echo "id: " . $row["idpl"]. " - Playlista: " . $row["name"] . " <a href='add_song.php?idpl=$idpl'><button>Dodaj utwór</button></a><br>";

        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>Artysta</th>";
        echo "<th>Nazwa pliku</th>";
        echo "<th>Tekst</th>";
        echo "<th>Tytuł</th>";
        echo "<th>Gatunek</th>";
        echo "</tr>";
        $title = explode(' | ', $row['title']);
        $filename = explode(' | ', $row['filename']);
        $lyrics = explode(' | ', $row['lyrics']);
        $musician = explode(' | ', $row['musician']);
        $gatunek = explode(' | ', $row['gatunek']);
        $i = 0;
         foreach($title as $t){
            if(!empty($t)){
                echo "<tr>";
                echo "<td>" . $musician[$i] . "</td>";
                echo "<td>" . $filename[$i] . "</td>";
                echo "<td>" . $lyrics[$i] . "</td>";
                echo "<td>" . $t . "</td>";
                echo "<td>" . $gatunek[$i] . "</td>";
                echo "</tr>";
                $i++;
            }
        }
        echo "</table>";
        echo "<br>";
    } 
    } 


mysqli_close($conn);
?>
<br>
<form action="glowna_strona.php">
    <input type="submit" value="Utwórz playliste" />
</form>
<form action="logowanie.php">
    <input type="submit" value="Wyloguj" />
</form>

