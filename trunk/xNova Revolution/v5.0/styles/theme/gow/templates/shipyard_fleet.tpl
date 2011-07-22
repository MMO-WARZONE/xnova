{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
	{if !$NotBuilding}<table width="70%" id="infobox" style="border: 2px solid red; text-align:center;background:transparent"><tr><td>{$bd_building_shipyard}</td></tr></table><br><br>{/if}
	{if $BuildList != '[]'}
    <table>
		<tr>
			<td class="transparent">
				<div id="bx" class="z"></div>
				<br>
				<form method="POST" action="">
				<input type="hidden" name="mode" value="fleet">
				<input type="hidden" name="action" value="delete">
				<table>
				<tr>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td><select name="auftr[]" id="auftr" size="10" multiple><option>&nbsp;</option></select><br><br>{$bd_cancel_warning}<br><input type="Submit" value="{$bd_cancel_send}"></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
				</tr>
				</table>
				</form>
				<br><span id="timeleft"></span><br><br>
			</td>
		</tr>
    </table>
	<br>
	{/if}
	<form action="" method="POST">
    <table align="top" width="530">	
		{foreach name=FleetList item=FleetListRow from=$FleetList}
		<tr>
		<th colspan="4"><a href="javascript:OpenPopup('game.php?page=infos&gid={$FleetListRow.id}', '', 640, 510);"><a href="javascript:OpenPopup('game.php?page=infos&gid={$FleetListRow.id}', '', 640, 510);">{$FleetListRow.name}</a>{if $FleetListRow.Available != 0} ({$bd_available} {$FleetListRow.Available}){/if}</th></tr>
		<tr>
			      
				  <td class="l" style="background-image:url({$dpath}img/invisible.png);border:none;">
                                 <a href="javascript:OpenPopup('game.php?page=infos&gid={$FleetListRow.id}', '', 610, 510)" onmouseover="return overlib('<center><font size=1 color=white><b>{$FleetListRow.descriptions}<b></b></font></a></center>', RIGHT, WIDTH, 150);" onmouseout="return nd();">
                                         <img src="{$dpath}gebaeude/{$FleetListRow.id}.png" width="120" height="120">
                                 </a>
                         </td>
			
 
			
			<td class="l">
									{if $NotBuilding && $FleetListRow.IsAvailable}<input type="text" name="fmenge[{$FleetListRow.id}]" id="input_{$FleetListRow.id}" size="{$maxlength}" maxlength="{$maxlength}" value="0" tabindex="{$smarty.foreach.FleetList.iteration}">							
						<!--BUTTON MAX IN HANGAR BUG IN THE FUNCTION maxcount IN SCRIPTS/GLOBAL.JS --><!--<input type="button" value="Max" onclick="$('#input_{$FleetListRow.id}').val(maxcount({$FleetListRow.id}))">-->
						<!--<td><a href="javascript:maxcount({$FleetListRow.id});">Max</a></td>--><!--TEST LINK-->
						{/if}<br><br>
				<font color="orange">{$fgf_time}</font>
				{$FleetListRow.time}<br>
				
			</td>
									
			                     
									
 <td class="l">
  {$FleetListRow.price}
  </td>
	{/foreach}
		{if $NotBuilding}<tr><th colspan="4" style="text-align:center"><input type="submit" value="{$bd_build_ships}"></th></tr>{/if}
    </table>
	</form>
</div>
<script type="text/javascript">
data			= {$BuildList};
bd_operating	= '{$bd_operating}';
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}