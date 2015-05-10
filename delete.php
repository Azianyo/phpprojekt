<?
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == "1")){

		$query = "SELECT * FROM `nazwiska` WHERE 1";
		$sukces = mysqli_query($mysqli,$query)
		or die("Nie udało się pobrać zawartości tabeli");
		if($sukces){
			while($row = mysqli_fetch_assoc($sukces)){
				echo $row['id']. " / ";
				echo $row['nazwisko']. " / ";
				echo $row['email'] . " / ";
				echo $row['uprawnienia'] . "  ";
				$forma ="<form action = \"delete2.php\" method=\"POST\">";
				$forma.="<input type=\"hidden\" name=\"ID\" value=" . $row['id']. " />";
				$forma.="<input type=\"hidden\" name=\"NAZWISKO\" value=\"" . $row['nazwisko']."\" />";
				$forma.="<input type=\"hidden\" name=\"EMAIL\" value=\"" . $row['email']."\" />";
				$forma.="<input type=\"hidden\" name=\"UPRAWNIENIA\" value=" . $row['uprawnienia']." />";

				$forma.= "<input type=\"submit\" value=\"Usuń rekord\" />";
				$forma.="</form>";
				echo $forma;	
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