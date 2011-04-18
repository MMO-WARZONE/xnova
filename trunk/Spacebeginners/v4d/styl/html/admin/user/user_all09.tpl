<form action="user_all.php?page=del_gebaude" method="post"><input type="hidden" name="mode" value="addit">
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

<tr><td width="50%" align="center" >{all_al}</td>
    <td width="50%" align="center" ><input name="id" type="text" value="0" /></td></tr>

<tr><th width="50%">{gebau_aa}</th>
    <th width="50%"><input name="metal_mine" type="text" value="0" />            </th></tr>
<tr><th width="50%">{gebau_ab}</td>
    <th width="50%"><input name="crystal_mine" type="text" value="0" />          </th></tr>
<tr><th width="50%">{gebau_ac}</td>
    <th width="50%"><input name="deuterium_sintetizer" type="text" value="0" />  </th></tr>
<tr><th width="50%">{gebau_ad}</td>
    <th width="50%"><input name="solar_plant" type="text" value="0" />           </th></tr>
<tr><th width="50%">{gebau_ae}</td>
    <th width="50%"><input name="fusion_plant" type="text" value="0" />          </th></tr>
<tr><th width="50%">{gebau_af}</td>
    <th width="50%"><input name="robot_factory" type="text" value="0" />         </th></tr>
<tr><th width="50%">{gebau_ag}</td>
    <th width="50%"><input name="nano_factory" type="text" value="0" />          </th></tr>
<tr><th width="50%">{gebau_ah}</td>
    <th width="50%"><input name="hangar" type="text" value="0" />                </th></tr>
<tr><th width="50%">{gebau_ai}</td>
    <th width="50%"><input name="metal_store" type="text" value="0" />           </th></tr>
<tr><th width="50%">{gebau_aj}</td>
    <th width="50%"><input name="crystal_store" type="text" value="0" />         </th></tr>
<tr><th width="50%">{gebau_ak}</td>
    <th width="50%"><input name="deuterium_store" type="text" value="0" />       </th></tr>
<tr><th width="50%">{gebau_al}</td>
    <th width="50%"><input name="laboratory" type="text" value="0" />            </th></tr>
<tr><th width="50%">{gebau_am}</td>
    <th width="50%"><input name="terraformer" type="text" value="0" />           </th></tr>
<tr><th width="50%">{gebau_an}</td>
    <th width="50%"><input name="ally_deposit" type="text" value="0" />          </th></tr>
<tr><th width="50%">{gebau_ao}</td>
    <th width="50%"><input name="silo" type="text" value="0" /></th></tr>

</table><table width="100%">
<tr><th><input type="Submit" value="{all_ak}" /></th></tr>

</table></div></table><table>
</form>