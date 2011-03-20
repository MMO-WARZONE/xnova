<script src="scripts/cntchar.js" type="text/javascript"></script>
<form action="" method="POST">
  <!-- START BLOCK : form -->
  {inputs}
  <table width="519">
    <tr>
      <td class="c" colspan="2">{TITLE}</td>
    </tr>
    <tr>
      <th>{nt_priority}</th>
      <th><select name="u">{c_Options}</select></th>
    </tr>
    <tr>
      <th>{nt_subject_note}</th>
      <th><input type="text" name="title" size="30" maxlength="30" value="{asunto}" /></th>
    </tr>
    <tr>
      <th>{nt_note} (<span id="cntChars">0</span> / 5000 {nt_characters})</th>
      <th>
        <textarea name="text" cols="60" rows="10" onkeyup="javascript:cntchar(5000)">{texto}</textarea>
      </th>
    </tr>
    <tr>
      <td class="c"><a href="game.php?page=notes">{nt_back}</a></td>
      <td class="c"><input type="reset" value="{nt_reset}" /> <input type="submit" value="{nt_save}" /></td>
    </tr>
  </table>
  <!-- END BLOCK : form -->
  <!-- START BLOCK : notes -->
  <table width="519">
    <tr>
      <td class="c" colspan="4">{nt_notes}</td>
    </tr>
    <tr>
      <th colspan="4"><a href="game.php?page=notes&a=1">{nt_create_new_note}</a></th>
    </tr>
    <tr>
	      <td class="c">&nbsp;</td>
	      <td class="c">{nt_date_note}</td>
	      <td class="c">{nt_subject_note}</td>
	      <td class="c">{nt_size_note}</td>
    </tr>
	<!-- START BLOCK : listnotes -->
    <tr>
		<th width="20"><input name="delmes{NOTE_ID}" value="y" type="checkbox" /></th>
		<th width="150">{NOTE_TIME}</th>
		<th><a href="game.php?page=notes&a=2&amp;n={NOTE_ID}"><font color="{NOTE_COLOR}">{NOTE_TITLE}</font></a></th>
		<th align="right" width="40">{NOTE_TEXT}</th>
	</tr>
	<!-- END BLOCK : listnotes -->
	<!-- START BLOCK : error -->
	<tr>
		<th colspan="4">{nt_you_dont_have_notes}</th>
	</tr>
	<!-- END BLOCK : error -->
	<tr>
            <td colspan="4" align="center" class="anything"><input value="{nt_dlte_note}" type="submit"></td>
    </tr>
  </table>
  <!-- END BLOCK : notes -->
</form>


  


