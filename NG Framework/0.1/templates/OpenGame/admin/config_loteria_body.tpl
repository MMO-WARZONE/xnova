<br><br>
<h2>Konfiguration Lotterie</h2>
<form action="config-loteria.php" method="post">
<table width="450">

{mensaje}
<tr>
	<td class="a" colspan="2" style="color:#FFFFFF"><strong>Konfiguration Lotterie</strong></td>
</tr>
  <tr>
	<td class="c" style="color:#FFFFFF">Ziehung der Lotterie (in Sekunden)</td>
	<td align="left" width="50" class="b" style="color:red"><input name="Tiempo" type="text" value="{Tiempo}"/></td>
  </tr>
    <tr>
	<td class="b" style="color:#FFFFFF">Lose zu verkaufen</td>
	<td align="left" width="50" class="c" style="color:red"><input name="tickets" type="text" value="{tickets}"/></td>
  </tr>
    <tr>
	<td class="c" style="color:#FFFFFF">Preis von Metall</td>
	<td align="left" width="50" class="b" style="color:red"><input name="pmetal" type="text" value="{pmetal}"/></td>
    <tr>
	<td class="b" style="color:#FFFFFF">Preis von Kristall</td>
	<td align="left" width="50" class="c" style="color:red"><input name="pcristal" type="text" value="{pcristal}"/></td>
  </tr>
    <tr>
	<td class="c" style="color:#FFFFFF">Preis von Deuterium</td>
    <td align="left" width="50" class="b" style="color:red"><input name="pdeuterio" type="text" value="{pdeuterio}"/></td>
  </tr>
      <tr>
	<td class="c" style="color:#FFFFFF">Lose pro Person</td>
    <td align="left" width="50" class="b" style="color:red"><input name="ticketsxper" type="text" value="{ticketsxper}"/></td>
  </tr>
	<tr>
	<td class="b" colspan="2" style="color:#FFFFFF"><input style="width:100%;" value="Aktualisieren" type="submit"></td>
</tr>
</table>
</form>


