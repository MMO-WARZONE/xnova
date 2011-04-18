<script src="scripts/cntchar.js" type="text/javascript"></script>
<br>
<center>
<table width="700">
	<tr>
	  <td class="c" colspan="2" height="21">{Alliance_admin}</td>
	</tr>
	<tr>
	  <th colspan=2><a href="?action=internalAlliance&amp;mode=admin&amp;edit=rights">{Law_settings}</a></th>
	</tr>
	<tr>
	  <th colspan=2><a href="?action=internalAlliance&amp;mode=admin&amp;edit=members">{Members_administrate}</a></th>
	</tr>
	<tr>
	  <th colspan=2><a href="?action=internalAlliance&amp;mode=admin&amp;edit=tag">{Change_the_ally_tag}</a></th>
	</tr>
	<!--<img src="{dpath}pic/appwiz.gif" border=0 alt="">-->
	<tr>
	  <th colspan=2><a href="?action=internalAlliance&amp;mode=admin&amp;edit=name">{Change_the_ally_name}</a></th>
	</tr>
	<!--<img src="{dpath}pic/appwiz.gif" border=0 alt="">-->
</table>
</center>
<br>
<form action="" method="POST">
<input type="hidden" name="t" value="{t}">
<center>
<table width="700">
	<tr>
	  <td class="c" colspan="3" height="21">{Texts}</td>
	</tr>
	<tr>
	  <th><a href="?action=internalAlliance&amp;mode=admin&amp;edit=ally&amp;t=1">{External_text}</a></th>
	  <th><a href="?action=internalAlliance&amp;mode=admin&amp;edit=ally&amp;t=2">{Internal_text}</a></th>
	  <th><a href="?action=internalAlliance&amp;mode=admin&amp;edit=ally&amp;t=3">{Request_text}</a></th>
	</tr>
	<tr>
	  <td class="c" colspan="3" height="21">{Show_of_request_text} (<span id="cntChars">0</span> / 5000 {characters})</td>
	</tr>
	<tr>
	  <th colspan=3><textarea name="text" cols=70 rows=15 onkeyup="javascript:cntchar(5000)">{text}</textarea>
{request_type}
	</th>
	</tr>
	<tr>
	  <th colspan=3>
	  <input type="hidden" name=t value={t}><input type="reset" value="{Reset}"> 
	  <input type="submit" value="{Save}">
	  </th>
	</tr>
</table>
</center>
</form>

<br>

<form action="" method="POST">
<center>
<table width="700">
	<tr>
	  <td class="c" colspan="2" height="21">{Options}</td>
	</tr>
	<tr>
	  <th>{Main_Page}</th>
	  <th><input type=text name="web" value="{ally_web}" size="70"></th>
	</tr>
	<tr>
	  <th>{Alliance_logo}</th>
	  <th><input type=text name="image" value="{ally_image}" size="70"></th>
	</tr>
	<tr>
	  <th>{Requests}</th>
	  <th>
	  <select name="request_notallow"><option value=1{ally_request_notallow_0}>{No_allow_request}</option>
	  <option value=0{ally_request_notallow_1}>{Allow_request}</option></select>
	  </th>
	</tr>
	<tr>
	  <th>{Founder_name}</th>
	  <th><input type="text" name="owner_range" value="{ally_owner_range}" size=30></th>
	</tr>
	<tr>
	  <th colspan=2><input type="submit" name="options" value="{Save}"></th>
	</tr>
</table>
</center>
</form>

<br>
{Disolve_alliance}
<br>
{Transfer_alliance}
<br>
<center>
<table width="700">
	<tr>
		<td class="c" colspan="2" height="21"><a href="?action=internalAlliance">Zur&uuml;ck</a></td>
	</tr>
</table>
<br>
</center>
