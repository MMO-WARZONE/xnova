<?php
/*
	ccc  u  u   a   k k
	c    u  u  aaa  kk
	ccc  uuuu a   a k k
	
	This phrase is a sound. duck sound. kuak
	
*/


include("common.php");
include("cookies.php");

$userrow = checkcookies();//Identificación del usuario

if(!$userrow){ header("Location: login.php"); }

if($userrow['authlevel'] != 3&&$userrow['authlevel'] != 1){
	admin_ask_password();
}
$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];

function admin_ask_password(){
	
	if($_POST){
		
		//aca recibimos la contraseña y damos el paso ok
		if($_POST['password']) 
		
		
	}
	//preguntamos la contraseña del admin
	$dat = "<form action=admin.php method=post>
	<input type=password name=password>
	<input type=submit Value=Entry>
	</form>";

	die();

}

function display_mainpanel(){

	/*
		Esta funcion solo mustra un menu en el cual el admin puede acceder a
		las diferentes configuraciones y tablas del juego.
	*/
	$dat = <<<HTML

<table>
<tr><td class="c">UGAMELA Administration</td></tr>
<tr><td class="b">Welcome to the administration of UGAMELA</td></tr>
<tr><td class="c">Users Menu</td></tr>
<tr><td class="b"><a href="admin.php?mode=listusers">Userlist</a></td></tr>









HTML;

	display($dat,'Control Panel',false);

}

function listusers(){

	/*
		Por ahora es solo experimental, porque muestra todos los usuarios
		de golpe
	*/
	
	$dat = <<<HTML
<table>
<tr><td class="c" colspan=6>Users</td></tr>
<tr><td class="c">ID</td>
<td class="c">Username</td>
<td class="c">Email</td>
<td class="c">Sex</td>
<td class="c">Avatar</td>
<td class="c">Sign</td></tr>
HTML;



	$q = doquery("SELECT * FROM {{table}}", "users");

	while($u=mysql_fetch_array($q)){
		
		
		$dat .= "<tr><td class=c>{$u['id']}</td>
<td class=b><a href=\"admin.php?mode=edituser&id={$u['id']}\">{$u['username']}</a></td>
<td class=b>{$u['email']}</td>
<td class=b>{$u['sex']}</td>
<td class=b>".(($u['avatar']!='')?"<img src=\"{$u['avatar']}\"":'')."</td>
<td class=b>{$u['sign']}</td></tr>";
	}

	$dat .= "<tr><td class=c colspan=6><a href=admin.php>return</a></td></tr></table>";

	display($dat,'Control Panel',false);

}

