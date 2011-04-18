<br>
<center>
<form action="?action=internalStats" method="post">
	<table width="700">
		<tr>
			<td class="c" colspan="6">{stat_title}: {stat_date}</td>
		</tr>
		<tr>
			<th>{stat_show}&nbsp;</th>
			<th><select name="who" onChange="javascript:document.forms[1].submit()">{who}</select></th>
			<th>&nbsp;{stat_by}&nbsp;</th>
			<th><select name="type" onChange="javascript:document.forms[1].submit()">{type}</select></th>
			<th>&nbsp;{stat_range}&nbsp;</th>
			<th><select name="range" onChange="javascript:document.forms[1].submit()">{range}</select></th>
		</tr>
	</table>
</form>
<table width="700">
{stat_header}
{stat_values}
</table>
</center>
