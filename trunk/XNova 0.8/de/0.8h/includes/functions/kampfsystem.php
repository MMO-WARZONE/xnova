<?php


/*******************************************************************************************************
*
*      german UGamela (C) 2008
*      OpenSource aslong as you don't remove our Copyright
*      Licence GNU (GPL)
*      http://ugamela-forum.pheelgood.net
*      UGamela basescripts from Perberos @2006 (all rights reversed)
*      KS & AKS by -= MoF =- on 23.02.2008 - 19:11
*
********************************************************************************************************


                             .%.+.YÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛ+%$++                             
                      ..% ++.YÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛ   + .                     
               .++%$DDÛÛÛÛÛÛÛÛÛ°°°°°°°°°°°°°°°°°°°°ÛÛÛÛÛÛÛÛÛÛÛ%.                      
             .$ÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛ°°°°°°°°°°°°°°°°°°°°°°°oVi±±±±±±±±2                     
         ÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛÛ°°°°°°°°      ²²²°°°°°°°°°±±±±±±²²²²²²%                  
       ²²²²²²²²²²²²²²²²²²²±°°°°°°°°°        ²²²°°°°°°°°°±±±±²²²²²²²²²²²²              
    +²²²²²²²²²²²²²²²²²²²²²±±±±±°°°°°          °°°°°°°°°±±±±²²²²²²²²²²²²²²²            
  +²²²²²²²²²²²²²²²²²²²²²²²±±±±±±°°°°°°       °°°°°°°°±±±±²²²²²²²²²²²²²²²²²²²²².+.     
     ²²²²²²²²²²²²²²²²²²²²²²²²²±±°°°°°°°°°°°°°°°°°°°°±±±±²²²²²²²²²²²²²²²²²²²²²²²       
    +Y2 ²²²²²²²²²²²²²²²²²²²²²²²±±±°°°°°°°°°°°°°°°°°±±±²²²²²²²²²²²²²²²²²²²²²²²²²².     
      ..²²²²²²²²²²²²²²²²²²²²²²²²±±±±±±°°°°°°°°°±±±±±²²²²²²²²²²²²²²²²²²²²²²ÛÛÛÛÛ.      
        .²²²²²²²²²²²²²²²²²²²²²²²²²²±±±±±±±±±±±±±±²²²²²²²²²²²²²²²²²²²²²²²ÛÛÛÛÛÛ        
               ²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²+             
                  ²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²².                   
                      .ÛÛÛÛÛÛ²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²²                     
                            ÛÛÛÛÛÛÛÛÛ                                                 
                                                                                      
                                      -= MoF =-     


AN XNOVASCRIPT ANGEPASST BY REDFIGHTER									  


*/

if (!defined('INSIDE'))
	die("Hacking attempt");

