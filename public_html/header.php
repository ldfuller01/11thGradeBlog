<?php
$postDir = scandir("posts");
$numbers = array();
foreach ($postDir as $name) {
	if (substr($name, -4) == ".php") {
		$name = preg_replace('/\D/', "", $name);
		if ($name != "")
			array_push($numbers, $name);
	}
}
rsort($numbers);
// $posts must be preserved
$posts = array();
foreach ($numbers as $number) {
	array_push($posts, "post$number.php");
}
?>
<div class="topbar section">
	<ul>
	<li><p class="unnatural" id="homelink"><a class="unnatural" href="http://www.ldfuller.com">Home</a></p></li>
	<li><p class="unnatural" id="header_spacer">—</p></li>
	<li><p class="unnatural" id="recentposts_label">Recent posts:</p></li>
	<?php
	for ($i = 0; $i < 3; $i++) {
		$post = basename($posts[$i], ".php");
		$text = file_get_contents("posts/$post.txt");
		$linkTitle = preg_replace('/\[\/TITLE\]$(.*)/sm', "", preg_replace('/\A(.*)\[TITLE\]/sU', "", $text));
		echo "<li><p class=\"unnatural\"><a href=\"http://www.ldfuller.com/viewpost.php?post=$post\">$linkTitle</a></p></li>\n";
	}
	?>
	</ul>
</div>