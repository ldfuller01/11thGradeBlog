<?php
$arr = array("apple" => "banana", "pear" => "tomato");
echo $arr[0];
?>
<!DOCTYPE html>
  <html>
  <script language="javascript">
		function go() {
			var something = document.getElementById('hello');
			something.innerHTML = "ello";
		}
	</script>
	<p id="hello"></p>
	<button type="button" onclick="go();">Click mee!</button>
	<?php echo '<script language="javascript">setTimeout(go, 2000);</script>'; ?>
	<p>A 'quote' is &lt;b&gt;bold&lt;/b&gt;</p>
  </html>