@set_time_limit(360);
@ignore_user_abort(TRUE);


 function Kampf($angreifer_daten, $verteidiger_daten, $angreifer_schiffe, $verteidiger_schiffe, $angreifer_techniken, $verteidiger_techniken, $ressis, $mond, $pricelist, $lang) {

 
/*
UGAMELA KAMPF SYSTEM / UGAMELA AKS SYSTEM
By -= MoF =-

Ablauf:
-> 1. Alles berechnen (Schilde usw...), jedes Schiff bekommt eine eigene Zahl
-> 2. Kampf starten, max 7 Runden
-> 3. Jedes Schiff / Verteidigungsanlage kommt zum Zug, feuert min. 1 Schuss ab, bei RapidFire mehr
-> 4. Schuss auf ein zufälliges Schiff
-> 5. Schild nimmt schaden, wenn Schussstärke > 1% der max. Schilde, eventuell wird auch Hülle beschädigt
-> 6. Falls Hülle mehr als 30 % Schaden hat, kann das Schiff ein Explosionsflag bekommen (40% Schaden = 40% Chance auf Zerstörung)
-> 7. Zerstöre Schiff werden aus dem Kampf entfernt
-> 8. Schilde werden wieder aufgeladen
-> 9. Und so weiter, bis einer gewinnt oder nach 7 Runden unentschieden ist.
-> 10. KB wird während der Schlacht generiert
-> 11. KB Endaten berechnen (Beute usw...)
-> 12. Eventuell Mond
13. Zerstörte Schiffe aus Datenbank entfernen
14. Zerstörte Verteidigungsanlagen zu 30% (etwa) entfernen
15. Nachrichten verschicken + Flotten auf Rückweg senden
*/

 $startzeit_benchmark = explode(' ', microtime());


	// Alles berechnen


	$date = date('m-d H:i:s');
	$lang['kb_time'] = str_replace("%d", $date, $lang['kb_time']);

	$kb = '<html>
<head>
%style
  <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
  <title>'.$lang['kb_title'].'</title>
</head>
<body>
<div id=overDiv></div>
<table width=99%>
   <tr>
    <td>'.$lang['kb_time'].'
	<br>

	<table border=1 width=100%>
		<tr>
			';


	$schiffe_a = array();
	$schiffe_v = array();

	$schiffdaten_a = array();
	$schiffdaten_v = array();

	$runde_schiffe_a = array();
	$runde_schiffe_v = array();

	$startdef = array();
	$return = array();

	$ladekapazitaet = array();
	$gesamtcap = 0;

	$def_delte = array();
	$def_repaired = array();
	$shipdelete_a = array();
	$shipdelete_v = array();

	$maxrips = 200; // (Max. Todessterne / Deadstars / RIPs); Angreifer / Verteidiger getrennt
	$rips_a = 0;
	$rips_v = 0;

	$infos_a = array();
	$infos_v = array();

	$vernichtet_a = array();
	$vernichtet_v = array();


	foreach ($angreifer_schiffe as $angr_id => $array) {

		$kb .= '			<th>
				<br>
				<center>
					'.$lang['kb_angreifer'].' '.$angreifer_daten[$angr_id]['name'].' (['.$angreifer_daten[$angr_id]['koords'].'])

					<br>
					'.$lang['kb_waffen'].': '.($angreifer_techniken[$angr_id]['waffen'] * 10).'% '.$lang['kb_schilde'].': '.($angreifer_techniken[$angr_id]['schilde'] * 10).'% '.$lang['kb_huelle'].': '.($angreifer_techniken[$angr_id]['panzerung'] * 10).'%
					';



		$namen = '';
		$anzahlen = '';
		$bewaffnungen = '';
		$schilde = '';
		$huellen = '';

		foreach ($array as $schiff_id => $schiffdaten) {

			$zahl_add = '';

			if ($schiff_id == "214") {
				$rips_a += $schiffdaten['anzahl'];
				if ($rips_a > $maxrips) {
					$zuviel = ($rips_a - $maxrips);
					$zahl_add = " (- ".$zuviel.")";
					$rips_a = $maxrips;

					if ($zuviel == $schiffdaten['anzahl'])
						$infos_a[$angr_id] = 1;
					else
						$infos_a[$angr_id] = 2;
				}
			}




			$name = $lang['kb_names'][$schiff_id];

			if (empty($name))
				$name = "N/A";


			$namen .= '<th>'.$name.'</th>';
			$anzahlen .= '<th>'.pretty_number($schiffdaten['anzahl']).$zahl_add.'</th>';
			$bewaffnungen .= '<th>'.pretty_number(floor($pricelist[$schiff_id]['attack'] + (($pricelist[$schiff_id]['attack'] / 10) * $angreifer_techniken[$angr_id]['waffen']))).'</th>';
			$schilde .= '<th>'.pretty_number(floor($pricelist[$schiff_id]['shield'] + (($pricelist[$schiff_id]['shield'] / 10) * $angreifer_techniken[$angr_id]['schilde']))).'</th>';
			$huellen .= '<th>'.pretty_number(floor((($pricelist[$schiff_id]['metal'] + $pricelist[$schiff_id]['crystal']) + ((($pricelist[$schiff_id]['metal'] + $pricelist[$schiff_id]['crystal']) / 10) * $angreifer_techniken[$angr_id]['panzerung'])) / 10)).'</th>';


			$runde_schiffe_a[0][$angr_id][$schiff_id] = $schiffdaten['anzahl'];

			$schiffdaten_a[$angr_id][$schiff_id] =
						array(
							"w" => floor($pricelist[$schiff_id]['attack'] + (($pricelist[$schiff_id]['attack'] / 10) * $angreifer_techniken[$angr_id]['waffen'])),
							"s" => floor($pricelist[$schiff_id]['shield'] + $pricelist[$schiff_id]['shield'] * $angreifer_techniken[$angr_id]['schilde'] / 10),
							"p" => floor((($pricelist[$schiff_id]['metal'] + $pricelist[$schiff_id]['crystal']) + ((($pricelist[$schiff_id]['metal'] + $pricelist[$schiff_id]['crystal']) / 10) * $angreifer_techniken[$angr_id]['panzerung'])) / 10)
						);



			if ($zahl_add != '') {
				$schiffdaten['anzahl'] -= $zuviel;
			}


			$ladekapazitaet[$angr_id] += ($pricelist[$schiff_id]['capacity'] * $schiffdaten['anzahl']);
			// $gesamtcap += ($pricelist[$schiff_id]['capacity'] * $schiffdaten['anzahl']);

			for ($i = 0; $i < $schiffdaten['anzahl']; $i++) {
				$schiffe_a[] = array(
					"a" => $angr_id,
					"b" => $schiff_id,
					"s" => floor($pricelist[$schiff_id]['shield'] + $pricelist[$schiff_id]['shield'] * $angreifer_techniken[$angr_id]['schilde'] / 10),
					"p" => floor((($pricelist[$schiff_id]['metal'] + $pricelist[$schiff_id]['crystal']) + ((($pricelist[$schiff_id]['metal'] + $pricelist[$schiff_id]['crystal']) / 10) * $angreifer_techniken[$angr_id]['panzerung'])) / 10)
					);
			}
		}


		if (!empty($namen)) {

			$kb .= '
					<table border=1>
						<tr>
							<th>'.$lang['kb_typ'].'</th>'.$namen.'
						</tr>
						<tr>
							<th>'.$lang['kb_anzahl'].'</th>'.$anzahlen.'
						</tr>
						<tr>
							<th>'.$lang['kb_bewaff'].'</th>'.$bewaffnungen.'
						</tr>
						<tr>
							<th>'.$lang['kb_schilde'].'</th>'.$schilde.'
						</tr>
						<tr>
							<th>'.$lang['kb_huelle'].'</th>'.$huellen.'
						</tr>
					</table>';


		}
		else {
			$kb .= '<br>'.$lang['kb_killed'];
			if (!in_array($angr_id, $vernichtet_a))
				$vernichtet_a[] = $angr_id;

		}

		$gesamtcap -= $angreifer_daten[$angr_id]['beladen'];
		$ladekapazitaet[$angr_id] -= $angreifer_daten[$angr_id]['beladen'];

		if ($ladekapazitaet[$angr_id] < 0)
			$ladekapazitaet[$angr_id] = 0;
		else
			$gesamtcap += ($ladekapazitaet[$angr_id]);

		$kb .= '
				</center>
			</th>';


	}

	if ($gesamtcap < 0)
		$gesamtcap = 0;


	$kb .= '		</tr>
	</table>
	<table border=1 width=100%>
		<tr>';
	
	foreach ($verteidiger_daten as $vert_id => $array) {



		$array = $verteidiger_schiffe[$vert_id];

		$namen = '';
		$anzahlen = '';
		$bewaffnungen = '';
		$schilde = '';
		$huellen = '';

		$kb .= '			<th>
				<br>
				<center>
					'.$lang['kb_verteidiger'].' '.$verteidiger_daten[$vert_id]['name'].' (['.$verteidiger_daten[$vert_id]['koords'].'])

					<br>
					'.$lang['kb_waffen'].': '.($verteidiger_techniken[$vert_id]['waffen'] * 10).'% '.$lang['kb_schilde'].': '.($verteidiger_techniken[$vert_id]['schilde'] * 10).'% '.$lang['kb_huelle'].': '.($verteidiger_techniken[$vert_id]['panzerung'] * 10).'%
					';


		if (count($array) > 0) {
			foreach ($array as $schiff_id => $schiffdaten) {

				$zahl_add = '';

				if ($schiff_id == "214") {
					$rips_v += $schiffdaten['anzahl'];
					if ($rips_v > $maxrips) {
						$zuviel = ($rips_v - $maxrips);
						$zahl_add = " (- ".$zuviel.")";
						$rips_v = $maxrips;

						if ($zuviel == $schiffdaten['anzahl'])
							$infos_v[$vert_id] = 1;
						else
							$infos_v[$vert_id] = 2;
					}
				}



				$name = $lang['kb_names'][$schiff_id];

				if (empty($name))
					$name = "N/A";

				$namen .= '<th>'.$name.'</th>';
				$anzahlen .= '<th>'.pretty_number($schiffdaten['anzahl']).$zahl_add.'</th>';
				$bewaffnungen .= '<th>'.pretty_number(floor($pricelist[$schiff_id]['attack'] + (($pricelist[$schiff_id]['attack'] / 10) * $verteidiger_techniken[$vert_id]['waffen']))).'</th>';
				$schilde .= '<th>'.pretty_number(floor($pricelist[$schiff_id]['shield'] + (($pricelist[$schiff_id]['shield'] / 10) * $verteidiger_techniken[$vert_id]['schilde']))).'</th>';
				$huellen .= '<th>'.pretty_number(floor((($pricelist[$schiff_id]['metal'] + $pricelist[$schiff_id]['crystal']) + ((($pricelist[$schiff_id]['metal'] + $pricelist[$schiff_id]['crystal']) / 10) * $verteidiger_techniken[$vert_id]['panzerung'])) / 10)).'</th>';


				$runde_schiffe_v[0][$vert_id][$schiff_id] = $schiffdaten['anzahl'];


				$schiffdaten_v[$vert_id][$schiff_id] =
						array(
							"w" => floor($pricelist[$schiff_id]['attack'] + (($pricelist[$schiff_id]['attack'] / 10) * $verteidiger_techniken[$vert_id]['waffen'])),
							"s" => floor($pricelist[$schiff_id]['shield'] + $pricelist[$schiff_id]['shield'] * $verteidiger_techniken[$vert_id]['schilde'] / 10),
							"p" => floor((($pricelist[$schiff_id]['metal'] + $pricelist[$schiff_id]['crystal']) + ((($pricelist[$schiff_id]['metal'] + $pricelist[$schiff_id]['crystal']) / 10) * $verteidiger_techniken[$vert_id]['panzerung'])) / 10)
						);

				if ($schiff_id > 400 && $schiff_id < 500) {
					$startdef[$schiff_id] = $schiffdaten['anzahl'];
				}

				if ($zahl_add != '') {
					$schiffdaten['anzahl'] -= $zuviel;
				}

				for ($i = 0; $i < $schiffdaten['anzahl']; $i++) {
					$schiffe_v[] = array(
						"a" => $vert_id,
						"b" => $schiff_id,
						"s" => floor($pricelist[$schiff_id]['shield'] + $pricelist[$schiff_id]['shield'] * $verteidiger_techniken[$vert_id]['schilde'] / 10),
						"p" => floor((($pricelist[$schiff_id]['metal'] + $pricelist[$schiff_id]['crystal']) + ((($pricelist[$schiff_id]['metal'] + $pricelist[$schiff_id]['crystal']) / 10) * $verteidiger_techniken[$vert_id]['panzerung'])) / 10)
						);
				}

			}

			if (!empty($namen)) {

				$kb .= '<table border=1>
						<tr>
							<th>'.$lang['kb_typ'].'</th>'.$namen.'
						</tr>
						<tr>
							<th>'.$lang['kb_anzahl'].'</th>'.$anzahlen.'
						</tr>
						<tr>
							<th>'.$lang['kb_bewaff'].'</th>'.$bewaffnungen.'
						</tr>
						<tr>
							<th>'.$lang['kb_schilde'].'</th>'.$schilde.'
						</tr>
						<tr>
							<th>'.$lang['kb_huelle'].'</th>'.$huellen.'
						</tr>
				</table>';


			}
			else {


				$vernichtet_v[] = $vert_id;

				$kb .= '<br>'.$lang['kb_killed'];


			}


		$kb .= '
				</center>
			</th>';

		}

	}


	$kb .= '		</tr>
	</table>';



	// LET'S FIGHT!!!


	$kampf = array();

	for ($runde = 0; $runde < 7; $runde++) {


		if ($runde > 0) {



			$runde_schiffe_a = array();
			$runde_schiffe_v = array();



			$kb .= '
	<table border=1 width=100%>
		<tr>';

			$tmp = $schiffe_a;
			unset($schiffe_a);


			$schiffe_a = array();

			foreach ($tmp as $id => $array) {
					$schiffe_a[] = array(
						"a" => $array['a'],
						"b" => $array['b'],
						"s" => $schiffdaten_a[$array['a']][$array['b']]['s'],
						"p" => $array['p'],
						);

					$runde_schiffe_a[$runde][$array['a']][$array['b']]++;

			}

			unset($tmp);


			foreach ($angreifer_daten as $owner => $array) {
				$kb .= '
			<th>
				<br>
				<center>
					'.$lang['kb_angreifer'].' '.$angreifer_daten[$owner]['name'].' (['.$angreifer_daten[$owner]['koords'].'])

					';


				$namen = '';
				$anzahlen = '';
				$bewaffnungen = '';
				$schilde = '';
				$huellen = '';

				if (count($runde_schiffe_a[$runde][$owner]) >= 1) {
					foreach ($runde_schiffe_a[$runde][$owner] as $schiffid => $anzahl) {


						$name = $lang['kb_names'][$schiffid];

						if (empty($name))
							$name = "N/A";

						$namen .= '<th>'.$name.'</th>';
						$anzahlen .= '<th>'.pretty_number($anzahl).'</th>';
						$bewaffnungen .= '<th>'.pretty_number(floor($pricelist[$schiffid]['attack'] + (($pricelist[$schiffid]['attack'] / 10) * $angreifer_techniken[$owner]['waffen']))).'</th>';
						$schilde .= '<th>'.pretty_number(floor($pricelist[$schiffid]['shield'] + (($pricelist[$schiffid]['shield'] / 10) * $angreifer_techniken[$owner]['schilde']))).'</th>';
						$huellen .= '<th>'.pretty_number(floor((($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal']) + ((($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal']) / 10) * $angreifer_techniken[$owner]['panzerung'])) / 10)).'</th>';

					}
				}



				if (!empty($namen)) {

					$kb .= '
					<table border=1>
						<tr>
							<th>'.$lang['kb_typ'].'</th>'.$namen.'
						</tr>
						<tr>
							<th>'.$lang['kb_anzahl'].'</th>'.$anzahlen.'
						</tr>
						<tr>
							<th>'.$lang['kb_bewaff'].'</th>'.$bewaffnungen.'
						</tr>
						<tr>
							<th>'.$lang['kb_schilde'].'</th>'.$schilde.'
						</tr>
						<tr>
							<th>'.$lang['kb_huelle'].'</th>'.$huellen.'
						</tr>
					</table>
				';


				}
				else {

					$vernichtet_a[] = $owner;

					if (!isset($infos_a[$owner]))
						$kb .= '<br>'.$lang['kb_killed'];
					elseif ($infos_a[$owner] == 1)
						$kb .= '<br>'.$lang['kb_ausgesetzt'];
					else
						$kb .= '<br>'.$lang['kb_ausgesetzt_teil'];
				}


				$kb .= '
				</center>
			</th>
				';

			}

			$kb .= '
		</tr>
	</table>';


			$tmp = $schiffe_v;
			unset($schiffe_v);
			$schiffe_v = array();
			foreach ($tmp as $id => $array) {
					$schiffe_v[] = array(
						"a" => $array['a'],
						"b" => $array['b'],
						"s" => $schiffdaten_v[$array['a']][$array['b']]['s'],
						"p" => $array['p'],
						);

					$runde_schiffe_v[$runde][$array['a']][$array['b']]++;

			}

			unset($tmp);

	$kb .= '
	<table border=1 width=100%>
		<tr>';


			foreach ($verteidiger_daten as $owner => $array) {
				$kb .= '
			<th>
				<br>
				<center>
					'.$lang['kb_verteidiger'].' '.$verteidiger_daten[$owner]['name'].' (['.$verteidiger_daten[$owner]['koords'].'])

					';


				$namen = '';
				$anzahlen = '';
				$bewaffnungen = '';
				$schilde = '';
				$huellen = '';

				if (count($runde_schiffe_v[$runde][$owner]) >= 1) {
					foreach ($runde_schiffe_v[$runde][$owner] as $schiffid => $anzahl) {


						$name = $lang['kb_names'][$schiffid];

						if (empty($name))
							$name = "N/A";

						$namen .= '<th>'.$name.'</th>';
						$anzahlen .= '<th>'.pretty_number($anzahl).'</th>';
						$bewaffnungen .= '<th>'.pretty_number(floor($pricelist[$schiffid]['attack'] + (($pricelist[$schiffid]['attack'] / 10) * $verteidiger_techniken[$owner]['waffen']))).'</th>';
						$schilde .= '<th>'.pretty_number(floor($pricelist[$schiffid]['shield'] + (($pricelist[$schiffid]['shield'] / 10) * $verteidiger_techniken[$owner]['schilde']))).'</th>';
						$huellen .= '<th>'.pretty_number(floor((($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal']) + ((($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal']) / 10) * $verteidiger_techniken[$owner]['panzerung'])) / 10)).'</th>';

					}

				}


				if (!empty($namen)) {

					$kb .= '
					<table border=1>
						<tr>
							<th>'.$lang['kb_typ'].'</th>'.$namen.'
						</tr>
						<tr>
							<th>'.$lang['kb_anzahl'].'</th>'.$anzahlen.'
						</tr>
						<tr>
							<th>'.$lang['kb_bewaff'].'</th>'.$bewaffnungen.'
						</tr>
						<tr>
							<th>'.$lang['kb_schilde'].'</th>'.$schilde.'
						</tr>
						<tr>
							<th>'.$lang['kb_huelle'].'</th>'.$huellen.'
						</tr>
					</table>
				';


				}
				else {

					$vernichtet_v[] = $owner;

					if (!isset($infos_v[$owner]))
						$kb .= '<br>'.$lang['kb_killed'];
					elseif ($infos_v[$owner] == 1)
						$kb .= '<br>'.$lang['kb_ausgesetzt'];
					else
						$kb .= '<br>'.$lang['kb_ausgesetzt_teil'];

				}


				$kb .= '
				</center>
			</th>
				';

			}

			$kb .= '
		</tr>
	</table>';






		}



		if (count($schiffe_v) <= 0 || count($schiffe_a) <= 0) {


			if (count($schiffe_v) <= 0 AND count($schiffe_a) <= 0) { // :-P Ich weiss, kann aber trotzdem mal eintreten
				$kampf['ausgang'] = 0;
			}
			elseif (count($schiffe_v) <= 0) {
				$kampf['ausgang'] = 1;
			}
			elseif (count($schiffe_a) <= 0) {
				$kampf['ausgang'] = 2;
			}
			else
				$kampf['ausgang'] = 0; // Sollte gar nicht mehr möglich sein.



			break; // So, Kampf fetig ;-)

		}


		if ($runde != 6) {


			// Der eigentliche Kampf ...

			$killed_a = array();
			$killed_v = array();

			$kampf[$runde]['angriff_a'] = 0; // Anzahl Schüsse des Angreifers
			$kampf[$runde]['angriff_v'] = 0; // Anzahl Schüsse des Verteidigers
			$kampf[$runde]['angriffwert_a'] = 0; // Gesamtstärke Angreifer
			$kampf[$runde]['angriffwert_v'] = 0; // Gesamtstärke Verteidiger
			$kampf[$runde]['schilde_a'] = 0; // Schadenverhinderung durch Schilde des Angreifers
			$kampf[$runde]['schilde_v'] = 0; // Schadenverhinderung durch Schilde des Verteidigers


			for ($j = 0; $j < count($schiffe_a); $j++) {

				$schiff = $schiffe_a[$j]; // Schiffdaten

				$owner = $schiff['a']; // Inhaber des Schiffs (Array-ID)
				$schiffid = $schiff['b']; // SchiffID (UGamela-ID)
				$fire = true; // Feuer zulassen

				while ($fire) {

					$fire = false; // Feuer verbieten

					$rand = mt_rand(0, (count($schiffe_v)-1)); // Schiff auswählen
					$zielschiff = $schiffe_v[$rand]; // Zielschiffdaten

					if (isset($pricelist[$schiff['b']]['sd'][$zielschiff['b']])) { // Falls das Schiff gegen das Zielschiff RapidFire hat, darf es ev. nochmals schiessen

						$rapidfire = @(100 * ($pricelist[$schiff['b']]['sd'][$zielschiff['b']] - 1) / $pricelist[$schiff['b']]['sd'][$zielschiff['b']]);

						$zufall = mt_rand(1, 100); // Natürlich alles Zufall...

						if ($zufall <= $rapidfire)
							$fire = true; // Feuer zulassen, da RapidFire
					}

					$angriffswert = $schiffdaten_a[$owner][$schiffid]['w']; // Angriffswert des Schiffes

					$kampf[$runde]['angriff_a']++; // Schusszahl erhöhen
					$kampf[$runde]['angriffwert_a'] += $angriffswert; // Gesamtstärke erhöhen

					if ($angriffswert < ($schiffdaten_v[$zielschiff['a']][$zielschiff['b']]['s'] / 100) AND $zielschiff['s'] > 0) { // 1%-Regel
						$kampf[$runde]['schilde_v'] += $angriffswert; // Schaden durch Schilde abgehalten updaten
						/* 
						http://owiki.de/1%25-Regel
						---
						Wenn bei einem Schuss der Schaden, den eine Einheit erleidet,
						geringer ist als 1% des Schildes des Verteidigers,
						so wird der Schuss ignoriert und beschädigt den Schild nicht.
						*/
					}
					elseif ($angriffswert <= $zielschiff['s']) {
						$kampf[$runde]['schilde_v'] += $angriffswert;
						$zielschiff['s'] -= $angriffswert;

						$schiffe_v[$rand] = $zielschiff; // Zielschiffdaten updaten
					}
					elseif ($angriffswert >= $zielschiff['s']) {

						$restschaden = ($angriffswert - $zielschiff['s']);

						$kampf[$runde]['schilde_v'] += $zielschiff['s'];
						
						$zielschiff['s'] = 0;

						$zielschiff['p'] -= $restschaden;
						if ($zielschiff['p'] < 0)
							$zielschiff['p'] = 0;

						$maxhuelle = $schiffdaten_v[$zielschiff['a']][$zielschiff['b']]['p'];

						if (($maxhuelle * 0.7) >= $zielschiff['p']) {

							$zufall = mt_rand(1,100);

							$prozent = ceil(100 - ($zielschiff['p'] / ($maxhuelle / 100)));

							if ($zufall <= $prozent) {
								if (!in_array($rand, $killed_v)) {
									$killed_v[] = $rand;
								}
							}
						}

						$schiffe_v[$rand] = $zielschiff; // Zielschiffdaten updaten

					}
				}
			}





			for ($j = 0; $j < count($schiffe_v); $j++) {

				$schiff = $schiffe_v[$j]; // Schiffdaten

				$owner = $schiff['a']; // Inhaber des Schiffs (Array-ID)
				$schiffid = $schiff['b']; // SchiffID (UGamela-ID)
				$fire = true; // Feuer zulassen

				while ($fire) {

					$fire = false; // Feuer verbieten

					$rand = mt_rand(0, (count($schiffe_a)-1)); // Schiff auswählen
					$zielschiff = $schiffe_a[$rand]; // Zielschiffdaten

					if (isset($pricelist[$schiff['b']]['sd'][$zielschiff['b']])) { // Falls das Schiff gegen das Zielschiff RapidFire hat, darf es ev. nochmals schiessen

						$rapidfire = @(100 * ($pricelist[$schiff['b']]['sd'][$zielschiff['b']] - 1) / $pricelist[$schiff['b']]['sd'][$zielschiff['b']]);

						$zufall = mt_rand(1, 100); // Natürlich alles Zufall...

						if ($zufall <= $rapidfire)
							$fire = true; // Feuer zulassen, da RapidFire
					}

					$angriffswert = $schiffdaten_v[$owner][$schiffid]['w']; // Angriffswert des Schiffes

					$kampf[$runde]['angriff_v']++; // Schusszahl erhöhen
					$kampf[$runde]['angriffwert_v'] += $angriffswert; // Gesamtstärke erhöhen

					if ($angriffswert < ($schiffdaten_a[$zielschiff['a']][$zielschiff['b']]['s'] / 100) AND $zielschiff['s'] > 0) { // 1%-Regel
						$kampf[$runde]['schilde_a'] += $angriffswert; // Schaden durch Schilde abgehalten updaten
						/* 
						http://owiki.de/1%25-Regel
						---
						Wenn bei einem Schuss der Schaden, den eine Einheit erleidet,
						geringer ist als 1% des Schildes des Verteidigers,
						so wird der Schuss ignoriert und beschädigt den Schild nicht.
						*/
					}
					elseif ($angriffswert <= $zielschiff['s']) {
						$kampf[$runde]['schilde_a'] += $angriffswert;
						$zielschiff['s'] -= $angriffswert;

						$schiffe_a[$rand] = $zielschiff; // Zielschiffdaten updaten
					}
					elseif ($angriffswert >= $zielschiff['s']) {

						$restschaden = ($angriffswert - $zielschiff['s']);

						$kampf[$runde]['schilde_a'] += $zielschiff['s'];
						
						$zielschiff['s'] = 0;

						$zielschiff['p'] -= $restschaden;
						if ($zielschiff['p'] < 0)
							$zielschiff['p'] = 0;

						$maxhuelle = $schiffdaten_a[$zielschiff['a']][$zielschiff['b']]['p'];

						if (($maxhuelle * 0.7) >= $zielschiff['p']) {

							$zufall = mt_rand(1,100);

							$prozent = ceil(100 - ($zielschiff['p'] / ($maxhuelle / 100)));

							if ($zufall <= $prozent) {
								if (!in_array($rand, $killed_a)) {
									$killed_a[] = $rand;
								}
							}
						}

						$schiffe_a[$rand] = $zielschiff; // Zielschiffdaten updaten

					}
				}
			}


			for ($i = 0; $i < count($killed_a); $i++) {
				$id = $killed_a[$i];
				$schiffid = $schiffe_a[$id]['b'];
				$kampf['units_a'] += ($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal'] + $pricelist[$schiffid]['deuterium']);

				if ($schiffid > 200 && $schiffid < 300) {
					$kampf['tf_met'] += ($pricelist[$schiffid]['metal'] * 0.6);
					$kampf['tf_kris'] += ($pricelist[$schiffid]['crystal'] * 0.6);


					$shipdelete_a[$schiffe_a[$id]['a']][$schiffid]++;

				}

				unset($schiffe_a[$id]);

			}


			for ($i = 0; $i < count($killed_v); $i++) {
				$id = $killed_v[$i];
				$schiffid = $schiffe_v[$id]['b'];
				$kampf['units_v'] += ($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal'] + $pricelist[$schiffid]['deuterium']);

				if ($schiffid > 200 && $schiffid < 300) {
					$kampf['tf_met'] += ($pricelist[$schiffid]['metal'] * 0.6);
					$kampf['tf_kris'] += ($pricelist[$schiffid]['crystal'] * 0.6);


					$shipdelete_v[$schiffe_v[$id]['a']][$schiffid]++;

				}
				elseif ($schiffid > 400 && $schiffid < 500) {
					$zufall = mt_rand(0, 100);
					if ($zufall > 70) {
						$def_delte[$schiffid]++;

					}
					else {
						$def_repaired[$schiffid]++;
					}
				}

				unset($schiffe_v[$id]);

			}


			$status1 = str_replace("%a", pretty_number($kampf[$runde]['angriff_a']), $lang['kb_status1']);
			$status1 = str_replace("%g", pretty_number($kampf[$runde]['angriffwert_a']), $status1);
			$status1 = str_replace("%s", pretty_number($kampf[$runde]['schilde_v']), $status1);

			$status2 = str_replace("%a", pretty_number($kampf[$runde]['angriff_v']), $lang['kb_status2']);
			$status2 = str_replace("%g", pretty_number($kampf[$runde]['angriffwert_v']), $status2);
			$status2 = str_replace("%s", pretty_number($kampf[$runde]['schilde_a']), $status2);

			$kb .= '<br>
	<center>
		'.$status1.'
		<br>
		'.$status2.'
	</center>';


		}

	}

	$return['angreifer_schiffe'] = array();
	$return['verteidiger_schiffe'] = array();

	if (count($schiffe_a) > 0) {
		foreach ($schiffe_a as $id => $array) {
			$owner = $array['a'];
			$schiffid = $array['b'];
			$return['angreifer_schiffe'][$owner][$schiffid]++;
		}
	}

	if (count($schiffe_v) > 0) {
		foreach ($schiffe_v as $id => $array) {
			$owner = $array['a'];
			$schiffid = $array['b'];
			if ($schiffid < 300 && $schiffid > 200)
				$return['verteidiger_schiffe'][$owner][$schiffid]++;
		}
	}

	unset($schiffe_a);
	unset($schiffe_v);



	if ($kampf['ausgang'] == 1) {
		$kb .= '<p>'.$lang['kb_win_a'];
	}
	elseif ($kampf['ausgang'] == 2) {
		$kb .= '<p>'.$lang['kb_win_v'];
	}
	else {
		$kb .= '<p>'.$lang['kb_win_na'];
	}

	$killed_def = array();

	if (count($def_repaired) >= 1) {

		arsort($def_repaired);

		$list = '';

		foreach ($def_repaired as $id => $anzahl) {
			if (!empty($list))
				$list .= ", ";


			$list .= "<b>".pretty_number($anzahl)."</b> ".$lang['tech'][$id];

		}

		$repairlist = str_replace("%list", $list, $lang['kb_repair']);

	}


	$units_a = str_replace("%u", pretty_number($kampf['units_a']), $lang['kb_units_a']);
	$units_v = str_replace("%u", pretty_number($kampf['units_v']), $lang['kb_units_v']);



	$lang_tf = str_replace("%m", pretty_number($kampf['tf_met']), $lang['kb_tf']);
	$lang_tf = str_replace("%k", pretty_number($kampf['tf_kris']), $lang_tf);


        $mondchance = floor(($kampf['tf_met'] + $kampf['tf_kris']) / 100000);



	if ($mondchance > 20)
		$mondchance = 20;
	elseif ($mondchance < 0)
		$mondchance = 0;

	if ($mondchance > 0 && !$mond) {
		$mond = "<br>".str_replace("%c", $mondchance, $lang['kb_tf_moon'])."<br>";

		$zufall = mt_rand(1,100);

		if ($zufall <= $mondchance) {
			$mond .= $lang['kb_moon']."<br>";
			$return['mond'] = true;

			$mondsize = 0;

			if ($mondchance == 20) {
				$mondsize = mt_rand(8000, 8944); // km

			}
			else {
				$mondsize = mt_rand(4000, 8944); // km

			}

			$return['mondsize'] = $mondsize;

		}
		else {
			$mond .= "<br>";
			$return['mond'] = false;
		}

	}
	else {
		$mond = '<br>';
		$return['mond'] = false;
	}


	$beute = array();

	$beute_text = '';
	$gesamtbeute = array();

	if ($kampf['ausgang'] == 1) {

		$max_met = ($ressis['metall'] / 2);
		$max_kris = ($ressis['kristall'] / 2);
		$max_deut = ($ressis['deuterium'] / 2);

		$oneprozent = ($gesamtcap / 100);

		$g_met = 0;
		$g_kris = 0;
		$g_deut = 0;


		foreach ($ladekapazitaet as $angrid => $cap) {

			$prozent = ($cap / $oneprozent); // Anzahl Prozent vom Kuchen

			$u_max_met = floor(($max_met / 100) * $prozent);
			$u_max_kris = floor(($max_kris / 100) * $prozent);
			$u_max_deut = floor(($max_deut / 100) * $prozent);
			$gesamt = ($u_max_met + $u_max_kris + $u_max_deut);

			if ($gesamt <= $cap) {
				$beute[$angrid] = array('m' => $u_max_met, 'k' => $u_max_kris, 'd' => $u_max_deut);
				$g_met += $u_max_met;
				$g_kris += $u_max_kris;
				$g_deut += $u_max_deut;
			}
			else {

				$restcap = $cap;
				$met = 0;
				$kris = 0;
				$deut = 0;
				$weiterladen = true;

				while ($weiterladen == true) {
					$weiterladen = false;

					$drittel = ($restcap / 3);

					if ($u_max_met > 0) {
						if ($drittel > $u_max_met) {
							$met += floor($u_max_met);
							$restcap -= floor($u_max_met);
							$u_max_met = 0;
						}
						else {
							$met += floor($drittel);
							$restcap -= floor($drittel);
							$u_max_met -= floor($drittel);
						}
					}

					$halb = ($restcap / 2);

					if ($u_max_kris > 0) {
						if ($halb > $u_max_kris) {
							$kris += floor($u_max_kris);
							$restcap -= floor($u_max_kris);
							$u_max_kris = 0;
						}
						else {
							$kris += floor($halb);
							$restcap -= floor($halb);
							$u_max_kris -= floor($halb);
						}
					}

					if ($u_max_deut > 0) {
						if ($restcap > $u_max_deut) {
							$deut += floor($u_max_deut);
							$restcap -= floor($u_max_deut);
							$u_max_deut = 0;
						}
						else {
							$deut += floor($restcap);
							$restcap -= floor($restcap);
							$u_max_deut -= floor($restcap);
						}
					}

					if ($restcap > 3 && $u_max_met > 2 && $u_max_kris > 2 && $u_max_deut > 2)
						$weiterladen = true;

				}

				$beute[$angrid] = array('m' => $met, 'k' => $kris, 'd' => $deut);	

				$g_met += $met;
				$g_kris += $kris;
				$g_deut += $deut;


		

			}
		}


		$gesamtbeute['m'] = $g_met;
		$gesamtbeute['k'] = $g_kris;
		$gesamtbeute['d'] = $g_deut;

		$beute_text = '<br>'.str_replace("%m", pretty_number($g_met), $lang['kb_beute']);
		$beute_text = str_replace("%c", pretty_number($g_kris), $beute_text);
		$beute_text = str_replace("%d", pretty_number($g_deut), $beute_text);
		$beute_text .= '<br>';
	}


	// START: DON'T REMOVE THIS COPYRIGHT!
	$footer = "<p>UGamela (".VERSION.") Fight System - Script by UGamela Deutsch Member <b>-= MoF =-</b></p>";
	$footer.= "<p>Kampfsystem an XNova angepasst by RedFighter</p>";
	// END: DON'T REMOVE THIS COPYRIGHT!

	$endzeit_benchmark = explode(' ', microtime());

	$totalzeit_benchmark = $endzeit_benchmark[0] + $endzeit_benchmark[1] - ($startzeit_benchmark[1] + $startzeit_benchmark[0]);
	$totaltime = ($totalzeit_benchmark * 1000);
	$totalzeit_benchmark = round($totalzeit_benchmark, 5);


	$kb .= '	'.$beute_text.'<br><br>
	<!-- Generation Time: '.$totalzeit_benchmark.'s - Script by UGamela Deutsch Member -= MoF =- Version: '.VERSION.' -->
	<br>
	'.$units_a.'
	<br>
	'.$units_v.'
	<br>
	'.$lang_tf.$mond.'
	';

	$return['ausgabe_angreifer'] = $kb.$footer.'		
    </td>

   </tr>
</table>';


	$return['ausgabe_verteidiger'] = $kb.
				$repairlist.'<br>
		'.$footer.'
	<br>
    </td>

   </tr>
</table>
';


	sort($vernichtet_a);
	sort($vernichtet_v);


	$hashes = array();
	$hashes['md5_angreifer'] = md5($return['ausgabe_angreifer']);
	$hashes['sha1_angreifer'] = sha1($return['ausgabe_angreifer']);
	$hashes['double_angreifer'] = $hashes['sha1_angreifer'].$hashes['md5_angreifer'];

	$hashes['md5_verteidiger'] = md5($return['ausgabe_verteidiger']);
	$hashes['sha1_verteidiger'] = sha1($return['ausgabe_verteidiger']);
	$hashes['double_verteidiger'] = $hashes['sha1_verteidiger'].$hashes['md5_verteidiger'];

	$return['hashes'] = $hashes;
	$return['delete'] = $def_delte;
	$return['tf'] = array("m" => $kampf['tf_met'], "k" => $kampf['tf_kris']);
	$return['units'] = array("a" => $kampf['units_a'], "v" => $kampf['units_v']);
	$return['ausgang'] = $kampf['ausgang'];
	$return['beute'] = $beute;
	$return['g_beute'] = $gesamtbeute;
	$return['vernichtet'] = array("a" => $vernichtet_a, "v" => $vernichtet_v);

	return $return;

 }



?>