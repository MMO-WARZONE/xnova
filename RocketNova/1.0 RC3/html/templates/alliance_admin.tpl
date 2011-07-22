<script src="scripts/cntchar.js" type="text/javascript"></script>
<br />
<table width=530>
	<tr>
	  <td class="c" colspan="2"><font color=yellow><center>{Alliance_admin}</center></font></td>
	</tr><tr>
	  <th><a href="?mode=admin&edit=rights">{Law_settings}</a></th>
	  <th><a href="?mode=admin&edit=members">{Members_administrate}</a></th>
	</tr><tr>
	  <th><a href="?mode=admin&edit=tag">{Change_the_ally_tag}</a></th>
	  <th><a href="?mode=admin&edit=name">{Change_the_ally_name}</a></th>
	</tr><tr>
	  <th><a href="alliance_diplo.php"><font color="#b0c4de">Allianz-Diplomatie</font></a></th>
	  <th colspan=2><b><a href="wing.php"><font color="#b0c4de">Allianz Wing</font></a></b></th>
	</tr>
</table>
<br />
<form action="" method="POST">
<input type="hidden" name="t" value="{t}">
<table width=530>
	<tr>
	  <td class="c" colspan="3"><font color="yellow"><center>{Options}</center></font></td>
	</tr>
	<tr>
	  <th>{Alliance_logo}</th>
	  <th><input type=text name="image" value="{ally_image}" size="70"></th>
	</tr>
	<tr>
	  <th>{Main_Page}</th>
	  <th><input type=text name="web" value="{ally_web}" size="70"></th>
	</tr>
	<tr>
	  <th>{Founder_name}</th>
	  <th><input type="text" name="owner_range" value="{ally_owner_range}" size=30></th>
	</tr>
	<tr>
	  <th>{Requests}</th>
	  <th>
	  <select name="request_notallow"><option value=1{ally_request_notallow_0}>Bewerbungen nicht erlauben</option>
	  <option value=0{ally_request_notallow_1}>Bewerbungen erlauben</option></select>
	  </th>
	</tr>
	<tr>
	  <th colspan="3"><input type="submit" name="options" value="{Save}"></th>
	</tr>
</table>
</form>

<br />

<form action="" method="POST">
<table width=530>
	<tr>
	  <th><a href="?mode=admin&edit=ally&t=1"><font color=orange>{External_text}</font></a></th>
	  <th><a href="?mode=admin&edit=ally&t=2"><font color=orange>{Internal_text}</font></a></th>
      <th><a href="?mode=admin&edit=ally&t=3"><font color=orange>{Request_text}</font></a></th>
	</tr>
	<tr>
	  <td class="c" colspan="3"><center>{Show_of_request_text} (<span id="cntChars">0</span> / 5000 {characters})</center></td>
	</tr>
	<tr>
	  <th colspan="3"><textarea name="text" cols="70" rows="15" onkeyup="javascript:cntchar(5000)">{text}</textarea>
{request_type}
	</th>
	<tr>
	  <th colspan="3">
	  <input type="hidden" name=t value={t}><input type="reset" value="{Reset}"> 
	  <input type="submit" value="{Save}">
	  </th>
	</tr>
	<tr>
	  <td class="c" colspan="3"><center><a href="alliance.php">{Return_to_overview}</a></center></td>
	</tr>
</table>
</form>
<br />
{Transfer_alliance}
<br />
{Disolve_alliance}