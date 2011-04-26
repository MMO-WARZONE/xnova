<?php //building.php

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;

{//init
  include("common.php");
  include("cookies.php");
	$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
	include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta
	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];
	$planetrow = doquery("SELECT * FROM {{table}} WHERE id = '".$userrow["current_planet"]."'","planets",true);
}
//Funciones
function echo_buildinglist(){
  global $userrow,$planetrow,$pricelist;

  echo "<br>Producción actual: <div id=bx class=z></div>";
  //Array del b_hangar_id
  $b_hangar_id = explode(';',$planetrow['b_hangar_id']);
  
  $a=$b=$c="";
  foreach($b_hangar_id as $n => $array){
    if($array!=''){
      $array = explode(',',$array);
      //calculamos el tiempo
      $time = get_building_time($userrow,$planetrow,$array[0]);
      $totaltime += $time * $array[1];
      $c .= "$time,";
      $b .= "'{$pricelist[$array[0]][name]}',";
      $a .= "{$array[1]},";
    }
  }
  echo "
<script  type=\"text/javascript\">
  v = new Date();
  p = 0;
  g = {$planetrow[b_hangar]};
  s = 0;
  hs = 0;
  of = 1;
  c = new Array($c'');
  b = new Array($b'');
  a = new Array($a'');
  aa = 'Completado';
";

  echo <<<HTML
  function t() {
    if (hs == 0) {
      xd();
      hs = 1;
    }
    n = new Date();
    s = c[p]-g-Math.round((n.getTime()-v.getTime())/1000.);
    s = Math.round(s);
    m = 0;
    h = 0;
    if (s < 0) {
      a[p]--;
      xd();
      if (a[p] <= 0) {
        p++;
        xd();
      }
      g = 0;
      v = new Date();
      s=0;
    }
    if (s > 59) {
      m = Math.floor(s / 60);
      s = s - m * 60;
    }
    if (m > 59) {
      h = Math.floor(m / 60);
      m = m - h * 60;
    }
    if (s < 10) {
      s = "0" + s;
    }
    if (m < 10) {
      m = "0" + m;
    }
    if (p > b.length - 2) {
      document.getElementById("bx").innerHTML=aa ;
    } else {
      document.getElementById("bx").innerHTML=b[p]+" "+h+":"+m+":"+s;
    }
    window.setTimeout("t();", 200);
  }
  
  
  
  function xd() {
    while (document.Atr.auftr.length > 0) {
      document.Atr.auftr.options[document.Atr.auftr.length-1] = null;
    }
    if (p > b.length - 2) {
      document.Atr.auftr.options[document.Atr.auftr.length] = new Option(aa);
    }
    for (iv = p; iv <= b.length - 2; iv++) {
      if (a[iv] < 2) {
        ae=" ";
      }else{
        ae=" ";
      }
      if (iv == p) {
        act = " (En funcionamiento)";
      }else{
        act = "";
      }
      document.Atr.auftr.options[document.Atr.auftr.length] = new Option(a[iv]+ae+" \""+b[iv]+"\""+act, iv + of);
    }
  }
  
  window.onload = t;
  </script>
  <br>
  <form name="Atr" method="get" action="buildings">
  <input type="hidden" name="mode" value="fleet">
  <table width="530">
   <tr>
      <td class="c" >Trabajos por hacer</td>
  
   </tr>
   <tr>
    <th ><select name="auftr" size="10"></select></th>
     </tr>
   <tr>
    <td class="c" ></td>
   </tr>
  </table>
  </form>
  Tiempo total restante: 
HTML;
  echo pretty_time($totaltime-$planetrow['b_hangar'])."<br></center>";

}

