<?php
/*
#############################################################################
#  Filename: GetMissileRange.php
#  Create date: Friday, May 30, 2008    22:24:15
#  Project: prethOgame
#  Description: RPG web based game
#
#  Copyright © 2008 Aleksandar Spasojevic <spalekg@gmail.com>
#  Copyright © 2005 - 2008 KGsystem
#############################################################################
*/

function GetMissileRange () {
   global $resource, $user;

   if ($user[$resource[117]] > 0) {
      $MissileRange = ($user[$resource[117]] * 2) - 1;
   } elseif ($user[$resource[117]] == 0) {
      $MissileRange = 0;
   }

   return $MissileRange;
}

?>