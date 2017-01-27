<?php
$postName = "";
if (isset($_POST['post']))
	$postName = $_POST['post'];

require 'scripts/password_scripts.php';
if (isset($_POST['delpost_pass']))
	$delpost_pass = $_POST['delpost_pass'];
testPassword('delpost_access.php', $delpost_pass, array("post" => $postName));

unlink(realpath("posts/$postName.php")) or die("Could not delete $postName.php file!");
unlink(realpath("posts/$postName.txt")) or die("Could not delete $postName.txt file!");
?>

<!DOCTYPE html>
  <html>
  <head>
    <title>Posting...</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css" type="text/css"/>
  </head>
  <body class="mainbody">
    <div class="section" style="height: 350px;">
		<p style="font-size: 300%; margin-left: 5px;">Please wait...</p>
		<!--<div style="height: 40px; width: 40px; background: blue;" onclick="goHome();"></div>-->
	</div>
	<script language="javascript">
		setTimeout(goHome, 1000);
		function goHome() {
			window.location = "http://www.ldfuller.com";
		}
	</script>
  </body>
  </html>
