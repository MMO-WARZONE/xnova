<table width="75%">
<tr>
    <td colspan="5" class="c" width="500"><center>{supp_admin_system}</center></td>
</tr><tr>
     <td><br></td>
</tr><tr>
     <td class="c" width="10%">{sp_ticket_id}</td>
     <td class="c" width="10%">{sp_player}</td>
     <td class="c" width="40%">{sp_subject}</td>
     <td class="c" width="15%">{sp_status}</td>
     <td class="c" width="25%">{sp_ticket_posted}</td>
</tr>

<tr>
     <td class="c" width="10%">{ID}</td>
     <td class="c" width="10%">{username}</td>
     <td class="c" width="40%">{subject}</td>
     <td class="c" width="15%">{status}</td>
     <td class="c" width="25%">{time}</td>
</tr>

</table>
<table width="75%">
<tr>
     <td class="c"><center>{text}</center></td>
</tr>
</table>
<table>
<tr>
     <td class="c" width="50%"><center>{sp_answer_new}</center></td>
</tr><tr>
     <form action="admin.php?page=support&ticket={ID}&sendenantwort=1" method="POST">
     <td class="b" colspan="2">
        <input type="hidden" name="senden_antwort_id" value="{ID}">
        <center><textarea cols="50" rows="8" name="senden_antwort_text" style="font-family:Arial;font-size:11px;"></textarea></center>
        <center><br><input type="submit" value="{sp_senden}"></center>
     </form>
     <hr noshade>
     <form action="admin.php?page=support&ticket={ID}&schliessen=1" method="POST">
        <input type="hidden" name="ticket" value="{ID}">
        <center><input type="submit" value="{sp_close_ticket}"></center>
</form>
</td>
</tr>
</table>
