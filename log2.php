<?
	session_start();
	include("nagl.php");
	include ("polacz.php");
	
	echo $_POST['email'] . "<br>";
	echo $_POST['haslo'] . "<br>";
	echo isset($_POST['email']);
	print_r($_POST);

	if(isset($_SESSION)){
		echo "Zmienne sesji:<br>";
		print_r($_SESSION);
		echo "<br><br>";
		print_r($_POST);
		echo "<br><br>";
	}else
		echo "Sesja nie zostala jeszcze zainicjowana <br><br>";
		
	if ((!isset($_POST['email'])) && (isset($_SESSION))){
		$kwerenda = "select email, haslo, nazwisko, uprawnienia from nazwiska ";
		$kwerenda.= "where nazwisko = \"". $_SESSION['nazwisko']. "\""; //"\" AND haslo = \"". md5($_SESSION['haslo']). "\"";
	}
	else {

	$kwerenda = "select email, haslo, nazwisko, uprawnienia from nazwiska ";
	$kwerenda.= "where email = \"". $_POST['email']. "\"";
	}
	echo $kwerenda . "<br><br>";
	
	$wynik = mysqli_query($mysqli, $kwerenda)
	or die('Blad zapytania');
		
		if($wynik){
			$wiersz = mysqli_fetch_assoc($wynik);
			echo mysqli_fetch_assoc($wynik);
			$has = $wiersz['haslo'];
			echo "Zakodowane przez md5 haslo z bazy = $has<br>";
		}
				
		echo "========================================<br>";

		
		if((isset($has)) && md5($_POST['haslo']) == $has){
			echo"<br>Logujacy podal poprawne dane <br>";
			echo "Mozna rozpoczac sesje <br><br>";
			$_SESSION['login'] = $_POST['haslo'];
			$_SESSION['nazwisko'] = $wiersz['nazwisko'];
			}
			if(((isset($has)) && (md5($_POST['haslo']) == $has)) || ((isset($_SESSION['login']))&&(md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko']))){
				print_r($wiersz);
				switch($wiersz['uprawnienia']){
					case -1:
						echo "Pacjent";
						echo "<br>";
						include("panel_pacjenta.php");
						break;
					case 0:
						echo "Lekarz";
						$forma4 ="<form action = \"wybor_gabinetu.php\">";
						$forma4.= "<input type=\"submit\" value=\"Sprawdź dostępnosć gabinetów\" />";
						$forma4.="</form>";

						$forma3 ="<form action = \"wolne.php\">";
						$forma3.= "<input type=\"submit\" value=\"Kiedy gabinety są zajęte\" />";
						$forma3.="</form>";

						echo $forma4;

						break;
					case 1:
						echo "Admin<br>";
						
						$forma ="<form action = \"add.php\" method=\"POST\">";
						$forma.= "<input type=\"submit\" value=\"Dodaj rekord\" />";
						$forma.="</form>";

						$forma1 ="<form action = \"edit.php\">";
						$forma1.= "<input type=\"submit\" value=\"Edytuj rekordy\" />";
						$forma1.="</form>";

						$forma2 ="<form action = \"delete.php\">";
						$forma2.= "<input type=\"submit\" value=\"Usuwaj rekordy\" />";
						$forma2.="</form>";

						$forma3 ="<form action = \"calendar.php\">";
						$forma3.= "<input type=\"submit\" value=\"Przeglądaj kalendarz\" />";
						$forma3.="</form>";


						echo $forma;
						echo $forma1;
						echo $forma2;
						echo $forma3;
						break;
					default:
						echo "Coś poszło nie tak";
						break;
				}
				$forma ="<form action = \"dalej.php\" method=\"POST\">";
				$forma.= "<input type=\"submit\" value=\"Kontynuacja sesji\" />";
				$forma.="</form>";
				
						$button="<form action=\"wyloguj.php\" method=\"POST\">";
						$button.= "<input type = \"submit\" value=\"Wyloguj\"/>";
						$button.= "</form>";

				echo $forma;
				echo $button;
			
			}
		if((isset($_POST['email']))&&(!((isset($has)) && md5($_POST['haslo']) == $has))){
			echo "Podales zle dane - nie masz uprawnien";
		}
	?>
	
	<?
		include("stopka.php");
	?>
