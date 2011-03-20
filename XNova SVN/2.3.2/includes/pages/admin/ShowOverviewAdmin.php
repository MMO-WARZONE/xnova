<?php
//version 1
function ShowOverviewAdmin($user){
	global $lang,$db,$svn_root, $displays;
		if ($user['authlevel'] < 1){ die($displays->message ($lang['not_enough_permissions']));}
                
		if(file_exists($svn_root . 'install/') && defined('IN_ADMIN'))
		{
			$Message	.= "<font color=\"red\">".$lang['ow_install_file_detected']."</font><br/><br/>";
			$error++;
		}

		if(@fopen($svn_root."config.php", "a"))
		{
			$Message	.= "<font color=\"red\">".$lang['ow_config_file_writable']."</font><br/><br/>";
			$error++;
		}

		$Errors = $db->query("SELECT COUNT(*) AS `errors` FROM {{table}};", 'errors', true);

		if($Errors['errors'] != 0)
		{
			$Message	.= "<font color=\"red\">".$lang['ow_database_errors']."</font><br/><br/>";
			$error++;
		}

			update_config("update_version",time());
			include($svn_root.'includes/functions/CheckVersion.php');
                        $time_ini=microtime(true);
                        $updates=new Update_version;
                        $updates->check_ult_modificacion();
                        $updates->check_version();
                        $time_fin=microtime(true);
			//$versionerror=Checkversion();
                        
			if($updates->errors>0){
		                if($updates->versioncreditos){
		                        $error++;
		                        $Message .= "<font color=\"red\">".$updates->versioncreditos."</font><br/><br/>";

		                }elseif($updates->mensajeversion){
		                        $Message .= "<font color=\"red\">".$updates->mensajeversion."</font><br/><br/>";
		                        $error++;
		                }
		        }
 
		if($error != 0){
			$lang['error_message']		=	$Message;
		}
		else{
			$lang['error_message']		= 	$lang['ow_none'];
		}

               
		$displays->assignContent('adm/overview_body', $topnav = true, $menu = true, $admin = true);
                		
                $displays->display();

}
?>