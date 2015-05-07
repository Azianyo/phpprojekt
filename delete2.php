<?
	session_start();
	include("nagl.php");
	include("polacz.php");

	$sql = "DELETE FROM `nazwiska` WHERE id='". $_POST['ID'] . "'";
	$sukces = mysqli_query($mysqli, $sql)
	or die('Błąd');

	if($sukces){
		echo $sql;
	}
?>