<?php //techtree.php v1.0
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
	$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$userrow['current_planet']}",'planets',true);
}

echo_head("Tecnologias");
echo_topnav();
echo "<br>\n<center>\n<table width=470>\n";
/*
  Crea la tabla con las diferentes tecnologias seguido de sus requerimientos minimos.
  Además checkea que se tenga esa tecnologia, y las colorea para su facil lectura.
*/
foreach($tech as $i => $n){

	if($i == 0||$i == 100||$i == 200||$i == 400||$i == 40){
    
		echo "\t<tr><td class=c>$n</td><td class=c>{$lang['Requirements']}</td></tr>\n";
    
	}else{
    
		echo "\t<tr><td class=l><a href=infos.php?gid=$i>$n</a></th>";
    //se comprueba si se tienen los requerimientos necesarios
		if(isset($requeriments[$i])){
      
		  echo "<td class=l>";
      
      foreach($requeriments[$i] as $r => $n){
        
        echo "<font color=";
        
        if(isset($userrow[$resource[$r]]) && $userrow[$resource[$r]] >= $n){
          echo "#00ff00";
        }elseif(isset($planetrow[$resource[$r]]) && $planetrow[$resource[$r]] >= $n){
          echo "#00ff00";
        }else{
          echo "#ff0000";
        }
        echo ">{$tech[$r]}({$lang['level']} $n)</font><br>";
      }
      
		  echo "</td></tr>\n";
      
	  }else{
      
      echo "<td class=l></td></tr>\n";
      
    }
	}
}

echo "</table>\n</center>\n</body>\n</html>";

//  Timer, para comprobar la velocidad del scriptd
if ( isset($userrow['authlevel']) && $userrow['authlevel']== 3 ) {
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoFin = $tiempo;
	$tiempoReal = ($tiempoFin - $tiempoInicio);
	echo $depurerwrote001.$tiempoReal.$depurerwrote002.$numqueries.$depurerwrote003;
}
// Created by Perberos. All rights reversed (C) 2006
?>
