<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from xgproyect.net      	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

if ($ConfigGame != 1) die(message ($lang['404_page']));

if($_POST){
	$name = addslashes($_POST['name']);
	$overflow = ($_POST['name'] > 0) ? intval($_POST['name']) : 'false';
	$need = explode(";", $_POST['need']);
	$needArray = array();
	foreach($need as $value){
		if($value == ""){continue;}
		$a = explode(":", $value);
		$needArray[$a[0]] = $a[1];
	}

	
$FILE = "<?php

	\$element 	= '".md5($name)."';
	\$overflow	= ".$overflow.";
	\$need	 	= unserialize('".serialize($needArray)."');
	\$prices  	= array('metal' => ".intval($_POST['metal']).", 'crystal' => ".intval($_POST['crystal']).", 'deuterium' => ".intval($_POST['deuterium']).", 'tritium' => ".intval($_POST['tritium']).", 'energy' => 0, 'factor' => 1, 'consumption' => ".intval($_POST['consumption']).", 'consumption2' => ".intval($_POST['consumption']).", 'speed' => ".intval($_POST['speed']).", 'speed2' => ".intval($_POST['speed']).", 'capacity' => ".intval($_POST['capacity']).");
	\$combat		= array('shield' => ".intval($_POST['shield']).", 'attack' => ".intval($_POST['attack']).", 'sd' => array (202 => 1, 203 => 1, 204 => 1, 205 => 1, 206 => 1, 207 => 1, 208 => 1, 209 => 1, 210 =>  1, 211 => 1, 212 =>  1, 217 =>  1, 213 => 1, 214 => 1, 215 => 1, 216 => 1, 401 => 1, 402 => 1, 403 => 1, 404 => 1, 405 => 1, 406 => 1, 407 => 1, 408 => 1, 409 => 1));
	\$language	= array('name' => '".$name."', 'description' => '".addslashes($_POST['description'])."', 'description_long' => '".addslashes($_POST['description_long'])."');	
?>";
$md5 = md5($FILE);
	chmod( $xgp_root.'includes/plugins/newships/', 0775);
	$st = fopen($xgp_root.'includes/plugins/newships/'.$md5.'.xgship', "w+");
	
	if($st){
		fwrite($st, $FILE);
		fclose($st);
	}else{
		message('Error, no se ha creado la nave. Crea un archivo con este contenido en includes/plugins/newships/'.$md5.'.xgship<br/><br/><div style="overflow:auto;width:500px;height:100px;border:1px solid silver;position:relative;">'.htmlentities($FILE).'</div>');
	}
	message('Nave creada: '.$md5.'.xgship');
}


$parse = $lang;
display( parsetemplate(gettemplate("adm/ShipCreator"), $parse), false, '', true, false);
?>
