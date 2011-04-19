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
	</p>
	</div>
	<p class="buttonrow">
		<input type="reset" name="aktion" value="Zur&uuml;cksetzen"> 
		<input type="submit" name="aktion" value="Filter">
	</p>
	</form>
</div>
