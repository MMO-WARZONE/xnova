<div id='leftmenu'>
<script language="JavaScript">
function f(target_url,win_name) {
  var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
  new_win.focus();
}
parent.frames['Hauptframe'].location.replace("overview.php");
</script>
<style type="text/css">
<!--
.Stil1 {color: #FF0000}
-->
</style>
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
	<td><div><a href="server.php" accesskey="s" target="{mf}">{server_inf}</a></div></td>
</tr><tr>
	<td><div><a href="optimieren.php" accesskey="s" target="{mf}">Datenbankpflege</a></div></td>
</tr
<tr>
	<td><div><a href="variables.php" accesskey="k" target="{mf}">Php Infos</a></div></td>
</tr><tr>
	<td><div><a href="settings.php" accesskey="e" target="{mf}">{adm_conf}</a></div></td>
</tr><tr>
	<td><div><a href="ResetUniverse.php" target="{mf}" class="Stil1" accesskey="e"><strong><blink>{adm_reset}</strong></a></div></td>
</tr><tr>
	<td background="{dpath}img/bg1.gif"><center>{player}</center></td>
</tr><tr>
	<td><div><a href="userlist.php" accesskey="a" target="{mf}">{adm_plrlst}</a></div></td>
</tr><tr>
	<td><div><a href="paneladmina.php" accesskey="k" target="{mf}">{adm_plrsch}</a></div></td>
</tr><tr>
	<td><div><a href="support.php" accesskey="v" target="{mf}">Support Tickets</a></div></td>
</tr><tr>
	<td><div><a href="banadmin.php" accesskey="v" target="{mf}">IP-Bann System</a></div></td>
</tr><tr>
	<td><div><a href="mats.php" accesskey="k" target="{mf}">{adm_mats}</a></div></td>
</tr><tr>
	<td><div><a href="planetlist.php" accesskey="k" target="{mf}">Planeten bearbeiten</a></div></td>
</tr><tr>
      <td><div><a href="add_pts.php" accesskey="k" target="{mf}">Offizierspunkte</a></div></td>
</tr><tr>
    <td><div><a href="alliancelist.php" accesskey="e" target="{mf}">Allianzen&uuml;bersicht</a></div></td>
</tr><tr>

</tr><tr>
	<td><div><a href="planetlist.php" accesskey="1" target="{mf}">{adm_pltlst}</a></div></td>
</tr><tr>
	<td><div><a href="activeplanet.php" accesskey="k" target="{mf}">{adm_actplt}</a></div></td>
</tr><tr>
	<td background="{dpath}img/bg1.gif"><center>{luna}</center></td>
</tr><tr>
	<td><div><a href="moonlist.php" accesskey="k" target="{mf}">{adm_moonlst}</a></div></td>
</tr><tr>
	<td><div><a href="add_moon.php" accesskey="k" target="{mf}">{adm_addmoon}</a></div></td>
</tr><tr>
	<td background="{dpath}img/bg1.gif"><center>{fleet}</center></td>
</tr><tr>
	<td><div><a href="ShowFlyingFleets.php" accesskey="k" target="{mf}">{adm_fleet}</a></div></td>
</tr><tr>

</tr><tr>
	<td><div><a href="banned.php" accesskey="k" target="{mf}">{adm_ban}</a></div></td>
</tr><tr>
	<td><div><a href="unbanned.php" accesskey="k" target="{mf}">{adm_unban}</a></div></td>
</tr><tr>
	<td background="{dpath}img/bg1.gif"><center>{tool}</center></td>
</tr><tr>
	<td><div><a href="statbuilder.php" accesskey="p" target="{mf}">{adm_updpt}</a></div></td>
</tr><tr>
	<td><div><a href="ElementQueueFixer.php" accesskey="p" target="{mf}">{adm_build}</a></div></td>
</tr><tr>
	<td background="{dpath}img/bg1.gif"><center>
	  {tool2}
	</center></td>
</tr><tr>
	<td><div><a href="messagelist.php" accesskey="k" target="{mf}">{adm_msg}</a></div></td>
</tr><tr>
     <td><div><a href="meldenadmin.php" accesskey="a" target="{mf}">Meldungen</a></div></td>
</tr><tr>
	<td><div><a href="messall.php" accesskey="k" target="{mf}">{adm_mass}</a></div></td>
</tr><tr>
	<td><div><a href="chat.php" accesskey="p" target="{mf}">{adm_chat}</a></div></td>
</tr><tr>
	<td background="{dpath}img/bg1.gif"><center>
	  {tool3}
	</center></td>
</tr><tr>
	<td><div><a href="md5enc.php" accesskey="p" target="{mf}">{adm_md5}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="edit_impress.php" accesskey="e" target="{mf}">Impressum editieren</a></div></td>
</tr><tr>

</tr><tr>
	<td><div><a href="errors.php" accesskey="e" target="{mf}">{adm_error}</a></div></td>
</tr><tr>
	<td><div><a href="../x.php" accesskey="i" target="_top" style="color:red">{adm_back}</a></div></td>
</tr><tr>

</tr><tr><td colspan="2" background="{dpath}img/bg1.gif"><center><br><font size=1 color=red>Rocket Nova v{XNovaRelease}</font><br><font size=1 color=yellow><b>&copy; 2009 - Team Rocket</b></font></center><br></td></tr>
</table>
</div>
</center>
</body>
</div>