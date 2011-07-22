<script type="text/javascript" >
function calcul() {
	var Metal = document.forms['trader'].elements['metal'].value ;
	var Crystal = document.forms['trader'].elements['crystal'].value;
	var Deuterium = document.forms['trader'].elements['deuterium'].value;

	if({reductor_on})
	{
		if(Metal > {metal_max})
		{
			document.forms['trader'].elements['metal'].value = {metal_max};
			Metal = {metal_max};
		}
		
		if(Crystal > {crystal_max})
		{
			document.forms['trader'].elements['crystal'].value = {crystal_max};
			Crystal = {crystal_max};
		}
		
		if(Deuterium > {deuterium_max})
		{
			document.forms['trader'].elements['deuterium'].value = {deuterium_max};
			Deuterium = {deuterium_max};
		}
	}
	
	if (isNaN(document.forms['trader'].elements['metal'].value)) {
		document.getElementById("dark").innerHTML = "Sólo números";
	}
	else if (isNaN(document.forms['trader'].elements['crystal'].value)) {
		document.getElementById("dark").innerHTML = "Sólo números";
	}
	else if (isNaN(document.forms['trader'].elements['deuterium'].value)) {
		document.getElementById("dark").innerHTML = "Sólo números";
	}
	else
	{
		var Dark = Metal*{rate_metal}+Crystal* {rate_crystal}+Deuterium*{rate_deuterium};
		document.getElementById("dark").innerHTML = Math.round(Dark);
	}
	
}
</script>
<br />
<div id="content">
    <form id="trader" action="" method="post">
    <table width="569">
    <tr>
        <td class="c" colspan="5"><b>{mo_buy}</b></td>
    </tr>
	<tr>
	{events}
	</tr><tr>
        <th>{tr_resource}</th>
        <th>{tr_amount}</th>
        <th>{tr_quota_exchange}</th>
    </tr><tr>
        <th>{Darkmatter}</th>
        <th><span id='dark'></span>&nbsp;</th>
        <th>-</th>
    </tr><tr>
        <th>{Metal}</th>
        <th><input name="metal" type="text" value="0" onkeyup="calcul()"/></th>
        <th>{rate_metal}</th>
    </tr><tr>
        <th>{Crystal}</th>
        <th><input name="crystal" type="text" value="0" onkeyup="calcul()"/></th>
        <th>{rate_crystal}</th>
    </tr><tr>
        <th>{Deuterium}</th>
        <th><input name="deuterium" type="text" value="0" onkeyup="calcul()"/></th>
        <th>{rate_deuterium}</th>
    </tr><tr>
        <th colspan="6"><input type="submit" value="{tr_exchange}" /></th>
    </tr>
    </table>
    </form>
</div>