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
?>
<div id="debug" class="clear">
	<?php print_r($_GET); ?><br />
	<?php print_r($page->validGET) ?>
</div>
<div id="container">
	<div id="banner" class="clear">
		<h1>Firmendatenbank</h1>
	</div>
	<?php include 'filter.php' ?>
	<div id="content">
		<h1>&Uuml;bersicht</h1>
		<div id="abcd">
			<a href="index.php?<?php echo http_build_query($page->validGET) ?>" class="active">Alle</a><a href="index.php?<?php echo http_build_query($page->validGET) . '&page=0-9' ?>">0-9</a><a href="index.php?<?php echo http_build_query($page->validGET) . '&page=A' ?>">A</a><a href="#">B</a><a href="#">C</a><a href="#">D</a><a href="#">E</a><a href="#">F</a><a href="#">G</a><a href="#">H</a><a href="#">I</a><a href="#">J</a><a href="#">K</a><a href="#">L</a><a href="#">M</a><a href="#">N</a><a href="#">O</a><a href="#">P</a><a href="#">Q</a><a href="#">R</a><a href="#">S</a><a href="#">T</a><a href="#">U</a><a href="#">V</a><a href="#">W</a><a href="#">X</a><a href="#">Y</a><a href="#">Z</a>
		</div>
		<table class="overview">
		<colgroup>
			<col style="width:323px">
			<col style="width:200px">
			<col style="width:100px">
			<col style="width:100px">
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
			foreach($page->getFirmen() as $row)
			{
				if($row['fid']%2)
				{
					echo '<tr class="even">';
				}
				else
				{
					echo '<tr class="odd">';
				}
				echo '<td><a href="detail.php?fid='.$row['fid'].'">'.$row['name'].'</a></td>';
				echo '<td>'.$row['standort'].'</td>';
				echo '<td class="center">';
				echo '    <img src="./img/icon_a.png" alt="Automatisierungstechnik" title="Automatisierungstechnik" />';
				echo '    <img src="./img/icon_i.png" alt="Informationsnetze" title="Informationsnetze" />';
				echo '    <img src="./img/icon_m_bw.png" alt="Multimedia-Engineering" title="Multimedia-Engineering" />';
				echo '</td>';
				echo '<td class="center">';
				echo '    <div class="rating_bg">';
				echo '        <a href="detail.php?fid='.$row['fid'].'#rating"><div class="rating_stars" style="width:'.($row['bew_avg']*20).'%"></div></a>';
				echo '    </div>';
				echo '</td>';
				echo '</tr>';
			}
		?>
	</div>
</div>
</body>
</html>
<?php $page = NULL ?>
