<script language="JavaScript" type="text/javascript" src="scripts/chat.js"></script>

<br><br>

<table align="center"><tbody>

<tr><td class="c"><b>{chat_disc}</b></td></tr>

<tr><th><div id="shoutbox" style="margin: 5px; vertical-align: text-top; height: 305px; overflow:hidden;"></div></th></tr>

<tr><th>{chat_message}: <input name="msg" type="text" id="msg" size="80" maxlength="100" onKeyPress="if(event.keyCode == 13){ addMessage(); } if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"> <input type="button" name="send" value="{chat_send}" id="send" onClick="addMessage()"></th></tr>

</tbody></table>

<br>
<table width="355" align="center"><tbody>

<tr><td colspan="2" class="c"><b>{chat_short}</b></td></tr>

<tr><th colspan="2"><img src="images/smileys/lol.gif" align="absmiddle" title=":D" alt=":D" width="25" height="20" onClick="addSmiley(':D')">
		    <img src="images/smileys/confused.gif" align="absmiddle" title=":/" alt=":/" width="20" height="20" onClick="addSmiley(':/')">
		    <img src="images/smileys/dizzy.gif" align="absmiddle" title="o0" alt="o0" width="16" height="16" onClick="addSmiley('o0')">
		    <img src="images/smileys/happy.gif" align="absmiddle" title="^^" alt="^^" width="30" height="30" onClick="addSmiley('^^')">
			<img src="images/smileys/cry.gif" align="absmiddle" title=":c" alt=":c" width="25" height="20" onClick="addSmiley(':c')">
		    <img src="images/smileys/neutral.gif" align="absmiddle" title=":|" alt=":|" width="16" height="16" onClick="addSmiley(':|')">
		    <img src="images/smileys/smile.gif" align="absmiddle" title=":)" alt=":)" width="15" height="20" onClick="addSmiley(':)')">
		    <img src="images/smileys/omg.gif" align="absmiddle" title=":o" alt=":o" width="22" height="22" onClick="addSmiley(':o')">
		    <img src="images/smileys/tongue.gif" align="absmiddle" title=":p" alt=":p" width="24" height="24" onClick="addSmiley(':p')">
		    <img src="images/smileys/sad.gif" align="absmiddle" title=":(" alt=":(" width="20" height="20" onClick="addSmiley(':(')">
		    <img src="images/smileys/wink.gif" align="absmiddle" title=";)" alt=";)" width="18" height="20" onClick="addSmiley(';)')">
			<img src="images/smileys/dance.gif" align="absmiddle" title=":T" alt=":T" width="25" height="22" onClick="addSmiley(':T')">
		    <img src="images/smileys/shit.gif" align="absmiddle" title=":s" alt=":s" width="25" height="20" onClick="addSmiley(':s')"></th></tr>

<tr><th width="60"><b>{chat_text}</b><br><i>{chat_text}</i><br><u>{chat_text}</u><br><a href="http://www.site.com" target="_blank">{chat_text}</a><br><font color="red">{chat_text}</font></th>

<th>[b]{chat_text}[/b]<br>[i]{chat_text}[/i]<br>[u]{chat_text}[/u]<br>[a=http://www.site.com]{chat_text}[/a]<br>[c=blue|yellow|green|pink|red|orange]{chat_text}[/c]</th></tr>

</tbody></table>