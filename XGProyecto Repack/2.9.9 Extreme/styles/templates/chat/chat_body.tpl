<script type="text/javascript">
var chat_type = "{chat_type}";
var ally_id = "{ally_id}";

</script>
<script language="javascript" type="text/javascript" src="scripts/chat.js"></script>
<script language="javascript" type="text/javascript" src="scripts/jquery.js"></script>
<style type="text/css">


img{ border:0; }

</style>
<br>

<table align="center" width='800'><tbody>

<tr><td class="c"><b>{chat_disc}</b></td><td class="c">Usuarios conectados</td></tr>

<tr><th width="620"><div id="shoutbox" style="margin: 5px; vertical-align: text-top; height: 360px; overflow:auto;"><span style="font-size:30px;">Cargando...</span></div></th><th>
<div style="vertical-align: text-top; height: 360px; overflow:auto;margin:0px;">
<table width="100%" id="connectedUsers">
<tr><th colspan="2">Cargando...</th></tr>
</table>
</div>
</th></tr>

<tr><th colspan="2" nowrap>
{chat_message}: <input name="msg" type="text" id="msg" style="width:80%" maxlength="120" onKeyPress="if(event.keyCode == 13){ addMessage(); } if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"> 
<div nowrap>
&nbsp;&nbsp;
<select name="color" id="chat_color">
    <option value="white" style="color:white;">Blanco</option>
    <option value="blue" style="color:blue;">Azul</option>
    <option value="yellow" style="color:yellow;">Amarillo</option>
	<option value="lime" style="color:lime;">Lima</option>
    <option value="green" style="color:green;">Verde</option>
    <option value="pink" style="color:pink;">Rosa</option>
    <option value="red" style="color:red;">Rojo</option>
    <option value="orange" style="color:orange;">Naranja</option>
</select>
&nbsp;&nbsp;
<input type="button" value="Enviar" id="send" onClick="addMessage();"/>
 a <select name="to" id="chat_to">
    <option value="ALLUSERS">Todos</option>
	<option value="USER">Usuario-&gt;</option>
</select><input type="text" id="to_user" name="to_user" value=""/>
</div>
</th>
<tr><td class="c" colspan="2">Emoticonos</td></tr>
<tr>
<th colspan="2" nowrap>
<div nowrap>  
<img src="images/smileys/aggressive.gif" style="cursor:pointer;" align="absmiddle" title=":agr:" alt=":agr:" onClick="addSmiley(':agr:')">
<img src="images/smileys/angel.gif" style="cursor:pointer;" align="absmiddle" title=":angel:" alt=":angel:" onClick="addSmiley(':angel:')">
<img src="images/smileys/bad.gif" style="cursor:pointer;" align="absmiddle" title=":bad:" alt=":bad:" onClick="addSmiley(':bad:')">
<img src="images/smileys/blink.gif" style="cursor:pointer;" align="absmiddle" title="o0" alt="o0" onClick="addSmiley(':blink:')">
<img src="images/smileys/blush.gif" style="cursor:pointer;" align="absmiddle" title=":blush:" alt=":blush:" onClick="addSmiley(':blush:')">
<img src="images/smileys/bomb.gif" style="cursor:pointer;" align="absmiddle" title=":bomb:" alt=":blush:" onClick="addSmiley(':bomb:')">
<img src="images/smileys/clapping.gif" style="cursor:pointer;" align="absmiddle" title=":clap:" alt=":clap:" onClick="addSmiley(':clap:')">
<img src="images/smileys/cool.gif" style="cursor:pointer;" align="absmiddle" title=":cool:" alt=":cool:" onClick="addSmiley(':cool:')">
<img src="images/smileys/cray.gif" style="cursor:pointer;" align="absmiddle" title=":c:" alt=":c:" onClick="addSmiley(':c:')">
<img src="images/smileys/crazy.gif" style="cursor:pointer;" align="absmiddle" title=":crz:" alt=":crz:" onClick="addSmiley(':crz:')">
<img src="images/smileys/diablo.gif" style="cursor:pointer;" align="absmiddle" title=":diablo:" alt=":diablo:" onClick="addSmiley(':diablo:')">
<img src="images/smileys/dirol.gif" style="cursor:pointer;" align="absmiddle" title=":cool2:" alt=":cool2:" onClick="addSmiley(':cool2:')">
<img src="images/smileys/fool.gif" style="cursor:pointer;" align="absmiddle" title=":s:" alt=":s:" onClick="addSmiley(':fool:')">   <br>