if($userrow["b_tech_planet"] != 0){
//opsss
	/*
	  Hacemos el query para mantenerlo porque se va a utilizar mas adelante para dar la referencia
	  pero en vano es el query, si el planeta es el mismo que el actual :P
	*/
	if($userrow["b_tech_planet"] != $planetrow["id"]){
		$tech_planetrow = doquery("SELECT * FROM {{table}} WHERE id = '{$userrow[b_tech_planet]}'","planets",true);
	}
	if($tech_planetrow){$planet = $tech_planetrow;}else{$planet = $planetrow;}
	
	if($planet["b_tech"] <= time() && $planet["b_tech_id"] != 0){
		$userrow[$resource[$planet["b_tech_id"]]]++;
		
		doquery("UPDATE {{table}} SET b_tech_id=0  WHERE `id`=".$planet["id"].";","planets");
		doquery("UPDATE {{table}} SET `".$resource[$planet["b_tech_id"]]."`= ".$userrow[$resource[$planetrow["b_tech_id"]]].", b_tech_planet=0  WHERE `id`=".$userrow["id"].";","users");
		$planet["b_tech_id"] = 0;
		
		if(isset($tech_planetrow)){$tech_planetrow = $planet;}else{$planetrow = $planet;}
		
	}elseif($planet["b_tech_id"] == 0){
		/*
		  Esto es para corregir algunos fallos o un posible problema al cancelar una investigacion
		*/
		doquery("UPDATE {{table}} SET b_tech_planet=0  WHERE id={$userrow[id]};","users");
	}else{ $teching = true;}
	
	
	
}

