<tr>
  <th colspan="2">
<div align="left">
{txt_1}
    <br>
  </p>
</div>
<p align="left">{txt_2}</p>
<fieldset>
<p align="left">{txt_3}</p>
<div align="left">
      <p><strong>{ins_form_server}:</strong></p>
      <p>
        <input type="text" name="host" value="localhost" size="30" />
      </p>
    </div>
  
                		<p align="left">{txt_4}</p>
                		<p align="left">{ins_form_db}:</p>
	<p align="left"> 
	  <input type="text" name="db" value="" size="30" />
    </p>
                	
	</fieldset>
    <p>&nbsp;</p>
    <fieldset>
    {txt_5}
    <div align="left">
      <table width="533" border="1">
        <tr>
          <td><p align="center"><strong>{ins_form_login}:</strong></p>
              <p align="center">
                <input type="text" name="user" value="" size="30" />
            </p></td>
          <td><p align="center"><strong>{ins_form_pass}:</strong></p>
              <p align="center">
                <input type="password" name="passwort" value="" size="30" />
            </p></td>
        </tr>
          </table>
    </div>

    </fieldset>
    <p>&nbsp;</p>
	            <fieldset>
	            {txt_6}
	            <p align="left">{ins_form_prefix}:</p>
	            <p align="left">
	              <input type="text" name="prefix" value="game_" size="30" />
	            </p>
	            </fieldset>            <br>
</th>
</tr>
<tr>
  <th colspan="2"><input type="button" name="next" onclick="submit();" value="{ins_btn_inst}" ></th>
</tr>