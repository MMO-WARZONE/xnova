    <!-- START BLOCK : stat -->
    <form name="stats" method="post">
        <table width="519">
            <tr>
               <td colspan="6" class="c">{st_statistics}({st_updated}: {stat_date})</td>
            </tr>
            <tr>
                <th colspan="6" class="c">{st_show}
                <select name="who" onChange="javascript:document.stats.submit()">{who}</select>
                {st_per}
                <select name="type" onChange="javascript:document.stats.submit()">{type}</select>
                {st_in_the_positions}
                <select name="range" onChange="javascript:document.stats.submit()">{range}</select></th>
            <tr>
        </table>
    </form>
    <!-- END BLOCK : stat -->
<table width="519">
    <!-- START BLOCK : alliance -->
    
    <tr>
	<td class="c" width="60">{st_position}</td>
	<td class="c">{st_alliance}</td>
	<td class="c">&nbsp;</td>
	<td class="c">{st_members}</td>
	<td class="c">{st_points}</td>
	<td class="c">{st_per_member}</td>
    </tr>
    
    <!-- START BLOCK : alliancelist -->
    <tr>
	<th><a href="#" onmouseover='return overlib("{ally_rankplus}");' onmouseout='return nd();'>{ally_rank}</a></th>
	<th><a href="game.php?page=alliance&mode=ainfo&tag={ally_tag}" target='_ally'>{ally_name}</a></th>
	<th>{ally_mes}</th>
	<th>{ally_members}</th>
	<th>{ally_points}</th>
	<th>{ally_members_points}</th>
    </tr>
    <!-- END BLOCK : alliancelist -->
    <!-- END BLOCK : alliance -->
    
    
    <!-- START BLOCK : users -->
    
    <tr>
	<td class="c" width="60px">{st_position}</td>

<td class="c">{st_avatar}</td>
        <td class="c">{st_player}</td>
        <td class="c">{st_alliance}</td>
	<td class="c">{st_points}</td>
    </tr>
    <!-- START BLOCK : userslist -->
    <tr>
	<th><a href="#" onmouseover='return overlib("{player_rankplus}");' onmouseout='return nd();'>{player_rank}</a></th>


        <th align="left">{player_name}</th>
        
	<th>{player_mes}</th>
	<th align="left">{player_alliance}</th>
	<th align="right">{player_points}</th>
    </tr>
    <!-- END BLOCK : userslist -->
    <!-- END BLOCK : users -->
    </table>