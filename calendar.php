<?
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == "1")){
	date_default_timezone_set('UTC');

	for($i=0; $i<8;$i++){
		$nextWeek = time() + ($i * 24 * 60 * 60);
		$weekday = date("D", $nextWeek);
		$date = date('Y-m-d',$nextWeek);

		$query = "SELECT * FROM `wizyty` WHERE data = '".$date ."'";
		$sukces = mysqli_query($mysqli,$query)
		or die("Błąd: " . mysqli_error($mysqli));

		if($sukces){
			$row = mysqli_fetch_assoc($sukces);
			echo $weekday . "<br>";
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
		}
	}	

	?>


		<?
	}
	else {
		echo "Nie masz uprawnień do tego skryptu";
	}
	include ("stopka.php");
?>?>