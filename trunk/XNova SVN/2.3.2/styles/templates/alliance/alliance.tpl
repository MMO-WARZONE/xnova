<!-- START BLOCK : ainfo -->
 <table width="519">
    <tr>
    	<td class="c" colspan="2">{al_ally_information}</td>
    </tr>
    {ally_image}
    <tr>
        <th>{al_ally_info_tag}</th>
        <th>{ally_tag}</th>
    </tr>
    <tr>
        <th>{al_ally_info_name}</th>
        <th>{ally_name}</th>
    </tr>
    <tr>
        <th>{al_ally_info_members}</th>
        <th>{ally_member_scount}</th>
    </tr>
        {ally_description}
        {ally_web}
        {solicitud}
    </table>
<!-- END BLOCK : ainfo -->
<!-- START BLOCK : default -->
    <table width=519>
        <tr>
          <td class="c" colspan="2">{al_alliance}</td>
        </tr>
        <tr>
          <th><a href="game.php?page=alliance&mode=make">{al_alliance_make}</a></th>
          <th><a href="game.php?page=alliance&mode=search">{al_alliance_search}</a></th>
        </tr>
    </table>
<!-- END BLOCK : default -->
<!-- START BLOCK : fundar -->

<form action="game.php?page=alliance&mode=make&yes=1" method="POST">
        <table width=519>
            <tr>
                <td class="c" colspan=2>{al_make_alliance}</td>
            </tr>
            <tr>
                <th>{al_make_ally_tag_required}</th>
                <th><input type="text" name="atag" size=8 maxlength=8 value=""></th>
            </tr>
            <tr>
                <th>{al_make_ally_name_required}</th>
                <th><input type="text" name="aname" size=20 maxlength=30 value=""></th>
            </tr>
            <tr>
                <th colspan=2><input type="submit" value="{al_make_submit}"></th>
            </tr>
        </table>
    </form>
<!-- END BLOCK : fundar -->
<!-- START BLOCK : buscar -->
<form action="?page=alliance&mode=search" method="POST">
        <table width="519">
            <tr>
                <td class="c" colspan="2">{al_find_alliances}</td>
            </tr>
            <tr>
                <th>{al_find_text}</th>
                <th><input type="text" name="searchtext" value="{searchtext}"/> <input type="submit" value="{al_find_submit}"/></th>
            </tr>
        </table>
    </form>
<!-- START BLOCK : buscar_encontrar -->
    <table width="519">
        <tr>
            <td class="c" colspan="3">{al_the_nexts_allys_was_founded}</td>
        </tr>
        <tr>
            <td class="c">{al_ally_info_tag}</td>
            <td class="c">{al_ally_info_name}</td>
            <td class="c">{al_ally_info_members}</td>
        </tr>
        <!-- START BLOCK : buscar_encontrado -->
        <tr>
            <th>{ally_tag}</th>
            <th>{ally_name}</th>
            <th>{ally_members}</th>
        </tr>
        <!-- END BLOCK : buscar_encontrado -->
    </table>
<!-- END BLOCK : buscar_encontrar -->
<!-- END BLOCK : buscar -->
<!-- START BLOCK : alianza -->
<table width=519>
        <tr>
        	<td class=c colspan=2>{al_your_ally}</td>
        </tr>
        	{ally_image}
        <tr>
            <th>{al_ally_info_tag}</th>
            <th>{ally_tag}</th>
        </tr>
        <tr>
            <th>{al_ally_info_name}</th>
            <th>{ally_name}</th>
        </tr>
        <tr>
            <th>{al_ally_info_members}</th>
            <th>{ally_members}{members_list}</th>
        </tr>
        <tr>
            <th>{al_rank}</th>
            <th>{range}{alliance_admin}</th>
        </tr>
        {requests}
        {send_circular_mail}
	{chat_ajax}
        <tr>
        	<th colspan="2" height=100>{ally_description}</th>
        </tr>
        <tr>
            <th>{al_web_site}</th>
            <th><a href="{ally_web}">{ally_web}</a></th>
        </tr>
        <tr>
        	<td class=c colspan=2>{al_inside_section}</th>
        </tr>
        <tr>
        	<th colspan=2 height=100>{ally_text}</th>
        </tr>
    </table>
	{ally_owner}
