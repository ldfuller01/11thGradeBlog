<?php
$newpost_title = "";
$newpost_author = "Anonymous";
$newpost_content = "";
$newpost_pass = "";
require 'scripts/password_scripts.php';

if (isset($_POST['newpost_title']))
	$newpost_title = $_POST['newpost_title'];

if (isset($_POST['newpost_author']) && !empty($_POST['newpost_author']))
	$newpost_author = $_POST['newpost_author'];

if (isset($_POST['newpost_content']))
	$newpost_content = $_POST['newpost_content'];

if (isset($_POST['newpost_pass'])) {
	$newpost_pass = translate($_POST['newpost_pass']);
	testPassword('newpost_access.php', $newpost_pass, array());
}

$newpost_content = preg_replace('/\n/', "<br/>\n", $newpost_content);

$content = $newpost_content;

$replaced = preg_split('/<\w+.*>/U', $content);
$index = 0;
// $startMatches is important.
$startMatches = array();
preg_match_all('/<\w+.*>/U', $content, $startMatches);

// This replaces all of the element starters (i.e. <p>) with %%%'s
foreach ($startMatches[0] as $startElement) {
	$rplSigns = "";
	for ($i = 0; $i < strlen($startElement); $i++)
		$rplSigns = $rplSigns . "%";
	$replaced[$index] = $replaced[$index] . $rplSigns;
	$index++;
}

$content = implode($replaced);

$replaced = preg_split('/<\/\w+\s*>/U', $content);
$index = 0;
// $endMatches is also important.
$endMatches = array();
preg_match_all('/<\/\w+\s*>/U', $content, $endMatches);

// This replaces all of the element enders (i.e. </p>) with @@@'s
foreach ($endMatches[0] as $endElement) {
	$rplSigns = "";
	for ($i = 0; $i < strlen($endElement); $i++)
		$rplSigns = $rplSigns . "@";
	$replaced[$index] = $replaced[$index] . $rplSigns;
	$index++;
}

/* This $content now contains the regular post, with the following replacements:
 * \n's have been replaced with <br/>\n's
 * Element starters have been replaced with %%%'s
 * Element enders have been replaced with @@@'s
 */
$content = implode($replaced);

// Actual HTML has been flushed out, htmlentity conversion should be fine now.
$content = htmlentities($content);

// And now let's reverse the process of switching out the actual HTML.

// Three or more % signs at a time (<p> is 3 long)
$replaced = preg_split('/%{3,}/', $content);
$index = 0;

// Puts start tags back where they belong.
foreach ($startMatches[0] as $match) {
	$replaced[$index] = $replaced[$index] . $match;
	$index++;
}

$content = implode($replaced);

$replaced = preg_split('/@{4,}/', $content);
$index = 0;

// Puts end tags back where they belong.
foreach ($endMatches[0] as $match) {
	$replaced[$index] = $replaced[$index] . $match;
	$index++;
}

// Final implodation of $replaced.
$content = implode($replaced);

// Final version of $newpost_content.
$newpost_content = $content;

$dir = scandir("posts");
$ordered = array();
// file names should be in the format "post<number>.php"
foreach ($dir as $filename) {
	if (substr($filename, -4) == ".php") {
		$filename = preg_replace('/\D/', "", $filename);
		if ($filename != "")
			array_push($ordered, $filename);
	}
}

// Highest number to lowest number.
rsort($ordered);
// Number of most recent post.
$lastPost = $ordered[0];
// Determine reason for post handling.
// If newpost, this post is one greater than last one.
// If editpost, this is the same as the last one.
if (isset($_POST['post_reason']) && !empty($_POST['post_reason'])) {
	if ($_POST['post_reason'] == "newpost")
		$thisPost = $lastPost + 1;
	elseif ($_POST['post_reason'] == "editpost" && isset($_POST['post']) && !empty($_POST['post']))
		$thisPost = preg_replace('/\D/', "", $_POST['post']);
}
// No post reason? Eh, can't be a security breach if
// they have the access password.
else
	$thisPost = $lastPost + 1;

// Create new post files.
$newpost_file_php = fopen("posts/post$thisPost.php", "w+");
$newpost_file_txt = fopen("posts/post$thisPost.txt", "w+");

// Open template files and read them.
$templateFile_php = fopen("posts/template_html.php", "r");
$template_php = fread($templateFile_php, filesize("posts/template_html.php"));
$templateFile_txt = fopen("posts/template_txt.txt", "r");
$template_txt = fread($templateFile_txt, filesize("posts/template_txt.txt"));

// All HTML post files are exactly the same but with different names.
// Write PHP template into PHP post file.
fwrite($newpost_file_php, $template_php);

// Fill in text template with info.
$newpostText = str_replace(array("%POST TITLE%", "%POST AUTHOR%", "%POST CONTENT%"), array($newpost_title, $newpost_author, $newpost_content), $template_txt);

// Publish data.
fwrite($newpost_file_txt, $newpostText);

// Close files for memory efficiency and good practice.
fclose($newpost_file_php);
fclose($newpost_file_txt);
fclose($templateFile_php);
fclose($templateFile_txt);
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
	</div>
	<script language="javascript">
		setTimeout(goHome, 1000);
		function goHome() {
			window.location = "http://www.ldfuller.com";
		}
	</script>
  </body>
  </html>
