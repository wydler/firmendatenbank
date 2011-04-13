<!DOCTYPE html>
<html lang="de">
<head>
	<title>Firmendatenbank - Hochschule Ravensburg-Weingarten</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="author" content="Michael Wydler und Simon Westphahl">
	<meta name="description" content="Firmendatenbank der Hochschule Ravensburg-Weingarten." />
	<meta name="keywords" content="firmen,datenbank,praktikum" />
	<link rel="stylesheet" href="./style/screen.css" media="screen" />
</head>
<body>
<div id="container">
	<?php include 'index.inc.php' ?>

	<div id="header">
		<img id="logo" src="./img/hs-logo.gif" width="275" height="119">
		<div id="search">
			<form>
				<input type="search" id="search_field" placeholder=" Suche..." /><input type="submit" name="search_go" value="Suchen">
			</form>
		</div>
	</div>
	<div id="banner" class="clear">
		<h1>Firmendatenbank</h1>
	</div>
	<div id="filter">
		<form action="index.php" method="get">
		<div class="main">
		<p class="head">Studienschwerpunkte</p>
		<p>
			<?php
				foreach(getSchwerpunkte() as $row)
				{
					echo '<input type="checkbox" name="schwerpunkte[]" value="'.strtolower($row['name']).'" '.inArray($validGET['schwerpunkte'], $row['name']).'> '.$row['name'].' ('.$row['count'].')<br />';
				}
			?>
			<!--
			<input type="checkbox" name="schwerpunkte" value="automatisierungstechnik"> Automatisierung (4)<br />
			<input type="checkbox" name="schwerpunkte" value="multimediaengineering"> Informationsnetze (1)<br />
			<input type="checkbox" name="schwerpunkte" value="informationsnetze"> Multimedia (2)
			-->
		</p>
		</div>
		<div class="main">
		<p class="head">Bewertung</p>
		<?php 
			if(array_key_exists('rating', $_GET))
			{
				$rating = validRating($validGET['rating']);
			}
			else 
			{
				$rating = 0;
			}
		?>
		<?php
		for($i=4; $i >= 0; $i--)
		{
			if($rating==$i)
			{
				$checked = "checked";
			}
			else
			{
				$checked = "";
			}
			echo '<input type="radio" name="rating" id="rating'.$i.'" value="'.$i.'" '.$checked.' class="radio">';
			echo '<label for="rating'.$i.'">';
			for($k=1; $k<=5; $k++)
			{
				if($k <= $i)
				{
					echo '<img src="./img/star.png" />';
				}
				else
				{
					echo '<img src="./img/star_bw.png" />';
				}
			}
			echo '  & mehr (2) </label>';
			echo '<br />';
		}
		?>
		<!--
		<input type="radio" name="rating" id="rating4" value="4" <?php if($rating==4){echo "checked";} ?> >
			<label for="rating4"><img src="./img/star.png" /><img src="./img/star.png" /><img src="./img/star.png" /><img src="./img/star.png" /><img src="./img/star_bw.png" /> & mehr (2)</label><br />
		<input type="radio" name="rating" id="rating3" value="3" <?php if($rating==3){echo "checked";} ?> >
			<label for="rating3"><img src="./img/star.png" /><img src="./img/star.png" /><img src="./img/star.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /> & mehr (4)</label><br />
		<input type="radio" name="rating" id="rating2" value="2" <?php if($rating==2){echo "checked";} ?> >
			<label for="rating2"><img src="./img/star.png" /><img src="./img/star.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /> & mehr (6)</label><br />
		<input type="radio" name="rating" id="rating1" value="1" <?php if($rating==1){echo "checked";} ?> >
			<label for="rating1"><img src="./img/star.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /> & mehr (7)</label><br />
		<input type="radio" name="rating" id="rating0" value="0" <?php if($rating==0){echo "checked";} ?> >
			<label for="rating0"><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /> & mehr (7)</label>-->
		<!--
		<a href="#">
			<img src="./img/star.png" /><img src="./img/star.png" /><img src="./img/star.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /> & mehr (4)
		</a>
		<a href="#">
			<img src="./img/star.png" /><img src="./img/star.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /> & mehr (6)
		</a>
		<a href="#">
			<img src="./img/star.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /> & mehr (7)
		</a>
		<a href="#">
			<img src="./img/star_bw.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /><img src="./img/star_bw.png" /> & mehr (7)
		</a>-->
		</div>
		<div class="main">
		<p class="head">Themengebiete</p>
		<p>
			<?php
				foreach(getThemen() as $row)
				{
					echo '<input type="checkbox" name="themen[]" value="'.strtolower($row['name']).'" '.inArray($validGET['themen'], $row['name']).'> '.$row['name'].' ('.$row['count'].')<br />';
				}
			?>
			<!--
			<input type="checkbox" name="themen" value="c" checked> C (3)<br />
			<input type="checkbox" name="themen" value="cpp"> C++ (5)<br />
			<input type="checkbox" name="themen" value="java"> Java (3)<br />
			<input type="checkbox" name="themen" value="php"> PHP (1)<br />
			<input type="checkbox" name="themen" value="python"> Python (2)<br />
			-->
		</p>
		</div>
		<p class="buttonrow">
			<input type="reset" name="aktion" value="Zur&uuml;cksetzen"> 
			<input type="submit" name="aktion" value="Filter">
		</p>
		<br />
	</div>
	<div id="content">
		<div style="font-size:0.9em"><a href="index.php?<?php echo http_build_query($validGET) ?>">zur Übersicht</a></div>
		<h1>Railware Ltd.</h1>
		<div id="column_left">
			<h3>Anschrift</h3>
			<p>
				Musterstraße 54<br />
				12345 Musterhausen
			</p>
			<br />
			<h3>Kontakt</h3>
			<p>
				<a href="http://www.musterfirma.de">http://www.musterfirma.de</a><br />
				<a href="mailto:max.mustermann@musterfirma.de">max.mustermann@musterfirma.de</a>
			</p>
			<br />
			<h3>Schwerpunkte</h3>
			<p>
				Automatisierungstechnik<br />
				Informationsnetze
			</p>
			<br />
			<h3>Themen</h3>
			<p>C, C++, Java, Python</p>
		</div>
		<div id="column_right">
			<h3>Gesamtbewertung</h3>
			<div class="rating_bg">
				<div class="rating_stars" style="width:50%"></div>
			</div>
			<br />
			<h3>Neue Bewertung verfassen</h3>
			<form>
				<textarea rows="5" maxlength="50" style="width:98%"></textarea>
				<p class="buttonrow">
					<input type="reset" name="reset_filter" value="Zur&uuml;cksetzen"> 
					<input type="submit" name="apply_filter" value="Absenden">
				</p>
			</form>
			<br />
			<h3>Einzelbewertungen</h3>
			<div class="comment_box">
				<div class="rating_bg">
					<div class="rating_stars" style="width:40%"></div>
				</div>
				<p>Lorem ipsum dolor sit amet, consectetur cras amet.</p>
			</div>
			<div class="comment_box">
				<div class="rating_bg">
					<div class="rating_stars" style="width:80%"></div>
				</div>
				<p>Lorem ipsum dolor sit amet, consectetur cras amet.</p>
			</div>
			<div style="text-align:right;font-size:0.8em"><a href="#">Alle anzeigen (52)</a></div>
		</div>
	</div>
</div>
<div id="debug" class="clear">
	<?php print_r($_GET); ?><br />
	<?php print_r(http_build_query($validGET)) ?>
</div>
</body>
</html>
