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
	<script src="js/toggles.min.js"></script>
</head>
<body>
<?php 
	include 'classes/page.class.php';
	// Page-Objekt erzeugen.
	$page = new Page();
	
	// Filtereinstellungen löschen, wenn GET-Parameter gesetzt ist.
	if(isset($_GET['clearfilter']) && $_GET['clearfilter'] == 1)
	{
		$page->clearFilter();
	}
?>
<div id="container">
	<div id="banner" class="clear">
		<h1>Firmendatenbank</h1>
	</div><!-- BANNER -->
	<?php include 'filter.php' ?>
	<div id="content">
		<h1>&Uuml;bersicht</h1>
		<div id="abcd">
			<?php
				// Link mit GET-Parameter generieren.
				$querystring = http_build_query($page->validGET);
				if(!isset($page->validGET['page']) || ($page->validGET['page'] == "Alle" || $page->validGET['page'] == NULL))
				{
					$active = "active";
				}
				else
				{
					$active = "";
				}
				echo "<a href=\"index.php?$querystring&amp;page=Alle\" class=\"$active\">Alle</a> ";
				
				$regexs = array(
					'0-9'=>'0-9', 'A'=>'AÄ', 'B'=>'B', 'C'=>'C', 'D'=>'D', 
					'E'=>'E', 'F'=>'F', 'G'=>'G', 'H'=>'H', 'I'=>'I',
					'J'=>'J', 'K'=>'K', 'L'=>'L', 'M'=>'M', 'N'=>'N', 
					'O'=>'OÖ', 'P'=>'P', 'Q'=>'Q', 'R'=>'R', 'S'=>'S', 
					'T'=>'T', 'U'=>'UÜ', 'V'=>'V', 'W'=>'W', 'X'=>'X', 
					'Y'=>'Y', 'Z'=>'Z'
				);
			
				foreach($regexs as $name=>$regex)
				{
					$querystring = http_build_query($page->validGET);
					if(isset($page->validGET['page']) && $page->validGET['page'] == $regex)
					{
						$active = "active";
					}
					else
					{
						$active = "";
					}
					echo "<a href=\"index.php?$querystring&amp;page=$regex\" class=\"$active\">$name</a> ";
				}
			?>
		</div>
		<table class="overview">
			<colgroup>
				<col style="width:300px">
				<col style="width:165px">
				<col style="width:123px">
				<col style="width:125px">
			</colgroup>
			<thead>
				<tr>
				<td>Name</td>
				<td>Ort</td>
				<td>Schwerpunkte</td>
				<td>Bewertung</td>
				</tr>
			</thead>
			<tbody>
			<?php
				$counter = 0;
			
				// Firmen für den Filter ausgeben.
				foreach($page->firmen->getByFilter($page->validGET) as $row)
				{
					// Unterschiedliche Tabellenhintergrundfarben setzten.
					$counter += 1;
					if($counter%2) { echo "<tr class=\"even\">"; }
					else { echo "<tr class=\"odd\">"; }
				
					echo "<td><a href=\"detail.php?fid={$row['fid']}\">{$row['name']}</a></td>";
					echo "<td>{$row['standort']}</td>";
					echo "<td class=\"center\">";
				
					// Schwerpunkte zur Firma suchen.
					$schwerpunkte = $page->schwerpunkte->getByFID($row['fid']);
					$map = array(
						'Automatisierung'=>'icon_a', 
						'Informationsnetze'=>'icon_i',
						'Multimedia'=>'icon_m'
					);
				
					// Schwerpunkt-Icons ausgeben.
					foreach($map as $schwerpunkt=>$icon)
					{
						if(in_array($schwerpunkt, $schwerpunkte))
						{
							echo "<img src=\"./img/$icon.png\" alt=\"$schwerpunkt\" title=\"$schwerpunkt\" /> ";
						}
						else
						{
							echo "<img src=\"./img/{$icon}_bw.png\" alt=\"$schwerpunkt\" title=\"$schwerpunkt\" /> ";
						}
					}
					echo "</td>";
					// Bewertungsdurchschnitt und -anzahl ausgeben.
					echo "<td class=\"left\"><div class=\"rating_bg\" style=\"display:inline-block\">";
					echo "<a href=\"detail.php?fid={$row['fid']}#ratings\"><div class=\"rating_stars\" style=\"width:".($row['bew_avg']*20)."%\"></div></a>";
					echo "</div> ({$row['bew_cnt']})</td></tr>";
				}
			?>
			</tbody>
		</table>
		<br />
		<?php
			// Wenn Firmen ausgeben sind, soll der Exportieren-Link ausgegeben werden.
			if($counter != 0)
			{
				echo "<p class=\"xmlexport\"><a href=\"xmlexport.php\">Liste als XML exportieren</a></p>";
			}
		?>
	</div><!-- CONTENT -->
</div><!-- CONTAINER -->
</body>
</html>
<?php unset($page) ?>
