<?
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == "1")){

		$tables = array('budynki', 'gabinety', 'lekarze', 'nazwiska', 'specjalnosci');
		foreach($tables as $table) {
			$query = "SELECT * FROM `". $table ."` WHERE 1";
			echo "<h1>". strtoupper($table) ."</h1>";
			$sukces = mysqli_query($mysqli,$query)
			or die("Nie udało się pobrać zawartości tabeli " . $table);
			if($sukces){
				while($row = mysqli_fetch_assoc($sukces)){
					$forma ="<form action = \"delete2.php\" method=\"POST\">";
					$forma.="<input type=\"hidden\" name=\"TABELA\" value=\"" . $table."\" size=\"20\" maxlength=\"30\" />";
					foreach($row as $key => $obj) {
							echo $key . ": " . $obj . " / ";
							$forma.="<input type=\"hidden\" name=\"". $key ."\" value=\"" . $obj ."\" />";

					}
					$forma.= "<br> <input type=\"submit\" value=\"Usuń rekord\" />";
					$forma.="</form>";
					echo $forma;	
				}
			}
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