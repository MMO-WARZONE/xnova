<?php  //functions.php









function add_points($resources,$userid){

	return false;
}

function remove_points($resources,$userid){

	return false;
}
//
// Comprueba si un usario existe
//
function check_user(){
	//obtenemos las cookies y o userdata
	$row = checkcookies();
	
	if($row != false){
		global $user;
		$user = $row;
		return true;
	}
	return false;

}

//
// Obtiene una array de los datos de un jugador.
//
function get_userdata(){
 echo "pendiente";

}

//
// Comprueba si es una direccion de email valida
//
function is_email($email){
	
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
	
}

//
// Sirve para leer las cookies.
//
function checkcookies(){
	global $lang,$game_config,$ugamela_root_path,$phpEx;
	//mas adelante esta variable formara parte de la $game_config
	includeLang('cookies');
	include($ugamela_root_path.'config.'.$phpEx);
	$row = false;
	
	if (isset($_COOKIE[$game_config['COOKIE_NAME']]))
	{
		// Formato de la cookie:
		// {ID} {USERNAME} {PASSWORDHASH} {REMEMBERME}
		$theuser = explode(" ",$_COOKIE[$game_config['COOKIE_NAME']]);
		$query = doquery("SELECT * FROM {{table}} WHERE username='{$theuser[1]}'", "users");
		if (mysql_num_rows($query) != 1)
		{
			message($lang['cookies']['Error1']);
		}
		
		$row = mysql_fetch_array($query);
		if ($row["id"] != $theuser[0])
		{
			message($lang['cookies']['Error2']);
		}
		
		if (md5($row["password"]."--".$dbsettings["secretword"]) !== $theuser[2])
		{
			message($lang['cookies']['Error3']);
		}
		// Si llegamos hasta aca... quiere decir que la cookie es valida,
		// entonces escribimos una nueva.
		$newcookie = implode(" ",$theuser);
		if($theuser[3] == 1){ $expiretime = time()+31536000;}else{ $expiretime = 0;}
		setcookie ($game_config['COOKIE_NAME'], $newcookie, $expiretime, "/", "", 0);
		doquery("UPDATE {{table}} SET onlinetime=".time().", user_lastip='{$_SERVER['REMOTE_ADDR']}' WHERE id='{$theuser[0]}' LIMIT 1", "users");
	}
	unset($dbsettings);
	return $row;
}

//
//	Funcion de parce
//
function parsetemplate($template, $array){

	foreach($array as $a => $b) {
		$template = str_replace("{{$a}}", $b, $template);
	}
	return $template;
}

function gettemplate($templatename){ //OpenGame .. $skinname = 'FinalWars'
	global $ugamela_root_path;

	$filename =  $ugamela_root_path . TEMPLATE_DIR . TEMPLATE_NAME . '/' . $templatename . ".tpl";
	return ReadFromFile($filename);
	
}

// to get the language texts
function includeLang($filename,$ext='.mo'){
	global $ugamela_root_path,$lang;

	include($ugamela_root_path."language/".DEFAULT_LANG.'/'.$filename.$ext);

}

//
// Leer y Guardar archivos
//
function ReadFromFile($filename){

	$f = fopen($filename,"r");
	$content = fread($f,filesize($filename));
	fclose($f);
	return $content;

}

function SaveToFile($filename,$content){

	$f = fopen($filename,"w");
	fputs($f,"$content");
	fclose($f);

}

//**************************************************************************
//
//	FUNCIONES PARA REVISAR!!!!!!!!!!
//
//**************************************************************************

function message($mes,$title='Error',$dest = "",$time = "3"){
	
	$parse['color'] = $color;
	$parse['title'] = $title;
	$parse['mes'] = $mes;

	$page .= parsetemplate(gettemplate('message_body'), $parse);

	display($page,$title,false,(($dest!='')?"<meta http-equiv=\"refresh\" content=\"$time;URL=javascript:self.location='$dest';\">":''));
	
	die();
}

function message_die($mes,$title,$dest = "",$time = "3",$color = "#C0A000"){
	
	$parse['color'] = $color;
	$parse['title'] = $title;
	$parse['mes'] = $mes;

	$page .= parsetemplate(gettemplate('message_body'), $parse);

	display($page,$title,true,((isset($dest))?"<meta http-equiv=\"refresh\" content=\"$time;URL=javascript:self.location='$dest';\">":''));
	
	die();
}

