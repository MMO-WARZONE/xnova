<?php
//version 1
if (!defined('INSIDE')){die("Intento de hackeo");}
class ShowOptionsPages
{
	private function CheckIfIsBuilding($CurrentUser)
	{
            global $db;
		$query = $db->query("SELECT b_building,b_tech,b_hangar FROM {{table}} WHERE id_owner = '{$CurrentUser['id']}'", 'planets');

		while($id = mysql_fetch_assoc($query))
		{
			if($id['b_building'] != 0 && $id['b_building'] != "")
			{
				return true;
			}
			elseif($id['b_tech'] != 0 && $id['b_tech'] != "")
			{
				return true;
			}elseif($id['b_hangar'] != 0 && $id['b_hangar'] != "")
                        {
				return true;
			}
		}
		$fleets = $db->query("SELECT count(id) as count FROM {{table}} WHERE `fleet_owner` = '{$CurrentUser['id']}'", 'fleets',true);
		if($fleets["count"] != 0){
			return true;
		}

		return false;
	}

	public function ShowOptionsPage($CurrentUser)
	{
		global  $db, $dpath, $lang,$svn_root,$displays;
                $act_mail=explode(",",$db->game_config["act_mail"]);
		$mode = $_GET['mode'];
		if ($mode == "activar" && $CurrentUser["activate_status"]=="0" && $act_mail[0]==1){
			$url=dirname("http://". $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'])."/";
			$siteurlactivationlink = $url.'activate.php?hash='. urlencode(encrypt($CurrentUser['username'])).'&stamp='. urlencode(encrypt($CurrentUser['id']));
			
			$body =$lang["op_confirmation"];
			$body=preg_replace("(:server:)",$db->game_config["game_name"], $body);
			$body=preg_replace("(:url_link:)",$siteurlactivationlink, $body);
                        $body=preg_replace("(:username:)",$CurrentUser['username'], $body);
                        $body=preg_replace("({pass})","", $body);
			include($svn_root.'includes/functions/classes/class.phpmailer.php');
			$mail             = new PHPMailer();
                        $mail->ContentType = "text/html";
                        $mail->CharSet = "utf-8";
                        $user_mail=$db->game_config["user_mail"]."@".$db->game_config["smtp_mail"];
			if($act_mail[1]==1){              
                            $smtp_mail="mail.".$db->game_config["smtp_mail"];
                            $smtp_mail_2="smtp.".$db->game_config["smtp_mail"];
                            $mail->IsSMTP(); // telling the class to use SMTP
                            $mail->Host       = $smtp_mail; 	// SMTP server
                            $mail->SMTPAuth   = true;               // enable SMTP authentication
                            $mail->SMTPSecure = $db->game_config['sec_mail'];              // sets the prefix to the servier
                            $mail->Host       = $smtp_mail_2; 	// SMTP server
                            $mail->Port       = $db->game_config["port_mail"];                // set the SMTP port for the GMAIL server
                            $mail->Username   = $user_mail;  // GMAIL username
                            $mail->Password   = $db->game_config["pass_mail"];        // GMAIL password
                        }
                        $mail->SetFrom($user_mail, $db->game_config["game_name"]);
                        $mail->AddAddress($CurrentUser['email'], $CurrentUser['username']);
                        if($CurrentUser['email_2']!=$CurrentUser['email']){
                            $mail->AddAddress($CurrentUser['email_2'], $CurrentUser['username']);
                        }

                        $mail->Subject    = "Link de Activacion de la cuenta.";

                        $mail->MsgHTML($body);
                        if($mail->Send()){
                            $displays->message("Se ha enviado correctamente el link de activacion al siguiente mail: " .$CurrentUser['email_2']);
                        }else{
                           $displays->message("ERROR EN EL ENVIO : " .$CurrentUser['email_2']);

                        }
			
		}
		
		if ($_POST && $mode == "exit")
		{
			if (isset($_POST["exit_modus"]) && $_POST["exit_modus"] == 'on' and $CurrentUser['urlaubs_until'] <= time())
			{
				$urlaubs_modus = "0";

				$db->query("UPDATE {{table}} SET
				`urlaubs_modus` = '0',
				`urlaubs_until` = '0'
				WHERE `id` = '".$CurrentUser['id']."' LIMIT 1", "users");

				die(header("location:game.php?page=options"));
			}else{
				$urlaubs_modus = "1";
				die(header("location:game.php?page=options"));
			}
		}

		if ($_POST && $mode == "change")
		{
			if ($CurrentUser['authlevel'] > 0)
			{
				if ($_POST['adm_pl_prot'] == 'on'){
					$db->query ("UPDATE {{table}} SET `id_level` = '".$CurrentUser['authlevel']."' WHERE `id_owner` = '".$CurrentUser['id']."';", 'planets');
				}else{
					$db->query ("UPDATE {{table}} SET `id_level` = '0' WHERE `id_owner` = '".$CurrentUser['id']."';", 'planets');
				}
			}
			// <  EL SKIN  >
			if (isset($_POST["design"]) && $_POST["design"] == 'on')
			{
				$design = "1";
			}else{
				$design = "0";
			}
			// < - COMPROBACION DE IP - >
			if (isset($_POST["noipcheck"]) && $_POST["noipcheck"] == 'on')
			{
				$noipcheck = "1";
			}else{
				$noipcheck = "0";
			}
			// < - NOMBRE DE USUARIO - >
			if (isset($_POST["db_character"]) && $_POST["db_character"] != '')
			{
				$username = mysql_escape_string ( $_POST['db_character'] );
			}else{
				$username = $CurrentUser['username'];
			}
			// < - DIRECCION DE EMAIL - >

			if (isset($_POST["db_email"]) && $_POST["db_email"] != '')
			{
				$db_email = mysql_escape_string ( $_POST['db_email'] );
			}else{
				$db_email = $CurrentUser['email'];
			}
			// < - CANTIDAD DE SONDAS - >
			if (isset($_POST["spio_anz"]) && is_numeric($_POST["spio_anz"]))
			{
				$spio_anz = $_POST["spio_anz"];
			}else{
				$spio_anz = "1";
			}
			// < - TIEMPO TOOLTIP - >
			if (isset($_POST["settings_tooltiptime"]) && is_numeric($_POST["settings_tooltiptime"]))
			{
				$settings_tooltiptime = $_POST["settings_tooltiptime"];
			}else{
				$settings_tooltiptime = "1";
			}
			// < - MENSAJES DE FLOTAS - >
			if (isset($_POST["settings_fleetactions"]) && is_numeric($_POST["settings_fleetactions"]))
			{
				$settings_fleetactions = $_POST["settings_fleetactions"];
			}else{
				$settings_fleetactions = "1";
			}
			// <  SONDAS DE ESPIONAJE  >
			if (isset($_POST["settings_esp"]) && $_POST["settings_esp"] == 'on')
			{
				$settings_esp = "1";
			}else{
				$settings_esp = "0";
			}
			// <  ESCRIBIR MENSAJE  >
			if (isset($_POST["settings_wri"]) && $_POST["settings_wri"] == 'on')
			{
				$settings_wri = "1";
			}else{
				$settings_wri = "0";
			}
			// <  A�ADIR A LISTA DE AMIGOS  >
			if (isset($_POST["settings_bud"]) && $_POST["settings_bud"] == 'on')
			{
				$settings_bud = "1";
			}else{
				$settings_bud = "0";
			}
			// <  ATAQUE CON MISILES  >
			if (isset($_POST["settings_mis"]) && $_POST["settings_mis"] == 'on')
			{
				$settings_mis = "1";
			}else{
				$settings_mis = "0";
			}
			// <  VER REPORTE  >
			if (isset($_POST["settings_rep"]) && $_POST["settings_rep"] == 'on')
			{
				$settings_rep = "1";
			}else{
				$settings_rep = "0";
			}
			// <  MODO VACACIONES  >
			if (isset($_POST["urlaubs_modus"]) && $_POST["urlaubs_modus"] == 'on')
			{
				if($this->CheckIfIsBuilding($CurrentUser))
				{
					$displays->message($lang['op_cant_activate_vacation_mode'], "game.php?page=options",1);
				}

				$urlaubs_modus = "1";
				$time = time() + 60*60*2; //2 dias de vacaciones
				$db->query("UPDATE {{table}} SET
				`urlaubs_modus` = '$urlaubs_modus',
				`urlaubs_until` = '$time'
				WHERE `id` = '".$CurrentUser["id"]."' LIMIT 1", "users");


                                $db->query("UPDATE {{table}} SET
                                metal_perhour = '".$db->game_config['metal_basic_income']."',
                                crystal_perhour = '".$db->game_config['metal_basic_income']."',
                                deuterium_perhour = '".$db->game_config['metal_basic_income']."',
                                energy_used = '0',
                                energy_max = '0',
                                metal_mine_porcent = '0',
                                crystal_mine_porcent = '0',
                                deuterium_sintetizer_porcent = '0',
                                solar_plant_porcent = '0',
                                fusion_plant_porcent = '0',
                                solar_satelit_porcent = '0'
                                WHERE id_owner = '{$id['id']}' AND `planet_type` = 1 ", 'planets');
				
			}else{
				$urlaubs_modus = "0";
                        }


                        if(isset($_POST["avatar"]) && $_POST["avatar"] != ""){ $avatar=$_POST["avatar"]; }else{ $avatar=""; }

			// <  BORRAR CUENTA  >
			if (isset($_POST["db_deaktjava"]) && $_POST["db_deaktjava"] == 'on')
			{
				$db_deaktjava = time()+7*60*60*24;
				
			}else{
				$db_deaktjava 	= "0";
				
			}

			$SetSort  = mysql_escape_string($_POST['settings_sort']);
			$SetOrder = mysql_escape_string($_POST['settings_order']);

                        if($_POST["dpath"]!=(DEFAULT_SKINPATH_FOLDER.$_POST["skins"]."/") && $_POST["dpath"]!='' && $_POST["skins"]==''){
				$dpath=mysql_escape_string($_POST["dpath"]);
			}elseif($_POST["skins"]!=''){
				$dpath=DEFAULT_SKINPATH_FOLDER.mysql_escape_string($_POST["skins"])."/";
                        }else{
				$dpath=DEFAULT_SKINPATH;
			}
                        // < ACTUALIZAR TODO LO SETEADO ANTES >
			$db->query("UPDATE {{table}} SET
			`email` = '$db_email',
			`dpath` = '$dpath',
			`design` = '$design',
			`noipcheck` = '$noipcheck',
			`planet_sort` = '$SetSort',
			`planet_sort_order` = '$SetOrder',
			`spio_anz` = '$spio_anz',
			`settings_tooltiptime` = '$settings_tooltiptime',
			`settings_fleetactions` = '$settings_fleetactions',
                        `settings_allylogo` = '$settings_allylogo',
			`settings_esp` = '$settings_esp',
			`settings_wri` = '$settings_wri',
			`settings_bud` = '$settings_bud',
			`settings_mis` = '$settings_mis',
			`settings_rep` = '$settings_rep',
			`urlaubs_modus` = '$urlaubs_modus',
			`db_deaktjava` = '$db_deaktjava'
			WHERE `id` = '".$CurrentUser["id"]."' LIMIT 1", "users");
			// < - CAMBIO DE CLAVE - >
			if (isset($_POST["db_password"]) && md5($_POST["db_password"]) == $CurrentUser["password"])
			{
				if ($_POST["newpass1"] == $_POST["newpass2"])
				{
					if ($_POST["newpass1"] != "")
					{
						$newpass = md5($_POST["newpass1"]);
						$db->query("UPDATE {{table}} SET `password` = '{$newpass}' WHERE `id` = '{$CurrentUser['id']}' LIMIT 1", "users");
						setcookie(COOKIE_NAME, "", time()-100000, "/", "", 0);
						$displays->message($lang['op_password_changed'],"index.php",1);
					}
				}
			}
			$displays->message($lang['op_options_changed'], "game.php?page=options", 1);
		}else{

                        $displays->assignContent("options/options");
			$parse['dpath'] = $dpath;

			if($CurrentUser['urlaubs_modus'])
			{
                                $displays->newblock("vacaciones");
				$parse['opt_modev_data'] = ($CurrentUser['urlaubs_modus'] == 1)?" checked='checked'/":'';
				$parse['opt_modev_exit'] = ($CurrentUser['urlaubs_modus'] == 0)?" checked='1'/":'';
				$parse['vacation_until'] = date("d.m.Y G:i:s",$CurrentUser['urlaubs_until']);

                                foreach($parse as $name => $trans){
                                    $displays->assign($name, $trans);
                                }
                        }
			else
			{
                            $displays->newblock("options");
				if ($CurrentUser['authlevel'] > 0)
				{
                                        $displays->newBlock("adm_frame");
					$IsProtOn = $db->query ("SELECT `id_level` FROM {{table}} WHERE `id_owner` = '".$CurrentUser['id']."' LIMIT 1;", 'planets', true);
					$trans   = ($IsProtOn['id_level'] > 0) ? " checked='checked'/":'';
					$displays->assign('adm_pl_prot_data', $trans);
                                }
                                $displays->gotoblock("options");
                                $parse['opt_lst_ord_data']   = "<option value =\"0\"". (($CurrentUser['planet_sort'] == 0) ? " selected": "") .">Fecha de colonizaci&oacute;n</option>";
				$parse['opt_lst_ord_data']  .= "<option value =\"1\"". (($CurrentUser['planet_sort'] == 1) ? " selected": "") .">Coordenadas</option>";
				$parse['opt_lst_ord_data']  .= "<option value =\"2\"". (($CurrentUser['planet_sort'] == 2) ? " selected": "") .">Orden alfab&eacute;tico</option>";
				$parse['opt_lst_cla_data']   = "<option value =\"0\"". (($CurrentUser['planet_sort_order'] == 0) ? " selected": "") .">Creciente</option>";
				$parse['opt_lst_cla_data']  .= "<option value =\"1\"". (($CurrentUser['planet_sort_order'] == 1) ? " selected": "") .">Decreciente</option>";

                                
				$SkinsFolder = opendir('./styles/skins/');
				while (($SkinSubFolder = readdir($SkinsFolder)) !== false)
				{
					if($SkinSubFolder != '.' && $SkinSubFolder != '..' && $SkinSubFolder != '.htaccess' && $SkinSubFolder!= 'index.htm')
					{
						$parse['skins'] .= "<option ";
						if($CurrentUser['dpath'] == (DEFAULT_SKINPATH_FOLDER.$SkinSubFolder."/")){
							$parse['skins'] .= "selected = selected";
						}
						$parse['skins'] .= " value='".$SkinSubFolder."'>".$SkinSubFolder."</option>";
					}
				}
				$parse['opt_usern_data'] = $CurrentUser['username'];
				$parse['opt_mail1_data'] = $CurrentUser['email'];
				$parse['opt_mail2_data'] = $CurrentUser['email_2'];
				if($CurrentUser["activate_status"]!="1" && $act_mail[0]==1){
					$parse["activate_status"]="<th colspan=2><a href='".$svn_root."game.php?page=options&mode=activar'>Activar Cuenta</a></th>";
				}else{
					$parse["activate_status"]="<th>".$lang['op_permanent_email_adress']."</th>
					<th>".$parse['opt_mail2_data']."</th>";
				}

                    
				$parse['opt_dpath_data'] = $CurrentUser['dpath'];
				$parse['opt_probe_data'] = $CurrentUser['spio_anz'];
				$parse['opt_toolt_data'] = $CurrentUser['settings_tooltiptime'];
				$parse['opt_fleet_data'] = $CurrentUser['settings_fleetactions'];
				$parse['opt_sskin_data'] = ($CurrentUser['design'] == 1) ? " checked='checked'":'';
				$parse['opt_noipc_data'] = ($CurrentUser['noipcheck'] == 1) ? " checked='checked'":'';
				$parse['opt_allyl_data'] = ($CurrentUser['settings_allylogo'] == 1) ? " checked='checked'/":'';
				$parse['opt_delac_data'] = ($CurrentUser['db_deaktjava'] == 1) ? " checked='checked'/":'';
				$parse['user_settings_rep'] = ($CurrentUser['settings_rep'] == 1) ? " checked='checked'/":'';
				$parse['user_settings_esp'] = ($CurrentUser['settings_esp'] == 1) ? " checked='checked'/":'';
				$parse['user_settings_wri'] = ($CurrentUser['settings_wri'] == 1) ? " checked='checked'/":'';
				$parse['user_settings_mis'] = ($CurrentUser['settings_mis'] == 1) ? " checked='checked'/":'';
				$parse['user_settings_bud'] = ($CurrentUser['settings_bud'] == 1) ? " checked='checked'/":'';
                                foreach($parse as $name => $trans){
                                    $displays->assign($name, $trans);
                                }
                        }
                        $displays->display("Opciones");

		}
	}
}
?>