<?php //techtree.php :: Arbol Tecnologico v2.0

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);

includeLang('tech');

/*
  Crea la tabla con las diferentes tecnologias seguido de sus requerimientos minimos.
  Ademﾃ｡s checkea que se tenga esa tecnologia, y las colorea para su facil lectura.
*/
$head = gettemplate('techtree_head');
$row = gettemplate('techtree_row');
//Magia :D
foreach($lang['tech'] as $i => $n){

	$parse = array();
	$parse = array();
	$parse['n'] = $n;

	if(!isset($resource[$i])){
		
		$parse['Requirements'] = $lang['Requirements'];
		$page .= parsetemplate($head, $parse);
		
	}else{
		//se comprueba si se tienen los requerimientos necesarios
		if(isset($requeriments[$i])){
			
			$parse['required_list'] = "";
			
			foreach($requeriments[$i] as $r => $n){
				
				$parse['required_list'] .= "<font color=";
				
				if(isset($user[$resource[$r]]) && $user[$resource[$r]] >= $n){
					$parse['required_list'] .= "#00ff00";
				}elseif(isset($planetrow[$resource[$r]]) && $planetrow[$resource[$r]] >= $n){
					$parse['required_list'] .= "#00ff00";
				}else{
					$parse['required_list'] .= "#ff0000";
				}
				$parse['required_list'] .= ">{$lang['tech'][$r]}({$lang['level']} $n)</font><br>";
			}
			
		}else{
			
			$parse['required_list'] = "";
			
		}
		
		$parse['i'] = $i;
		$page .= parsetemplate($row, $parse);
		
	}
}

$parse['techtree_list'] = $page;
$page = parsetemplate(gettemplate('techtree_body'), $parse);
display($page,$lang['Tech']);

// Created by Perberos. All rights reversed (C) 2006
?>
