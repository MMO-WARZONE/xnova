<?php
/*
Menu.php

by nain pytoyable pour AideXnova 

*/

/////////////////////////le gros du menu///////////////////////////////
$action = $_GET['action'];



$menuFixe=0;//variable a définir un de ces jours pour avoir le choix d'un menu fixe ou dynamique

$nombreLien = 6;// la je ne met que 6 pour le moment car les encheres ne sont pas finies

//description des liens
$title[1] =  "Venta de Naves";
$title[2] =  "Mis Ventas de Naves";
$title[3] =  "Venta de Recursos";
$title[4] =  "Mis Ventas de Recursos";
$title[5] =  "Venta de Defensas";
$title[6] =  "Mis Ventas de Defensas";
$title[7] =  "Poner Naves en Subasta";
$title[8] =  "Subastas de mis Naves";
$title[9] =  "Otros";

//action des liens
$lien[1]  =  "&action=1";
$lien[2]  =  "&action=2";
$lien[3]  =  "&action=3";
$lien[4]  =  "&action=4";
$lien[5]  =  "&action=5";
$lien[6]  =  "&action=6";
$lien[7]  =  "&action=7";
$lien[8]  =  "&action=8";
$lien[9]  =  "&action=9";

//images des liens
$image[1] =  "211";
$image[2] =  "213";
$image[3] =  "2";
$image[4] =  "3";
$image[5] =  "403";
$image[6] =  "406";
$image[7] =  "208";
$image[8] =  "215";
$image[9] =  "209";
//on met menufixe ou pas selon si on active l'option menu dynamique

if ($menuFixe  == 0)// menu pas fixe 
{
	$pageHeader = <<<HEREHEADER

	<!-- DEBUT Script pour la zolie dock :) -->

	<script type="text/javascript" src="scripts/jquerymenu.js"></script>
	<script type="text/javascript" src="scripts/interface.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="scripts/interface.css" />

	<script type="text/javascript">
	$(document).ready(
	function()
	{ $('#dock').Fisheye( {
	maxWidth: 50,
	items: 'a',
	itemsText: 'span',
	container: '.dock-container',
	itemWidth: 75,
	proximity: 90,
	halign : 'center'
	} ) } );
	</script>
	<!-- FIN Script pour la zolie dock :) -->



	<!-- DEBUT Insertion -->

	<div class="dock" id="dock">
	  <div class="dock-container">
HEREHEADER;

	for($i = 1 ; $i <= $nombreLien ; $i++)
	{
		$pageHeader .= <<<HEREHEADER
		<a class="dock-item" href="game.php?page=annonce$lien[$i]" title="$title[$i]">
			<img src="$dpath/gebaeude/$image[$i].gif" title="$title[$i]" />
			<span>$title[$i]</span>
		</a>
HEREHEADER;
	}
	$pageHeader .= <<<HEREHEADER
	  </div> 
	</div>
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />

	<!-- FIN  Header -->



HEREHEADER;
}

if ($menuFixe  == 1)//menu fixe
{
	$pageHeader = <<<HEREHEADER

	<!-- DEBUT Header -->
	<br />
HEREHEADER;

	for($i = 1 ; $i <= $nombreLien ; $i++)
	{
		$pageHeader .= <<<HEREHEADER
	<a href="game.php?page=annonce$lien[$i]" title="$title[$i]">
		<img src="$dpath/gebaeude/$image[$i].gif" style="width: 75px; height: 75px;" title="$title[$i]" />
	</a>
HEREHEADER;
	}
	
	$pageHeader .= <<<HEREHEADER

	<br />
	<br />
	<br />
	<br />
    <br />
	<br />

	<!-- FIN Insertion Header -->

HEREHEADER;
}//////////////////////////////fin du menu

?>