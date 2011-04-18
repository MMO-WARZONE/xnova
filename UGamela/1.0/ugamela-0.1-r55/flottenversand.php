<?

include("common.php");
include("cookies.php");


function infos(){




}

{//init
	$userrow = checkcookies(); // Login (or verify) if not logged in.
	CheckUserExist($userrow);
}
$planetrow = doquery("SELECT * FROM {{table}} WHERE id = '".$userrow["current_planet"]."'","planets",true);

?>
<html>
<? echo_head("Flota"); ?>
<script language=JavaScript> //if (parent.frames.length == 0) { top.location.href = "http://es.ogame.org/"; } </script> <script language="JavaScript">
function haha(z1) {
  eval("location='"+z1.options[z1.selectedIndex].value+"'");
}

</script>
  <script language="JavaScript" src="js/flotten.js"></script>
  <script language="JavaScript" src="js/ocnt.js"></script>
 <body onload="javascript: shortInfo();">
<center>
<? echo_topnav(); ?>
  </center>
<br />
  <script language="JavaScript">
  <!--
     function link_to_gamepay() {
    self.location = "https://www.gamepay.de/?lang=es&serverID=10&userID=122720&gameID=ogame&gui=v2&chksum=2eff45c27ded6d1828c2bf5cfad2f852";
  }
//-->
  </script>
  <center>
  <table width="519" border="0" cellpadding="0" cellspacing="1">
   <tr height="20">
    <td class="c" colspan="2">

      <span class="success">La flota ha sido enviada:</span>
    </td>
   </tr>
   <tr height="20">
  <th>Misión</th>
      <th>Desplegar</th>
   </tr>

   <tr height="20">
     <th>Distancia</th>
      <th>1010</th>
   </tr>
   <tr height="20">
  <th>Velocidad</th>
      <th>28750</th>

   </tr>
   <tr height="20">
  <th>Consumo</th>
      <th>10</th>
   </tr>
   <tr height="20">
  <th>Comienzo</th>

    <th>[7:327:7]</th>
   </tr>
   <tr height="20">
  <th>Objetivo</th>
     <th>[7:327:5]</th>
   </tr>
   <tr height="20">

  <th>Hora de llegada</th>
     <th>Thu Jun 29 5:21:20</th>
   </tr>
   <tr height="20">
  <th>Hora de vuelta</th>
    <th>Thu Jun 29 5:56:04</th>
   </tr>

   <tr height="20">
  <td class="c" colspan="2">Naves</td>
   </tr>
      <tr height="20">
     <th width="50%">Cazador ligero</th><th>4</th>
   </tr>
     
   </table>

 </body>
</html>
   
<?

// Created by Perberos. All rights reversed (C) 2006
?>