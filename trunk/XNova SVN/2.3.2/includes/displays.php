<?php
//version 1.4.1
///REHACER DE NUEVO DA MUCHOS PROBLEMAS
if ( !defined('INSIDE') ) die(header("location:../"));
class displays extends TemplatePower{
    
    private $profiler;
    private $db         = '';
    private $topnav    ;
    private $menu       ;
    private $admin  ;
    public  $session;
    public  $tpl        ='.tpl';
    private $disable;
   

    function __construct(){
        global $db;
	$this->db=$db;
	$this->profiler = new PhpQuickProfiler(PhpQuickProfiler::getMicroTime());
    }

    
    public function assignContent($page, $topnav = true, $menu = true){
        
        global $users, $planetrow, $svn_root , $displays;
        
        $this->disable=($this->db->game_config["game_disable"]!=1 || $users->user[authlevel]!=0);
        
        $this->TemplatePower($svn_root . TEMPLATE_DIR  . "header".$this->tpl );
        $this->topnav     = $topnav;
        $this->menu       = $menu;
        
        $this->admin      = preg_match("/admin.php/i",$_SERVER["PHP_SELF"]);

        
        if(!defined('LOGIN') && $this->disable){
            if(!$this->admin ){
                if($this->topnav){
                    $this->assignInclude("topnav",$svn_root.TEMPLATE_DIR."topnav".$this->tpl);
                }
                if($this->menu){
                    $this->assignInclude("leftmenu",$svn_root.TEMPLATE_DIR."left_menu".$this->tpl);
                }
            }else{
                $this->assignInclude("leftmenu",$svn_root.TEMPLATE_DIR."adm/menu".$this->tpl);
                $this->assignInclude("topnav",$svn_root.TEMPLATE_DIR."adm/topnav".$this->tpl);
            }
        }
        $this->assignInclude("content",$svn_root.TEMPLATE_DIR.$page.$this->tpl);
        $this->prepare();
        
    }
   
    
    public function message($mes,$page = false,$time = 3,$topnav = false, $menu = true)
    {
        if($page){
            header('refresh:'.$time.'; url='.$page);
        }
        $this->assignContent('message_body', $topnav, $menu);
        $this->assign('mes', $mes);
        exit($this->display());
    }
    
    public function display($metatags = '')
    {
	global $dpath,$lang,  $users, $planetrow, $svn_root, $phpEx,$plugin;

        $this->gotoBlock("_ROOT");
        if(!INSTALL){
            $menu=$plugin->plugin_menu();
            $lang["lm_defenses"]    .= $menu["lm_defenses"];
            $lang["lm_search"]      .= $menu["lm_search"];
            $lang["lm_options"]     .= $menu["lm_options"];
            $lang["mu_connected"]   .= $menu["mu_connected"];
        }
        if(!$dpath){
            $dpath=DEFAULT_SKINPATH;
        }
        

        if ($this->topnav && !$this->admin){
	    $this->ShowTopNavigationBar($users->user, $planetrow);
	}
        
	if ($this->menu && !$this->admin){
            $this->ShowLeftMenu ($users->user['authlevel']);
	}
        
        
        if (!$this->admin && INSTALL==false){
		$DisplayPage  = $this->StdUserHeader($metatags);
        }else{
                $DisplayPage  = $this->AdminUserHeader($metatags);
	}

        foreach($DisplayPage as $name => $trans){
                $this->assign($name, $trans);
        }
		unset($DisplayPage);
        
        if ($this->db->game_config['debug'] == 1 && $users->user['authlevel']!=0){
            $lang["debug"]="<tr><th align=center><a style='color:red'   onclick='control_debug()' href=# >Debug Log</a></th></tr>";
	}
        if($this->db->game_config["publicidad"]){
            $publicidad=explode(";;",$this->db->game_config["publicidad"]);
                $a = "/\[codescript(.*?)\](.*?)\[\/codescript\]/is";
                $b = "<script $1>$2</script>";
                $a1 = "/\[codes\"\+\"cript(.*?)\](.*?)\[\/codes\"\+\"cript\]/is";
                $b2 = "<scr\"+\"ipt $1>$2</scr\"+\"ipt>";
            $lang['script_publicidad']   = preg_replace(array($a,$a1),array($b,$b2), stripslashes($publicidad[1]));
        }
        
        $lang['dpath']        	= $dpath;
        foreach($lang as $name => $trans){
            $this->assignGlobal($name, $trans);
        }
        
        $this->getOutputContent();
        $this->printToScreen();
        if ($this->db->game_config['debug'] == 1 && $users->user['authlevel']!=0){
            $this->profiler->display($this->db);
        }
        unset($lang);
        exit;
        
    }
    
