<?php


  
  define('INSTALL', false);
  
  $mode = $_GET['mode'];
  if (empty($mode))
    {
      unset($mode);
    }
  $a = intval($_GET['a']);
  if (empty($a))
    {
      unset($a);
    }
  $sort1 = intval($_GET['sort1']);
  if (empty($sort1))
    {
      unset($sort1);
    }
  $sort2 = intval($_GET['sort2']);
  if (empty($sort2))
    {
      unset($sort2);
    }
  $d = $_GET['d'];
  if ((!is_numeric($d)) || (empty($d) && $d != 0))
      unset($d);
  
  $edit = $_GET['edit'];
  
  if (empty($edit))
      unset($edit);
  
  $rank = intval($_GET['rank']);
  
  if (empty($rank))
      unset($rank);
  
  $kick = intval($_GET['kick']);
  
  if (empty($kick))
      unset($kick);
  
  $id = intval($_GET['id']);
  
  if (empty($id))
      unset($id);
  
  define('INSIDE', true);
  $xnova_root_path = './';
  include($xnova_root_path . 'extension.inc');
  include($xnova_root_path . 'common.' . $phpEx);
  
  $mode = $_GET['mode'];
  $yes = $_GET['yes'];
  $edit = $_GET['edit'];
  $allyid = intval($_GET['allyid']);
  $show = intval($_GET['show']);
  $sort = intval($_GET['sort']);
  $sendmail = intval($_GET['sendmail']);
  $t = $_GET['t'];
  $a = intval($_GET['a']);
  $tag = mysql_escape_string($_GET['tag']);
  
  includeLang('alliance');
  
  /* L'alliance a trois parti :
   -La premiere est la commune . C'est dire , pas besoin de regarder si je suis dans une alliance ou non .
   -La deuxi&eacute;me est sans alliance . Alors &ccedil;a implique les candidature
   -La derniere est quand on est dedans l'alliance
   */
  
  //Premiere Parti 
  
  if ($_GET['mode'] == 'ainfo')
    {
      $a = intval($_GET['a']);
      $tag = mysql_escape_string($_GET['tag']);
      
      $lang['Alliance_information'] = "Information Alliance";
      
      if (isset($_GET['tag']))
        {
          $allyrow = doquery("SELECT * FROM {{table}} WHERE ally_tag='{$tag}'", "alliance", true);
        }
      elseif (is_numeric($a) && $a != 0)
        {
          $allyrow = doquery("SELECT * FROM {{table}} WHERE id='{$a}'", "alliance", true);
        }
      else
        {
          message("Cette alliance n'existe pas !", "Information Alliance (1)");
        }
      
      // Elle existe ou pas ???
      if (!$allyrow)
        {
          message("Cette alliance n'existe pas !", "Information Alliance (1)");
        }
      extract($allyrow);
      
      if ($ally_image != "")
        {
          $ally_image = "<tr><th colspan=2><img src=\"{$ally_image}\"></td></tr>";
        }
      
      if ($ally_description != "")
        {
          $ally_description = "<tr><th colspan=2 height=100>{$ally_description}</th></tr>";
        }
      else
          $ally_description = "<tr><th colspan=2 height=100>Il n'y as aucune descriptions de cette alliance.</th></tr>";
      
      if ($ally_web != "")
        {
          $ally_web = "<tr>
    <th>{$lang['Initial_page']}</th>
    <th><a href=\"{$ally_web}\">{$ally_web}</a></th>
    </tr>";
        }
      
      $lang['ally_member_scount'] = $ally_members;
      $lang['ally_name'] = $ally_name;
      $lang['ally_tag'] = $ally_tag;
      // code rare
      $patterns[] = "#\[fc\]([a-z0-9\#]+)\[/fc\](.*?)\[/f\]#Ssi";
      $replacements[] = '<font color="\1">\2</font>';
      $patterns[] = '#\[img\](.*?)\[/img\]#Smi';
      $replacements[] = '<img src="\1" alt="\1" style="border:0px;" />';
      $patterns[] = "#\[fc\]([a-z0-9\#\ \[\]]+)\[/fc\]#Ssi";
      $replacements[] = '<font color="\1">';
      $patterns[] = "#\[/f\]#Ssi";
      $replacements[] = '</font>';
      $ally_description = preg_replace($patterns, $replacements, $ally_description);
      
      $lang['ally_description'] = nl2br($ally_description);
      $lang['ally_image'] = $ally_image;
      $lang['ally_web'] = $ally_web;
      
      if ($user['ally_id'] == 0)
        {
          $lang['bewerbung'] = "<tr>
    <th>Candidature</th>
    <th><a href=\"alliance.php?mode=apply&amp;allyid=" . $id . "\">Cliquer ici pour ecrire votre candidature</a></th>

  </tr>";
        }
      else
          $lang['bewerbung'] = "Candidature";
      
      $page .= parsetemplate(gettemplate('alliance_ainfo'), $lang);
      display($page, str_replace('%s', $ally_name, $lang['Info_of_Alliance']));
    }
  
  // ---------Verification de l'alliance ---------
  
  if ($user['ally_id'] == 0)
    {
      // Sans alliance 
      if ($mode == 'make' && $user['ally_request'] == 0)
        {
          // creer alliance 
          
          /* On creer l'alliance ici */
          
          if ($yes == 1 && $_POST)
            {
              /*
               Ici on realise un query pour tester le nombre et apres on demande si le TAG  et correct
               */
              
              if (!$_POST['atag'])
                {
                  message($lang['have_not_tag'], $lang['make_alliance']);
                }
              if (!$_POST['aname'])
                {
                  message($lang['have_not_name'], $lang['make_alliance']);
                }
              
              $tagquery = doquery("SELECT * FROM {{table}} WHERE ally_tag='{$_POST['atag']}'", 'alliance', true);
              
              if ($tagquery)
                {
                  message(str_replace('%s', $_POST['atag'], $lang['always_exist']), $lang['make_alliance']);
                }
              
              doquery("INSERT INTO {{table}} SET
      `ally_name`='{$_POST['aname']}',
      `ally_tag`='{$_POST['atag']}' ,
      `ally_owner`='{$user['id']}',
      `ally_owner_range`='Leader',
      `ally_members`='1',
      `ally_register_time`=" . time(), "alliance");
              
              $allyquery = doquery("SELECT * FROM {{table}} WHERE ally_tag='{$_POST['atag']}'", 'alliance', true);
              
              doquery("UPDATE {{table}} SET
      `ally_id`='{$allyquery['id']}',
      `ally_name`='{$allyquery['ally_name']}',
      `ally_register_time`='" . time() . "'
      WHERE `id`='{$user['id']}'", "users");
              
              $page = MessageForm(str_replace('%s', $_POST['atag'], $lang['ally_maked']), str_replace('%s', $_POST['atag'], $lang['alliance_has_been_maked']) . "<br><br>", "", $lang['Ok']);
            }
          else
            {
              $page .= parsetemplate(gettemplate('alliance_make'), $lang);
            }
          
          display($page, $lang['make_alliance']);
        }
      
      if ($mode == 'search' && $user['ally_request'] == 0)
        {
          // Recherche alliance
          
          $parse = $lang;
          $lang['searchtext'] = $_POST['searchtext'];
          $page = parsetemplate(gettemplate('alliance_searchform'), $lang);
          
          // Cette partie correspond au fichier search.php
          
          if ($_POST)
            {
              $search = doquery("SELECT * FROM {{table}} WHERE ally_name LIKE '%{$_POST['searchtext']}%' or ally_tag LIKE '%{$_POST['searchtext']}%' LIMIT 30", "alliance");
              
              if (mysql_num_rows($search) != 0)
                {
                  $template = gettemplate('alliance_searchresult_row');
                  
                  while ($s = mysql_fetch_array($search))
                    {
                      $entry = array();
                      $entry['ally_tag'] = "[<a href=\"alliance.php?mode=apply&allyid={$s['id']}\">{$s['ally_tag']}</a>]";
                      $entry['ally_name'] = $s['ally_name'];
                      $entry['ally_members'] = $s['ally_members'];
                      
                      $parse['result'] .= parsetemplate($template, $entry);
                    }
                  
                  $page .= parsetemplate(gettemplate('alliance_searchresult_table'), $parse);
                }
            }
          display($page, $lang['search_alliance']);
        }
      
      
      // ------------------------Candidature -----------------------
      
      
      if ($mode == 'apply' && $user['ally_request'] == 0)
        {
			//Alliance fermer !
            if($_GET['allyid'] != NULL) {
      $alianza = doquery("SELECT * FROM {{table}} WHERE id='{$_GET['allyid']}'", "alliance", true); }
         if($alianza['ally_request_notallow'] == 1) { message("L'alliance est fermer les candidature ne sont pas autoriser !"); } else { 
          if (!is_numeric($_GET['allyid']) || !$_GET['allyid'] || $user['ally_request'] != 0 || $user['ally_id'] != 0)
            {
              message($lang['it_is_not_posible_to_apply'], $lang['it_is_not_posible_to_apply']);
            }
          // On demande des informations a  l'alliance
          
          $allyrow = doquery("SELECT ally_tag,ally_request FROM {{table}} WHERE id='" . intval($_GET['allyid']) . "'", "alliance", true);
          
          if (!$allyrow)
            {
              message($lang['it_is_not_posible_to_apply'], $lang['it_is_not_posible_to_apply']);
            }
          
          extract($allyrow);
          if ($_POST['further'] == $lang['Send'])
            {
              // Cette parti est la meme que search.php
              doquery("UPDATE {{table}} SET `ally_request`='" . intval($allyid) . "', ally_request_text='" . mysql_escape_string(strip_tags($_POST['text'])) . "', ally_register_time='" . time() . "' WHERE `id`='" . $user['id'] . "'", "users");
              // Message quand le message est bien envoy&eacute;e 
              message($lang['apply_registered'], $lang['your_apply']);
              // Message d'erreur quand l'envoi du message a echou&eacute;
              // message($lang['apply_cantbeadded'], $lang['your_apply']);
            }
          else
            {
              $text_apply = ($ally_request) ? $ally_request : $lang['There_is_no_a_text_apply'];
            }
          
          $parse = $lang;
          $parse['allyid'] = intval($_GET['allyid']);
          $parse['chars_count'] = strlen($text_apply);
          $parse['text_apply'] = $text_apply;
          $parse['Write_to_alliance'] = str_replace('%s', $ally_tag, $lang['Write_to_alliance']);
          
          $page = parsetemplate(gettemplate('alliance_applyform'), $parse);
          
          display($page, $lang['Write_to_alliance']);
			}
        }
      
      if ($user['ally_request'] != 0)
        {
          // On attend une reponse .....
          // On demande pour ally_tag
          $allyquery = doquery("SELECT ally_tag FROM {{table}} WHERE id='" . intval($user['ally_request']) . "' ORDER BY `id`", "alliance", true);
          
          extract($allyquery);
          if ($_POST['bcancel'])
            {
              doquery("UPDATE {{table}} SET `ally_request`=0 WHERE `id`=" . $user['id'], "users");
              
              $lang['request_text'] = str_replace('%s', $ally_tag, $lang['Canceled_a_request_text']);
              $lang['button_text'] = $lang['Ok'];
              $page = parsetemplate(gettemplate('alliance_apply_waitform'), $lang);
            }
          else
            {
              $lang['request_text'] = str_replace('%s', $ally_tag, $lang['Waiting_a_request_text']);
              $lang['button_text'] = $lang['Delete_apply'];
              $page = parsetemplate(gettemplate('alliance_apply_waitform'), $lang);
            }
          // mysql_escape_string(strip_tags());
          display($page, "Deine Anfrage");
        }
      else
        {
          // Vue sans alliance 
          /*
           Vue normal quand il n"y as ni candidature ni alliance
           */
          $page .= parsetemplate(gettemplate('alliance_defaultmenu'), $lang);
          display($page, $lang['alliance']);
        }
    }
  
  // Partie de la vue alliance quand on est dedans .
  elseif ($user['ally_id'] != 0 && $user['ally_request'] == 0)
    {
      // Avec alliance 
      // Query pour allyrow
      /*
       array(1 =>
       'name' => 'Co. Leader',
       'mails' => '1',
       'delete' => '0',
       'kick' => '1',
       'bewerbungen' => '1',
       'administrieren' => '1',
       'memberlist' => '1',
       'bewerbungenbearbeiten' => '1',
       'onlinestatus' => '1',
       'rechtehand' => '1'
       );
       
       */
      
      $ally = doquery("SELECT * FROM {{table}} WHERE id='{$user['ally_id']}'", "alliance", true);
      
      $ally_ranks = unserialize($ally['ally_ranks']);
      
      $allianz_raenge = unserialize($ally['ally_ranks']);
      
      if ($allianz_raenge[$user['ally_rank_id'] - 1]['onlinestatus'] == 1 || $ally['ally_owner'] == $user['id'])
        {
          $user_can_watch_memberlist_status = true;
        }
      else
          $user_can_watch_memberlist_status = false;
      
      if ($allianz_raenge[$user['ally_rank_id'] - 1]['memberlist'] == 1 || $ally['ally_owner'] == $user['id'])
        {
          $user_can_watch_memberlist = true;
        }
      else
          $user_can_watch_memberlist = false;
      
      if ($allianz_raenge[$user['ally_rank_id'] - 1]['mails'] == 1 || $ally['ally_owner'] == $user['id'])
        {
          $user_can_send_mails = true;
        }
      else
          $user_can_send_mails = false;
      
      if ($allianz_raenge[$user['ally_rank_id'] - 1]['kick'] == 1 || $ally['ally_owner'] == $user['id'])
        {
          $user_can_kick = true;
        }
      else
          $user_can_kick = false;
      
      if ($allianz_raenge[$user['ally_rank_id'] - 1]['rechtehand'] == 1 || $ally['ally_owner'] == $user['id'])
          $user_can_edit_rights = true;
      else
          $user_can_edit_rights = false;
      
      if ($allianz_raenge[$user['ally_rank_id'] - 1]['delete'] == 1 || $ally['ally_owner'] == $user['id'])
          $user_can_exit_alliance = true;
      else
          $user_can_exit_alliance = false;
      
      if ($allianz_raenge[$user['ally_rank_id'] - 1]['bewerbungen'] == 1 || $ally['ally_owner'] == $user['id'])
          $user_bewerbungen_einsehen = true;
      else
          $user_bewerbungen_einsehen = false;
      
      if ($allianz_raenge[$user['ally_rank_id'] - 1]['bewerbungenbearbeiten'] == 1 || $ally['ally_owner'] == $user['id'])
          $user_bewerbungen_bearbeiten = true;
      else
          $user_bewerbungen_bearbeiten = false;
      
      if ($allianz_raenge[$user['ally_rank_id'] - 1]['administrieren'] == 1 || $ally['ally_owner'] == $user['id'])
          $user_admin = true;
      else
          $user_admin = false;
      
      if ($allianz_raenge[$user['ally_rank_id'] - 1]['onlinestatus'] == 1 || $ally['ally_owner'] == $user['id'])
          $user_onlinestatus = true;
      else
          $user_onlinestatus = false;
      
      if (!$ally)
        {
          doquery("UPDATE {{table}} SET `ally_id`=0 WHERE `id`='{$user['id']}'", "users");
          message($lang['ally_notexist'], $lang['your_alliance'], 'alliance.php');
        }
      
      if ($mode == 'exit')
        {
          if ($ally['ally_owner'] == $user['id'])
            {
              message($lang['Owner_cant_go_out'], $lang['Alliance']);
            }
          
          // On quitte l'alliance
          
          if ($_GET['yes'] == 1)
            {
              doquery("UPDATE {{table}} SET `ally_id`=0, `ally_name` = '' WHERE `id`='{$user['id']}'", "users");
              $lang['Go_out_welldone'] = str_replace("%s", $ally_name, $lang['Go_out_welldone']);
              $page = MessageForm($lang['Go_out_welldone'], "<br>", $PHP_SELF, $lang['Ok']);
              
              
              // On enleve les points de l'alliance
            }
          else
            {
              // Confirmation de sorti
              $lang['Want_go_out'] = str_replace("%s", $ally_name, $lang['Want_go_out']);
              $page = MessageForm($lang['Want_go_out'], "<br>", "?mode=exit&yes=1", "Oui");
            }
          display($page);
        }
      if ($mode == 'memberslist')
        {
          // Liste des membres
          
          
          
          // On obtient les array des membres
          // $ally_ranks = unserialize($ally['ally_ranks']);
          $allianz_raenge = unserialize($ally['ally_ranks']);
          // $user_can_watch_memberlist
          
          // On regarde les permissions
          if ($ally['ally_owner'] != $user['id'] && !$user_can_watch_memberlist)
            {
              message($lang['Denied_access'], $lang['Members_list']);
            }
          
          // L'odre d'apparition
          if ($sort2)
            {
              $sort1 = intval($_GET['sort1']);
              $sort2 = intval($_GET['sort2']);
              
              if ($sort1 == 1)
                {
                  $sort = " ORDER BY `username`";
                }
              elseif ($sort1 == 2)
                {
                  $sort = " ORDER BY `username`";
                }
              elseif ($sort1 == 3)
                {
                 $sort = " ORDER BY `total_points`";
                }
              elseif ($sort1 == 4)
                {
                  $sort = " ORDER BY `ally_register_time`";
                }
              elseif ($sort1 == 5)
                {
                  $sort = " ORDER BY `onlinetime`";
                }
              else
                {
                  $sort = " ORDER BY `id`";
                }
              
              if ($sort2 == 1)
                {
                  $sort .= " DESC;";
                }
              elseif ($sort2 == 2)
                {
                  $sort .= " ASC;";
                }
              $listuser = doquery("SELECT * FROM {{table}} inner join `game_statpoints` on `game_users`.`id`=`game_statpoints`.`id_owner` WHERE ally_id='{$user['ally_id']}' AND STAT_type=1 $sort", 'users');
            }
          else
            {
              $listuser = doquery("SELECT * FROM {{table}} WHERE ally_id='{$user['ally_id']}'", 'users');
            }
          
          // On compte le nombre de membres
          
          $i = 0;
          // Row Templates
          $template = gettemplate('alliance_memberslist_row');
          $page_list = '';
          while ($u = mysql_fetch_array($listuser)) {
         $UserPoints = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $u['id'] . "';", 'statpoints', true);

         $i=$i+1;
         $u['i'] = $i;

         if ($u["onlinetime"] + 60 * 10 >= time() && $user_can_watch_memberlist_status) {
            $u["onlinetime"] = "lime>{$lang['On']}<";
         } elseif ($u["onlinetime"] + 60 * 20 >= time() && $user_can_watch_memberlist_status) {
            $u["onlinetime"] = "yellow>{$lang['15_min']}<";
         } elseif ($user_can_watch_memberlist_status) {
            $u["onlinetime"] = "red>{$lang['Off']}<";
         } else $u["onlinetime"] = "orange>-<";
         // Nombre de rango
         if ($ally['ally_owner'] == $u['id']) {
            $u["ally_range"] = ($ally['ally_owner_range'] == '')?$lang['Founder']:$ally['ally_owner_range'];
         } elseif ($u['ally_rank_id'] == 0 ) {
            $u["ally_range"] = $lang['Novate'];
         } else {
            $u["ally_range"] = $allianz_raenge[$u['ally_rank_id']-1]['name'];         
         }  
              
              $u["dpath"] = $dpath;
              $u['points'] = "" . pretty_number($UserPoints['total_points']) . "";
              
              if ($u['ally_register_time'] > 0)
                  $u['ally_register_time'] = date("Y-m-d h:i:s", $u['ally_register_time']);
              else
                  $u['ally_register_time'] = "-";
              
              $page_list .= parsetemplate($template, $u);
            }
          // Pour changer le lien d'ordre
          
          if ($sort2 == 1)
            {
              $s = 2;
            }
          elseif ($sort2 == 2)
            {
              $s = 1;
            }
          else
            {
              $s = 1;
            }
          
          if ($i != $ally['ally_members'])
            {
              doquery("UPDATE {{table}} SET `ally_members`='{$i}' WHERE `id`='{$ally['id']}'", 'alliance');
            }
          
          $parse = $lang;
          $parse['i'] = $i;
          $parse['s'] = $s;
          $parse['list'] = $page_list;
          
          $page .= parsetemplate(gettemplate('alliance_memberslist_table'), $parse);
          
          display($page, $lang['Members_list']);
        }
      
      if ($mode == 'circular')
        {
          // Message Collectif
          
          // Un loop pour montrer les rangs 
          $allianz_raenge = unserialize($ally['ally_ranks']);
          
          // On regarde les permissions
          if ($ally['ally_owner'] != $user['id'] && !$user_can_send_mails)
            {
              message($lang['Denied_access'], $lang['Send_circular_mail']);
            }
          
          if ($sendmail == 1)
            {
              $_POST['r'] = intval($_POST['r']);
              $_POST['text'] = mysql_escape_string(strip_tags($_POST['text']));
              
              if ($_POST['r'] == 0)
                {
                  $sq = doquery("SELECT id,username FROM {{table}} WHERE ally_id='{$user['ally_id']}'", "users");
                }
              else
                {
                  $sq = doquery("SELECT id,username FROM {{table}} WHERE ally_id='{$user['ally_id']}' AND ally_rank_id='{$_POST['r']}'", "users");
                }
              
              // Loop
              $list = '';
              while ($u = mysql_fetch_array($sq))
                {
                  doquery("INSERT INTO {{table}} SET
        `message_owner`='{$u['id']}',
        `message_sender`='{$user['id']}' ,
        `message_time`='" . time() . "',
        `message_type`='2',
        `message_from`='{$ally['ally_tag']}',
        `message_subject`='{$user['username']}',
        `message_text`='{$_POST['text']}'
        ", "messages");
                  $list .= "<br>{$u['username']} ";
                }
              // doquery("SELECT id,username FROM {{table}} WHERE ally_id='{$user['ally_id']}' ORDER BY `id`","users");
              doquery("UPDATE {{table}} SET `new_message`= '+1' WHERE ally_id='{$user['ally_id']}' AND ally_rank_id='{$_POST['r']}'", "users");
              doquery("UPDATE {{table}} SET `mnl_alliance`= '+1' WHERE ally_id='{$user['ally_id']}' AND ally_rank_id='{$_POST['r']}'", "users");
              // Un petit message pour dire a qui on l'envoi ^^
              
              $page = MessageForm($lang['Circular_sended'], "Les membres suivants ont re&ccedil;u un message:" . $list, "alliance.php", $lang['Ok'], true);
              display($page, $lang['Send_circular_mail']);
            }
          
          $lang['r_list'] = "<option value=\"0\">{$lang['All_players']}</option>";
          if ($allianz_raenge)
            {
              foreach ($allianz_raenge as $id => $array)
                {
                  $lang['r_list'] .= "<option value=\"" . ($id + 1) . "\">" . $array['name'] . "</option>";
                }
            }
          
          $page .= parsetemplate(gettemplate('alliance_circular'), $lang);
          
          display($page, $lang['Send_circular_mail']);
        }
      
      // Administrer les regles
      
      if ($mode == 'admin' && $edit == 'rights')
        {
          $allianz_raenge = unserialize($ally['ally_ranks']);
          
          if ($ally['ally_owner'] != $user['id'] && !$user_can_edit_rights)
            {
              message($lang['Denied_access'], $lang['Members_list']);
            }
          elseif (!empty($_POST['newrangname']))
            {
              $name = mysql_escape_string(strip_tags($_POST['newrangname']));
              
              $allianz_raenge[] = array('name' => $name, 'mails' => 0, 'delete' => 0, 'kick' => 0, 'bewerbungen' => 0, 'administrieren' => 0, 'bewerbungenbearbeiten' => 0, 'memberlist' => 0, 'onlinestatus' => 0, 'rechtehand' => 0);
              
              $ranks = serialize($allianz_raenge);
              
              doquery("UPDATE {{table}} SET `ally_ranks`='" . $ranks . "' WHERE `id`=" . $ally['id'], "alliance");
              
              $goto = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
              
              header("Location: " . $goto);
              exit();
            }
          elseif ($_POST['id'] != '' && is_array($_POST['id']))
            {
              $ally_ranks_new = array();
              
              foreach ($_POST['id'] as $id)
                {
                  $name = $allianz_raenge[$id]['name'];
                  
                  $ally_ranks_new[$id]['name'] = $name;
                  
                  if (isset($_POST['u' . $id . 'r0']))
                    {
                      $ally_ranks_new[$id]['delete'] = 1;
                    }
                  else
                    {
                      $ally_ranks_new[$id]['delete'] = 0;
                    }
                  
                  if (isset($_POST['u' . $id . 'r1']) && $ally['ally_owner'] == $user['id'])
                    {
                      $ally_ranks_new[$id]['kick'] = 1;
                    }
                  else
                    {
                      $ally_ranks_new[$id]['kick'] = 0;
                    }
                  
                  if (isset($_POST['u' . $id . 'r2']))
                    {
                      $ally_ranks_new[$id]['bewerbungen'] = 1;
                    }
                  else
                    {
                      $ally_ranks_new[$id]['bewerbungen'] = 0;
                    }
                  
                  if (isset($_POST['u' . $id . 'r3']))
                    {
                      $ally_ranks_new[$id]['memberlist'] = 1;
                    }
                  else
                    {
                      $ally_ranks_new[$id]['memberlist'] = 0;
                    }
                  
                  if (isset($_POST['u' . $id . 'r4']))
                    {
                      $ally_ranks_new[$id]['bewerbungenbearbeiten'] = 1;
                    }
                  else
                    {
                      $ally_ranks_new[$id]['bewerbungenbearbeiten'] = 0;
                    }
                  
                  if (isset($_POST['u' . $id . 'r5']))
                    {
                      $ally_ranks_new[$id]['administrieren'] = 1;
                    }
                  else
                    {
                      $ally_ranks_new[$id]['administrieren'] = 0;
                    }
                  
                  if (isset($_POST['u' . $id . 'r6']))
                    {
                      $ally_ranks_new[$id]['onlinestatus'] = 1;
                    }
                  else
                    {
                      $ally_ranks_new[$id]['onlinestatus'] = 0;
                    }
                  
                  if (isset($_POST['u' . $id . 'r7']))
                    {
                      $ally_ranks_new[$id]['mails'] = 1;
                    }
                  else
                    {
                      $ally_ranks_new[$id]['mails'] = 0;
                    }
                  
                  if (isset($_POST['u' . $id . 'r8']))
                    {
                      $ally_ranks_new[$id]['rechtehand'] = 1;
                    }
                  else
                    {
                      $ally_ranks_new[$id]['rechtehand'] = 0;
                    }
                }
              
              $ranks = serialize($ally_ranks_new);
              
              doquery("UPDATE {{table}} SET `ally_ranks`='" . $ranks . "' WHERE `id`=" . $ally['id'], "alliance");
              
              $goto = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
              
              header("Location: " . $goto);
              exit();
            }
          
          // Effac&eacute; une entrer
          elseif (isset($d) && isset($ally_ranks[$d]))
            {
              unset($ally_ranks[$d]);
              $ally['ally_rank'] = serialize($ally_ranks);
              
              doquery("UPDATE {{table}} SET `ally_ranks`='{$ally['ally_rank']}' WHERE `id`={$ally['id']}", "alliance");
            }
          
          if (count($ally_ranks) == 0 || $ally_ranks == '')
            {
              // si il n'y as pas de rang
              $list = "<th>{$lang['There_is_not_range']}</th>";
            }
          else
            {
              // Si il y a un rang
              // On chage le template de la table 
              $list = parsetemplate(gettemplate('alliance_admin_laws_head'), $lang);
              $template = gettemplate('alliance_admin_laws_row');
              // On creer la liste des rangs
              $i = 0;
              
              foreach ($ally_ranks as $a => $b)
                {
                  if ($ally['ally_owner'] == $user['id'])
                    {
                      // $i++;u2r5
                      $lang['id'] = $a;
                      $lang['delete'] = "<a href=\"alliance.php?mode=admin&edit=rights&d={$a}\"><img src=\"{$dpath}pic/abort.gif\" alt=\"{$lang['Delete_range']}\" border=0></a>";
                      $lang['r0'] = $b['name'];
                      $lang['a'] = $a;
                      //{$b[1]}
                      $lang['r1'] = "<input type=checkbox name=\"u{$a}r0\"" . (($b['delete'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r2'] = "<input type=checkbox name=\"u{$a}r1\"" . (($b['kick'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r3'] = "<input type=checkbox name=\"u{$a}r2\"" . (($b['bewerbungen'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r4'] = "<input type=checkbox name=\"u{$a}r3\"" . (($b['memberlist'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r5'] = "<input type=checkbox name=\"u{$a}r4\"" . (($b['bewerbungenbearbeiten'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r6'] = "<input type=checkbox name=\"u{$a}r5\"" . (($b['administrieren'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r7'] = "<input type=checkbox name=\"u{$a}r6\"" . (($b['onlinestatus'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r8'] = "<input type=checkbox name=\"u{$a}r7\"" . (($b['mails'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r9'] = "<input type=checkbox name=\"u{$a}r8\"" . (($b['rechtehand'] == 1) ? ' checked="checked"' : '') . ">";
                      
                      $list .= parsetemplate($template, $lang);
                    }
                  else
                    {
                      $lang['id'] = $a;
                      $lang['r0'] = $b['name'];
                      $lang['delete'] = "<a href=\"alliance.php?mode=admin&edit=rights&d={$a}\"><img src=\"{$dpath}pic/abort.gif\" alt=\"{$lang['Delete_range']}\" border=0></a>";
                      $lang['a'] = $a;
                      $lang['r1'] = "<b>-</b>";
                      $lang['r2'] = "<input type=checkbox name=\"u{$a}r1\"" . (($b['kick'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r3'] = "<input type=checkbox name=\"u{$a}r2\"" . (($b['bewerbungen'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r4'] = "<input type=checkbox name=\"u{$a}r3\"" . (($b['memberlist'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r5'] = "<input type=checkbox name=\"u{$a}r4\"" . (($b['bewerbungenbearbeiten'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r6'] = "<input type=checkbox name=\"u{$a}r5\"" . (($b['administrieren'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r7'] = "<input type=checkbox name=\"u{$a}r6\"" . (($b['onlinestatus'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r8'] = "<input type=checkbox name=\"u{$a}r7\"" . (($b['mails'] == 1) ? ' checked="checked"' : '') . ">";
                      $lang['r9'] = "<input type=checkbox name=\"u{$a}r8\"" . (($b['rechtehand'] == 1) ? ' checked="checked"' : '') . ">";
                      
                      $list .= parsetemplate($template, $lang);
                    }
                }
              
              if (count($ally_ranks) != 0)
                {
                  $list .= parsetemplate(gettemplate('alliance_admin_laws_feet'), $lang);
                }
            }
          
          $lang['list'] = $list;
          $lang['dpath'] = $dpath;
          $page .= parsetemplate(gettemplate('alliance_admin_laws'), $lang);
          
          display($page, $lang['Law_settings']);
        }
      
      if ($mode == 'admin' && $edit == 'ally')
        {
          // Administrer l'alliance 
          if ($t != 1 && $t != 2 && $t != 3)
            {
              $t = 1;
            }
          // post!
          if ($_POST)
            {
              if (!get_magic_quotes_gpc())
                {
                  $_POST['owner_range'] = stripslashes($_POST['owner_range']);
                  $_POST['web'] = stripslashes($_POST['web']);
                  $_POST['image'] = stripslashes($_POST['image']);
                  $_POST['text'] = stripslashes($_POST['text']);
                }
            }
          
          if ($_POST['options'])
            {
              $ally['ally_owner_range'] = mysql_escape_string(htmlspecialchars(strip_tags($_POST['owner_range'])));
              
              $ally['ally_web'] = mysql_escape_string(htmlspecialchars(strip_tags($_POST['web'])));
              
              $ally['ally_image'] = mysql_escape_string(htmlspecialchars(strip_tags($_POST['image'])));
              
              $ally['ally_request_notallow'] = intval($_POST['request_notallow']);
              
              if ($ally['ally_request_notallow'] != 0 && $ally['ally_request_notallow'] != 1)
                {
                  message("Aller &agrave; \"Candidature\" et sur une option dans le formulaire!", "Erreur");
                  exit;
                }
              
              doquery("UPDATE {{table}} SET
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
                  $ally['ally_request'] = mysql_escape_string(strip_tags($_POST['text']));
                  
                  doquery("UPDATE {{table}} SET
        `ally_request`='{$ally['ally_request']}'
        WHERE `id`='{$ally['id']}'", "alliance");
                }
              elseif ($t == 2)
                {
                  $ally['ally_text'] = mysql_escape_string(strip_tags($_POST['text']));
                  doquery("UPDATE {{table}} SET
        `ally_text`='{$ally['ally_text']}'
        WHERE `id`='{$ally['id']}'", "alliance");
                }
              else
                {
                  $ally['ally_description'] = mysql_escape_string(strip_tags(stripslashes($_POST['text'])));
                  
                  doquery("UPDATE {{table}} SET
        `ally_description`='" . $ally['ally_description'] . "'
        WHERE `id`='{$ally['id']}'", "alliance");
                }
              header('Location:alliance.php');
            }
          $lang['dpath'] = $dpath;
          
          if ($t == 3) {
         $lang['request_type'] = $lang['Show_of_request_text'];
      } elseif ($t == 2) {
         $lang['request_type'] = $lang['Internal_text'];
      } else {
         $lang['request_type'] = $lang['Public_text_of_alliance'];
      }

      if ($t == 2) {
         $lang['text'] = $ally['ally_text'];
         $lang['Texts'] = $lang['Texts'];
         $lang['Show_of_request_text'] = $lang['Internal_text_of_alliance'];
      } elseif ($t == 1) {
         $lang['text'] = $ally['ally_description'];
         $lang['Show_of_request_text'] = $lang['Public_text_of_alliance'];
      }   else {
          $lang['text'] = $ally['ally_request'];
         $lang['Show_of_request_text'] = $lang['Show_of_request_text'];
               } 
          $lang['t'] = $t;
          
          $lang['ally_web'] = $ally['ally_web'];
          $lang['ally_image'] = $ally['ally_image'];
          $lang['ally_request_notallow_0'] = (($ally['ally_request_notallow'] == 1) ? ' SELECTED' : '');
          $lang['ally_request_notallow_1'] = (($ally['ally_request_notallow'] == 0) ? ' SELECTED' : '');
          $lang['ally_owner_range'] = $ally['ally_owner_range'];
          $lang['Transfer_alliance'] = MessageForm($lang['Transfer_alliance'], "", "?mode=admin&edit=transfer", $lang['Continue']); 
          $lang['Disolve_alliance'] = MessageForm("Allyanz aufloesen??", "", "?mode=admin&edit=exit", $lang['Continue']);
          
          $page .= parsetemplate(gettemplate('alliance_admin'), $lang);
          display($page, $lang['Alliance_admin']);
        }
      
      if ($mode == 'admin' && $edit == 'members')
        {
          // Administrer les membres
          /*
           Dans l'administration des membres , on peut definir les rangs
           Pour donner les differents rang
           */
          // On Teste les permissions
          if ($ally['ally_owner'] != $user['id'] && $user_admin == false) {
         message($lang['Denied_access'], $lang['Members_list']);
         } 
          
          /*
           Vrer des membres demande a etre numero 1
           */
          if (isset($kick))
            {
              if ($ally['ally_owner'] != $user['id'] && !$user_can_kick)
                {
                  message($lang['Denied_access'], $lang['Members_list']);
                }
              
              $u = doquery("SELECT * FROM {{table}} WHERE id='{$kick}' LIMIT 1", 'users', true);
              // On vire !
              if ($u['ally_id'] == $ally['id'] && $u['id'] != $ally['ally_owner'])
                {
                  doquery("UPDATE {{table}} SET `ally_id`='0' WHERE `id`='{$u['id']}'", 'users');
                }
            }
          elseif (isset($_POST['newrang']))
            {
              $q = doquery("SELECT * FROM {{table}} WHERE id='{$u}' LIMIT 1", 'users', true);
              
              if ((isset($ally_ranks[$_POST['newrang'] - 1]) || $_POST['newrang'] == 0) && $q['id'] != $ally['ally_owner'])
                {
                  doquery("UPDATE {{table}} SET `ally_rank_id`='" . mysql_escape_string(strip_tags($_POST['newrang'])) . "' WHERE `id`='" . intval($id) . "'", 'users');
                }
            }
          // On obtient les template row
          $template = gettemplate('alliance_admin_members_row');
          $f_template = gettemplate('alliance_admin_members_function');
          // L'ordre D'apparition
          if ($sort2)
            {
              // agresser le =0 pour les coordonn&eacute;es...
              if ($sort1 == 1)
                {
                  $sort = " ORDER BY `username`";
                }
              elseif ($sort1 == 2)
                {
                  $sort = " ORDER BY `username`";
                }
              elseif ($sort1 == 3)
                {
                  $sort = " ORDER BY `points_planets`";
                }
              elseif ($sort1 == 4)
                {
                  $sort = " ORDER BY `ally_register_time`";
                }
              elseif ($sort1 == 5)
                {
                  $sort = " ORDER BY `onlinetime`";
                }
              else
                {
                  $sort = " ORDER BY `id`";
                }
              
              if ($sort2 == 1)
                {
                  $sort .= " DESC;";
                }
              elseif ($sort2 == 2)
                {
                  $sort .= " ASC;";
                }
              $listuser = doquery("SELECT * FROM {{table}} WHERE ally_id='{$user['ally_id']}'{$sort}", 'users');
            }
          else
            {
              $listuser = doquery("SELECT * FROM {{table}} WHERE ally_id={$user['ally_id']}", 'users');
            }
          
          // On compte le nombre de membres
          $i = 0;
          
          // Row templates
          
          $page_list = '';
          $lang['memberzahl'] = mysql_num_rows($listuser);
          
          while ($u = mysql_fetch_array($listuser))
            {
              $UserPoints = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $u['id'] . "';", 'statpoints', true);
              $i++;
              $u['i'] = $i;
              
              // Combien de jours il est inactif ?
              $u['points'] = "" . pretty_number($UserPoints['total_points']) . "";
              $days = floor(round(time() - $u["onlinetime"]) / 3600 % 24);
              $u["onlinetime"] = str_replace("%s", $days, "%s d");
              
              // Nombre du rang 
              
              if ($ally['ally_owner'] == $u['id'])
                {
                  $ally_range = ($ally['ally_owner_range'] == '') ? $lang['Founder'] : $ally['ally_owner_range'];
                }
              elseif ($u['ally_rank_id'] == 0 || !isset($ally_ranks[$u['ally_rank_id'] - 1]['name']))
                {
                  $ally_range = $lang['Novate'];
                }
              else
                {
                  $ally_range = $ally_ranks[$u['ally_rank_id'] - 1]['name'];
                }
              
              // Parti un peut chiante xD 
              
              if ($ally['ally_owner'] == $u['id'] || $rank == $u['id'])
                {
                  $u["functions"] = '';
                }
              elseif ($allianz_raenge[$user['ally_rank_id']-1]['administrieren'] == 1 || $ally['ally_owner'] == $user['id'])
                {
                  $f['dpath'] = $dpath;
                  $f['Expel_user'] = $lang['Expel_user'];
                  $f['Set_range'] = $lang['Set_range'];
                  $f['You_are_sure_want_kick_to'] = str_replace("%s", $u['username'], $lang['You_are_sure_want_kick_to']);
                  $f['id'] = $u['id'];
                  $u["functions"] = parsetemplate($f_template, $f);
                }
              else
                {
                  $u["functions"] = '';
                }
              $u["dpath"] = $dpath;
              
              // Pour le formulaire
              
              if ($rank != $u['id'])
                {
                  $u['ally_range'] = $ally_range;
                }
              else
                {
                  $u['ally_range'] = '';
                }
              $u['ally_register_time'] = date("Y-m-d h:i:s", $u['ally_register_time']);
              $page_list .= parsetemplate($template, $u);
              if ($rank == $u['id'])
                {
                  $r['Rank_for'] = str_replace("%s", $u['username'], $lang['Rank_for']);
                  $r['options'] .= "<option value=\"0\">{$lang['Novate']}</option>";
                  
                  foreach ($ally_ranks as $a => $b)
                    {
                      $r['options'] .= "<option value=\"" . ($a + 1) . "\"";
                      if ($u['ally_rank_id'] - 1 == $a)
                        {
                          $r['options'] .= ' selected=selected';
                        }
                      $r['options'] .= ">{$b['name']}</option>";
                    }
                  $r['id'] = $u['id'];
                  $r['Save'] = $lang['Save'];
                  $page_list .= parsetemplate(gettemplate('alliance_admin_members_row_edit'), $r);
                }
            }
          
          // Pour changer l'odre du lien 
          
          if ($sort2 == 1)
            {
              $s = 2;
            }
          elseif ($sort2 == 2)
            {
              $s = 1;
            }
          else
            {
              $s = 1;
            }
          
          if ($i != $ally['ally_members'])
            {
              doquery("UPDATE {{table}} SET `ally_members`='{$i}' WHERE `id`='{$ally['id']}'", 'alliance');
            }
          
          $lang['memberslist'] = $page_list;
          $lang['s'] = $s;
          $page .= parsetemplate(gettemplate('alliance_admin_members_table'), $lang);
          
          display($page, $lang['Members_administrate']);
        }
      
      if ($mode == 'admin' && $edit == 'requests')
        {
          // Administrer candidature
          if ($ally['ally_owner'] != $user['id'] && !$user_bewerbungen_bearbeiten)
            {
              message($lang['Denied_access'], $lang['Check_the_requests']);
            }
          
          if ($_POST['action'] == "Accepter")
            {
              $_POST['text'] = mysql_escape_string(strip_tags($_POST['text']));
              
              $u = doquery("SELECT * FROM {{table}} WHERE id=$show", 'users', true);
              // On insere les points dans l'alliance 
              doquery("UPDATE {{table}} SET
      ally_members=ally_members+1
      WHERE id='{$ally['id']}'", 'alliance');
              
              doquery("UPDATE {{table}} SET
      ally_name='{$ally['ally_name']}',
      ally_request_text='',
      ally_request='0',
      ally_id='{$ally['id']}',
      new_message=new_message+1,
      mnl_alliance=mnl_alliance+1
      WHERE id='{$show}'", 'users');
              // On envoi un message d'information
              
              doquery("INSERT INTO {{table}} SET
      `message_owner`='{$show}',
      `message_sender`='{$user['id']}' ,
      `message_time`='" . time() . "',
      `message_type`='2',
      `message_from`='{$ally['ally_tag']}',
      `message_subject`='[" . $ally['ally_name'] . "] vous a acceptee!',
      `message_text`='Bravo!<br>L\'Alliance <b>" . $ally['ally_name'] . "</b> a acceptee votre candidature!<br>Charte:<br>" . $_POST['text'] . "'", "messages");
              
              header('Location:alliance.php?mode=admin&edit=requests');
              die();
            }
          elseif ($_POST['action'] == "Refuser" && $_POST['action'] != '')
            {
              $_POST['text'] = mysql_escape_string(strip_tags($_POST['text']));
              
              doquery("UPDATE {{table}} SET ally_request_text='',ally_request='0',ally_id='0',new_message=new_message+1, mnl_alliance=mnl_alliance+1 WHERE id='{$show}'", 'users');
              // On envoi un message d'information
              doquery("INSERT INTO {{table}} SET
      `message_owner`='{$show}',
      `message_sender`='{$user['id']}' ,
      `message_time`='" . time() . "',
      `message_type`='2',
      `message_from`='{$ally['ally_tag']}',
      `message_subject`='[" . $ally['ally_name'] . "] vous as refuse!',
      `message_text`='Hi!<br>L\'Alliance <b>" . $ally['ally_name'] . "</b> a refusee votre candidature!<br>Begr&uuml;ndung/Text:<br>" . $_POST['text'] . "'", "messages");
              
              header('Location:alliance.php?mode=admin&edit=requests');
              die();
            }
          
          $row = gettemplate('alliance_admin_request_row');
          $i = 0;
          $parse = $lang;
          $query = doquery("SELECT id,username,ally_request_text,ally_register_time FROM {{table}} WHERE ally_request='{$ally['id']}'", 'users');
          while ($r = mysql_fetch_array($query))
            {
              // On recolte les donn&eacute;e de celui qu'on a choisi 
              if (isset($show) && $r['id'] == $show)
                {
                  $s['username'] = $r['username'];
                  $s['ally_request_text'] = nl2br($r['ally_request_text']);
                  $s['id'] = $r['id'];
                }
              // la date de quand la candidature a &eacute;t&eacute; envoy&eacute;
              $r['time'] = date("Y-m-d h:i:s", $r['ally_register_time']);
              $parse['list'] .= parsetemplate($row, $r);
              $i++;
            }
          if ($parse['list'] == '')
            {
              $parse['list'] = '<tr><th colspan=2>Il ne reste plus aucune candidature</th></tr>';
            }
          // Avec $show
          if (isset($show) && $show != 0 && $parse['list'] != '')
            {
              // Les donn&eacute;es des candidatures
              $s['Request_from'] = str_replace('%s', $s['username'], $lang['Request_from']);
              // Formulaire
              $parse['request'] = parsetemplate(gettemplate('alliance_admin_request_form'), $s);
              $parse['request'] = parsetemplate($parse['request'], $lang);
            }
          else
            {
              $parse['request'] = '';
            }
          
          $parse['ally_tag'] = $ally['ally_tag'];
          $parse['Back'] = $lang['Back'];
          
          $parse['There_is_hanging_request'] = str_replace('%n', $i, $lang['There_is_hanging_request']);
          // $parse['list'] = $lang['Return_to_overview'];
          $page = parsetemplate(gettemplate('alliance_admin_request_table'), $parse);
          display($page, $lang['Check_the_requests']);
        }
      
      if ($mode == 'admin' && $edit == 'name')
        {
          // Changer le nom de l'alliance
          
          $ally_ranks = unserialize($ally['ally_ranks']);
          // On teste les permissions
          if ($ally['ally_owner'] != $user['id'] && !$user_admin)
            {
              message($lang['Denied_access'], $lang['Members_list']);
            }
          
          if ($_POST['newname'])
            {
              // Y a le nouveau Nom
              $ally['ally_name'] = mysql_escape_string(strip_tags($_POST['newname']));
              doquery("UPDATE {{table}} SET `ally_name` = '" . $ally['ally_name'] . "' WHERE `id` = '" . $user['ally_id'] . "';", 'alliance');
              doquery("UPDATE {{table}} SET `ally_name` = '" . $ally['ally_name'] . "' WHERE `ally_id` = '" . $ally['id'] . "';", 'users');
            }
          
          $parse['old_name'] = $ally['ally_name'];
          $parse['New_name'] = $lang['New_name'];
          $parse['Change'] = $lang['Change'];
          $parse['name'] = 'newname';
          $parse['Return_to_overview'] = $lang['Return_to_overview'];
          $parse['Question'] = 'Namen der Allyanz aendern?.';
          $parse['New_name'] = 'Neuer Name : ';
          $parse['Change_name'] = 'Ok';
          $page .= parsetemplate(gettemplate('alliance_admin_rename'), $parse);
          display($page, $lang['Alliance_admin']); 
        }
      
      if ($mode == 'admin' && $edit == 'tag')
        {
          // Changer le TAG l'alliance
          $ally_ranks = unserialize($ally['ally_ranks']);
          
          // Bon si on verifiait les autorisation ?
          if ($ally['ally_owner'] != $user['id'] && !$user_admin)
            {
              message($lang['Denied_access'], $lang['Members_list']);
            }
          
          if ($_POST['newtag'])
            {
              // Y a le nouveau TAG
              $ally['ally_tag'] = mysql_escape_string(strip_tags($_POST['newtag']));
              doquery("UPDATE {{table}} SET `ally_tag` = '" . $ally['ally_tag'] . "' WHERE `id` = '" . $user['ally_id'] . "';", 'alliance');
            }
          
          $parse['old_name'] = $ally['ally_tag'];
          $parse['New_name'] = $lang['New_name'];
          $parse['Change'] = $lang['Change'];
          $parse['name'] = 'newtag';
          $parse['Return_to_overview'] = $lang['Return_to_overview'];
          $parse['Question'] = 'Wechseln des Allyanz TAG';
          $parse['New_name'] = 'Neuer TAG : ';
          $parse['Change_name'] = 'Ok';
          $page .= parsetemplate(gettemplate('alliance_admin_rename'), $parse);
          display($page, $lang['Alliance_admin']);
        }
      
      if ($mode == 'admin' && $edit == 'exit')
        {
          // disoudre une alliance
          // On obtient l'array des rangs
          $ally_ranks = unserialize($ally['ally_ranks']);
          // On teste les permissions
          if ($ally['ally_owner'] != $user['id'] && !$user_can_exit_alliance)
            {
              message($lang['Denied_access'], $lang['Members_list']);
            }
          
          doquery("DELETE FROM {{table}} WHERE id='{$ally['id']}'", "alliance");
          header('Location: alliance.php');
          exit;
        }
		// Transferer l alliance ....
   if ($mode == 'admin' && $edit == 'transfer') {
      
      if (isset($_POST['newleader'])) {
         doquery("UPDATE {{table}} SET `ally_rank_id`='0' WHERE `id`={$user['id']} ", 'users');      
         doquery("UPDATE {{table}} SET `ally_owner`='" . mysql_escape_string(strip_tags($_POST['newleader'])) . "' WHERE `id`={$user['ally_id']} ", 'alliance');
         doquery("UPDATE {{table}} SET `ally_rank_id`='0' WHERE `id`='" . mysql_escape_string(strip_tags($_POST['newleader'])) . "' ", 'users');
         header('Location: alliance.php');
          exit;
      }
      // 
      if ($ally['ally_owner'] != $user['id']) {
         message($lang['Denied_access'], $lang['Members_list']);
      } else {
      // 
      $rangos_alianza = unserialize($ally['ally_ranks']);
      //
      $listuser = doquery("SELECT * FROM {{table}} WHERE ally_id='{$user['ally_id']}'", 'users');
      // 
      $i = 0;
      // 
      $template1 = gettemplate('alliance_admin_transfer_row');
      $page_list1 = '';
      //
      while ($u = mysql_fetch_array($listuser)) {
         $i=$i+1;
         $u['i'] = $i;
         if ($ally['ally_owner'] == $u['id']) {
         //
         } elseif ($u['ally_rank_id'] == 0 ) {
         //
         } else {
             if ($rangos_alianza[$u['ally_rank_id']-1]['rechtehand'] == 1){
            //
            $righthand['righthand'] .= "\n<option value=\"" . $u['id'] . "\"";
            $righthand['righthand'] .= ">";
            $righthand['righthand'] .= "".$u['username'];
            $righthand['righthand'] .= "&nbsp;[".$rangos_alianza[$u['ally_rank_id']-1]['name'];
            $righthand['righthand'] .= "]&nbsp;&nbsp;</option>";
            }
            
         }
         //
         $righthand['transfer_to'] = $lang['transfer_to'];
          $righthand['transfer'] = $lang['transfer'];
         $righthand["dpath"] = $dpath;

      }
      //
      $page_list1 .= parsetemplate($template1, $righthand);
      $parse1 = $lang;
      $parse1['s'] = $s;
      $parse1['list'] = $page_list1;

      $page .= parsetemplate(gettemplate('alliance_admin_transfer'), $parse1);

      display($page, $lang['Members_list']);
   }
   } //Fin 
        {
          // Default 
          if ($ally['ally_owner'] != $user['id'])
            {
              $ally_ranks = unserialize($ally['ally_ranks']);
            }
          // Images de l'alliance
          if ($ally['ally_ranks'] != '')
            {
              $ally['ally_ranks'] = "<tr><td colspan=2><img src=\"{$ally['ally_image']}\"></td></tr>";
            }
          // temporaire
          if ($ally['ally_owner'] == $user['id'])
            {
              $range = ($ally['ally_owner_range'] != '') ? $lang['Founder'] : $ally['ally_owner_range'];
            }
          elseif ($user['ally_rank_id'] != 0 && isset($ally_ranks[$user['ally_rank_id'] - 1]['name']))
            {
              $range = $ally_ranks[$user['ally_rank_id'] - 1]['name'];
            }
          else
            {
              $range = $lang['member'];
            }
          // Le lien pour voir la liste des membres
          if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id'] - 1]['memberlist'] != 0)
            {
              $lang['members_list'] = " (<a href=\"?mode=memberslist\">{$lang['Members_list']}</a>)";
            }
          else
            {
              $lang['members_list'] = '';
            }
          // Le lien pour administrer l'alliance
          if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id'] - 1]['administrieren'] != 0)
            {
              $lang['alliance_admin'] = " (<a href=\"?mode=admin&edit=ally\">{$lang['Alliance_admin']}</a>)";
            }
          else
            {
              $lang['alliance_admin'] = '';
            }
          // Le lien de l'envoi du message collectif
          if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id'] - 1]['mails'] != 0)
            {
              $lang['send_circular_mail'] = "<tr><th>{$lang['Circular_message']}</th><th><a href=\"?mode=circular\">{$lang['Send_circular_mail']}</a></th></tr>";
            }
          else
            {
              $lang['send_circular_mail'] = '';
            }
          // Le lien pour voir les candidature
          $lang['requests'] = '';
          $request = doquery("SELECT id FROM {{table}} WHERE ally_request='{$ally['id']}'", 'users');
          $request_count = mysql_num_rows($request);
          if ($request_count != 0)
            {
              if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id'] - 1]['bewerbungen'] != 0)
                  $lang['requests'] = "<tr><th>{$lang['Requests']}</th><th><a href=\"alliance.php?mode=admin&edit=requests\">{$request_count} {$lang['XRequests']}</a></th></tr>";
            }
          if ($ally['ally_owner'] != $user['id'])
            {
              $lang['ally_owner'] .= MessageForm($lang['Exit_of_this_alliance'], "", "?mode=exit", $lang['Continue']);
            }
          else
            {
              $lang['ally_owner'] .= '';
            }
          // L'image du logo de l'alliance
          $lang['ally_image'] = ($ally['ally_image'] != '') ? "<tr><th colspan=2><img src=\"{$ally['ally_image']}\"></td></tr>" : '';
          // $ally_image =
          $lang['range'] = $range;
          // code rare
          $patterns[] = "#\[fc\]([a-z0-9\#]+)\[/fc\](.*?)\[/f\]#Ssi";
          $replacements[] = '<font color="\1">\2</font>';
          $patterns[] = '#\[img\](.*?)\[/img\]#Smi';
          $replacements[] = '<img src="\1" alt="\1" style="border:0px;" />';
          $patterns[] = "#\[fc\]([a-z0-9\#\ \[\]]+)\[/fc\]#Ssi";
          $replacements[] = '<font color="\1">';
          $patterns[] = "#\[/f\]#Ssi";
          $replacements[] = '</font>';
          $ally['ally_description'] = preg_replace($patterns, $replacements, $ally['ally_description']);
          $lang['ally_description'] = nl2br($ally['ally_description']);
          
          $ally['ally_text'] = preg_replace($patterns, $replacements, $ally['ally_text']);
          $lang['ally_text'] = nl2br($ally['ally_text']);
          
          $lang['ally_web'] = $ally['ally_web'];
          $lang['ally_tag'] = $ally['ally_tag'];
          $lang['ally_members'] = $ally['ally_members'];
          $lang['ally_name'] = $ally['ally_name'];
          
          $page .= parsetemplate(gettemplate('alliance_frontpage'), $lang);
          display($page, $lang['your_alliance']);
        }
    }
?>