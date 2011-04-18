<center>
<br>
{buildinglist}
<script type="text/javascript">
function setL(id)
{
	if(document.getElementsByName("fmenge["+id+"]")[0].value >= 1)
	document.getElementsByName("fmenge["+id+"]")[0].value = Math.floor(document.getElementsByName("fmenge["+id+"]")[0].value) - 1;
}
function setN(id)
{
	if(document.getElementsByName("fmenge["+id+"]")[0].value <= 998)
	document.getElementsByName("fmenge["+id+"]")[0].value = Math.floor(document.getElementsByName("fmenge["+id+"]")[0].value) + 1;
}
function setMax(id, max)
{
	document.getElementsByName("fmenge["+id+"]")[0].value = max;
}
  </script>
<table align="center">
<tr>
	<td>
		<form action="?action=internalBuildings&amp;mode=fleet" method="post" name="Schiffe">
		<table width=700>
		{buildlist}
		<tr>
			<td class="c" colspan=3 align="center"><input type="submit" value="{Construire}"></td>
		</tr>
		</table>
		</form>
	</td>
	  <td valign="top"></td>
	</tr>
</table>

</center>