function display($page,$title = '',$topnav = true,$metatags=''){
	global $link,$game_config,$debug;

	echo_head($title,$metatags);

	if($topnav){ echo_topnav();}
	echo "<center>\n$page\n</center>\n";
	//Muestra los datos del debuger.
	if($game_config['debug']==1) $debug->echo_log();

	echo echo_foot();
	if(isset($link)) mysql_close();
	die();
}

function echo_foot(){
	global $game_config,$lang;
	$parse['copyright'] = $game_config['copyright'];
	$parse['TranslationBy'] = $lang['TranslationBy'];
	echo parsetemplate(gettemplate('overall_footer'), $parse);

}

function CheckUserExist($user){
  global $lang,$link;
  
	if(!$user){
		if(isset($link)) mysql_close();
		error($lang['Please_Login'],$lang['Error']);
	}
}

function pretty_time($seconds){
	//Divisiones, y resto. Gracias Prody
	$day = floor($seconds / (24*3600));
	$hs = floor($seconds / 3600 % 24);
	$min = floor($seconds  / 60 % 60);
	$seg = floor($seconds / 1 % 60);
	
	$time = '';//la entrada del $time
	if($day != 0){ $time .= $day.'d ';}
	if($hs != 0){ $time .= $hs.'h ';}
	if($min != 0){ $time .= $min.'m ';}
	$time .= $seg.'s';
	
	return $time;//regresa algo como "[[[0d] 0h] 0m] 0s"
}

function echo_topnav(){

	global $user, $planetrow, $galaxyrow,$mode,$messageziel,$gid,$lang;

	if(!$user){return;}
	if(!$planetrow){ $planetrow = doquery("SELECT * FROM {{table}} WHERE id ={$user['current_planet']}","planets",true);}
	calculate_resources_planet($planetrow);//Actualizacion de rutina
	//if(!$galaxyrow){ $galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet = '".$planetrow["id"]."'","galaxy",true);}
	$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];


echo <<<HTML

<center>
<table>
 <tr>
  <td></td>
  <td>
   <center>
   <table>
    <tr>
     <td><img src="{$dpath}planeten/small/s_{$planetrow['image']}.jpg" height="50" width="50"></td>
     <td>
      <select size="1" onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
HTML;
/*
  peque� loop para agregar todos los planetas disponibles del mismo jugador...
*/

//pedimos todos los planetas que coincidan con el id del due�.
	$planets_list = doquery("SELECT id,name,galaxy,system,planet FROM {{table}} WHERE id_owner='{$user['id']}'","planets");

	while($p = mysql_fetch_array($planets_list)){
		/*
		  Cuando alguien selecciona destruir planeta, hay un tiempo en el que se vacia el slot
		  del planeta, es mas que nada para dar tiempo a posible problema de hackeo o robo de cuenta.
		*/
		if($p["destruyed"] == 0){
			
			//$pos_galaxy = doquery("SELECT * FROM {{table}} WHERE id_planet = {$p[id]}","galaxy",true);
			echo "\n	<option ";
			if($p["id"] == $user["current_planet"]) echo 'selected="selected" ';//Se selecciona el planeta actual
			echo "value=\"?cp={$p['id']}&amp;mode=$mode&amp;gid=$gid&amp;messageziel=$messageziel&amp;re=0\">";
			//Nombre [galaxy:system:planet]
			echo "{$p['name']} [{$p['galaxy']}:{$p['system']}:{$p['planet']}]</option>";
		}
	}

