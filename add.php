
<?
	session_start();
	include("nagl.php");
	include("polacz.php");

	if(isset($_POST['HASLO']) && isset($_POST['NAZWISKO']) && isset($_POST['EMAIL'])) {
		$add = "INSERT INTO `nazwiska`(`nazwisko`, `email`, `haslo`, `uprawnienia`) VALUES (";
		$add .= "'" . $_POST['NAZWISKO'] . "'" . ",". "'" . $_POST['EMAIL'] . "'" . ","
		. "'" . md5($_POST['HASLO']) . "'" . ",". "'" . $_POST['UPRAWNIENIA'] . "'". ")";
		$wynik = mysqli_query($mysqli,$add)
		or die("Błąd zapytania");
		if($wynik) {
			echo "Dodano rekord: " . $add . "<br>";
		}
		else {
			echo "Dodanie rekordu nie powiodło się <br>";
		}
	}

	?>
	<form action="add.php" method="POST">
	Nazwisko: <input type="text" name="NAZWISKO" /><br />
	E-mail: <input type="text" name="EMAIL" /><br />
	Hasło: <input type="password" name="HASLO" /><br />
	Uprawnienia: <input type="text" name="UPRAWNIENIA" /><br />
	<input type="submit" value="Dodaj rekord" />
	</form>
	<form action="log2.php">
	<input type="submit" value="Wróć" />
	</form>
<?
	include ("stopka.php");
?>