
<?
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == '1')){
		$tables = array('budynki', 'gabinety', 'lekarze', 'nazwiska', 'specjalnosci');
		if(isset($_POST['HASLO']) && isset($_POST['NAZWISKO']) && isset($_POST['EMAIL'])) {
			$add = "INSERT INTO `". $_POST('TABELA') ."`(`nazwisko`, `email`, `haslo`, `uprawnienia`) VALUES (";
			$add .= "'" . $_POST['NAZWISKO'] . "'" . ",". "'" . $_POST['EMAIL'] . "'" . ","
			. "'" . md5($_POST['HASLO']) . "'" . ",". "'" . $_POST['UPRAWNIENIA'] . "'". ")";
			$wynik = mysqli_query($mysqli,$add)
			or die("Błąd");
			if($wynik) {
				echo "Dodano rekord: " . $add . "<br>";
			}
			else {
				echo "Dodanie rekordu nie powiodło się <br>";
			}
		}

		

		foreach($tables as $table) {
			$forma = "<form action=\"add.php\" method=\"POST\">";
			$query = "SELECT * FROM `". $table ."` WHERE 1";
			echo "<h1>". strtoupper($table) ."</h1>";
			$sukces = mysqli_query($mysqli,$query)
			or die("Nie udało się pobrać zawartości tabeli " . $table);
			echo $query;
			if($sukces){
				$row = mysqli_fetch_assoc($sukces);
				foreach($row as $key => $obj){
					if($key == 'id'){}
					else {
						$forma.= $key . ": <input type=\"text\" name=\"". $key ."\" size=\"20\" maxlength=\"30\" /><br>";
					}
				}
			}
			$forma.= "<input type=\"submit\" value=\"Dodaj rekord\" />";
			$forma.="</form>";
			echo $forma;
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
		}
	else {
		echo "Nie masz uprawnień do tego skryptu";
	}
	include ("stopka.php");
?>