<!-- END BLOCK : alianza -->
<!-- START BLOCK : admin -->
<script src="scripts/cntchar.js" type="text/javascript"></script>
    <table width=519>
        <tr>
          <td class=c colspan=2>{al_manage_alliance}</td>
        </tr>
        <tr>
          <th colspan=2><a href="game.php?page=alliance&mode=admin&edit=rights">{al_manage_ranks}</a></th>
        </tr>
        <tr>
          <th colspan=2><a href="game.php?page=alliance&mode=admin&edit=members">{al_manage_members}</a></th>
        </tr>
        <tr>
          <th colspan=2><a href="game.php?page=alliance&mode=admin&edit=tag">{al_manage_change_tag}</a></th>
        </tr>
        <tr>
          <th colspan=2><a href="game.php?page=alliance&mode=admin&edit=name">{al_manage_change_name}</a></th>
        </tr>
    </table>
    <form action="" method="POST">
    <input type="hidden" name="t" value="{t}">
    <table width=519>
        <tr>
          <td class="c" colspan="3">{al_texts}</td>
        </tr>
        <tr>
          <th><a href="game.php?page=alliance&mode=admin&edit=ally&t=1">{al_outside_text}</a></th>
          <th><a href="game.php?page=alliance&mode=admin&edit=ally&t=2">{al_inside_text}</a></th>
          <th><a href="game.php?page=alliance&mode=admin&edit=ally&t=3">{al_request_text}</a></th>
        </tr>
        <tr>
          <td class=c colspan=3>{al_message} (<span id="cntChars">0</span> / 5000 {al_characters})</td>
        </tr>
        <tr>
          <th colspan="3"><textarea name="text" cols=70 rows=15 onkeyup="javascript:cntchar(5000)">{text}</textarea>
    {request_type}
        </th>
        </tr>
        <tr>
          <th colspan=3>
          <input type="hidden" name=t value={t}><input type="reset" value="{al_circular_reset}">
          <input type="submit" value="{al_save}">
          </th>
        </tr>
    </table>
    </form>
    <form action="" method="POST">
    <table width=519>
        <tr>
          <td class=c colspan=2>{al_manage_options}</td>
        </tr>
        <tr>
          <th>{al_web_site}</th>
          <th><input type=text name="web" value="{ally_web}" size="70"></th>
        </tr>
        <tr>
          <th>{al_manage_image}</th>
          <th><input type=text name="image" value="{ally_image}" size="70"></th>
        </tr>
        <tr>
          <th>{al_manage_requests}</th>
          <th>
          <select name="request_notallow"><option value=1{ally_request_notallow_0}>{al_requests_not_allowed}</option>
          <option value=0{ally_request_notallow_1}>{al_requests_allowed}</option></select>
          </th>
        </tr>
        <tr>
          <th>{al_manage_founder_rank}</th>
          <th><input type="text" name="owner_range" value="{ally_owner_range}" size=30></th>
        </tr>
        <tr>
          <th colspan=2><input type="submit" name="options" value="{al_save}"></th>
        </tr>
    </table>
    </form>
     <table width=519>
     	<tr>
        	<td class="c">{al_disolve_alliance}</td>
        </tr>
        <tr>
          <th><input type="button" onclick="javascript:location.href='game.php?page=alliance&mode=admin&edit=exit';" value="{al_continue}"/></th>
        </tr>
     </table>
     <table width=519>
     	<tr>
        	<td class="c">{al_transfer_alliance}</td>
        </tr>
        <tr>
          <th><input type="button" onclick="javascript:location.href='game.php?page=alliance&mode=admin&edit=transfer';" value="{al_continue}"/></th>
        </tr>
     </table>

<!-- END BLOCK : admin -->
<!-- START BLOCK : rename_alliance -->
<form action="" method="POST">
    <table width=519>
        <tr>
          <td class=c colspan="2">{al_change_title} {caso} {al_the_alliance}</td>
        </tr>
        <tr>
          <th>{caso_titulo}</th>
          <th><input type="text" name="{caso}"> <input type="submit" value="{al_change_submit}"></th>
        </tr>
        <tr>
          <td class="c" colspan="9"><a href="game.php?page=alliance&mode=admin&edit=ally">{al_back}</a></td>
        </tr>
    </table>
