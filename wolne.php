<?php
	session_start();
	include("nagl.php");
	include("polacz.php");
	include("sessioncheck.php");

	?>

	<style type="text/css" media="print">
		.no-print { display: none; }
	</style>

	<?

	if((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko'])&&($wiersz['uprawnienia'] == "0")){

		if(isset($_POST['od'])&&isset($_POST['do'])){
			foreach($_POST as $key => $val){
				if($key == "od" || $key =="do"){}
				else {
					$kwerenda = "select * from dzierzawy where id_gabinetu =". $val ." and data between '". $_POST['od'] ."' and '". $_POST['do'] ."' order by data asc, godzina_poczatek asc";

					$query = "select numer from gabinety ";
					$query.= "where id = \"". $val. "\"";

					$wynik = mysqli_query($mysqli,$query)
						or die("Błąd zapytania:". mysqli_error($mysqli));

					if($wynik){ 
							$row = mysqli_fetch_assoc($wynik);
							echo "Dzierżawy gabinetu nr:". $row['numer'] ."<br>";

						$wynik = mysqli_query($mysqli,$kwerenda)
							or die("Błąd zapytania:". mysqli_error($mysqli));

						if($wynik){ 
							while($row = mysqli_fetch_assoc($wynik)){
								echo "Data:" . $row['data']."<br>";
								echo "Godziny:" . $row['godzina_poczatek']." - ". $row['godzina_koniec']."<br>";
							}
						}
					}
				}
			}
		}

		echo "Wyświetl dzierżawy w okresie:";
		$form4 ="<form action = \"wolne.php\" method=\"POST\" class=\"no-print\">";
		foreach($_POST as $key => $item) {	
			if($key == "od" || $key =="do"){}
			else{
				$form4.="<input type=\"hidden\" name =\"gabinet". $key ."\" value=\"". $item ."\" >";
			}
		}
		$form4.= "Od: <input type=\"date\" name=\"od\" size=\"20\" maxlength=\"30\" /><br>";
		$form4.= "Do: <input type=\"date\" name=\"do\" size=\"20\" maxlength=\"30\" /><br>";
		$form4.= "<input type=\"submit\" value=\"Wyświetl\" />";
		$form4.="</form>";

		echo $form4;
	?>

	<form>
		<input type="button" onClick="window.print()" class="no-print" value="Wydrukuj lub ściągnij  PDF">
	</form>

	<?

	}


	else {
		echo "Nie masz uprawnień do tego skryptu";
	}
	include ("stopka.php");
?>