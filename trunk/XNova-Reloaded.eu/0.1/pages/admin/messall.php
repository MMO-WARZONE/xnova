<?php //Dr.Isaacs - XNova.de

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);

if ($user['authlevel'] >= 1) 
	{
		if ($_POST && $_GET['mode'] == "change")
			{
				if ($user['authlevel'] == 3) 
					{
						$kolor = 'red';
						$ranga = 'Administrator';
					}
				elseif ($user['authlevel'] == 2)
					{
						$kolor = 'yellow';
						$ranga = 'SuperGameOperator';
					}
				elseif ($user['authlevel'] == 1)
					{
						$kolor = 'skyblue';
						$ranga = 'GameOperator';
					}

					if ((isset($_POST["text"]) && $_POST["text"] != '') && (isset($_POST["temat"]) && $_POST["temat"] != '')) 
						{
							$sq		 = $DB->query("SELECT `id` FROM ".PREFIX."users");
							$Time    = time();
							$From    = "<font color=\"". $kolor ."\">". $ranga ." ".$user['username']."</font>";
							$Subject = "<font color=\"". $kolor ."\">". $_POST['temat'] ."</font>";
							$Message = "<font color=\"". $kolor ."\"><b>". $_POST['text'] ."</b></font>";
							
							while ($u = $sq->fetch(PDO::FETCH_ASSOC))
								{
									SendSimpleMessage ( $u['id'], $user['id'], $Time, 1, $From, $Subject, $Message);
								}
							message("<font color=\"lime\">Deine Nachricht wurde an alle Spieler gesendet!</font><meta http-equiv=\"refresh\" content=\"3; url=?action=administrativeHome\">", "Gesendet");
						} 
					else 
						{
							message("<font color=\"red\">Du hast kein Betreff angegeben!</font><meta http-equiv=\"refresh\" content=\"3; url=?action=administrativeMessageToAll\">", "Fehler");
						}
			} 
		else 
			{
				$parse 			= $game_config;
				$parse['dpath'] = $dpath;
				$parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":'';
				$page .= parsetemplate(gettemplate('admin/messall_body'), $parse);
				display($page, '', false,'', true);
			}
	} 
else
	{
		message($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}
?>