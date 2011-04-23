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
	<script src="js/ajax.js"></script>
</head>
<body>
<?php 
	include 'index.inc.php';
	$page = new Page();

	if(array_key_exists("fid", $_POST))
	{
		$result = $page->addBewertung();
		echo $result;
		
		print_r($_POST);
	}
?>
</body>
</html>
