<!DOCTYPE html>
<html lang="de">
<head>
	<title>Firmendatenbank - Hochschule Ravensburg-Weingarten</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="author" content="Michael Wydler und Simon Westphahl">
	<meta name="description" content="Firmendatenbank der Hochschule Ravensburg-Weingarten." />
	<meta name="keywords" content="firmen,datenbank,praktikum" />
	<link rel="stylesheet" href="./style/screen.css" media="screen" />
	<script src="js/jquery-1.5.2.min.js"></script>
	<script src="js/ajax.min.js"></script>
	<script src="js/toggles.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			// Maximal 10 Bewertungen anzeigen.
			if($('.comment_box').length > 10) {
				$('.comment_box:gt(9)').hide();
				$('#toggle_bewertungen').show();
			}
		});
		
		// Zeichen mitzählen, die im Bewertungsformular eingegeben werden.
		function countChars() {
			var len = 50 - $("#comment_text").val().length;
			if(len == 50)
				$("#counter").html("Hinweis: maximal 50 Zeichen.");
			else
				$("#counter").html("noch " + len + " Zeichen übrig.");
		}
	</script>
</head>
<body>
<?php 
	include 'addRating.php';
?>
<div id="container">
	<div id="banner" class="clear">
		<h1>Firmendatenbank</h1>
	</div><!-- BANNER -->
	<div id="filter">
		<div class="main">
			<p class="head"><a href="index.php">Zurück</a></p>
		</div>
	</div><!-- FILTER -->
	<div id="content">
		<?php $firma = $page->firmen->getByPk($page->validGET['fid']) ?>
		<h1><?php echo $firma['name'] ?></h1>
		<div>
			<table class="firmendetails">
				<colgroup>
					<col style="width:25%">
					<col style="width:25%">
					<col style="width:25%">
					<col style="width:25%">
				</colgroup>
				<tbody>
					<tr>
						<td>
							<h3>Anschrift</h3>
							<p>
								<?php echo $firma['strasse'] ?><br />
								<?php echo $firma['plz']." ".$firma['standort'] ?>
							</p>
						</td>
						<td>
							<h3>Kontakt</h3>
							<p>
								<a href="http://<?php echo $firma['url'] ?>"><?php echo $firma['url'] ?></a><br />
								<a href="mailto:<?php echo $firma['email'] ?>"><?php echo $firma['email'] ?></a>
							</p>
						</td>
						<td>
							<?php $schwerpunkte = $page->schwerpunkte->getByFID($page->validGET['fid']) ?>
							<h3>Schwerpunkte</h3>
							<ul>
								<?php
									foreach($schwerpunkte as $schwerpunkt)
									{
										echo "<li>{$schwerpunkt}</li>";
									}
								?>
							</ul>
						</td>
						<td>
							<?php $themen = $page->themen->getByFID($page->validGET['fid']) ?>
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
		</div><!-- CONTENT -->
		<div id="ratings">
			<div id="column_left">
				<h3>Gesamtbewertung</h3>
				<div class="center">
					<div class="rating_bg" style="display:inline-block">
						<div id="rating_all" class="rating_stars" style="width:<?php echo $firma['bew_avg']*20 ?>%"></div>
					</div>
					<span>(<span id="rating_cnt"><?php echo $firma['bew_cnt'] ?></span>)</span>
				</div>
				<br />
				<h3>Einzelbewertungen</h3>
				<?php
					$bewertungen = $page->firmen->getBewertungen($page->validGET['fid']);
				?>
				<div id="comments">
				<?php 
					foreach($bewertungen as $bewertung)
					{
						$rating = $bewertung['bewertung'] * 20;
						echo "<div class=\"comment_box\"><div class=\"rating_bg\">";
						echo "<div class=\"rating_stars\" style=\"width:$rating%\"></div></div>";
						echo "<p>{$bewertung['kommentar']}</p><hr /></div>";
					}
				?>
				</div>
				<div class="toggle_bewertungen"><a id="toggle_bewertungen" href="#ratings">Alle anzeigen</a></div>
			</div><!-- COMLUMN_LEFT -->
			<div id="column_right">
				<div id="done">
					<b>Vielen Dank.<br />Wir haben Ihre Bewertung erhalten.</b>
				</div>
				<div id="form">
					<h3>Neue Bewertung verfassen</h3>
					<form action="detail.php?<?php echo http_build_query($page->validGET) ?>" method="post" id="rating_form">
						<input type="hidden" name="fid" value="<?php echo $page->validGET['fid'] ?>">
						<p>
							Eigene Bewertung: 
							<select name="rating" id="rating" size="1">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
							</select>
							 (1 = schlecht, 5 = gut)
						 </p>
						<p><textarea name="text" id="comment_text" rows="5" maxlength="50" style="width:98%" onkeyup="countChars()"></textarea></p>
						<div id="counter" class="hint">Hinweis: maximal 50 Zeichen.</div>
						<p class="buttonrow">
							<input type="reset" name="reset_rating" value="Zur&uuml;cksetzen">
							<input type="submit" name="submit_rating" id="submit_rating" value="Absenden">
						</p>
					</form>
				</div><!-- FORM -->
			</div><!-- COLUMN_RIGHT -->
		</div><!-- RATINGS -->
	</div><!-- CONTENT -->
</div><!-- CONTAINER -->
</body>
</html>
