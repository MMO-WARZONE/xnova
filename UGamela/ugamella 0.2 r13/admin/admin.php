<?php // -> Panel de admin Creado por Prody {Con el notepad sabelo}

define('INSIDE', true);
$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
//checkeamos que el usuario este logueado y que tenga los permisos de admin
if(!check_user()){ header("Location: ./../login.php"); }
if($user['authlevel']!="3"&&$user['authlevel']!="1"){ header("Location: ../login.php");}
//si todo esta bien continuamos
echo "<br><br><br><br><center><b>Bienvenido : ".$user['username'];
echo "<br><br><br>";
echo "<div align=\"left\" valign=\"bottom\"  ><b><a href=\"?op=1\">Buscar usuarios</a><br><br><b><a href=\"?op=2\">Buscar por ip</a><br><br><b><a href=\"?op=3\">Editar usuario</a></font></div>";

//formulario de busqueda por nombre de usuario
function form_1(){
echo "<form name=\"buscar\" action=\"?doit=1\" method=\"GET\">Usuario :<input type=\"text\" name=\"usuario\"><br><a href=\"javascript:document.forms[0].submit()\">Buscar</a>";}
//formulario de busqueda por numero de ip
function form_2(){
echo "<form name=\"buscarip\" action=\"?doit=2\" method=\"GET\">IP :<input type=\"text\" name=\"ip\"><br><a href=\"javascript:document.forms[0].submit()\">Buscar</a>";}
//formulario para editar usuario
function form_3(){
echo "<form name=\"editartipo\" action=\"?doit=3\" method=\"GET\">Usuario :<input type=\"text\" name=\"edit_user\"><br><a href=\"javascript:document.forms[0].submit()\">Editar</a>";}

