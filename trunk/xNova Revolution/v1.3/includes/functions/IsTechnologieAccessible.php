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

	function IsTechnologieAccessible($user, $planet, $Element)
	{
		global $requeriments, $resource;

		if (isset($requeriments[$Element]))
		{
			$enabled = true;

			foreach($requeriments[$Element] as $ReqElement => $EleLevel)
			{
				if (@$user[$resource[$ReqElement]] && $user[$resource[$ReqElement]] >= $EleLevel)
				{
					//BREAK
				}
				elseif ($planet[$resource[$ReqElement]] && $planet[$resource[$ReqElement]] >= $EleLevel)
				{
					$enabled = true;
				}
				else
				{
					return false;
				}
			}
			return $enabled;
		}
		else
		{
			return true;
		}
	}
?>