if($mode == "fleet"){//Flota

  //modo POST
  if(isset($_POST['fmenge'])){
    
    foreach($_POST['fmenge'] as $a => $b){
      /*
        Lo que se hara a continuacion es totalmente insano y muy loco...
        
        Bueno, se procede a crear una array con la produccion de los
        elementos elegidos, y se comprobara si se tiene el suficiente
        recurso para poder comprarlo
      */
      if($b != 0){
        //se comprueba que este disponible, para evitar hacks
        if(is_tech_available($userrow,$planetrow,$a)){
          //Se procede a comprobar cuantos recursos requiere esa cantidad de
          //elementos
          //version 1.0
          while($b != 0){
            
            $is_buyeable = true;
            $costMetal=0;
            $costCrystal=0;
            $costDeuterium=0;
            $costEnergy=0;
            
            if($pricelist[$a]['metal'] != 0){
              $costMetal = $pricelist[$a]['metal'];
              if($costMetal > $planetrow["metal"]){ $is_buyeable = false;}
            }
            if($pricelist[$a]['crystal'] != 0){
              $costCrystal = $pricelist[$a]['crystal'];
              if($costCrystal > $planetrow["crystal"] && $is_buyeable){ $is_buyeable = false;}
            }
            if($pricelist[$a]['deuterium'] != 0){
              $costDeuterium = $pricelist[$a]['deuterium'];
              if($costDeuterium > $planetrow["deuterium"] && $is_buyeable){$is_buyeable = false;}
            }
            if($pricelist[$a]['energy'] != 0){
              $costEnergy = $pricelist[$a]['energy'];
              if($costEnergy > $planetrow["energy_max"] && $is_buyeable){$is_buyeable = false;}
            }
            if($is_buyeable){
              //Se agrega a una array donde se contiene todo lo que se pudo
              //comprar
              $builds[$a]++;
              $planetrow["metal"] -= $costMetal;
              $planetrow["crystal"] -= $costCrystal;
              $planetrow["deuterium"] -= $costDeuterium;
              
              $b--;//un contador menos...
            }else{
              $b=0;//para romper el loop
            }
            
          }
          //ahora que ya quitamos los recursos, que se actualizan solos ademas!
          //se procede a crear la array de produccion
          
          foreach($builds as $a => $b){
            $planetrow['b_hangar_id'] .= "$a,$b;";
          }
        }
      }
    }
  }

  echo_head("Hangar");
  echo_topnav();
  if($planetrow[$resource[21]] == 0){message("¡Es necesario construir primero un hangar en este planeta!","Hangar");}
  //luego del post
  echo "<center>\n<br><a href=schrotthaendler><span class=warning>Visita al comerciante de desechos, hasta el 31.08.06</span></a>\n";
  echo "<form action=buildings?mode=fleet method=post>\n<table align=top>\n<tr><td>\n<table width=530>";

  $tabindex = 0;

  foreach($tech as $i => $n){//investigacion
    
    if($i > 201&&$i <= 399){
      
      if(!is_tech_available($userrow,$planetrow,$i)){
        echo "</tr>\n";
      }else{
        //Funciona ^_^
        echo "<tr><td class=l><a href=infos?gid=$i><img border=0 src=\"{$dpath}gebaeude/$i.gif\" align=top width=120 height=120></a></td>";
        //obtenemos el nivel del edificio
        $building_level = $planetrow[$resource[$i]];
        //Muestra el nivel actual de la mina
        //die($userrow[$resource[$i]]);
        $nivel = ($building_level == 0) ? "" : " ($building_level disponibles)";
        //Descripcion
        echo "<td class=l><a href=infos?gid=$i>$n</a>$nivel<br>{$pricelist[$i][description]}<br>\n";
        
        $is_buyeable = echo_price($userrow,$planetrow,$i,false);
        
        /*
          Calculo del tiempo de produccion
          [(Cris+Met)/2500]*[1/(Nivel f.robots+1)]* 0,5^NivelFabrica Nanos. 
        */
        $time = get_building_time($userrow,$planetrow,$i);
        //metodo temporal para mostrar el formato tiempo...
        echo_building_time($time);
        
        echo "<td class=k>";
        
        //Muestra la opcion a elegir para construir o ampliar un edificio
        if($is_buyeable){
          $tabindex++;
          echo "<input type=text name=fmenge[$i] alt='{$tech[$i]}' size=6 maxlength=6 value=0 tabindex=$tabindex>";
        }
      }
      
    }
  }
  
  echo "</td></tr><td class=c colspan=2 align=center><input type=submit value=\"Aceptar\"></td></tr></table></form></td><td valign=top></td></tr></table>";
  
  if ($planetrow['b_hangar_id']!='') echo_buildinglist();
  
  echo "</body>\n</html>";


}
elseif($mode == "research"){//Investigacion

  /*
    Este codigo es el mismo que se encuentra en el b_building.php
  */
  if($bau > 100&&$bau < 200&&isset($tech[$bau])){//Array ( [db_character] 
    //check_field_current($planetrow); solo para edificios
    //if(is_buyable($userrow,$planetrow,$bau)) error("No se puede investigar esa tecnologia.","Investigar");
      if(is_tech_available($userrow,$planetrow,$bau)&&$userrow["b_tech_planet"]==0&&is_buyable($userrow,$planetrow,$bau)!=false){
      //establecemos que se investiga.
      $planetrow["b_tech_id"] = $bau;
      //indicamos el tiempo de investigacion.y establecemos el tiempo de especulacion de cuando termine la investigacion.
      $planetrow["b_tech"] = time()+get_building_time($userrow,$planetrow,$bau);
      //actualizamos e indicamos donde se esta haciendo la investigacion.
      $userrow["b_tech_planet"] = $planetrow["id"];
      //$userrow["b_tech_planet"] //Indica el planeta donde se esta investigando...
      //ahora se restan los recursos
      $costs = get_building_price($userrow,$planetrow,$bau);
      
      foreach($costs as $a => $b){
        
        $planetrow[$a] = $planetrow[$a] - $b;
        
      }
    /*if($pricelist[$bau]['metal'] != 0){
      $cost_metal = floor($pricelist[$bau]['metal'] * pow($pricelist[$bau]['factor'],$userrow[$resource[$bau]]));
      //ahora comprovamos si se tienen los recursos necesarios
      if($planetrow["metal"] < $cost_metal){error("No tienes suficientes recursos.","Investigar ".$tech[$bau]);}
      
    }
    if($pricelist[$bau]['crystal'] != 0){
      $cost_crystal = floor($pricelist[$bau]['crystal'] * pow($pricelist[$bau]['factor'],$userrow[$resource[$bau]]));
      if($planetrow["crystal"] < $cost_crystal){error("No tienes suficientes recursos.","Investigar ".$tech[$bau]);}
      $planetrow["crystal"] = $planetrow["crystal"] - $cost_crystal;
    }
    if($pricelist[$bau]['deuterium'] != 0){
      $cost_deuterium= floor($pricelist[$bau]['deuterium'] * pow($pricelist[$bau]['factor'],$userrow[$resource[$bau]]));
      if($planetrow["deuterium"] < $cost_deuterium){error("No tienes suficientes recursos.","Investigar ".$tech[$bau]);}
      $planetrow["deuterium"] = $planetrow["deuterium"] - $cost_deuterium;
    }
    if($pricelist[$bau]['energy'] != 0){
      $cost_energy= floor($pricelist[$bau]['energy'] * pow($pricelist[$bau]['factor'],$userrow[$resource[$bau]]));
      if($planetrow["energy_max"] < $cost_energy){error("No tienes suficientes recursos.","Investigar ".$tech[$bau]);}
      //$planetrow["deuterium"] = $planetrow["deuterium"] - $cost_deuterium;
    }*/
    
    doquery("UPDATE {{table}} SET b_tech_id={$planetrow[b_tech_id]}, b_tech={$planetrow[b_tech]}, metal={$planetrow[metal]}, crystal={$planetrow[crystal]}, deuterium={$planetrow[deuterium]} WHERE id={$planetrow[id]}","planets");
    doquery("UPDATE {{table}} SET b_tech_planet={$userrow[b_tech_planet]} WHERE id={$userrow["id"]}","users");
    //listo
    }
  }
  elseif($unbau > 100&&$unbau < 200&& $resource[$unbau] != ''){
  
    if($userrow["b_tech_planet"] != 0){// && $planetrow["b_tech_id"] == $unbau
      
      if($userrow["b_tech_planet"] != $planetrow["id"]){
        $tech_planetrow = doquery("SELECT * FROM {{table}} WHERE id = '".$userrow["b_tech_planet"]."'","planets",true);
      }
      
      if(isset($tech_planetrow)){$planet = $tech_planetrow;}else{$planet = $planetrow;}
      //if($planet["b_tech"] <= time()){
      
      if($planet["b_tech_id"] == $unbau){
        
        $planet["b_tech_id"] = 0;
        $userrow["b_tech_planet"] = 0;
        
        if($pricelist[$unbau]['metal'] != 0){
          $cost_metal = floor($pricelist[$unbau]['metal'] * pow($pricelist[$unbau]['factor'],$userrow[$resource[$unbau]]+1));
          $planet["metal"] = $planet["metal"] + $cost_metal;
        }
        if($pricelist[$unbau]['crystal'] != 0){
          $cost_crystal = floor($pricelist[$unbau]['crystal'] * pow($pricelist[$unbau]['factor'],$userrow[$resource[$unbau]]+1));
          $planet["crystal"] = $planet["crystal"] + $cost_crystal;
        }
        if($pricelist[$unbau]['deuterium'] != 0){
          $cost_deuterium= floor($pricelist[$unbau]['deuterium'] * pow($pricelist[$unbau]['factor'],$userrow[$resource[$unbau]]+1));
          $planet["deuterium"] = $planet["deuterium"] + $cost_deuterium;
        }
        
        //doquery("UPDATE {{table}} SET b_tech_id=0  WHERE `id`=".$planet["id"].";","planets");
        doquery("UPDATE {{table}} SET b_tech_id=0, metal=".$planet["metal"].", crystal=".$planet["crystal"].",deuterium=".$planet["deuterium"]."  WHERE `id`=".$planet["id"].";","planets");
        doquery("UPDATE {{table}} SET b_tech_planet=0 WHERE `id`=".$userrow["id"].";","users");
        
        if(isset($tech_planetrow)){$tech_planetrow = $planet;}else{$planetrow = $planet;}
        
        
        
      }
      //error("$cost_metal/".$planetrow["metal"]." - $cost_crystal/".$planetrow["crystal"]." - $cost_deuterium/".$planetrow["deuterium"]."/","");
      //$time = ((($cost_crystal )+($cost_metal)) / 2500) * (1 / ($planetrow[$resource['14']] + 1)) * pow(0.5,$planetrow[$resource['15']]);
      //metodo temporal para mostrar el formato tiempo...
      //$time = ($time *60*60);
      
    }
  
  }

  echo_head("Investigación");
  echo_topnav(); 
  if($planetrow[$resource[31]] == 0){message("¡Es necesario construir primero un laboratorio de investigación en este planeta!","Investigación");}

  
  echo"<center><br /><table align=top><tr><td><table width=530>";
  
  foreach($tech as $i => $n){//investigacion
    
    if($i > 105&&$i <= 199){
        
      if(!is_tech_available($userrow,$planetrow,$i)){//:)
        echo "</tr>";
      }else{
        //Funciona ^_^
        echo "<tr><td class=l><a href=infos?gid=$i><img border=0 src=\"{$dpath}gebaeude/$i.gif\" align=top width=120 height=120></a></td>";
        
        //obtenemos el nivel del edificio
        $building_level = $userrow[$resource[$i]];
        //Muestra el nivel actual de la mina
        $nivel = ($building_level == 0) ? "" : "(Nivel $building_level)";
        //Descripcion
        echo "<td class=l><a href=infos?gid=$i>$n</a>$nivel<br>".$pricelist[$i]['description']."<br>\n		";
        
        //$is_buyeable = is_buyable($userrow,$planetrow,$i,true);
        $is_buyeable = echo_price($userrow,$planetrow,$i);
        /*
          Calculo del tiempo de produccion
          [(Cris+Met)/2500]*[1/(Nivel f.robots+1)]* 0,5^NivelFabrica Nanos. 
        */
        //$time = (($pricelist[$i]['metal'] + $pricelist[$i]['crystal']) / 1000) * (($planetrow[$resource['31']] + 1 ));
        //metodo temporal para mostrar el formato tiempo...
        $time = get_building_time($userrow,$planetrow,$i);//$time*60*60);
        echo_building_time($time);
        
        echo "<td class=k>";
        
        if(!$teching){
          //Muestra la opcion a elegir para construir o ampliar un edificio
          if($planetrow[$resource[$i]] == 0 && $is_buyeable){
            echo "<a href=\"?mode=research&bau=$i\"><font color=#00FF00>Investigar</font></a>";
          }elseif($is_buyeable){
            $nplus = $planetrow[$resource[$i]] + 1;
            echo "<a href=\"?mode=research&bau=$i\"><font color=#00FF00>Investigar<br> al nivel $nplus</font></a>";
          }elseif($planetrow[$resource[$i]] == 0){
            echo "<font color=#FF0000>Investivar</font>";
          }else{
            $nplus = $planetrow[$resource[$i]] + 1;
            echo "<font color=#FF0000>Investivar<br> al nivel $nplus</font>";
          }
            
        }else{
          if($planet["b_tech_id"] == $i){
            if(isset($tech_planetrow)){
              $planet = $tech_planetrow;
              $time = $tech_planetrow["b_tech"] - time();
              $name = $tech_planetrow["name"];
              $idcp = $tech_planetrow["id"];
              $unbau = $tech_planetrow["b_tech_id"];
            }else{
              $planet = $planetrow;
              $time = $planetrow["b_tech"] - time();
              $name = "";
              $idcp = $planetrow["id"];
              $unbau = $planetrow["b_tech_id"];
            }
            // Todo loco, este script permite mostrar el tiempo de investigacion seguido 
            echo '				
      <div id="bxx" class="z"></div>
                <script   type="text/javascript">
                  v=new Date();
                  var bxx=document.getElementById(\'bxx\');
                  function t(){
                    n=new Date();
                    ss='.$time.';
                    s=ss-Math.round((n.getTime()-v.getTime())/1000.);
                    m=0;h=0;
                    if(s<0){
                      bxx.innerHTML='."'Hecho<br><a href=buildings?mode=research&cp=$idcp>Continuar</a>'".';
                    }else{
                      if(s>59){m=Math.floor(s/60);s=s-m*60}
                      if(m>59){h=Math.floor(m/60);m=m-h*60}
                      if(s<10){s="0"+s}
                      if(m<10){m="0"+m}
                      bxx.innerHTML=h+":"+m+":"+s+"<br><a href=buildings?unbau='.$unbau.'&mode=research"+">Cancelar<br><br>'.$name.'</a>"                }
                    window.setTimeout("t();",999);
                  }
                  window.onload=t;
                </script>';
          }else{echo "<center>-</center>";}
        }
      
      
      }
      
    }
  
  }
	echo "</tr></table></td><td valign=top></td></tr></table></center></body></html>";
}
elseif($mode = "defense"){//Defensa

  //modo POST
  if(isset($_POST['fmenge'])){
    
    foreach($_POST['fmenge'] as $a => $b){
      /*
        Lo que se hara a continuacion es totalmente insano y muy loco...
        
        Bueno, se procede a crear una array con la produccion de los
        elementos elegidos, y se comprobara si se tiene el suficiente
        recurso para poder comprarlo
      */
      if($b != 0){
        //se comprueba que este disponible, para evitar hacks
        if(is_tech_available($userrow,$planetrow,$a)){
          //Se procede a comprobar cuantos recursos requiere esa cantidad de
          //elementos
          //version 1.0
          while($b != 0){
            
            $is_buyeable = true;
            $costMetal=0;
            $costCrystal=0;
            $costDeuterium=0;
            $costEnergy=0;
            
            if($pricelist[$a]['metal'] != 0){
              $costMetal = $pricelist[$a]['metal'];
              if($costMetal > $planetrow["metal"]){ $is_buyeable = false;}
            }
            if($pricelist[$a]['crystal'] != 0){
              $costCrystal = $pricelist[$a]['crystal'];
              if($costCrystal > $planetrow["crystal"] && $is_buyeable){ $is_buyeable = false;}
            }
            if($pricelist[$a]['deuterium'] != 0){
              $costDeuterium = $pricelist[$a]['deuterium'];
              if($costDeuterium > $planetrow["deuterium"] && $is_buyeable){$is_buyeable = false;}
            }
            if($pricelist[$a]['energy'] != 0){
              $costEnergy = $pricelist[$a]['energy'];
              if($costEnergy > $planetrow["energy_max"] && $is_buyeable){$is_buyeable = false;}
            }
            if($is_buyeable){
              //Se agrega a una array donde se contiene todo lo que se pudo
              //comprar
              $builds[$a]++;
              $planetrow["metal"] -= $costMetal;
              $planetrow["crystal"] -= $costCrystal;
              $planetrow["deuterium"] -= $costDeuterium;
              
              $b--;//un contador menos...
            }else{
              $b=0;//para romper el loop
            }
            
          }
          //ahora que ya quitamos los recursos, que se actualizan solos ademas!
          //se procede a crear la array de produccion
          foreach($builds as $a => $b){
            $planetrow['b_hangar_id'] .= "$a,$b;";
          }
        }
      }
    }
  }
  
  echo_head("Defensa");
  echo_topnav();
  echo "<center>
  <br />
  <form action=buildings?mode=defense method=post>
  <table align=top><tr><td>  
  <table width=530>";
  
  if($planetrow[$resource[21]] == 0){message("¡Es necesario construir primero un hangar en este planeta!","Hangar");}
  $tabindex = 0;
  foreach($tech as $i => $n){ //Defensa
  
    if($i > 400&&$i <= 599){
      
      if(!is_tech_available($userrow,$planetrow,$i)){
        echo "</tr>\n";
      }else{
        //Funciona ^_^
        echo "<tr><td class=l><a href=infos?gid=$i><img border='0' src=\"".$dpath."gebaeude/$i.gif\" align='top' width='120' height='120'></a></td>";
        
        //obtenemos la cantidad de unidades que hay en el planeta
        $building_level = $planetrow[$resource[$i]];
        //Muestra la cantidad de unidades que se encuentran en el planeta
        //die($userrow[$resource[$i]]);
        $nivel = ($building_level == 0) ? "" : "(Nivel $building_level)";
        //Descripcion
        echo "<td class=l><a href=infos?gid=$i>$n</a><br>{$pricelist[$i][description]}<br>\n		";
        
        $is_buyeable = echo_price($userrow,$planetrow,$i,false);
        /*
          Calculo del tiempo de produccion
          [(Cris+Met)/2500]*[1/(Nivel f.robots+1)]* 0,5^NivelFabrica Nanos. 
        */
        $time = get_building_time($userrow,$planetrow,$i);
        //metodo temporal para mostrar el formato tiempo...
        echo_building_time($time);
        
        echo "<td class=k>";
        
        //Muestra la opcion a elegir para construir o ampliar un edificio
        if($is_buyeable){
          $tabindex++;
          echo "<input type=text name=fmenge[$i] alt='{$tech[$i]}' size=6 maxlength=6 value=0 tabindex=$tabindex>";
        }
      }
      
    }
  
  }

  echo '</td>
  </tr>
	<td class=c colspan=2 align=center><input type=submit value="Aceptar">
	</td></tr></table></form></td><td valign="top"></td></tr></table>';

  if ($planetrow['b_hangar_id']!='') echo_buildinglist();
  
  echo "</body>\n</html>\n";

}

//  Timer, para comprobar la velocidad del scriptd
if($userrow['authlevel'] == 3){
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoFin = $tiempo;
	$tiempoReal = ($tiempoFin - $tiempoInicio);
	echo $depurerwrote001.$tiempoReal.$depurerwrote002.$numqueries.$depurerwrote003;
}
// Created by Perberos. All rights reversed (C) 2006
?>