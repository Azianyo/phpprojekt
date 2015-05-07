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
		$kwerenda.= "where nazwisko = \"". $_SESSION['nazwisko']. "\" AND haslo = \"". md5($_SESSION['haslo']). "\"";
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
		echo $wiersz['haslo'];		
		if(!((md5($_SESSION['login'])==$wiersz['haslo'])&&($_SESSION['nazwisko']==$wiersz['nazwisko']))) echo "zle";
		
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
						echo "Siema";
						echo "<br>";
						break;
					case 0:
						echo "Nie";
						break;
					case 1:
						echo "hej admin hej<br>";
						
						$forma ="<form action = \"add.php\" method=\"POST\">";
						$forma.= "<input type=\"submit\" value=\"Dodaj rekord\" />";
						$forma.="</form>";

						$forma1 ="<form action = \"edit.php\">";
						$forma1.= "<input type=\"submit\" value=\"Edytuj rekordy\" />";
						$forma1.="</form>";

						$forma2 ="<form action = \"delete.php\">";
						$forma2.= "<input type=\"submit\" value=\"Usuwaj rekordy\" />";
						$forma2.="</form>";

						echo $forma;
						echo $forma1;
						echo $forma2;
						break;
					default:
						echo "Coś poszło nie tak";
						break;
				}
				$forma ="<form action = \"dalej.php\" method=\"POST\">";
				$forma.= "<input type=\"submit\" value=\"Kontynuacja sesji\" />";
				$forma.="</form>";
				
				echo $forma;
			
			}
		if((isset($_POST['email']))&&(!((isset($has)) && md5($_POST['haslo']) == $has))){
			echo "Podales zle dane - nie masz uprawnien";
		}
	?>
	
	<?
		include("stopka.php");
	?>
