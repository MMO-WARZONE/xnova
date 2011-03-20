<?php
require('connect.php');
require('login.php');
require('reactie.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Forum Asschensukar</title>
<!--<script type="text/javascript" src="js/login.js"></script>-->
<LINK HREF="css/basis.css" REL="stylesheet" TYPE="text/css">
<LINK HREF="css/stylesheet.css" REL="stylesheet" TYPE="text/css">
<script language="javascript" src="js/time.js"></script>
</head>

<body>
<?php
	function pretty_number($n, $floor = true) {
		if ($floor) {
			$n = floor($n);
		}
		return number_format($n, 0, ",", ".");
	}
?>
<?php
session_start();
?>
<table width="800" border="0.25" align="center" bgcolor="#333333" cellpadding="0" cellspacing="0" bordercolor="black" >
<!--  <tr>	
    <td id="logorow" align="center"><div id="logo-left"><div id="logo-right">
		<a href="./index.php"></a>
	</div></div></td>
  </tr>-->
  <tr>
  	<td width="800" height="99" align="center">
    <h1><strong>Server news</strong></h1>
    <br />
    <?php
    $res = mysql_query("SELECT config_name,config_value FROM beta_config WHERE config_name='OverviewNewsText'") or die(mysql_error());
    $row = mysql_fetch_assoc($res);
    echo $row['config_value'];
    ?>
    <br />
    </td>
  </tr>
  <tr>
    <td height="30" align="center" class="navrow">
    <?php
	if(!isset($_SESSION['suser'])) {
	?>
	<form action="login.php" method="post">
	Username: <input type="text" name="naam" size="15" class="post">&nbsp;
	Wachtwoord: <input type="password" name="wacht" size="15" class="post">&nbsp;
	<input type="checkbox" name="memory" value="1"> Onthouden (cookie)&nbsp;
	<input type="submit" name="login" value="log in" class="btnmain">
	</form>
	<?php
	} else {
	?>
	Je bent ingelogd als <b><?php $naam = $_SESSION['suser']; echo $naam; ?></b>,
	<a href="logout.php?user='<?php $naam = $_SESSION['suser']; echo $naam; ?>'">uitloggen</a><br />
	<?php
	}
	?>
    </td>
  </tr>
<!--  <tr>
   <td>
   <div align="right" id="time"></div>
   </td>
  </tr>-->
  <tr>
    <td height="204"><!-- InstanceBeginEditable name="Inhoud" -->
	<?php
	if(!isset($_SESSION['suser'])) {
	?>
    Je moet ingelogd zijn voor deze actie
	<?php
	} else {
	?>
    <form action="reactie.php" method="post">
	Reactie <br />
    <textarea name="reactie" rows="5"></textarea><br />
	<input type="submit" name="postreactie" value="Post">
    <input type="reset" value="reset">
	</form>
	<?php
	}
	?>
	<!-- InstanceEndEditable --></td>
  </tr>
  <tr>
    <td align="center">Designed by Warsaalk for <a href="http://www.asschensukar.nl">www.asschensukar.nl</a></td>
  </tr>
  <tr>
  <td>&nbsp;
  </td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
