<script src="scripts/cntchar.js" type="text/javascript"></script>

<br />
<center>
  <form action="messages.php?mode=write&id={id}" method="post">
    <table width="519">
      <tr>
        <td class="c" colspan="2">{Send_message}</td>
      </tr>
      <tr>
        <th>{Recipient}</th>
        <th><input type="text" name="to" size="40" value="{to}" /></th>
      </tr>
      <tr>
        <th>{Subject}</th>
        <th><input type="text" name="subject" size="40" maxlength="40" value="{subject}" /></th>
      </tr>
      <tr>
        <th valign="top"> <table width="100%" border="0">
            <tr>
              <td>{Message}(<span id="cntChars">0</span> / 5000 {characters})</td>
            </tr>
            <tr>
              <td height="5"></td>
            </tr>
            <tr>
              <td><table border="0" align="center" cellpadding="2" cellspacing="2">
                  <tr> {smilies_list} </tr>
                </table></td>
            </tr>
          </table></th>
        <th><textarea id="message" name="text" cols="40" rows="10" size="100" onkeyup="javascript:cntchar(5000)">{text}</textarea></th>
      </tr>
      <tr>
        <th colspan="2"><input type="submit" value="{Envoyer}" /></th>
      </tr>
    </table>
  </form>
</center>
