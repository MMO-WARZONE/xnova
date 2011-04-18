<div id='leftmenu'>
<script language="JavaScript">
function f(target_url,win_name) {
  var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
  new_win.focus();
}
parent.frames['Hauptframe'].location.replace("overview.php");
</script>
<body  class="style" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
<center>
<div id='menu'>
<br>
<table width="130" cellspacing="0" cellpadding="0">
<tr>
	<td style="border-top: 1px #545454 solid"><div><center>{servername}<br><a href="changelog.php" target="{mf}"><font color="red">{XNovaRelease}</font></a><center></div></td>
</tr><tr>
	<td background="{dpath}img/bg1.gif"><center>{admin}</center></td>
</tr><tr>
	<td><div><a href="overview.php" accesskey="v" target="{mf}">{adm_over}</a></div></td>
</tr><tr>
	<td background="{dpath}img/bg1.gif"><center>{player}</center></td>
</tr><tr>
	<td><div><a href="userlist.php" accesskey="a" target="{mf}">{adm_plrlst}</a></div></td>
</tr><tr>
	<td><div><a href="paneladmina.php" accesskey="k" target="{mf}">{adm_plrsch}</a></div></td>
</tr><tr>
	<td><div><a href="mats.php" accesskey="k" target="{mf}">Spieler Werte &auml;ndern</a></div></td>
</tr><tr>
	<td><div><a href="planetlist.php" accesskey="k" target="{mf}">Planeten bearbeiten</a></div></td>
</tr><tr>
      <td><div><a href="add_pts.php" accesskey="k" target="{mf}">Offizier Punkte &auml;ndern</a></div></td>
</tr><tr>
	<td style="background-color:#FFFFFF" height="1px"></td>
</tr><tr>
	<td><div><a href="planetlist.php" accesskey="1" target="{mf}">{adm_pltlst}</a></div></td>
</tr><tr>
	<td><div><a href="activeplanet.php" accesskey="k" target="{mf}">{adm_actplt}</a></div></td>
</tr><tr>
	<td style="background-color:#FFFFFF" height="1px"></td>
</tr><tr>
	<td><div><a href="moonlist.php" accesskey="k" target="{mf}">{adm_moonlst}</a></div></td>
</tr><tr>
	<td style="background-color:#FFFFFF" height="1px"></td>
</tr><tr>
	<td><div><a href="ShowFlyingFleets.php" accesskey="k" target="{mf}">{adm_fleet}</a></div></td>
</tr><tr>
	<td style="background-color:#FFFFFF" height="1px"></td>
</tr><tr>
	<td><div><a href="banned.php" accesskey="k" target="{mf}">{adm_ban}</a></div></td>
</tr><tr>
	<td><div><a href="unbanned.php" accesskey="k" target="{mf}">{adm_unban}</a></div></td>
</tr><tr>
	<td background="{dpath}img/bg1.gif"><center>{tool}</center></td>
</tr><tr>
	<td><div><a href="statbuilder.php" accesskey="p" target="{mf}">{adm_updpt}</a></div></td>
</tr><tr>
	<td><div><a href="messagelist.php" accesskey="k" target="{mf}">{adm_msg}</a></div></td>
</tr><tr>
     <td><div><a href="meldenadmin.php" accesskey="a" target="{mf}">Gemeldete Nachrichten</a></div></td>
</tr><tr>
	<td><div><a href="md5enc.php" accesskey="p" target="{mf}">{adm_md5}</a></div></td>
</tr><tr>
	<td><div><a href="ElementQueueFixer.php" accesskey="p" target="{mf}">{adm_build}</a></div></td>
</tr><tr>
	<td style="background-color:#FFFFFF" height="1px"></td>
</tr><tr>
	<td><div><a href="../frames.php" accesskey="i" target="_top" style="color:red">{adm_back}</a></div></td>
</tr><tr>
	<td background="{dpath}img/bg1.gif"><center>{infog}</center></td>
</tr><tr>
	<td><div><center><a href="../credit.php" accesskey="T" target="{mf}">Kleinerzwerg</a><br>&copy; Copyright 2009</center></div></td>
</tr>
</table>
</div>
</center>
</body>
</div>