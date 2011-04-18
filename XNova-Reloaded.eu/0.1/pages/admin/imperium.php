<?php
/**
 * imperium.php
 *
 * @version 1.1
 * @copyright 2009 by Mwieners for XNova-Reloaded
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('XNOVA_ROOT_PATH', './../');

include(XNOVA_ROOT_PATH . 'common.php');

includeLang('imperium');
includeLang('tech');

if($_POST){
	$planetsrow = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$_GET['user']."' ORDER BY `id` ASC",'planets');
	$planet = array();
	while ($p = mysql_fetch_array($planetsrow)) {
	$planet[] = $p;
	}
	foreach ($planet as $p) {
	$QueryUser = "UPDATE {{table}} SET ";
	$QueryPlanet = "UPDATE {{table}} SET ";
	$QueryPlanet .= "`name` = '".$_POST[$p['id'].'-name'] ."',";
	$QueryPlanet .= "`field_current` = '".$_POST[$p['id'].'-field_current'] ."',";
	$QueryPlanet .= "`metal` = '".$_POST[$p['id'].'-metal'] ."',";
	$QueryPlanet .= "`crystal` = '".$_POST[$p['id'].'-crystal'] ."',";
	$QueryPlanet .= "`deuterium` = '".$_POST[$p['id'].'-deuterium'] ."',";
	foreach ($resource as $i => $res) {
	if(in_array($i,$reslist['build']))
		$QueryPlanet .= "`". $resource[$i]."` = '".$_POST[$p['id'].'-'.$i] ."',";
	elseif(in_array($i,$reslist['tech']))
		$QueryUser .= "`". $resource[$i]."` = '".$_POST[$p['id'].'-'.$i] ."',";
	elseif(in_array($i,$reslist['fleet']))
		$QueryPlanet .= "`". $resource[$i]."` = '".$_POST[$p['id'].'-'.$i] ."',";
	elseif(in_array($i,$reslist['defense']))
		$QueryPlanet .= "`". $resource[$i]."` = '".$_POST[$p['id'].'-'.$i] ."',";
	}
	$QueryPlanet .= "`id` = '".$p['id']."' WHERE `id` = ".$p['id']." LIMIT 1 ;";
	$QueryUser .= "`id` = '".$_GET['user']."' WHERE `id` = '".$_GET['user']."' LIMIT 1 ;";
	doquery ($QueryPlanet, 'planets');	
	if($durch != true){
	doquery ($QueryUser, 'users');
	$durch = true;
	}
	}
	Adminmessage("Erfolgreich ge&auml;ndert","OK", "./imperium.php?id=".$_GET['user'], 3); 
}


if(intval($_GET['id'])){
	$planetsrow = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$_GET['id']."' ORDER BY `id` ASC",'planets');
	
	$userrow = doquery("SELECT * FROM {{table}} WHERE `id` = '".$_GET['id']."'", 'users', true);
	$planet = array();
	$parse  = $lang;

while ($p = mysql_fetch_array($planetsrow)) {
	$planet[] = $p;
}

$parse['mount'] = count($planet) + 1;
// primera tabla, con las imagenes y coordenadas
$row  = gettemplate('admin/imperium_row');
$row2 = gettemplate('admin/imperium_row2');

foreach ($planet as $p) {
$data['text'] = '<img src="../images/planeten/gross/'.$p['image'].'.jpg" border="0" height="75" width="75">';
$parse['file_images'] .=  parsetemplate($row, $data);

if($auth['rang'] >=2 and $_GET['edit'] == 'ja'){
$data['text'] = '<input name="'. $p['id'].'-name" type="text" value="'. $p['name'] .'" >';
}else{
$data['text'] = $p['name'];
}
$parse['file_names'] .=  parsetemplate($row2, $data);


$data['text'] = "[".$p['galaxy'].":".$p['system'].":".$p['planet']."]";
$parse['file_coordinates'] .=  parsetemplate($row2, $data);

if($auth['rang'] >=2 and $_GET['edit'] == 'ja'){
$data['text'] = '<input name="'. $p['id'].'-field_current" type="text" value="'. $p['field_current'] .'" > /'.$p['field_max'];
}else{
$data['text'] = $p['field_current'].'/'.$p['field_max'];
}
$parse['file_fields'] .=  parsetemplate($row2, $data);

if($auth['rang'] >=2 and $_GET['edit'] == 'ja'){
$data['text'] = '<input name="'. $p['id'].'-metal" type="text" value="'. pretty_number($p['metal']) .'" > /'.pretty_number($p['metal_perhour']);
}else{
$data['text'] = pretty_number($p['metal']).' / '.pretty_number($p['metal_perhour']);
}
$parse['file_metal'] .=  parsetemplate($row2, $data);

if($auth['rang'] >=2 and $_GET['edit'] == 'ja'){
$data['text'] = '<input name="'. $p['id'].'-crystal" type="text" value="'. pretty_number($p['crystal']) .'" > /'.pretty_number($p['crystal_perhour']);
}else{
$data['text'] = pretty_number($p['crystal']).' / '.pretty_number($p['crystal_perhour']);
}
$parse['file_crystal'] .=  parsetemplate($row2, $data);

if($auth['rang'] >=2 and $_GET['edit'] == 'ja'){
$data['text'] = '<input name="'. $p['id'].'-deuterium" type="text" value="'. pretty_number($p['deuterium']) .'" > /'.pretty_number($p['deuterium_perhour']);
}else{
$data['text'] = pretty_number($p['deuterium']).' / '.pretty_number($p['deuterium_perhour']);
}
$parse['file_deuterium'] .=  parsetemplate($row2, $data);

$data['text'] = pretty_number($p['energy_max']-$p['energy_used']).' / '.pretty_number($p['energy_max']);
$parse['file_energy'] .=  parsetemplate($row2, $data);


	foreach ($resource as $i => $res) {
	if($auth['rang'] >=2 and $_GET['edit'] == 'ja'){
if($p[$resource[$i]]==0){$p[$resource[$i]]=0;}
	if(in_array($i,$reslist['build'])){
		$data['text'] = '<input name="'. $p['id'].'-'.$i.'" type="text" value="'.$p[$resource[$i]].'">';
	}elseif(in_array($i,$reslist['tech'])){
		if($durch != true){
			$data['text'] = '<input name="'. $p['id'].'-'.$i.'" type="text" value="'.$userrow[$resource[$i]].'">';
		}else{	$data['text'] = "";	}
	}elseif(in_array($i,$reslist['fleet'])){
		$data['text'] = '<input name="'. $p['id'].'-'.$i.'" type="text" value="'.$p[$resource[$i]].'">';
	}elseif(in_array($i,$reslist['defense'])){
		$data['text'] = '<input name="'. $p['id'].'-'.$i.'" type="text" value="'.$p[$resource[$i]].'">';
	}
	$r[$i] .= parsetemplate($row2, $data);
	}else{
	if(in_array($i,$reslist['build'])){
		$data['text'] = ($p[$resource[$i]]==0)?'-':"".$p[$resource[$i]];
	}elseif(in_array($i,$reslist['tech'])){
		if($durch != true){
			$data['text'] = ($userrow[$resource[$i]]==0)?'-':"".$userrow[$resource[$i]];
		}else{	$data['text'] = "";	}
	}elseif(in_array($i,$reslist['fleet'])){
		$data['text'] = ($p[$resource[$i]]==0)?'-':"".$p[$resource[$i]];
	}elseif(in_array($i,$reslist['defense'])){
		$data['text'] = ($p[$resource[$i]]==0)?'-':"".$p[$resource[$i]];
	}
		$r[$i] .= parsetemplate($row2, $data);
	}
	}
$durch = true;
}

// {building_row}
foreach ($reslist['build'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['building_row'] .= "<tr>" . parsetemplate($row2, $data) . $r[$i] . "</tr>";
}
// {technology_row}
foreach ($reslist['tech'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['technology_row'] .= "<tr>" . parsetemplate($row2, $data) . $r[$i] . "</tr>";
}
// {fleet_row}
foreach ($reslist['fleet'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['fleet_row'] .= "<tr>" . parsetemplate($row2, $data) . $r[$i] . "</tr>";
}
// {defense_row}
foreach ($reslist['defense'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['defense_row'] .= "<tr>" . parsetemplate($row2, $data) . $r[$i] . "</tr>";
}

if($auth['rang'] >=2 and $_GET['edit'] != 'ja'){
	$parse['edit'] = "<a href=\"imperium.php?id=". $_GET['id'] ."&edit=ja\">User editieren</a>";
}else{
	$parse['edit'] = "<input type=\"submit\" value=\"&Auml;ndern\">";
}
$parse['id'] = $_GET['id'];
$page .= parsetemplate(gettemplate('admin/imperium_table'), $parse);


display($page,$lang['Imperium'],false, '', true );
				 }else{
$parse = array();			 
$page .= parsetemplate(gettemplate('admin/imperium_userid'), $parse);


display($page,$lang['Imperium'],false, '', true );
				 }
?>
