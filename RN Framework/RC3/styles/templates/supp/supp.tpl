<script type="text/javascript" src="./scripts/jquery.js"></script>
<script type="text/javascript" src="./scripts/animatedcollapse.js"></script>
<script type="text/javascript">

animatedcollapse.addDiv('new', 'fade=1,height=auto')
animatedcollapse.addDiv('newbutton', 'fade=1,height=auto')
{ticketsrc}animatedcollapse.init()

function infodiv(i){
if(i == 0){animatedcollapse.hide('newbutton');animatedcollapse.show('new');}
if(i != 0){animatedcollapse.show('newbutton');animatedcollapse.hide('new');}
{ticketdiv}}
</script>
<div id="content">
<br>
<table width="519">
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
	{ticketsinfo}
<div id="newbutton" style="display:block;">
<table width="519">
	<tr>
		<td colspan="4" class="c" width="50%"><center><a href="javascript:infodiv(0);">Neues Ticket</a></center></td>
	</tr>
</table>
</div>
<div id="new" style="display:none;">
<form action="game.php?page=support&ticket=99999999999999999999999999&sendenticket=1" method="POST">
<table width="519">
	<tr>
		<td colspan="2" class="c" width="50%"><center>{ticket_new}</center></td>
	</tr>
	<tr>
		<th><center>{subject}:</center></th><th><input type="text" name="senden_ticket_subject"></th>
	</tr>
	<tr>
		<th colspan="2">{input_text}</th>
	</tr>
	<tr>
		<th colspan="2">
		<textarea cols="50" rows="10" name="senden_ticket_text" style="font-family:Arial;font-size:11px;"></textarea>
		<center><input type="submit" value="Absenden"></center>
		</th>
	</tr>
</table></form>
</div>
</div>