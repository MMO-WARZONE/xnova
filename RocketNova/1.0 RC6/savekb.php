<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);


$kuser = doquery ("SELECT u_id FROM {{table}}","savekb");
$row = mysql_fetch_array($kuser);
if($_GET['mysql']=='new')
{
if(!$_POST['titel'])
{
$page ='<h2><font color=red>FEHLER KEIN TITEL ANGEGEBEN';
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
        message("ERROR","ERROR");
    }
    display($page, 'SAVEKB', false);
}
switch($_GET['mode'])
{
case 'new':
{
$page = "<h2>Neuer SaveKB</h2>
<form action=savekb.php?mysql=new method=POST>
Titel:<br>
<input type=text name=titel size=100><br>
Code:<br>
<textarea name=code cols=10 rows=20 style=width:60%>
</textarea><br>
<input type=submit value='Ab damit'>
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
$page ="<h2>SaveKB</h2>";
$ksql = doquery("SELECT * FROM {{table}} WHERE u_id = '".$user['id']."' ","savekb");
$page .="<table width=600>
<tr>
<td class=c colspan=3>Deine KBs</td>
</tr>
<tr><td class=c>Titel</td><td class=c>Link</td><td class=c>Optionen</td></tr>";
while($krow = mysql_fetch_array($ksql))
{
$page .= "
<tr><td class=b>".$krow['titel']."</td><td class=b><a href=savekb.php?mode=anzeigen&ID=".$krow['ID']." target=_new>Hier</a></td><td class=b><a href='savekb.php?mysql=delete&ID=".$krow['ID']."'>Killen</a></td></tr>";
}
$page .= "
<tr><td class=c colspan=3><a href=savekb.php?mode=new>Neuen KB einf&uuml;gen</a></td></tr>
</table>";
display($page, "SaveKB", false);
break;
}
}
?>