<?
	session_start();
	include("nagl.php");
	include("polacz.php");

	$query = "UPDATE `nazwiska` SET `nazwisko`='". $_POST['NAZWISKO']."',`email`='".$_POST['EMAIL']."',`uprawnienia`='" . $_POST['UPRAWNIENIA']."' WHERE ";
	$query .= "`id`='" . $_POST['ID'] ."';";
	$sukces = mysqli_query($mysqli,$query);
	
	if($sukces){
		echo "Edytowano rekord:" . $query;
	}
	//or die("Nie udało się pobrać zawartości tabeli");
?>