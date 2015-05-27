<?php
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == "1")){
	date_default_timezone_set('UTC');

	$next = $_POST['next'];  

	if(!isset($_POST['next'])){
		$next = 0;
	}


	if(!isset($_POST['next'])&& isset($_POST['data'])) {
		 $first = new DateTime($_POST['data'] . " " . $_POST['godzina_poczatek']);
		 $second = new DateTime($_POST['data'] . " " . $_POST['godzina_koniec']);
		 $diff = $first->diff($second);


		 $query = "SELECT FROM 'dzierzawy' WHERE `data`='" . $_POST['data'] . "';";

		 echo $query;

		 $result = mysqli_query($mysqli,$query);

		 if($result){
		 	while($row = mysqli_fetch_assoc($result)){
		 		$hour_database = new DateTime($_row['data'] . " " . $_row['godzina_poczatek']);
		 		$hour_post = new DateTime($_POST['data'] . " " . $_POST['godzina_poczatek']);
		 		
		 	}

		 }
		if($_POST['godzina_poczatek']<$_POST['godzina_koniec']){
			if((($diff->h)>=2) && $_POST['godzina_poczatek']){
				$add = "INSERT INTO `dzierzawy`(`";
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
			else {
				echo "Gabinet można wydzierżawić minimalnie na 2 godziny!";
			}
		}
		else {
			echo "Czas dzierżawy nie może być ujemny!";
		}
	}


	for($i=0; $i<7;$i++){
		$nextWeek = time() + ($i * 24 * 60 * 60) + ($_POST['next']*7 * 24 * 60 * 60);
		$weekday = date("D: Y-m-d", $nextWeek);
		$date = date('Y-m-d',$nextWeek);

		$query = "SELECT * FROM `dzierzawy` WHERE data = '".$date ."'";
		$sukces = mysqli_query($mysqli,$query)
		or die("Błąd: " . mysqli_error($mysqli));

		if($sukces){
			$row = mysqli_fetch_assoc($sukces);
			echo "<h3>" . $weekday . "</h3>";
			for($j=7;$j<22;$j++){
				echo $j . "<br>";
				if($j+1 > $row['godzina_poczatek'] && $row['godzina_poczatek'] >= $j){
					print_r($row);
					while($row['godzina_koniec'] > $j){
						echo "<br>";
						$j+=1;
					}
				}
			}
			echo "<br>";
		}
	}	

	?>


	<form action="calendar.php" method = "POST">
	<input type = "hidden" name = "next" value="<? echo $next-1; ?>"/><br>
	<input type="submit" value="Poprzedni tydzień" />
	</form>

	<form action="calendar.php" method = "POST">
	<input type = "hidden" name = "next" value="<? echo $next+1; ?>"/><br>
	<input type="submit" value="Następny tydzień" />
	</form>

		<?php

		echo "Dodaj wizytę:";
		$forma = "<form action=\"calendar.php\" method=\"POST\">";
		$query = "SELECT * FROM `dzierzawy` WHERE 1";
		$sukces = mysqli_query($mysqli,$query)
			or die('Błąd zapytania' . mysqli_error($mysqli));
			
			if($sukces){
				$row = mysqli_fetch_assoc($sukces);
				foreach($row as $key => $obj){
					if($key == 'id'){}
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