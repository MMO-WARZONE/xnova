<script language="JavaScript" src="scripts/flotten.js"></script>
<script language="JavaScript" src="scripts/ocnt.js"></script>
<script language="JavaScript" >
    function mover_option(vars){
        if(vars!="buddy"){
            $("#"+vars+" option:selected").clone().appendTo('#buddy');
            $("#"+vars+" option:selected").remove();
        }else{
            $("#"+vars+" option:selected").clone().appendTo('#invited');
            $("#"+vars+" option:selected").remove();
        }
    }
    function save_invited_sac(){
        $("#invited option").attr("selected", "selected");
        $("#saved").attr("disable", "disable");
        $.post("game.php?page=fleetsac",$("#invitated").serialize(), function(data) {
            setInterval('$("#saved").removeAttr("disabled");',1000);
        });
    }
    function save_name_sac(){
        $("#saved_1").attr("disable", "disable");
        /*$.post("game.php?page=fleetsac",$("#name_sac").serialize(), function(data) {
            $("#pru").html($("#pru").html()+"<br>"+data);
            setInterval('$("#saved_1").removeAttr("disabled");',100000);
        });*/
    }
</script>

	<table width="519" border="0" cellpadding="0" cellspacing="1">
		<tr height="20">
			<td colspan="9" class="c">{fl_fleet} ({fl_max}. {ile})</td>
		</tr>
		<tr height="20">
                    <th>{fl_number}</th>
                    <th>{fl_mission}</th>
                    <th>{fl_ammount}</th>
                    <th>{fl_beginning}</th>
                    <th>{fl_departure}</th>
                    <th>{fl_destiny}</th>
                    <th>{fl_objective}</th>
                    <th>{fl_arrival}</th>
                    <th>{fl_order}</th>
                </tr>
                    {page1}
                    {maxflot}
        </table>
	<table width="519" border="0" cellpadding="0" cellspacing="1">
		<tr height="20">
			<td class="c" colspan="2">{fl_sac_of_fleet} {aks_code_mr}</td>
		</tr>
		<tr height="20">
			<td class="c" colspan="2">{fl_modify_sac_name}</td>
		</tr>
		<tr>
                    <form id="name_sac" >
                        <input name="fleetid" value="{fleetid}" type="hidden">
			<th colspan="2">
                            <div id="pru"></div>
                            <input name="sac_name"  type="text" value="{aks_code_mr}" ><br />
                            <input id="saved_1" type="button" onclick="save_name_sac()" value="GUARDAR"  ></th>
                    </form>
                    </tr>
		<tr>
                    <th><form id="invitated" >
			<input name="fleetid" value="{fleetid}" type="hidden">

                            <table width="100%" border="0" cellpadding="0" cellspacing="1">
					<tr height="20">
                                            <td class="c">Lista a los que puedes invitar</td>
                                            <td class="c">{fl_invite_members}</td>
					</tr>
					<tr>
                                            <th width="50%">
                                                
                                                <div id="prub"></div>
                                                <select id="buddy" name="buddy" onclick="mover_option($(this).attr('id'));" size="5">

                                                {page2}
                                                </select>
                                            </th>
                                            <th width="50%">
                                                <select id="invited" name="invited[]" multiple="multiple" onclick="mover_option($(this).attr('id'));" size="5">
                                                    {page22}
                                                </select>
                                            </th>
                        <!--<form action="game.php?page=fleetsac" method="POST">
                        <input type="hidden" name="add_member_to_aks" value="madnessred" />
                        <input name="fleetid" value="{fleetid}" type="hidden">
                        <input name="aks_invited_mr" value="{aks_invited_mr}" type="hidden">
						<td>
							<input name="addtogroup" type="text" /> <br /><input type="submit" value="{fl_continue}" />
						</td>
						</form>-->

                        <br />
                        {add_user_message_mr}
					</tr>
                                        <tr>
                                            <th colspan="2">
                                                <input type="button" onclick="save_invited_sac()" id="saved" value="GUARDAR"  >
                                            </th>
                                        </tr>
				</table>
                        </form>
			</th>
		</tr>
		<tr>
		</tr>
	</table>
	<form action="game.php?page=fleet1" method="post">
	<table width="519" border="0" cellpadding="0" cellspacing="1">
		<tr height="20">
			<td colspan="4" class="c">{fl_new_mission_title}</td>
		</tr>
		<tr height="20">
            <th>{fl_ship_type}</th>
            <th>{fl_ship_available}</th>
			<th>-</th>
            <th>-</th>
		</tr>
{page3}
