<div id="filter">
	<div class="main">
	<p class="head">Studienschwerpunkte<a href="index.php?clearfilter=1" style="float:right"><img src="./img/cross.png" /></a></p>
	<p>
		<ul>
		<?php
			foreach($page->schwerpunkte->getAll() as $row)
			{
				$url = "index.php?".http_build_query($page->validGET);
				$name = urlencode(strtolower($row['name']));
				if(isset($page->validGET['schwerpunkte']) && in_array(strtolower($row['name']), $page->validGET['schwerpunkte']))
				{
					$url .= "&removeschwerpunkt=$name";
					$class = "active";
					$img = "./img/checkbox_active.png";
				}
				else
				{
					$url .= "&addschwerpunkt=$name";
					$class = "";
					$img = "./img/checkbox.png";
				}
				echo "<li class=\"$class\"><a href=\"$url\"><img src=\"$img\" class=\"checkbox\"/> {$row['name']} ({$row['count']})</a></li>";
			}
		?>
		</ul>
	</p>
	</div>
	<div class="main">
	<p class="head">Bewertung<a href="index.php?clearfilter=1" style="float:right"><img src="./img/cross.png" /></a></p>
		<ul>
		<?php
			for($i=4; $i >= 0; $i--)
			{
				$url = "index.php?".http_build_query($page->validGET)."&rating=".$i;
				if(isset($page->validGET['rating']) && $page->validGET['rating'] == $i)
				{
					$class = "active";
				}
				else
				{
					$class = "";
				}
				
				echo "<li class=\"$class\"><a href=\"$url\">";
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
				$query = "SELECT * FROM firmen WHERE bew_avg >= $i";
				$result = mysql_query($query) or die(mysql_error());
				$num_rows = mysql_num_rows($result); 
				echo "  & mehr ($num_rows)</a></li>";
			}
		?>
		</ul>
	</div>
	<div class="main">
	<p class="head">Themengebiete<a href="index.php?clearfilter=1" style="float:right"><img src="./img/cross.png" /></a></p>
	<p>
		<ul>
		<?php
			if(isset($page->validGET['showallthemen']) && $page->validGET['showallthemen'] == 1)
			{
				$themen = $page->themen->getAll();
			}
			else
			{
				$themen = $page->themen->getTop10();
			}
			foreach($themen as $thema)
			{
				$url = "index.php?".http_build_query($page->validGET);
				$name = urlencode(strtolower($thema['name']));
				if(isset($page->validGET['themen']) && in_array(strtolower($thema['name']), $page->validGET['themen']))
				{
					$url .= "&removethema=$name";
					$class = "active";
					$img = "./img/checkbox_active.png";
				}
				else
				{
					$url .= "&addthema=$name";
					$class = "";
					$img = "./img/checkbox.png";
				}
				echo "<li class=\"$class\"><a href=\"$url\"><img src=\"$img\" class=\"checkbox\"/> {$thema['name']} ({$thema['count']})</a></li>";
			}
		?>
		</ul>
		<?php
			if(isset($page->validGET['showallthemen']) && $page->validGET['showallthemen'] == 1)
			{
				$url = "index.php?".http_build_query($page->validGET)."&showallthemen=0";
				echo "<div class=\"hint\"><a href=\"$url\">Top10 anzeigen</a></div>";
			}
			else
			{
				$url = "index.php?".http_build_query($page->validGET)."&showallthemen=1";
				$cnt = count($page->themen->getAll());
				echo "<div class=\"hint\"><a href=\"$url\">Alle anzeigen ({$cnt})</a></div>";
			}
		?>
	</p>
	</div>
</div>
