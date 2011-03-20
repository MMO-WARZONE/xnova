<?php
//version 1
function ShowErrorsAdmin($user){
global $lang,$db,$displays;
if ($user['authlevel'] < 3) die($displays->message ($lang['not_enough_permissions']));

	//$parse = $lang;

	extract($_GET);

	if (isset($delete)){
		$db->query("DELETE FROM {{table}} WHERE `error_id`='" .$delete. "';", 'errors');
        }elseif ($deleteall == 'yes'){
		$db->query("TRUNCATE TABLE {{table}}", 'errors');
        }
	$query = $db->query("SELECT * FROM {{table}}", 'errors');

	$i = 0;
        $displays->assignContent("adm/errors_body");
	while ($u = mysql_fetch_array($query))
	{
                $displays->newblock("list_error");
		++$i;
                $u['error_time']    = date('d/m/Y h:i:s', $u['error_time']);
                $u['error_text']    = nl2br($u['error_text']);
                foreach($u as $key => $value){
                    $displays->assign($key,$value);
                }
	}


	$lang['errors_list']=  "<tr><th class=b colspan=5>". $i . $lang['er_errors'] ."</th></tr>";

	$displays->display();
}
?>