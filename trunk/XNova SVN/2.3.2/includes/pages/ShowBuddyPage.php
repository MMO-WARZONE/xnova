<?php
//version 1.1


if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowBuddyPage($CurrentUser)
{
	global $lang, $svn_root,$db,$displays;

	$displays->assignContent("/buddy/buddy" );
	
	foreach($_GET as $name => $value)
	{
		$$name = intval( $value );
	}
	$displays->newBlock("title");
	switch($mode)
	{
		case 1:
			switch($sm)
			{
				case 1:
					$db->query("DELETE FROM {{table}} WHERE `id`='".$bid."'","buddy");
					header("location:game.php?page=buddy");
				break;

				case 2:
					$db->query("UPDATE {{table}} SET `active` = '1' WHERE `id` ='".$bid."'","buddy");
					header("location:game.php?page=buddy");
				break;

				case 3:
					$test = $db->query("SELECT `id` FROM {{table}} WHERE `sender`='".$CurrentUser[id]."' AND `owner`='".$_POST."' OR `owner`='".$CurrentUser[id]."' AND `sender`='".$_POST[u]."'","buddy",true);
					if($test == array())
					{
						$text = mysql_escape_string( strip_tags( $_POST['text'] ) );
						$db->query("INSERT INTO {{table}} SET `sender`='".$CurrentUser[id]."' ,`owner`='".$_POST[u]."' ,`active`='0' ,`text`='".$text."'","buddy");
						header("location: game.php?page=buddy");
					}
					else
					{
						message($lang['bu_request_exists'], 'game.php?page=buddy',2 );
					}
				break;
			}
		break;

		case 2:
			if($u==$CurrentUser['id']){
				
				$displays->message($lang['bu_cannot_request_yourself'],'game.php?page=buddy',2);
			}else{
				
				$player=$db->query("SELECT `username` FROM {{table}} WHERE `id`='".$u."'","users",true);
				
				$displays->newBlock("newbuddy");
				$player["u"]=$u;
				foreach($player as $name => $trans){
                   	$displays->assign($name, $trans);
                }
                    
     			
     			$displays->display ();

                }
		break;
		
		
		default:
			$liste=$db->query("SELECT * FROM {{table}} WHERE (`sender`='".$CurrentUser['id']."' OR `owner`='".$CurrentUser['id']."' )","buddy");
			while($buddy = mysql_fetch_assoc($liste)){
					$i++;
					

                                        if($buddy['active']	==0){

                                                if($buddy['sender']==$CurrentUser['id']){
                                                        $myrequestnum++;
                                                        $myrequest=$db->query("SELECT `id`, `username`, `galaxy`, `system`, `planet`,`ally_id`, `ally_name` FROM {{table}} WHERE `id`='".$buddy["owner"]."'","users",true);

                                                        $displays->newBlock("buddy");
                                                        $parse["tipo"]=$lang['bu_my_requests'];
                                                        $parse["texts1"]=$lang['bu_text'];

                                                        foreach($parse as $name => $trans){
                                                            $displays->assign($name, $trans);
                                                        }

                                                        $displays->newBlock("listbuddy");
                                                        $myrequest["texts2"]=$buddy["text"];
                                                        $myrequest['actions']="<a href=game.php?page=buddy&mode=1&sm=1&bid=".$buddy[id].">".$lang['bu_cancel_request']."</a>";
                                                        foreach($myrequest as $name => $trans){
                                                           $displays->assign($name, $trans);
                                                        }

                                                }else{
                                                        $outrequestnum++;
                                                        $outrequest=$db->query("SELECT `id`, `username`, `galaxy`, `system`, `planet`,`ally_id`, `ally_name` FROM {{table}} WHERE `id`='".$buddy[sender]."'","users",true);
                                                        $outrequest[$outrequest[id]]=$buddy[text];
                                                        if($outrequestnum==1){
                                                                $displays->newBlock("buddy");
                                                                $parse["tipo"]=$lang['bu_requests'];
                                                                $parse["texts1"]=$lang['bu_text'];
                                                                foreach($parse as $name => $trans){
                                                                $displays->assign($name, $trans);
                                                        }
                                                        }

                                                        $displays->newBlock("listbuddy");
                                                        $outrequest["texts2"]=$buddy["text"];
                                                        $outrequest['actions']="<a href=game.php?page=buddy&mode=1&sm=2&bid=".$buddy[id].">".$lang['bu_accept']."</a><br><a href=game.php?page=buddy&mode=1&sm=1&bid=".$buddy[id].">".$lang['bu_decline']."</a>";
                                                        foreach($outrequest as $name => $trans){
                                                $displays->assign($name, $trans);
                                            }
                                                }
                                        }else{
                                                if($buddy['sender']==$CurrentUser['id']){
                                                        $myfriends  = $db->query("SELECT `id`, `username`, `galaxy`, `system`, `planet`,`ally_id`, `ally_name`,`onlinetime` FROM {{table}} WHERE `id`='".$buddy[owner]."'","users",true);
                                                }else{
                                                        $myfriends  = $db->query("SELECT `id`, `username`, `galaxy`, `system`, `planet`,`ally_id`, `ally_name`,`onlinetime` FROM {{table}} WHERE `id`='".$buddy[sender]."'","users",true);
                                                }

                                                $myfriendsnum++;

                                                if($myfriendsnum==1){
                                                        $displays->newBlock("buddy");
                                                        $parse["tipo"]=$lang['bu_partners'];
                                                        $parse["texts1"]=$lang['bu_estate'];
                                                        foreach($parse as $name => $trans){
                                                            $displays->assign($name, $trans);
                                                        }
                                                }
                                                $displays->newBlock("listbuddy");
                                                if($myfriends["onlinetime"] + (60 * 10) >= time()){
                                                        $myfriends["color"]="lime";
                                                        $myfriends["texts2"]=$lang['bu_connected'];
                                                }elseif($myfriends["onlinetime"] + (60 * 20) >= time()){
                                                        $myfriends["color"]="yellow";
                                                        $myfriends["texts2"]=$lang['bu_fifteen_minutes'];
                                                }else{
                                                        $myfriends["color"]="red";
                                                        $myfriends["texts2"]=$lang['bu_disconnected'];
                                                }
                                                $myfriends["actions"]="<a href=game.php?page=buddy&mode=1&sm=1&bid=".$buddy[id].">".$lang['bu_delete']."</a>";
                                                foreach($myfriends as $name => $trans){
                                                    $displays->assign($name, $trans);
                                                }
                                        }
					
				}
				if(!$i){
					$displays->newBlock("anuncio");
				}
			$displays->display ();

		break;
	}
}
?>