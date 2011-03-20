<?php
//version 1.01


if(!defined('INSIDE')){ die(header("location:../../"));}

class ShowAlliancesPage
{
	private function bbcode($string)
	{
		$pattern = array(
		    '/ \n/',
		    '/ \r/',
		    '/\[b\](.*?)\[\/b\]/is',
		    '/\[strong\](.*?)\[\/strong\]/is',
		    '/\[i\](.*?)\[\/i\]/is',
		    '/\[u\](.*?)\[\/u\]/is',
		    '/\[s\](.*?)\[\/s\]/is',
		    '/\[url=(.*?)\](.*?)\[\/url\]/ise',
		    '/\[img](.*?)\[\/img\]/ise',
		    '/\[color=(.*?)\](.*?)\[\/color\]/is',
		    '/\[size=(.*?)\](.*?)\[\/size\]/ise'
		);

		$replace = array(
		    '<br/>',
		    '',
		    '<b>\1</b>',
		    '<strong>\1</strong>',
		    '<i>\1</i>',
		    '<span style="text-decoration: underline;">\1</span>',
		    '<span style="text-decoration: line-through;">\1</span>',
		    '$this->urlfix(\'\\1\',\'\\2\')',
		    '$this->imagefix(\'\\1\')',
		    '<span style="color: \1;">\2</span>',
		    '$this->sizefix(\'\\1\',\'\\2\')'
		);

		return preg_replace($pattern, $replace, nl2br(htmlspecialchars(stripslashes($string))));
	}

	private function imagefix($img){
		return '<img src="' . $img . '" />';
	}

	private function urlfix($url, $title){
		$title = stripslashes($title);
		return '<a href="' . $url . '" title="' . $title . '">' . $title . '</a>';
	}

	private function sizefix($size, $text){
		$title = stripslashes($text);
		return '<span style="font-size:' . $size . 'px">' . $title . '</span>';
	}

	private function MessageForm($Title, $Message, $Goto = '', $Button = ' OK ', $TwoLines = false)
	{
		$Form .= "<form action=\"". $Goto ."\" method=\"post\">";
		$Form .= "<table width=\"519\">";
		$Form .= "<tr>";
		$Form .= "<td class=\"c\" colspan=\"2\">". $Title ."</td>";
		$Form .= "</tr><tr>";
		if ($TwoLines == true)
		{
			$Form .= "<th colspan=\"2\">". $Message ."</th>";
			$Form .= "</tr><tr>";
			$Form .= "<th colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"". $Button ."\"></th>";
		}
		else
			$Form .= "<th colspan=\"2\">". $Message ."<input type=\"submit\" value=\"". $Button ."\"></th>";
		$Form .= "</tr>";
		$Form .= "</table>";
		$Form .= "</form>";

		return $Form;
	}

