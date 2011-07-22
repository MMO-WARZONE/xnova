<form action="" method="POST">
	<input type="hidden" name="search" value="step3" />
    <table width="350">
		<tbody>
		<tr>
  			<td class="c" colspan="2">Allianzpakt hinzuf&uuml;gen</td>
		</tr>
		<tr>
 			<td class="b" colspan="2"><center><b>Hier kannst du einen neuen Pakt mit einer Allianz hinzuf&uuml;gen.</b></center></td>
		</tr>
		<tr>
  			<td class="b" colspan="1" width="105"><b>Allianz</b></td>
  			<td class="b" colspan="1" width=105>
    			<select name="ally" size="3" >

 					{allys}
                    
 				</select>
 			</td>
 		</tr>
		<tr>
			<td class="b" colspan="1" width="105"><b>Paktart</b></td>
  			<td class="b" colspan="1">
  
			<select name="pakt" size="3">
				<option selected value="1">Bundniss</option>
                <option selected value="2">Nicht-Angriffs-Pakt</option>
                <option selected value="3">Krieg</option>
			</select>
			</td>
 		 </tr>
  		<tr>
  			<td class="b" colspan="2"><center><input type="submit" value="Absenden" size="20"></center></td>
		</tr>
		<tr>
  			<td class="c" colspan="3">{zurueck}</td>
		</tr>
		</tbody>
	</table>
</form>