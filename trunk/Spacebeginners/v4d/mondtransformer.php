<?php

/**
  * Mondtransformer.php
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2010
  * @Team Space Beginner
  *
  **/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);
  
     global $_POST,$lang,$user;

	
		includeLang('infos');

		

		 $TransTPL  = gettemplate('mondtransformer');
		 $parse     = $lang;
		 
		 // Abfrage ob schon ein Mond exestiert?.
		     $CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user['current_planet'] ."'", 'planets', true);
			 $Galaxy    = $CurrentPlanet['galaxy'];
			 $System    = $CurrentPlanet['system'];
			 $Planet    = $CurrentPlanet['planet'];
			 
             $QryGetMoonGalaxyData  = "SELECT * FROM {{table}} ";
	         $QryGetMoonGalaxyData .= "WHERE ";
	         $QryGetMoonGalaxyData .= "`galaxy` = '". $Galaxy ."' AND ";
	         $QryGetMoonGalaxyData .= "`system` = '". $System ."' AND ";
	         $QryGetMoonGalaxyData .= "`planet` = '". $Planet ."';";
	         $MoonGalaxy = doquery ( $QryGetMoonGalaxyData, 'galaxy', true);
			 if ($MoonGalaxy['id_luna'] != 0 ) {
			 
			 message ($lang['moon_exist'] );
			 break;
			 }
		 // Abfrage ende
		 
		if ( $CurrentPlanet['mondtransformer'] == 1) {
			$Chance    = 20 ;
			$MoonName  = $_POST['name'];
			 if  (!ctype_alnum ($MoonName)){
             message ($lang['do_word_and_digit'] );
			 break;
		     }
			$Galaxy    = $CurrentPlanet['galaxy'];
			$System    = $CurrentPlanet['system'];
			$Planet    = $CurrentPlanet['planet'];
            $Owner     = $CurrentPlanet['id_owner'];
			$MoonID    = time();

			$NewOwnerMoon = CreateOneMoonRecord ( $Galaxy, $System, $Planet, $Owner, $MoonID, $MoonName, $Chance );

			message ($title ='', $lang['done'] );
			
		}

 
		$Page = parsetemplate($TransTPL, $parse);
		return  $Page;

		
	
	

?>