<?php
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == "-1")){


		if(isset($_POST['data'])&&isset($_POST['godzina_poczatek'])&&isset($_POST['godzina_koniec'])){
			$add = "INSERT INTO `wizyty`(`";
						foreach($_POST as $key => $val){
							if(end($_POST) == $val){
								$add.= $key . "`) VALUES ('";
							}
							else {
								$add.= $key . "`, `";
							}
						}
						foreach($_POST as $key => $val){
							if(end($_POST) == $val){
								$add.= $val . "')";
							}
							else {
								$add.= $val . "', '";
							}
						}
					
					$wynik = mysqli_query($mysqli,$add)
					or die("Bład zapytania: " . mysqli_error($mysqli));

					if($wynik) {
						echo "Dodano rekord: " . $add . "<br>";
					}
					else {
						echo "Dodanie rekordu nie powiodło się <br>";
					}
		}


		$query2 = "select imie, nazwisko from lekarze where id=\"".$_POST['id_lekarze']."\"";

		$wynik2 = mysqli_query($mysqli,$query2)
		or die("Błąd zapytaniaa:". mysqli_error($mysqli));

				
		if($wynik2){ 
			$row2 = mysqli_fetch_assoc($wynik2);
			echo "<h1>Dr. ". $row2['imie'] ." ". $row2['nazwisko']." - dostępne terminy</h1>";
		}

		$query = "select * from dzierzawy where id_lekarza=". $_POST['id_lekarze'] ." order by data asc, godzina_poczatek asc";
		$wynik = mysqli_query($mysqli,$query)
			or die("Błąd zapytania:". mysqli_error($mysqli));

			
		if($wynik){ 
			while($row = mysqli_fetch_assoc($wynik)){
				print_r($row);
			}
		}

		echo "Zarezerwuj wizytę:";
		$forma = "<form action=\"rezerwacja_wizyty.php\" method=\"POST\">";
		$query = "SELECT * FROM `wizyty` WHERE 1";
		$sukces = mysqli_query($mysqli,$query)
			or die('Błąd zapytania' . mysqli_error($mysqli));
			
			if($sukces){
				$row = mysqli_fetch_assoc($sukces);
				foreach($row as $key => $obj){
					if($key == 'id'){}
					else if($key == 'id_lekarze') {
						$forma.= "<input type=\"hidden\" name=\"". $key ."\" value=\"".$_POST['id_lekarza']."\" size=\"20\" maxlength=\"30\" /><br>";

					}
					else if($key == 'id_nazwiska') {
						$forma.= "<input type=\"hidden\" name=\"". $key ."\" value=\"".$wiersz['id']."\" size=\"20\" maxlength=\"30\" /><br>";

					}
					else if($key == 'data') {
						$forma.= $key . ": <input type=\"date\" name=\"". $key ."\" size=\"20\" maxlength=\"30\" /><br>";

					}
					else {
						$forma.= $key . ": <input type=\"text\" name=\"". $key ."\" size=\"20\" maxlength=\"30\" /><br>";
					}
				}
			}
		$forma.= "<input type=\"submit\" value=\"Dodaj rekord\" />";
		$forma.="</form>";
		echo $forma;

	}		
	else {
		echo "Nie masz uprawnień do tego skryptu";
	}
	include ("stopka.php");
?>