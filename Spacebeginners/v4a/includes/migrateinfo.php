<?php

/**
 * migrateinfo.php
 *
 * @version 1.0
 * @copyright 2008 By e-Zobar for XNova
 */

$QryMigrate = array(
"ALTER TABLE `{{prefix}}fleets` ADD COLUMN `fleet_end_stay` int(11) NOT NULL default '0';"
);

?>