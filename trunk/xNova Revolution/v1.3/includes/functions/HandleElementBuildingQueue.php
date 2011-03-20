<?php

/*
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|
 @copyright:
Copyright (C) 2010 por Brayan Narvaez (principe negro)
Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar

@support:
Web http://www.xnovarevolution.com.ar/
Forum http://www.xnovarevolution.com.ar/foros/

Proyect based in xg proyect for xtreme gamez.
*/

if(!defined('INSIDE')){ die(header("location:../../"));}

	function HandleElementBuildingQueue ( $CurrentUser, &$CurrentPlanet, $ProductionTime )
	{
		global $resource;

		if ($CurrentPlanet['b_hangar_id'] != 0)
		{
			$Builded                    = array ();
			$CurrentPlanet['b_hangar'] += $ProductionTime;
			$BuildQueue                 = explode(';', $CurrentPlanet['b_hangar_id']);

			foreach ($BuildQueue as $Node => $Array)
			{
				if ($Array != '')
				{
					$Item              = explode(',', $Array);
					$AcumTime		   += GetBuildingTime ($CurrentUser, $CurrentPlanet, $Item[0]);
					$BuildArray[$Node] = array($Item[0], $Item[1], $AcumTime);
				}
			}

			$CurrentPlanet['b_hangar_id'] 	= '';
			$UnFinished 					= false;

			foreach ( $BuildArray as $Node => $Item )
			{
				if (!$UnFinished)
				{
					$Element   = $Item[0];
					$Count     = $Item[1];
					$BuildTime = $Item[2];
					while ( $CurrentPlanet['b_hangar'] >= $BuildTime && !$UnFinished )
					{
						if ( $Count > 0 )
						{
							$CurrentPlanet['b_hangar'] -= $BuildTime;
							$Builded[$Element]++;
							$CurrentPlanet[$resource[$Element]]++;
							$Count--;
							if ($Count == 0)
							{
								break;
							}
						}
						else
						{
							$UnFinished = true;
							break;
						}
					}
				}
				if ( $Count != 0 )
				{
					$CurrentPlanet['b_hangar_id'] .= $Element.",".$Count.";";
				}
			}
		}
		else
		{
			$Builded                   = '';
			$CurrentPlanet['b_hangar'] = 0;
		}

		return $Builded;
	}
?>