function edituser($id){

	/*
		sensillo formulario donde se puede editar el usuario directamente.
		
		... creo que esto es mas complicado de lo que imagino...
	*/
	global $lang,$dpath;
	include(INCLUDES_PATH."lang/".DEFAULT_LANG."/lang_options.php");
	
	
	if($_POST){
		
		$avatar = $_POST["avatar"];
		$dpath = $_POST["dpath"];
		$db_email = $_POST["db_email"];
		//Mostrar skin
		if(isset($_POST["design"])&& $_POST["design"] == 'on'){
			$design = "1";
		}else{
			$design = "0";
		}
		//Desactivar comprobación de IP
		if(isset($_POST["noipcheck"])&& $_POST["noipcheck"] == 'on'){
			$noipcheck = "1";
		}else{
			$noipcheck = "0";
		}
		//Cantidad de sondas de espionaje
		if(isset($_POST["spio_anz"])&&is_numeric($_POST["spio_anz"])){
			$spio_anz = $_POST["spio_anz"];
		}else{
			$spio_anz = "1";
		}
		//Mostrar tooltip durante
		if(isset($_POST["settings_tooltiptime"]) && is_numeric($_POST["settings_tooltiptime"])){
			$settings_tooltiptime = $_POST["settings_tooltiptime"];
		}else{
			$settings_tooltiptime = "1";
		}
		//Maximo mensajes de flotas
		if(isset($_POST["settings_fleetactions"]) && is_numeric($_POST["settings_fleetactions"])){
			$settings_fleetactions = $_POST["settings_fleetactions"];
		}else{
			$settings_fleetactions = "1";
		}//
		//Mostrar logos de los aliados
		if(isset($_POST["settings_allylogo"]) && $_POST["settings_allylogo"] == 'on'){
			$settings_allylogo = "1";
		}else{
			$settings_allylogo = "0";
		}
		//Espionaje
		if(isset($_POST["settings_esp"]) && $_POST["settings_esp"] == 'on'){
			$settings_esp = "1";
		}else{
			$settings_esp = "0";
		}
		//Escribir mensaje
		if(isset($_POST["settings_wri"]) && $_POST["settings_wri"] == 'on'){
			$settings_wri = "1";
		}else{
			$settings_wri = "0";
		}
		//Añadir a lista de amigos
		if(isset($_POST["settings_bud"]) && $_POST["settings_bud"] == 'on'){
			$settings_bud = "1";
		}else{
			$settings_bud = "0";
		}
		//Ataque con misiles
		if(isset($_POST["settings_mis"]) && $_POST["settings_mis"] == 'on'){
			$settings_mis = "1";
		}else{
			$settings_mis = "0";
		}
		//Ver reporte
		if(isset($_POST["settings_rep"]) && $_POST["settings_rep"] == 'on'){
			$settings_rep = "1";
		}else{
			$settings_rep = "0";
		}
		//Modo vacaciones
		if(isset($_POST["urlaubs_modus"]) && $_POST["urlaubs_modus"] == 'on'){
			$urlaubs_modus = "1";
		}else{
			$urlaubs_modus = "0";
		}
		//Borrar cuenta
		if(isset($_POST["db_deaktjava"]) && $_POST["db_deaktjava"] == 'on'){
			$db_deaktjava = "1";
		}else{
			$db_deaktjava = "0";
		}
		
		doquery("UPDATE {{table}} SET
		`email` = '$db_email',
		`avatar` = '$avatar',
		`dpath` = '$dpath',
		`design` = '$design',
		`noipcheck` = '$noipcheck',
		`spio_anz` = '$spio_anz',
		`settings_tooltiptime` = '$settings_tooltiptime',
		`settings_fleetactions` = '$settings_fleetactions',
		`settings_allylogo` = '$settings_allylogo',
		`settings_esp` = '$settings_esp',
		`settings_wri` = '$settings_wri',
		`settings_bud` = '$settings_bud',
		`settings_mis` = '$settings_mis',
		`settings_rep` = '$settings_rep',
		`urlaubs_modus` = '$urlaubs_modus',
		`db_deaktjava` = '$db_deaktjava'
		WHERE `id` = '$id' LIMIT 1","users");
		
		if(isset($_POST["newpass1"])&&$_POST["newpass1"]!=''){
			
			if($_POST["newpass1"] == $_POST["newpass2"]){
				$newpass = md5($_POST["newpass1"]);
				doquery("UPDATE {{table}} SET `password` = '$newpass' WHERE `id` = '$id' LIMIT 1","users");
				//error($lang['succeful_changepass'],$lang['changue_pass']);
			}
			
		}
		
		error("succefull<br><a href=admin.php?mode=listusers>back</a>",$lang['Options']);
		
	}
	else{
	
	$u = doquery("SELECT * FROM {{table}} WHERE id=$id","users",true);
	
	
	$dat = <<<HTML
<center>
<br>

<form action="admin.php?mode=edituser&id={$u['id']}" method="post">
 <table width="519">

     <tbody><tr><td class="c" colspan="2">{$lang['userdata']}</td></tr>
<tr>
      <th>{$lang['username']}</th>
   <th><input name="db_character" size="20" value="{$u['username']}" type="text"></th>
    </tr>
  <tr>
  <th>{$lang['newpassword']}</th>
   <th><input name="newpass1" size="20" maxlength="40" type="password"></th>
  </tr>
  <tr>
  <th>{$lang['newpasswordagain']}</th>
   <th><input name="newpass2" size="20" maxlength="40" type="password"></th>
  </tr>
  <tr>
  <th><a title="{$lang['emaildir_tip']}">{$lang['emaildir']}</a></th>
  <th><input name="db_email" maxlength="100" size="20" value="{$u['email']}" type="text"></th>
  </tr>
  <tr>
  <th>{$lang['permanentemaildir']}</th>
   <th>{$u['email_2']}</th>
  </tr>
   <tr><th colspan="2">
  </th></tr>
  <tr>
  <td class="c" colspan="2">{$lang['general_settings']}</td>
  </tr>
  <tr>
   <th>{$lang['skins_example']}<br> <a href="http://80.237.203.201/download/" target="_blank">{$lang['Download']}</a></th>
   <th><input name="dpath" maxlength="80" size="40" value="{$u['dpath']}" type="text"> <br>
  </tr>
  <tr>
   <th>{$lang['avatar_example']}<br> <a href="http://www.google.com.ar/imghp" target="_blank">{$lang['Search']}</a></th>
   <th><input name="avatar" maxlength="80" size="40" value="{$u['avatar']}" type="text">
   </th>
  </tr>
  <tr>
  <th>{$lang['showskin']}</th>
   <th>
    <input name="design"
HTML;

	if($u['design'] == 1) $dat .= " checked='checked'";
	
	$dat .= <<<HTML
 type="checkbox">
   </th>
  </tr>
  <tr>
    <th><a title="{$lang['untoggleip_tip']}">{$lang['untoggleip']}</a></th>
   <th><input name="noipcheck"
HTML;

	if($u['noipcheck'] == 1) $dat .= " checked='checked'";
	
	$dat .= <<<HTML
 type="checkbox" /></th>
  </tr>
  <tr>
   <td class="c" colspan="2">{$lang['galaxyvision_options']}</td>
  </tr>
  <tr>
   <th><a title="{$lang['spy_cant_tip']}">{$lang['spy_cant']}</a></th>
   <th><input name="spio_anz" maxlength="2" size="2" value="{$u['spio_anz']}" type="text"></th>
  </tr>
  <tr>
   <th>{$lang['tooltip_time']}</th>
   <th><input name="settings_tooltiptime" maxlength="2" size="2" value="{$u['settings_tooltiptime']}" type="text"> {$lang['seconds']}</th>
  </tr>
  <tr>
   <th>{$lang['mess_ammount_max']}</th>
   <th><input name="settings_fleetactions" maxlength="2" size="2" value="{$u['settings_fleetactions']}" type="text"></th>
  </tr>
  <tr>
   <th>{$lang['show_ally_logo']}</th>
   <th><input name="settings_allylogo"
HTML;

   if($u['settings_allylogo'] == 1) $dat .= " checked='checked'/";
   
	$dat .= <<<HTML
 type="checkbox" /></th>
  </tr>
     <tr>
   <th>{$lang['shortcut']}</th>
   <th>{$lang['show']}</th>
  </tr>
      <tr>
   <th><img src="{$dpath}img/e.gif" alt="">   {$lang['spy']}</th>
   <th><input name="settings_esp"
HTML;

   if($u['settings_esp'] == 1) $dat .= " checked='checked'/";
   
	$dat .= <<<HTML
 type="checkbox" /></th>
   </tr>
      <tr>
   <th><img src="{$dpath}img/m.gif" alt="">   {$lang['write_a_messege']}</th>
   <th><input name="settings_wri"
HTML;

   if($u['settings_wri'] == 1) $dat .= " checked='checked'/";
   
	$dat .= <<<HTML
 type="checkbox" /></th>
   </tr>
      <tr>
   <th><img src="{$dpath}img/b.gif" alt="">   {$lang['add_to_buddylist']}</th>
   <th><input name="settings_bud"
HTML;

	if($u['settings_bud'] == 1) $dat .= " checked='checked'/";
   
	$dat .= <<<HTML
 type="checkbox" /></th>
   </tr>
      <tr>
   <th><img src="{$dpath}img/r.gif" alt="">   {$lang['attack_with_missile']}</th>
   <th><input name="settings_mis"
HTML;

	if($u['settings_mis'] == 1) $dat .= " checked='checked'/";
   
	$dat .= <<<HTML
 type="checkbox" /></th>
   </tr>
      <tr>
   <th><img src="{$dpath}img/s.gif" alt="">   {$lang['show_report']}</th>
   <th><input name="settings_rep"
HTML;

	if($u['settings_rep'] == 1) $dat .= " checked='checked'/";
   
	$dat .= <<<HTML
 type="checkbox" /></th>
   </tr>
         
    <tr>
     <td class="c" colspan="2">{$lang['delete_vacations']}</td>
  </tr>
  <tr>
     <th><a title="{$lang['vacations_tip']}">{$lang['mode_vacations']}</a></th>
   <th>
    <input name="urlaubs_modus"
HTML;

	if($u['urlaubs_modus'] == 1) $dat .= " checked='checked'/";

	$dat .= <<<HTML
 type="checkbox" />
   </th>


  </tr>
  <tr>
   <th><a title="{$lang['deleteaccount_tip']}">{$lang['deleteaccount']}</a></th>
   <th><input name="db_deaktjava"
HTML;

	if($u['db_deaktjava'] == 1) $dat .= " checked='checked'/";
	
	$dat .= <<<HTML
 type="checkbox" />
   
   
   
   </th>
  </tr>
  <tr>
   <th colspan="2"><input value="{$lang['save_settings']}" type="submit"></th>
  </tr>


   
 </tbody></table>

 
</form>

</center>
</body>
</html>
HTML;
	}

	display($dat,'Control Panel',false);

}


switch(@$mode){

	case "listusers":
		listusers();
	break;
	case "edituser";
		edituser($id);
	break;
	default:
		
		display_mainpanel();
		
		


}


//display($dat,'Panel de control',false);

// Created by Perberos. All rights reversed (C) 2006
?>