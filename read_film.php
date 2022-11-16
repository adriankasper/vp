<?php
	require_once ("../../config.php");

	session_start();
	if(!isset($_SESSION["user_id"])){
		header("Location: page.php");
		exit();
	}

	$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
	$conn-> set_charset("utf8");
	
	$stmt = $conn->prepare("SELECT PEALKIRI, aasta, kestus, zanr, tootja, lavastaja FROM film");
	echo $conn->error; 
	$stmt->bind_result($pealkiri_from_db, $aasta_from_db, $kestus_from_db, $zanr_from_db, $tootja_from_db, $lavastaja_from_db);
	$stmt->execute();
	$film_html = null;	
	while($stmt->fetch()){
		$film_html .= "<h3>" .$pealkiri_from_db ."</h3>". "<ul>". "<li>" ." Valmimisaasta: " .$aasta_from_db . "</li>". "<li>" ." Kestus: " .$kestus_from_db . " minutit". "</li>". "<li>" ." Žanr: " .$zanr_from_db . "</li>". "<li>" ." Tootja: " .$tootja_from_db . "</li>". "<li>" ." Lavastaja: " .$lavastaja_from_db . "</li>". "</ul>";
	}

	$stmt->close();
	$conn->close();
	
		if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
		exit();
	}

?>

<!DOCTYPE html>
<html lang="et">
<body>

<?php echo $film_html; ?>
<ul>
	<li><a href="?logout=1">Logi välja</a></li>
</ul>
</body>