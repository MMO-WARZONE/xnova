<html> 
 <head> 
  <link rel='stylesheet' type='text/css' href='css/default.css' />
  <link rel="stylesheet" type="text/css" href="http://ogame414.de/epicblue/formate.css" />
  <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
  <script src="js/utilities.js" type="text/javascript"></script>
  <script language="JavaScript">
  
  </script>
 </head> 
 <body > 
  <center>
<center>
<table>
 <tr>
  <td></td>
  <td>
   <center>
   <table>
    <tr>
     <td><img src="http://ogame414.de/epicblue/planeten/small/s_wasserplanet05.jpg" width="50" height="50"></td>
     <td>
      <table border="1">
       <select size="1" onchange="haha(this)">
                                   <option value="/game/schrotthaendler.php?session=676f5a8a5ccf&cp=33742944&mode=&gid=&messageziel=&re=0" selected>Nuettad    [5:328:12]</option> 
                                   <option value="/game/schrotthaendler.php?session=676f5a8a5ccf&cp=33796729&mode=&gid=&messageziel=&re=0" >Ammuk    [7:327:7]</option> 
                                   <option value="/game/schrotthaendler.php?session=676f5a8a5ccf&cp=33802736&mode=&gid=&messageziel=&re=0" >Zhaga    [7:327:4]</option> 
                                   <option value="/game/schrotthaendler.php?session=676f5a8a5ccf&cp=33804271&mode=&gid=&messageziel=&re=0" >Wabiteum    [7:327:5]</option> 
                                   <option value="/game/schrotthaendler.php?session=676f5a8a5ccf&cp=33817224&mode=&gid=&messageziel=&re=0" >Nafeq    [7:327:15]</option> 
                                   <option value="/game/schrotthaendler.php?session=676f5a8a5ccf&cp=33820757&mode=&gid=&messageziel=&re=0" >Summok    [7:327:12]</option> 
                                   <option value="/game/schrotthaendler.php?session=676f5a8a5ccf&cp=33822343&mode=&gid=&messageziel=&re=0" >Nuekumo    [7:327:10]</option> 
                                   <option value="/game/schrotthaendler.php?session=676f5a8a5ccf&cp=33918717&mode=&gid=&messageziel=&re=0" >Naknue    [7:327:6]</option> 
                                   <option value="/game/schrotthaendler.php?session=676f5a8a5ccf&cp=34554707&mode=&gid=&messageziel=&re=0" >Colonia    [5:328:11]</option> 
               </select>
      </table>
     </td>
    </tr>
  </table>
  </center>
  </td>
  <td>
   <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
     <td align="center"></td>
     <td align="center" width="85">
      <img border="0" src="http://ogame414.de/epicblue/images/metall.gif" width="42" height="22">
     </td>
     <td align="center" width="85">
      <img border="0" src="http://ogame414.de/epicblue/images/kristall.gif" width="42" height="22">
     </td>
     <td align="center" width="85">
      <img border="0" src="http://ogame414.de/epicblue/images/deuterium.gif" width="42" height="22">
     </td>
     <td align="center" width="85">
      <img border="0" src="http://ogame414.de/epicblue/images/energie.gif" width="42" height="22">
     </td>
     <td align="center"></td>
    </tr>
    <tr>
     <td align="center"><i><b>&nbsp;&nbsp;</b></i></td>
     <td align="center" width="85"><i><b><font color="#ffffff">Metal</font></b></i></td>
     <td align="center" width="85"><i><b><font color="#ffffff">Cristal</font></b></i></td>
     <td align="center" width="85"><i><b><font color="#ffffff">Deuterio</font></b></i></td>
     <td align="center" width="85"><i><b><font color="#ffffff">Energía</font></b></i></td>
     <td align="center"><i><b>&nbsp;&nbsp;</b></i></td>
    </tr>
    <tr>
     <td align="center"></td>
     <td align="center" width="85">100.336</td>
     <td align="center" width="85">52.445</td>
     <td align="center" width="85">37.028</td>
     <td align="center" width="85">539/4.878</td>
     <td align="center"></td>
    </tr>
   </table>
  </tr>
 </table>
  </center>
<br />


<html><head>
  <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  <link rel="stylesheet" type="text/css" href="flotten1.php-Dateien/formate.css">
  </head><body>


<script type="text/javascript">

function calc_resources()
{
	var regain_kristal = 1000 * 1;
	var max_number = 12;
	var num = parseInt(document.getElementById('numscrap').value);

	if (num < 0){
		num = 0;
		document.getElementById('numscrap').value=num;
	}
	if (num > max_number){
		num = max_number;
		document.getElementById('numscrap').value=num;
	}
	
	document.getElementById('scrapkrisvalue').innerHTML = num * regain_kristal; 
	
}

</script>
<center>
<form action="schrotthaendler.php?session=676f5a8a5ccf" method="post">
  <table border="0" cellpadding="0" cellspacing="1" width="519">
   <tr height="20"><td colspan="3" class="c">Comerciante intergaláctico de desechos</td></tr>
   <tbody>
     <tr height="20">
    	<th rowspan="4" align="center" valign="middle"><img src="img/ogame_scrap.jpg" width="120" height="180"></th>
    	<th class="1" colspan="2" align="center"><p>A través del comerciante puedes intercambiar tus sondas en desuso por cristal<br></p></th>
    </tr>
     <tr height="20">
         <th align="center">¿Cuántas sondas quieres intercambiar?</th>
         <th align="center">
             <input id="numscrap" type=text name=number_of_probes alt='Spionagesonde' size="6" maxlength="6" value="0" tabindex="1" onKeyup="calc_resources()">
         <span style="color:gray;">/ 12</span></th>
     </tr>
     <tr height="20">
         <th colspan="2" align="center">El comerciante te ofrece <span id="scrapkrisvalue" style="color:lightgreen;">0</span> de cristal </th>
         </tr>
     <tr height="20" align="center">
         <th colspan="2"><input name="submit" type="submit" value="intercambiar"></th>
     </tr>
    </tbody></table>
</form>

</center>
</body>
</html>








