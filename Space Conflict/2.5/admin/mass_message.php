<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** mass_message.php                      **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

function mass_message_run($parent){
	if($_POST["mode"] == "change"){
		if(isset($_POST["tresc"])&& $_POST["tresc"] != ''){
			$game_config['tresc'] = $parent->safe_get_post_var("tresc");
		}
		if(isset($_POST["temat"])&& $_POST["temat"] != ''){
			$game_config['temat'] = $parent->safe_get_post_var("temat");
		}
		$kolor = 'red';
		if($game_config['tresc'] !='' and $game_config['temat']){
			$sq = $parent->db->query("SELECT `id` FROM {{table}}","users");
			while($u = $parent->db->fetch_assoc($sq)){
				doquery("INSERT INTO {{table}} SET
					`message_owner`='{$u['id']}',
					`message_sender`='1' ,
					`message_time`='".time()."',
					`message_type`='0',
					`message_from`='<font color=\"$kolor\">Administracja</font>',
					`message_subject`='<font color=\"$kolor\">{$game_config['temat']}</font>',
					`message_text`='<font color=\"$kolor\"><b>{$game_config['tresc']}</b></font>'
					","messages");
				$parent->db->query("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$u['id']}'",'users');
			}
			$parent->smarty->assign("message","<font color=\"lime\">Wys³a³e¶ wiadomo¶æ do wszystkich graczy</font>");
		}
	}
	$parent->smarty->display("mass_message.tpl");
}

function mass_message_info(){
	return array("name" => "Send MassMessages","description"=>"Sends messagess to all players","default_weight"=>"0");
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>