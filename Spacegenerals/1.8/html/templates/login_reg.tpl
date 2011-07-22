<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/mocha.js"></script>

<style type="text/css">
.weak{background-color: #FF5353;}
.strong{background-color: #FAD054;}
.stronger{background-color: #93C9F4; }
.strongest{background-color: #B6FF6C;}
</style>
 <h2>{registry} bei {servername}</div><br></b> </h2>
<b>Hier kannst du dich f&uuml;r unsere Universen registireren.<b/>
<br>


<div id="rightmenu_register" class="rightmenu_register">

<div id="content">
<div id="contentscroll">
<table class="gibts nicht" width="100%">

<tbody>
	  <tr>
	<th><form method="post" name="reg" action="">{GameName}</th>
    <th><input name="character" size="20" maxlength="20" type="text" value="{postname}" onKeypress="
     if (event.keyCode==60 || event.keyCode==62) event.returnValue = false;
     if (event.which==60 || event.which==62) return false;"></th>
</tr>
<tr>
<th>{neededpass}</th>
  <th><input name="passwrd" size="20" maxlength="20" type="password" onKeypress="
     if (event.keyCode==60 || event.keyCode==62) event.returnValue = false;
     if (event.which==60 || event.which==62) return false;"id="inputPassword"></th>
</tr>
<th>Sicherheit:</th>
<th id="complexity" class="default">Nicht vorhanden</tr>

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
</div>
<br>
<center><Font color=red>{meldung}</font></center>
<br>
<input name="submit" type="submit" value="{signup}" style="float: center"></td>
<br>
</div>
</div>