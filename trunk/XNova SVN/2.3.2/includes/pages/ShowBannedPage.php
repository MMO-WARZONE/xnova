<?php
//version 1


if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowBannedPage()
{
	global $displays,$lang,$db;

	$displays->assignContent('banned_body');
	
	$query = $db->query("SELECT * FROM {{table}} ORDER BY `id`;",'banned');

	$i=0;
	if(mysql_num_rows($query)){
		$displays->newBlock("banned");
		while($u = mysql_fetch_array($query))
		{
			$displays->newBlock("listbanned");
			$i++;
			$parse["player"]=$u['who'];
			$parse["reason"]=$u['theme'];
			$parse["from"]=gmdate("d/m/Y G:i:s",$u['time']);
			$parse["until"]=gmdate("d/m/Y G:i:s",$u['longer']);
			$parse["by"]=$u['author'];
			foreach($parse as $name => $trans){
				$displays->assign($name, $trans);
			}
			unset($parse);
		}
	}
	if ($i == 0){
		$parse['banned'] .= "<tr><th class=b colspan=6>".$lang['bn_no_players_banned']."</th></tr>";
	}else{
	  	$parse['banned'] .= "<tr><th class=b colspan=6>".$lang['bn_exists'] . $i . $lang['bn_players_banned']."</th></tr>";
	}
	
	$displays->gotoBlock("_ROOT");
	
	foreach($parse as $name => $trans){
                $displays->assign($name, $trans);
	}
	
	$displays->display();
}
?>