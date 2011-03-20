<br />
<div id="content">
    <table width="*">
            {Have_new_message}
        <tr>
        	<th>{ov_server_time}</th>
        	<th colspan="3">{date_time}</th>
        </tr>
	{noticias}
		            <tr><th>Online</th>
    <th colspan="3">{NumberMembersOnline}</th></tr>  
        <tr>
        	<td colspan="4" class="c">{ov_events}</td>
        </tr>

        	{fleet_list}
        <tr>
        	<!--<th>{moon_img}<br>{moon}</th>-->
        	<th colspan="4" >
		   <div style="background-image: url({dpath}planeten/{planet_image}.jpg);background-repeat:no-repeat;height:255px;margin:0px
auto;position:relative;width:650px;margin-bottom:0px ">
		    <div style="float: left;margin:100px 0px 0px 60px;">{moon_img}<br>{moon} </div>
			<div style="position: absolute; left: 160px;top: 8px; font-size: 16px" >Vision General - {planet_name} <font style="font-size:10px">ID ({id})</font></div><!--<h2></h2>
			-->
			<div style="float: right;margin:140px 5px 0px 0px;
	width:255px;font-size:10px; background-color:transparent; text-align: left">
				<br>
				<font color="#33FF00">{ov_diameter}:</font> {planet_diameter} {ov_distance_unit} (<a title="{Developed_fields}">{planet_field_current}</a> / <a title="{max_eveloped_fields}">{planet_field_max}</a> {fields})<br>
				<font color="#33FF00">{ov_temperature}:</font> {ov_aprox} {planet_temp_min}{ov_temp_unit} {ov_to} {planet_temp_max}{ov_temp_unit}<br>
				<font color="#33FF00">{ov_position}:</font> <a href="game.php?page=galaxy&mode=0&galaxy={galaxy_galaxy}&system={galaxy_system}">[{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}]</a><br>
				<font color="#33FF00">{ov_points}:</font> {user_rank}<br>
				<font color="#33FF00">Opciones:</font> <a href="game.php?page=overview&mode=renameplanet" title="{Planet_menu}">Renombrar | Abandonar</a><br>
				<font color="#33FF00">Referidos:</font> <a href="./reg.php?ref={user_username}">http://warsofplanet.com/uni1/reg.php?ref={user_username}</a>
			

		</div>
		  </th>
        </tr>
	<tr>
	    <th class="s" colspan="4">
            	<table class="s" align="top" border="0">
                	<tr>{anothers_planets}</tr>
               </table>
            </th>
	</tr>
        <tr>
            <th colspan="4">
                {overview_produccion}
            </th>
        </tr>
    </table>
</div>