{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
	{if $ExtraDMList}
    <table align="top" width="530">	
	    <tr>
			<center><img src="./styles/theme/gow/adds/oficiales.png"></center>
		</tr>
		{foreach item=ExtraDMInfo from=$ExtraDMList}
		<tr>
			<td rowspan="2" style="background-image:url({$dpath}img/invisible.png);border:none;width:120px;">
				<a href="javascript:void(0);">
					<img src="{$dpath}gebaeude/{$ExtraDMInfo.id}.png" alt="{$ExtraDMInfo.name}" width="120" height="120">
				</a>
			</td>
			<th>
				<a href="javascript:void(0);">{$ExtraDMInfo.name}</a>
			</th>
		</tr>
		<tr>
			<td>
				<table style="width:100%">
					<tbody>
						<tr>
							<td class="transparent left" style="width:90%;padding:10px;">{$ExtraDMInfo.desc}<br><br>{$Darkmatter}: {if $ExtraDMInfo.isok}<span style="color:lime">{$ExtraDMInfo.price}</span>{else}<span style="color:#FF0000">{$ExtraDMInfo.price}</span>{/if} {$in_dest_durati}: <span style="color:lime">{$ExtraDMInfo.time}</span></td>
							<td class="transparent" style="vertical-align:middle;width:100px">
							{if $ExtraDMInfo.active > 0}
							{$of_still}<br>
							<div id="time_{$ExtraDMInfo.id}" class="z">-</div>
							{$of_active}{if $ExtraDMInfo.isok}
							<br>
							<a href="?page=officier&amp;extra={$ExtraDMInfo.id}&amp;action=send">{$of_update}</a>{/if}
							{else}{if $ExtraDMInfo.isok}
							<a href="?page=officier&amp;extra={$ExtraDMInfo.id}&amp;action=send"><span style="color:#00FF00">{$of_recruit}</span></a>{else}<span style="color:#FF0000">{$of_recruit}</span>{/if}{/if}
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		{/foreach}
    </table>
	<br><br>
	{/if}
	{if $OfficierList}
		{foreach item=OfficierInfo from=$OfficierList}
		
		{/foreach}
	{/if}
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}