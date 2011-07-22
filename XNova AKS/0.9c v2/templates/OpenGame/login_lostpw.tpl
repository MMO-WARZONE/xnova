<div id="rightmenu_register" class="rightmenu_register">
<div id="title">{ResetPass} {servername}</div>
<div id="content">
<div id="contentscroll">
<table class="gibts nicht" width="100%">
<tbody align="center">
	  <tr>
	<th>Universum</th>
    <th>		  <form name="form" id="form">
                                <select name="jumpMenu" id="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
                                  <option value="">Uni Ausw&auml;hlen</option>
                                  <option value="http://metusalem.spacequadrat.de/XNova/login.php?mode=passlost">Universum 1</option>
								  								
                                </select>
                              </form></th>
</tr>
  <tr>
<form action="login.php" method="POST" name="pwlost"><input name="mode" value="passlost" type="hidden">
	 <th colspan="2"><b>{PassForm}</b></th>
</tr><tr>
	<th colspan="2">{TextPass1} {servername} {TextPass2}</th>
    </tr>
<tr>
  <th>{email}</th>
  <th><input type="text" name="email" /></th>
  </tr>
</tbody>
</table>
<center>{meldung}</center>
</div>
<div id="register2" class="bigbutton" onClick="document.pwlost.submit()"><font color="#cc0000">{ButtonSendPass}</font></div></form>
</div>
</div>