echo <<<HTML
     </select>
     <table border="1"></table>
    </td>
   </tr>
  </table>
  </center>
  </td>
  <td>
   <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
     <td align="center"></td>
     <td align="center" width="85">
      <img src="{$dpath}images/metall.gif" border="0" height="22" width="42">
     </td>
     <td align="center" width="85">
      <img src="{$dpath}images/kristall.gif" border="0" height="22" width="42">
     </td>
     <td align="center" width="85">
      <img src="{$dpath}images/deuterium.gif" border="0" height="22" width="42">
     </td>
     <td align="center" width="85">
      <img src="{$dpath}images/energie.gif" border="0" height="22" width="42">
     </td>
     <td align="center"></td>
    </tr>
    <tr>
     <td align="center"><i><b>&nbsp;&nbsp;</b></i></td>
     <td align="center" width="85"><i><b style="color: rgb(173, 174, 173);">{$lang['Metal']}</b></i></td>
     <td align="center" width="85"><i><b style="color: rgb(239, 81, 239);">{$lang['Crystal']}</b></i></td>
     <td align="center" width="85"><i><b style="color: rgb(247, 117, 66);">{$lang['Deuterium']}</b></i></td>
     <td align="center" width="85"><i><b style="color: rgb(156, 113, 198);">{$lang['Energy']}</b></i></td>
     <td align="center"><i><b>&nbsp;&nbsp;</b></i></td>
    </tr>
    <tr>
     <td align="center"></td>
     <td align="center" width="85">
HTML;
	/* 
	  Muestra los recursos, e indica si estos sobrepasan la capacidad de los almacenes
	*/
	$metal = number_format(floor($planetrow["metal"]),0,",",".");
	if(($planetrow["metal"] > $planetrow["metal_max"])){
		echo "<font color=\"#ff0000\">{$metal}</font>";
	}else{echo $metal;}
	echo '</td>
     <td align="center" width="85">';
	$crystal = number_format(floor($planetrow["crystal"]),0,",",".");
	if(($planetrow["crystal"] > $planetrow["crystal_max"])){ echo "<font color=\"#ff0000\">$crystal</font>";
	}else{echo $crystal;}
	echo '</td>
     <td align="center" width="85">';
	$deuterium = number_format(floor($planetrow["deuterium"]),0,",",".");
	if(($planetrow["deuterium"] > $planetrow["deuterium_max"])){ echo "<font color=\"#ff0000\">$deuterium</font>";
	}else{echo $deuterium;}
	echo '</td>
     <td align="center" width="85">';
	$energy = number_format($planetrow["energy_max"]-$planetrow["energy_used"],0,",",".")."/".number_format($planetrow["energy_max"],0,",",".");
	
	if($planetrow["energy_max"]-$planetrow["energy_used"]< 0){ echo "<font color=\"#ff0000\">$energy</font>";
	}else{echo $energy;}
	
	echo '</td>
     <td align="center"></td>
    </tr>
   </table>
  </td>
  </tr>
</table>
</center>
';
}

function echo_head($title = '',$metatags=''){

	global $user,$lang;

	$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

	$parse = $lang;
	$parse['dpath'] = $dpath;
	$parse['title'] = $title;
	$parse['META_TAG'] = ($metatags)?$metatags:'';

	echo parsetemplate(gettemplate('simple_header'), $parse);

}

