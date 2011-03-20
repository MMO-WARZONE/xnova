<?php
//version 1.1


function ShowMessallAdmin($user){
	global $lang,$svn_root,$db,$users, $displays;
if ($user['authlevel'] < 2) die($displays->message ($lang['not_enough_permissions']));

     $parse 	= $lang;

	if ($_POST && $_GET['mode'] == "change")
	{
		if ($user['authlevel'] == 3)
		{
			$kolor = 'red';
			$ranga = $lang['user_level'][3];
		}

		elseif ($user['authlevel'] == 2)
		{
			$kolor = 'skyblue';
			$ranga = $lang['user_level'][2];
		}

		elseif ($user['authlevel'] == 1)
		{
			$kolor = 'yellow';
			$ranga = $lang['user_level'][1];
		}
		if ((isset($_POST["tresc"]) && $_POST["tresc"] != '') && (isset($_POST["temat"]) && $_POST["temat"] != ''))
		{
			$sq      	= $db->query("SELECT `id`,`username`,`email_2` FROM {{table}} ORDER BY `id` ASC", "users");
			$Time    	= time();
			$From    	= "<font color=". $kolor .">". $ranga ." ".$user['username']."</font>";
			$Subject 	= "<font color=". $kolor .">". $_POST['temat'] ."</font>";
			$Message 	= "<font color=". $kolor ."><b>". $_POST['tresc'] ."</b></font>";
			$summery	= 0;
                        $url=dirname("http://". $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'])."/";

			while ($u = mysql_fetch_array($sq))
			{
                                        $Message_new = str_replace(":name:",$u['username'],$Message);
                                        $siteurlactivationlink = $url.'activate.php?hash='. urlencode(encrypt($u['username'])).'&stamp='. urlencode(encrypt($u['id']));
                                        $Message_new = str_replace(":link_acti:","<a href=\'{$siteurlactivationlink}\'> Link de Activación </a>",$Message);

                                        $users->SendSimpleMessage ( $u['id'], $user['id'], $Time, 1, $From, $Subject, $Message_new);


			}
			$displays->message($lang['ma_message_sended'], "?page=messall", 3);
			                         		}
		else
		{
			$displays->message($lang['ma_subject_needed'], "?page=messall", 3);
		}
	}else{

				$displays->assignContent('adm/messall_body');
			
      		                $displays->display();

	}
}
?>