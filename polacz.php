<?
	//dolaczenie  skryptu ze zmiennymi
	include("zmienne.php");
	
	//polaczenie z serwerem bazy
		$mysqli = mysqli_connect($host, $user, $passwd, $baza)
			or die("Brak polaczenia z serwerem MySQL");
	//laczymy sie z baza danych
		//@mysql_select_db($baza)
			//or die("Blad wyboru bazy danych");
	if (!$mysqli->set_charset("utf8")) {
    	printf("Error loading character set utf8: %s\n", $mysqli->error);
	} else {
    	//printf("Current character set: %s\n", $mysqli->character_set_name());
	}
?>