    private function StdUserHeader ($metatags = '')
    {
	global $dpath, $svn_root;

        $parse=array();
        
	if($metatags){
            $parse['-title-'] 	.= $this->db->game_config['game_name']." - ".$metatags;
        }else{
            $parse['-title-'] 	.= $this->db->game_config['game_name'];
        }
        
        $parse['-favi-']	.= "<link rel=\"shortcut icon\" href=\"".$svn_root."favicon.ico\">\n";
	$parse['-meta-']	.= "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=iso-8859-1\">\n";
        $css=array();
	if(!defined('LOGIN')  )
	{
		//$parse['-style-']  	.= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$svn_root."styles/css/formate.css\">\n";
		//$parse['-style-'] 	.= "<link rel=\"stylesheet\" type=\"text/css\" href=\"". $dpath ."formate.css\" />\n";
                //$parse['-style-'] 	.= "<link rel=\"stylesheet\"  type=\"text/css\" href=\"".$svn_root."/styles/css/ui.all.css\">\n";
                
                $css[]  = $svn_root."styles/css/formate.css";
		$css[]	= $dpath ."formate.css";
                $css[] 	= $svn_root."/styles/css/ui.all.css";
               if(defined('INSTALL')){
                    $this->newblock("scripts_header");
                    $this->newblock("scripts_mensaje");
                    $this->newblock("mensaje");
                }

        }
	else
	{
                $css[]  = $svn_root."styles/css/styles.css";
                $css[] 	= $svn_root."styles/css/ui.all.css";
		//$parse['-style-']  	.= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$svn_root."styles/css/styles.css\">\n";
        }
         $i=0;
        $css_css="";
        foreach($css as $value){
            $css_css.="archivo$i=".encrypt($value)."&";//".encrypt($value)."&";
            $i++;
        }

        $parse['-style-'] 	.= "<link rel=\"stylesheet\"  type=\"text/css\" href=\"".$svn_root."css.php?{$css_css}skin=$dpath\">\n";

        $this->gotoBlock("_ROOT");

	$parse['-meta-']	.= "<script type=\"text/javascript\" src=\"".$svn_root."scripts/overlib.js\"></script>\n";

	return $parse;
    }

    private function AdminUserHeader ($metatags = '')
    {
	global $svn_root;
	if (!defined('IN_ADMIN')){
		$parse['-title-'] 	.= 	"Xnova SVN 2.3 - Instalación";
	}else{
                $this->newblock("scripts_header");
                    $this->newblock("scripts_mensaje");
                    $this->newblock("mensaje");
		$parse['-title-'] 	.= 	$this->db->game_config['game_name'] . " - Panel de Administración";
	}
        $this->gotoBlock("_ROOT");
	$parse['-favi-']	.= 	"<link rel=\"shortcut icon\" href=\"".$svn_root."favicon.ico\">\n";
	$parse['-style-']	.=	"<link rel=\"stylesheet\" type=\"text/css\" href=\"".$svn_root."styles/css/admin.css\">\n";
	$parse['-meta-']	.= 	"<script type=\"text/javascript\" src=\"".$svn_root."scripts/overlib.js\"></script>\n";
	$parse['-meta-'] 	.= ($metatags) ? $metatags : "";
	return $parse;
    }

