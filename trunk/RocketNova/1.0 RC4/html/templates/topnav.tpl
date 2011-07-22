<div id="header_top">
<center>
<table class="header">
<tbody>
<tr class="header">
	<td class="header">
		<center>
		</center>
	</td>
	<td class="header">
		<table width="722" border="0" cellpadding="0" cellspacing="0" class="header" id="resources" style="width: 722px;" padding-right="30">
		<tbody>
		<tr class="header">
		    <td class="header" align="center" width="150"><select size="1" onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">{planetlist}</select></td>
			<td class="header" align="center" width="150"><img src="{dpath}images/metall.gif" border="0" height="22" width="42"></td>
			<td class="header" align="center" width="150"><img src="{dpath}images/kristall.gif" border="0" height="22" width="42"></td>
			<td class="header" align="center" width="150"><img src="{dpath}images/deuterium.gif" border="0" height="22" width="42"></td>
			<td class="header" align="center" width="150"><img src="{dpath}images/energie.gif" border="0" height="22" width="42"></td>
			<td class="header" align="center" width="150"><img src="{dpath}images/message.gif" border="0" height="22" width="42"></td>
		</tr>
		<tr class="header">
			<td class="header" align="center" width="150"><b><font color="#ffffff"></font></b></td>
			<td class="header" align="center" width="150"><b><font color="#FFFF00">{Metal}</font></td>
			<td class="header" align="center" width="150"><b><font color="#FFFF00">{Crystal}</font></b></td>
			<td class="header" align="center" width="150"><b><font color="#FFFF00">{Deuterium}</font></b></td>
			<td class="header" align="center" width="150"><b><font color="#FFFF00">{Energy}</font></b></td>
			<td class="header" align="center" width="150"><b><font color="#FFFF00">{Message}</font></b></td>
		</tr>
 		<center>
		<tr class="header">

		    <td class="header" align="center" width="150"><b><font color="#FFFF00">{Ressverf}</font></b></td>
			<td class="header" align="center" width="150"><font><div id="metal"></div></font></td>
			<td class="header" align="center" width="150"><font><div id="crystal"></div></font></td>
			<td class="header" align="center" width="150"><font><div id="deut"></div></font></td>
			<td class="header" align="center" width="150"><font>{energy_total}</font></td>
			<td class="header" align="center" width="150"><font></font>{message}</td>
		</tr>
			<td class="header" align="center" width="150"><b><font color="#FFFF00">{Store_max}</font></b></td>
			<td class="header" align="center" width="150">{metal_max}</td>
			<td class="header" align="center" width="150">{crystal_max}</td>
			<td class="header" align="center" width="150">{deuterium_max}</td>
			<td class="header" align="center" width="150"><font color="#00ff00">{energy_max}</font></td>
			<td class="header" align="center" width="150"><font></font></td>
		</tr>
			<td class="header" align="center" width="150">&nbsp;</td>
			<td class="header" align="center" width="150">&nbsp;</td>
			<td class="header" align="center" width="150">&nbsp;</td>
			<td class="header" align="center" width="150">&nbsp;</td>
			<td class="header" align="center" width="150">&nbsp;</td>
			<td class="header" align="center" width="150"><font></font></td>
		</table>
	</td>
</tr>
</tbody>
</table>
{show_umod_notice}
</center>
</div>

<script LANGUAGE='JavaScript'>
<!--
var now = new Date();
var event = new Date();
var seconds = (Date.parse(now) - Date.parse(event)) / 1000;
var val = 0;
var val2 = 0;
var val3 = 0;

update();

function update() {
  now = new Date();
  seconds = (Date.parse(now) - Date.parse(event)) / 1000;

  val = (( {metal_perhour} / 3600) * seconds) + {metalh};
  if( val >= {metal_mmax} ) val = {metalh};
  document.getElementById('metal').innerHTML = number_format( val ,0);

  val = ( {crystal_perhour} / 3600) * seconds + {crystalh};
  if( val >= {crystal_mmax} ) val = {crystalh};
  document.getElementById('crystal').innerHTML = number_format( val ,0);

  val = ( {deuterium_perhour} / 3600) * seconds + {deuteriumh};
  if( val >= {deuterium_mmax} ) val = {deuteriumh};
  document.getElementById('deut').innerHTML = number_format( val ,0);


  ID=window.setTimeout('update();',1000);
}

function number_format(number,laenge) {
  number = Math.round( number * Math.pow(10, laenge) ) / Math.pow(10, laenge);
  str_number = number+'';
  arr_int = str_number.split('.');
  if(!arr_int[0]) arr_int[0] = '0';
  if(!arr_int[1]) arr_int[1] = '';
  if(arr_int[1].length < laenge){
    nachkomma = arr_int[1];
    for(i=arr_int[1].length+1; i <= laenge; i++){  nachkomma += '0';  }
    arr_int[1] = nachkomma;
  }
  if(arr_int[0].length > 3){
    Begriff = arr_int[0];
    arr_int[0] = '';
    for(j = 3; j < Begriff.length ; j+=3){
      Extrakt = Begriff.slice(Begriff.length - j, Begriff.length - j + 3);
      arr_int[0] = '.' + Extrakt +  arr_int[0] + '';
    }
    str_first = Begriff.substr(0, (Begriff.length % 3 == 0)?3:(Begriff.length % 3));
    arr_int[0] = str_first + arr_int[0];
  }
  return arr_int[0]+''+arr_int[1];
}
// --></script>