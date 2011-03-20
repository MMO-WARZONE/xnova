<?php
//version 1
function ShowIplogAdmin($user){
	global $lang, $db, $displays;;
if ($user['authlevel'] < 2) die($displays->message($lang['not_enough_permissions']));


				$displays->assignContent('adm/iplog');

     if (isset($_GET['iplog']))
     {
     	switch($_GET['iplog'])
	{
		case'iplog':

                        $search = $_GET['value'];
                        $SelIplog = $db->query("SELECT * FROM {{table}} WHERE (`userid` == '". $search ."') OR (`username` == '". $search ."') OR (`user_ip` == '". $search ."');", 'iplog', true);
			$mode      = $_POST['edit'];

                        $lang['id']          = $SelIplog['id'];
                        $lang['userid']      = $SelIplog['userid'];
			$lang['username']    = $SelIplog['username'];
			$lang['user_ip']     = $SelIplog['user_ip'];
			$lang['date']        = date($SelIplog['date']);



				$displays->assignContent('adm/iplogsearch');
			
      		                $displays->display();

		break;
		
	}
     }
      		                $displays->display();
}
?>
