
<script language="JavaScript" type="text/javascript" src="scripts/overlib.js"></script>
<tr>
    <td class=c colspan="3"><span id="missiles">{currentmip}</span> {gl_avaible_missiles}</td>
    <td class=c colspan="3"><span id="slots">{maxfleetcount}</span>/{fleetmax} {gl_fleets}</td>
    <td class=c colspan="2">
		<span id="recyclers">{recyclers}</span> {gl_avaible_recyclers}<br>
		<span id="probes">{spyprobes}</span> {gl_avaible_spyprobes}</td>
</tr>
<tr style="display: none;" id="fleetstatusrow">
    <th class=c colspan="8">
		<table style="font-weight: bold" width="100%" id="fleetstatustable">
			<!-- will be filled with content later on while processing ajax replys -->
		</table>
	</th>
</tr>
<tr>
    <td class="c" colspan="8">{gl_solar_system} {galaxy}:{system}</td>
</tr>
<tr>
    <td class="c">{gl_pos}</td>
    <td class="c">{gl_planet}</td>
    <td class="c">{gl_name_activity}</td>
    <td class="c">{gl_moon}</td>
    <td class="c">{gl_debris}</td>
    <td class="c">{gl_player_estate}</td>
    <td class="c">{gl_alliance}</td>
    <td class="c">{gl_actions}</td>
</tr>
