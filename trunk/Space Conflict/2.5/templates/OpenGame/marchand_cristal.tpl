<script type="text/javascript" >
function calcul() {
	var Metal = document.forms['marchand'].elements['metal'].value;
	var Deuterium = document.forms['marchand'].elements['deut'].value;
	var Tachyon = document.forms['marchand'].elements['tach'].value;

	Metal = Metal * {mod_ma_res_a};
	Deuterium = Deuterium * {mod_ma_res_b};
	Tachyon = Tachyon * {mod_ma_res_c};

	var Cristal = Metal + Deuterium + Tachyon;
	document.getElementById("cristal").innerHTML=Cristal;

	if (isNaN(document.forms['marchand'].elements['metal'].value)) {
		document.getElementById("cristal").innerHTML="{mod_ma_nbre}";
	}
	if (isNaN(document.forms['marchand'].elements['deut'].value)) {
		document.getElementById("cristal").innerHTML="{mod_ma_nbre}";
	}
	if (isNaN(document.forms['marchand'].elements['tach'].value)) {
		document.getElementById("cristal").innerHTML="{mod_ma_nbre}";
	}
}
</script>
<br>
<center>
<form id="marchand" action="marchand.php" method="post">
<input type="hidden" name="ress" value="cristal">
<table width="569">
<tr>
	<td class="c" colspan="5"><b>{mod_ma_buton}</b></td>
</tr><tr>
	<th></th>
	<th></th>
	<th>{mod_ma_cours}</th>
</tr><tr>
	<th>{Crystal}</th>
	<th><span id='cristal'></span></th>
	<th>{mod_ma_res}</th>
</tr><tr>
	<th>{Metal}</th>
	<th><input name="metal" type="text" value="0" onkeyup="calcul()"/></th>
	<th>{mod_ma_res_a}</th>
</tr><tr>
	<th>{Deuterium}</th>
	<th><input name="deut" type="text" value="0" onkeyup="calcul()"/></th>
	<th>{mod_ma_res_b}</th>
</tr><tr>
	<th>Tachyon</th>
	<th><input name="tach" type="text" value="0" onkeyup="calcul()"/></th>
	<th>{mod_ma_res_c}</th>
</tr><tr>
	<th colspan="6"><input type="submit" value="{mod_ma_excha}" /></th>
</tr>
</table>
</form>