    private function ShowTopNavigationBar ($CurrentUser, $CurrentPlanet)
    {
	global $dpath, $svn_root,$lang;

        $this->gotoBlock("topnav");

        if($CurrentUser['urlaubs_modus'] == 0 && isset($CurrentUser['urlaubs_modus'])){
                 PlanetResourceUpdate($CurrentUser, $CurrentPlanet, time());
        }else{
                $this->db->query("UPDATE {{table}} SET `deuterium_sintetizer_porcent` = 0, `metal_mine_porcent` = 0, `crystal_mine_porcent` = 0 WHERE id_owner = ".$CurrentUser['id'],"planets" );
        }
        
        $ThisUsersPlanets = SortUserPlanets ($CurrentUser);
       
	while ($CurPlanet = mysql_fetch_array($ThisUsersPlanets))
	{
		if ($CurPlanet["destruyed"] == 0){
                    if($CurPlanet['planet_type'] != 3){
		        $this->newblock('planetlist');
                    }else{
                    	$this->newblock('moonlist');
                    }
		    if ($CurPlanet['id'] == $CurrentUser['current_planet']){
                    	$CurPlanet['select'] = "selected=\"selected\" ";
                    }
                    $CurPlanet['page_topnav']   = $_GET['page'];
                    $CurPlanet['gid_topnav']    = $_GET['gid'];
                    $CurPlanet['mode_topnav']   = $_GET['mode'];
                    
                    foreach($CurPlanet as $name => $trans){
                        $this->assign($name, $trans);
                    }
                    unset($CurPlanet);
		}
                //FIX ABANDONO
                else {
                    if($CurPlanet["destruyed"]<time()){
                        $db->query("DELETE FROM `{{table}}` WHERE `id` = '{$CurPlanet['id']}'","planets");
                    }
                }
                //FIN FIX ABANDONO


	}

        $this->gotoBlock("_ROOT");

        $parse['image']      		= $CurrentPlanet['image'];
	$parse['show_umod_notice']      = $CurrentUser['urlaubs_modus'] ? '<table width="100%" style="border: 3px solid red; text-align:center;"><tr><td>' . $lang['tn_vacation_mode'] . date('d.m.Y h:i:s',$CurrentUser['urlaubs_until']).'</td></tr></table>' : '';
	
	$energy = pretty_number($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) . "/" . pretty_number($CurrentPlanet["energy_max"]);
	// Energie
	if (($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) < 0) {
		$parse['energy'] = colorRed($energy);
	} else {
		$parse['energy'] = $energy;
	}
	// Metal
	$metal=pretty_number($CurrentPlanet["metal"]);
	
	
	if (($CurrentPlanet["metal"] >= $CurrentPlanet["metal_max"])) {
		$parse['metal'] = colorRed($metal);
	} else {
		$parse['metal'] = $metal;
	}
	// Cristal
	$crystal = pretty_number($CurrentPlanet["crystal"]);
	if (($CurrentPlanet["crystal"] >= $CurrentPlanet["crystal_max"])) {
		$parse['crystal'] = colorRed($crystal);
	} else {
		$parse['crystal'] = $crystal;
	}
	// Deuterium
	$deuterium = pretty_number($CurrentPlanet["deuterium"]);
	if (($CurrentPlanet["deuterium"] >= $CurrentPlanet["deuterium_max"])) {
		$parse['deuterium'] = colorRed($deuterium);
	} else {
		$parse['deuterium'] = $deuterium;
	}
	if($CurrentUser["activate_status"]==0){
		$parse["show_umod_notice"]='<table width="100%" style="border: 3px solid red;position:relative; text-align:center;z-index:10000"><tr><td>Debes activar tu cuenta si quieres seguir jugando. <a href="'.$svn_root.'game.php?page=options&mode=activar">Activar tu Cuenta</a></td></tr></table>';
	}
	
	$parse['darkmatter'] 		= pretty_number($CurrentUser["darkmatter"]);
         
        foreach($parse as $name => $trans){
            $this->assign($name, $trans);
        }
        unset($parse);
    }
 
    private function ShowLeftMenu ($Level)
    {
	global $users,$plugin,$lang;
        
        
        $this->gotoBlock("leftmenu");

        $parse["id"]		= $users->user["id"];
	$parse["name"]		= $users->user["username"];
	$mess   = $this->db->query("SELECT count(*) as count FROM {{table}}
                            WHERE `message_owner` = '" . $users->user['id'] . "'
                            AND `message_read`='0'", 'messages',true);
        
        $Mess   = $mess["count"];
        
	$color=($Mess!=0) ? "color='red'" : "color='white'";

        $parse["new_message"]	= '<font size="1px">(<font size="1px" '.$color.' >'. $Mess.'</font>)</font>';
	
	$parse['version']   	= $this->db->game_config['VERSION'];
	$parse['servername']	= $this->db->game_config['game_name'];
	$parse['lm_tx_serv']	= $this->db->game_config['resource_multiplier'];
	$parse['lm_tx_game']    = $this->db->game_config['game_speed'] / 2500;
	$parse['lm_tx_fleet']   = $this->db->game_config['fleet_speed'] / 2500;
	$parse['lm_tx_queue']   = MAX_FLEET_OR_DEFS_PER_ROW;
	$parse['forum_url']     = $this->db->game_config['forum_url'];
	$parse['servername']   	= $this->db->game_config['game_name'];
	$parse['user_rank']     = $users->user['total_rank'];
	$parse['total']         = number_format($users->user['total_points'],0,",", ".");
	$parse['fleet']         = number_format($users->user['fleet_points'],0,",", ".");
	$parse['tech']          = number_format($users->user['tech_points'],0,",", ".");
	$parse['build']         = number_format($users->user['build_points'],0,",", ".");
	$parse['defs']          = number_format($users->user['defs_points'],0,",", ".");
	if($this->db->game_config["debug"] && $Level > 0){
		$parse['debug']		="<tr><td><div align=\"center\"><a href='#' style='color:red'   onclick='control_debug()'  >Debug Log</a></div></td></tr>";
	}
	if ($Level > 0){
		$parse['admin_link']	="<tr><td><div align=\"center\"><a href=\"javascript:top.location.href='admin.php?page=overview'\"> <font color=\"lime\">Administracion</font></a></div></td></tr>";
	}
        
        foreach($parse as $name => $trans){
            $this->assign($name, $trans);
        }
        
        unset($parse);
    }
    function __destruct(){
        unset($this->display,$_POST,$this->profiler,$this->db);
    }
}



?>