function calculate_resources_planet(&$planet){
  global $resource,$game_config;

	/*
	  calculate_resources_planet calcula y suma los recursos de un planeta dependiendo del ultimo acceso
	  al planeta.
	  El row de la base de datos last_update indica el tiempo inicial desde que se ejecuto el
	  ultimo acceso al calculo de recursos.
	  Cualquier usuario puede actualizar los recursos de otro planeta.
	  Eso hace que se actualize sin la necesidad de que el due� ingrese a su cuenta.
	*/
	//Entonces calculamos el tiempo de inactividad desde la ultima actualizacion del planeta.
	$left_time = (time() - $planet['last_update']);
	$planet['last_update'] = time();//($left_time + $planet['last_update']);//$total_time va a ser el nuevo last_update
	//if($planet['energy_max']>=0){
	/*
	  y ahora se agregan los recursos.
	  Consideramos que dependiendo de la energia disponible. el modificador correspondiente a la produccion de energia
	  //produccion total
	*/
	if($planet['energy_max']==0){
		//en caso de que la energia maxima sea nula y la energia maxima sea mayor a cero.
		$planet['metal_perhour'] = $game_config['metal_basic_income'];
		$planet['crystal_perhour'] = $game_config['crystal_basic_income'] ;
		$planet['deuterium_perhour'] = $game_config['deuterium_basic_income'];
		$production_level=100;
	}elseif($planet["energy_max"]>=$planet["energy_used"]){
		//caso normal
		$production_level=100;
	}else{
		//En caso de que la energya libre sea mayor que la maxima
		$production_level = floor(($planet['energy_max']/$planet['energy_used'])*100);
	}
	//una pequeña comprobacion
	if($production_level>100){$production_level=100;}
	if($production_level<0){$production_level=0;}
	echo $production_level;
	//
	//Se suman los recursos
	//
	//Sumamos el metal disponigle
	if($planet['metal'] < ($planet['metal_max'] + $planet['metal_max'] * 0.1))
	$planet['metal'] = $planet['metal'] + (($left_time * ($planet['metal_perhour']/3600)) * $game_config['resource_multiplier'])*(0.01*$production_level);
	//Sumamos el crystal
	if($planet['crystal'] < ($planet['crystal_max'] + $planet['crystal_max'] * 0.1))
	$planet['crystal'] = $planet['crystal'] + (($left_time * ($planet['crystal_perhour']/3600)) * $game_config['resource_multiplier'])*(0.01*$production_level);
	//sumamos el deuterio disponible
	if($planet['deuterium'] < ($planet['deuterium_max'] + $planet['deuterium_max'] * 0.1))
	$planet['deuterium'] = $planet['deuterium'] + (($left_time * ($planet['deuterium_perhour']/3600)) * $game_config['resource_multiplier'])*(0.01*$production_level);
		
	/*
	  Tambien se debe actualizar el tema del hangar...
	*/
	if($planet['b_hangar_id']!=''){
		$planet['b_hangar']+=$left_time;
		
		$b_hangar_id = explode(';',$planet['b_hangar_id']);
		
		foreach($b_hangar_id as $n => $array){
			if($array!=''){
				$array = explode(',',$array);
				$buildArray[$n] = array($array[0],$array[1],get_building_time('',$planet,$array[0]));
			}
		}
		
		$planet['b_hangar_id'] = '';
		
		/*
		  fixed. el loop revisaba todas las arrays. Pero las que tenian
		  menor presio, se quitaban, sin importar el orden.
		*/
		$endtaillist = false;
		foreach($buildArray as $a => $b){
			
			while($planet['b_hangar']>=$b[2] && !$endtaillist){
				
				if($b[1]>0){
					
					$planet['b_hangar']-=$b[2];
					$summon[$b[0]]++;
					$planet[$resource[$b[0]]]++;
					$b[1]--;
					
				}else{
					$endtaillist=true;//Fix, no se respetaba la lista...
					break;//Fix, cuando queda tiempo de sobra. se creaba loop
				}
				
			}
			if($b[1]!=0){
				$planet['b_hangar_id'] .= "{$b[0]},{$b[1]};";
			}
		}
	}else{$planet['b_hangar'] = 0;}
	
	//despues se actualiza el $planet y se actualiza la base de datos con
	//el nuevo last_update
	$query = "UPDATE {{table}} SET
	metal='{$planet['metal']}',
	crystal='{$planet['crystal']}',
	deuterium='{$planet['deuterium']}',
	last_update='{$planet['last_update']}',
	b_hangar_id='{$planet['b_hangar_id']}',";

	//Para hacer las consultas, mas precisas
	if(isset($summon)){
		
		foreach($summon as $a => $b){
			
			$query .= "{$resource[$a]}='{$planet[$resource[$a]]}', ";
			
		}
		
	}

	$query .= "b_hangar='{$planet['b_hangar']}' WHERE id={$planet['id']}";

	doquery($query,'planets');

	touchPlanet($planet);//para las flotas

}

function check_field_current(&$planet){
	/*
	  Esta funcion solo permite actualizar la cantidad de campos en un planeta.
	*/
	global $resource;
	//sumatoria de todos los edificios disponibles
	$cfc = $planet[$resource[1]]+$planet[$resource[2]]+$planet[$resource[3]];
	$cfc += $planet[$resource[4]]+$planet[$resource[12]]+$planet[$resource[14]];
	$cfc += $planet[$resource[15]]+$planet[$resource[21]]+$planet[$resource[22]];
	$cfc += $planet[$resource[23]]+$planet[$resource[24]]+$planet[$resource[31]];
	$cfc += $planet[$resource[33]]+$planet[$resource[34]]+$planet[$resource[44]];
	
	//Esto ayuda a ahorrar una query...
	if($planet['field_current'] != $cfc){
		$planet['field_current'] = $cfc;
		doquery("UPDATE {{table}} SET field_current=$cfc WHERE id={$planet['id']}",'planets');
	}
}

