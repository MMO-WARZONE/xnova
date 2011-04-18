<form action="user_all.php?page=del_offis" method="post"><input type="hidden" name="mode" value="addit">
<script type="text/javascript" src="./../scripts/jquery.js"></script>
<script type="text/javascript" src="./../scripts/animatedcollapse.js"></script>
<script type="text/javascript">

animatedcollapse.addDiv('01', 'fade=1,height=auto')
animatedcollapse.addDiv('02', 'fade=1,height=auto')
animatedcollapse.addDiv('03', 'fade=1,height=auto')
animatedcollapse.addDiv('04', 'fade=1,height=auto')
animatedcollapse.addDiv('05', 'fade=1,height=auto')

animatedcollapse.ontoggle=function($, divobj, state){
}

animatedcollapse.init()

</script><table width="100%"><tr><th align="left" ><u>{all_aa}</u></th></tr>
</table><p></p><p></p><table width="95%">

<tr><td class="c" align="left" width="50%"><a href="javascript:animatedcollapse.toggle('01')">{all_ab}</a></td>
    <td class="c" align="left" width="50%"><a href="javascript:animatedcollapse.toggle('02')">{all_ac}</a></td></tr>

<table width="95%" ><tr><th width="50%" valign="top">
<div id="01" style="display:none"><table width="100%" >

<tr><th><a href="user_all.php?page=add_ress">    {all_ad} </a></th></tr>
<tr><th><a href="user_all.php?page=add_fleet">   {all_ae} </a></th></tr>
<tr><th><a href="user_all.php?page=add_deff">    {all_af} </a></th></tr>
<tr><th><a href="user_all.php?page=add_gebaude"> {all_ag} </a></th></tr>
<tr><th><a href="user_all.php?page=add_forsch">  {all_ah} </a></th></tr>
<tr><th><a href="user_all.php?page=add_offis">   {all_ai} </a></th></tr>

</table></div></th><th width="50%" valign="top" >
<div id="02" style="display:none"><table width="100%" >

<tr><th><a href="user_all.php?page=del_ress">    {all_ad} </a></th></tr>
<tr><th><a href="user_all.php?page=del_fleet">   {all_ae} </a></th></tr>
<tr><th><a href="user_all.php?page=del_deff">    {all_af} </a></th></tr>
<tr><th><a href="user_all.php?page=del_gebaude"> {all_ag} </a></th></tr>
<tr><th><a href="user_all.php?page=del_forsch">  {all_ah} </a></th></tr>
<tr><th><a href="user_all.php?page=del_offis">   {all_ai} </a></th></tr>

</table></div></table><table><table width="95%">
<tr><th width="50%" valign="top"><table width="100%">

<tr><th>&nbsp;</th></tr>

</table></th><th width="50%" valign="top" >
<table width="100%" >

<tr><td width="50%" align="center" >{all_am}</td>
    <td width="50%" align="center" ><input name="id" type="text" value="0" /></td></tr>

<tr><th width="50%">{offi_aa}</th>
    <th width="50%"><input name="rpg_geologue" type="text" value="0" />          </th></tr>
<tr><th width="50%">{offi_ab}</th>
    <th width="50%"><input name="rpg_amiral" type="text" value="0" />            </th></tr>
<tr><th width="50%">{offi_ac}</th>
    <th width="50%"><input name="rpg_ingenieur" type="text" value="0" />         </th></tr>
<tr><th width="50%">{offi_ad}</th>
    <th width="50%"><input name="rpg_technocrate" type="text" value="0" />       </th></tr>
<tr><th width="50%">{offi_ae}</th>
    <th width="50%"><input name="rpg_constructeur" type="text" value="0" />      </th></tr>
<tr><th width="50%">{offi_af}</th>
    <th width="50%"><input name="rpg_scientifique" type="text" value="0" />      </th></tr>
<tr><th width="50%">{offi_ag}</th>
    <th width="50%"><input name="rpg_stockeur" type="text" value="0" />          </th></tr>
<tr><th width="50%">{offi_ah}</th>
    <th width="50%"><input name="rpg_defenseur" type="text" value="0" />         </th></tr>
<tr><th width="50%">{offi_ai}</th>
    <th width="50%"><input name="rpg_bunker" type="text" value="0" />            </th></tr>
<tr><th width="50%">{offi_aj}</th>
    <th width="50%"><input name="rpg_espion" type="text" value="0" />            </th></tr>
<tr><th width="50%">{offi_ak}</th>
    <th width="50%"><input name="rpg_commandant" type="text" value="0" />        </th></tr>
<tr><th width="50%">{offi_al}</th>
    <th width="50%"><input name="rpg_destructeur" type="text" value="0" />       </th></tr>
<tr><th width="50%">{offi_am}</th>
    <th width="50%"><input name="rpg_general" type="text" value="0" />           </th></tr>
<tr><th width="50%">{offi_an}</th>
    <th width="50%"><input name="rpg_raideur" type="text" value="0" />           </th></tr>
<tr><th width="50%">{offi_ao}</th>
    <th width="50%"><input name="rpg_empereur" type="text" value="0" />          </th></tr>


</table><table width="100%">
<tr><th><input type="Submit" value="{all_ak}" /></th></tr>

</table></div></table><table>
</form>