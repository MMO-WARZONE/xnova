<style>.overlib{
        font-size: 10px;
        text-align: left;
        border: dotted;
}</style>
<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="519" cellpadding="2" cellspacing="2">
<tr>
	<td class="c" colspan="2">{se_server_parameters_email} Parámetros del servidor email</td>
</tr><tr>
	<th>Activar Email <a href="#" onmouseover='return overlib("<table width=300 ><tr><td class=overlib ><span>Activa esta casilla si quieres enviar email por el servidor</span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 )'
                                                                                      onmouseout="return nd();"> [?]</a></th>
        <th><input name="act_email"  size=20 value="1" {act_email_check} type="checkbox"></th>
</tr><tr>
	<th>Activar SMTP <a href="#" onmouseover='return overlib("<table width=300 ><tr><td class=overlib><span>Activa esta casilla si quieres enviar emails del servidor, con ayuda funcion IsSMTP(), en caso contrario enviara desde la funcion mail()</span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 )'
                                                                                      onmouseout="return nd();"> [?]</a></th>
        <th><input name="act_smtp_email"  size=20 value="1" {act_smtp_email_check} type="checkbox"></th>
</tr><tr>
	<th>Dominio <a href="#" onmouseover='return overlib("<table width=300 ><tr><td class=overlib><span>Dominio del servidor desde donde se envia los email (ejm. gmail.com si usas gmail)</span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 )'
                                                                                      onmouseout="return nd();"> [?]</a></th>
	<th><input name="smtp_email"  size=20 value="{smtp_email}" type=text></th>
</tr><tr>
	<th>Usuario del Envio <a href="#" onmouseover='return overlib("<table width=300 ><tr><td class=overlib><span>Usuario de la cuenta desde donde se envia, y la contraseña claro esta</span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 )'
                                                                                      onmouseout="return nd();"> [?]</a></th>
	<th><input name="user_email"  size=20 value="{user_email}" type=text></th>
</tr><tr>
	<th>Contraseña del Email</th>
	<th><input name="pass_email" size="15" value="{pass_email}" type="password"></th>
</tr><tr>
	<th>Seguridad del Envio <a href="#" onmouseover='return overlib("<table width=300 ><tr><td class=overlib><span>Seguridad del envio (tls, ssl  => gmail.com)</span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 )'
                                                                                      onmouseout="return nd();"> [?]</a></th>
	<th><input name="sec_email" size="15" value="{sec_email}" type="text"></th>
</tr><tr>
	<th>Puerto Email <a href="#" onmouseover='return overlib("<table width=300 ><tr><td class=overlib><span>Puerto desde donde se hace el envio (587 => gmail.com)</span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 )'
                                                                                      onmouseout="return nd();"> [?]</a></th>
	<th><input name="port_email" size="15" value="{port_email}" type="text"></th>
</tr><tr>
    <th colspan="3"><input value="{se_save_parameters}" type="submit"></th>
</tr>
</table>
</form>