<img src="images/smileys/give_rose.gif" style="cursor:pointer;" align="absmiddle" title=":rose:" alt=":rose:" onClick="addSmiley(':rose:')">
<img src="images/smileys/good.gif" style="cursor:pointer;" align="absmiddle" title=":good:" alt=":good:" onClick="addSmiley(':good:')">
<img src="images/smileys/huh.gif" style="cursor:pointer;" align="absmiddle" title=":huh:" alt=":huh:" onClick="addSmiley(':huh:')">
<img src="images/smileys/lol.gif" style="cursor:pointer;" align="absmiddle" title=":D" alt=":D" onClick="addSmiley(':D:')">
<img src="images/smileys/mellow.gif" style="cursor:pointer;" align="absmiddle" title=":/" alt=":/" onClick="addSmiley(':/')"> 
<img src="images/smileys/yu.gif" style="cursor:pointer;" align="absmiddle" title=":yu" alt=":yu" onClick="addSmiley(':yu')">
<img src="images/smileys/unknw.gif" style="cursor:pointer;" align="absmiddle" title=":unknw:" alt=":unknw:" onClick="addSmiley(':unknw:')">
<img src="images/smileys/sad.gif" style="cursor:pointer;" align="absmiddle" title=":(" alt=":(" onClick="addSmiley(':sad')">
<img src="images/smileys/smile.gif" style="cursor:pointer;" align="absmiddle" title=":)" alt=":)" onClick="addSmiley(':smile')">
<img src="images/smileys/shok.gif" style="cursor:pointer;" align="absmiddle" title=":o" alt=":o" onClick="addSmiley(':shok:')"> 
<img src="images/smileys/rofl.gif" style="cursor:pointer;" align="absmiddle" title=":rofl" alt=":rofl" onClick="addSmiley(':rofl')">
<img src="images/smileys/blackeye.gif" style="cursor:pointer;" align="absmiddle" title=":eye" alt=":eye" onClick="addSmiley(':eye')">
<img src="images/smileys/tongue.gif" style="cursor:pointer;" align="absmiddle" title=":p" alt=":p" onClick="addSmiley(':p')">
<img src="images/smileys/wink.gif" style="cursor:pointer;" align="absmiddle" title=";)" alt=";)" onClick="addSmiley(';)')">                

<img src="images/smileys/yahoo.gif" style="cursor:pointer;" align="absmiddle" title=":yahoo:" alt=":yahoo:" onClick="addSmiley(':yahoo:')"> <br>
<img src="images/smileys/mill.gif" style="cursor:pointer;" align="absmiddle" title=":tratata:" alt=":tratata:" onClick="addSmiley(':tratata:')">
<img src="images/smileys/friends.gif" style="cursor:pointer;" align="absmiddle" title=":fr:" alt=":fr:" onClick="addSmiley(':fr')">
<img src="images/smileys/drinks.gif" style="cursor:pointer;" align="absmiddle" title=":dr:" alt=":dr:" onClick="addSmiley(':dr')">
<img src="images/smileys/tease.gif" style="cursor:pointer;" align="absmiddle" title=":tease:" alt=":tease:" onClick="addSmiley(':tease:')"><br>
</div>
</th>
</tr>

</tr>
</tbody>
</table>