<?php
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == "0")){

	print_r($wiersz);

	function gabinety($tab, $mysqli){

		$kwerenda = "select * from lekarze ";
		$kwerenda.= "where id_nazwiska = \"". $tab['id']. "\"";

		echo $kwerenda;
		print_r($wiersz);
		$wynik = mysqli_query($mysqli,$kwerenda)
				or die("Błąd zapytania:". mysqli_error($mysqli));

				if($wynik){ 
					$row = mysqli_fetch_assoc($wynik);
					$id_lekarza = $row['id'];
				}


		$kwerenda2 = "select * from lekarze_specjalnosci ";
		$kwerenda2.= "where id_lekarze = \"". $id_lekarza. "\"";

		echo $kwerenda2;
		$wynik = mysqli_query($mysqli,$kwerenda2)
				or die("Błąd zapytania:". mysqli_error($mysqli));

				if($wynik){ 
					$specjalnosci = array();
					while($row = mysqli_fetch_assoc($wynik)){
						array_push($specjalnosci, $row['id_specjalnosci']);
					}
				}
			print_r($specjalnosci);

		foreach($specjalnosci as $item){
			$gabinety = array();
			$kwerenda3 = "select * from gabinety_specjalnosci ";
			$kwerenda3.= "where id_specjalnosci = \"". $item. "\"";
			echo $kwerenda3;

			$wynik = mysqli_query($mysqli,$kwerenda3)
				or die("Błąd zapytania:". mysqli_error($mysqli));

			if($wynik){ 
					$gabinety = array();
					while($row = mysqli_fetch_assoc($wynik)){
						array_push($gabinety, $row['id_gabinetu']);
					}
			}
		}
		return $gabinety;
	}


	$id_gabinetow = gabinety($wiersz, $mysqli);
	echo "Wybierz gabinet:";


	foreach($id_gabinetow as $item) {

		$query = "select numer from gabinety ";
		$query.= "where id = \"". $item. "\"";

			$wynik = mysqli_query($mysqli,$query)
				or die("Błąd zapytania:". mysqli_error($mysqli));

			if($wynik){ 
				$row = mysqli_fetch_assoc($wynik);
				$forma3 ="<form action = \"calendar.php\">";
				$forma3.="<input type=\"hidden\" name =\"gabinet\" value=\"". $item ."\" >";
				$forma3.= "<input type=\"submit\" value=\"Przeglądaj kalendarz gabinetu nr ". $row['numer'] ."\" />";
				$forma3.="</form>";
			}

		echo $forma3;
	}


	$form4 ="<form action = \"wolne.php\">";
	foreach($id_gabinetow as $key => $item) {	
		$form4.="<input type=\"hidden\" name =\"gabinet". $key ."\" value=\"". $item ."\" >";
	}
	$form4.= "<input type=\"submit\" value=\"Spis dzierzaw\" />";
	$form4.="</form>";

	echo $form4;



	}

	else {
		echo "Nie masz uprawnień do tego skryptu";
	}
	include ("stopka.php");
?>