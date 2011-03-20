<table width="520">
    <tr>
    	<td class="c" colspan="4">{er_error_list} [<a href="?page=errors&deleteall=yes">{er_dlte_all}</a>]</td>
    </tr>
    <tr>
        <th width="25">{er_id}</th>
        <th width="170">{er_type}</th>
        <th width="230">{er_data}</th>
        <th width="95">{er_delete}</th>
    </tr>
<!-- START BLOCK : list_error -->
    <tr>
			<td width="25" align='center'>{error_id}</td>
			<td width="170" align='center'>{error_type}</td>
			<td width="230" align='center'>{error_time}</td>
			<td width="95" align='center'><a href="?page=errors&delete={error_id}"><img src="./styles/images/r1.png" border="0"></a></td>
		</tr>
		<tr>
			<td colspan="3" class=c >{error_text}</td>
			<td colspan="1" class=b align='center'>{error_page}: {error_line}</td>
		</tr>
<!-- END BLOCK : list_error -->
{errors_list}
</table>