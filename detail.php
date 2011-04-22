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
<?php 
	include 'index.inc.php';
	$page = new Page();
	
	if(!array_key_exists("fid", $page->validGET))
	{
		header('Location: index.php');
	}
	
	if(array_key_exists("submit_rating", $_POST))
	{
		$result = $page->addBewertung();
	}
?>
<div id="container">
	<div id="banner" class="clear">
		<h1>Firmendatenbank</h1>
	</div>
	<div id="filter">
		<div class="main">
			<p class="head"><a href="index.php">Zurück</a></p>
		</div>
	</div>
	<div id="content">
		<?php $firma = $page->getFirma($page->validGET['fid']) ?>
		<h1><?php echo utf8_encode($firma['name']) ?></h1>
		<div>
			<table style="width:723px">
				<colgroup>
					<col style="width:25%">
					<col style="width:30%">
					<col style="width:25%">
					<col style="width:20%">
				</colgroup>
				<tbody style="font-size:0.9em;">
					<tr>
						<td style="padding:10px;">
							<h3>Anschrift</h3>
							<p>
								<?php echo utf8_encode($firma['strasse']) ?><br />
								<?php echo utf8_encode($firma['plz']." ".$firma['standort']) ?>
							</p>
						</td>
						<td style="padding:10px;">
							<h3>Kontakt</h3>
							<p>
								<a href="http://<?php echo urlencode($firma['url']) ?>"><?php echo utf8_encode($firma['url']) ?></a><br />
								<a href="mailto:<?php echo urlencode($firma['email']) ?>"><?php echo utf8_encode($firma['email']) ?></a>
							</p>
						</td>
						<td style="padding:10px;">
							<?php $schwerpunkte = $page->getSchwerpunkte($page->validGET['fid']) ?>
							<h3>Schwerpunkte</h3>
							<ul>
								<?php
									foreach($schwerpunkte as $schwerpunkt)
									{
										echo "<li>{$schwerpunkt['name']}</li>";
									}
								?>
							</ul>
						</td>
						<td style="padding:10px;">
							<?php $themen = $page->getThemen($page->validGET['fid']) ?>
							<h3>Themen</h3>
							<ul>
								<?php
									foreach($themen as $thema)
									{
										echo "<li>{$thema['name']}</li>";
									}
								?>
							</ul>
						</td>
					</tr>
				</tbody>
			</table>
			<br />
		</div>
		<div id="rating">
			<div id="column_left">
				<h3>Gesamtbewertung</h3>
				<div class="rating_bg">
					<div class="rating_stars" style="width:<?php echo $firma['bew_avg']*20 ?>%"></div>
				</div>
				<br />
				<h3>Einzelbewertungen</h3>
				<?php
					$bewertungen = $page->getBewertungen($page->validGET['fid']);
				?>
				<?php 
					foreach($bewertungen as $bewertung)
					{
						$rating = $bewertung['bewertung'] * 20;
						echo "<div class=\"comment_box\">";
						echo "    <div class=\"rating_bg\">";
						echo "        <div class=\"rating_stars\" style=\"width:$rating%\"></div>";
						echo "    </div>";
						echo "    <p>{$bewertung['kommentar']}</p>";
						echo "</div>";
						echo "<hr />";
					}
				?>
			</div>
			<div id="column_right">
				<h3>Neue Bewertung verfassen</h3>
				<form action="detail.php?<?php echo http_build_query($page->validGET) ?>" method="post">
					<p>
					Eigene Bewertung: 
					<select name="rating" size="1">
						<option>0</option>
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
					</select>
					 (0 = schlecht, 5 = gut)</p>
					<p><textarea name="text" rows="5" maxlength="50" style="width:98%"></textarea></p>
					<div class="hint">maximal 50 Zeichen.</div>
					<p class="buttonrow">
						<input type="reset" name="reset_rating" value="Zur&uuml;cksetzen"> 
						<input type="submit" name="submit_rating" value="Absenden">
					</p>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
