<br />
<div id="content">

<form action="game.php?page=options&mode=change" method="post">
<center>
<table width="580">

<tr>
<td class="c" colspan="2">{cc_datos}</td>
</tr>

<tr>
<th colspan="2">
<a href="game.php?page=options"><font color="yellow">{cc_datos}</font></a> -
<a href="game.php?page=general">{cc_general}</a> -
<a href="game.php?page=galaxia">{cc_galaxy}</a></th>
</tr>

<table=width"300">
<tr>
<td class="b"><b><font color=orange>{op_username}</font></b><br>{dt_user}</td>
<th><input name="db_character" size="20" value="{opt_usern_data}" type="text"></th>
</tr>

<tr>
<td class="b"><b><font color=orange>{op_old_pass}</font></b><br>{dt_pass}</td>
<th><input name="db_password" size="20" value="" type="password"></th>
</tr>

<tr>
<td class="b"><b><font color=orange>{op_new_pass}</font></b><br>{dt_new_pass}</td><th><input name="newpass1"    size="20" maxlength="40" type="password"></th>
</tr>

<tr>
<td class="b"><b><font color=orange>{op_repeat_new_pass}</font></b><br>{dt_new_pass_repit}</td>
<th><input name="newpass2" size="20" maxlength="40" type="password"></th>
</tr>

<tr>
<td class="b"><b><font color=orange>{op_permanent_email_adress}</font></b><br>{dt_mail}</td>
<th>{opt_mail2_data}</th>
</tr>

<tr>
<td class="b"><b><font color=orange>{op_email_adress}</font></b><br>{dt_new_mail}</td>
<th><input name="db_email" maxlength="100" size="20" value="{opt_mail1_data}" type="text"></th>
</tr>


     
<tr>
<td class="c" colspan="2" align="center"> <input value="{cc_guardar}" type="submit"></td>
</tr>
</table>

</form>
</div>
