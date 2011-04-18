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

<table width="519">
        <tr>
                <td colspan="4" class="c" width="50%"><center><a href="javascript:animatedcollapse.toggle('new0004')">Neues Ticket</a></center></td>
        </tr>
</table>

<div id='new0004' style='display:none'>
<form action="support.php?ticket=99999999999999999999999999&sendenticket=1" method="POST">
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
