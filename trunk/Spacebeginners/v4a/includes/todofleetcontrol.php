<?php

/**
  * todofleetcontrol.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

// Galaxy
include($xnova_root_path . 'includes/functions/galaxy/InsertGalaxyScripts.'              .$phpEx);
include($xnova_root_path . 'includes/functions/galaxy/GalaxyRowPos.'                     .$phpEx);
include($xnova_root_path . 'includes/functions/galaxy/GalaxyRowPlanet.'                  .$phpEx);
include($xnova_root_path . 'includes/functions/galaxy/GalaxyRowPlanetName.'              .$phpEx);
include($xnova_root_path . 'includes/functions/galaxy/GalaxyRowMoon.'                    .$phpEx);
include($xnova_root_path . 'includes/functions/galaxy/GalaxyRowDebris.'                  .$phpEx);
include($xnova_root_path . 'includes/functions/galaxy/GalaxyRowUser.'                    .$phpEx);
include($xnova_root_path . 'includes/functions/galaxy/GalaxyRowAlly.'                    .$phpEx);
include($xnova_root_path . 'includes/functions/galaxy/GalaxyRowActions.'                 .$phpEx);
include($xnova_root_path . 'includes/functions/galaxy/GalaxyCheckFunctions.'             .$phpEx);
include($xnova_root_path . 'includes/functions/galaxy/GalaxyLegendPopup.'                .$phpEx);
include($xnova_root_path . 'includes/functions/galaxy/ShowGalaxySelector.'               .$phpEx);
include($xnova_root_path . 'includes/functions/galaxy/ShowGalaxyMISelector.'             .$phpEx);
include($xnova_root_path . 'includes/functions/galaxy/ShowGalaxyFooter.'                 .$phpEx);
include($xnova_root_path . 'includes/functions/galaxy/ShowGalaxyRows.'                   .$phpEx);

//Overview
include($xnova_root_path . 'includes/functions/uebersicht/Countdown.'                    .$phpEx);
include($xnova_root_path . 'includes/functions/uebersicht/BuildFleetEventTable.'         .$phpEx);
include($xnova_root_path . 'includes/functions/uebersicht/InsertJavaScriptChronoApplet.'.$phpEx);


include($xnova_root_path . 'includes/functions/FlyingFleetHandler.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseAttack.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseACS.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseStay.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseStayAlly.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseTransport.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseSpy.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseRecycling.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseDestruction.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseColonisation.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissionCaseExpedition.'.$phpEx);
include($xnova_root_path . 'includes/functions/MissileAttack.'.$phpEx);
include($xnova_root_path . 'includes/functions/SendSimpleMessage.'.$phpEx);
include($xnova_root_path . 'includes/functions/SpyTarget.'.$phpEx);
include($xnova_root_path . 'includes/functions/RestoreFleetToPlanet.'.$phpEx);
include($xnova_root_path . 'includes/functions/StoreGoodsToPlanet.'.$phpEx);
include($xnova_root_path . 'includes/functions/CheckPlanetBuildingQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/CheckPlanetUsedFields.'.$phpEx);
include($xnova_root_path . 'includes/functions/CreateOneMoonRecord.'.$phpEx);
include($xnova_root_path . 'includes/functions/CreateOnePlanetRecord.'.$phpEx);

include($xnova_root_path . 'includes/functions/IsTechnologieAccessible.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetBuildingTime.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetRestPrice.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetElementPrice.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetBuildingPrice.'.$phpEx);
include($xnova_root_path . 'includes/functions/IsElementBuyable.'.$phpEx);
include($xnova_root_path . 'includes/functions/CheckCookies.'.$phpEx);
include($xnova_root_path . 'includes/functions/ChekUser.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetPhalanxRange.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetMissileRange.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetMaxConstructibleElements.'.$phpEx);
include($xnova_root_path . 'includes/functions/GetElementRessources.'.$phpEx);
include($xnova_root_path . 'includes/functions/ElementBuildListBox.'.$phpEx);
include($xnova_root_path . 'includes/functions/ElementBuildListQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/FleetBuildingPage.'.$phpEx);
include($xnova_root_path . 'includes/functions/DefensesBuildingPage.'.$phpEx);
include($xnova_root_path . 'includes/functions/ResearchBuildingPage.'.$phpEx);
include($xnova_root_path . 'includes/functions/BatimentBuildingPage.'.$phpEx);
include($xnova_root_path . 'includes/functions/CheckLabSettingsInQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/InsertBuildListScript.'.$phpEx);
include($xnova_root_path . 'includes/functions/AddBuildingToQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/ShowBuildingQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/HandleTechnologieBuild.'.$phpEx);
include($xnova_root_path . 'includes/functions/BuildingSavePlanetRecord.'.$phpEx);
include($xnova_root_path . 'includes/functions/BuildingSaveUserRecord.'.$phpEx);
include($xnova_root_path . 'includes/functions/RemoveBuildingFromQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/CancelBuildingFromQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/SetNextQueueElementOnTop.'.$phpEx);
include($xnova_root_path . 'includes/functions/ShowTopNavigationBar.'.$phpEx);
include($xnova_root_path . 'includes/functions/SetSelectedPlanet.'.$phpEx);
include($xnova_root_path . 'includes/functions/MessageForm.'.$phpEx);
include($xnova_root_path . 'includes/functions/PlanetResourceUpdate.'.$phpEx);
include($xnova_root_path . 'includes/functions/Piratenangriff.'.$phpEx);
include($xnova_root_path . 'includes/functions/BuildFlyingFleetTable.'.$phpEx);
include($xnova_root_path . 'includes/functions/SendNewPassword.'.$phpEx);
include($xnova_root_path . 'includes/functions/HandleElementBuildingQueue.'.$phpEx);
include($xnova_root_path . 'includes/functions/UpdatePlanetBatimentQueueList.'.$phpEx);
include($xnova_root_path . 'includes/functions/IsOfficierAccessible.'.$phpEx);
include($xnova_root_path . 'includes/functions/CheckInputStrings.'.$phpEx);
include($xnova_root_path . 'includes/functions/MipCombatEngine.'.$phpEx);
include($xnova_root_path . 'includes/functions/DeleteSelectedUser.'.$phpEx);
include($xnova_root_path . 'includes/functions/SortUserPlanets.'.$phpEx);

include($xnova_root_path . 'includes/functions/ResetThisFuckingCheater.'.$phpEx);
include($xnova_root_path . 'includes/functions/IsVacationMode.'.$phpEx);
include($xnova_root_path . 'includes/calculateAttack.'.$phpEx);
include($xnova_root_path . 'includes/formatCR.'.$phpEx);



?>