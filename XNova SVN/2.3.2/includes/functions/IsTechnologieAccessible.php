<?php
//version 1


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