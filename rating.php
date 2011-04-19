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
<?php include 'index.inc.php' ?>
<div id="debug" class="clear">
	<?php print_r($_GET); ?><br />
	<?php print_r(http_build_query($validGET)) ?>
</div>
<div id="container">
	<div id="banner" class="clear">
		<h1>Firmendatenbank</h1>
	</div>
	<?php include 'filter.php' ?>
	<div id="content">
		<div style="font-size:0.9em"><a href="index.php?<?php echo http_build_query($validGET) ?>">Zurück</a></div>
		<h1>Railware Ltd.</h1>
		<div id="column_left">
			<h3>Gesamtbewertung</h3>
			<div class="rating_bg">
				<div class="rating_stars" style="width:50%"></div>
			</div>
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
		</div>
		<div id="column_right">
			<h3>Neue Bewertung verfassen</h3>
			<form>
				<textarea rows="5" maxlength="50" style="width:98%"></textarea>
				<p class="buttonrow">
					<input type="reset" name="reset_filter" value="Zur&uuml;cksetzen"> 
					<input type="submit" name="apply_filter" value="Absenden">
				</p>
			</form>
		</div>
	</div>
</div>
</body>
</html>
