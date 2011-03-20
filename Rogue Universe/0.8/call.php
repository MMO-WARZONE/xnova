<?php

define('INSIDE' , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);


$select = mysql_query("SELECT * FROM `game_planets`");

$page = mysql_fetch_object($select);

$login=$user['username'];


?>

<link rel="stylesheet" type="text/css" href="skins/basic/formate.css">

<html>
<style type="text/css">
<!--
.style1 {
	font-size: medium;
	font-weight: bold;
}
.style2 {color: #00CC00}
-->
</style>
<head>


<script language="JavaScript">
function f(target_url,win_name) {
  var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
  new_win.focus();
}
</script>
</head>

<body >
<div id="theLayer" style="border:none;background-color:transparent;position:absolute;width:20px;left:150;top:50;visibility:visible">

<BR><BR>
<table width="441" align="center" border=1>
</td></tr>
</table>

<link rel="stylesheet" type="text/css" href="skins/ds2/formate.css">
<table width="600" align="center">
<div align="center">
<th colspan="3">
  <p align="center" class="style1">Buy</p>
  <p align="center">&nbsp;</p>
  <p align="center">Send a sms to <b>555-******</b> with the text:<b> prefix 'Your IGN'</b>.</p>
  <p align="center">The current price is <b>£5 / 100 arraki</b>. Game currency is Arraki .</p>
  <p align="center">You will get a confirmation that your account has been updated with 100 Arraki.</p>
  <p>&quot;Your IGN&quot; is your login name you are using IN GAME.</p>
  <p>Be sure you got the spelling right and mind capitol and lower case letters. (CAPITOL and lower case letters). <img src="images/ras.gif" width="20" height="20"></p>
  <p>If anything goes wrong and you dont get the credits you've ordered, please contact an administrator.</p>
  <p>&nbsp;</p>
  <p>Write to <a href="http://your.site.com/messages.php?mode=write&id=1" class="style2">Admin1</a> or <a href="http://your.site.com/messages.php?mode=write&id=3" class="style2">Admin2</a>. </p>
  <p>&nbsp;</p>
  <p>By clicking any of the above names will take you to "send a message" page.</p>
  <p>Dont forget to set a subject related to the problem, hence getting our attention faster.<BR>
    <BR>
    <BR>
    <BR>
          </p></th>

</div>
<tr><td class=subTitle colspan=3><p align="center" class="style1">&nbsp;</p>
      </td></tr><tr>
    <td align=right class=mainTxt width="199">
</tr></td></div>
</body>
</html>



