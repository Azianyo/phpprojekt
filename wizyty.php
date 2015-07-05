<?php
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == "-1")){

		$now = new DateTime(); 

		if(isset($_POST['wizyta'])){
			$sql = "DELETE FROM `wizyty` WHERE id='". $_POST['wizyta'] . "'";
			$sukces = mysqli_query($mysqli, $sql)
			or die('Błąd zapytania' . mysqli_error($mysqli));

			if($sukces){
				echo "Usunięto wizytę <br>";
			}
		}

		$query = "select * from wizyty where id_nazwiska=". $wiersz['id'] ." order by data asc, godzina_poczatek asc";
		$wynik = mysqli_query($mysqli,$query)
			or die("Błąd zapytania:". mysqli_error($mysqli));
		//echo $query;
			
		if($wynik){ 
			while($row = mysqli_fetch_assoc($wynik)){
				
				$string = $row['data']." ".$row['godzina_poczatek'];
				$datetime = new DateTime($string);
				if($datetime>$now){

					$query2 = "select imie, nazwisko from lekarze where id=". $row['id_lekarze'];
					$wynik2 = mysqli_query($mysqli,$query2)
					or die("Błąd zapytania:". mysqli_error($mysqli));
					
					if($wynik2){ 
						$row2 = mysqli_fetch_assoc($wynik2);
						
						echo "Wizyta u dr: ". $row2['imie'] . " ". $row2['nazwisko'] ." ";
					}
					echo "Data: ".$row['data'] ." Godziny: ".$row['godzina_poczatek']."-".$row['godzina_koniec']."<br>";
					
					$diff = $now->diff($datetime);
					//printf('%d days, %d hours, %d minutes', $diff->d, $diff->h, $diff->i);

					$diff1 = new DateTime("1990-01-01 12:00:00");
					$diff2 = new DateTime("1990-01-02 12:00:00");
					$doba = $diff1->diff($diff2);
					//printf('%d days, %d hours, %d minutes', $doba->d, $doba->h, $doba->i);

					$doba_s = ($doba->i*60) + ($doba->h*3600) + ($doba->d* 86400);
					$datetime_s = ($diff->i*60) + ($diff->h*3600) + ($diff->d* 86400);

					//echo $doba_s . "<br>";
					//echo $datetime_s;

					if($datetime_s<$doba_s){
						$forma ="<form action = \"wizyty.php\" method=\"POST\">";
						$forma.="<input type=\"hidden\" name =\"wizyta\" value=\"". $row['id'] ."\" >";
						$forma.= "<input type=\"submit\" value=\"Rezygnuj\" />";
						$forma.="</form>";

						echo $forma;
					}
				}

			}
		}
	}		
	else {
		echo "Nie masz uprawnień do tego skryptu";
	}
	include ("stopka.php");
?>