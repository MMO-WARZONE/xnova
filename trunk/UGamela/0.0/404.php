<?php
  header("Expires: " . date("D, j M Y H:i:s", time() + (86400 * 30)) . " UTC");
  header("Cache-Control: Public");
  header("Pragma: Public");
?>
<html>
<title>Error 404</title>
<body bgcolor="#525A73">
 <center>
  <img src="/images/404.gif">
 </center>
</body>
</html>