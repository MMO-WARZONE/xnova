<!-- START BLOCK : ally -->
<table width='299' border='0' align='center' cellpadding='1' cellspacing='1'>
	<tr>
		<td colspan='2' class='c'>{Alliance} {ally_name}</td>
	</tr>
	<tr>
		<th valign='top'>
			<table width='100%' border='0' cellspacing='2' cellpadding='2'>
				<tr>
					<td>{AllianceRank} {ally_rank_id}</td>
				</tr>
				<tr>
					<td>{AllianceMembers} {ally_members}</td>
				</tr>
			</table>
		</th>
		<th align='left' valign='top'>
			<table width='100%' border='0' cellspacing='2' cellpadding='2'>
				<!-- START BLOCK : ally_actions -->
				<tr>
					<td><a href='{action_link}'>{action_name}</a></td>
				</tr>
				<!-- END BLOCK : ally_actions -->
			</table>
		</th>
	</tr>
</table>
<!-- END BLOCK : ally -->
<!-- START BLOCK : debris -->
<table width='246' border='0' align='center' cellpadding='1' cellspacing='1'>
	<tr>
		<td colspan='2' class='c'>{Debris}{debris_position}</td>
	</tr>
	<tr>
		<th width='1%' align='center' valign='top'><img src='{dpath}planeten/debris.jpg' width='75' height='75'></th>
		<th align='left' valign='top'>
			<table width='100%' border='0' cellspacing='2' cellpadding='2'>
				<tr>
					<td colspan='2' class='c'>{resources}</td>
				</tr>
				<tr>
					<td colspan='2'>{resources_txt}</td>
				</tr>
				<tr>
					<td colspan='2' class='c'>{lang_actions}</td>
				</tr>
				<!-- START BLOCK : debris_actions -->
				<tr>
					<td colspan='2'><a href='{action_link}'>{action_name}</a></td>
				</tr>
				<!-- END BLOCK : debris_actions -->
			</table>
		</th>
	</tr>
</table>
<!-- END BLOCK : debris -->
<!-- START BLOCK : planet -->
<table width='246' border='0' align='center' cellpadding='1' cellspacing='1'>
	<tr>
		<td colspan='2' class='c'>{planet_name}{planet_position}</td>
	</tr>
	<tr>
		<th align='center' valign='top' width='1%'><img src='{dpath}planeten/small/s_{planet_image}.jpg'></th>
		<th align='left' valign='top'>
			<table width='100%' border='0' cellspacing='2' cellpadding='2'>
				<tr>
					<td colspan='2' class='c'>{lang_actions}</td>
				</tr>
				<!-- START BLOCK : planet_actions -->
				<tr>
					<td colspan='2'><a href='{action_link}'>{action_name}</a></td>
				</tr>
				<!-- END BLOCK : planet_actions -->
			</table>
		</th>
	</tr>
</table>
<!-- END BLOCK : planet -->
<!-- START BLOCK : moon -->
<table width='246' border='0' align='center' cellpadding='1' cellspacing='1'>
	<tr>
		<td colspan='2' class='c'>{moon_name}{moon_position}</td>
	</tr>
	<tr>
		<th width='1%' align='center' valign='top'><img src='{dpath}planeten/small/s_mond.jpg' width='75' height='75' /></th>
		<th align='left' valign='top'>
			<table width='100%' border='0' cellspacing='2' cellpadding='2'>
				<tr>
					<td colspan='2' class='c'>{Properties}</td>
				</tr>
				<tr>
					<td width='1%'>{mSize}</td>
					<td width='99%'>{moon_size}</td>
				</tr>
				<tr>
					<td>{mTemp}</td>
					<td>{moon_temp}</td>
				</tr>
				<tr>
					<td colspan='2' class='c'>{lang_actions}</td>
				</tr>
				<!-- START BLOCK : moon_actions -->
				<tr>
					<td colspan='2'><a href='{action_link}'>{action_name}</a></td>
				</tr>
				<!-- END BLOCK : moon_actions -->
			</table>
		</th>
	</tr>
</table>
<!-- END BLOCK : moon -->