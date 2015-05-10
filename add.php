
<?
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == '1')){
		$tables = array('budynki', 'gabinety', 'lekarze', 'nazwiska', 'specjalnosci');
		if(isset($_POST['TABELA'])) {
			$add = "INSERT INTO `". $_POST['TABELA'] ."`(`";
				foreach($_POST as $key => $val){
					if(end($_POST) == $val){
						$add.= $key . "`) VALUES ('";
					}
					else if($key == 'TABELA'){}
					else {
						$add.= $key . "`, `";
					}
				}
				foreach($_POST as $key => $val){
					if(end($_POST) == $val){
						$add.= $val . "')";
					}
					else if($key == 'HASLO'){
						$add .= md5($val) . "', '";;
					}
					else if($key == 'TABELA') {}
					else {
						$add.= $val . "', '";
					}
				}
				//"nazwisko`, `email`, `haslo`, `uprawnienia`) VALUES (";
			//$add .= "'" . $_POST['NAZWISKO'] . "'" . ",". "'" . $_POST['EMAIL'] . "'" . ","
			//. "'" . md5($_POST['HASLO']) . "'" . ",". "'" . $_POST['UPRAWNIENIA'] . "'". ")";
			$wynik = mysqli_query($mysqli,$add)
			or die($add . mysqli_error($mysqli));
			if($wynik) {
				echo "Dodano rekord: " . $add . "<br>";
			}
			else {
				echo "Dodanie rekordu nie powiodło się <br>";
			}
		}

		

		foreach($tables as $table) {
			$forma = "<form action=\"add.php\" method=\"POST\">";
			$forma.="<input type=\"hidden\" name=\"TABELA\" value=\"" . $table."\" size=\"20\" maxlength=\"30\" />";
			$query = "SELECT * FROM `". $table ."` WHERE 1";
			echo "<h1>". strtoupper($table) ."</h1>";
			$sukces = mysqli_query($mysqli,$query)
			or die("Nie udało się pobrać zawartości tabeli " . $table);
			echo $query;
			if($sukces){
				$row = mysqli_fetch_assoc($sukces);
				foreach($row as $key => $obj){
					if($key == 'id'){}
					else if($key == 'haslo') {
						$forma.= "Hasło" . ": <input type=\"password\" name=\"". $key ."\" size=\"20\" maxlength=\"30\" /><br>";

					}
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