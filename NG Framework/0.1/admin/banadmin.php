<?php
//created by lyra
//galacticbattles.org
//lyra.bd@hotmail.com
// banadmin.php
// incluir Funciones

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);
include($ugamela_root_path . 'includes/functions/func.ban.' . $phpEx);
includeLang('admin/banned');

if ($user['authlevel'] >= 2) {
	if ($_GET['x'] == 'add') {
// si agregamos una direccion mostraremos el formulario
// y en caso de que el formulario haya sido enviado crearemos el registro
		if ($_POST['add']){

			$ip = $_POST['ip'];
			if (!$ip){
				message($lang['add_no_ip'], $lang['error']);
			}
			addban($ip,$_POST[reason],$_POST[legnth]);
		
		}else{
		// otra manera de mostrar el formulario
		$page1 .= parsetemplate(gettemplate('admin/bannedipform'), $lang);
		display($page1, $lang['ip_ban_sys'], false, '', true );
		}
	}
// eliminar una direccion
	if ($_GET['x'] == 'delete') {
		if ($_GET['id']){
			delban($_GET['id']);
		}else{
		// show error
		message($lang['rem_no_ip'], $lang['error']);
		}
	}
	//sección principal
	$listbanned = doquery("SELECT * FROM {{table}}", 'bannedip');
	$i = 0;
	$banned_list = '';
	while ($r = mysql_fetch_array($listbanned)){
		$i++;
		$r['i'] = $i;
		$r['razon'] = $r['reason'];
		$r['borrar'] = "<a href=\"./banadmin.php?x=delete&id={$r[id]}\">Eliminar</a>";
		$banned_list .= parsetemplate(gettemplate('admin/bannedip_row'), $r);
	}
	$lang['lista'] = $banned_list;
	$page .= parsetemplate(gettemplate('admin/bannedip'), $lang);
	display($page, $lang['ip_ban_sys'], false, '', true );
}else{
message($lang['no_admin'], $lang['error']);
}

?>