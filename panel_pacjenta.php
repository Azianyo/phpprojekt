<?
$kwer = "select * from lekarze ";
$kwer.= "where 1";

$wynik = mysqli_query($mysqli,$kwer)
	or die("Błąd zapytania:". mysqli_error($mysqli));

if($wynik){ 
	while($row = mysqli_fetch_assoc($wynik)){
		$forma ="<form action = \"rezerwacja_wizyty.php\" method=\"POST\">";
		$forma.="<input type=\"hidden\" name =\"id_lekarza\" value=\"". $row['id'] ."\" >";
		$forma.= "<input type=\"submit\" value=\"Rezerwacja wizyty - dr. ". $row['imie'] ." ". $row['nazwisko'] ."\" />";
		$forma.="</form>";

		echo $forma;
	}
}
?>

<form action="wizyty.php">
	<input type="submit" value="Twoje wizyty" />
</form>
<?