function check_abandon_planet(&$planet){

	if($planet['destruyed'] <= time()){
		//Borrando el planeta...
		doquery("DELETE FROM {{table}} WHERE id={$planet['id']}",'planets');
		//Borrando referencias en la galaxia...
		doquery("UPDATE {{table}} SET id_planet=0 WHERE id_planet={$planet['id']}",'galaxy');
		
	}
}

function check_building_progress($planet){
	/*
	  Esta funcion es utilizada en el Overview.
	  Indica si se esta construyendo algo en el planeta
	*/
	if($planet['b_building'] > time()) return true;

}

function is_tech_available($user,$planet,$i){//comprueba si la tecnologia esta disponible

	global $requeriments,$resource;

	if(@$requeriments[$i]){ //se comprueba si se tienen los requerimientos necesarios
		
		$enabled = true;
		foreach($requeriments[$i] as $r => $l){
			
			if(@$user[$resource[$r]] && $user[$resource[$r]] >= $l){
			// break;
			}elseif($planet[$resource[$r]] && $planet[$resource[$r]] >= $l){
				$enabled = true;
			}else{
				return false;
			}
		}
		return $enabled;
	}else{
		return true;
	}
}

function is_buyable($user,$planet,$i,$userfactor=true){//No usado por el momento...

	global $pricelist,$resource,$lang;

	$level = (isset($planet[$resource[$i]])) ? $planet[$resource[$i]] : $user[$resource[$i]];
  $is_buyeable = true;
	//array
  $array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"],'energy'=>$lang["Energy"]);
  //loop
  foreach($array as $a => $b){
  
    if(@$pricelist[$i][$a] != 0){
      //echo "$b: ";
      if($userfactor)
        $cost = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
      else
        $cost = floor($pricelist[$i][$a]);
        
      if($cost > $planet[$a]){
        $is_buyeable = false;
        
      }
    }
    
  }
	return $is_buyeable;
}

function echo_price($user,$planet,$i,$userfactor=true){//Usado
  global $pricelist,$resource,$lang;
  
  if($userfactor)
    $level = ($planet[$resource[$i]]) ? $planet[$resource[$i]] : $user[$resource[$i]];
  
  $is_buyeable = true;
  
  $array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"],'energy'=>$lang["Energy"]);
  echo "{$lang['Requires']}: ";
  foreach($array as $a => $b){
  
    if($pricelist[$i][$a] != 0){
      echo "$b: ";
      if($userfactor)
        $cost = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
      else
        $cost = floor($pricelist[$i][$a]);
        
      if($cost > $planet[$a]){
        echo '<b style="color:red;"> <t title="-'.number_format($cost-$planet[$a],0,',','.').'"><span class="noresources">'.number_format($cost,0,',','.')."</span></t></b> ";
        $is_buyeable = false;
      }else{
        echo '<b style="color:lime;"> <t title="+'.-number_format($cost-$planet[$a],0,',','.').'"><span class="noresources">'.number_format($cost,0,',','.')."</span></t></b> ";
      }
    }
  }
  
  return $is_buyeable;

}

function echo_rest_price($user,$planet,$i,$userfactor=true){//Usado
  global $pricelist,$resource,$lang;
  
  if($userfactor)
    $level = ($planet[$resource[$i]]) ? $planet[$resource[$i]] : $user[$resource[$i]];

  $array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"],'energy'=>$lang["Energy"]);
  
  echo '<br><font color="#7f7f7f">Resto: ';
  foreach($array as $a => $b){
  
    if($pricelist[$i][$a] != 0){
      echo "$b: ";
      if($userfactor)
        $cost = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
      else
        $cost = floor($pricelist[$i][$a]);
      
      if($cost < $planet[$a]){
        echo '<b style="color: rgb(95, 127, 108);">'.number_format($planet[$a]-$cost,0,',','.')."</b> ";
      }else{
        echo '<b style="color: rgb(127, 95, 96);">'.number_format($planet[$a]-$cost,0,',','.')."</b> ";
      }
    }
  }
  echo '</font>';
  
}

