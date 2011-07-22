<div id="header_top">
	<table class="header">
		<tr class="header">
			<td class="header" style="width: 150px;">
				<table class="header">
					<tr class="header">
						<td class="header" style="width: 50px;"><img src="{$dpath}planeten/small/s_{$image}.jpg" height="50" width="50" alt="Planetenbild"></td> 
						<td class="header" style="background:url({$dpath}img/nav.png);">	  
						<select onChange="document.location = $(this).val();">
						{html_options options=$PlanetSelect selected=$current_planet}
						</select>
						</td>
					</tr>
				</table>
			</td>
			<td class="header">
				<table class="header" id='resources'>
					<tr class="header">
						<td class="header" style="background:url({$dpath}img/nav.png);">
							<a style="cursor:help" href="javascript:void(0);" onmouseover="return overlib('{$Metal}');"
onmouseout="return nd();"><img src="{$dpath}images/metal.jpg" alt="{$Metal}"></a></a>
						</td>
						<td class="header" style="background:url({$dpath}img/nav.png);">
							<a style="cursor:help" href="javascript:void(0);" onmouseover="return overlib('{$Crystal}');"
onmouseout="return nd();"><img src="{$dpath}images/cristal.jpg" alt="{$Crystal}"></a>
						</td>
						<td class="header" style="background:url({$dpath}img/nav.png);">
							<a style="cursor:help" href="javascript:void(0);" onmouseover="return overlib('{$Deuterium}');"
onmouseout="return nd();"><img src="{$dpath}images/deuterio.jpg" alt="{$Deuterium}"></a>
						</td>
						<td class="header" style="background:url({$dpath}img/nav.png);">
							<a style="cursor:help" href="javascript:void(0);" onmouseover="return overlib('{$Norio}');"
onmouseout="return nd();"><img src="{$dpath}images/norio.jpg" alt="{$Norio}"></a>
						</td>
						<td class="header" style="background:url({$dpath}img/nav.png);">
							<a style="cursor:help" href="javascript:void(0);" onmouseover="return overlib('{$Darkmatter}');"
onmouseout="return nd();"><img src="{$dpath}images/materia_oscura.gif" alt="{$Darkmatter}"></a>
						</td>	     
						<td class="header" style="background:url({$dpath}img/nav.png);">
							<a style="cursor:help" href="javascript:void(0);" onmouseover="return overlib('{$Energy}');"
onmouseout="return nd();"><img src="{$dpath}images/energia.jpg" alt="{$Energy}"></a>
						</td>
					</tr>
					<tr class="header">
						<td class="header res_current" id="current_metal" style="background:url({$dpath}img/nav.png);">{pretty_number($metal)}</td>
						<td class="header res_current" id="current_crystal" style="background:url({$dpath}img/nav.png);">{pretty_number($crystal)}</td>
						<td class="header res_current" id="current_deuterium" style="background:url({$dpath}img/nav.png);">{pretty_number($deuterium)}</td>
						<td class="header res_current" id="current_norio" style="background:url({$dpath}img/nav.png);">{pretty_number($norio)}</td>						
						<td class="header res_current" style="background:url({$dpath}img/nav.png);">{$darkmatter}</td>
						<td class="header res_current" style="background:url({$dpath}img/nav.png);" >{$energy}</td>
					</tr>
					<tr class="header">
						<td class="header res_max" id="max_metal" style="background:url({$dpath}img/nav.png);"><span title="{$alt_metal_max}">{if $settings_tnstor}{$metal_max}{else}{$alt_metal_max}{/if}</span></td>
						<td class="header res_max" id="max_crystal" style="background:url({$dpath}img/nav.png);"><span title="{$alt_crystal_max}">{if $settings_tnstor}{$crystal_max}{else}{$alt_crystal_max}{/if}</span></td>
						<td class="header res_max" id="max_deuterium" style="background:url({$dpath}img/nav.png);"><span title="{$alt_deuterium_max}">{if $settings_tnstor}{$deuterium_max}{else}{$alt_deuterium_max}{/if}</span></td>
						<td class="header res_max" id="max_norio" style="background:url({$dpath}img/nav.png);"><span title="{$alt_norio_max}">{if $settings_tnstor}{$norio_max}{else}{$alt_norio_max}{/if}</span></td>
						<td class="header res_max"></td>
						<td class="header res_max"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	{if $closed}
	<table width="70%" id="infobox" style="border: 3px solid red; text-align:center;"><tr><td>{$closed}</td></tr></table>
	{elseif $delete}
	<table width="70%" id="infobox" style="border: 3px solid red; text-align:center;"><tr><td>{$tn_delete_mode} {$delete}</td></tr></table>
	{elseif $vacation}
	<table width="70%" id="infobox" style="border: 3px solid red; text-align:center;"><tr><td>{$tn_vacation_mode} {$vacation}</td></tr></table>
	{/if}
</div>