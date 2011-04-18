<?php

/**
  * GalaxyCheckFunctions.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function CheckAbandonMoonState ($lunarow) {

    if (($lunarow['destruyed'] + 172800) <= time() && $lunarow['destruyed'] != 0) {
        $query = doquery("DELETE FROM {{table}} WHERE id = '" . $lunarow['id'] . "'", "lunas");
    }
}

function CheckAbandonPlanetState (&$planet) {

    if ($planet['destruyed'] <= time()) {
        doquery("DELETE FROM {{table}} WHERE id={$planet['id']}", 'planets');
        doquery("UPDATE {{table}} SET id_planet=0 WHERE id_planet={$planet['id']}", 'galaxy');
    }
}

?>