function is_buyeable($user,$planet,$i,$userfactor=true){//Usado
  global $pricelist,$resource,$lang;
  
  if($userfactor)
    $level = ($planet[$resource[$i]]) ? $planet[$resource[$i]] : $user[$resource[$i]];
  $is_buyeable = true;
  $array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"],'energy'=>$lang["Energy"]);
  foreach($array as $a => $b){
  
    if($pricelist[$i][$a] != 0){
      if($userfactor)
        $cost = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
      else
        $cost = floor($pricelist[$i][$a]);
      if($cost > $planet[$a]){
        $is_buyeable = false;
      }
    }
  }
  return $is_buyeable;

}

function price($user,$planet,$i,$userfactor=true){//Usado
  global $pricelist,$resource,$lang;
  
  if($userfactor)
    $level = ($planet[$resource[$i]]) ? $planet[$resource[$i]] : $user[$resource[$i]];
  
  $is_buyeable = true;
  
  $array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"],'energy'=>$lang["Energy"]);
  $text = "{$lang['Requires']}: ";
  foreach($array as $a => $b){
  
    if($pricelist[$i][$a] != 0){
      $text .= "$b: ";
      if($userfactor)
        $cost = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
      else
        $cost = floor($pricelist[$i][$a]);
        
      if($cost > $planet[$a]){
        $text .= "<a style=\"cursor: pointer;\" title=\"-".number_format($cost-$planet[$a],0,',','.')."\"><span class=\"noresources\">".number_format($cost,0,',','.')."</span></a> ";
        $is_buyeable = false;
      }else{
        $text .= "<b>".number_format($cost,0,',','.')."</b> ";
      }
    }
  }
  return $text;

}

function building_time($time){
  global $lang;

  return "<br>{$lang['ConstructionTime']}: ".pretty_time($time);
  
  //a futuro...
  //echo "La investigacion puede ser iniciada en: 14d 23h 12m 2s";
}

function get_building_time($user,$planet,$i){//solo funciona con los edificios y talvez con las investigaciones
	global $pricelist,$resource,$reslist;
  /*
    Formula sencilla para mostrar los costos de construccion.
    
    
    Mina de Metal: 60*1,5^(nivel-1) Metal y 15*1,5^(nivel-1) Cristal
    Mina de Cristal: 48*1,6^(nivel-1) Metal y 24*1,6^(nivel-1) Cristal
    Sintetizador de Deuterio: 225*1,5^(nivel-1) Metal y 75*1,5^(Nivel-1) Cristal
    Planta energ} Solar: 75*1,5^(nivel-1) Metal y 30*1,5^(Nivel-1) cristal
    Planta Fusion: 900*1,8^(nivel-1) Metal y 360*1,8^(Nivel-1) cristal y 180*1,8^(Nivel-1) Deuterio
    tecnolog} Gravit�: *3 por Nivel.
    
    Todas las dem� investigaciones y edificios *2^Nivel 
    
  */
	$level = ($planet[$resource[$i]]) ? $planet[$resource[$i]] : $user[$resource[$i]];
	
	if(in_array($i,$reslist['build']))
	{//Edificios
		/*
		  Calculo del tiempo de produccion
		  [(Cris+Met)/2500]*[1/(Nivel f.robots+1)]* 0,5^NivelFabrica Nanos. 
		*/
		$cost_metal = 	floor($pricelist[$i]['metal'] * pow($pricelist[$i]['factor'],$level));
		$cost_crystal = floor($pricelist[$i]['crystal'] * pow($pricelist[$i]['factor'],$level));
		$time = ((($cost_crystal )+($cost_metal)) / 2500) * (1 / ($planet[$resource['14']] + 1)) * pow(0.5,$planet[$resource['15']]);
		//metodo temporal para mostrar el formato tiempo...
		$time = floor($time * 60 * 60);
		return $time;
		//return 30;
	}
	elseif(in_array($i,$reslist['tech']))
	{//Investigaciones
		$cost_metal = 	floor($pricelist[$i]['metal'] * pow($pricelist[$i]['factor'],$level));
		$cost_crystal = floor($pricelist[$i]['crystal'] * pow($pricelist[$i]['factor'],$level));
		$time = (($cost_metal + $cost_crystal) / 1000) / ( ($planet[$resource['31']] + 1 )*2);
		//metodo temporal para mostrar el formato tiempo...
		$time = floor($time*60*60);
		return $time;
		//return 30;
	}
	elseif(in_array($i,$reslist['defense'])||in_array($i,$reslist['fleet']))
	{//flota y defensa
		$time = (($pricelist[$i]['metal'] + $pricelist[$i]['crystal']) / 2500) * (1 / ($planet[$resource['14']] + 1 )) * pow(1/2,$planet[$resource['15']]);
		//metodo temporal para mostrar el formato tiempo...
		$time = $time*60*60;
		return $time;
	}

}

