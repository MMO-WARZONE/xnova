<!-- START BLOCK : overview -->
<table width="650px" >
	{delete}
        {Have_new_message}
        <tr>
        	<th>{ov_server_time}</th>
        	<th colspan="3">{date_time}</th>
        </tr>
	<tr>
	    <th>Online</th>
	    <th colspan="3">{NumberMembersOnline}</th>
	</tr>  
	<!-- START BLOCK : noticias -->
        <tr>
            <td class="c" colspan="4" >{ov_news_title}</td>
        </tr>
        <tr>
            <th colspan="4">{news}</th>
        </tr>
        <!-- END BLOCK : noticias -->
	
        <tr>
        	<td colspan="4" class="c">{ov_events}</td>
        </tr>

        	{fleet_list}
        <tr>

        	<th colspan="4" class="anything" >
                    <div class="img" style="background-image: url({dpath}planeten/{planet_image}.jpg);background-repeat:no-repeat;height:255px;margin:0px
auto;position:relative;width:650px;margin-bottom:0px ">
		    <!-- START BLOCK : moon -->
		    <div style="float: left;margin:100px 0px 0px 60px;">{moon_img}<br>{moon} </div>
		    <!-- END BLOCK : moon -->
		    
			<div style="position: absolute; left: 160px;top: 8px; font-size: 16px" title="ID ({id})" style="cursor: default" >Vision General - {planet_name} <a href="game.php?page=overview&mode=renameplanet" title="Renombrar | Abandonar"><img src="{dpath}img/en.gif"></a></div>
			<div style="float: right;margin:140px 5px 0px 0px;
	width:255px;font-size:10px; background-color:transparent; text-align: left">
				<br>
				<font color="#33FF00">{ov_diameter}:</font> {planet_diameter} {ov_distance_unit} (<a title="{Developed_fields}">{planet_field_current}</a> / <a title="{max_eveloped_fields}">{planet_field_max}</a> {fields})<br>
				<font color="#33FF00">{ov_temperature}:</font> {ov_aprox} {planet_temp_min}{ov_temp_unit} {ov_to} {planet_temp_max}{ov_temp_unit}<br>
				<font color="#33FF00">{ov_position}:</font> <a href="game.php?page=galaxy&mode=0&galaxy={galaxy_galaxy}&system={galaxy_system}">[{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}]</a><br>
				<font color="#33FF00">{ov_points}:</font> {user_rank}<br>
				<font color="#33FF00">Opciones:</font> <a href="game.php?page=overview&mode=renameplanet" title="{Planet_menu}">Renombrar | Abandonar</a><br>
				<font color="#33FF00">Referidos:</font> {refer}
		</div>
		  </th>
        </tr>
        <!-- START BLOCK : anothers_planets -->
	<tr>
	    <th class="s" colspan="4">
            	<table class="s" align="top" border="0">
                	<tr>{anothers_planets}</tr>
               </table>
            </th>
	</tr>
        <!-- END BLOCK : anothers_planets -->
        <tr>
            <th colspan="4" class="anything">
                <table width="100%">
                    <tr>
                        <td class="c" width="33%"><center>{pr_edificios}</center></td>
                        <td class="c" width="34%"><center>{pr_investigacion}</center></td>
                        <td class="c" width="33%"><center>{pr_hangar}</center></td>
                    </tr>
                    <tr>
                        <th><center>{building}</center></th>
                        <th><center>{tech_en_proceso}</center></th>
                        <th><center>{hangar_en_proceso}</center></th>
                    </tr>
                </table>
            </th>
        </tr>
    </table>
<!-- END BLOCK : overview -->
<!-- START BLOCK : deleted -->
<form action="game.php?page=overview&mode=renameplanet&pl={planet_id}" method="POST">
    <table width="519">
        <tr>
            <td colspan="3" class="c">{ov_security_request}</td>
        </tr>
        <tr>
            <th colspan="3">{ov_security_confirm} {galaxy_galaxy}:{galaxy_system}:{galaxy_planet} {ov_with_pass}</th>
        </tr>
        <tr>
            <th>{ov_password}</th>
            <th><input type="password" name="pw"></th>
            <th><input type="submit" name="action" value="{ov_delete_planet}"></th>
        </tr>
    </table>
    <input type="hidden" name="kolonieloeschen" value="1">
    <input type="hidden" name="deleteid" value ="{planet_id}">
</form>
<!-- END BLOCK : deleted -->
<!-- START BLOCK : renameplanet -->
<form action="game.php?page=overview&mode=renameplanet&pl={planet_id}" method="POST">
    <table width=519>
    <tr>
        <td class="c" colspan=3>{ov_your_planet}</td>
    </tr><tr>
        <th>{ov_coords}</th>
        <th>{ov_planet_name}</th>
        <th>{ov_actions}</th>
    </tr><tr>
        <th>{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}</th>
        <th>{planet_name}</th>
        <th><input type="submit" name="action" value="{ov_abandon_planet}"></th>
    </tr><tr>
        <th>{ov_planet_rename}</th>
        <th><input type="text" name="newname" size=25 maxlength=20></th>
        <th><input type="submit" name="action" value="{ov_planet_rename_action}"></th>
    </tr>
    </table>
</form>
<!-- END BLOCK : renameplanet -->