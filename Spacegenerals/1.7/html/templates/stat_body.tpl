<br>
<center>
<form method="post">
<table width="530">
<tr>
	<td class="c">{stat_title}: {stat_date}</td>
</tr><tr>
	<th align="center">
	<table>
	<tr>
		<th width="8%" style="background-color: blue;">&nbsp;</th>
		<th style="background-color: blue;">{stat_show}&nbsp;</th>
		<th style="background-color: blue;"><select name="who" onChange="javascript:document.forms[0].submit()">{who}</select></th>
		<th style="background-color: blue;">&nbsp;{stat_by}&nbsp;</th>
		<th style="background-color: blue;"><select name="type" onChange="javascript:document.forms[0].submit()">{type}</select></th>
		<th style="background-color: blue;">&nbsp;{stat_range}&nbsp;</th>
		<th style="background-color: blue;"><select name="range" onChange="javascript:document.forms[0].submit()">{range}</select></th>
		<th width="8%" style="background-color: blue;">&nbsp;</th>
	<tr>
	</table>
	</th>
</tr>
</table>
</form>
<table width="530">
{stat_header}
{stat_values}
</table>
</center>
</body>
</html>