<br><br>
<center>
<h2>{adm_bn_ttle}</h2>
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js?load=effects,controls" type="text/javascript"></script>
<form action="" method="get">
<input type="hidden" name="action" value="administrativePlayerBanning" />
</form>
<form action="" method="post">
<input type="hidden" name="mode" value="banit">
<table width="700">
<tr>
	<td class="c" colspan="2">{adm_bn_plto}</td>
</tr><tr>
	<th width="129">{adm_bn_name}</th>
	<th width="571"><input name="name" type="text" size="25" id="name" /><div id="destinationDiv" class="autocomplete"></div></th>
</tr><tr>
	<th width="129">{adm_bn_reas}</th>
	<th width="571"><input name="why" type="text" value="" size="25" maxlength="50"></th>
</tr><tr>
	<td class="c" colspan="2">{adm_bn_time}</td>
</tr><tr>
	<th width="129">{adm_bn_days}</th>
	<th width="571"><input name="days" type="text" value="0" size="5" /></th>
</tr><tr>
	<th width="129">{adm_bn_hour}</th>
	<th width="571"><input name="hour" type="text" value="0" size="5" /></th>
</tr><tr>
	<th width="129">{adm_bn_mins}</th>
	<th width="571"><input name="mins" type="text" value="0" size="5" /></th>
</tr><tr>
	<th width="129">{adm_bn_secs}</th>
	<th width="571"><input name="secs" type="text" value="0" size="5" /></th>
</tr><tr>
	<th colspan="2"><input type="submit" value="{adm_bn_bnbt}" /></th>
</tr>
</table>
</form>
<script type="text/javascript">//<![CDATA[
new Ajax.Autocompleter('name','destinationDiv','indexGame.php?action=administrativePlayerBanning', {
	indicator: 'loadingImg'
});
//]]></script>
</center>