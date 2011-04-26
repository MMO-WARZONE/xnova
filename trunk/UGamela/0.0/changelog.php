<? //changelog.php
include("common.php");
include("cookies.php");
{//init
	$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
	include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta
}
echo_head();
echo_topnav();
echo '<br>
<center>
<table width="668">
  <tr>
    <td class="c">'.$lang['Version'].'</td>
    <td class="c">'.$lang['Descriptión'].'</td>
  </tr>';
$changelog_query = doquery("SELECT * FROM {{table}} ORDER BY id DESC","changelog");
while($changelog = mysql_fetch_array($changelog_query)){
	echo '
  <tr>
    <th width="42">'.$changelog["version"].'</th>
    <th style="text-align:left">'.nl2br($changelog["description"]).'</th>
  </tr>';
}
echo '
</table>
</center>
</body>
</html>';
if(isset($link)) mysql_close();
// Created by Perberos. All rights reversed (C) 2006
?>