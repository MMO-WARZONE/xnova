<script type="text/javascript" src="js/generate.js"></script>
</head>
<body>
<center>
<br/>
<table>
	<tr>
		<td colspan="3"><img src="images/xnova.png" width="400" height="125"></td>
	<tr>
</table>
<br>
<h2><font size="+3" style="color:#00FFFF">{registry} bei {servername}</font></h2><br><br>
<form action="reg.php" method="post">
<table width="700">
<tbody>
	  <tr>
	    <td colspan="2" class="c" height="21"><b>{form}</b></td>
</tr><tr>
	<th width="350">{GameName}</th>
    <th width="350"><input name="character" size="20" maxlength="20" type="text"></th>
</tr>
<tr>
  <th>{neededpass}</th>
  <th><input name="passwrd" size="20" maxlength="20" type="password"></th>
</tr>
<tr>
  <th>{E-Mail}</th>
  <th><input name="email" size="20" maxlength="40" type="text"></th>
</tr>
<tr>
  <th>{MainPlanet}</th>
  <th><input name="planet" size="20" maxlength="20" type="text"></th>
</tr><tr>
  <td height="20" colspan="2"></td>
  </tr>
<tr>
  <th><input name="rgt" type="checkbox">
    {accept}</th>
  <th><input name="submit" type="submit" value="{signup}"></th>
</tr>
</table>
</form>
</center>