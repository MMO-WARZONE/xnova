<form action="user_all.php?page=add_deff" method="post"><input type="hidden" name="mode" value="addit">
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

<tr><td width="50%" align="center" >{all_al}</td>
    <td width="50%" align="center" ><input name="id" type="text" value="0" /></td></tr>

<tr><th width="50%">{def_aa}</th>
    <th width="50%"><input name="misil_launcher" type="text" value="0" />                </th></tr>
<tr><th width="50%">{def_ab}</td>
    <th width="50%"><input name="small_laser" type="text" value="0" />                   </th></tr>
<tr><th width="50%">{def_ac}</td>
    <th width="50%"><input name="big_laser" type="text" value="0" />                     </th></tr>
<tr><th width="50%">{def_ad}</td>
    <th width="50%"><input name="gauss_canyon" type="text" value="0" />                  </th></tr>
<tr><th width="50%">{def_ae}</td>
    <th width="50%"><input name="ionic_canyon" type="text" value="0" />                  </th></tr>
<tr><th width="50%">{def_af}</td>
    <th width="50%"><input name="buster_canyon" type="text" value="0" />                 </th></tr>
<tr><th width="50%">{def_ag}</td>
    <th width="50%"><input name="small_protection_shield" type="text" value="0" />       </th></tr>
<tr><th width="50%">{def_ah}</td>
    <th width="50%"><input name="big_protection_shield" type="text" value="0" />         </th></tr>
<tr><th width="50%">{def_ai}</td>
    <th width="50%"><input name="gig_protection_shield" type="text" value="0" />         </th></tr>
<tr><th width="50%">{def_aj}</td>
    <th width="50%"><input name="Gravitonka" type="text" value="0" />                    </th></tr>
<tr><th width="50%">{def_ak}</td>
    <th width="50%"><input name="interceptor_misil" type="text" value="0" />             </th></tr>
<tr><th width="50%">{def_al}</td>
    <th width="50%"><input name="interplanetary_misil" type="text" value="0" />          </th></tr>

</table><table width="100%">
<tr><th><input type="Submit" value="{all_aj}" /></th></tr>

</table></th><th width="50%" valign="top" >
<table width="100%" >

<tr><th>&nbsp;</th></tr>

</table></div></table><table>
</form>