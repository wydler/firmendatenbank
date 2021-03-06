<div id="filter">
	<div class="main">
		<p class="head">Studienschwerpunkte<span id="toggle_schwerpunkte" class="fl_right"><img src="./img/dots_white_left.png" alt="Ein-/Ausblenden" /></span></p>
		<div id="filter_schwerpunkte">
			<ul>
			<?php
				// Alle Schwerpunkte ausgeben.
				foreach($page->schwerpunkte->getAll() as $row)
				{
					$url = "index.php?".http_build_query($page->validGET);
					$name = urlencode(strtolower($row['name']));
					if(isset($page->validGET['schwerpunkte']) && in_array(strtolower($row['name']), $page->validGET['schwerpunkte']))
					{
						$url .= "&amp;removeschwerpunkt=$name";
						$class = "active";
						$img = "./img/checkbox_active.png";
					}
					else
					{
						$url .= "&amp;addschwerpunkt=$name";
						$class = "";
						$img = "./img/checkbox.png";
					}
					echo "<li class=\"$class\"><a href=\"$url\"><img src=\"$img\" class=\"checkbox\" alt=\"\"/> {$row['name']}</a></li>";
				}
			?>
			</ul>
		</div>
	</div>
	<div class="main">
		<p class="head">Bewertung<span id="toggle_rating" class="fl_right"><img src="./img/dots_white_left.png" alt="Ein-/Ausblenden" /></span></p>
		<div id="filter_rating">
			<ul>
			<?php
				// Filter für Bewertungsdurchschnitt.
				for($i=4; $i >= 0; $i--)
				{
					$url = "index.php?".http_build_query($page->validGET)."&amp;rating=".$i;
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
							echo '<img src="./img/star.png" alt="*" />';
						}
						else
						{
							echo '<img src="./img/star_bw.png" alt="" />';
						}
					}
					echo "  & mehr</a></li>";
				}
			?>
			</ul>
		</div>
	</div>
	<div class="main">
		<p class="head">Themengebiete<span id="toggle_themen" class="fl_right"><img src="./img/dots_white_left.png" alt="Ein-/Ausblenden" /></span></p>
		<div id="filter_themen">
			<ul>
			<?php
				// Themen ausgeben, nur Top10 oder alle.
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
						$url .= "&amp;removethema=$name";
						$class = "active";
						$img = "./img/checkbox_active.png";
					}
					else
					{
						$url .= "&amp;addthema=$name";
						$class = "";
						$img = "./img/checkbox.png";
					}
					echo "<li class=\"$class\"><a href=\"$url\"><img src=\"$img\" class=\"checkbox\" alt=\"\"/> {$thema['name']}</a></li>";
				}
			?>
			</ul>
			<?php
				if(isset($page->validGET['showallthemen']) && $page->validGET['showallthemen'] == 1)
				{
					$url = "index.php?".http_build_query($page->validGET)."&amp;showallthemen=0";
					echo "<div class=\"hint\"><a href=\"$url\">Top10 anzeigen</a></div>";
				}
				else
				{
					$url = "index.php?".http_build_query($page->validGET)."&amp;showallthemen=1";
					$cnt = count($page->themen->getAll());
					echo "<div class=\"hint\"><a href=\"$url\">Alle anzeigen ({$cnt})</a></div>";
				}
			?>
		</div>
	</div>
	<div class="right">
		<a href="index.php?clearfilter=1"><img src="./img/arrow_undo.png" alt="Zurücksetzten" /></a>
	</div>
</div><!-- FILTER -->
