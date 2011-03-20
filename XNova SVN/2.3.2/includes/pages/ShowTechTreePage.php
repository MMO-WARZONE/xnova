<?php
//version 1


if(!defined('INSIDE')){ die(header("location:../../"));}


function ShowTechTreePage($CurrentUser, $CurrentPlanet)
{
	global $resource, $requeriments, $lang,$svn_root,$displays;
        
	$displays->assignContent('/techtree/techtree');
	
        foreach($lang['tech'] as $Element => $ElementName)
		{
		$parse            = array();
		$parse['tt_name'] = $ElementName;
		if (!isset($resource[$Element]))
		{
                        $displays->newBlock("name");
			$parse['Requirements']  = $lang['tt_requirements'];
			foreach($parse as $name => $trans){
                            $displays->assign($name, $trans);
                        }
		}
		else
		{
                        $displays->newBlock("requeriments");
			if (isset($requeriments[$Element]))
			{
				$parse['required_list'] = "";
				foreach($requeriments[$Element] as $ResClass => $Level)
				{
					if( isset($CurrentUser[$resource[$ResClass]] ) && $CurrentUser[$resource[$ResClass]] >= $Level)
						$parse['required_list'] .= "<font color=\"#00ff00\">";
					elseif ( isset($CurrentPlanet[$resource[$ResClass]] ) && $CurrentPlanet[$resource[$ResClass]] >= $Level)
						$parse['required_list'] .= "<font color=\"#00ff00\">";
					else
						$parse['required_list'] .= "<font color=\"#ff0000\">";

					$parse['required_list'] .= $lang['tech'][$ResClass] ." (". $lang['tt_lvl'] . $Level .")";
					$parse['required_list'] .= "</font><br>";
				};
			}
			else
			{
				$parse['required_list'] = "";
				$parse['tt_detail']     = "";
			}
			$parse['tt_info']   = $Element;
			foreach($parse as $name => $trans){
                                    $displays->assign($name, $trans);
                        }
		}
	}
	unset($lang);
	
	$displays->display('Tecnologia');
}
?>