<div id='leftmenu'>
<script language="JavaScript">
function f(target_url,win_name) {
  var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
  new_win.focus();
}
</script>
<body  class="style" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
<center>
<div id='menu'>
<br>
<table width="130" cellspacing="0" cellpadding="0">
<tr>
	<td colspan="2" style="border-top: 1px #545454 solid"><div><center>NG Framework<br>(<a href="changelog.php" target={mf}><font color=red>{XNovaRelease}</font></a>)<center></div></td>
</tr>
	{todoelmenu}
	{ADMIN_LINK}
<tr>
	<td colspan="2"><div><a href="javascript:top.location.href='logout.php'" accesskey="s" style="color:red">{Logout}</a></div></td>
</tr><tr>
	<td colspan="2" background="{dpath}img/bg1.gif"><center>{infog}</center></td>
</tr>
	{server_info}
<tr>
	<td colspan="2"><div><center><a href="credit.php" accesskey="T" target="{mf}">NG Framework</a><br>&copy; 2009 - Team Rocket</center></div></td>
</tr>
</table>
</div>
</center>
</body>
</div>