function get_building_price($user,$planet,$i,$userfactor=true){
	global $pricelist,$resource;

  if($userfactor){$level = (isset($planet[$resource[$i]])) ? $planet[$resource[$i]] : $user[$resource[$i]];}
	//array
  $array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"]);
  //loop
  foreach($array as $a => $b){
    if($userfactor){
      $cost[$a] = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
    }else{
      $cost[$a] = floor($pricelist[$i][$a]);
    }
  }
  return $cost;

}

//
//  Actualiza los datos de un planeta en cuanto a la plota.
//

function touchPlanet(&$planet){
	global $resource;
/*
  No solo actualiza los recursos, tambien checkea los movimientos de flotas.
  Pero solo los que le pertenecen. Checkeando los datos de los tiempos con
  un pequeño loop si es necesario hacerlo.
*/
	//por el momento vamos a resolver el problema de las flotas y la teoria
	//de la lista sabana...
	//primero, sabemos que tenemos una tabla especial. fleet.
	//es cuestion de solo pedir los datos en cuanto al planeta.
	//relacion comienzo y destino. y separarlo con el tiempo
	$fleetquery = doquery("SELECT * FROM {{table}} WHERE  ((
		fleet_start_galaxy={$planet['galaxy']} AND
		fleet_start_system={$planet['system']} AND
		fleet_start_planet={$planet['planet']}
		) OR
		(
			fleet_end_galaxy={$planet['galaxy']} AND
			fleet_end_system={$planet['system']} AND
			fleet_end_planet={$planet['planet']})
		) AND
		(
		fleet_start_time<".time()." OR
		fleet_end_time<".time()."
		)",'fleets'
	);
	//una vez que se cumple el requerimiento se realiza el loop de la muerte...

	while($f = mysql_fetch_array($fleetquery)){
		//no tengo idea de como seguir...
		//depende del tipo de mision, se efectuan diferentes eventos.
		switch($f["fleet_mission"]){
			//
			//--[1:Atacar]--------------------------------------------------
			//
			case 1:
			//
			//--[3:Transportar]--------------------------------------------------
			//
			case 3:{ //bug...
				//ARGHH!!! ok, transportar implica enviar solo recursos y volver.
				//no es necesario revisar la flota.
				//comprobamos el primer viaje :)
				if($f['fleet_start_time']<=time()){
					//se suman los recursos al planeta destino.
					$metal=$f['fleet_resource_metal'];
					$cristal=$f['fleet_resource_crystal'];
					$deuterium=$f['fleet_resource_deuterium'];
					//actualizamos los recursos de la flota.
					doquery("UPDATE {{table}} SET
						fleet_resource_metal=0,fleet_resource_crystal=0,fleet_resource_deuterium=0
						WHERE fleet_id = {$f['fleet_id']}
						LIMIT 1 ;","fleets"
					);
					//ahora el planeta se le suman los recursos
					doquery("UPDATE {{table}} SET
						metal=metal+{$f['fleet_resource_metal']},
						crystal=crystal+{$f['fleet_resource_crystal']},
						deuterium=deuterium+{$f['fleet_resource_deuterium']}
						WHERE galaxy = {$f['fleet_end_galaxy']} AND
						system = {$f['fleet_end_system']} AND
						planet = {$f['fleet_end_planet']}
						LIMIT 1 ;","planets"
					);
					
					//en caso de que ya haya pasado el tiempo. 
					if($f['fleet_end_time']<=time()){
						$fleet = explode("¥r¥n",$f['fleet_array']);
						//preparamos el array
						foreach($fleet as $a =>$b){
							if($b != ''){
								$a = explode(",",$b);
								$fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";
							}
						}
						doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
						//ahora el planeta se le suman los recursos
						doquery("UPDATE {{table}} SET
							$fquery
							metal=metal+{$f['fleet_resource_metal']},
							crystal=crystal+{$f['fleet_resource_crystal']},
							deuterium=deuterium+{$f['fleet_resource_deuterium']}
							WHERE galaxy = {$f['fleet_start_galaxy']} AND
							system = {$f['fleet_start_system']} AND
							planet = {$f['fleet_start_planet']}
							LIMIT 1 ;","planets"
						);
					}
					
					
				}
				
				break;}
			//
			//--[4:Desplazar]--------------------------------------------------
			//
			case 4:{
				// Desplazar -finesh... talvez
				$fleet = explode("¥r¥n",$f['fleet_array']);
				//preparamos el array
				foreach($fleet as $a =>$b){
					if($b != ''){
						$a = explode(",",$b);
						$fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";
					}
				}
				//This work perfectly! i'm a genie! :3
				if($f['fleet_start_time']<=time()){
					
					doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
					doquery("UPDATE {{table}} SET
						$fquery
						metal=metal+{$f['fleet_resource_metal']},
						crystal=crystal+{$f['fleet_resource_crystal']},
						deuterium=deuterium+{$f['fleet_resource_deuterium']}
						WHERE galaxy = {$f['fleet_end_galaxy']} AND
						system = {$f['fleet_end_system']} AND
						planet = {$f['fleet_end_planet']}
						LIMIT 1 ;","planets"
					);
					
				}else{
					
					doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
					doquery("UPDATE {{table}} SET
						$fquery
						metal=metal+{$f['fleet_resource_metal']},
						crystal=crystal+{$f['fleet_resource_crystal']},
						deuterium=deuterium+{$f['fleet_resource_deuterium']}
						WHERE galaxy = {$f['fleet_start_galaxy']} AND
						system = {$f['fleet_start_system']} AND
						planet = {$f['fleet_start_planet']}
						LIMIT 1 ;","planets"
					);
				}
				
				break;}
			//
			//--[5:Destruir]--------------------------------------------------
			//
			case 5:
			//
			//--[6:Espiar]--------------------------------------------------
			//
			case 6:
			//
			//--[7:Posicionar flota]--------------------------------------------------
			//
			case 7:
			//
			//--[8:Reciclar]--------------------------------------------------
			//
			case 8:
			//
			//--[9:Colonizar]-----------------------------------------------
			//
			case 9:
				
				
				//This work perfectly! i'm a genie! :3
				//if($f['fleet_start_time']<=time()){
					
					if(make_planet($f['fleet_end_galaxy'],$f['fleet_end_system'],$f['fleet_end_planet'],$f['fleet_owner']))
					{
						//query para agregar un mensaje
						doquery("INSERT INTO {{table}} SET 
							`message_owner`='{$user['id']}',
							`message_sender`='',
							`message_time`='".time()."',
							`message_type`='0',
							`message_from`='Orden de la flota',
							`message_subject`='Colonizador',
							`message_text`='Colonizador comienza a construir en un planeta... bla bla bla zzzz'"
							,'messages');
					}else{echo "error";}
					/*doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
					doquery("UPDATE {{table}} SET
						$fquery
						metal=metal+{$f['fleet_resource_metal']},
						crystal=crystal+{$f['fleet_resource_crystal']},
						deuterium=deuterium+{$f['fleet_resource_deuterium']}
						WHERE galaxy = {} AND
						system = {} AND
						planet = {}
						LIMIT 1 ;","planets"
					);*/
					
				/*}else{
					
					doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
					doquery("UPDATE {{table}} SET
						$fquery
						metal=metal+{$f['fleet_resource_metal']},
						crystal=crystal+{$f['fleet_resource_crystal']},
						deuterium=deuterium+{$f['fleet_resource_deuterium']}
						WHERE galaxy = {$f['fleet_start_galaxy']} AND
						system = {$f['fleet_start_system']} AND
						planet = {$f['fleet_start_planet']}
						LIMIT 1 ;","planets"
					);
				}*/
				
				
			default:
			//como parte final. se elimina la entrada.
			//esto es solo para saber si esta bien aplicada la teoria...
			doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
			
		}
	}


}


?>
