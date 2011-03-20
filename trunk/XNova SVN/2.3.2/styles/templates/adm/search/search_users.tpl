<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tr>
     <td class="c" colspan="2"><center><h2>{ad_edit_users}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="admin.php?page=editor&search=researchs&id={id}">{ad_researchs}</option>
     <option value="admin.php?page=editor&search=oficers&id={id}">{ad_oficers}</option>
     <option selected value="admin.php?page=editor&search=users&id={id}">{ad_users}</option>
     </select></th>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" align="center">{ad_acction}</td>
	<td class="c" align="center">{ad_value}</td>
	<td class="c" align="center">{ad_value}</td>
</tr><tr>
	<th>{ad_username}</th>
	<th>{username}</th>
	<th><input name="username"  size="19" type="text"/></th>
</tr><tr>
        <th>{ad_userpass}</th>
        <th>{password}</th>
	<th><input name="password"  size="19" type="password"/></th>
</tr><tr>
	<th>{ad_useremail}</th>
	<th>{email}</th>
	<th><input name="email"  size="19" type="text"/></th>
</tr><tr>
	<th>{ad_useremail2}</th>
	<th>{email2}</th>
	<th><input name="email2"  size="19" type="text"/></th>
</tr><tr>
	<th>{ad_activate}</th>
	<th>{activate}</th>
		<th colspan="4">
		<select name="activate">
			<option value="">{ad_sel_op}</option>
			<option value="yes">{ad_yesactivate}</option>
			<option value="no">{ad_noactivate}</option>
		</select>
	</th>
</tr><tr>
	<th>{ad_dpath}</th>
	<th>{dpath}</th>
	<th><input name="dpath"  size="19" type="text"/></th>
</tr><tr>
	<th>{ad_design}</th>
	<th>{design}</th>
		<th colspan="4">
		<select name="design">
			<option value="">{ad_sel_op}</option>
			<option value="yes">{ad_yes}</option>
			<option value="no">{ad_no}</option>
		</select>
	</th>
</tr><tr>
	<th>{ad_noipcheck}</th>
	<th>{noipcheck}</th>
		<th colspan="4">
		<select name="noipcheck">
			<option value="">{ad_sel_op}</option>
			<option value="yes">{ad_yes}</option>
			<option value="no">{ad_no}</option>
		</select>
	</th>
</tr><tr>
	<th>{ad_userlevel}</th>
	<th>{authlevel_s}</th>
	<th>
		<select name="authlevel">
			<option value="">{ad_sel_op}</option>
			<option value="0" {level_0}>{ad_level_player}</option>
			<option value="1" {level_1}>{ad_level_mod}</option>
			<option value="2" {level_2}>{ad_level_op}</option>
			<option value="3" {level_3}>{ad_level_adm}</option>
		</select>
	</th>
</tr><tr>
	<th>{ad_uservac}</th>
	<th>{vacations}</th>
	<th>
		<select name="vacations">
			<option value="">{ad_sel_op}</option>
			<option value="yes">{ad_yesactivate}</option>
			<option value="no">{ad_noactivate}</option>
		</select>
	</th>
</tr><tr>
	<th>{ad_duration}</th>
	<th>{duration}</th>
        <th>{ad_days}  <input name="d" type="text" size="2" maxlength="2"/>  {ad_hours}  <input name="h" type="text" size="2"  maxlength="2"/></th>
</tr><tr>
	<th colspan="3"><input type="Submit" value="{ad_save}"/></th>
</tr>
</table>
</form>