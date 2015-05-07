<?
	session_start();
	include("nagl.php");
	include("polacz.php");

	$query = "SELECT * FROM `nazwiska` WHERE 1";
	$sukces = mysqli_query($mysqli,$query)
	or die("Nie udało się pobrać zawartości tabeli");
	if($sukces){
		while($row = mysqli_fetch_assoc($sukces)){
			echo "id:" . $row['id'];
			$forma ="<form action = \"edit2.php\" method=\"POST\">";
			$forma.="<input type=\"hidden\" name=\"ID\" value=\"" . $row['id']."\" />";
			$forma.="<input type=\"text\" name=\"NAZWISKO\" value=\"" . $row['nazwisko']."\" size=\"10\" maxlength=\"20\" />";
			$forma.="<input type=\"text\" name=\"EMAIL\" value=\"" . $row['email']."\" size=\"20\" maxlength=\"30\" />";
			$forma.="<input type=\"text\" name=\"UPRAWNIENIA\" value=\"" . $row['uprawnienia']."\" size=\"5\" maxlength=\"10\" />";

			$forma.= "<input type=\"submit\" value=\"Edytuj rekord\" />";
			$forma.="</form>";
			echo $forma;	
		}
	}
	//if(isset($_POST['HASLO']) && isset($_POST['NAZWISKO']) && isset($_POST['EMAIL']))
?>