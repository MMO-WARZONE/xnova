<?php
/*
#############################################################################
#  Filename: raketenangriff.php
#  Create date: Friday, April 04, 2008    04:54:58
#  Project: prethOgame
#  Description: RPG web based game
#
#  Copyright © 2008 Aleksandar Spasojevic <spalekg@gmail.com>
#  Copyright © 2005 - 2008 KGsystem
#############################################################################
*/
function raketenangriff($verteidiger_panzerung, $angreifer_waffen, $iraks, $def, $primaerziel = '0') {
   // Variablen initialisieren
   $temp = '';
   $temp2 = '';

   $def[11] = $iraks;

   $metall     = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
   $kristall   = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
   $deut       = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
   $verblieben = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

   for($temp = 0; $temp < 11; $temp++) {
      $verblieben[$temp] = $def[$temp];
   }

   $kaputt = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

   $hull = Array();

   $hull[0] = 200 * ((1 + $verteidiger_panzerung) / 10);
   $hull[1] = $hull[0];
   $hull[2] = 800 * ((1 + $verteidiger_panzerung) / 10);
   $hull[3] = 3500 * ((1 + $verteidiger_panzerung) / 10);
   $hull[4] = $hull[2];
   $hull[5] = 10000 * ((1 + $verteidiger_panzerung) / 10);
   $hull[6] = 2000 * ((1 + $verteidiger_panzerung) / 10);
   $hull[7] = $hull[5];
   $hull[8] = 1500 * ((1 + $verteidiger_panzerung) / 10);
   $hull[9] = 15000 * ((1 + $verteidiger_panzerung) / 10);
   $hull[10] = 15000 * ((1 + $verteidiger_panzerung) / 10);

   $metall_cost_tab   = Array( 2, 1.5, 6, 20, 2, 50, 10, 50, 12.5, 8);
   $kristall_cost_tab = Array( 0, 0.5, 2, 15, 6, 50, 10, 50,  2.5, 0);
   $deut_cost_tab     = Array( 0,   0, 0,  2, 0, 30,  0,  0, 10.0, 2);

   $schaden = floor(($def[11] - $def[10]) * (12000 * ((1 + $angreifer_waffen) / 10)));
   if ($schaden < 0)
      $schaden = 0;

   switch ($primaerziel) {
      case 0:
         $beschussreihenfolge = Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
         break;
      case 1:
         $beschussreihenfolge = Array(1, 0, 2, 3, 4, 5, 6, 7, 8, 9, 10);
         break;
      case 2:
         $beschussreihenfolge = Array(2, 0, 1, 3, 4, 5, 6, 7, 8, 9, 10);
         break;
      case 3:
         $beschussreihenfolge = Array(3, 0, 1, 2, 4, 5, 6, 7, 8, 9, 10);
         break;
      case 4:
         $beschussreihenfolge = Array(4, 0, 1, 2, 3, 5, 6, 7, 8, 9, 10);
         break;
      case 5:
         $beschussreihenfolge = Array(5, 0, 1, 2, 3, 4, 6, 7, 8, 9, 10);
         break;
      case 6:
         $beschussreihenfolge = Array(6, 0, 1, 2, 3, 4, 5, 7, 8, 9, 10);
         break;
      case 7:
         $beschussreihenfolge = Array(7, 0, 1, 2, 3, 4, 5, 6, 8, 9, 10);
         break;
      case 8:
         $beschussreihenfolge = Array(8, 0, 1, 2, 3, 4, 5, 6, 7, 9, 10);
         break;
	  case 9:
         $beschussreihenfolge = Array(9, 0, 1, 2, 3, 4, 5, 6, 7, 8, 10);
         break;
	  case 10:
         $beschussreihenfolge = Array(10, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
         break;
   }
   // Simulation
   // das Einfachste: I-Raks und Abfangraks ausrechnen...
   $verblieben[11] = 0;
   $kaputt[11] += $def[11];
   $metall[11] += $kaputt[11] * $metall_cost_tab[8];
   $kristall[11] += $kaputt[11] * $kristall_cost_tab[8];
   $deut[11] += $kaputt[11] * $deut_cost_tab[8];

   $verblieben[10] = ($def[10] - $def[11]);
   if ($verblieben[10] < 0)
      $verblieben[10] = 0;

   $kaputt[12] = $def[10] - $verblieben[10];
   $kaputt[10] += ($def[10] - $verblieben[10]);
   $metall[10] += $kaputt[10] * $metall_cost_tab[10];
   $kristall[10] += $kaputt[10] * $kristall_cost_tab[10];
   $deut[10] += $kaputt[10] * $deut_cost_tab[10];
   $metall[12] += $metall[10];
   $kristall[12] += $kristall[10];
   $deut[12] += $deut[10];
   // und jetzt der Reihe nach alles ABKNALLEN!!!
   for($temp = 0; $temp < 10; $temp++) {
      if ($schaden >= ($hull[$beschussreihenfolge[$temp]] * $def[$beschussreihenfolge[$temp]])) {
         $kaputt[$beschussreihenfolge[$temp]] += $def[$beschussreihenfolge[$temp]];

         $verblieben[$beschussreihenfolge[$temp]] = 0;

         $schaden -= ($hull[$beschussreihenfolge[$temp]] * $kaputt[$beschussreihenfolge[$temp]]);
      } else {
         $kaputt[$beschussreihenfolge[$temp]] += floor($schaden / $hull[$beschussreihenfolge[$temp]]);

         $schaden -= $kaputt[$beschussreihenfolge[$temp]] * $hull[$beschussreihenfolge[$temp]];

         $verblieben[$beschussreihenfolge[$temp]] = ($def[$beschussreihenfolge[$temp]] - $kaputt[$beschussreihenfolge[$temp]]);
      }

      $metall[$beschussreihenfolge[$temp]] += $kaputt[$beschussreihenfolge[$temp]] * $metall_cost_tab[$beschussreihenfolge[$temp]];
      $kristall[$beschussreihenfolge[$temp]] += $kaputt[$beschussreihenfolge[$temp]] * $kristall_cost_tab[$beschussreihenfolge[$temp]];
      $deut[$beschussreihenfolge[$temp]] += $kaputt[$beschussreihenfolge[$temp]] * $deut_cost_tab[$beschussreihenfolge[$temp]];

      $verblieben[12] += $verblieben[$beschussreihenfolge[$temp]];
      $kaputt[12] += $kaputt[$beschussreihenfolge[$temp]];
      $metall[12] += $metall[$beschussreihenfolge[$temp]];
      $kristall[12] += $kristall[$beschussreihenfolge[$temp]];
      $deut[12] += $deut[$beschussreihenfolge[$temp]];
   }

   $return = array();

   $return['verbleibt'] = $verblieben; // Übrige Def
   $return['zerstoert'] = $kaputt; // Zerstörte Def
   $return['verluste_metall'] = $metall; // Gesamtverluste Metall
   $return['verluste_kristall'] = $kristall; // Gesamtverluste Kristall
   $return['verluste_deuterium'] = $deut; // Gesamtverluste Deuterium

   return $return;
}
?>