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
	<td style="border-top: 1px #545454 solid"><div><center>{servername}<br>(<a href="changelog.php" target={mf}><font color=red>{XNovaRelease}</font></a>)<center></div></td>
</tr><tr>
	<td background="{dpath}img/bg1.gif"><center>{admin}</center></td>
</tr><tr>
	<td><div><a href="overview.php" accesskey="v" target="{mf}">{adm_over}</a></div></td>
</tr><tr>
	<td><div><a href="settings.php" accesskey="e" target="{mf}">{adm_conf}</a></div></td>
</tr><tr>
	<td><div><a href="XNovaResetUnivers.php" accesskey="e" target="{mf}">{adm_reset}</a></div></td>
</tr><tr>
	<td><div><a href="server.php" accesskey="s" target="{mf}">{server_inf}</a></div></td>
</tr><tr>
	<td><div><a href="visitas.php" accesskey="s" target="{mf}">Seitenaufrufe</a></div></td>
</tr><tr>
	<td background="{dpath}img/bg1.gif"><center>Konfiguration</center></td>
</tr>
<tr>
	<td><div><a href="menu.php" accesskey="s" target="{mf}">Spielmen&uuml;</a></div></td>
</tr>
<tr>
	<td><div><a href="modulos.php" accesskey="s" target="{mf}">Module</a></div></td>
</tr>
<tr>
	<td><div><a href="config-stats.php" accesskey="s" target="{mf}">Statistiken</a></div></td>
</tr>
<tr>
	<td><div><a href="config-idioma.php" accesskey="s" target="{mf}">Sprachdateien</a></div></td>
</tr>
<tr>
	<td background="{dpath}img/bg1.gif"><center>Spieler</center></td>
</tr><tr>
	<td><div><a href="banned.php" accesskey="k" target="{mf}">{adm_ban}</a></div></td>
</tr><tr>
	<td><div><a href="unbanned.php" accesskey="k" target="{mf}">{adm_unban}</a></div></td>
</tr><tr>
	<td><div><a href="add_moon.php" accesskey="k" target="{mf}">{adm_addmoon}</a></div></td>
</tr><tr>
	<td><div><a href="add_money.php" accesskey="k" target="{mf}">{adm_addres}</a></div></td>
</tr><tr>
	<td><div><a href="add_ship.php" accesskey="k" target="{mf}">Flotte hinzuf&uuml;gen</a></div></td>
</tr><tr>
	<td><div><a href="add_def.php" accesskey="k" target="{mf}">Verteidigung hinzuf&uuml;gen</a></div></td>
</tr><tr>
	<td><div><a href="add_research.php" accesskey="k" target="{mf}">Forschungen hinzuf&uuml;gen</a></div></td>
</tr><tr>
	<td><div><a href="add_building.php" accesskey="k" target="{mf}">Geb&auml;ude hinzuf&uuml;gen</a></div></td>
</tr><tr>
	<td><div><a href="del_money.php" accesskey="k" target="{mf}">Rohstoffe abziehen</a></div></td>
</tr><tr>
	<td><div><a href="del_ship.php" accesskey="k" target="{mf}">Flotte abziehen</a></div></td>
</tr><tr>
	<td><div><a href="del_def.php" accesskey="k" target="{mf}">Verteidigung abziehen</a></div></td>
</tr><tr>
	<td><div><a href="del_research.php" accesskey="k" target="{mf}">Forschungen abziehen</a></div></td>
</tr><tr>
	<td><div><a href="del_building.php" accesskey="k" target="{mf}">Geb&auml;ude abziehen</a></div></td>
</tr>


<tr>
	<td background="{dpath}img/bg1.gif"><center>Administrar</center></td>
</tr><tr>
	<td><div><a href="paneladmina.php" accesskey="k" target="{mf}">{adm_plrsch}</a></div></td>
</tr><tr>
	<td><div><a href="lista-multi.php" accesskey="1" target="{mf}">Mond Liste</a></div></td>
</tr><tr>
	<td><div><a href="planetlist.php" accesskey="1" target="{mf}">{adm_pltlst}</a></div></td>
</tr><tr>
	<td><div><a href="moonlist.php" accesskey="k" target="{mf}">{adm_moonlst}</a></div></td>
</tr><tr>
	<td><div><a href="userlist.php" accesskey="a" target="{mf}">{adm_plrlst}</a></div></td>
</tr><tr>
	<td><div><a href="messagelist.php" accesskey="k" target="{mf}">{adm_msg}</a></div></td>
</tr><tr>
	<td><div><a href="activeplanet.php" accesskey="k" target="{mf}">{adm_actplt}</a></div></td>
</tr><tr>
	<td><div><a href="chat.php" accesskey="p" target="{mf}">{adm_chat}</a></div></td>
</tr><tr>
	<td><div><a href="ShowFlyingFleets.php" accesskey="k" target="{mf}">{adm_fleet}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="support.php" accesskey="s" target="{mf}">{adm_support}</a></div></td>
</tr><tr>
	<td><div><a href="statbuilder.php" accesskey="p" target="{mf}">{adm_updpt}</a></div></td>
</tr><tr>
	<td background="{dpath}img/bg1.gif"><center>Sonstiges</center></td>
</tr><tr>
	<td><div><a href="optimizar.php" accesskey="3" target="{mf}">DB optimieren</a></div></td>
</tr><tr>
	<td><div><a href="errors.php" accesskey="e" target="{mf}">{adm_error}</a></div></td>
</tr><tr>
	<td><div><a href="http://www.xnova.saint-rc.es/index.php" accesskey="3" target="{mf}">{adm_help}</a></div></td>
</tr><tr>
	<td><div><a href="../frames.php" accesskey="i" target="_top" style="color:red">{adm_back}</a></div></td>
</tr><tr>
	<td background="{dpath}img/bg1.gif"><center>{infog}</center></td>
</tr><tr>
	<td colspan="2"><div><center><a href="credit.php" accesskey="T" target="{mf}">NG Framework</a><br>&copy; 2009 - Team Rocket</center></div></td>
</tr>
</table>
</div>
</center>
</body>
</div>