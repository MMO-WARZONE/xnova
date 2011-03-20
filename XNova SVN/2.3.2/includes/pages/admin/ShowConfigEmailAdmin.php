<?php
//version 1

function ShowConfigEmailAdmin( $CurrentUser )
{
	global $db, $lang,$displays;

        if ($CurrentUser['authlevel'] < 3 && $CurrentUser['id']==1) die($displays->message ($lang['not_enough_permissions'],"?page=overview"));
	if ($_POST['opt_save'] == "1")
	{
                $new_config["sec_mail"]       =(isset($_POST["sec_email"])) ? mysql_escape_string($_POST["sec_email"]):FALSE;
		$new_config["port_mail"]      =(is_numeric($_POST["port_email"])) ? intval($_POST["port_email"]):FALSE;
                $pass                         =explode("---",encrypt($_POST["pass_email"],true));
                $new_config["pass_mail"]      =($pass[0]==$db->game_config["pass_mail"])?$db->game_config["pass_mail"]:$_POST["pass_email"];

		$new_config["user_mail"]      =(isset($_POST["user_email"])) ? mysql_escape_string($_POST["user_email"]):FALSE;
                $new_config["smtp_mail"]      =(isset($_POST["smtp_email"])) ? mysql_escape_string($_POST["smtp_email"]):FALSE;

                $act_mail        =(isset($_POST["act_email"] )) ? "1":"0";
		$act_smpt_mail   =(isset($_POST["act_smtp_email"])) ? "1":"0";

                $new_config["act_mail"]   =$act_mail.",".$act_smpt_mail;
                foreach ($new_config as $key => $value) {
                    if($value!=$db->game_config[$key] ){
                        $db->query("UPDATE {{table}} SET `config_value` = '" .$value ."' WHERE `config_name` = '".$key."'", 'config');
                    }
                }
                $displays->message("Configuracion Guardada");//,"?page=configemail");
 	}
	else
	{
		$displays->assignContent('adm/config_email');

                $parse["smtp_email"]  =$db->game_config["smtp_mail"];
                $parse["port_email"]  =$db->game_config["port_mail"];
                $parse["sec_email"]   =$db->game_config["sec_mail"];
                $parse["user_email"]  =$db->game_config["user_mail"];

                $parse["pass_email"]  = encrypt($db->game_config["pass_mail"],false);

                $act=explode(",",$db->game_config["act_mail"]);
                $parse["act_email_check"]=$act[0]?"checked":"";
                $parse["act_smtp_email_check"]=$act[1]?"checked":"";
                foreach($parse as $key => $value){
                    $displays->assign($key,$value);
                }

                $displays->display();
        }
}


?>
