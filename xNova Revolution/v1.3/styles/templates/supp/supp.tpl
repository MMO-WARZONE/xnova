<div id="content">
	<table>
	<tr>
		<td colspan="4" class="c" width="50%"><center>{supp_header}</center></td>
	</tr>
	<tr>
		<td class="c" width="10%"><center>{ticket_id}</center></td>
		<td class="c" width="50%"><center>{subject}</center></td>
		<td class="c" width="15%"><center>{status}</center></td>
		<td class="c" width="25%"><center>{ticket_posted}</center></td>
	</tr>
	{tickets}
</table>

<form action="game.php?page=soporte&ticket=99999999999999999999999999&sendenticket=1" method="POST">
<table>
	<tr>
		<td colspan="2" class="c" width="50%"><center>{ticket_new}</center></td>
	</tr>
	<tr>
		<td class="c"><center>{subject}:</center></td><td class="c"><input type="text" name="senden_ticket_subject"></td>
	</tr>
	<tr>
		<td class="c"><center>{ticket_desc}</center></td>
	</tr>
		<tr>
			<td class="c" colspan="2">{input_text}</td>
		</tr>
		<tr>
			<td class="b" colspan="2">
			<textarea cols="50" rows="10" name="senden_ticket_text" style="font-family:Arial;font-size:11px;"></textarea>
						<center><input type="submit" value="Enviar"></center>
		</td>
	</tr>
</table></form></div>
