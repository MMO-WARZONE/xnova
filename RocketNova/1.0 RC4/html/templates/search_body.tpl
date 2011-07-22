<br>
 <form action="search.php" method="post">

 <table width="530">
  <tr>
   <td class="c"><center><h2>{Search_in_all_game}</h2></center></td>
  </tr>
  <tr>
   <th>
    <select name="type">
     <option value="playername"{type_playername}>{Player_name}</option>
     <option value="allytag"{type_allytag}>{Alliance_tag}</option>
    </select>
    &nbsp;&nbsp;
    <input type="text" name="searchtext" value="{searchtext}"/>
    &nbsp;&nbsp;

    <input type="submit" value="{Search}" />
   </th>
  </tr>
</table>
</form>
{search_results}
