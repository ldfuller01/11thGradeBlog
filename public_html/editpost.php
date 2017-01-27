<?php

if (!isset($_POST['post']) || empty($_POST['post'])) {
	header("Location: http://www.ldfuller.com/editpost_access.php");
	exit();
}
else
	$postName = $_POST['post'];

$passInput = $_POST['editpost_pass'];
require 'scripts/password_scripts.php';
testPassword('editpost_access.php', $passInput, array("post" => $postName));

$text = file_get_contents("posts/".$postName.".txt");
$title = preg_replace('/\[\/TITLE\]$(.*)/sm', "", preg_replace('/\A(.*)\[TITLE\]/sU', "", $text));
$author = preg_replace('/\[\/AUTHOR\]$(.*)/sm', "", preg_replace('/\A(.*)\[AUTHOR\]/sU', "", $text));
$content = html_entity_decode(str_replace("<br/>", "", preg_replace('/\[\/CONTENT\]$(.*)/sm', "", preg_replace('/\A(.*)\[CONTENT\]/sU', "", $text))));

?>
<!DOCTYPE html>
  <html>
  <head>
    <title>Minarets IT</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css" type="text/css"/>
	<script language="javascript">
		function formSubmit() {
			var newpost_title = document.getElementById('newpost_title').value,
			newpost_author = document.getElementById('newpost_author').value,
			newpost_content = document.getElementById('newpost_content').value,
			newpost_form = document.getElementById('newpost_form');
			
			// regex says, "from beginning to end of entire string, check for any number of whitespaces"
			if (!newpost_title || (newpost_title.search(/^\s+$/) > -1)
				|| !newpost_content || (newpost_content.search(/^\s+$/) > -1)) {
				alert("Title and post content cannot be left blank.");
				return;
			}
			
			if (newpost_author.search(/^\s+$/) > -1)
				document.getElementById('newpost_author').value = "";
			
			// Nothing else can be wrong at this point, go ahead and submit.
			newpost_form.submit();
			
			/* TO-DO:
			 * Before sending off the form data, make sure it does not have too many in a row of the
			 * escape characters that are used in newpost_handle, which would be
			 * 3 % signs in a row, and 4 @ signs in a row.
			 * THESE ARE DANGEROUS!!
			 * Remove them by shortening them to two % signs and 3 @ signs, respectively, before
			 * forwarding to newpost_handle.
			 */
			
		}
	</script>
  </head>
  <body class="mainbody">
  <?php include "header.php"; ?>
  <div id="mainbodydiv" style="width: 90%; max-width: 90%; margin: 20px auto 10px auto;">
	  <form action="newpost_handle.php" method="post" id="newpost_form">
		<table class="blogtable">
			<tr>
			  <td class="blogpostexample">
				<article id="newpost_article">
				  <table class="postheader">
					<tr>
					  <td class="postinfotd">
						<div class="postinfodiv">
						  <input id="newpost_title" name="newpost_title" type="text" class="posttitle" placeholder="Title" value="<?php echo $title; ?>">
						  <br><h3 class="postauthor newpost_author_label">by </h3><input name="newpost_author" id="newpost_author" class="postauthor newpost_author_label" placeholder="Author" value="<?php echo $author; ?>">
						</div>
					  </td>
					  <td id="newpost_col_buffer"></td>
					  <td class="postbuttonstd" valign="bottom">
						<div class="editbuttons">
						  <button type="button" class="linkbutton" id="newpost_submit" onclick="formSubmit()">Submit Post</button>
						</div>
					  </td>
					</tr>
					<tr><td colspan="3"><hr/></td></tr>
					<tr class="newpost_row_buffer">
					  <td class="postcontenttd" colspan="3" valign="top">
						<div class="postcontent">
						  <textarea name="newpost_content" id="newpost_content" placeholder="Begin typing here..."><?php echo $content; ?></textarea>
						</div>
					  </td>
					</tr>
					<tr id="newpost_bottom_row"></tr>
				  </table>
				</article>
			  </td>
			</tr>
		</table>
		<input type="text" name="newpost_pass" style="visibility: hidden; float: left;" value="<?php echo encrypt($passInput); ?>">
		<input type="text" name="post_reason" style="visibility: hidden; float: left;" value="editpost">
		<input type="text" name="post" style="visibility: hidden; float: left;" value="<?php echo $postName; ?>">
	  </form>
  </div>
  </body>
  </html>
