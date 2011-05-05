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
	<?php echo session_id(); ?><br />
	<?php
		include('smarty/libs/Smarty.class.php');
		
		// create object
		$smarty = new Smarty;

		// assign an array of data
		$smarty->assign('names', array('bob','jim','joe','jerry','fred'));

		// assign an associative array of data
		$smarty->assign('users', array(
			array('name' => 'bob', 'phone' => '555-3425'),
			array('name' => 'jim', 'phone' => '555-4364'),
			array('name' => 'joe', 'phone' => '555-3422'),
			array('name' => 'jerry', 'phone' => '555-4973'),
			array('name' => 'fred', 'phone' => '555-3235')
			));

		// display it
		$smarty->display('templates/index.tpl');
	?>
</div>-->
<div id="container">
	<div id="banner" class="clear">
		<h1>Firmendatenbank</h1>
	</div>
	<?php include 'filter.php' ?>
	<div id="content">
		<h1>&Uuml;bersicht</h1>
		<div id="abcd">
			<a href="index.php?<?php echo http_build_query($page->validGET) ?>&page=Alle" class="<?php if($page->validGET['page'] == 'Alle' || $page->validGET['page'] == NULL) echo 'active'; ?>">Alle</a>
			<?php $regexs = array('0-9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'); ?>
			<?php foreach($regexs as $regex) { ?>
				<a href="index.php?<?php echo http_build_query($page->validGET) ?>&page=<?php echo $regex ?>" class="<?php if($page->validGET['page'] == $regex) echo 'active'; ?>"><?php echo $regex ?></a>
			<?php } ?>
		</div>
		<table class="overview">
		<colgroup>
			<col style="width:300px">
			<col style="width:175px">
			<col style="width:123px">
			<col style="width:115px">
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
					echo '<tr class="even">';
				}
				else
				{
					echo '<tr class="odd">';
				}
				echo '<td><a href="detail.php?fid='.$row['fid'].'">'.utf8_encode($row['name']).'</a></td>';
				echo '<td>'.utf8_encode($row['standort']).'</td>';
				echo '<td class="center">';
				$schwerpunkte = $page->schwerpunkte->getByFID($row['fid']);
				if(in_array("Automatisierung", $schwerpunkte))
				{
					echo '<img src="./img/icon_a.png" alt="Automatisierungstechnik" title="Automatisierungstechnik" /> ';
				}
				else
				{
					echo '<img src="./img/icon_a_bw.png" alt="Automatisierungstechnik" title="Automatisierungstechnik" /> ';
				}
				if(in_array("Informationsnetze", $schwerpunkte))
				{
					echo '<img src="./img/icon_i.png" alt="Informationsnetze" title="Informationsnetze" /> ';
				}
				else
				{
					echo '<img src="./img/icon_i_bw.png" alt="Informationsnetze" title="Informationsnetze" /> ';
				}
				if(in_array("Multimedia", $schwerpunkte))
				{
					echo '<img src="./img/icon_m.png" alt="Multimedia" title="Multimedia" />';
				}
				else
				{
					echo '<img src="./img/icon_m_bw.png" alt="Multimedia" title="Multimedia" />';
				}
				echo '</td>';
				echo '<td class="left">';
				echo '    <div class="rating_bg" style="display:inline-block">';
				echo '        <a href="detail.php?fid='.$row['fid'].'#rating"><div class="rating_stars" style="width:'.($row['bew_avg']*20).'%"></div></a>';
				echo '    </div> ('.$row['bew_cnt'].')';
				echo '</td>';
				echo '</tr>';
			}
		?>
	</div>
</div>
</body>
</html>
<?php unset($page) ?>
