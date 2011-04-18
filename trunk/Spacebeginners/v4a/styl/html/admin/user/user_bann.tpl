<form action="user_bann.php" method="post"><input type="hidden" name="mode" value="banit">
<table width="100%"><tr><th align="left" ><u>{adm_bn_ttle}</u></th></tr>
</table><p></p><p></p><table width="95%">

<tr><td class="c" align="left" width="50%">{sperr_aa}</td>
    <td class="c" align="left" width="50%">{sperr_ab}</td></tr>
<table width="95%" ><tr><th width="50%" valign="top">

<table width="100%" >

<tr><th width="50%" align="left"   >{adm_bn_name}</th>
    <th width="50%" align="center" ><input name="name" type="text" size="25" /></th></tr>
<tr><th width="50%" align="left"   >{adm_bn_reas}</th>
    <th width="50%" align="center" ><input name="why" type="text" value="" size="25" maxlength="50"></th></tr>

</table></th><th width="50%" valign="top" >
<table width="100%" >

<tr><th width="50%" align="left"   >{adm_bn_days}</th>
    <th width="50%" align="center" ><input name="days" type="text" value="0" size="5" /></th></tr>
<tr><th width="50%" align="left"   >{adm_bn_hour}</th>
    <th width="50%" align="center" ><input name="hour" type="text" value="0" size="5" /></th></tr>
<tr><th width="50%" align="left"   >{adm_bn_mins}</th>
    <th width="50%" align="center" ><input name="mins" type="text" value="0" size="5" /></th></tr>
<tr><th width="50%" align="left"   >{adm_bn_secs}</th>
    <th width="50%" align="center" ><input name="secs" type="text" value="0" size="5" /></th></tr>

</table></th></tr></table>
<table width="100%">

<tr><th><input type="submit" value="{adm_bn_bnbt}" /></th></tr>

</table></form>