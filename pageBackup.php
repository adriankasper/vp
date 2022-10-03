<?php
	$author_name = "Adrian Käsper";
	$full_time_now = date("d.m.Y H:i:s");
	$weekday_now = date("N");

	$weekdaynames_et = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	$proverbs_et = ["Suur tükk ajab suu lõhki.", "Tänaseid toimetusi ära viska homse varna.", "Üheksa korda mõõda, üks kord lõika.", "Õnnetus ei hüüa tulles.", "Kordamine on tarkuse ema."];
	
	$random_proverb = $proverbs_et[mt_rand(0, count($proverbs_et) - 1)];
	
	$hours_now = date("H");
	$part_of_day = "suvaline päeva osa";
	if ($weekday_now <= 5)
	{
		if($hours_now < 7)
		{
			$part_of_day = "uneaeg";
		}
		if($hours_now >= 7 & $hours_now < 18)
		{
			$part_of_day = "koolipäev";
		}
			if($hours_now >= 18)
		{
			$part_of_day = "vaba aeg";
		}
	}
	else
	{
		$part_of_day = "puhkus";
	}
	
	//uurime semestri kestmist
	$semester_begin = new DateTime("2022-9-5");
	$semester_end = new DateTime("2022-12-18");
	
	$semester_duration = $semester_begin->diff($semester_end);
	$semester_duration_days = $semester_duration->format("%r%a");
	
	$from_semester_begin = $semester_begin->diff(new DateTime("now"));
	$from_semester_begin_days = $from_semester_begin->format("%r%a");
	
	//juhuslik arv
	//küsin massiivi pikkust
	//echo count($weekdaynames_et);
	//echo $weekdaynames_et[mt_rand(0, count($weekdaynames_et) - 1)];
	
	$photo_dir = "photos";
	//loen kataloogi sisu
	$all_files = array_slice(scandir($photo_dir), 2);
	//kontrollin kas foto
	$allowed_photo_types = ["image/jpeg", "image/png"];
	//tsükkel
	/*muutuja väärtuse suurendamine
	$muutuja = $muutuja + 5
	$muutuja += 5
	$muutuja++
	*/
	/*for($i = 0; $i < count($all_files); $i++)
	{
		echo $all_files[$i];
	}
	*/
	$photo_files = [];
	foreach($all_files as $file_name)
	{
		$file_info = getimagesize($photo_dir ."/" .$file_name);
		// kas on lubatud tüüpide nimekirjas
		if(isset($file_info["mime"]))
		{
			if(in_array($file_info["mime"], $allowed_photo_types))
			{
				array_push($photo_files, $file_name);
			}
		}
	}
	// <img src="kataloog/fail" alt="tekst">
	$photo_number = mt_rand(0, count($photo_files) - 1);
	$photo_html = '<img src="' .$photo_dir . "/" .$photo_files[$photo_number] . '"' . ' alt="Tallinna pilt">';
	
	//var_dump($_POST)
	//echo $_POST["todays_adjective_input"];
	$todays_adjective = "Pole midagi sisestatud";
	if (isset($_POST["todays_adjective_input"]) and !empty($_POST["todays_adjective_input"]))
	{
		$todays_adjective = $_POST["todays_adjective_input"];
	}
	$select_html = '<option value="" selected disabled>Vali pilt</option>';
	for($i = 0; $i < count($photo_files); $i++)
	{
		$select_html .= '<option value="' .$i .'">' .$photo_files[$i] ."</option>";

	}
	
	if(isset($_POST["photo_select"]) and ($_POST["photo_select"] >=0))
	{
		echo "Valiti pilt nr: " .$_POST["photo_select"];
	}
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $author_name;?> programmeerib veebi</title>
</head>

<body>
	<a> <img src="media/vp_banner_gs.png" alt="Lehekülje banner"></a>
	<h1>Adrian Käsper programmeerib veebi</h1>
	<p>Seel leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/" target="_blank">Tallinna Ülikoolis</a> Digitehnoloogiate instituudis.</p>
	<p>Lehe avamise hetk: <?php echo $weekdaynames_et[$weekday_now - 1] .", " .$full_time_now;?></p>
	<p>Praegu on <?php echo $part_of_day;?></p>
	
	<p>Eesti vanasõna: <?php echo $random_proverb;?></p>
	
	<p>Semestri pikkus on <?php echo $semester_duration_days?> päeva. See on kestnud juba <?php echo $from_semester_begin_days?> päeva.</p>
	<a href="https://www.tlu.ee/" target="_blank"><img src="media/tlu_2.jpg" alt="TLÜ klaasist lagi"></a>
	<a href="https://www.tlu.ee/" target="_blank"><img src="media/tlu_3.jpg" alt="TLÜ koridorid"></a>
	<p>Minu nimi on Adrian, olen 20 aastane ja varem õppisin Saku Gümnaasiumis.</p>
	<form method="POST">
		<input type="text" id="todays_adjective_input" name="todays_adjective_input" placeholder="Kirjuta siia omadussõna tänase päeva kohta">
		<input type="submit" id="todays_adjective_submit" name="todays_adjective_submit" value="Saada omadussõna">
	</form>
	<p>Omadussõna tänase kohta: <?php echo $todays_adjective ?></p>
	<form method="POST">
		<select id="photo_select" name="photo_select">
			<?php echo $select_html?>
		<input type="submit" id="photo_submit" name="photo_submit" value="Saada foto">
	</form>
	<hr><?php
		if(isset($_POST["photo_select"]) and ($_POST["photo_select"] >=0))
		{
			$photo_number = $_POST["photo_select"];
			$photo_html = '<img src="' .$photo_dir . "/" .$photo_files[$photo_number] . '"' . ' alt="Tallinna pilt">';
			echo $photo_html;
		}
		else
		{
		echo $photo_html;
		}
	?></hr>
</body>
</html>