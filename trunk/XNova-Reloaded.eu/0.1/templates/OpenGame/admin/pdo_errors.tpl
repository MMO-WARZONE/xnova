<br><br>
<center>
<h2>{title}</h2>
<script type="text/javascript">
var ns4up = (document.layers) ? 1 : 0
var ie4up = (document.all) ? 1 : 0
var xsize = screen.width
var ysize = screen.height
var breite=800
var hoehe=500
var xpos=(xsize-breite)/2
var ypos=(ysize-hoehe)/2
function f(target_url, win_name) {
var new_win = window.open(target_url, win_name, "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width="+breite+",height="+hoehe+",screenX="+xpos+",screenY="+ypos+",top="+ypos+",left="+xpos);
new_win.focus();
}
</script>

<table width="700">
<tr>
<td class="c" colspan="4">{error_files}</td>
</tr>
<tr>
<th width="33%">{from}</th>
<th width="33%">{open}</th>
<th width="33%">{delete}</th>
</tr>
{errors_list}
</table>
</center>