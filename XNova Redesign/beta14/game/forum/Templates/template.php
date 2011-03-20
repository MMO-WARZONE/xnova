<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Naamloos document</title>
<script type="text/javascript" src="js/login.js">
<!--function login() {
require("connect.php");
session_start();

if(type == 'yes') {
if(isset($_POST['login'])) {
  if(trim($_POST['naam']) <> "" && trim($_POST['wacht']) <> "") {
    $naam  = $_POST['naam'];
    $wacht = md5($_POST['wacht']);
    $res = mysql_query("SELECT id, pass, level FROM users where name='".$naam."'") or die(mysql_error());

    if(mysql_num_rows($res) > 0) {
      $row = mysql_fetch_assoc($res);
      if(!strcmp($wacht, $row['pass'])) {
          if(isset($_POST['memory'])) {
          setcookie("login_cookie", $row['id'].";".$row['pass'], time()+3600*24*31*2, "/");
          $ip = $_SERVER['REMOTE_ADDR'];
          mysql_query("UPDATE users SET last_ip='".$ip."' WHERE id=".$row['id']) or die(mysql_error());
        }

        $_SESSION['suser']    = $naam;         // gebruikersnaam van ingelogd persoon
        $_SESSION['slevel']   = $row['level']; // bijbehorende gebruikersniveau
        $_SESSION['stime']    = time();        // de huidige tijd
        $_SESSION['smaxidle'] = 60 * 60;       // het aantal seconden inactiviteit
      } else {
        $_SESSION = array();
        session_destroy();
      }
      unset($row);
      mysql_free_result($res);
    }
    header("Location: voorbeeld.php");
  }
}
}
}-->
</script>

</head>

<body background="../img/body.gif">
<table width="800" border="1" align="center" bgcolor="#666666" noborder>
  <tr>
  	<td width="800" height="99"></td>
  </tr>
  <tr>
    <td height="30" align="left">
    <?php
	if(!isset($_SESSION['suser'])) {
	?>
	<form onSubmit="login('yes');" method="post">
	Username: <input type="text" name="naam" size="15">&nbsp;
	Wachtwoord: <input type="password" name="wacht" size="15">&nbsp;
	<input type="checkbox" name="memory" value="1"> Onthouden (cookie)&nbsp;
	<input type="submit" name="login" value="log in">
	</form>
	<?php
	} else {
	?>
	Je bent ingelogd als <b><?= $_SESSION['suser'] ?></b>,
	<a href="logout.php" target="inhoud">uitloggen</a><br />
	<?php
	}
	?>
    </td>
  </tr>
  <tr>
    <td height="204"><!-- TemplateBeginEditable name="Inhoud" --><!-- TemplateEndEditable --></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>

