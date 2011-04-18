<br>
<form action="?action=internalAlliance&amp;mode=circular&amp;sendmail=1" method="post">
<center>
  <table width="700">
	<tr>
	  <td class="c" colspan=2>{Send_circular_mail}</td>
	</tr>
	<tr>
	  <th>{Destiny}</th>
	  <th>
		<select name="r">
		  {r_list}
		</select>
	  </th>
	</tr>

	<tr>
	  <th>{Text_mail} (<span id="cntChars">0</span> / 5000 {characters})</th>
	  <th>
	    <textarea name="text" cols="60" rows="10" onkeyup="javascript:cntchar(5000)"></textarea>
	  </th>
	</tr>
	<tr>
	  <td class="c"><a href="?action=internalAlliance">{Back}</a></td>
	  <td class="c">
		<input type="reset" value="{Clear}">
		<input type="submit" value="{Send}">
	  </td>
	</tr>
  </table>
</center></form>