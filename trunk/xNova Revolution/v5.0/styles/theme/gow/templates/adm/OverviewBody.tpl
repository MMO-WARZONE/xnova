{include file="adm/overall_header.tpl"}
<br>
<script type="text/javascript" src="./scripts/buildlist.js"></script>
<center>
<h1>{$ow_title}</h1>
<table width="90%" style="border:2px {if empty($Messages)}lime{else}red{/if} solid;text-align:center;font-weight:bold;">
<tr>
    <td class="transparent">{foreach item=Message from=$Messages}
	<span style="color:red">{$Message}</span><br>
	{foreachelse}{$ow_none}{/foreach}
	</td>
</tr>
</table>
<br>
<table width="80%">

 <tr>
    	<th colspan="2">{$ow_credits}</th>
    </tr>
    <tr>
    	<td colspan="2">
            <table width="475" align="center" style="text-align:center;">
                <tr>
					<td class="transparent"><h3>{$ow_proyect_leader}</h3></td>
                </tr>
                <tr>
					<td class="transparent"><a href="http://www.xnovarevolution.com.ar/?page_id=11" target="_blank"><font color="red" size="2"><b>Brayan Narv&aacute;ez (Designer and Developer of xNova Revolution)</b></font></a></td>
                </tr>
                <tr>
					<td class="transparent"><h3><br>Team of <a href="http://2moons.cc/" target="_blank">2Moons</a></h3></td>
                </tr>
                <tr>
					<td class="transparent">
					<span style="color:orange"><font color="red">Slaver - 2moons leader</font> <br>
					Robbyn - Communityleitung<br>
					Lyon - Forenadministrator<br>
					Freak1992 - Forenadministrator<br>
					Buggy666 - Forenmoderrator
					</span></td>
                </tr><br>
		        <tr>
					<td class="transparent"><h3><br>{$ow_translator}</h3></td>
                </tr>
                <tr>
					<td class="transparent">
					Z3roCooL (english)<br>
					Yoda (frensh)<br>
					QwataKayean (portuguese)<br>
					g4me0ver (portuguese)<br>
					InquisitorEA (russian)<br>
					</td>
                </tr>
                <tr>
					<td class="transparent"><h3><br>{$ow_special_thanks}</h3></td>
                </tr>
                <tr>
					<td class="transparent">lucky<br>Metusalem<br>Meikel<br>Phil<br>Schnippi<br>Inforcer<br>Vobi<br>Onko<br>Sycrog<br>Raito<br>Chlorel<br>e-Zobar<br>Flousedid<br>Allen Spielern im <a href="http://www.titanspace.org" target="blank">Betauni</a> ...<br>... and all Community of 2moons and xNova Revolution </td>
                </tr>    
            </table>
        </td>
    </tr> 
</table>
</center>
<script type="text/javascript">
$(document).ready(function(){
	$('.UIStory_Message').css("color","#CCCCCC");
});
</script>
{include file="adm/overall_footer.tpl"}