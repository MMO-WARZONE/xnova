<!-- START BLOCK : info_fleet -->
<table width="519">
    <tbody>
    <tr>
        <td class="c" colspan="2">{in_title_head} {element_typ}</td>
    </tr><tr>
        <th>{in_name}</th>
        <th>{name}</th>
    </tr><tr>
        <th colspan="2">
            <table>
            <tbody>
            <tr>
                <th style="background-image:url('{dpath}gebaeude/{image}.gif'); background-repeat:  no-repeat" height="120" width="120"></th>
                <th>{description}<br>
                    <br>{rf_info_to}{rf_info_from}</th>
            </tr>
            </tbody>
            </table>
        </th>
    </tr><tr>
        <th>{in_struct_pt}</th>
        <th>{hull_pt}</th>
    </tr><tr>
        <th>{in_shield_pt}</th>
        <th>{shield_pt}</th>
    </tr><tr>
        <th>{in_attack_pt}</th>
        <th>{attack_pt}</th>
    </tr>
    </tbody>
    </table>
<!-- END BLOCK : info_fleet -->
<!-- START BLOCK : info_oficial -->
<table width="519">
    <tbody>
    <tr>
        <td class="c">{name}</td>
    </tr><tr>
        <th>
        <table>
        <tbody>
        <tr>
            <th style="background-image:url('styles/images/officiers/{image}.jpg'); background-repeat:  no-repeat" height="120" width="120"></th>
            <th>{description}</th>
        </tr>
        </tbody>
        </table>
        </th>
    </tr>
    </tbody>
    </table>
<!-- END BLOCK : info_oficial -->
<!-- START BLOCK : info_buildings -->
    <table width="519">
    <tr>
        <td class="c">{name}</td>
    </tr><tr>
        <th>
        <table>
        <tbody>
        <tr>
            <th style="background-image:url('{dpath}gebaeude/{image}.gif'); background-repeat:  no-repeat" height="120" width="120"> </th>
            <th>{description}</th>
        </tr>
        </tbody>
        </table>
        </th>
    </tr>

<!-- START BLOCK : productions -->
    <tr>
        <th>
            <center>

            <table border="1">
                <tbody>
                    
                    <tr><td class="c">{in_level}</td>
                        <td class="c">{in_prod_p_hour}</td>
                        <td class="c">{in_difference}</td>
                         <!-- START BLOCK : energy -->
                        <td class="c">{in_used_energy}</td>
                        <td class="c">{in_difference}</td>
                        <!-- END BLOCK : energy -->
                    </tr>
                    <!-- START BLOCK : production_list_con -->
                     <tr>
                         <th>{build_lvl}</th>
                         <th>{build_prod} {build_gain}</th>
                         <th>{build_prod_diff}</th>
                         <th>{build_need}</th>
                         <th>{build_need_diff}</th>
                     </tr>
                    <!-- END BLOCK : production_list_con -->
                    <!-- START BLOCK : production_list_sin -->
                     <tr>
                         <th>{build_lvl}</th>
                         <th>{build_prod} {build_gain}</th>
                         <th>{build_prod_diff}</th>
                     </tr>
                    <!-- END BLOCK : production_list_sin -->
                </tbody>
            </table>


            </center>
        </th>
    </tr>
<!-- END BLOCK : productions -->
<!-- START BLOCK : phanlax -->
    <tr>
        <th>
            <center>

            <table border="1">
                <tbody>

                    <tr>
                        <td class="c">{in_level}</td>
                        <td class="c">{in_range}</td>
                    </tr>
                    <!-- START BLOCK : phanlax_list -->
                    <tr>
                        <th>{build_lvl}</th>
                        <th>{build_range}</th>
                    </tr>
                        <!-- END BLOCK : phanlax_list -->
                </tbody>
            </table>


            </center>
        </th>
    </tr>
<!-- END BLOCK : phanlax -->






    </table>
    <!-- START BLOCK : info_buildings_destroy -->
    <table width="519">
    <tbody>
    <tr>
        <td class="c" align="center">
            <a href="{destroyurl}">{in_destroy} {name} {in_level} {levelvalue} ?</a>
        </td>
    </tr><tr>
        <th>{in_needed}: {Metal}: <b>{metals}</b> {Crystal}: <b>{crystals}</b> {Deuterium}: <b>{deuteriums}</b></th>
    </tr><tr>
        <th><br>{in_dest_durati}: {destroytime}<br></th>
    </tr>
    </tbody>
    </table>
    <!-- END BLOCK : info_buildings_destroy -->

<!-- END BLOCK : info_buildings -->

<!-- START BLOCK : info_gate_table -->
{gate_time_script}
    <form action="" method="post">
        <table border="0">
            <tr>
                <th>{in_jump_gate_start_moon}</th>
              <th>{gate_start_link}</th>
            </tr>
            <tr>
                <th>{in_jump_gate_finish_moon}</th>
                <th>
                <select name="jmpto">
                {gate_dest_moons}
                </select>
                </th>
            </tr>
		</table>
        <table width="519">
                <tr>
                	<td class="c" colspan="2">{in_jump_gate_select_ships}</td>
                </tr>
                <tr>
                	<th class="l" colspan="2" align="right">
                        <table width="100%">
                        	<tr>
                        		<td style="background-color: transparent;" align="right">{gate_wait_time}</td>
                        	</tr>
                        </table>
                	</th>
                </tr>
                <!-- START BLOCK : fleet_rows -->
                <tr>
                    <th><a href="game.php?page=infos&gid={fleet_id}">{fleet_name}</a> ({fleet_max} {gate_ship_dispo})</th>
                    <th><input tabindex="{idx}" name="c{fleet_id}" size="7" maxlength="7" value="0" type="text"></th>
                </tr>
                	{gate_fleet_rows}
                <!-- END BLOCK : fleet_rows -->
                <tr>
                	<th colspan="2"><input value="{in_jump_gate_jump}" type="submit"></th>
                </tr>
        {gate_script_go}
        </table>
    </form>
<!-- END BLOCK : info_gate_table -->