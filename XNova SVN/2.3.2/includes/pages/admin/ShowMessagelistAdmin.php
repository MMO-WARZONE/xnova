<?php
//version 1

function ShowMessagelistAdmin($user){
	global $lang,$db,$displays;
if ($user['authlevel'] < 2) die($displays->message ($lang['not_enough_permissions']));

	$Prev       = ( !empty($_POST['prev'])   ) ? true : false;
	$Next       = ( !empty($_POST['next'])   ) ? true : false;
	$DelSel     = ( !empty($_POST['delsel']) ) ? true : false;
	$DelDat     = ( !empty($_POST['deldat']) ) ? true : false;
	$CurrPage   = ( !empty($_POST['curr'])   ) ? $_POST['curr'] : 1;
	$Selected   = ( !empty($_POST['sele'])   ) ? $_POST['sele'] : 0;
	$SelType    = $_POST['type'];
	$SelPage    = $_POST['page'];

	$ViewPage = 1;
	if ( $Selected != $SelType )
	{
		$Selected = $SelType;
		$ViewPage = 1;
	}
	elseif ( $CurrPage != $SelPage )
	{
		$ViewPage = ( !empty($SelPage) ) ? $SelPage : 1;
	}

	if($Prev   == true)
	{
		$CurrPage -= 1;
		if ($CurrPage >= 1){
			$ViewPage = $CurrPage;
		}
		else{
			$ViewPage = 1;
		}
	}
	elseif ($Next   == true)
	{
		$Mess      = $db->query("SELECT COUNT(*) AS `max` FROM {{table}} WHERE `message_type` = '". $Selected ."';", 'messages', true);
		$MaxPage   = ceil ( ($Mess['max'] / 25) );
		$CurrPage += 1;
		if ($CurrPage <= $MaxPage){
			$ViewPage = $CurrPage;
		}
		else{
			$ViewPage = $MaxPage;
		}
	}
	elseif ($DelSel == true)
	{
		foreach($_POST['sele'] as $MessId => $Value)
		{
			if ($Value == "on"){
				$db->query ( "DELETE FROM {{table}} WHERE `message_id` = '". $MessId ."';", 'messages');
		
                        }
                }
	} elseif ($DelDat == true)
	{
		$SelDay    = $_POST['selday'];
		$SelMonth  = $_POST['selmonth'];
		$SelYear   = $_POST['selyear'];
		$LimitDate = mktime (0,0,0, $SelMonth, $SelDay, $SelYear );
		if ($LimitDate != false)
		{
			$db->query ( "DELETE FROM {{table}} WHERE `message_time` <= '". $LimitDate ."';", 'messages');
			$db->query ( "DELETE FROM {{table}} WHERE `time` <= '". $LimitDate ."';", 'rw');
		}
	}

	$Mess     = $db->query("SELECT COUNT(*) AS `max` FROM {{table}} WHERE `message_type` = '". $Selected ."';", 'messages', true);
	$MaxPage  = ceil ( ($Mess['max'] / 25) );

	$lang['mlst_data_page']    = $ViewPage;
	$lang['mlst_data_pagemax'] = $MaxPage;
	$lang['mlst_data_sele']    = $Selected;
	$lang['mlst_data_types']   = "<option value=\"0\"".  (($Selected == "0")  ? " SELECTED" : "") .">".$lang['mg_type'][0]."</option>";
	$lang['mlst_data_types']  .= "<option value=\"1\"".  (($Selected == "1")  ? " SELECTED" : "") .">".$lang['mg_type'][1]."</option>";
	$lang['mlst_data_types']  .= "<option value=\"2\"".  (($Selected == "2")  ? " SELECTED" : "") .">".$lang['mg_type'][2]."</option>";
	$lang['mlst_data_types']  .= "<option value=\"3\"".  (($Selected == "3")  ? " SELECTED" : "") .">".$lang['mg_type'][3]."</option>";
	$lang['mlst_data_types']  .= "<option value=\"4\"".  (($Selected == "4")  ? " SELECTED" : "") .">".$lang['mg_type'][4]."</option>";
	$lang['mlst_data_types']  .= "<option value=\"5\"".  (($Selected == "5")  ? " SELECTED" : "") .">".$lang['mg_type'][5]."</option>";
	$lang['mlst_data_types']  .= "<option value=\"15\"". (($Selected == "15") ? " SELECTED" : "") .">".$lang['mg_type'][15]."</option>";
	$lang['mlst_data_types']  .= "<option value=\"99\"". (($Selected == "99") ? " SELECTED" : "") .">".$lang['mg_type'][99]."</option>";

	$lang['mlst_data_pages']   = "";

	for ( $cPage = 1; $cPage <= $MaxPage; $cPage++ )
	{
		$lang['mlst_data_pages'] .= "<option value=\"".$cPage."\"".  (($ViewPage == $cPage)  ? " SELECTED" : "") .">". $cPage ."/". $MaxPage ."</option>";
	}

	$StartRec       = 1 + (($ViewPage - 1) * 25);
	$Messages       = $db->query("SELECT m.*, u.id ,u.username
				FROM {{table}}messages as m INNER JOIN {{table}}users as u
				ON m.message_type = '". $Selected ."'
				AND u.id=m.message_owner
				ORDER BY m.message_time DESC LIMIT ". $StartRec .",25;", '');

        $displays->assignContent("adm/messagelist_body");
	while ($row = mysql_fetch_assoc($Messages)){
		$displays->newblock("lista_mensajes");

		$row['mlst_id']      = $row['message_id'];
		$row['mlst_from']    = $row['message_from'];
		$row['mlst_to']      = $row['username'] ." ID:". $row['message_owner'];
		$row['mlst_text']    = $row['message_text'];
		$row['mlst_time']    = gmdate ("d/M/y H:i:s", $row['message_time'] );

            foreach($row as $key => $value){
                $displays->assign($key,$value);
            }
        }
	
	$displays->display();
}
?>