</form>
<!-- END BLOCK : rename_alliance -->
<!-- START BLOCK : memberslist -->
 <table width="600">
        <tr>
          <td class=c colspan=8>{al_user_list} ({al_number_of_records}: {i})</td>
        </tr>
        <tr>
          <th>{al_num}</th>
          <th><a href="game.php?page=alliance&mode=memberslist&sort1=1&sort2={s}">{al_member}</a></th>
          <th>{al_message}</th>
          <th><a href="game.php?page=alliance&mode=memberslist&sort1=2&sort2={s}">{al_position}</a></th>
          <th><a href="game.php?page=alliance&mode=memberslist&sort1=3&sort2={s}">{al_points}</a></th>
          <th><a href="game.php?page=alliance&mode=memberslist&sort1=0&sort2={s}">{al_coords}</a></th>
          <th><a href="game.php?page=alliance&mode=memberslist&sort1=4&sort2={s}">{al_member_since}</a></th>
          <th><a href="game.php?page=alliance&mode=memberslist&sort1=5&sort2={s}">{al_estate}</a></th>
        </tr>
    <!-- START BLOCK : list_memberslist -->
        <tr>
            <th>{i}</th>
            <th>{username}</th>
            <th><a href="#"  onclick="new_mensaje('{username}','{id}','Sin Asunto','')"><img src="{dpath}img/m.gif" border=0 title="{write_message}"></a></th>
            <th>{ally_range}</th>
            <th>{points}</th>
            <th><a href="game.php?page=galaxy&mode=3&galaxy={galaxy}&system={system}">{galaxy}:{system}:{planet}</a></th>
            <th>{ally_register_time}</th>
            <th><font color={onlinetime}/font></th>
        </tr>
    <!-- START BLOCK : list_memberslist -->



        <tr>
          <td class="c" colspan="9"><a href="game.php?page=alliance">{al_back}</a></td>
        </tr>
    </table>
<!-- END BLOCK : memberslist -->
<!-- START BLOCK : circular -->
<script src="scripts/cntchar.js" type="text/javascript"></script>
<form action="game.php?page=alliance&mode=circular&sendmail=1" method="POST">
      <table width="530">
        <tr>
          <td class="c" colspan=2>{al_circular_send_ciruclar}</td>
        </tr>
        <tr>
          <th>{al_receiver}</th>
          <th>
            <select name="r">
              {r_list}
            </select>
          </th>
        </tr>
        <tr>
          <th>{al_message} (<span id="cntChars">0</span> / 5000 {al_characters})</th>
          <th>
            <textarea name="text" cols="60" rows="10" onkeyup="javascript:cntchar(5000)"></textarea>
          </th>
        </tr>
        <tr>
          <td class="c"><a href="game.php?page=alliance">{al_back}</a></td>
          <td align="center" class="c">
            <input type="reset" value="{al_circular_reset}">
            <input type="submit" value="{al_circular_send_submit}">
          </td>
        </tr>
      </table>
    </form>
<!-- END BLOCK : circular -->
<!-- START BLOCK : admin_members -->
<table width="519">
        <tr>
            <td class="c" colspan="9">{al_user_list} ({al_number_of_records}: {i})</td>
        </tr>
        <tr>
            <th>{al_num}</th>
            <th><a href="game.php?page=alliance&mode=admin&edit=members&sort1=1&sort2={s}">{al_member}</a></th>
            <th>{al_message}</th>
            <th><a href="game.php?page=alliance&mode=admin&edit=members&sort1=2&sort2={s}">{al_position}</a></th>
            <th><a href="game.php?page=alliance&mode=admin&edit=members&sort1=3&sort2={s}">{al_points}</a></th>
            <th><a href="game.php?page=alliance&mode=admin&edit=members&sort1=0&sort2={s}">{al_coords}</a></th>
            <th><a href="game.php?page=alliance&mode=admin&edit=members&sort1=4&sort2={s}">{al_member_since}</a></th>
            <th><a href="game.php?page=alliance&mode=admin&edit=members&sort1=5&sort2={s}">{al_estate}</a></th>
            <th>{al_actions}</th>
        </tr>
