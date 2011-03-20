<script type="text/javascript" src="./../scripts/jquery.js"></script>
<script type="text/javascript" src="./../scripts/animatedcollapse.js"></script>
<script type="text/javascript">

animatedcollapse.addDiv('01', 'fade=1,height=auto')
animatedcollapse.addDiv('02', 'fade=1,height=auto')
animatedcollapse.addDiv('03', 'fade=1,height=auto')
animatedcollapse.addDiv('04', 'fade=1,height=auto')
animatedcollapse.addDiv('05', 'fade=1,height=auto')
animatedcollapse.addDiv('06', 'fade=1,height=auto')
animatedcollapse.addDiv('07', 'fade=1,height=auto')
animatedcollapse.addDiv('08', 'fade=1,height=auto')
animatedcollapse.addDiv('09', 'fade=1,height=auto')
animatedcollapse.addDiv('10', 'fade=1,height=auto')

animatedcollapse.ontoggle=function($, divobj, state){
}

animatedcollapse.init()

</script><form action="" method="post"><input type="hidden" name="opt_save" value="1">
<table width="100%"><tr><th align="left" ><u>{grund01}</u></th></tr>
</table><p></p><table width="500px">

<tr><th align="left" >{grund02}</th></tr>

</table><p></p></table><p></p><table width="95%">
<tr><td align="left" >{grund03}</td></tr>
</table><p></p>

<table><tr><th align="center" valign="top" width="90%" ><table width="500px">
<tr><td class="c"><a href="javascript:animatedcollapse.toggle('01')">{grund_aa}</a></td></tr>
</table><div id="01" style="display:none"><table width="510px">

<tr><th align="left" >{grund_ab}</th>
    <th align="right"><input name="game_name"   size="30" maxlength="20" value="{game_name}"   type="text"></th></tr>
<tr><th align="left" >{grund_ac}</th>
    <th align="right"><input name="VERSION"     size="30" maxlength="20" value="{VERSION}"     type="text"></th></tr>
<tr><th align="left" >{grund_ad}</th>
    <th align="right"><input name="game_speed"  size="30" maxlength="20" value="{game_speed}"  type="text"></th></tr>
<tr><th align="left" >{grund_ae}</th>
    <th align="right"><input name="fleet_speed" size="30" maxlength="20" value="{fleet_speed}" type="text"></th></tr>
<tr><th align="left" >{grund_af}</th>
    <th align="right"><input name="resource_multiplier" size="30" maxlength="20" value="{resource_multiplier}" type="text"></th></tr>
<tr><th align="left" rowspan="2" >{grund_ag}</th>
    <th align="right"><input name="stat_settings" size="30" maxlength="20" value="{stat_settings}" type="text"></th></tr>
<tr><th align="right">{grund_ag01}</th></tr>
<tr><th align="left" >{grund_ah}</th>
    <th align="right"><input name="forum_url" size="30" maxlength="254" value="{forum_url}" type="text"></th></tr>

</table></div><p></p><table width="500px">
<tr><td class="c"><a href="javascript:animatedcollapse.toggle('02')">{schlie_aa}</a></td></tr>
</table><div id="02" style="display:none"><table width="500px">

<tr><th align="left" >{schlie_ac}</th>
    <th align="center"><input name="SHOW_ADMIN_IN_RECORDS"{SHOW_ADMIN_IN_RECORDS} type="checkbox" /></th></tr>
<tr><th align="left" >{schlie_ab}</th>
    <th align="center"><input name="attack_disabled"{attack_disabled} type="checkbox" /></th></tr>
<tr><th align="left" >{schlie_ad}</th>
    <th align="center"><input name="closed"{closed} type="checkbox" /></th></tr>
<tr><th colspan="2" ><textarea name="close_reason" cols="60" rows="5" size="80" >{close_reason}</textarea></th></tr>

</table></div><p></p><table width="500px">
<tr><td class="c"><a href="javascript:animatedcollapse.toggle('03')">{natur_aa}</a></td></tr>
</table><div id="03" style="display:none"><table width="510px">

<tr><th align="left" >{natur_ab}</th>
    <th align="right"><input name="initial_fields" size="30" maxlength="20" value="{initial_fields}" type="text"></th></tr>
<tr><th align="left" >{natur_ac} {Metal}         {natur_ac01}</th>
    <th align="right"><input name="metal_basic_income" size="30" maxlength="20" value="{metal_basic_income}" type="text"></th></tr>
<tr><th align="left" >{natur_ad} {Crystal}       {natur_ad01}</th>
    <th align="right"><input name="crystal_basic_income" size="30" maxlength="20" value="{crystal_basic_income}" type="text"></th></tr>
<tr><th align="left" >{natur_ae} {Deuterium}     {natur_ae01}</th>
    <th align="right"><input name="deuterium_basic_income" size="30" maxlength="20" value="{deuterium_basic_income}" type="text"></th></tr>
<tr><th align="left" >{natur_af} {Appolonium}     {natur_af01}</th>
    <th align="right"><input name="appolonium_basic_income" size="30" maxlength="20" value="{appolonium_basic_income}" type="text"></th></tr>
<tr><th align="left" >{natur_ag} {Energy}        {natur_ag01}</th>
    <th align="right"><input name="energy_basic_income" size="30" maxlength="20" value="{energy_basic_income}" type="text"></th></tr>

