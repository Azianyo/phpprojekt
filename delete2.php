<?
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == "1")){

		$sql = "DELETE FROM `" . $_POST['TABELA'] ."` WHERE id='". $_POST['id'] . "'";
		$sukces = mysqli_query($mysqli, $sql)
		or die('Błąd zapytania' . mysqli_error($mysqli));

		if($sukces){
			echo "Udało się usunąć rekord:" . $sql;
		}
		?>

		<form action="delete.php">
		<input type="submit" value="Wróć" />
		</form>

		<form action="log2.php">
		<input type="submit" value="Wróć do panelu głównego" />
		</form>

		<?
	}
	else {
		echo "Nie masz uprawnień do tego skryptu";
	}
	include ("stopka.php");
?>