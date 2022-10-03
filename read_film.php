<?php
	require_once "../config.php";
	
	//loon andmebaasiga ühenduse
	// server , kasutaja, parool, andmebaas 
		
	$db_connection = new mysqli($server_host, $server_user_name, $server_password, $database);
		
	//määran suhtlemisel kasutatava kooditabeli
		
	$db_connection->set_charset("utf8");
	
	//valmistame ette andmete saatmise SQL käsu
		
	$stmt = $db_connection->prepare("SELECT pealkiri, aasta, kestus, zanr FROM film");
	echo $db_connection->error;
	
	//seome saadavad andmed muutujatega
	
	$stmt->bind_result($pealkiri_db, $aasta_db, $kestus_db, $zanr_db);
	
	//täidame käsu
	
	$stmt->execute();
	// kui saan ühe kirje 
	//if($stmt->fetch());
	//kui tuleb teadmata arv kirjeid
	
	$film_html = null;
	while($stmt->fetch())
	{
		//echo $comment_from_db;
		//<p>pealkiri, aasta xxxx, kestus xx min, zanr</p>
	$film_html .= "<p>" .$pealkiri_db .", aastal: " .$aasta_db;
	$film_html .= ", kestus " .$kestus_db ."min, " .$zanr_db ."</p>\n";
	}
	
	//sulgeme k2su
	$stmt->close();
	
	//sulgeme andmebaasi uhenduse
	$db_connection->close();
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Filmide lapang</title>
</head>

<body>

<?php echo $film_html; ?>

</body>

</html>