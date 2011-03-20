<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Battle Message Compressor</title>
<link rel="stylesheet" type="text/css" href="/css/compactador.css">
<script src="/scripts/crgeneral.js" language="javascript"></script>
<style type="text/css">
<!--
body
{
  color                : #CCEEFF;
  margin-top           : 1px;
  margin-left          : 1px;
  background           : #000000;
  background-image     : url(/images/back2.png);
  background-attachment: fixed;
  background-repeat    : no-repeat;
  background-position  : right;
  scrollbar-arrow-color: #FFFFFF;
  scrollbar-base-color: #344566;
  scrollbar-track-color: #344566;
  scrollbar-face-color: #344566;
  scrollbar-highlight-color: #344566;
  scrollbar-3dlight-color: #465673;
  scrollbar-darkshadow-color: #344566;
  scrollbar-shadow-color: #465673;
  font-size            : 11px;
  font-weight          : normal;
  font-family          : Tahoma,sans-serif;
}
-->
</style></head>
<body style="height: 100%">
<div id="content">
<script src="/scripts/crconverter.js?1955" language="javascript"></script>
<script src="/scripts/crpolish.js?1955" language="javascript"></script>
<script src="/scripts/critalian.js?1955" language="javascript"></script>
<script src="/scripts/crbalkan.js?1955" language="javascript"></script>
<script src="/scripts/crfrench.js?1955" language="javascript"></script>
<script src="/scripts/crturkish.js?1955" language="javascript"></script>
<script src="/scripts/crgerman.js?1955" language="javascript"></script>
<script src="/scripts/crbr.js?1955" language="javascript"></script>
<script src="/scripts/crfixfont.js?1955" language="javascript"></script>
<script src="/scripts/crspanish.js?1955" language="javascript"></script>
<script src="/scripts/crdanish.js?1955" language="javascript"></script>
<script src="/scripts/crcolor.js?1955" language="javascript"></script>

<table style="height: 500px; width: 100%;"><tbody><tr style="height: 500px; width: 100%;"><td style="height: 500px; width: 100%;" id="taka">

<div id="tool">

<div id="message" style="border: 1px ridge white; padding: 5px; visibility: hidden; position: absolute; width: 600px; height: 320px; top: 180px; left: 50px; overflow: auto; background-color: rgb(17, 17, 17);">
<table width="100%">
<tbody><tr>
	<td><b id="note0">PreView</b></td>
	<td align="right"><a href="#tool" onclick="closeMessage()">Close</a></td>
</tr>
</tbody></table>
<hr>
<div id="preview"> </div>
<hr>
<table width="100%">
<tbody><tr>
	<td><b id="note1">PreView</b></td>
	<td align="right"><a href="#tool" onclick="closeMessage()">Close</a></td>
</tr>
</tbody></table>
</div>


<form id="crform">
<table height="100%" width="100%">
<tbody><tr height="5%"><td colspan="2" width="100%">
<table width="100%">
<tbody><tr>
	<td align="center" valign="center" width="100%">
	<h1 style="color: #66ccff;">Battle Message Compressor</h1>	</td>
	</td>
</tr>
</tbody></table>
</td></tr>
<tr height="60%">

<td colspan="2" width="100%">
<table height="100%" width="100%">
<tbody><tr height="100%">
	<td width="50%">
		Copy of the complete battlereport:<br>
		<textarea rows="30" name="report" style="width: 100%; height: 300px;" onfocus="closeMessage()"></textarea>
	</td>
	<td width="50%">
		Compressed battlereport:<br>

		<textarea readonly="readonly" rows="30" name="formatedReport" style="width: 100%; height: 300px;" onfocus="closeMessage()"></textarea>
	</td>
</tr>
</tbody></table>
</td></tr>
<tr height="30%">
<td valign="top">
<table width="100%">
<tbody><tr>
	<td valign="top">
		<nobr><input name="tech" onclick="closeMessage()" type="checkbox"> Show Technologies</nobr><br>
		<nobr><input name="coor" onclick="closeMessage()" type="checkbox"> Show Coordinates</nobr> <br>
		<nobr><input name="center" onclick="closeMessage()" type="checkbox"> Center</nobr><br>
	</td>
	<td valign="top">
		<nobr><input name="column" checked="checked" onclick="columnformatclicked(); closeMessage()" type="checkbox"> Show fleet in column</nobr><br>
		<nobr><input name="attackerName" onclick="closeMessage()" type="checkbox"> Show number of attacker</nobr><br>
		<nobr><input name="defenderName" onclick="closeMessage()" type="checkbox"> Show number of defender</nobr>
	</td>
	<td valign="top">
			<nobr><input name="fixFont" onclick="tableformatclicked(); closeMessage()" type="checkbox"> Show fleets in table format</nobr><br>
			<br>
			<nobr></nobr>	</td>

</tr>
<tr>
	<td colspan="3" width="100%">
	<table width="100%">
	<tbody><tr>
		<td align="right">
			<nobr>Type of Forum:</nobr>		</td>
		<td>
			<select id="forumCombo" class="inp" style="width: 150px;" onchange="changeLang(this.value)" name="forumType">
				<option value="0">phpBB</option>
				<option value="1">Proboard</option>
				<option value="2">SMF</option>
			</select>		</td>
		<td align="right"><nobr>Font Color : </nobr> </td>
		<td><select class="inp" style="width: 150px;" name="background" onchange="setColorPalette(this.value);">
          <option value="1">Dark</option>
          <option value="0" selected="selected">Light</option>
        </select>		</td>
	</tr>
	<tr>
		<td align="right">
			<nobr>Message:</nobr>		</td>
		<td>
			<input class="inp" name="message" style="border: 1px groove ; width: 150px;" value="Language in battlereport..." onclick="closeMessage()" type="text">		</td>
		<td align="right">
			<nobr>Idioma: </nobr>		</td>
		<td>
			<select id="langCombo" class="inp" style="width: 150px;" onchange="changeLang(this.value)" name="language">
				<option value="14">English</option>
			</select>		</td>
	</tr>
	</tbody></table>
	</td>
</tr>

<tr>
	<td colspan="3" valign="bottom">
	<table width="100%">
	<tbody><tr><td height="26">
	    <div align="center">
	      <input class="button" onclick="convert(); closeMessage(); window.location='#tool';" value="Compress" type="button">
	            <input class="button" onclick="preview(); window.location='#tool';" value="PreView" type="button">
	            <input class="button" onclick="save('cookie', 'cr'); window.location='#tool';" value="Save" type="button">
	            <br>
	    </div>
	    </td>

	</tr>
	</tbody></table>
	</td>

</tr><tr>
</tr></tbody></table>
</td>
</tr>
</tbody></table>
</form>

<script language="javascript">
addTTT();
fillColorPalette(document.getElementById('crform').background);
load('cookie', 'cr');
</script>
</div></td></tr></tbody></table>
</p>
</div>
<script language="javascript">
	window.parent.scrollTo(0,0);
</script>
</body>
</html>