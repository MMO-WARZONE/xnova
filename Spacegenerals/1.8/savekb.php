<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);
includeLang('savekb');


$kuser = doquery ("SELECT u_id FROM {{table}}","savekb");
$row = mysql_fetch_array($kuser);
if($_GET['mysql']=='new')
{
	if(!$_POST['titel'])
	{
		$page ='<h2><font color=red>'.$lang['SAVEKB_ERROR_NO_TITLE'];
	}
	else
	{
		doquery("INSERT INTO {{table}}(
			`u_id`,
			`titel`,
			`code`
			)
			VALUES
			(
				'".$user['id']."',
				'".$_POST['titel']."',
				'".$_POST['code']."')","savekb");
						$page .= '<meta http-equiv="refresh" content="0; URL=savekb.php">';
		display($page, "SaveKB", false);
	}
}
if($_GET['mysql']=='delete' && $_GET['ID']) {
	// Änderung
	$kuser1 = doquery ("SELECT u_id FROM {{table}} WHERE ID=" . intval($_GET['ID']). "","savekb");
	$row1 = mysql_fetch_array($kuser1);
	if($user['id'] == $row1['u_id']) {
		doquery("DELETE FROM {{table}} WHERE ID = ".intval($_GET['ID'])."","savekb");
		$page .= '<meta http-equiv="refresh" content="0; URL=savekb.php">';
	}else{
		message($lang['SAVEKB_ERROR_TITLE'], $lang['SAVEKB_ERROR_TITLE']);
	}
	display($page, 'SAVEKB', false);
}
switch($_GET['mode'])
{
	case 'new':
	{
		$page = "<h2>Neuer SaveKB</h2>
		<form action=savekb.php?mysql=new method=POST>
		".$lang['SAVEKB_INPUT_TITLE'].":<br>
		<input type=text name=titel size=100><br>
		".$lang['SAVEKB_INPUT_CODE'].":<br>
		<textarea name=code cols=10 rows=20 style=width:60%>
		</textarea><br>
		<input type=submit value='".$lang['SAVEKB_BUTTON_SUBMIT']."'>
		</form>";
		display($page, "SaveKB", false);
		break;
	}
	case 'anzeigen':
	{
		$row = $lang;
		$sql = doquery("SELECT * FROM {{table}} WHERE ID = '".$_GET['ID']."' ","savekb");
		$row = mysql_fetch_array($sql);
		$page = parsetemplate(gettemplate('savekb'), $row);
		display($page, "SaveKB", false);
		break;
	}
	default:
	{
		$page ="<h2>".$lang['SAVEKB_TITLE']."</h2>";
		$ksql = doquery("SELECT * FROM {{table}} WHERE u_id = '".$user['id']."' ","savekb");
		$page .="<table width=600>
		<tr>
		<td class=c colspan=3>".$lang['SAVEKB_YOUR_COMBATS']."</td>
		</tr>
		<tr><td class=c>".$lang['SAVEKB_INPUT_TITLE']."</td><td class=c>".$lang['SAVEKB_LINK']."</td><td class=c>".$lang['SAVEKB_OPTIONS']."</td></tr>";
		while($krow = mysql_fetch_array($ksql))
		{
			$page .= "
			<tr><td class=b>".$krow['titel']."</td><td class=b><a href=savekb.php?mode=anzeigen&ID=".$krow['ID']." target=_new>".$lang['SAVEKB_SHOW']."</a></td><td class=b><a href='savekb.php?mysql=delete&ID=".$krow['ID']."'>".$lang['SAVEKB_DELETE']."</a></td></tr>";
		}
		$page .= "
			<tr><td class=c colspan=3><a href=savekb.php?mode=new>".$lang['SAVEKB_ADD']."</a></td></tr>
			</table>";
		display($page, "SaveKB", false);
		break;
	}
}
?>