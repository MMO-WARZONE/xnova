<br><br>
<h2>Sprachdateien Konfiguration</h2>
<form action="" method="post" name="elegir">
<table width="450">
<script>

function redirecion(){
    var archivo = document.elegir.opcionesaelejir.options[document.elegir.opcionesaelejir.selectedIndex].value
	document.location.href='config-idioma.php?archivo='+archivo
 } 
</script>

<tr>
	<td class="a" style="color:#FFFFFF"><strong>Sprachdateien Konfiguration</strong></td>
	<td class="a" style="width: 100px;" style="color:#FFFFFF">
	<select onchange="redirecion()" name="opcionesaelejir">
		<option>Selektiere ein Archiv</option>
		<option value="tradingscrapmetal">trading1scrapmetal</option>
		<option value="topkb">topkb</option>
		<option value="reg">reg</option>
		<option value="records">records</option>
		<option value="playercard">playercard</option>
		<option value="player">player</option>
		<option value="overview">overview</option>
		<option value="options">options</option>
		<option value="notes">notes</option>
		<option value="marchand">marchand</option>
		<option value="lostpassword">lostpassword</option>
		<option value="logout">logout</option>
		<option value="login">login</option>
		<option value="left_menu">left_menu</option>
		<option value="index">index</option>
		<option value="imperium">imperium</option>
		<option value="galaxy">galaxy</option>
		<option value="chat">chat</option>
		<option value="contact">contact</option>
		<option value="buildings">buildings</option>
		<option value="buddy">buddy</option>
		<option value="banned">banned</option>
		<option value="announce">announce</option>
		<option value="alliance">alliance</option>
		<option value="admin">admin</option>
		<option value="stat">stat</option>
		<option value="supp">supp</option>
		<option value="search">search</option>		
	</select>
	</td>
		</tr>
{idioma}

		<tr>
	<td class="b" colspan="2" style="color:#FFFFFF"><input style="width:100%;" value="Aktualisieren" type="submit"></td>
</tr>
</table>
</form>

