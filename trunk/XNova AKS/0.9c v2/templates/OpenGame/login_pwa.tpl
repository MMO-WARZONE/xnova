<div id="rightmenu_register" class="rightmenu_register">
<div id="title">{aktivate2} bei {servername}</div>
<div id="content">
<div id="contentscroll">
<table class="gibts nicht" width="100%">
<tbody>
	  <tr>
	<th>Universum</th>
    <th>		  <form name="form" id="form">
                                <select name="jumpMenu" id="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
                                  <option value="">Uni Ausw&auml;hlen</option>
                                  <option value="http://metusalem.spacequadrat.de/XNova/login.php?mode=pwa">Universum 1</option>
								  							
                                </select>
                              </form></th>
</tr>
  <tr>
	<th><form method="get" name="akt" action=""><input name="mode" value="pwa" type="hidden">{code}</th>

    <th><input name="code" size="30" maxlength="999" type="text" value="{getcode}"></th>
</tr>
</tbody>
</table>
<center>{meldung}</center>
</div>
<div id="register2" class="bigbutton" onClick="document.pwa.submit()"><font color="#cc0000">{akt}</font></div></form>
</div>
</div>