<!-- START BLOCK : admin_list_members -->
<tr>
    <th>{i}</th>
    <th>{username}</th>
    <th><a href="#" onclick="new_mensaje('{username}','{id}','Sin Asunto','')"><img src="{dpath}img/m.gif" border=0 title="{write_message}"></a></th>
    <th>{ally_range}
<!-- START BLOCK : admin_list_members_edit -->
<br>
<form action="game.php?page=alliance&mode=admin&edit=members&id={id}" name="editar_usu_rango" method="POST">
	<select name="newrang">{options}</select>
    <input type="submit" value="{al_ok}" /> 
</form>
<!-- END BLOCK : admin_list_members_edit -->
</th>
    <th>{points}</th>
    <th><a href="game.php?page=galaxy&mode=0&galaxy={galaxy}&system={system}">{galaxy}:{system}:{planet}</a></th>
    <th>{ally_register_time}</th>
    <th>{onlinetime}</th>
    <th>{acciones}</th>
</tr>
<!-- END BLOCK : admin_list_members -->

        <tr>
            <td class="c" colspan="9"><a href="game.php?page=alliance&mode=admin&edit=ally">{al_back}</a></td>
        </tr>
    </table>
<!-- END BLOCK : admin_members -->

<!-- START BLOCK : rights -->
<table width="519">
<!-- START BLOCK : list_rights -->
    <tr><td class="c" colspan="11">{al_configura_ranks}</td></tr>
        
        <form action="game.php?page=alliance&mode=admin&edit=rights" method="POST">
            <tr>
              <th>{al_dlte}</th>
              <th>{al_rank_name}</th>
              <th><img src=styles/images/r1.png></th>
              <th><img src=styles/images/r2.png></th>
              <th><img src=styles/images/r3.png></th>
              <th><img src=styles/images/r4.png></th>
              <th><img src=styles/images/r5.png></th>
              <th><img src=styles/images/r6.png></th>
              <th><img src=styles/images/r7.png></th>
              <th><img src=styles/images/r8.png></th>
              <th><img src=styles/images/r9.png></th>
            </tr>
            <!-- START BLOCK : list_law_rights -->
            <tr>
                <th>{delete}</th>
                <th>{r0}</th>
                <input type="hidden" name="id[]" value="{a}">
                <th>{r1}</th>
                <th>{r2}</th>
                <th>{r3}</th>
                <th>{r4}</th>
                <th>{r5}</th>
                <th>{r6}</th>
                <th>{r7}</th>
                <th>{r8}</th>
                <th>{r9}</th>
            </tr>
            <!-- END BLOCK : list_law_rights -->

            <tr>
                      <th colspan="11"><input type="submit" value="{al_save}"></th>
                    </tr>
            </form>


        <!-- END BLOCK : list_rights -->
    </table>
    <br>
    <form action="game.php?page=alliance&mode=admin&edit=rights&add=name" method="POST">
    <table width="519">
        <tr>
          <td class="c" colspan="2">{al_create_new_rank}</td>
        </tr>
        <tr>
          <th>{al_rank_name}</th>
          <th><input type="text" name="newrangname" size="20" maxlength="30"></th>
        </tr>
        <tr>
          <th colspan=2><input type="submit" value="{al_create}"></th>
        </tr>
    </table>
    </form>
    <form action="game.php?page=alliance&mode=admin&edit=rights" method="POST">
    <table width="519">
        <tr>
          <td class=c colspan="2">{al_legend}</td>
        </tr>
        <tr>
          <th><img src=styles/images/r1.png></th>
          <th>{al_legend_disolve_alliance}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r2.png></th>
          <th>{al_legend_kick_users}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r3.png></th>
          <th>{al_legend_see_requests}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r4.png></th>
          <th>{al_legend_see_users_list}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r5.png></th>
          <th>{al_legend_check_requests}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r6.png></th>
          <th>{al_legend_admin_alliance}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r7.png></th>
          <th>{al_legend_see_connected_users}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r8.png></th>
          <th>{al_legend_create_circular}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r9.png></th>
          <th>{al_legend_right_hand}</th>
        </tr>
        <tr>
          <td class="c" colspan="2"><a href="game.php?page=alliance&mode=admin&edit=ally">{al_back}</a></td>
        </tr>
    </table>
    </form>
