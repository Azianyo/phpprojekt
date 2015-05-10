<?
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == "1")){

		$query = "UPDATE `nazwiska` SET `nazwisko`='". $_POST['NAZWISKO']."',`email`='".$_POST['EMAIL']."',`uprawnienia`='" . $_POST['UPRAWNIENIA']."' WHERE ";
		$query .= "`id`='" . $_POST['ID'] ."';";
		$sukces = mysqli_query($mysqli,$query);
		
		if($sukces){
			echo "Edytowano rekord:" . $query;
		}
		//or die("Nie udało się pobrać zawartości tabeli");
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