{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
	<div id="buildlist" style="display:none;"></div>
    {if $IsLabinBuild}<table width="70%" id="infobox" style="border: 2px solid red; text-align:center;background:transparent"><tr><td>{$bd_building_lab}</td></tr></table><br><br>{/if}
    <table align="top" width="530">	
		{foreach item=ResearchInfoRow from=$ResearchList}
		<tr><th colspan="4"><a href="javascript:OpenPopup('game.php?page=infos&gid={$ResearchInfoRow.id}', '', 640, 510);">{$ResearchInfoRow.name}</a>	{if $ResearchInfoRow.lvl != 0} ({$bd_lvl} {$ResearchInfoRow.lvl}){/if}{if $ResearchInfoRow.elvl > 0} <span style="color:lime;">+{$ResearchInfoRow.elvl}</span>{/if} {$ResearchInfoRow.maxinfo}</th></tr>
		<tr>
			      
				  <td class="l" style="background-image:url({$dpath}img/invisible.png);border:none;">
                                 <a href="javascript:OpenPopup('game.php?page=infos&gid={$ResearchInfoRow.id}', '', 610, 510)" onmouseover="return overlib('<center><font size=1 color=white><b>{$ResearchInfoRow.descr}<b></b></font></a></center>', RIGHT, WIDTH, 150);" onmouseout="return nd();">
                                         <img src="{$dpath}gebaeude/{$ResearchInfoRow.id}.png" alt="{$ResearchInfoRow.name}"  width="120" height="120">
                                 </a>
                         </td>
			
 
			
			<td class="l">
			
				{$ResearchInfoRow.link}<br>
				<font color="orange">{$fgf_time}</font>
				{$ResearchInfoRow.time}
			</td>
			                     
									
 <td class="l">
  {$ResearchInfoRow.price}
  </td>
	{/foreach}
    </table>
</div>
{if $ScriptInfo}
<script type="text/javascript">
data	= {$ScriptInfo};
</script>
{/if}
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}