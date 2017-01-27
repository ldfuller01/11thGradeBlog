<?php
$text = file_get_contents("posts/".basename(__FILE__, ".php").".txt");
$title = preg_replace('/\[\/TITLE\]$(.*)/sm', "", preg_replace('/\A(.*)\[TITLE\]/sU', "", $text));
$author = preg_replace('/\[\/AUTHOR\]$(.*)/sm', "", preg_replace('/\A(.*)\[AUTHOR\]/sU', "", $text));
$content = preg_replace('/\[\/CONTENT\]$(.*)/sm', "", preg_replace('/\A(.*)\[CONTENT\]/sU', "", $text));
?>
<td class="blogpost" valign="top">
<article>
<table class="postheader">
<tr>
<td class="postinfotd">
<div class="postinfodiv">
<h2 class="posttitle"><?php echo $title; ?></h2>
<h3 class="postauthor">by <span class="authorname"><?php echo $author; ?></span></h3>
</div>
</td>
<td class="buffer"></td>
<td class="postbuttonstd" valign="bottom">
<div class="editbuttons">
<p class="delete"><a href="delpost_access.php?post=<?php echo basename(__FILE__, ".php"); ?>">Delete</a></p>
<p class="edit"><a href="editpost_access.php?post=<?php echo basename(__FILE__, ".php"); ?>">Edit</a></p>
</div>
</td>
</tr>
<tr><td colspan="3"><hr/></td></tr>
<tr><td colspan="3"><div class="postcontent"><?php echo $content; ?></div></td></tr>
</table>
</article>
</td>
<td class="buffer"></td>