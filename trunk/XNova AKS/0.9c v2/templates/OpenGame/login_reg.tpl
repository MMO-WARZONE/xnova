<div id="rightmenu_register" class="rightmenu_register">
<div id="title">{registry} bei {servername}</div>
<div id="content">
<div id="contentscroll">
<table class="gibts nicht" width="100%">
<tbody>
	  <tr>
	<th>Universum</th>
    <th><form name="form" id="form">
                                <select name="jumpMenu" id="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
                                  <option value="">Uni Ausw&auml;hlen</option>
                                  <option value="http://metusalem.spacequadrat.de/XNova/login.php?mode=reg">Universum 1</option>
								  								
                                </select>
                              </form></th>
</tr>
	  <tr>
	<th><form method="post" name="reg" action="">{GameName}</th>
    <th><input name="character" size="20" maxlength="20" type="text" value="{postname}" onKeypress="
     if (event.keyCode==60 || event.keyCode==62) event.returnValue = false;
     if (event.which==60 || event.which==62) return false;"></th>
</tr>
<tr>
  <th>{neededpass}</th>
  <th><input name="passwrd" size="20" maxlength="20" type="password" value="{postpass}" onKeypress="
     if (event.keyCode==60 || event.keyCode==62) event.returnValue = false;
     if (event.which==60 || event.which==62) return false;"></th>
</tr>
<tr>
  <th>{E-Mail}*</th>
  <th><input name="email" size="20" maxlength="40" type="text" value="{postemail}" onKeypress="
     if (event.keyCode==60 || event.keyCode==62) event.returnValue = false;
     if (event.which==60 || event.which==62) return false;"></th>
</tr>
<tr>
  <th>{MainPlanet}</th>
  <th><input name="planet" size="20" maxlength="20" type="text" value="{postplanet}" onKeypress="
     if (event.keyCode==60 || event.keyCode==62) event.returnValue = false;
     if (event.which==60 || event.which==62) return false;"></th>
</tr>
<tr>
  <th>{Sex}</th>
  <th><select name="sex">
		<option value="" {sex}>{Undefined}</option>
		<option value="M" {sexm}>{Male}</option>
		<option value="F" {sexf}>{Female}</option>
		</select></th>
</tr>
<tr> 
  <th>{Languese}</th>
  <th><select name="langer">
		<option value="de">{de}</option>
		</select></th>
</tr>
<tr>
<th><img src="captcha.php"></th>
<th><input type="text" name="captcha" size="20" maxlength="20" /></th>
</tr>
<tr>
  <th colspan="2"><input name="rgt" type="checkbox" value="on" {agb}><input name="mode" value="reg" type="hidden">
    {accept}</th>
</tr>
</table>
<center>{meldung}</center>
</div>
<div id="register2" class="bigbutton" onClick="document.reg.submit()"><font color="#cc0000">{signup}</font></div></form>
</div>
</div>