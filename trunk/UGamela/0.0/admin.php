<?php
/*
	ccc  u  u   a   k k
	c    u  u  aaa  kk
	ccc  uuuu a   a k k
*/


include("common.php");
include("cookies.php");

$userrow = checkcookies();//Identificación del usuario

if(!$userrow){ header("Location: login.php"); }
if($userrow['authlevel'] != 3){ header('Location: admin,php');}




$page = "<table width=\"100%\" height=\"100%\">
<tr>
<th>

<blink>Bajo construccion ^_^U</blink>




</th>
</tr>
</table>
";


display($page,'Panel de control',false);

// Created by Perberos. All rights reversed (C) 2006
?>