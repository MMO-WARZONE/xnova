<div id='leftmenu'>
	
<script language="JavaScript">
function f(target_url,win_name) {
  var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
  new_win.focus();
}
function control_debug(){
 if (document.getElementById('pqp-container').style.display == "none"){
  document.getElementById('pqp-container').style.display = '';
 }else{
  document.getElementById('pqp-container').style.display = 'none';
 }
}
</script>
<div id="menu">
<img src="./styles/images/logo.png" border="0" width="139" height="48" />
<br /><br />
<table width="140">
    <tr>
        <td align=center colspan="2">{mu_general}</td>
    </tr>
    <tr>
        <th width="125"><a href="admin.php?page=settings">{mu_settings}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=configstat">{mu_stats_options}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=configemail">{mu_configemail}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=news">{mu_news}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=resetuni" onclick=" return confirm('{mu_reset_universe_confirmation}');">{mu_reset_universe}</a></th>
    </tr>
    
</table>
<table width="140">
    <tr>
        <td align=center colspan="2">{mu_users_settings}</td>
    </tr>
    <tr>
        <th><a href="admin.php?page=messall">{mu_global_message}</a></th>
    </tr>
    <tr>
        <th><a href='admin.php?page=support'>{supp_header}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=banned">{mu_ban_options}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=search">{mu_add_delete_resources}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=createuser">Crear Usuario</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=moonopt">{mu_moon_options}</a></th>
    </tr>
</table>
<table  width="140">
    <tr>
        <td align=center colspan="2">{mu_observation}</td>
    </tr>
    <tr>
        <th><a href="admin.php?page=onlineusers">{mu_connected}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=userlist">{mu_user_list}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=planetlist">{mu_planet_list}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=moonlist">{mu_moon_list}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=activeplanet">{mu_active_planets}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=messagelist">{mu_mess_list}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=flyingfleets">{mu_flying_fleets}</a></th>
    </tr>

</table>
<table width="140">
    <tr>
        <td align=center colspan="2">{mu_tools}</td>
    </tr>
    <tr>
        <th><a href="admin.php?page=statbuilder" onclick=" return confirm('{mu_mpu_confirmation}');">{mu_manual_points_update}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=errors">{mu_error_list}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=plugins" ">{mu_plugins}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=changepass">{mu_change_pass}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=encripter">{mu_md5_encripter}</a></th>
    </tr>
    <tr>
        <th><a href="admin.php?page=optimicedb">{mu_optimize_db}</a></th>
    </tr>



    {debug}
   </table></div>