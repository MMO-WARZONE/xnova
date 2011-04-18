<?php

/**
 * galaxy.php
 *
 * @version 1.3
 * @copyright 2008 by Chlorel for XNova
 */

	includeLang('galaxy');

	$CurrentPlanet = $planetrow;
	$Query = $DB->query("SELECT * FROM `".PREFIX."lunas` WHERE `id` = '". $user['current_luna'] ."'");
	$galaxyrow = $Query->fetch();

	$dpath         = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
	$fleetmax      = $user['computer_tech'] + 1;
	$CurrentPlID   = $CurrentPlanet['id'];
	$CurrentMIP    = $CurrentPlanet['interplanetary_misil'];
	$CurrentRC     = $CurrentPlanet['recycler'];
	$CurrentSP     = $CurrentPlanet['spy_sonde'];
	$HavePhalanx   = $CurrentPlanet['phalanx'];
	$CurrentSystem = $CurrentPlanet['system'];
	$CurrentGalaxy = $CurrentPlanet['galaxy'];
	$CanDestroy    = $CurrentPlanet[$resource[213]] + $CurrentPlanet[$resource[214]];

	$Query = $DB->query("SELECT * FROM `".PREFIX."fleets` WHERE `fleet_owner` = '". $user['id'] ."'");
	$maxfleet_count = sql_num_rows($Query);

	CheckPlanetUsedFields($CurrentPlanet);
	CheckPlanetUsedFields($lunarow);

	//$_GET->mode überprüfen
	if (!isset($mode)) {
		if (isset($_GET['mode'])) {
			$mode          = intval($_GET['mode']);
		} else {
			//Falls nicht gegeben: 0
			$mode          = 0;
		}
	}

	if ($mode == 0) {
		$galaxy        = $CurrentPlanet['galaxy'];
		$system        = $CurrentPlanet['system'];
		$planet        = $CurrentPlanet['planet'];
	} elseif ($mode == 1) {
		// On vient du selecteur de galaxie
		// Il nous poste :
		// $_POST['galaxy']      => Galaxie affichée dans la case a saisir
		// $_POST['galaxyLeft']  => <- A ete cliqué
		// $_POST['galaxyRight'] => -> A ete cliqué
		// $_POST['system']      => Systeme affiché dans la case a saisir
		// $_POST['systemLeft']  => <- A ete cliqué
		// $_POST['systemRight'] => -> A ete cliqué

		if ($_POST["galaxyLeft"]) {
			if ($_POST["galaxy"] < 1) {
				$_POST["galaxy"] = 1;
				$galaxy          = 1;
			} elseif ($_POST["galaxy"] == 1) {
				$_POST["galaxy"] = 1;
				$galaxy          = 1;
			} else {
				$galaxy = $_POST["galaxy"] - 1;
			}
		} elseif ($_POST["galaxyRight"]) {
			if ($_POST["galaxy"]      > MAX_GALAXY_IN_WORLD) {
				$_POST["galaxy"]      = MAX_GALAXY_IN_WORLD;
				$galaxy               = MAX_GALAXY_IN_WORLD;
			} elseif ($_POST["galaxy"] == MAX_GALAXY_IN_WORLD) {
				$_POST["galaxy"]      = MAX_GALAXY_IN_WORLD;
				$galaxy               = MAX_GALAXY_IN_WORLD;
			} else {
				$galaxy = $_POST["galaxy"] + 1;
			}
		} else {
			$galaxy = $_POST["galaxy"];
		}

		if ($_POST["systemLeft"]) {
			if ($_POST["system"] < 1) {
				$_POST["system"] = 1;
				$system          = 1;
			} elseif ($_POST["system"] == 1) {
				$_POST["system"] = 1;
				$system          = 1;
			} else {
				$system = $_POST["system"] - 1;
			}
		} elseif ($_POST["systemRight"]) {
			if ($_POST["system"]      > MAX_SYSTEM_IN_GALAXY) {
				$_POST["system"]      = MAX_SYSTEM_IN_GALAXY;
				$system               = MAX_SYSTEM_IN_GALAXY;
			} elseif ($_POST["system"] == MAX_SYSTEM_IN_GALAXY) {
				$_POST["system"]      = MAX_SYSTEM_IN_GALAXY;
				$system               = MAX_SYSTEM_IN_GALAXY;
			} else {
				$system = $_POST["system"] + 1;
			}
		} else {
			$system = $_POST["system"];
		}
	} elseif ($mode == 2) {
		// Mais c'est qu'il mordrait !
		// A t'on idée de vouloir lancer des MIP sur ce pauvre bonhomme !!

		$galaxy        = $_GET['galaxy'];
		$system        = $_GET['system'];
		$planet        = $_GET['planet'];
	} elseif ($mode == 3) {
		// Appel depuis un menu avec uniquement galaxy et system de passé !
		$galaxy        = $_GET['galaxy'];
		$system        = $_GET['system'];
	} else {
		// Si j'arrive ici ...
		// C'est qu'il y a vraiment eu un bug
		$galaxy        = 1;
		$system        = 1;
	}

	$planetcount = 0;
	$lunacount   = 0;

	$page  = InsertGalaxyScripts ( $CurrentPlanet );

	$page .= "<body style=\"overflow: hidden;\" onUnload=\"\"><br><br>";
	$page .= ShowGalaxySelector ( $galaxy, $system );

	if ($mode == 2) {
		$CurrentPlanetID = $_GET['current'];
		$page .= ShowGalaxyMISelector ( $galaxy, $system, $planet, $CurrentPlanetID, $CurrentMIP );
	}

	$page .= "<table width=700><tbody>";

	$page .= ShowGalaxyTitles ( $galaxy, $system );
    $page .= ShowGalaxyRows   ( $galaxy, $system );
    $page .= ShowGalaxyFooter ( $galaxy, $system,  $CurrentMIP, $CurrentRC, $CurrentSP);

	$page .= "</tbody></table></div>";

	display ($page, 'Galaxie', false, '', false);

?>