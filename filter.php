<div id="filter">
	<div class="main">
	<p class="head">Studienschwerpunkte</p>
	<p>
		<ul>
		<?php
			foreach($page->schwerpunkte->getAll() as $row)
			{
				$url = "index.php?".http_build_query($page->validGET);
				$name = urlencode(strtolower($row['name']));
				if(in_array(strtolower($row['name']), $page->validGET['schwerpunkte']))
				{
					$url .= "&removeschwerpunkt=$name";
					$class = "active";
				}
				else
				{
					$url .= "&addschwerpunkt=$name";
					$class = "";
				}
				echo "<li class=\"$class\"><a href=\"$url\">{$row['name']} ({$row['count']})</a></li>";
			}
		?>
		</ul>
	</p>
	</div>
	<div class="main">
	<p class="head">Bewertung</p>
		<ul>
		<?php
			for($i=4; $i >= 0; $i--)
			{
				$url = "index.php?".http_build_query($page->validGET)."&rating=".$i;
				if($page->validGET['rating'] == $i)
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
				echo '  & mehr (2)</a></li>';
			}
		?>
		</ul>
	</div>
	<div class="main">
	<p class="head">Themengebiete</p>
	<p>
		<ul>
		<?php
			if($page->validGET['showallthemen'] == 0)
			{
				$themen = $page->themen->getTop10(2);
			}
			else
			{
				$themen = $page->themen->getAll();
			}
			foreach($themen as $thema)
			{
				$url = "index.php?".http_build_query($page->validGET);
				$name = urlencode(strtolower($thema['name']));
				if(in_array(strtolower($thema['name']), $page->validGET['themen']))
				{
					$url .= "&removethema=$name";
					$class = "active";
				}
				else
				{
					$url .= "&addthema=$name";
					$class = "";
				}
				echo "<li class=\"$class\"><a href=\"$url\">{$thema['name']} ({$thema['count']})</a></li>";
			}
		?>
		</ul>
		<?php
			if($page->validGET['showallthemen'] == 1)
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
	<a href="index.php?clearfilter=1">Reset</a>
</div>
