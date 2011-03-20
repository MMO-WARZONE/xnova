{header_tpl}

<div id="zwei" style="display:block;">
	<div class="section">
		<h3>
			<a id="link21" class="closed" href="javascript:void(0);" onclick="ReverseDisplay('section21'); SwapClass('link21','opened','closed');">
				<span>Manage Members</span>
			</a>
		</h3>
	</div>
	<div class="sectioncontent" id="section21"  style="display:none;">
		<div class="contentz" id="rank_contentz">
			<!--<a href="#" class="makeNewRank smallLink" onclick="ReverseDisplay('newRank');">create new rank</a>-->
			<br class="clearfloat" />
			<form action="./?page=network&mode=admin&change=ranks" method="get" id="ranks_form">
			<table cellpadding="0" cellspacing="0" id="ranks" class="sortable">
				<tr>
					<th>Player Name</th>
					<th style="font-weight:700;">Rank name</th>
					<th><img class="tips" title="Disband alliance" src="{{skin}}/img/icons/alliance/allianz_aufloesen.gif" /></th>
					<th><img class="tips" title="Kick user" src="{{skin}}/img/icons/alliance/user_kicken.gif" /></th>
					<th><img class="tips" title="Show applications" src="{{skin}}/img/icons/alliance/bewerber_ansehen.gif" /></th>
					<th><img class="tips" title="Process applications" src="{{skin}}/img/icons/alliance/bewerber_bearbeiten.gif" /></th>
					<th><img class="tips" title="Show member list" src="{{skin}}/img/icons/alliance/memberliste_sehen.gif" /></th>
					<th><img class="tips" title="Show online status in member list" src="{{skin}}/img/icons/alliance/memberliste_onlinestatus.gif" /></th>
					<th><img class="tips" title="Manage Alliance" src="{{skin}}/img/icons/alliance/allianz_verwalten.gif" /></th>
					<th><img class="tips" title="Write circular message" src="{{skin}}/img/icons/alliance/rundmail.gif" /></th>
					<th><img class="tips" title="`Right Hand` (necessary to transfer founder rank)" src="{{skin}}/img/icons/alliance/rechte_hand.gif" /></th>
				</tr>
{ranks}
				<tr>
					<td colspan="11"><input type="button" class="buttonSave" name="test" value="{save}" onclick="submitform('ranks_form','{Alliance}','network'); document.getElementById('rank_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;"></td>
				</tr>
			</table>
			</form>
			<div class="h10"></div>
		</div><!--contentdiv -->
		<div class="footer"></div>
	</div><!-- section1 -->


	<div class="section">
		<h3><a id="link23" class="closed" href="javascript:void(0);" onclick="ReverseDisplay('section23'); SwapClass('link23','opened','closed');">
			<span>Alliance Texts</span></a>
		</h3>
	</div>
	<div class="sectioncontent" id="section23" style="display:none;">
		<div class="contentz" id="texts_contentz">
			<ul class="subsection_tabs" id="tabs_example_one">
				<li><a onclick="ShowContent('one');HideContent('two');HideContent('three');" id="tabIntern"><span>Internal text</span></a></li>
				<li><a onclick="HideContent('one');ShowContent('two');HideContent('three');" id="tabExtern"><span>External text</span></a></li>
				<li><a onclick="HideContent('one');HideContent('two');ShowContent('three');" id="tabBewerb"><span>Application text</span></a></li>
			</ul>

			<form action="./?page=network&mode=admin&change=texts" method="post" id="texts_form">
				<div id="one">
					<textarea name="ally_internal" class="alliancetexts">{internal}</textarea>
				</div><!-- One -->

				<div id="two" style="display:none;">
					<textarea name="ally_external" class="alliancetexts">{external}</textarea>
					<a href="./?page=ainfo&allyid={id}" target="_blank" class="smallLink preview">Open alliance page</a>
				</div><!-- Two -->

				<div id="three" style="display:none;">
					<textarea name="ally_request" class="alliancetexts">{request}</textarea>
				</div><!-- Three -->
				
				<input type="button" class="buttonSave" name="test" value="{save}" onclick="submitform('texts_form','{Alliance}','network'); document.getElementById('texts_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;">
			</form>

			<div class="h10"></div>
		</div><!--contenz -->

		<div class="footer"></div>
	</div><!-- #section3 -->

	<div class="section">
		<h3>
			<a id="link24" class="closed" href="javascript:void(0);" onclick="ReverseDisplay('section24'); SwapClass('link24','opened','closed');">
				<span>Options</span>
			</a>
		</h3>
	</div>
	<form action="./?page=network&mode=admin&change=basic" method="get" id="basics_form">
	<div class="sectioncontent" id="section24" style="display:none;">
		<div class="contentz allyprefs" id="basics_contentz">
			<table id="preferences" cellspacing="2" cellpadding="2">
				<tr>
					<td>Homepage</td>
					<td><input type="text" class="textInput" size="70" value="{www}" name="homepage"/></td>
				</tr>
				<tr>
					<td>Alliance logo</td>
					<td><input type="text" class="textInput" size="70" value="{image}" name="logo"/></td>
				</tr>
				<tr>
					<td>Applications</td>
					<td>
						<select class="dropdown w300" name="ally_closed">
							<option value="0">Possible (alliance open)</option>
							<option value="1">Impossible (alliance closed)</option>
						</select>
					</td>
				 </tr>
				 <tr>
				 	<td>Founder</td>
					<td><input type="text" class="textInput" size="30" value="{foundername}" name="foundername"/></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="button" class="buttonSave" value="{save}" onclick="submitform('basics_form','{Alliance}','network'); document.getElementById('basics_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" />
					</td>
				</tr>
			</table>
			<div class="h10"></div>
		</div><!--contentdiv -->
		<div class="footer"></div>
	</div><!-- section4 -->
	</form>

	<div class="section">
		<h3>
			<a id="link25" class="closed" href="javascript:void(0);" onclick="ReverseDisplay('section25'); SwapClass('link25','opened','closed');">
				<span>Change alliance tag/name</span>
			</a>
		</h3>
	</div>
	<div class="sectioncontent" id="section25" style="display:none;">
		<div class="contentz allyTagChange" id="tag_name_contentz">
			<ul class="subsection_tabs" id="tabs_example_one">
				<li><a onclick="ShowContent('oneAlly');HideContent('twoAlly');" id="tabIntern"><span>Change alliance tag</span></a></li>
				<li><a onclick="HideContent('oneAlly');ShowContent('twoAlly');" id="tabExtern"><span>Change alliance name</span></a></li>
			</ul>

			<form action="./?page=network&mode=admin&change=tag" method="get" id="tag_name_form">
				<div id="oneAlly">
					<table id="changeAllyTag" class="bborder" cellpadding="5">
						<tr>
							<td width="50%" class="textRight">Former alliance tag:</td>
							<td class="value">[{tag}]</td>
						</tr>
						<tr>
							<td class="textRight">New alliance tag:</td>

							<td class="value"><input type="text" class="textInput" maxlength="8" name="newtag"/></td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="button" class="buttonSave" value="{continue}" onclick="submitform('tag_name_form','{Alliance}','network'); document.getElementById('tag_name_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" />
							</td>
						</tr>
					</table>
				</div>

				<div id="twoAlly" style="display:none;">
					<table id="changeAllyName" class="bborder">
						<tr>
							<td width="50%" class="textRight">Former alliance name:</td>
							<td class="value">{name}</td>
						</tr>
						<tr>
							<td class="textRight">New alliance name:</td>

							<td class="value"><input type="text" class="textInput w250" maxlength="30" name="newname"/></td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="button" class="buttonSave" value="{continue}" onclick="submitform('tag_name_form','{Alliance}','network'); document.getElementById('tag_name_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" />
							</td>
						</tr>
					</table>
				</div>
			</form>

			<div class="h10"></div>
		</div><!--contentdiv -->

		<div class="footer"></div>
	</div><!-- section5 -->

	<div class="section" {stop_delete}>
		<h3>
			<a id="link26" class="closed" href="javascript:void(0);" onclick="ReverseDisplay('section26'); SwapClass('link26','opened','closed');">
				<span>Delete alliance/Pass alliance on</span>
			</a>
		</h3>
	</div>
	<div class="sectioncontent" id="section26" style="display:none;">
		<div class="contentz quitAlly" id="end_contentz">
			<ul class="subsection_tabs" id="tabs_example_one">
				{del_link}
				{hand_link}
			</ul>
			<div id="oneAllyQuit" style="display:none;">
				<form action="./?page=network&mode=admin&change=delete" method="get" id="delete_form">
					<table id="dissolveally" class="bborder">
						<tr>
							<th class="textCenter">Delete this alliance?</th>
						</tr>
						<tr>
							<th class="textCenter">
								<input type="password" name="confirm" value="" /><br />
								Confirm alliance deletion by entering password.
							</th>
						</tr>
						<tr>
							<td class="textCenter">
								<input class="buttonSave" type="button" value="{continue}" onclick="submitform('delete_form','{Alliance}','network'); document.getElementById('end_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" />
							</td>
						</tr>
					</table>
				</form>
				<div class="h10"></div>
			</div>

			<div id="twoAllyQuit" style="display:none;">
				<form action="./?page=network&mode=admin&change=newleader" method="get" id="pass_on_form">
					<table id="assignally" class="bborder">
						<tr>
							<th class="textCenter">Pass on/take over this alliance?</th>
						</tr>
						<tr>
							<th class="textCenter">
								Next leader: {next_list}
							</th>
						</tr>
						<tr>
							<td class="textCenter">
								<input class="buttonSave" type="button" value="{continue}" onclick="submitform('pass_on_form','{Alliance}','network'); document.getElementById('end_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" />
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div class="h10"></div>
		</div><!--contentdiv -->
		<div class="footer"></div>
	</div><!-- section6 -->
</div><!-- zwei -->
</div><!-- Inhalt -->
</div><!-- allianz -->
</div><!-- netz -->
<!-- END CONTENT AREA -->