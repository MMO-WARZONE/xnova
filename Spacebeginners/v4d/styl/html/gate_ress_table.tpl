<!--

/**
  * gate_ress_table.tpl
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2010
  * @Team Space Beginner
  *
  **/

-->
<html>
<head>
<meta name="generator" content="HTML Tidy for Linux (vers 6 November 2007), see www.w3.org">
<title></title>

<style type="text/css">
 td.c1 {\"background-color:}
</style>
</head>
<body>
<br>
{gate_time_script}
<form action="ressgate.php" method="post">
<table border="1">
<tbody>
<tr>
<th>{gate_start_moon}</th>
<th>{gate_start_link}</th>
</tr><tr>
	<th>{gate_dest_moon}</th>
	<th>
		<select name="jmpto">
		{gate_dest_moons}
		</select>
	</th>
</tr>
</tbody>
</table>
{gate_script_go}
<table border="0" cellpadding="0" cellspacing="0" width="259">
<tbody>
<tr>
<td colspan="3" class="c">Rohstoffe</td>
</tr>
<tr>
<th>Metall</th>
<th><input name="res1" alt="0" size="10" type="text" value="0"></th>
</tr>
<tr>
<th>Kristall</th>
<th><input name="res2" alt="0" size="10" type="text" value="0"></th>
</tr>
<tr>
<th>Deuterium</th>
<th><input name="res3" alt="0" size="10" type="text" value="0"></th>
</tr>
<tr>
<th>Appolonium</th>
<th><input name="res4" alt="0" size="10" type="text" value="0"></th>
</tr>
<tr>
<th colspan="3"><input value="{gate_jump_btn}" type="submit"></th>
</tr>
</tbody>
</table>
<table width="519">
<tbody>
<tr>
<td class="c" colspan="2">{gate_use_gate}</td>
</tr>
<tr>
<th class="l" colspan="2" align="right">
<table width="100%">
<tbody>
<tr>
<td class="c1" align="right">{gate_wait_time}</td>
</tr>
</tbody>
</table>
</th>
</tr>
</tbody>
</table>
</form>
</body>
</html>
