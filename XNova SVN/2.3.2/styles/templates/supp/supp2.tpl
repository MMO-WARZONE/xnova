 <!-- START BLOCK : supp -->
<table width="80%">
	<tr>
		<td colspan="4" class="c" width="50%"><center>{supp_header}</center></td>
	</tr>
	<tr>
		<td class="c" width="10%"><center>{supp_ticket_id}</center></td>
		<td class="c" width="50%"><center>{supp_subject}</center></td>
		<td class="c" width="15%"><center>{supp_status}</center></td>
		<td class="c" width="25%"><center>{supp_ticket_posted}</center></td>
	</tr>
         <!-- START BLOCK : listsupp -->
	<tr>
            <th class='c' align='center'>{ID}</th>
            <th class='c'><a href='game.php?page=support&ticket={ID}'>{subject}</a></th>
            <th class='c'>{status}</th>
            <th class='c' align='center'>{time}</th>
        </tr>
         <!-- END BLOCK : listsupp -->
</table>
<!-- END BLOCK : supp -->
<!-- START BLOCK : newsupp -->
<form action="game.php?page=support&sendticket={id}" method="POST">
<table width="80%">
	<tr>
		<td colspan="4" class="c" width="50%"><center>{supp_ticket_new}</center></td>
	</tr>
	<tr>
		<td class="c"><center>{supp_subject}:</center></td>
                <td  colspan="3"  class="anything"><input type="text" name="senden_ticket_subject"  value="{subject}" {read} ></td>
	</tr>
	<tr>
                <td class="c" colspan="4">{supp_input_text}</td>
	</tr>
	<tr>
		<td class="anything" colspan="2">
                <textarea cols="25" rows="20" name="senden_ticket_text" style="font-family:Arial;font-size:11px;position: relative; bottom: 0%;"></textarea></td>
                <td class="anything" colspan="1" >
                    <table width="100%">
                        <tr>
                            <td class="c">Conversacion:<br></td>
                        </tr>
                        <tr>
                            <th class="c">
                                <div style="overflow: auto; width: 250px; height: 300px;">{text}</div>
                            </th>
                        </tr>
                    </table>
                </td>
	</tr>
        <tr>
		<td class="anything" colspan="4">
                <center><input type="submit" name="send" value="Enviar"></center>
                </td>
	</tr>
</table></form>
<!-- END BLOCK : newsupp -->