//formulario para editar tecnologia
function form_4(){
echo "<form method=\"GET\"  action=\"\">
Usuario : <input type=\"text\" name=\"edit_user_name\"><br>
Nivel : <input type=\"text\" name=\"edit_user_nivel\"><br>
<select name=\"editar[]\">
<option value=\"spy\">Espionage</option>
<option value=\"computer\">Computacion</option>
<option value=\"military\">Militar</option>
<option value=\"defense\">Defensa</option>
<option value=\"shield\">Blindaje</option>
</select>
<a href=\"javascript:document.forms[0].submit()\">Editar !</a>
</form>";}

//formulario para editar Planetas
function form_5(){
echo "<form method=\"GET\"  action=\"\">
Usuario : <input type=\"text\" name=\"edit_planet_usr\"><br>
Galaxia : <input type=\"text\" name=\"edit_planet_gal\"><br>
Sistema : <input type=\"text\" name=\"edit_planet_sis\"><br>
Planeta : <input type=\"text\" name=\"edit_planet_pla\"><br>
Cantidad : <input type=\"text\" name=\"edit_planet_rec\"><br>
<select name=\"edit2[]\">
<option value=\"metal\">Metal</option>
<option value=\"crystal\">Cristal</option>
<option value=\"deuterium\">Deuterio</option>
</select>
<a href=\"javascript:document.forms[0].submit()\">Editar !</a>
</form>";}

switch($_GET['op']) {
   case 1:
       form_1();
       break;
   case 2:
       form_2();
       break;
   case 3:
       form_3();
       break;
   case 4:
       form_4();
       break;
   case 5:
       form_5();
       break;
/*
   default:
 htm();*/
       
}

//buscar por usuario
if(isset($_GET['usuario'])){
$result = doquery("SELECT * FROM {{table}} WHERE username LIKE '%{$_GET['usuario']}%' LIMIT 10;","users");
//doquery("SELECT ally_name FROM {{table}} WHERE id = {$s['ally_id']}","alliance",true);

$row = mysql_fetch_row($result);
echo "<table border = '1' cellspacing='0' cellpadding='0'> \n";
echo "<tr><td><div align=\"center\"><font color=\"#FFFFFF\">Nombre :</font></div></td></tr>";
echo "<tr><td><div align=\"center\"><font color=\"#FFFFFF\"><a href\"\"></a>{$row[1]}</font></div></td></tr>";
echo "<tr><td><div align=\"center\"><font color=\"#FFFFFF\">Ultimo IP :</font></div></td></tr>";
echo "<tr><td><div align=\"center\"><font color=\"#FFFFFF\"><a href\"\"></a>{$row[16]}</font></div></td></tr>";
echo "</table> \n";}

//buscar ip
if(isset($_GET['ip'])){
$ip=$_GET['ip'];
$result = doquery("SELECT * FROM {{table}} WHERE user_lastip='$ip' LIMIT 10;","users"); 

$row = mysql_fetch_row($result);
echo "<table border = '1' cellspacing='0' cellpadding='0'> \n";
echo "<tr><td><div align=\"center\"><font color=\"#FFFFFF\">Nombre :</font></div></td></tr>";
echo "<tr><td><div align=\"center\"><font color=\"#FFFFFF\">{$row[1]}</font></div></td></tr>";
//echo "<tr><td><div align=\"center\"><font color=\"#FFFFFF\">Ultimo IP :</font></div></td></tr>";
//echo "<tr><td><div align=\"center\"><font color=\"#FFFFFF\">{$row[16]}</font></div></td></tr>";
echo "</table> \n";}

//editar usuario
if(isset($_GET['edit_user'])){
$ed=$_GET['edit_user'];
$result=doquery("SELECT * FROM {{table}} WHERE username='$ed';","users");//aca buscamos el usuario
$row=mysql_fetch_row($result);//el resultado lo ponemos en un array no?
$gwor=$row[0];
$result2 = doquery("SELECT * FROM {{table}} WHERE id_owner='$gwor';","planets");//y aca buscamos los planetas del usuario.....
$row2=mysql_fetch_row($result2);//otro array mas no?

echo "<pre>Planeta Principal :<a href=\"?op=5\" alt=\"Editar\"><br>{$row[12]} : "."{$row[13]} : "."{$row[14]}</a></pre>";
echo "<pre>Colonias:<br>{$row2[3]} : "."{$row2[4]} : "."{$row2[5]}</pre>";

echo "<pre><font color=\"#FFFFFF\">Nombre :</font></pre>";
echo "<pre><font color=\"#FFFFFF\">{$row[1]}</font></pre>";

echo "<pre><font color=\"#FFFFFF\"><a href=\"?op=4\" alt=\"Editar\">Tecnologias :</a></font></pre>";
echo "<pre><font color=\"#FFFFFF\">Espionaje : {$row[37]}</a><br></div></td></tr>"."<tr><td><div align=\"center\"><font color=\"#FFFFFF\">Computacion : {$row[38]}<br></font></div></td></tr>"."<tr><td><div align=\"center\"><font color=\"#FFFFFF\">Militar : {$row[39]}<br></font></div></td></tr>"."<tr><td><div align=\"center\"><font color=\"#FFFFFF\">Defensa : {$row[40]}<br></font></pre>";}


//editar investigaciones

if(isset($_GET['editar'])){
$a=$_GET['editar'][0];
$b=$_GET['edit_user_nivel'];
$c=$_GET['edit_user_name'];

$query = doquery("UPDATE {{table}} SET {$a}_tech='$b' WHERE username='$c';","users");

message("Editado","pero vo so loko?");}

//editar planetas
if(isset($_GET['edit2'])){

$value=$_GET['edit2'][0];
$eds=$_GET['edit_planet_usr'];
$gal=$_GET['edit_planet_gal'];
$sis=$_GET['edit_planet_sis'];
$pla=$_GET['edit_planet_pla'];
$can=$_GET['edit_planet_rec'];
$ids=$row[12];//12 o 16

$result = doquery("SELECT * FROM {{table}} WHERE username='$eds';","users");//aca buscamos el usuario
$row = mysql_fetch_row($result);//el resultado lo ponemos en un array no?
$query = doquery("UPDATE {{table}} SET {$value}='$can' WHERE id='$ids';","planets");

message("Planeta Editado","pero vo so loko?");}


?>
<link rel="stylesheet" type="text/css" media="screen" href="http://freenet-homepage.de/kakashi/Maya/formate.css" />

</style> 