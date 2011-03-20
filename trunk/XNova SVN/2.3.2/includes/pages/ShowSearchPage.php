<?php
//version 1


if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowSearchPage()
{
	global $dpath, $lang, $db, $displays;

        $displays->assignContent("search/search_body");
	$type 	= $_POST['type'];

	$searchtext = mysql_escape_string($_POST["searchtext"]);

	switch($type)
	{
		case "playername":
			$displays->newblock("user_table");
                        $search = $db->query("SELECT * FROM {{table}} WHERE username LIKE '%{$searchtext}%' LIMIT 30;","users");
		break;
		case "planetname":
			$displays->newblock("user_table");
			$search = $db->query("SELECT * FROM {{table}} WHERE name LIKE '%{$searchtext}%' LIMIT 30",'planets');
		break;
		case "allytag":
		        $displays->newblock("ally_table");
			$search = $db->query("SELECT * FROM {{table}} WHERE ally_tag LIKE '%{$searchtext}%' LIMIT 30","alliance");
		break;
		case "allyname":
			$displays->newblock("ally_table");
			$search = $db->query("SELECT * FROM {{table}} WHERE ally_name LIKE '%{$searchtext}%' LIMIT 30","alliance");
		break;
	}


	if(isset($searchtext) && isset($type))
	{
		while($s = mysql_fetch_array($search, MYSQL_BOTH))
		{
			if($type == 'playername' || $type == 'planetname')
			{
                                 $displays->newblock("user_list");
				if($s['ally_id'] != 0 && $s['ally_request'] == 0)
				{
					$aquery = $db->query("SELECT id,ally_name FROM {{table}} WHERE id = {$s['ally_id']}","alliance",true);
				}
				else
				{
					$aquery = array();
				}

				if ($type == "planetname")
				{
					$pquery 		= $db->query("SELECT username,ally_id,ally_name FROM {{table}} WHERE id = {$s['id_owner']}","users",true);
					$s['planet_name'] 	= $s['name'];
					$s['username'] 		= $pquery['username'];
					$s['ally_name'] 	= ($pquery['ally_name']!='')?"<a href=\"game.php?page=alliance&mode=ainfo&a={$pquery['ally_id']}\">{$pquery['ally_name']}</a>":'';
				}
				else
				{
					$pquery 		= $db->query("SELECT name FROM {{table}} WHERE id = {$s['id_planet']}","planets",true);
					$s['planet_name']	= $pquery['name'];
					$s['ally_name'] 	= ($aquery['ally_name']!='')?"<a href=\"game.php?page=alliance&mode=ainfo&a={$aquery['id']}\">{$aquery['ally_name']}</a>":'';
				}

				$s['position'] 		= "<a href=\"game.php?page=statistics&start=".$s['rank']."\">".$s['rank']."</a>";
				$s['dpath'] 		= $dpath;
				$s['coordinated'] 	= "{$s['galaxy']}:{$s['system']}:{$s['planet']}";
					
                               
                        }
			elseif($type=='allytag'||$type=='allyname')
			{
                                $displays->newblock("ally_list");
				$s['ally_points'] = pretty_number($s['ally_points']);

				$s['ally_tag'] = "<a href=\"game.php?page=alliance&mode=ainfo&tag={$s['ally_tag']}\">{$s['ally_tag']}</a>";
			}

                        foreach ($s as $key => $value) {
                            $displays->assign($key,$value);
                        }
		}
			}
        $displays->gotoBlock("_ROOT");
	$parse['type_playername'] 	= ($_POST["type"] == "playername") ? " SELECTED" : "";
	$parse['type_planetname'] 	= ($_POST["type"] == "planetname") ? " SELECTED" : "";
	$parse['type_allytag'] 		= ($_POST["type"] == "allytag") ? " SELECTED" : "";
	$parse['type_allyname'] 	= ($_POST["type"] == "allyname") ? " SELECTED" : "";
	$parse['searchtext'] 		= $searchtext;
        foreach ($parse as $key => $value) {
              $displays->assign($key,$value);
        }
        $displays->display("Buscar");

}
?>