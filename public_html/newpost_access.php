<!DOCTYPE html>
  <html>
  <head>
    <title>Minarets IT</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css" type="text/css"/>
	<!-- Keeping this because it could be useful in the future.
	<script language="javascript">
	  function autoResizeDiv()
	  {
	  	document.getElementById('html').style.height = window.innerHeight +'px';
	  }
	  window.onresize = autoResizeDiv;
	  autoResizeDiv();
    </script>
	-->
  </head>
  <body class="mainbody">
  <?php include "header.php"; ?>
  <form action="newpost.php" method="post">
  <table class="section" id="access_section">
    <tr style><td>
      <p id="access_info">Please enter your password to proceed.</p>
	</td></tr>
	<tr><td style="width: 100%; padding-bottom: 35px;" valign="top">
	  <input type="password" class="unnatural" name="newpost_pass" id="access_pass_input">
	</td></tr>
	<tr><td style="width:100%" valign="top">
	  <input type="submit" class="linkbutton" id="access_pass_submit">
	</td></tr>
	<!-- Something to try later: use CSS transitions to make box larger before presenting error label. -->
	<tr style="height: 100px;"><td><p id="access_error_label"><?php
		if (isset($_GET['error']) && !empty($_GET['error'])) {
			$error = $_GET['error'];
		}
		$message = "";
		if ($error == "password_empty") {
			$message = "Password field must not be left blank.";
		}
		elseif ($error == "password_incorrect") {
			$message = "Password incorrect.";
		}
		elseif ($error == "password_error") {
			$message = "Unknown error.";
		}
		echo $message;
		?></p></td></tr>
  </table>
  </form>
  </body>
  </html>
