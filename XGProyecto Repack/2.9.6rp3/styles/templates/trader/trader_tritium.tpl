<script type="text/javascript" >
function calcul() {
    var Metal   = document.forms['trader'].elements['metal'].value;
    var Cristal = document.forms['trader'].elements['cristal'].value;
	var Deuterium = document.forms['trader'].elements['deuterium'].value;

    Metal   = Metal * {mod_ma_res_a};
    Cristal = Cristal * {mod_ma_res_b};
	Deuterium = Deuterium * {mod_ma_res_c};

    var Total = Metal + Cristal + Deuterium;
    document.getElementById("tritium").innerHTML=Total;

    if (isNaN(document.forms['trader'].elements['metal'].value)) {
        document.getElementById("tritium").innerHTML="Sólo números";
    }
    if (isNaN(document.forms['trader'].elements['cristal'].value)) {
        document.getElementById("tritium").innerHTML="Sólo números";
    }
    if (isNaN(document.forms['trader'].elements['deuterium'].value)) {
        document.getElementById("tritium").innerHTML="Sólo números";
    }
}
</script>
<br />
<div id="content">
    <form id="trader" action="" method="post">
    <input type="hidden" name="ress" value="tritium">
    <table width="569">
    <tr>
        <td class="c" colspan="5"><b>{tr_sell_tritium}</b></td>
    </tr><tr>
        <th>{tr_resource}</th>
        <th>{tr_amount}</th>
        <th>{tr_quota_exchange}</th>
    </tr><tr>
        <th>{Tritium}</th>
        <th><span id='tritium'></span>&nbsp;</th>
        <th>{mod_ma_res}</th>
    </tr><tr>
        <th>{Metal}</th>
        <th><input name="metal" type="text" value="0" onkeyup="calcul()"/></th>
        <th>{mod_ma_res_a}</th>
    </tr><tr>
        <th>{Crystal}</th>
        <th><input name="cristal" type="text" value="0" onkeyup="calcul()"/></th>
        <th>{mod_ma_res_b}</th>
    </tr><tr>
        <th>{Deuterium}</th>
        <th><input name="deuterium" type="text" value="0" onkeyup="calcul()"/></th>
        <th>{mod_ma_res_c}</th>
    </tr><tr>
        <th colspan="6"><input type="submit" value="{tr_exchange}" /></th>
    </tr>
    </table>
    </form>
</div>  
