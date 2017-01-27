<?php
/*$postDir = scandir("posts");
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
}*/
?>
<!DOCTYPE html>
  <html>
  <head>
    <title>Minarets IT</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css" type="text/css"/>
  </head>
  <body class="mainbody">
    <h1 id="blogheader">Welcome to the blog!</h1>
    <?php include "header.php"; ?>
	<div id="mainbodydiv" style="width: 90%; max-width: 90%; margin: 10px auto 10px auto;">
		<div id="blogtablediv" style="width: 55%; max-width: 55%; float: left;">
			<table class="blogtable">
			  <?php
			  foreach ($posts as $post) {
				  echo '<tr class="postrow">';
				  @include "posts/$post";
				  echo '</tr>';
			  }
			  ?>
			</table>
		</div>
		<div class="menu" style="float: right;">
		  <aside class="sidebar">
			<h3 class="sidebearheader">Quick Links</h3>
			<hr>
			<ul class="sidebaroptions">
			  <li id="newpost_li"><a class="linkbutton" id="newpost_button" href="newpost_access.php">New Post</a></li>
			  <li><hr style="width:20%; margin-top: 10px;"></hr></li>
			  <?php
				foreach ($posts as $post) {
					$post = basename($post, ".php");
					$text = file_get_contents("posts/$post.txt");
					$title = preg_replace('/\[\/TITLE\]$(.*)/sm', "", preg_replace('/\A(.*)\[TITLE\]/sU', "", $text));
					echo "<li><p class=\"unnatural\"><a href=\"http://www.ldfuller.com/viewpost.php?post=$post\" target=\"_blank\">$title</a></p></li>\n";
				}
			  ?>
			</ul>
		  </aside>
		</div>
	</div>
  </body>
  </html>
