<?
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == "1")){
		$query = "UPDATE `". $_POST['TABELA'] . "` SET `";
		foreach($_POST as $key => $obj) {
			if(($key == 'TABELA') || ($key == 'ID')) {

			}
			else if (end($_POST) == $obj){
				$query.= $key . "`='". $obj. "' WHERE ";
			}
			else {
				$query.= $key . "`='". $obj."',`";
			}
		}
		$query .= "`id`='" . $_POST['ID'] ."';";
		$sukces = mysqli_query($mysqli,$query)
		or die('Błąd zapytania' . mysqli_error($mysqli));

		
		if($sukces){
			echo "Edytowano rekord:" . $query;
		}
	?>

	<form action="edit.php">
	<input type="submit" value="Wróć" />
	</form>

			<?
	}
	else {
		echo "Nie masz uprawnień do tego skryptu";
	}
	include ("stopka.php");
?>