<?php
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == "0")){

		$kwerenda = "select * from dzierzawy where 1";
	}

	}

	else {
		echo "Nie masz uprawnień do tego skryptu";
	}
	include ("stopka.php");
?>