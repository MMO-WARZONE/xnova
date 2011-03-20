<?php

function CheckAbandonMoonState ($lunarow) {
	if (($lunarow['destruyed'] + 172800) <= time() && $lunarow['destruyed'] != 0) {
		$query = doquery("DELETE FROM {{table}} WHERE id = '" . $lunarow['id'] . "'", "lunas");
	}
}

function CheckAbandonPlanetState ($planet) {
   if ($planet['destruyed'] <= time()) {
      doquery("DELETE FROM {{table}} WHERE id={$planet['id']}", 'planets');
      doquery("DELETE FROM {{table}} WHERE id_planet={$planet['id']}", 'galaxy');
   }
}

?>