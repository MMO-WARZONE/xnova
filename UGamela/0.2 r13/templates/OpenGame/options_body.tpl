
<center>
<br>

<form action="{PHP_SELF}?mode=change" method="post">
 <table width="519">

     <tbody><tr><td class="c" colspan="2">{userdata}</td></tr>
<tr>
      <th>{username}</th>
   <th><input name="db_character" size="20" value="{user_username}" type="text"></th>
    </tr>
  <tr>
  <th>{lastpassword}</th>
   <th><input name="db_password" size="20" value="" type="password"></th>
  </tr>
  <tr>
  <th>{newpassword}</th>
   <th><input name="newpass1" size="20" maxlength="40" type="password"></th>
  </tr>
  <tr>
  <th>{newpasswordagain}</th>
   <th><input name="newpass2" size="20" maxlength="40" type="password"></th>
  </tr>
  <tr>
  <th><a title="{emaildir_tip}">{emaildir}</a></th>
  <th><input name="db_email" maxlength="100" size="20" value="{user_email}" type="text"></th>
  </tr>
  <tr>
  <th>{permanentemaildir}</th>
   <th>{user_email_2}</th>
  </tr>
   <tr><th colspan="2">
  </th></tr>
  <tr>
  <td class="c" colspan="2">{general_settings}</td>
  </tr>
  <tr>
   <th>{skins_example}<br> <a href="http://80.237.203.201/download/" target="_blank">{Download}</a></th>
   <th><input name="dpath" maxlength="80" size="40" value="{dpath}" type="text"> <br>
  </tr>
  <tr>
   <th>{avatar_example}<br> <a href="http://www.google.com.ar/imghp" target="_blank">{Search}</a></th>
   <th><input name="avatar" maxlength="80" size="40" value="{user_avatar}" type="text">
   </th>
  </tr>
  <tr>
  <th>{showskin}</th>
   <th>
    <input name="design"{user_design} type="checkbox">
   </th>
  </tr>
  <tr>
    <th><a title="{untoggleip_tip}">{untoggleip}</a></th>
   <th><input name="noipcheck"{user_noipcheck} type="checkbox" /></th>
  </tr>
  <tr>
   <td class="c" colspan="2">{galaxyvision_options}</td>
  </tr>
  <tr>
   <th><a title="{spy_cant_tip}">{spy_cant}</a></th>
   <th><input name="spio_anz" maxlength="2" size="2" value="{user_spio_anz}" type="text"></th>
  </tr>
  <tr>
   <th>{tooltip_time}</th>
   <th><input name="settings_tooltiptime" maxlength="2" size="2" value="{user_settings_tooltiptime}" type="text"> {seconds}</th>
  </tr>
  <tr>
   <th>{mess_ammount_max}</th>
   <th><input name="settings_fleetactions" maxlength="2" size="2" value="{user_settings_fleetactions}" type="text"></th>
  </tr>
  <tr>
   <th>{show_ally_logo}</th>
   <th><input name="settings_allylogo"{user_settings_allylogo} type="checkbox" /></th>
  </tr>
     <tr>
   <th>{shortcut}</th>
   <th>{show}</th>
  </tr>
      <tr>
   <th><img src="{dpath}img/e.gif" alt="">   {spy}</th>
   <th><input name="settings_esp"{user_settings_esp} type="checkbox" /></th>
   </tr>
      <tr>
   <th><img src="{dpath}img/m.gif" alt="">   {write_a_messege}</th>
   <th><input name="settings_wri"{user_settings_wri} type="checkbox" /></th>
   </tr>
      <tr>
   <th><img src="{dpath}img/b.gif" alt="">   {add_to_buddylist}</th>
   <th><input name="settings_bud"{user_settings_bud} type="checkbox" /></th>
   </tr>
      <tr>
   <th><img src="{dpath}img/r.gif" alt="">   {attack_with_missile}</th>
   <th><input name="settings_mis"{user_settings_mis} type="checkbox" /></th>
   </tr>
      <tr>
   <th><img src="{dpath}img/s.gif" alt="">   {show_report}</th>
   <th><input name="settings_rep"{user_settings_rep} type="checkbox" /></th>
   </tr>
         
    <tr>
     <td class="c" colspan="2">{delete_vacations}</td>
  </tr>
  <tr>
     <th><a title="{vacations_tip}">{mode_vacations}</a></th>
   <th>
    <input name="urlaubs_modus"{user_urlaubs_modus} type="checkbox" />
   </th>


  

  </tr>
  <tr>
   <th><a title="{deleteaccount_tip}">{deleteaccount}</a></th>
   <th><input name="db_deaktjava"{user_db_deaktjava} type="checkbox" />
   
   
   
   </th>
  </tr>
  <tr>
   <th colspan="2"><input value="{save_settings}" type="submit"></th>
  </tr>


   
 </tbody></table>

 
</form>

</center>
