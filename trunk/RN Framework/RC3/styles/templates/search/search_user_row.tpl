<tr>
     <th><a href="#" onclick="javascript:window.open('playercard.php?playerid={id}',this.target,'width=650,height=600,resizable=0,status=0,menubar=0,location=0,directories=0,toolbar=0,copyhistory=0,scrollbars=1');">{username}</a></th>
     <th><a href="game.php?page=messages&mode=write&id={id}" title="{write_message}"><img src="{dpath}img/m.gif"/></a>&nbsp;<a href="game.php?page=buddy&mode=2&amp;u={id}" title="{sh_buddy_request}"><img src="{dpath}img/b.gif" border="0"></a></th>
     <th>{ally_name}</th>
     <th>{planet_name}</th>
     <th><a href="game.php?page=galaxy&mode=3&galaxy={galaxy}&system={system}">{coordinated}</a></th>
     <th>{position}</th>
</tr>