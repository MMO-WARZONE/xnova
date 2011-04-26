<script language="JavaScript" type="text/javascript">
var chat_type = "{chat_type}";
var ally_id = "{ally_id}";
</script>
<script language="JavaScript" type="text/javascript" src="scripts/chat.js"></script>

<br><br>

<table align="center" width='77%'>

<tr><td class="c"><b>{chat_disc}</b></td></tr>

<tr><th><div id="shoutbox" style="margin: 5px; vertical-align: text-top; height: 360px; overflow:auto;"></div></th></tr>

<tr><th nowrap> 
{chat_message}: <input name="msg" type="text" id="msg" style="width:80%" maxlength="120" onKeyPress="if(event.keyCode == 13){ addMessage(); } if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"> 
<div nowrap>
&nbsp;&nbsp;
<input type="button" name="send" value="{chat_send}" id="send" onClick="addMessage()">
&nbsp;&nbsp;
&nbsp;&nbsp;
<input type="button" name="send" value="{chat_history}" id="send" onClick="MessageHistory()">
</div>
</th>
<tr><th colspan="2"><p align="left">BB-Codes:</p>
				Schriftfarbe: <select name="color" id="chat_color">
    <option style="color:white;" value="white">weiﬂ</option>
    <option style="color:blue;" value="blue">blau</option>
    <option style="color:yellow;" value="yellow">gelb</option>
    <option style="color:green;" value="green">Gr&uuml;n</option>
    <option style="color:pink;" value="pink">Pink</option>
    <option style="color:red;" value="red">Rot</option>
    <option style="color:orange;" value="orange">Orange</option>
</select>
&nbsp;&nbsp;
				<input type="button" style="font-weight:bold" name="Bold" value="B" onClick="addBBcode('[b] [/b]')" />
				<input type="button" style="font-style:italic;" name="Italic" value="I" onClick="addBBcode('[i] [/i]')" />
				<input type="button" style="text-decoration:underline;" name="underlined" value="U" onClick="addBBcode('[u] [/u]')" />
				<input type="button" name="url" value="URL" onClick="addBBcode('*URL*')" />
                </th></tr>

<tr>
<th nowrap>
<div nowrap>  
<img src="styles/images/smileys/aggressive.gif" align="absmiddle" title=":agr:" alt=":agr:" onClick="addSmiley(':agr:')">
<img src="styles/images/smileys/angel.gif" align="absmiddle" title=":angel:" alt=":angel:" onClick="addSmiley(':angel:')">
<img src="styles/images/smileys/bad.gif" align="absmiddle" title=":bad:" alt=":bad:" onClick="addSmiley(':bad:')">
<img src="styles/images/smileys/blink.gif" align="absmiddle" title="o0" alt="o0" onClick="addSmiley(':blink:')">
<img src="styles/images/smileys/blush.gif" align="absmiddle" title=":blush:" alt=":blush:" onClick="addSmiley(':blush:')">
<img src="styles/images/smileys/bomb.gif" align="absmiddle" title=":bomb:" alt=":blush:" onClick="addSmiley(':bomb:')">
<img src="styles/images/smileys/clapping.gif" align="absmiddle" title=":clap:" alt=":clap:" onClick="addSmiley(':clap:')">
<img src="styles/images/smileys/cool.gif" align="absmiddle" title=":cool:" alt=":cool:" onClick="addSmiley(':cool:')">
<img src="styles/images/smileys/cray.gif" align="absmiddle" title=":c:" alt=":c:" onClick="addSmiley(':c:')">
<img src="styles/images/smileys/crazy.gif" align="absmiddle" title=":crz:" alt=":crz:" onClick="addSmiley(':crz:')">
<img src="styles/images/smileys/diablo.gif" align="absmiddle" title=":diablo:" alt=":diablo:" onClick="addSmiley(':diablo:')">
<img src="styles/images/smileys/dirol.gif" align="absmiddle" title=":cool2:" alt=":cool2:" onClick="addSmiley(':cool2:')">
<img src="styles/images/smileys/fool.gif" align="absmiddle" title=":s:" alt=":s:" onClick="addSmiley(':fool:')">   <br>

<img src="styles/images/smileys/give_rose.gif" align="absmiddle" title=":rose:" alt=":rose:" onClick="addSmiley(':rose:')">
<img src="styles/images/smileys/good.gif" align="absmiddle" title=":good:" alt=":good:" onClick="addSmiley(':good:')">
<img src="styles/images/smileys/huh.gif" align="absmiddle" title=":huh:" alt=":huh:" onClick="addSmiley(':huh:')">
<img src="styles/images/smileys/lol.gif" align="absmiddle" title=":D" alt=":D" onClick="addSmiley(':D:')"> 
<img src="styles/images/smileys/yu.gif" align="absmiddle" title=":yu" alt=":yu" onClick="addSmiley(':yu')">
<img src="styles/images/smileys/unknw.gif" align="absmiddle" title=":unknw:" alt=":unknw:" onClick="addSmiley(':unknw:')">
<img src="styles/images/smileys/sad.gif" align="absmiddle" title=":(" alt=":(" onClick="addSmiley(':sad')">
<img src="styles/images/smileys/smile.gif" align="absmiddle" title=":)" alt=":)" onClick="addSmiley(':smile')">
<img src="styles/images/smileys/shok.gif" align="absmiddle" title=":o" alt=":o" onClick="addSmiley(':shok:')"> 
<img src="styles/images/smileys/rofl.gif" align="absmiddle" title=":rofl" alt=":rofl" onClick="addSmiley(':rofl')">
<img src="styles/images/smileys/blackeye.gif" align="absmiddle" title=":eye" alt=":eye" onClick="addSmiley(':eye')">
<img src="styles/images/smileys/tongue.gif" align="absmiddle" title=":p" alt=":p" onClick="addSmiley(':p')">
<img src="styles/images/smileys/wink.gif" align="absmiddle" title=";)" alt=";)" onClick="addSmiley(';)')">                

<img src="styles/images/smileys/yahoo.gif" align="absmiddle" title=":yahoo:" alt=":yahoo:" onClick="addSmiley(':yahoo:')"> <br>
<img src="styles/images/smileys/mill.gif" align="absmiddle" title=":tratata:" alt=":tratata:" onClick="addSmiley(':tratata:')">
<img src="styles/images/smileys/friends.gif" align="absmiddle" title=":fr:" alt=":fr:" onClick="addSmiley(':fr')">
<img src="styles/images/smileys/drinks.gif" align="absmiddle" title=":dr:" alt=":dr:" onClick="addSmiley(':dr')">
<img src="styles/images/smileys/tease.gif" align="absmiddle" title=":tease:" alt=":tease:" onClick="addSmiley(':tease:')">
</div>
</th>
</tr>

</tr>
</table>