</table></div><p></p><table width="500px">
<tr><td class="c"><a href="javascript:animatedcollapse.toggle('04')">{planet_aa}</a></td></tr>
</table><div id="04" style="display:none"><table width="510px">

<tr><th align="left" >{planet_ab}</th>
    <th align="right"><input name="LastSettedGalaxyPos" maxlength="1" size="30" value="{LastSettedGalaxyPos}" type="text" /></th></tr>
<tr><th align="left" >{planet_ac}</th>
    <th align="right"><input name="LastSettedSystemPos" maxlength="3" size="30" value="{LastSettedSystemPos}" type="text" /></th></tr>
<tr><th align="left" >{planet_ad}</th>
    <th align="right"><input name="LastSettedPlanetPos" maxlength="2" size="30" value="{LastSettedPlanetPos}" type="text" /></th></tr>

</table></div><p></p><table width="500px">
<tr><td class="c"><a href="javascript:animatedcollapse.toggle('05')">{tf_aa}</a></td></tr>
</table><div id="05" style="display:none"><table width="510px">

<tr><th align="left" >{tf_ab}</th>
    <th align="right"><input name="Fleet_Cdr" maxlength="3" size="30" value="{Fleet_Cdr}" type="text" /></th></tr>
<tr><th align="left" >{tf_ac}</th>
    <th align="right"><input name="Defs_Cdr" maxlength="3" size="30" value="{Defs_Cdr}" type="text" /></th></tr>

</table></div><p></p><table width="500px">
<tr><td class="c"><a href="javascript:animatedcollapse.toggle('06')">{noob_aa}</a></td></tr>
</table><div id="06" style="display:none"><table width="510px">

<tr><th align="left" >{noob_ab}</th>
    <th align="right"><input name="noobprotection" maxlength="1" size="30" value="{noobprotection}" type="text" /></th></tr>
<tr><th align="left" >{noob_ac}</th>
    <th align="right"><input name="noobprotectiontime" maxlength="12" size="30" value="{noobprotectiontime}" type="text" /></th></tr>
<tr><th align="left" >{noob_ad}</th>
    <th align="right"><input name="noobprotectionmulti" maxlength="5" size="30" value="{noobprotectionmulti}" type="text" /></th></tr>

</table></div><p></p><table width="500px">
<tr><td class="c"><a href="javascript:animatedcollapse.toggle('07')">{multi_aa}</a></td></tr>
</table><div id="07" style="display:none"><table width="510px">

<tr><th align="left" >{multi_ae}</th>
    <th align="right"><input name="bot_enable" size="30" value="{enable_bot}" type="text"></th></tr>
<tr><th align="left" >{multi_ab}</th>
    <th align="right"><textarea name="name_bot" cols="23" rows="1" size="80" >{bot_name}</textarea></th></tr>
<tr><th align="left" >{multi_ac}</th>
    <th align="right"><textarea name="adress_bot" cols="23" rows="1" size="80" >{bot_adress}</textarea></th></tr>
<tr><th align="left" >{multi_ad}</th>
    <th align="right"><input name="duration_ban" size="30" value="{ban_duration}" type="text"></th></tr>

</table></div><p></p><table width="500px">
<tr><td class="c"><a href="javascript:animatedcollapse.toggle('08')">{nachr_aa}</a></td></tr>
</table><div id="08" style="display:none"><table width="510px">

<tr><th align="left" >{nachr_ab}</th>
    <th align="right"><input name="bbcode_field" size="30" maxlength="254" value="{enable_bbcode}" type="text"></th></tr>

</table></div><p></p><table width="500px">
<tr><td class="c"><a href="javascript:animatedcollapse.toggle('09')">{news_aa}</a></td></tr>
</table><div id="09" style="display:none"><table width="510px">

<tr><th align="left"  >{news_ab}</th>
    <th align="center"><input name="newsframe"{newsframe} type="checkbox" /></th></tr>
<tr><th colspan="2"><textarea name="NewsText" cols="60" rows="5" size="80" >{NewsTextVal}</textarea></th></tr>

</table></div><p></p><table width="500px">
<tr><td class="c"><a href="javascript:animatedcollapse.toggle('10')">{sonst_aa}</a></td></tr>
</table><div id="10" style="display:none"><table width="510px">

<tr><th align="left"  >{sonst_ab}</th>
    <th align="center"><input name="chatframe"{chatframe} type="checkbox" /></th></tr>
<tr><th colspan="2"><textarea name="ExternChat" cols="60" rows="5" size="80" >{ExtTchatVal}</textarea></th></tr>
<tr><th align="left"  >{sonst_ac}</th>
    <th align="center"><input name="googlead"{googlead} type="checkbox" /></th></tr>
<tr><th colspan="2"><textarea name="GoogleAds" cols="60" rows="5" size="80" >{GoogleAdVal}</textarea></th></tr>
<tr><th align="left"  >{sonst_ad}</th>
    <th align="right" ><textarea name="banner_source_post" cols="24" rows="1" size="80" >{banner_source_post}</textarea></th></tr>
<tr><th align="left"  >{sonst_ae}<br /></th>
    <th align="center"><input name="bannerframe"{bannerframe} type="checkbox" />({sonst_ae01})</th></tr>
<tr><th colspan="2"><img src="{banner_source_post}" alt="{banner_source_post}" title="{banner_source_post}"></th></tr>

</table></div></th>
<th valign="middle" width="10%" align="right" ><table>

</tr><th><input value="{grund_999}" type="submit"></th></tr>

</table></th></tr>
</table></form>