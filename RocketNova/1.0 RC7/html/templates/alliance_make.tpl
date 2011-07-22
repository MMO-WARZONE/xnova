<script type="text/javascript" src="scripts/generate.js"></script>
<style type="text/css">
input.button {
background-color: #0000FF;
font-size: 12px;
font-family: monospace;
font-color: #FFFF00;
font-weight: 100;
}

input.text {
background-color: #FFFFFF;
color: #000000;
}
</style>

<br>
<form action="?mode=make&yes=1" method="POST">

<table width="600">
	<tr>
	  <td class="c" colspan="2"><font color=yellow><center>{make_alliance}</center></font></td>
	</tr>
	<tr>
	  <th>{alliance_tag} (3-8 {characters})</th>
	  <th>{allyance_name} (max. 35 {characters})</th>
	</tr>
	<tr>
	  <th><input type="text" name="atag" size=15 maxlength=8 value="" class="text"></th>
	  <th><input name="aname" size="20" maxlength="20" type="text" class="text" onKeypress="
     if (event.keyCode==60 || event.keyCode==62) event.returnValue = false;
     if (event.which==60 || event.which==62) return false;"> 
	 <input type="button" value="Allianz Name generieren" onClick="aname.value=profundity()" class="button"/></th>
	</tr>
	<tr>
	  <th colspan="2"><center><input type="submit" value="{Make}"></center></th>
	</tr>
</table>

</form>