<!-- END BLOCK : rights -->









<!-- START BLOCK : solicitud -->
<script src="scripts/cntchar.js" type="text/javascript"></script>
    <form action="game.php?page=alliance&mode=apply&allyid={allyid}" method=POST>
    <table width=519>
        <tr>
          <td class=c colspan=2>{Write_to_alliance}</td>
        </tr>
        <tr>
          <th>{al_message} (<span id="cntChars">{chars_count}</span> / 6000 {al_characters})</th>
          <th><textarea name="text" cols="40" rows="10" onkeyup="javascript:cntchar(6000)">{text_apply}</textarea></th>
        </tr>
        <tr>
          <th colspan="2"><input type="submit" name="enviar" value="{al_applyform_send}"/> <input type="submit" name="enviar" value="{al_applyform_reload}"/></th>
        </tr>
    </table>
    </form>
<!-- END BLOCK : solicitud -->
<!-- START BLOCK : esp_solicitud -->
<form action="" method="POST">
    <table width="519">
        <tr>
          <td class="c" colspan="2">{al_your_request_title}</td>
        </tr>
        <tr>
          <th colspan="2">{request_text}</th>
        </tr>
        <tr>
          <th colspan="2"><input type="submit" name="bcancel" value="{button_text}"></th>
        </tr>
    </table>
    </form>
<!-- END BLOCK : esp_solicitud -->
<!-- START BLOCK : list_solicitudes -->
<table width="519">
        <tr>
          <td class="c" colspan="2">{al_request_list}</td>
        </tr>
    <!-- START BLOCK : form_solicitudes -->
        <script src="scripts/cntchar.js" type="text/javascript"></script>
        <form action="game.php?page=alliance&mode=admin&edit=requests&show={id}&sort=0" method="POST">
           <tr>
                 <th colspan="2">{Request_from}</th>
           </tr>
           <tr>
                 <th colspan="2">{ally_request_text}</th>
           </tr>
           <tr>
                 <td class="c" colspan=2>{al_reply_to_request}</td>
           </tr>
           <tr>
                 <th>{al_reason} <span id="cntChars">0</span> / 500 {al_characters}</th>
                 <th><textarea name="text" cols=40 rows=10 onkeyup="javascript:cntchar(500)"></textarea></th>
           </tr>
           <tr>
                 <th colspan="2"><input type="submit" name="action" value="{al_acept_request}"/> <input type="submit" name="action" value="{al_decline_request}"/></th>
           </tr>
        </form>
     <!-- END BLOCK : form_solicitudes -->

        <tr>
          <th colspan="2">{There_is_hanging_request}</th>
        </tr>
        <tr>
          <td class="c"><a href="game.php?page=alliance&mode=admin&edit=requests&show=0&sort=1">{al_candidate}</a></td>
          <td class="c"><a href="game.php?page=alliance&mode=admin&edit=requests&show=0&sort=0">{al_request_date}</a></th>
        </tr>
      <!-- START BLOCK : list -->
        <tr>
            <th><a href="game.php?page=alliance&mode=admin&edit=requests&show={id}&sort=0">{username}</a></th>
            <th>{time}</th>
        </tr>
      <!-- END BLOCK : list -->
        <tr>
          <td class=c colspan=2><a href="game.php?page=alliance">{al_back}</a></td>
        </tr>
    </table>
<!-- END BLOCK : list_solicitudes -->

<!-- START BLOCK : transfer -->
   <table width="520">
        <tr>
          <td class="c" colspan="8">{al_transfer_alliance}</td>
        </tr>
        <form action="game.php?page=alliance&mode=admin&edit=transfer&id={id}" method="POST">
        <tr>
                <th colspan="3">{al_transfer_to}:</th>
                <th><select name="newleader">{righthand}</select></th>
                <th colspan="3"><input type="submit" value="{al_transfer_submit}"></th>
        </tr>
        </form>

        <tr>
          <td class="c" colspan="8"><a href="game.php?page=alliance&mode=admin&edit=ally">{al_back}</a></td>
        </tr>
    </table>

<!-- END BLOCK : transfer -->
