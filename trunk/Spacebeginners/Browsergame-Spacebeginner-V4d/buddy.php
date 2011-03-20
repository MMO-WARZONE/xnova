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
                                message( $lang['no_question'], $lang['Buddy_request'], 'buddy.php' );
                                break;

                        case 2://on veut accepter une requ&ecirc;te
                                doquery("UPDATE {{table}} SET `active` = '1' WHERE `id` ='{$bid}'","buddy");
                                message( $lang['question_akzept'], $lang['Buddy_request'], 'buddy.php' );
                                break;

                             case 3:// on veut enregistrer une requ&ecirc;te
                                $test=doquery("SELECT `id` FROM {{table}} WHERE `sender`='{$user[id]}' AND `owner`='{$_POST}' OR `owner`='{$user[id]}' AND `sender`='{$_POST[u]}'","buddy",true);
                                if($test==array()){
                                        $text=mysql_escape_string( strip_tags( $_POST['text'] ) );//mesure de s&eacute;curit&eacute;
                                        doquery("INSERT INTO {{table}} SET `sender`='{$user[id]}' ,`owner`='{$_POST[u]}' ,`active`='0' ,`text`='{$text}'","buddy");

                                        $from = $lang['sender_message_ig'];
                                        $sender = "Buddy";
                                        $Subject = $lang['subject_message_ig'];
                                        $message = sprintf($lang['text_message_ig'], $user['username']);
                                        SendSimpleMessage($_POST['u'], $user['id'], $Time, 1, $from, $Subject, $message);


                                        message( $lang['Request_sent'], $lang['Buddy_request'], 'buddy.php' );
                                }
                                else{
                                        message( $lang['question_exist'], $lang['Buddy_request'], 'buddy.php' );
                                }
                                break;
                     }
                    break;
                        case 2://d&eacute;poser une candidature
                                if($u==$user['id']){
                                        message($lang['question_no_self'],$lang['error'],'buddy.php');
                                }
                                else{
                                        $player=doquery("SELECT `username` FROM {{table}} WHERE `id`='{$u}'","users",true);
                                        $page="<script src=scripts/cntchar.js type=text/javascript></script>
                    <script src=scripts/win.js type=text/javascript></script>
                    <center>
                    <form action=buddy.php?mode=1&sm=3 method=post>
                    <input type=hidden name=u value={$u}>
                    <table width=520>
                    <tr><td class=c colspan=2>".$lang['Request_new']."</td></tr>
                    <tr><th>Spieler</th><th>{$player[username]}</th></tr>
                    <tr><th>".$lang['Text_of_Buddy']." (<span id=cntChars>0</span> / ".$lang['long_text'].")</th><th><textarea name=text cols=60 rows=10 onKeyUp=javascript:cntchar(5000)></textarea></th></tr>
                    <tr><td class=c><a href=javascript:back();>".$lang['Back']."</a></td><td class=c><input type=submit value='Senden'></td></tr>
                    </table></form>";
                                        display ( $page, 'buddy', false );
                                }
                                break;
                            default://Affichage de la liste d'amis, des requ&ecirc;tes et des requ&ecirc;tes envoy&eacute;es par le joueur lui-m&ecirc;me
                                // get active buddy list
                                $liste        =        doquery("SELECT b.*, IF(b.sender='{$user['id']}', b.owner, b.sender) as buddy_id,
                                                                                                        u.username, u.galaxy, u.system, u.planet, u.ally_id, u.ally_name, u.onlinetime
                                                                                                        FROM {{table}} b
                                                                                                        LEFT JOIN game_users u ON (IF(b.sender='{$user['id']}', b.owner, b.sender)=u.id)
                                                                                                        WHERE (b.sender='{$user['id']}' OR b.owner='{$user['id']}') AND (b.active=1)","buddy");

                                while($buddy=mysql_fetch_assoc($liste))
                                {
                                        $myfriends.="<tr><th><a href=messages.php?mode=write&id={$buddy[buddy_id]}>{$buddy[username]}</a></th>
                                        <th><a href=alliance.php?mode=ainfo&a={$buddy[ally_id]}>{$buddy[ally_name]}</a></th>
                                        <th><a href=galaxy.php?mode=3&galaxy={$buddy[galaxy]}&system={$buddy[system]}>{$buddy[galaxy]}:{$buddy[system]}:{$buddy[planet]}</a></th>
                                        <th><font color=".(( time()-$buddy["onlinetime"] < (60*10) )?"lime>{$lang['On']}":(( $u["onlinetime"] + 60 * 20 >= time() )?"yellow>{$lang['15_min']}":"red>{$lang['Off']}"))."</font></th>
                                        <th><a href=buddy.php?mode=1&sm=1&bid={$buddy[id]}>".$lang['end']."</a></th></tr>";
                                }

                                // get pending sent requests
                                $liste        =        doquery("SELECT b.*, IF(b.sender='{$user['id']}', b.owner, b.sender) as buddy_id,
                                                                                                        u.username, u.galaxy, u.system, u.planet, u.ally_id, u.ally_name, u.onlinetime
                                                                                                        FROM {{table}} b
                                                                                                        LEFT JOIN game_users u ON (IF(b.sender='{$user['id']}', b.owner, b.sender)=u.id)
                                                                                                        WHERE (b.sender='{$user['id']}') AND (b.active=0)","buddy");

                                while($owner=mysql_fetch_assoc($liste))
                                {

                                        $myrequest.="<tr><th><a href=messages.php?mode=write&id={$owner[buddy_id]}>{$owner[username]}</a></th>
                <th><a href=alliance.php?mode=ainfo&a={$owner[ally_id]}>{$owner[ally_name]}</a></th>
                <th><a href=galaxy.php?mode=3&galaxy={$owner[galaxy]}&system={$owner[system]}>{$owner[galaxy]}:{$owner[system]}:{$owner[planet]}</a></th>
                <th>{$owner[text]}</th>
                <th><a href=buddy.php?mode=1&sm=1&bid={$owner[id]}>".$lang['Delete_request']."</a></th></tr>";


                                }

                                // get pending received requests
                                $liste        =        doquery("SELECT b.*, IF(b.sender='{$user['id']}', b.owner, b.sender) as buddy_id,
                                                                                                        u.username, u.galaxy, u.system, u.planet, u.ally_id, u.ally_name, u.onlinetime
                                                                                                        FROM {{table}} b
                                                                                                        LEFT JOIN game_users u ON (IF(b.sender='{$user['id']}', b.owner, b.sender)=u.id)
                                                                                                        WHERE (b.owner='{$user['id']}') AND (b.active=0)","buddy");

                                while($sender=mysql_fetch_assoc($liste))
                                {
                                        $outrequest.="<tr><th><a href=messages.php?mode=write&id={$sender[buddy_id]}>{$sender[username]}</a></th>
               <th><a href=alliance.php?mode=ainfo&a={$sender[ally_id]}>{$sender[ally_name]}</a></th>
               <th><a href=galaxy.php?mode=3&galaxy={$sender[galaxy]}&system={$sender[system]}>{$sender[galaxy]}:{$sender[system]}:{$sender[planet]}</a></th>
               <th>{$sender[text]}</th>
               <th><a href=buddy.php?mode=1&sm=2&bid={$sender[id]}>".$lang['Akzept']."</a><br><a href=buddy.php?mode=1&sm=1&bid={$sender[id]}>".$lang['Reject']."</a></th></tr>";
                                }

                                /*
                                 $from = $lang['sender_message_ig'];
                                 $sender = "Buddy";
                                 $Subject = $lang['subject_message_ig'];
                                 $message = $lang['text_message_ig'];
                                 SendSimpleMessage($u, $sender, $Time, 1, $from, $Subject, $message);
                                 */





                                $myfriends=($myfriends!='')?$myfriends:'<th colspan=6>'. $lang['no_one_in_buddy_list'] .'</th>';
                                $nor='<th colspan=6>'.$lang['There_is_no_request'].'</th>';
                                $outrequest=($outrequest!='')?$outrequest:$nor;
                                $myrequest=($myrequest!='')?$myrequest:$nor;



                                $page="<table width=520>
                <tr><td class=c colspan=6>".$lang['Buddy_list']."</td></tr>
                <tr><td class=c colspan=6><center>".$lang['Buddy_request']."</a></td></tr>
                <tr><td class=c>".$lang['Name']."</td>
                <td class=c>".$lang['Alliance']."</td>
                <td class=c>".$lang['Coordinates']."</td>
                <td class=c>".$lang['Text'] ."</td>
                <td class=c>".$lang['Action']."</td>
                </tr>
                <tr>{$outrequest}</tr>
                <tr><td class=c colspan=6><center>".$lang['My_requests']."</a></td></tr>
                <tr><td class=c>".$lang['Name']."</td>
                <td class=c>".$lang['Alliance']."</td>
                <td class=c>".$lang['Coordinates']."</td>
                <td class=c>".$lang['Text'] ."</td>
                <td class=c>".$lang['Action']."</td>
                </tr>
                <tr>{$myrequest}</tr>
                <tr><td class=c colspan=6><center>".$lang['my_buddys']."</a></td></tr>
                <tr><td class=c>".$lang['Name']."</td>
                <td class=c>".$lang['Alliance']."</td>
                <td class=c>".$lang['Coordinates']."</td>
                <td class=c>".$lang['Position']."</td>
                <td class=c>".$lang['Action']."</td>
                </tr>
                <tr>{$myfriends}</tr>
                </table>";
                                display ( $page, $lang['Buddy_list'], true );
                                break;
              }
?>