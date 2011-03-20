<!-- 
  -- Creator    : Yurgeta
  -- Date       : Unknown
  -- File name  : templates/admin/left_menu.tpl
!-->
<script language="JavaScript">
function f(target_url,win_name) {
  var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
  new_win.focus();
}
parent.frames['Hauptframe'].location.replace("overview.php");
</script>
<!-- //////////////////////////////////////////////////////// !-->
<script type="text/javascript">
<!--
window.onload=show;
function show(id) {
var d = document.getElementById(id);
	for (var i = 1; i<=10; i++) {
		if (document.getElementById('smenu'+i)) {document.getElementById('smenu'+i).style.display='none';}
	}
if (d) {d.style.display='block';}
}
//-->
</script>
<style type="text/css" media="screen">
<!-- 
body {
font: 80% verdana, arial, sans-serif;
  color                : #FFFFFF;
  margin-top           : 5px;
  background-image     : url(/skins/SGO/img/bkd_navigation.jpg);
  background-attachment: fixed;
  background-repeat    : no-repeat;
  background-position  : top left;
  scrollbar-arrow-color: #FFFFFF;
  scrollbar-base-color: #344566;
  scrollbar-track-color: #344566;
  scrollbar-face-color: #344566;
  scrollbar-highlight-color: #344566;
  scrollbar-3dlight-color: #465673;
  scrollbar-darkshadow-color: #344566;
  scrollbar-shadow-color: #465673;
  font-size            : 85%;
  font-family          : Tahoma,sans-serif;
}
body.style table {
  margin               : 0px;
}

body form table th table input
{
  width: 60px;
}
dl, dt, dd, ul, li {
margin: 0;
padding: 0;
list-style-type: none;
}
#menu {
position: absolute; /* Menu position that can be changed at will */
top: 5px;
left: 10px;
opacity              : 0.9;
}
#menu {
	width: 160px;
}
#menu dt {
cursor: pointer;
margin: 2px 0;;
height: 20px;
line-height: 20px;
text-align: center;
font-weight: bold;
border: 1px solid gray;
}
#menu dd {
border: 1px solid gray;
opacity              : 0.7;
}
#menu li {
text-align: center;
background-color     : #040e1e;
}
#menu li a, #menu dt a {
color                : #ffffff;
text-decoration: none;
display: block;
border: 0 none;
height: 100%;
}
#menu li a:hover, #menu dt a:hover {
background-color     : #000000;
color                : #ffffff;
}
-->
</style>
<dl id="menu">
  <dt onclick="javascript:show('smenu1');">General</dt>
			<dd id="smenu1">
				<ul>
					<li>Server Name: SGO</li>
					<li>Version : v0.9</li>
					<li><a href="../frames.php" accesskey="i" target="_top">{adm_back}</a></li>
				</ul>
			</dd>

	<dt onclick="javascript:show('smenu2');">Main Menu</dt>
			<dd id="smenu2">
				<ul>
					<li><a href="settings.php" accesskey="e" target="{mf}">Game Settings</a><a href="#"></a></li>
					<li><a href="XNovaResetUnivers.php" accesskey="e" target="{mf}">Wipe Game</a><a href="#"></a></li>
				<li><a href="lancerstatauto.php" target="{mf}">stat_auto1</a><a href="#"></a></li>
				<li><a href="stopstatauto.php" target="{mf}">stat_auto2</a><a href="#"></a></li>
				</ul>
			</dd>	

	<dt onclick="javascript:show('smenu3');">Add/Remove</dt>
			<dd id="smenu3">
				<ul>
					<li><a href="add_ship.php" accesskey="e" target="{mf}">[+] Ships</a></li>
					<li><a href="add_building.php" accesskey="v" target="{mf}">[+]Building</a><a href="#"></a></li>
					<li><a href="add_def.php" accesskey="e" target="{mf}">[+]Defense</a><a href="#"></a></li>
					<li><a href="add_money.php" accesskey="e" target="{mf}">[+]Money</a><a href="#"></a></li>
					<li><a href="add_research.php" accesskey="v" target="{mf}">[+]Research</a><a href="#"></a></li>
					<li><a href="del_ship.php" accesskey="e" target="{mf}">[-]Ship</a><a href="#"></a></li>
                    <li><a href="del_building.php" accesskey="v" target="{mf}">[-]Building</a><a href="#"></a></li>
                    <li><a href="del_def.php" accesskey="e" target="{mf}">[-]Defense</a><a href="#"></a></li>
                    <li><a href="del_money.php" accesskey="e" target="{mf}">[-]Money</a><a href="#"></a></li>
					
	                  <li><a href="del_research.php" accesskey="v" target="{mf}">[-]Research</a><a href="#"></a></li>

				</ul>
			</dd>

	<dt onclick="javascript:show('smenu4');">Other</dt>
			<dd id="smenu4">
				<ul>
					<li><a href="userlist.php" accesskey="a" target="{mf}">User List</a><a href="#"></a></li>
					<li><a href="paneladmina.php" accesskey="k" target="{mf}">Admin Panel</a><a href="#"></a></li>
					<li><a href="planetlist.php" accesskey="1" target="{mf}">Planet Lists</a><a href="#"></a></li>
					<li><a href="activeplanet.php" accesskey="k" target="{mf}">Active Planets</a><a href="#"></a></li>
					<li><a href="chat.php" accesskey="p" target="{mf}">Chat</a><a href="#"></a></li>
					<li><a href="messagelist.php" accesskey="k" target="{mf}">Message List</a><a href="#"></a></li>
					<li><a href="moonlist.php" accesskey="k" target="{mf}">Moon Lists</a><a href="#"></a></li>
					<li><a href="add_moon.php" accesskey="k" target="{mf}">[+]Add Moons</a><a href="#"></a></li>
				</ul>
			</dd>
	<dt onclick="javascript:show('smenu5');">Fixes</dt>
			<dd id="smenu5">
				<ul>
					<li><a href="statbuilder.php" accesskey="p" target="{mf}">Update Points</a><a href="#"></a></li>
					<li><a href="md5enc.php" accesskey="p" target="{mf}">Md5 Thingy</a><a href="#"></a></li>
					<li><a href="ElementQueueFixer.php" accesskey="p" target="{mf}">Update Rank</a><a href="#"></a></li>
				</ul>
			</dd>
</dl>
