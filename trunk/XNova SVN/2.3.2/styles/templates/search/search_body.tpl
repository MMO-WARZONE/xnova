<form action="" method="post">
     <table width="519">
      <tr>
       <td class="c">{sh_searcg_in_the_universe}</td>
      </tr>
      <tr>
       <th>
        <select name="type">
         <option value="playername"{type_playername}>{sh_player_name}</option>
         <option value="planetname"{type_planetname}>{sh_planet_name}</option>
         <option value="allytag"{type_allytag}>{sh_alliance_tag}</option>
         <option value="allyname"{type_allyname}>{sh_alliance_name}</option>
        </select>
        &nbsp;&nbsp;
        <input type="text" name="searchtext" value="{searchtext}"/>
        &nbsp;&nbsp;

        <input type="submit" value="{sh_search}" />
       </th>
      </tr>
    </table>
    </form>

<!-- START BLOCK : user_table -->
    <table width="519">
        <tr>
          <td class="c">{sh_name}</td>
          <td class="c">&nbsp;</td>
          <td class="c">{sh_alliance}</td>
          <td class="c">{sh_planet}</td>
          <td class="c">{sh_coords}</td>
          <td class="c">{sh_position}</td>
        </tr>
<!-- START BLOCK : user_list -->
    <tr>
     <th>{username}</th>
     <th><a href="#" onclick="new_mensaje('{username}','{id}','Sin Asunto','')" title="{write_message}"><img src="{dpath}img/m.gif"/></a>&nbsp;<a href="game.php?page=buddy&mode=2&amp;u={id}" title="{sh_buddy_request}"><img src="{dpath}img/b.gif" border="0"></a></th>
     <th>{ally_name}</th>
     <th>{planet_name}</th>
     <th><a href="game.php?page=galaxy&mode=3&galaxy={galaxy}&system={system}">{coordinated}</a></th>
     <th>{position}</th>
    </tr>
<!-- END BLOCK : user_list -->
    </table>
<!-- END BLOCK : user_table -->

<!-- START BLOCK : ally_table -->
<table width="519">
        <tr>
          <td class="c">{sh_tag}</td>
          <td class="c">{sh_name}</td>
          <td class="c">{sh_members}</td>
          <td class="c">{sh_points}</td>
        </tr>
<!-- START BLOCK : ally_list -->
    <tr>
      <th>{ally_tag}</th>
      <th>{ally_name}</th>
      <th>{ally_members}</th>
      <th>{ally_points}</th>
    </tr>
<!-- END BLOCK : ally_list -->
    </table>
<!-- END BLOCK : ally_table -->