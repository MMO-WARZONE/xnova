<?php
/**
* buddy.php
*
* @version 1.1
* @copyright 2008 by BenjaminV for XNova
*/

define('INSIDE' , true );
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

includeLang('buddy');
// blocking non-users
if ($IsUserChecked == false)
{
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}
foreach($_GET as $name => $value){//routine de r&eacute;cup&eacute;ration des informations
$$name = intval( $value );
}
switch($mode){
case 1://gestion des requ&ecirc;tes et des 'amiti&eacute;s' (suppression, acceptation ...)
switch($sm){
case 1://il s'agit d'une suppression ou d'un rejet 
doquery("DELETE FROM {{table}} WHERE `id`='{$bid}'","buddy");
message( "Du hast keine Buddy Anfrage!", $lang['Buddy_request'], 'buddy.php' );
break;

case 2://on veut accepter une requ&ecirc;te
doquery("UPDATE {{table}} SET `active` = '1' WHERE `id` ='{$bid}'","buddy");
message( "Buddyanfrage Akzeptiert!.", $lang['Buddy_request'], 'buddy.php' );
break;

case 3:// on veut enregistrer une requ&ecirc;te
$test=doquery("SELECT `id` FROM {{table}} WHERE `sender`='{$user[id]}' AND `owner`='{$_POST}' OR `owner`='{$user[id]}' AND `sender`='{$_POST[u]}'","buddy",true);
if($test==array()){
$text=mysql_escape_string( strip_tags( $_POST['text'] ) );//mesure de s&eacute;curit&eacute;
doquery("INSERT INTO {{table}} SET `sender`='{$user[id]}' ,`owner`='{$_POST[u]}' ,`active`='0' ,`text`='{$text}'","buddy");
message( $lang['Request_sent'], $lang['Buddy_request'], 'buddy.php' );}
else{
message( "Es exstiert bereits eine Buddyanfrage!", $lang['Buddy_request'], 'buddy.php' );
}
break;
} 
break;
case 2://d&eacute;poser une candidature
if($u==$user['id']){
message('Sie können sich selbst keine Buddy Anfrage senden!','Fehler','buddy.php');
}
else{
$player=doquery("SELECT `username` FROM {{table}} WHERE `id`='{$u}'","users",true);
$page="<script src=scripts/cntchar.js type=text/javascript></script>
<script src=scripts/win.js type=text/javascript></script>
<center>
<form action=buddy.php?mode=1&sm=3 method=post>
<input type=hidden name=u value={$u}>
<table width=520>
<tr><td class=c colspan=2>Buddy Anfrage</td></tr>
<tr><th>Spieler</th><th>{$player[username]}</th></tr>
<tr><th>Text der Buddy Anfrage (<span id=cntChars>0</span> / 5000 Zeichen)</th><th><textarea name=text cols=60 rows=10 onKeyUp=javascript:cntchar(5000)></textarea></th></tr>
<tr><td class=c><a href=javascript:back();>Zurueck</a></td><td class=c><input type=submit value='Senden'></td></tr>
</table></form>";
display ( $page, 'buddy', false );
}
break;
default://Affichage de la liste d'amis, des requ&ecirc;tes et des requ&ecirc;tes envoy&eacute;es par le joueur lui-m&ecirc;me
$liste=doquery("SELECT * FROM {{table}} WHERE `sender`='{$user[id]}' OR `owner`='{$user[id]}'","buddy");
while($buddy=mysql_fetch_assoc($liste)){
if($buddy['active']==0){//il s'agit d'une requ&ecirc;te non trait&eacute;e
if($buddy['sender']==$user['id']){//les requ&ecirc;tes que l'utilisateur a envoy&eacute;
$owner=doquery("SELECT `id`, `username`, `galaxy`, `system`, `planet`,`ally_id`, `ally_name` FROM {{table}} WHERE `id`='{$buddy[owner]}'","users",true);
$myrequest.="<tr><th><a href=messages.php?mode=write&id={$owner[id]}>{$owner[username]}</a></th>
<th><a href=alliance.php?mode=ainfo&a={$owner[ally_id]}>{$owner[ally_name]}</a></th>
<th><a href=galaxy.php?mode=3&galaxy={$owner[galaxy]}&system={$owner[system]}>{$owner[galaxy]}:{$owner[system]}:{$owner[planet]}</a></th>
<th>{$buddy[text]}</th>
<th><a href=buddy.php?mode=1&sm=1&bid={$buddy[id]}>Endfernen der Buddy Anfrage</a></th></tr>";
}
else{//les requ&ecirc;tes envoy&eacute;es &agrave; l'utilisateur
$sender=doquery("SELECT `id`, `username`, `galaxy`, `system`, `planet`,`ally_id`, `ally_name` FROM {{table}} WHERE `id`='{$buddy[sender]}'","users",true);
$outrequest.="<tr><th><a href=messages.php?mode=write&id={$sender[id]}>{$sender[username]}</a></th>
<th><a href=alliance.php?mode=ainfo&a={$sender[ally_id]}>{$sender[ally_name]}</a></th>
<th><a href=galaxy.php?mode=3&galaxy={$sender[galaxy]}&system={$sender[system]}>{$sender[galaxy]}:{$sender[system]}:{$sender[planet]}</a></th>
<th>{$buddy[text]}</th>
<th><a href=buddy.php?mode=1&sm=2&bid={$buddy[id]}>Annehmen</a><br><a href=buddy.php?mode=1&sm=1&bid={$buddy[id]}>Ablehnen </a></th></tr>";
}
}
else{//il s'agit des 'amiti&eacute;s' d&eacute;j&agrave; en place
$owner=doquery("SELECT `id`, `username`, `galaxy`, `system`, `planet`,`ally_id`, `ally_name` FROM {{table}} WHERE `id`='{$buddy[owner]}' OR `id`='{$buddy[sender]}'","users",true);
$myfriends.="<tr><th><a href=messages.php?mode=write&id={$owner[id]}>{$owner[username]}</a></th>
<th><a href=alliance.php?mode=ainfo&a={$owner[ally_id]}>{$owner[ally_name]}</a></th>
<th><a href=galaxy.php?mode=3&galaxy={$owner[galaxy]}&system={$owner[system]}>{$owner[galaxy]}:{$owner[system]}:{$owner[planet]}</a></th>
<th><font color=".(( $u["onlinetime"] + 60 * 10 >= time() )?"lime>{$lang['On']}":(( $u["onlinetime"] + 60 * 20 >= time() )?"yellow>{$lang['15_min']}":"red>{$lang['Off']}"))."</font></th>
<th><a href=buddy.php?mode=1&sm=1&bid={$buddy[id]}>Beenden</a></th></tr>";
}
}
$myfriends=($myfriends!='')?$myfriends:'<th colspan=6>Es ist niemand in deiner Buddy Liste!.</th>';
$nor='<th colspan=6>Es gibt keine Anfragen!.</th>';
$outrequest=($outrequest!='')?$outrequest:$nor;
$myrequest=($myrequest!='')?$myrequest:$nor;
$page="<table width=520>
<tr><td class=c colspan=6>Buddy Liste</td></tr>
<tr><td class=c colspan=6><center>Anfragen</a></td></tr>
<tr><td class=c>Name</td>
<td class=c>Allianz</td>
<td class=c>Koordinaten</td>
<td class=c>Text</td>
<td class=c>Aktion</td>
</tr>
<tr>{$outrequest}</tr>
<tr><td class=c colspan=6><center>Meine Anfragen</a></td></tr>
<tr><td class=c>Name</td>
<td class=c>Allianz</td>
<td class=c>Koordinaten</td>
<td class=c>Text</td>
<td class=c>Aktion</td>
</tr>
<tr>{$myrequest}</tr>
<tr><td class=c colspan=6><center>Buddys</a></td></tr>
<tr><td class=c>Name</td>
<td class=c>Allianz</td>
<td class=c>Koordinaten</td>
<td class=c>Status</td>
<td class=c>Aktion</td>
</tr>
<tr>{$myfriends}</tr>
</table>";
display ( $page, $lang['Buddy_list'], false );
break;
}
?>