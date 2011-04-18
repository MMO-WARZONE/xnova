<?php
/**
 * todofleetcontrol.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs für XNova-Germany
 * http://www.xnova-germany.org
 */

if(!defined("INSIDE")){ die("attemp hacking"); }

// Fonctions deja 'au propre'
include($ugamela_root_path . 'includes/functions/FlyingFleetHandler.'.$phpEx);
include($ugamela_root_path . 'includes/functions/MissionCaseAttack.'.$phpEx);
include($ugamela_root_path . 'includes/functions/MissionCaseStay.'.$phpEx);
include($ugamela_root_path . 'includes/functions/MissionCaseStayAlly.'.$phpEx);
include($ugamela_root_path . 'includes/functions/MissionCaseTransport.'.$phpEx);
include($ugamela_root_path . 'includes/functions/MissionCaseSpy.'.$phpEx);
include($ugamela_root_path . 'includes/functions/MissionCaseRecycling.'.$phpEx);
include($ugamela_root_path . 'includes/functions/MissionCaseDestruction.'.$phpEx);
include($ugamela_root_path . 'includes/functions/MissionCaseColonisation.'.$phpEx);
include($ugamela_root_path . 'includes/functions/MissionCaseExpedition.'.$phpEx);
include($ugamela_root_path . 'includes/functions/SendSimpleMessage.'.$phpEx);
//neu eingefügt bei Mwieners:
include($ugamela_root_path . 'includes/functions/SendSimpleMessage2.'.$phpEx);
//ende des neu eingefügten!
include($ugamela_root_path . 'includes/functions/SpyTarget.'.$phpEx);
include($ugamela_root_path . 'includes/functions/RestoreFleetToPlanet.'.$phpEx);
include($ugamela_root_path . 'includes/functions/StoreGoodsToPlanet.'.$phpEx);
include($ugamela_root_path . 'includes/functions/CheckPlanetBuildingQueue.'.$phpEx);
include($ugamela_root_path . 'includes/functions/CheckPlanetUsedFields.'.$phpEx);
include($ugamela_root_path . 'includes/functions/CreateOneMoonRecord.'.$phpEx);
include($ugamela_root_path . 'includes/functions/CreateOnePlanetRecord.'.$phpEx);
include($ugamela_root_path . 'includes/functions/InsertJavaScriptChronoApplet.'.$phpEx);
include($ugamela_root_path . 'includes/functions/IsTechnologieAccessible.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GetBuildingTime.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GetRestPrice.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GetElementPrice.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GetBuildingPrice.'.$phpEx);
include($ugamela_root_path . 'includes/functions/IsElementBuyable.'.$phpEx);
include($ugamela_root_path . 'includes/functions/CheckCookies.'.$phpEx);
include($ugamela_root_path . 'includes/functions/ChekUser.'.$phpEx);
include($ugamela_root_path . 'includes/functions/InsertGalaxyScripts.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GalaxyCheckFunctions.'.$phpEx);
include($ugamela_root_path . 'includes/functions/ShowGalaxyRows.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GetPhalanxRange.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GetMissileRange.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GalaxyRowPos.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GalaxyRowPlanet.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GalaxyRowPlanetName.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GalaxyRowMoon.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GalaxyRowDebris.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GalaxyRowUser.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GalaxyRowava.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GalaxyRowAlly.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GalaxyRowActions.'.$phpEx);
include($ugamela_root_path . 'includes/functions/ShowGalaxySelector.'.$phpEx);
include($ugamela_root_path . 'includes/functions/ShowGalaxyMISelector.'.$phpEx);
include($ugamela_root_path . 'includes/functions/ShowGalaxyTitles.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GalaxyLegendPopup.'.$phpEx);
include($ugamela_root_path . 'includes/functions/ShowGalaxyFooter.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GetMaxConstructibleElements.'.$phpEx);
include($ugamela_root_path . 'includes/functions/GetElementRessources.'.$phpEx);
include($ugamela_root_path . 'includes/functions/ElementBuildListBox.'.$phpEx);
include($ugamela_root_path . 'includes/functions/ElementBuildListQueue.'.$phpEx);
include($ugamela_root_path . 'includes/functions/FleetBuildingPage.'.$phpEx);
include($ugamela_root_path . 'includes/functions/DefensesBuildingPage.'.$phpEx);
include($ugamela_root_path . 'includes/functions/ResearchBuildingPage.'.$phpEx);
include($ugamela_root_path . 'includes/functions/BatimentBuildingPage.'.$phpEx);
include($ugamela_root_path . 'includes/functions/CheckLabSettingsInQueue.'.$phpEx);
include($ugamela_root_path . 'includes/functions/InsertBuildListScript.'.$phpEx);
include($ugamela_root_path . 'includes/functions/AddBuildingToQueue.'.$phpEx);
include($ugamela_root_path . 'includes/functions/ShowBuildingQueue.'.$phpEx);
include($ugamela_root_path . 'includes/functions/HandleTechnologieBuild.'.$phpEx);
include($ugamela_root_path . 'includes/functions/BuildingSavePlanetRecord.'.$phpEx);
include($ugamela_root_path . 'includes/functions/BuildingSaveUserRecord.'.$phpEx);
include($ugamela_root_path . 'includes/functions/RemoveBuildingFromQueue.'.$phpEx);
include($ugamela_root_path . 'includes/functions/CancelBuildingFromQueue.'.$phpEx);
include($ugamela_root_path . 'includes/functions/SetNextQueueElementOnTop.'.$phpEx);
include($ugamela_root_path . 'includes/functions/ShowTopNavigationBar.'.$phpEx);
include($ugamela_root_path . 'includes/functions/SetSelectedPlanet.'.$phpEx);
include($ugamela_root_path . 'includes/functions/MessageForm.'.$phpEx);
include($ugamela_root_path . 'includes/functions/PlanetResourceUpdate.'.$phpEx);
include($ugamela_root_path . 'includes/functions/BuildFlyingFleetTable.'.$phpEx);
include($ugamela_root_path . 'includes/functions/SendNewPassword.'.$phpEx);
include($ugamela_root_path . 'includes/functions/HandleElementBuildingQueue.'.$phpEx);
include($ugamela_root_path . 'includes/functions/UpdatePlanetBatimentQueueList.'.$phpEx);
include($ugamela_root_path . 'includes/functions/IsOfficierAccessible.'.$phpEx);
include($ugamela_root_path . 'includes/functions/CheckInputStrings.'.$phpEx);
include($ugamela_root_path . 'includes/functions/MipCombatEngine.'.$phpEx);
include($ugamela_root_path . 'includes/functions/DeleteSelectedUser.'.$phpEx);
include($ugamela_root_path . 'includes/functions/SortUserPlanets.'.$phpEx);
include($ugamela_root_path . 'includes/functions/BuildFleetEventTable.'.$phpEx);
include($ugamela_root_path . 'includes/functions/BuildRessourcePage.'.$phpEx);

?>