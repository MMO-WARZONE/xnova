<?php
  header("Expires: " . date("D, j M Y H:i:s", time() + (86400 * 30)) . " UTC");
  header("Cache-Control: Public");
  header("Pragma: Public");
?>
<html>
<title>Error 500</title>
<body bgcolor="#D6BA8E">
 <center>
  <img src="/images/500.gif">
 </center>
</body>
</html>