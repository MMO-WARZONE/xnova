<script type="text/javascript">
var galaxy = window
var ns4up = (document.layers) ? 1 : 0
var ie4up = (document.all) ? 1 : 0
var xsize = screen.width
var ysize = screen.height
var breite=720
var hoehe=260
var xpos=(xsize-breite)/2
var ypos=(ysize-hoehe)/2
function f(target_url, win_name) {
var new_win = window.open(target_url, win_name, "scrollbars=no,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width="+breite+",height="+hoehe+",screenX="+xpos+",screenY="+ypos+",top="+ypos+",left="+xpos);
new_win.focus();
}
</script>
</head>
<body onLoad="count()" onUnload="var then,now; then=new Date().getTime();now=then;while((now-then)<200){now=new Date().getTime();}">
	<div class="style">
		<center>
			<div id='boxleft'>
			<br>
				<table width="170" cellspacing="0" cellpadding="0">
					<tr>
						<td colspan="2" style="border-top: 1px #545454 solid">
							<div>
								<center>{servername}<br>
									<a href="?action=ShowChangelog" class="nobr">(<font color=red>{XNovaRelease}</font>)</a>
								</center>
							</div>
						</td>
					</tr>
					<tr>
						<td class="td_leftmenu" height="19" colspan="2"><center>{tag} {date} - <span id="time"></span></center></td>
					</tr>
							<tr>
								<th colspan="2">{user_username}</th>
							</tr>
							<tr>
								<th rowspan=4 width="72" height="70"><img src="{avatar}" width="70" height="70" alt="{user_username}"></th>
								<td>{a_zone} {user_az}</td>
							</tr>
							<tr>
								<td>{ally} {ally_tag}</td>
							</tr>
							<tr>
								<td>{u_id} {user_id}</td>
							</tr>
							<tr>
								<td>{rang} {user_rang}</td>
							</tr>
							<tr>
								<td class="td_bg_center" width="72">&nbsp;</td>
								<td class="td_bg_center" width="98">{points}</td>       
							</tr>
							<tr>
								<td width="72">&nbsp;{building}</td>
								<td align="right" width="98">{user_builds}</td>
							</tr>
							<tr>
								<td width="72">&nbsp;{research}</td>
								<td align="right" width="98">{user_tech}</td>
							</tr>
							<tr>
								<td width="72">&nbsp;{fleet}</td>
								<td align="right" width="98">{user_fleet}</td>
							 </tr>
							<tr>
								<td width="72">&nbsp;{Defense}</td>
								<td align="right" width="98">{user_def}</td>
							</tr>
							<tr>
								<td width="72">&nbsp;<b>{gesammt}</b></td>
								<td align="right" width="98"><b>{total_points}</b></td>
							</tr>
					<tr>
						<td class="td_leftmenu" colspan="2"><center>
						  {menu1}
						</center></td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
								<a href="?action=internalHome" target="_self">{Overview}</a>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
								<a href="?action=internalBuildings" target="_self">{Buildings}</a>
							</div>
						</td>
					</tr><tr>
						<td colspan="2">
							<div>
								<a href="?action=internalResources" target="_self">{Resources}</a>
							</div>
						</td>
					</tr><tr>
						<td colspan="2">
							<div>
								<a href="?action=internalImperium" target="_self">{Imperium}</a>
							</div>
						</td>
					</tr>
                    
					<tr>
						<td colspan="2">
							<div>
								<a href="?action=internalBuildings&amp;mode=research" target="_self">{Research}</a>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
								<a href="?action=internalBuildings&amp;mode=fleet" target="_self">{Shipyard}</a>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
								<a href="?action=internalBuildings&amp;mode=defense" target="_self">{Defense}</a>
							</div>
						</td>
					</tr>
					<tr>
						<td class="td_leftmenu"colspan="2"><center>
						  {menu2}
						</center></td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
								<a href="?action=internalFleet" target="_self">{Fleet}</a>
							</div>
						</td>
					</tr>
                    <tr>
						<td colspan="2">
							<div>
								<a href="?action=internalGalaxy&amp;mode=0" target="_self">{Galaxy}</a>
							</div>
						</td>
					</tr>
					<tr>
						<td class="td_leftmenu" colspan="2"><center>
						  {menu3}
						</center></td>
					</tr>
                    <tr>
						<td colspan="2">
							<div>
								<a href="?action=internalAlliance" target="_self">{Alliance}</a>
							</div>
						</td>
					</tr>
					
                    <tr>
						<td colspan="2">
							<div>
								<a href="?action=internalMessages" target="_self">{Messages}</a>
							</div>
						</td>
					</tr>
                    <tr>
						<td colspan="2">
							<div>
								<a href="#" onClick="f('?action=internalNotes', 'Report');">{Notes}</a>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
								<a href="{forum_url}" target="_self">{Board}</a>
							</div>
						</td>
					</tr>
					<tr>
						<td class="td_leftmenu" colspan="2"><center>
						  {menu4}
						</center></td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
								<a href="?action=internalStats&amp;start={user_rank}" target="_self">{Statistics}</a>
							</div>
						</td>
					</tr>
                    <tr>
						<td colspan="2">
							<div>
								<a href="?action=internalRecords" target="_self">{Records}</a>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
								<a href="?action=internalTechtree" target="_self">{Technology}</a>
							</div>
						</td>
					</tr>
                    <tr>
						<td colspan="2">
							<div>
								<a href="?action=internalOfficiers" target="_self">{Officiers}</a>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
								<a href="?action=internalSearch" target="_self">{Search}</a>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
								<a href="?action=internalContact" target="_self" >{Contact}</a>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
								<a href="?action=internalOptions" target="_self">{Options}</a>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
								<a href="javascript:top.location.href='?action=logout'" style="color:red">{Logout}</a>
							</div>
						</td>
					</tr>
						{ADMIN_LINK}
					<tr>
						<td colspan="2">
							<div>
								<center>
									<a href="?action=credits" >XNova Reloaded</a> &copy; 2009
								</center>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</center>
	</div>