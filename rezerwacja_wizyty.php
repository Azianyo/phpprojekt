<?php
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == "-1")){

		$query2 = "select imie, nazwisko from lekarze where id=". $_POST['id_lekarza'];
		$wynik2 = mysqli_query($mysqli,$query2)
		or die("Błąd zapytania:". mysqli_error($mysqli));
				
		if($wynik2){ 
			$row2 = mysqli_fetch_assoc($wynik2);
			echo "<h1>Dr. ". $row2['imie'] ." ". $row2['nazwisko']." - dostępne terminy</h1>";
		}

		$query = "select * from dzierzawy where id_lekarza=". $_POST['id_lekarza'] ." order by data asc, godzina_poczatek asc";
		$wynik = mysqli_query($mysqli,$query)
			or die("Błąd zapytania:". mysqli_error($mysqli));
			
		if($wynik){ 
			while($row = mysqli_fetch_assoc($wynik)){

			}
		}

	}		
	else {
		echo "Nie masz uprawnień do tego skryptu";
	}
	include ("stopka.php");
?>