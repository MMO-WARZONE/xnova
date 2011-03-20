<table>
<tr>
     <td colspan="5" class="c" width="500"><center>{sp_admin_system}</center></td>
</tr><tr>
     <td><br></td>
</tr><tr>
     <td class="c" width="10%">{sp_ticket_id}</td>
     <td class="c" width="10%">{sp_player}</td>
     <td class="c" width="40%">{sp_subject}</td>
     <td class="c" width="15%">{sp_status}</td>
     <td class="c" width="25%">{sp_ticket_posted}</td>
</tr>

<!-- START BLOCK : lista_tickets-->
<tr>
<td class="c" width="10%">{ID}</td>
<td class="c" width="10%">{username}</td>
<td class="c" width="40%"><a href="admin.php?page=support&ticket={ID}">{subject}</a></td>
<td class="c" width="15%">{status}</td>
<td class="c" width="25%">{time}</td>
</tr>
<!-- END BLOCK : lista_tickets -->

</table>