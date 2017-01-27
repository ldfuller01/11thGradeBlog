<?php

if (!isset($_GET['post']) || empty($_GET['post'])) {
	header("Location: http://www.ldfuller.com");
	exit();
}
else
	$postName = $_GET['post'];
?>
<!DOCTYPE html>
  <html>
  <head>
    <title>Minarets IT</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css" type="text/css"/>
  </head>
  <body class="mainbody">
  <?php include "header.php"; ?>
    <div id="mainbodydiv" style="width: 90%; max-width: 90%; margin: 20px auto 10px auto;">
		<div id="blogtablediv">
			<table class="blogtable">
			  <?php
				echo '<tr class="postrow">';
				@include "posts/$postName.php";
				echo '</tr>';
			  ?>
			</table>
		</div>
	</div>
  </body>
  </html>
