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
	<script type="text/javascript">
		$(document).ready(function() {
			$('#toggle_schwerpunkte').click(function() {
				var showOrHide = $('#filter_schwerpunkte').css('display');
				if(showOrHide == 'none') {
					$('#filter_schwerpunkte').show('fast');
					$('#toggle_schwerpunkte > img').replaceWith('\<img src=\".\/img\/dots_white_left.png\" alt=\"Clear\" \/\>');
				} else {
					$('#toggle_schwerpunkte > img').replaceWith('\<img src=\".\/img\/dots_white_down.png\" alt=\"Clear\" \/\>');
					$('#filter_schwerpunkte').hide('fast');
				}
			});
			$('#toggle_rating').click(function() {
				var showOrHide = $('#filter_rating').css('display');
				if(showOrHide == 'none') {
					$('#filter_rating').show('fast');
					$('#toggle_rating > img').replaceWith('\<img src=\".\/img\/dots_white_left.png\" alt=\"Clear\" \/\>');
				} else {
					$('#toggle_rating > img').replaceWith('\<img src=\".\/img\/dots_white_down.png\" alt=\"Clear\" \/\>');
					$('#filter_rating').hide('fast');
				}
			});
			$('#toggle_themen').click(function() {
				var showOrHide = $('#filter_themen').css('display');
				if(showOrHide == 'none') {
					$('#filter_themen').show('fast');
					$('#toggle_themen > img').replaceWith('\<img src=\".\/img\/dots_white_left.png\" alt=\"Clear\" \/\>');
				} else {
					$('#toggle_themen > img').replaceWith('\<img src=\".\/img\/dots_white_down.png\" alt=\"Clear\" \/\>');
					$('#filter_themen').hide('fast');
				}
			});
		});
	</script>
</head>
<body>
<?php 
	include 'index.inc.php';
	$page = new Page();
	
	if(isset($_GET['clearfilter']) && $_GET['clearfilter'] == 1)
	{
		$page->clearFilter();
	}
?>
<!--<div id="debug" class="clear">
	<?php print_r($_GET); ?><br />
	<?php print_r($page->validGET) ?><br />
	<?php print_r($_SESSION) ?><br />
</div>-->
<div id="container">
	<div id="banner" class="clear">
		<h1>Firmendatenbank</h1>
	</div>
	<?php include 'filter.php' ?>
	<div id="content">
		<h1>&Uuml;bersicht</h1>
		<div id="abcd">
			<a href="index.php?<?php echo http_build_query($page->validGET) ?>&amp;page=Alle" class="<?php if($page->validGET['page'] == 'Alle' || $page->validGET['page'] == NULL) echo 'active'; ?>">Alle</a>
			<?php $regexs = array('0-9'=>'0-9', 'A'=>'AÄ', 'B'=>'B', 'C'=>'C', 'D'=>'D', 'E'=>'E', 'F'=>'F', 'G'=>'G', 'H'=>'H', 'I'=>'I', 'J'=>'J', 'K'=>'K', 'L'=>'L', 'M'=>'M', 'N'=>'N', 'O'=>'OÖ', 'P'=>'P', 'Q'=>'Q', 'R'=>'R', 'S'=>'S', 'T'=>'T', 'U'=>'UÜ', 'V'=>'V', 'W'=>'W', 'X'=>'X', 'Y'=>'Y', 'Z'=>'Z'); ?>
			<?php foreach($regexs as $name=>$regex) { ?>
				<a href="index.php?<?php echo http_build_query($page->validGET) ?>&amp;page=<?php echo $regex ?>" class="<?php if($page->validGET['page'] == $regex) echo 'active'; ?>"><?php echo $name ?></a>
			<?php } ?>
		</div>
		<table class="overview">
		<colgroup>
			<col style="width:290px">
			<col style="width:175px">
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
			
			foreach($page->firmen->getByFilter($page->validGET) as $row)
			{
				$counter += 1;
				if($counter%2)
				{
					echo "<tr class=\"even\">";
				}
				else
				{
					echo "<tr class=\"odd\">";
				}
				echo "<td><a href=\"detail.php?fid={$row['fid']}\">".$row['name']."</a></td>";
				echo "<td>".$row['standort']."</td>";
				echo "<td class=\"center\">";
				
				$schwerpunkte = $page->schwerpunkte->getByFID($row['fid']);
				if(in_array("Automatisierung", $schwerpunkte))
				{
					echo "<img src=\"./img/icon_a.png\" alt=\"Automatisierungstechnik\" title=\"Automatisierungstechnik\" /> ";
				}
				else
				{
					echo "<img src=\"./img/icon_a_bw.png\" alt=\"Automatisierungstechnik\" title=\"Automatisierungstechnik\" /> ";
				}
				if(in_array("Informationsnetze", $schwerpunkte))
				{
					echo "<img src=\"./img/icon_i.png\" alt=\"Informationsnetze\" title=\"Informationsnetze\" /> ";
				}
				else
				{
					echo "<img src=\"./img/icon_i_bw.png\" alt=\"Informationsnetze\" title=\"Informationsnetze\" /> ";
				}
				if(in_array("Multimedia", $schwerpunkte))
				{
					echo "<img src=\"./img/icon_m.png\" alt=\"Multimedia\" title=\"Multimedia\" />";
				}
				else
				{
					echo "<img src=\"./img/icon_m_bw.png\" alt=\"Multimedia\" title=\"Multimedia\" />";
				}
				echo "</td>";
				echo "<td class=\"left\">";
				echo "    <div class=\"rating_bg\" style=\"display:inline-block\">";
				echo "        <a href=\"detail.php?fid=".$row['fid']."#ratings\"><div class=\"rating_stars\" style=\"width:".($row['bew_avg']*20)."%\"></div></a>";
				echo "    </div> ({$row['bew_cnt']})";
				echo "</td>";
				echo "</tr>";
			}
		?>
		</tbody>
		</table>
		<br />
		<p style="text-align:right;font-size:0.8em"><a href="xmlexport.php">Liste als XML exportieren</a></p>
	</div>
</div>
</body>
</html>
<?php unset($page) ?>