	public function ShowAlliancePage($CurrentUser)
	{

		global $dpath, $phpEx, $lang,$db,$displays,$users;
		 
                $displays->assignContent("alliance/alliance");
//MODO PRINCIPAL
		$mode = $_GET['mode'];
		if (empty($mode))   { unset($mode); }
		// ORDEN ALTERNATIVA "A"
		$a     = intval($_GET['a']);
		if (empty($a))      { unset($a); }
		// ORDEN 1
		$sort1 = intval($_GET['sort1']);
		if (empty($sort1))  { unset($sort1); }
		// ORDEN 2
		$sort2 = intval($_GET['sort2']);
		if (empty($sort2))  { unset($sort2); }
		// ELIMINAR RANGO
		$d = $_GET['d'];
		if ((!is_numeric($d)) || (empty($d) && $d != 0)){unset($d);}
		// EDITAR
		$edit = $_GET['edit'];
		if (empty($edit))unset($edit);
		// ADMIN -> RANGOS -> MIEMBROS
		$rank = intval($_GET['rank']);
		if (empty($rank))unset($rank);
		// ADMIN -> EXPULSAR -> MIEMBROS
		$kick = intval($_GET['kick']);
		if (empty($kick)){unset($kick);}

		$id = intval($_GET['id']);
		if (empty($id)){unset($id);}

		$yes      = $_GET['yes'];
		$allyid   = intval($_GET['allyid']);
		$show     = intval($_GET['show']);
		$sendmail = intval($_GET['sendmail']);
		$t        = $_GET['t'];
		$tag      = mysql_escape_string($_GET['tag']);
		// EN ESTE CASO EL USUARIO SOLO EST� DE VISITA EN LA ALIANZA
		if ($mode == 'ainfo')
		{
			if (isset($tag) && $a == "")
				$allyrow = $db->query("SELECT * FROM {{table}} WHERE ally_tag='{$tag}'", "alliance", true);
			elseif(is_numeric($a) && $a != 0 && $tag == "")
				$allyrow = $db->query("SELECT * FROM {{table}} WHERE id='{$a}'", "alliance", true);
			else
				header("location:game.". $phpEx . "?page=alliance",2);

			if (!$allyrow)
				header("location:game.". $phpEx . "?page=alliance",2);

                        extract($allyrow);
			$displays->newblock("ainfo");
                        if ($ally_image != "")
				$ally_image = "<tr><th colspan=2><img src=\"".$ally_image."\"></td></tr>";

			if ($ally_description != "")
				$ally_description = "<tr><th colspan=2 height=100>".nl2br($this->bbcode($ally_description))."</th></tr>";
			else
				$ally_description = "<tr><th colspan=2 height=100>".$lang['al_description_message']	."</th></tr>";

			if ($ally_web != "")
				$ally_web = "<tr><th>".$lang['al_web_text']."</th><th><a href=\"{$ally_web}\">{$ally_web}</a></th></tr>";

			$parse['ally_description'] 		= $ally_description;
			$parse['ally_image'] 			= $ally_image;
			$parse['ally_web'] 				= $ally_web;
			$parse['ally_member_scount'] 	= $ally_members;
			$parse['ally_name'] 			=$ally_name;
			$parse['ally_tag'] 				= $ally_tag;

			if ($CurrentUser['ally_id'] == 0 && $ally_request_notallow==0){
				$parse['solicitud'] = "<tr><th>".$lang['al_request']."</th><th><a href=\"game.php?page=alliance&mode=apply&amp;allyid=" . $id . "\">".$lang['al_click_to_send_request']."</a></th></tr>";
			}else{
				$parse['solicitud'] = "";
                        }
                        foreach($parse as$key => $value){
                            $displays->assign($key,$value);
                        }
			$displays->display();
		}
		// EN ESTE CASO EL USUARIO NO SE ENCUENTRA AUN EN NINGUNA ALIANZA
		if ($CurrentUser['ally_id'] == 0)
		{	//CREAR ALIANZA
			if ($mode == 'make' && $CurrentUser['ally_request'] == 0)
			{
				if ($yes == 1 && $_POST)
				{
					if (!$_POST['atag']){
						$displays->message($lang['al_tag_required'], "game.php?page=alliance&mode=make",2);
					}

					if (!$_POST['aname']){
						$displays->message($lang['al_name_required'],"game.php?page=alliance&mode=make",2);
					}

					$tagquery = $db->query("SELECT * FROM `{{table}}`
							    WHERE ally_tag='".mysql_escape_string($_POST['atag'])."'
							    OR ally_name='".mysql_escape_string($_POST['aname'])."'", 'alliance', true);

					if ($tagquery){
						$displays->message(str_replace('%s', $_POST['atag'], $lang['al_already_exists']),"game.php?page=alliance&mode=make",2);
					}

					$db->query("INSERT INTO {{table}} SET
					`ally_name`='{$_POST['aname']}',
					`ally_tag`='{$_POST['atag']}' ,
					`ally_owner`='{$CurrentUser['id']}',
					`ally_owner_range`='Lider',
					`ally_members`='1',
					`ally_register_time`=" . time() , "alliance");

					$allyquery = $db->query("SELECT * FROM {{table}} WHERE ally_tag='{$_POST['atag']}'", 'alliance', true);

					$db->query("UPDATE {{table}} SET
					`ally_id`='{$allyquery['id']}',
					`ally_name`='{$allyquery['ally_name']}',
					`ally_register_time`='" . time() . "'
					WHERE `id`='{$CurrentUser['id']}'", "users");
                                       
                                        $displays->message("Alianza creada");
                                }else{
                                        $displays->newblock("fundar");
                                }
				$displays->display();
			}
			//BUSCAR ALIANZA
			if ($mode == 'search' && $CurrentUser['ally_request'] == 0)
			{
				//$page = parsetemplate(gettemplate('alliance/alliance_searchform'), $parse);
                                $displays->newblock("buscar");
				if ($_POST)
				{
					$search = $db->query("SELECT * FROM {{table}} WHERE ally_name LIKE '%{$_POST['searchtext']}%' or ally_tag LIKE '%{$_POST['searchtext']}%' LIMIT 30", "alliance");

					if (mysql_num_rows($search) != 0)
					{
                                                $displays->newblock("buscar_encontrar");
						while ($s = mysql_fetch_array($search))
						{
                                                        $displays->newblock("buscar_encontrado");
                                                        $displays->assign('ally_tag',"<a href=\"game.php?page=alliance&mode=apply&allyid={$s['id']}\">{$s['ally_tag']}</a>");
                                                        $displays->assign('ally_name',$s['ally_name']);
                                                        $displays->assign('ally_members',$s['ally_members']);
                                                }
                            		}
				}
				$displays->display();
			}

			if ($mode == 'apply' && $CurrentUser['ally_request'] == 0)
			{ //SOLICITUDES
                                        if (!is_numeric($_GET['allyid']) || !$_GET['allyid'] || $CurrentUser['ally_request'] != 0 || $CurrentUser['ally_id'] != 0){
						header("location:game.". $phpEx . "?page=alliance",2);
                                        }
					$allyrow = $db->query("SELECT ally_tag,ally_request,ally_request_notallow FROM {{table}} WHERE id='" . intval($_GET['allyid']) . "'", "alliance", true);

                                        ($allyrow['ally_request_notallow'] == 1)?$displays->message($lang['al_alliance_closed'], "game.php?page=alliance",2):"";
					(!$allyrow)?header("location:game.". $phpEx . "?page=alliance",2):"";
                                        Console::logMemory();
					extract($allyrow);
                                        Console::logMemory();
					if ($_POST['enviar'] == $lang['al_applyform_send']){
						$db->query("UPDATE {{table}} SET
							`ally_request`='" . intval($allyid) . "',
							ally_request_text='" . mysql_escape_string(strip_tags($_POST['text'])) . "',
							ally_register_time='" . time() . "' WHERE `id`='" . $CurrentUser['id'] . "'", "users");

						$displays->message($lang['al_request_confirmation_message']);
					}else{
                                            $displays->newblock("solicitud");
                                            $text_apply = ($ally_request) ? $ally_request : $lang['al_default_request_text'];
                                            $lang['allyid'] 			= intval($_GET['allyid']);
                                            $lang['chars_count'] 		= strlen($text_apply);
                                            $lang['text_apply'] 		= $text_apply;
                                            $lang['Write_to_alliance'] = str_replace('%s', $ally_tag, $lang['al_write_request']);
                                        }
					$displays->display();

			}

			if ($CurrentUser['ally_request'] != 0)
			{
				$allyquery = $db->query("SELECT ally_tag FROM {{table}} WHERE id='" . intval($CurrentUser['ally_request']) . "' ORDER BY `id`", "alliance", true);
				extract($allyquery);
                                $displays->newblock("esp_solicitud");
				if ($_POST['bcancel'])
				{
					$db->query("UPDATE {{table}} SET `ally_request`=0 WHERE `id`=" . $CurrentUser['id'], "users");
                                    	$lang['request_text'] = str_replace('%s', $ally_tag, $lang['al_request_deleted']);
					$lang['button_text'] = $lang['al_continue'];
				}
				else
				{
					$lang['request_text'] = str_replace('%s', $ally_tag, $lang['al_request_wait_message']);
					$lang['button_text'] = $lang['al_delete_request'];
                                }

				$displays->display();
			}
			else
			{
                                $displays->newblock("default");
                                $displays->display();
			}
		}
		elseif ($CurrentUser['ally_id'] != 0 && $CurrentUser['ally_request'] == 0) // CUANDO YA ESTA EN UNA ALIANZA
		{
			$ally = $db->query("SELECT * FROM {{table}} WHERE id='{$CurrentUser['ally_id']}'", "alliance", true);
			$ally_ranks = unserialize($ally['ally_ranks']);
                        Console::logMemory();
                        if($ally['ally_owner'] == $CurrentUser['id']){
                            $user_can_watch_memberlist = true;
                            $user_can_send_mails = true;
                            $user_can_kick = true;
                            $user_can_edit_rights = true;
                            $user_can_exit_alliance = true;
                            $user_bewerbungen_einsehen = true;
                            $user_bewerbungen_bearbeiten = true;
                            $user_admin = true;
                            $user_onlinestatus = true;
                        }else{
                            $user_can_watch_memberlist_status= ($ally_ranks[$CurrentUser['ally_rank_id']-1]['onlinestatus'] == 1)?true:false;
                            $user_can_watch_memberlist = ($ally_ranks[$CurrentUser['ally_rank_id']-1]['memberlist'] == 1)?true:false;
                            $user_can_send_mails = ($ally_ranks[$CurrentUser['ally_rank_id']-1]['mails'] == 1 )?true:false;
                            $user_can_kick =($ally_ranks[$CurrentUser['ally_rank_id']-1]['kick'] == 1 )?true:false;
                            $user_can_edit_rights=($ally_ranks[$CurrentUser['ally_rank_id']-1]['rechtehand'] == 1)?true:false;
                            $user_can_exit_alliance=($ally_ranks[$CurrentUser['ally_rank_id']-1]['delete'] == 1)?true:false;
                            $user_bewerbungen_einsehen=($ally_ranks[$CurrentUser['ally_rank_id']-1]['bewerbungen'] == 1)?true:false;
                            $user_bewerbungen_bearbeiten =($ally_ranks[$CurrentUser['ally_rank_id']-1]['bewerbungenbearbeiten'] == 1)?true:false;
                            $user_admin =($ally_ranks[$CurrentUser['ally_rank_id']-1]['administrieren'] == 1)?true:false;
                            $user_onlinestatus =($ally_ranks[$CurrentUser['ally_rank_id']-1]['onlinestatus'] == 1 )?true:false;
                        }

                        
			if (!$ally)
			{
				$db->query("UPDATE `{{table}}` SET `ally_id` = 0 WHERE `id` = ".$CurrentUser['id']."", "users");
				header("location:game.". $phpEx . "?page=alliance",2);
			}
                         Console::logMemory();
			//SALIR DE LA ALIANZA 
			if ($mode == 'exit')
			{
				if ($ally['ally_owner'] == $CurrentUser['id'])
					$displays->message($lang['al_founder_cant_leave_alliance'],"game.php?page=alliance",2);

				if ($_GET['yes'] == 1)
				{
					$db->query("UPDATE {{table}} SET `ally_members` = `ally_members`-1 WHERE `id`='{$CurrentUser['ally_id']}'", "alliance");
					$db->query("UPDATE {{table}} SET `ally_id` = 0, `ally_name` = '', ally_rank_id = 0 WHERE `id`='{$CurrentUser['id']}'", "users");
					$lang['Go_out_welldone'] = str_replace("%s", $ally_name, $lang['al_leave_sucess']);
					$page = $this->MessageForm($lang['Go_out_welldone'], "<br>", $PHP_SELF, $lang['al_continue']);
				}
				else
				{
					$lang['Want_go_out'] = str_replace("%s", $ally_name, $lang['al_do_you_really_want_to_go_out']);
					$page = $this->MessageForm($lang['Want_go_out'], "<br>", "game.php?page=alliance&mode=exit&yes=1", $lang['al_go_out_yes']);
				}
				$displays->message($page);
			}
		// < LISTA DE MIEMBROS >
			if ($mode == 'memberslist')
			{
				if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_can_watch_memberlist)
					header("location:game.". $phpEx . "?page=alliance",2);

				if ($sort2)
				{
					$sort1 = intval($_GET['sort1']);
					$sort2 = intval($_GET['sort2']);

					if ($sort1 == 1) {
					$sort = " ORDER BY `username`";
					} elseif ($sort1 == 2) {
					$sort = " ORDER BY `ally_rank_id`";
					} elseif ($sort1 == 3) {
					$sort = " ORDER BY `total_points`";
					} elseif ($sort1 == 4) {
					$sort = " ORDER BY `ally_register_time`";
					} elseif ($sort1 == 5) {
					$sort = " ORDER BY `onlinetime`";
					} else {
					$sort = " ORDER BY `id`";
					}

					if ($sort2 == 1) {
					$sort .= " DESC;";
					} elseif ($sort2 == 2) {
					$sort .= " ASC;";
					}
				}
				$listuser = $db->query("SELECT u.* ,st.total_points
							    FROM {{table}}users as u
							    inner join {{table}}statpoints as st
							    on u.id=st.id_owner
							    WHERE u.ally_id='{$CurrentUser['ally_id']}'
							    AND STAT_type=1 $sort", '');

				$i = 0;
                                $displays->newblock("memberslist");
                                
				while ($u = mysql_fetch_array($listuser))
				{
                                        $displays->newblock("list_memberslist");
					$i++;
					$u['i'] = $i;

					if ($u["onlinetime"] + 60 * 10 >= time() && $user_can_watch_memberlist_status)
						$u["onlinetime"] = "\"lime\">Conectado<";
					elseif ($u["onlinetime"] + 60 * 20 >= time() && $user_can_watch_memberlist_status)
						$u["onlinetime"] = "\"yellow\">15 min<";
					elseif ($user_can_watch_memberlist_status)
						$u["onlinetime"] = "\"red\">Desconectado<";
					else
						$u["onlinetime"] = "\"orange\">-<";

					if ($ally['ally_owner'] == $u['id'])
						$u["ally_range"] = ($ally['ally_owner_range'] == '')?$lang['al_founder_rank_text']:$ally['ally_owner_range'];
					elseif ($u['ally_rank_id'] == 0 )
						$u["ally_range"] = $lang['al_new_member_rank_text'];
					else
						$u["ally_range"] = $ally_ranks[$u['ally_rank_id']-1]['name'];

					$u["dpath"] 	= $dpath;
					$u['points'] 	= "" . pretty_number($u['total_points']) . "";

					if ($u['ally_register_time'] > 0)
						$u['ally_register_time'] = date("h:i:s  Y-m-d", $u['ally_register_time']);
					else
						$u['ally_register_time'] = "-";

                                        foreach($u as $key => $value){
                                            $displays->assign($key,$value);
                                        }
				}

				if ($sort2 == 1) {$s = 2;}
				elseif ($sort2 == 2) {$s = 1;}
				else {$s = 1;}

				if ($i != $ally['ally_members'])
					$db->query("UPDATE {{table}} SET `ally_members`='{$i}' WHERE `id`='{$ally['id']}'", 'alliance');
				$lang['i'] = $i;
				$lang['s'] = $s;
				$lang['list'] = $page_list;

				$displays->display();
			}
		// < CORREO CIRCULAR >
			if ($mode == 'circular')
			{
				if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_can_send_mails)
					header("location:game.". $phpEx . "?page=alliance",2);

				if ($sendmail == 1)
				{
					$_POST['r'] 	= intval($_POST['r']);
					//$_POST['text']  = trim ( nl2br ( strip_tags ( $_POST['text'], '<br>' ) ) );
                                        $_POST['text']  = strip_tags ( $_POST['text'], '<br>' )  ;
                                        //echo $_POST['text'];
					if ($_POST['r'] == 0)
						$sq = $db->query("SELECT id,username FROM {{table}} WHERE ally_id='{$CurrentUser['ally_id']}'", "users");
					else
						$sq = $db->query("SELECT id,username FROM {{table}} WHERE ally_id='{$CurrentUser['ally_id']}' AND ally_rank_id='{$_POST['r']}'", "users");

					$list = '';
                                        //exit;
					while ($u = mysql_fetch_array($sq))
					{
						$users->SendSimpleMessage($u['id'],$CurrentUser['id'],'',2,$ally['ally_tag'],$CurrentUser['username'],$_POST['text']);

						$list .= "<br>{$u['username']} ";
					}

                                        $displays->message($lang['al_circular_sended'].$list,false,false,true, true);
				}else{
                                    $displays->newblock("circular");
                                    $lang['r_list'] = "<option value=\"0\">".$lang['al_all_players']."</option>";

                                    if ($ally_ranks)
                                    {
                                            foreach($ally_ranks as $id => $array)
                                            {
                                                    $lang['r_list'] .= "<option value=\"" . ($id + 1) . "\">" . $array['name'] . "</option>";
                                            }
                                    }
                                    $displays->display();
                                }

				
			}
		// <  EDICION DE LOS PERMISOS O LEYES  >
			if ($mode == 'admin' && $edit == 'rights')
			{
                                                    Console::logMemory();
				if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_can_edit_rights){
					header("location:game.". $phpEx . "?page=alliance",2);
				}elseif (!empty($_POST['newrangname'])){
					$name = mysql_escape_string(strip_tags($_POST['newrangname']));

					$ally_ranks[] = array('name' => $name,
					'mails' => 0,
					'delete' => 0,
					'kick' => 0,
					'bewerbungen' => 0,
					'administrieren' => 0,
					'bewerbungenbearbeiten' => 0,
					'memberlist' => 0,
					'onlinestatus' => 0,
					'rechtehand' => 0
					);

					$ranks = serialize($ally_ranks);

					$db->query("UPDATE {{table}} SET `ally_ranks`='" . $ranks . "' WHERE `id`=" . $ally['id'], "alliance");

					$goto = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];

					header("Location: " . $goto);
					exit();
				}
				elseif ($_POST['id'] != '' && is_array($_POST['id']))
				{
					$ally_ranks_new = array();

					foreach ($_POST['id'] as $id)
					{
						$name = $ally_ranks[$id]['name'];
						$ally_ranks_new[$id]['name'] = $name;
                                                $ally_ranks_new[$id]['delete']=(isset($_POST['u' . $id . 'r0']))?"1":"0";
                                                $ally_ranks_new[$id]['kick']=(isset($_POST['u' . $id . 'r1']) && $ally['ally_owner'] == $CurrentUser['id'])?"1":"0";
                                                $ally_ranks_new[$id]['bewerbungen']=(isset($_POST['u' . $id . 'r2']))?"1":"0";
                                                $ally_ranks_new[$id]['memberlist']=(isset($_POST['u' . $id . 'r3']))?"1":"0";
                                                $ally_ranks_new[$id]['bewerbungenbearbeiten']=(isset($_POST['u' . $id . 'r4']))?"1":"0";
                                                $ally_ranks_new[$id]['administrieren']=(isset($_POST['u' . $id . 'r5']))?"1":"0";
                                                $ally_ranks_new[$id]['onlinestatus']=(isset($_POST['u' . $id . 'r6']))?"1":"0";
                                                $ally_ranks_new[$id]['mails']=(isset($_POST['u' . $id . 'r7']))?"1":"0";
                                                $ally_ranks_new[$id]['rechtehand']=(isset($_POST['u' . $id . 'r8']))?"1":"0";
					}

					$ranks = serialize($ally_ranks_new);

					$db->query("UPDATE {{table}} SET `ally_ranks`='" . $ranks . "' WHERE `id`=" . $ally['id'], "alliance");

					$goto = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
                                        
					header("Location: " . $goto);
					exit();

				}
				elseif(isset($d) && isset($ally_ranks[$d]))
				{
					unset($ally_ranks[$d]);

					$ally['ally_rank'] = serialize($ally_ranks);

					$db->query("UPDATE {{table}} SET `ally_ranks`='{$ally['ally_rank']}' WHERE `id`={$ally['id']}", "alliance");
				}
                                
                                $displays->newblock("rights");
				if (count($ally_ranks) != 0){
					$displays->newblock("list_rights");
                                        
                                        foreach($ally_ranks as $a => $b)
					{
                                                $displays->newblock("list_law_rights");
						if ($ally['ally_owner'] == $CurrentUser['id'])
						{
							$parses['id'] = $a;
							$parses['delete'] = "<a href=\"game.php?page=alliance&mode=admin&edit=rights&d={$a}\"><img src=\"{$dpath}pic/abort.gif\" title=\"Borrar rango\" border=\"0\"></a>";
							$parses['r0'] = $b['name'];
							$parses['a'] = $a;
							$parses['r1'] = "<input type=checkbox name=\"u{$a}r0\"" . (($b['delete'] == 1)?' checked="checked"':'') . ">"; //{$b[1]}
							$parses['r2'] = "<input type=checkbox name=\"u{$a}r1\"" . (($b['kick'] == 1)?' checked="checked"':'') . ">";
							$parses['r3'] = "<input type=checkbox name=\"u{$a}r2\"" . (($b['bewerbungen'] == 1)?' checked="checked"':'') . ">";
							$parses['r4'] = "<input type=checkbox name=\"u{$a}r3\"" . (($b['memberlist'] == 1)?' checked="checked"':'') . ">";
							$parses['r5'] = "<input type=checkbox name=\"u{$a}r4\"" . (($b['bewerbungenbearbeiten'] == 1)?' checked="checked"':'') . ">";
							$parses['r6'] = "<input type=checkbox name=\"u{$a}r5\"" . (($b['administrieren'] == 1)?' checked="checked"':'') . ">";
							$parses['r7'] = "<input type=checkbox name=\"u{$a}r6\"" . (($b['onlinestatus'] == 1)?' checked="checked"':'') . ">";
							$parses['r8'] = "<input type=checkbox name=\"u{$a}r7\"" . (($b['mails'] == 1)?' checked="checked"':'') . ">";
							$parses['r9'] = "<input type=checkbox name=\"u{$a}r8\"" . (($b['rechtehand'] == 1)?' checked="checked"':'') . ">";
                                                }
						else
						{
							$parses['id'] = $a;
							$parses['r0'] = $b['name'];
							$parses['delete'] = "<a href=\"game.php?page=alliance&mode=admin&edit=rights&d={$a}\"><img src=\"{$dpath}pic/abort.gif\" alt=\"{$lang['Delete_range']}\" border=0></a>";
							$parses['a'] = $a;
							$parses['r1'] = "<b>-</b>";
							$parses['r2'] = "<input type=checkbox name=\"u{$a}r1\"" . (($b['kick'] == 1)?' checked="checked"':'') . ">";
							$parses['r3'] = "<input type=checkbox name=\"u{$a}r2\"" . (($b['bewerbungen'] == 1)?' checked="checked"':'') . ">";
							$parses['r4'] = "<input type=checkbox name=\"u{$a}r3\"" . (($b['memberlist'] == 1)?' checked="checked"':'') . ">";
							$parses['r5'] = "<input type=checkbox name=\"u{$a}r4\"" . (($b['bewerbungenbearbeiten'] == 1)?' checked="checked"':'') . ">";
							$parses['r6'] = "<input type=checkbox name=\"u{$a}r5\"" . (($b['administrieren'] == 1)?' checked="checked"':'') . ">";
							$parses['r7'] = "<input type=checkbox name=\"u{$a}r6\"" . (($b['onlinestatus'] == 1)?' checked="checked"':'') . ">";
							$parses['r8'] = "<input type=checkbox name=\"u{$a}r7\"" . (($b['mails'] == 1)?' checked="checked"':'') . ">";
							$parses['r9'] = "<input type=checkbox name=\"u{$a}r8\"" . (($b['rechtehand'] == 1)?' checked="checked"':'') . ">";
                                                }
                                                foreach($parses as $key => $value){
                                                    $displays->assign($key,$value);
                                                }
                                                
					}
				}
                                //Console::logMemory();
                                $displays->display();
			}
		// <  EDICIONES GENERALES DE LA ALIANZA >
			if ($mode == 'admin' && $edit == 'ally')
			{
				if ($t != 1 && $t != 2 && $t != 3)
				{
					$t = 1;
				}

				/*if ($_POST)
				{
					/if (!get_magic_quotes_gpc())
					{
						$_POST['owner_range'] 	= stripslashes($_POST['owner_range']);
						$_POST['web'] 		= stripslashes($_POST['web']);
						$_POST['image'] 	= stripslashes($_POST['image']);
						$_POST['text'] 		= stripslashes($_POST['text']);
					}
				}*/

				if ($_POST['options'])
				{
					$ally['ally_owner_range'] 	= $_POST['owner_range'];
					$ally['ally_web'] 		= $_POST['web'];
					$ally['ally_image'] 		= $_POST['image'];
					$ally['ally_request_notallow'] 	= intval($_POST['request_notallow']);

					if ($ally['ally_request_notallow'] != 0 && $ally['ally_request_notallow'] != 1)
						exit(header("location:game.". $phpEx . "?page=alliance?mode=admin&edit=ally",2));

					$db->query("UPDATE {{table}} SET
					`ally_owner_range`='{$ally['ally_owner_range']}',
					`ally_image`='{$ally['ally_image']}',
					`ally_web`='{$ally['ally_web']}',
					`ally_request_notallow`='{$ally['ally_request_notallow']}'
					WHERE `id`='{$ally['id']}'", "alliance");
				}
				elseif ($_POST['t'])
				{
					if ($t == 3)
					{

						$ally['ally_request'] = strip_tags($_POST['text']);
						$db->query("UPDATE {{table}} SET
						`ally_request`='{$ally['ally_request']}'
						WHERE `id`='{$ally['id']}'", "alliance");
					}
					elseif ($t == 2)
					{
						$ally['ally_text'] =strip_tags($_POST['text']);
						$db->query("UPDATE {{table}} SET
						`ally_text`='{$ally['ally_text']}'
						WHERE `id`='{$ally['id']}'", "alliance");
					}
					else
					{       
                                                $ally['ally_description'] = strip_tags($_POST['text']);

						$db->query("UPDATE {{table}} SET
						`ally_description`='" . $ally['ally_description'] . "'
						WHERE `id`='{$ally['id']}'", "alliance");
					}
				}
                                $displays->newblock("admin");
				
				if ($t == 3) {
                                    $lang['request_type'] = $lang['al_request_text'];
				} elseif ($t == 2) {
                                    $lang['request_type'] = $lang['al_inside_text'];
				} else {
                                    $lang['request_type'] = $lang['al_outside_text'];
				}

				if ($t == 2)
					$lang['text'] = $ally['ally_text'];
				else
					$lang['text'] = $ally['ally_description'];

				if ($t == 3)
					$lang['text'] = $ally['ally_request'];

				$lang['t'] 				= $t;
				$lang['ally_web'] 			= $ally['ally_web'];
				$lang['ally_image'] 			= $ally['ally_image'];
				$lang['ally_request_notallow_0'] 	= (($ally['ally_request_notallow'] == 1) ? ' SELECTED' : '');
				$lang['ally_request_notallow_1'] 	= (($ally['ally_request_notallow'] == 0) ? ' SELECTED' : '');
				$lang['ally_owner_range'] 		= $ally['ally_owner_range'];
				$displays->display();
			}
		// < -- EDICION DE LOS MIEMBROS -- >
			if ($mode == 'admin' && $edit == 'members')
			{
				if ($ally['ally_owner'] != $CurrentUser['id'] && $user_admin == false)
					header("location:game.". $phpEx . "?page=alliance",2);

				if (isset($kick))
				{
					if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_can_kick){
						header("location:game.". $phpEx . "?page=alliance",2);
					}

					$u = $db->query("SELECT * FROM {{table}} WHERE id='{$kick}' LIMIT 1", 'users', true);

					if ($u['ally_id'] == $ally['id'] && $u['id'] != $ally['ally_owner']){
						$db->query("UPDATE {{table}} SET `ally_id`='0', `ally_name`='', `ally_rank_id` = 0 WHERE `id`='{$u['id']}' LIMIT 1;", 'users');
					}
				}
				elseif (isset($_POST['newrang']))
				{
					$q = $db->query("SELECT * FROM {{table}} WHERE id='{$u}' LIMIT 1", 'users', true);

					if ((isset($ally_ranks[$_POST['newrang']-1]) || $_POST['newrang'] == 0) && $q['id'] != $ally['ally_owner'])
						$db->query("UPDATE {{table}} SET `ally_rank_id`='" . mysql_escape_string(strip_tags($_POST['newrang'])) . "' WHERE `id`='" . intval($id) . "'", 'users');
				}

				if ($sort2)
				{
					$sort1 = intval($_GET['sort1']);
					$sort2 = intval($_GET['sort2']);

					if ($sort1 == 1) {
					$sort = " ORDER BY u.username";
					} elseif ($sort1 == 2) {
					$sort = " ORDER BY u.ally_rank_id";
					} elseif ($sort1 == 3) {
					$sort = " ORDER BY st.total_points";
					} elseif ($sort1 == 4) {
					$sort = " ORDER BY u.ally_register_time";
					} elseif ($sort1 == 5) {
					$sort = " ORDER BY u.onlinetime";
					} else {
					$sort = " ORDER BY u.id";
					}

					if ($sort2 == 1) {
					$sort .= " DESC;";
					} elseif ($sort2 == 2) {
					$sort .= " ASC;";
					}
				}
				$listuser = $db->query("SELECT u.* ,st.total_points
							    FROM {{table}}users as u
							    inner join {{table}}statpoints as st
							    on u.id=st.id_owner
							    WHERE u.ally_id='{$CurrentUser['ally_id']}'
							    AND STAT_type=1 $sort", '');
				

				$i 				= 0;
				$lang['i'] = mysql_num_rows($listuser);
                                $displays->newblock("admin_members");
				while ($u = mysql_fetch_array($listuser))
				{
                                        $displays->newblock("admin_list_members");
					$i++;
					$u['i'] = $i;
					$u['points'] = "" . pretty_number($u['total_points']) . "";
					$days = floor(round(time() - $u["onlinetime"]) / (3600 * 24));
					$u["onlinetime"] = str_replace("%s", $days, "%s d");
					if ($ally['ally_owner'] == $u['id']){
						$ally_range = ($ally['ally_owner_range'] == '')?$lang['al_founder_rank_text']:$ally['ally_owner_range'];
					}
					elseif ($u['ally_rank_id'] == 0 || !isset($ally_ranks[$u['ally_rank_id']-1]['name'])){
						$ally_range = $lang['al_new_member_rank_text'];
					}
					else{
						$ally_range = $ally_ranks[$u['ally_rank_id']-1]['name'];
					}

					if ($ally['ally_owner'] == $u['id'] || $rank == $u['id']){
						$u["acciones"] = '-';
					}
					elseif ($ally_ranks[$CurrentUser['ally_rank_id']-1]['kick'] == 1  &&  $ally_ranks[$CurrentUser['ally_rank_id']-1]['administrieren'] == 1 || $ally['ally_owner'] == $CurrentUser['id']){
						$u["acciones"] = "<a href=\"game.php?page=alliance&mode=admin&edit=members&kick=$u[id]\" onclick=\"javascript:return confirm('�Est�s seguro que deseas expulsar a $u[username]?');\"><img src=\"".$dpath."pic/abort.gif\" border=\"0\"></a> <a href=\"game.php?page=alliance&mode=admin&edit=members&rank=$u[id]\"><img src=\"".$dpath."pic/key.gif\" border=\"0\"></a>";
					}
					elseif ($ally_ranks[$CurrentUser['ally_rank_id']-1]['administrieren'] == 1 ){
						$u["acciones"] = "<a href=\"game.php?page=alliance&mode=admin&edit=members&kick=$u[id]\" onclick=\"javascript:return confirm('�Est�s seguro que deseas expulsar a $u[username]?');\"><img src=\"".$dpath."pic/abort.gif\" border=\"0\"></a> <a href=\"game.php?page=alliance&mode=admin&edit=members&rank=$u[id]\"><img src=\"".$dpath."pic/key.gif\" border=\"0\"></a>";
					}
					else{
						$u["acciones"] = '-';
					}
					$u["dpath"] = $dpath;
					$u['ally_register_time'] = date("Y-m-d h:i:s", $u['ally_register_time']);
                                        $u['ally_range'] = $ally_range;
                                        foreach ($u as $key => $value) {
                                                    $displays->assign($key,$value);
                                                }
					if ($rank == $u['id'])
					{

                                                $displays->newblock("admin_list_members_edit");
						$r['Rank_for'] = str_replace("%s", $u['username'], $lang['Rank_for']);
						$r['options'] .= "<option onclick=\"document.editar_usu_rango.submit();\" value=\"0\">".$lang['al_new_member_rank_text']."</option>";
						if($ally_ranks){
                                                    foreach($ally_ranks as $a => $b)
                                                    {
                                                            $r['options'] 	.= "<option onclick=\"document.editar_usu_rango.submit();\" value=\"" . ($a + 1) . "\"";

                                                            if ($u['ally_rank_id']-1 == $a)
                                                            {
                                                                    $r['options'] .= ' selected=selected';
                                                            }

                                                            $r['options'] .= ">{$b['name']}</option>";
                                                    }
						}
						$r['id'] = $u['id'];
                                                foreach ($r as $key => $value) {
                                                    $displays->assign($key,$value);
                                                }
                                        }
                                }
				if ($sort2 == 1) {$s = 2;}
				elseif ($sort2 == 2) {$s = 1;}
				else {$s = 1;}
				if ($i != $ally['ally_members']){
					$db->query("UPDATE {{table}} SET `ally_members`='{$i}' WHERE `id`='{$ally['id']}'", 'alliance');
				}
                                $lang['s'] = $s;
				$displays->display();
			}
		// < -- EDICION DE LAS SOLICITUDES -- >
			if ($mode == 'admin' && $edit == 'requests')
			{
				if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_bewerbungen_bearbeiten)
					header("location:game.". $phpEx . "?page=alliance",2);

				if ($_POST['action'] == $lang['al_acept_request'])
				{
					//$_POST['text']  = trim ( nl2br ( strip_tags ( $_POST['text'], '<br>' ) ) );

					$db->query("UPDATE {{table}} SET
					ally_name='".$ally['ally_name']."',
					ally_request_text='',
					ally_request='0',
					ally_id='".$ally['id']."'
					WHERE id='".$show."'", 'users');
                                        
					$db->query("UPDATE {{table}} SET `ally_members` = `ally_members` + 1 WHERE id='".$ally['id']."'", 'alliance');
                                        
					$users->SendSimpleMessage($show,$CurrentUser['id'],'', 2,$ally['ally_tag'],$lang['al_you_was_acceted'] . $ally['ally_name'], $lang['al_hi_the_alliance'] . $ally['ally_name'] . $lang['al_has_accepted'] . $_POST['text']);

					exit(header('Location:game.php?page=alliance&mode=admin&edit=requests'));
				}
				elseif($_POST['action'] == $lang['al_decline_request'] && $_POST['action'] != '')
				{
					//$_POST['text']  = trim ( nl2br ( strip_tags ( $_POST['text'], '<br>' ) ) );

					$db->query("UPDATE {{table}}
						SET ally_request_text='',
						ally_request='0',
						ally_id='0'
						WHERE id='".$show."'", 'users');
					$users->SendSimpleMessage($show,$CurrentUser['id'],'', 2,$ally['ally_tag'],$lang['al_you_was_declined'] . $ally['ally_name'], $lang['al_hi_the_alliance'] . $ally['ally_name'] . $lang['al_has_declined'] . $_POST['text']);
					exit(header('Location:game.php?page=alliance&mode=admin&edit=requests'));
				}

				$i = 0;
				
				$query = $db->query("SELECT id,username,ally_request_text,ally_register_time
						 FROM {{table}} WHERE ally_request='".$ally['id']."'", 'users');

                                $displays->newblock("list_solicitudes");
				while ($r = mysql_fetch_array($query))
				{
					if(isset($show) && $r['id'] == $show)
					{
                                                $displays->newblock("form_solicitudes");
						$s['username'] 			= $r['username'];
						$s['ally_request_text'] 	= nl2br($r['ally_request_text']);
						$s['id'] 			= $r['id'];
                                                $lang['Request_from'] 	= str_replace('%s', $s['username'], $lang['al_request_from']);
                                        }else{
                                            $displays->newblock("list");
                                            $r['time'] 		= date("Y-m-d h:i:s", $r['ally_register_time']);
                                            $i++;
                                        }
                                        foreach($r as $key => $value){
                                            $displays->assign($key,$value);
                                        }
				}
				$lang['ally_tag'] 			= $ally['ally_tag'];
				$lang['There_is_hanging_request'] 	= str_replace('%n', $i, $lang['al_no_request_pending']);

				$displays->display();
			}
		// < -- CAMBIAR NOMBRE DE LA ALIANZA -- >
			if ($mode == 'admin' && $edit == 'name')
			{
				if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_admin)
					header("location:game.". $phpEx . "?page=alliance",2);

                                $displays->newblock("rename_alliance");

                                if ($_POST['nombre'] && !empty($_POST['nombre']))
				{
					$ally['ally_name'] = $_POST['nombre'];
					$db->query("UPDATE {{table}} SET `ally_name` = '". $ally['ally_name'] ."' WHERE `id` = '". $CurrentUser['ally_id'] ."';", 'alliance');
					$db->query("UPDATE {{table}} SET `ally_name` = '". $ally['ally_name'] ."' WHERE `ally_id` = '". $ally['id'] ."';", 'users');
				}
				$lang[caso] 		= $lang['al_name'];
				$lang[caso_titulo]	= $lang['al_new_name'];

				$displays->display();
			}
		// < - CAMBIAR ETIQUETA DE LA ALIANZA - >
			if ($mode == 'admin' && $edit == 'tag')
			{
				if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_admin)
					header("location:game.". $phpEx . "?page=alliance",2);

                                $displays->newblock("rename_alliance");
				if ($_POST['etiqueta'] && !empty($_POST['etiqueta'])){
					$db->query("UPDATE {{table}} SET `ally_tag` = '". $_POST['etiqueta'] ."' WHERE `id` = '". $CurrentUser['ally_id'] ."';", 'alliance');
                                }

				$lang[caso] 		= $lang['al_tag'];
				$lang[caso_titulo]	= $lang['al_new_tag'];

				$displays->display();
			}
		// < SALIR DE LA ALIANZA >
			if ($mode == 'admin' && $edit == 'exit')
			{
				if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_can_exit_alliance)
					header("location:game.". $phpEx . "?page=alliance",2);

				$BorrarAlianza = $db->query("SELECT id FROM {{table}} WHERE `ally_id`='{$ally['id']}'",'users');

				while ($v = mysql_fetch_array($BorrarAlianza))
				{
					$db->query("UPDATE {{table}} SET `ally_name` = '', `ally_id`='0' WHERE `id`='{$v['id']}'", 'users');
				}

				$db->query("DELETE FROM {{table}} WHERE id='{$ally['id']}' LIMIT 1", "alliance");

				exit(header("location:game.". $phpEx . "?page=alliance",2));
			}
		// < ----- TRANSFERIR LA ALIANZA ----- >
			if ($mode == 'admin' && $edit == 'transfer')
			{
                                if ($ally['ally_owner'] != $CurrentUser['id']){
					header("location:game.". $phpEx . "?page=alliance",2);
                                }elseif(isset($_POST['newleader']))
				{
					$db->query("UPDATE {{table}} SET `ally_rank_id`='0' WHERE `id`={$CurrentUser['id']} ", 'users');
					$db->query("UPDATE {{table}} SET `ally_owner`='" . mysql_escape_string(strip_tags($_POST['newleader'])) . "' WHERE `id`={$CurrentUser['ally_id']} ", 'alliance');
					$db->query("UPDATE {{table}} SET `ally_rank_id`='0' WHERE `id`='" . mysql_escape_string(strip_tags($_POST['newleader'])) . "' ", 'users');
					exit(header("location:game.". $phpEx . "?page=alliance",2));
				}else
				{
                                    $displays->newblock("transfer");
					$listuser 		= $db->query("SELECT * FROM {{table}} WHERE ally_id='{$CurrentUser['ally_id']}'", 'users');
					while ($u = mysql_fetch_array($listuser))
					{
                                            
						if ($ally['ally_owner'] != $u['id'])
						{
							if ($u['ally_rank_id'] != 0 )
							{
								if ($ally_ranks[$u['ally_rank_id']-1]['rechtehand'] == 1)
								{
                                                                    
									$righthand['righthand'] .= "\n<option value=\"" . $u['id'] . "\"";
									$righthand['righthand'] .= ">";
									$righthand['righthand'] .= "".$u['username'];
									$righthand['righthand'] .= "&nbsp;[".$ally_ranks[$u['ally_rank_id']-1]['name'];
									$righthand['righthand'] .= "]&nbsp;&nbsp;</option>";
                                                                        $displays->assign('righthand',$righthand['righthand']);
                                                                }
							}
						}
						
					}
                                        $displays->display();
				}
			}
		// < -- PARTE DEFAULT DE LA ALIANZA -- >
			{

                                $displays->newblock("alianza");
				// IMAGEN
				if ($ally['ally_ranks'] != '')
					$ally['ally_ranks'] = "<tr><td colspan=2><img src=\"{$ally['ally_image']}\"></td></tr>";
                                 
				//RANGOS
				if ($ally['ally_owner'] == $CurrentUser['id'])
					$range = ($ally['ally_owner_range'] != '') ? $ally['ally_owner_range'] : $lang['al_founder_rank_text'];
				elseif ($CurrentUser['ally_rank_id'] != 0 && isset($ally_ranks[$CurrentUser['ally_rank_id']-1]['name']))
					$range = $ally_ranks[$CurrentUser['ally_rank_id']-1]['name'];
				else
					$range = $lang['al_new_member_rank_text'];

				// LISTA DE MIEMBROS
				if ($ally['ally_owner'] == $CurrentUser['id'] || $ally_ranks[$CurrentUser['ally_rank_id']-1]['memberlist'] != 0)
					$parsefault['members_list'] = " (<a href=\"game.php?page=alliance&mode=memberslist\">".$lang['al_user_list']."</a>)";
				else
					$parsefault['members_list'] = '';

				// ADMINISTRAR ALIANZA
				if ($ally['ally_owner'] == $CurrentUser['id'] || $ally_ranks[$CurrentUser['ally_rank_id']-1]['administrieren'] != 0)
					$parsefault['alliance_admin'] = " (<a href=\"game.php?page=alliance&mode=admin&edit=ally\">".$lang['al_manage_alliance']."</a>)";
				else
					$parsefault['alliance_admin'] = '';

				// CORREO CIRCULAR
				if ($ally['ally_owner'] == $CurrentUser['id'] || $ally_ranks[$CurrentUser['ally_rank_id']-1]['mails'] != 0)
					$parsefault['send_circular_mail'] = "<tr><th>".$lang['al_circular_message']."</th><th><a href=\"game.php?page=alliance&mode=circular\">".$lang['al_send_circular_message']."</a></th></tr>";
				else
					$parsefault['send_circular_mail'] = '';

				// SOLICITUDES
				$request_count = mysql_num_rows($db->query("SELECT id FROM {{table}} WHERE ally_request='{$ally['id']}'", 'users'));

				if ($request_count != 0)
				{
					if ($ally['ally_owner'] == $CurrentUser['id'] || $ally_ranks[$CurrentUser['ally_rank_id']-1]['bewerbungen'] != 0)
						$parsefault['requests'] = "<tr><th>".$lang['al_requests']."</th><th><a href=\"game.php?page=alliance&mode=admin&edit=requests\">{$request_count} ".$lang['al_new_requests']."</a></th></tr>";
				}
				// SALIR DE LA ALIANZA
				if ($ally['ally_owner'] != $CurrentUser['id'])
				{
					$parsefault['ally_owner'] .= "<table width=\"519\">";
					$parsefault['ally_owner'] .= "<tr><td class=\"c\">".$lang['al_leave_alliance']."</td>";
					$parsefault['ally_owner'] .= "</tr><tr>";
					$parsefault['ally_owner'] .= "<th><input type=\"button\" onclick=\"javascript:location.href='game.php?page=alliance&mode=exit';\" value=\"".$lang['al_continue']."\"/></th>";
					$parsefault['ally_owner'] .= "</tr></table>";
				}
				else
					$parsefault['ally_owner'] .= '';

				// IMAGEN DEL LOGO
				$parsefault['ally_image'] 		= ($ally['ally_image'] != '')?"<tr><th colspan=2><img src=\"{$ally['ally_image']}\"></td></tr>":'';
				$parsefault['range'] 				= $range;

				$parsefault['ally_description'] 	= html_entity_decode($this->bbcode($ally['ally_description']));
				$parsefault['ally_text'] 		= html_entity_decode($this->bbcode($ally['ally_text']));
                                $parsefault['ally_web']=($ally['ally_web'] != '')?$ally['ally_web']:"-";
				$parsefault['ally_tag'] 			= $ally['ally_tag'];
				$parsefault['ally_members']                     = $ally['ally_members'];
				$parsefault['ally_name'] 			= $ally['ally_name'];
                                foreach($parsefault as $key => $value){
                                    $displays->assign($key,$value);
                                }
				$displays->display();
			}
		}
	}
}
?>