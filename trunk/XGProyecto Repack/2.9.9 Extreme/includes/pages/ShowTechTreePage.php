<?php 

############################################################################## 
# *                                                                             # 
# * XG PROYECT                                                                 # 
# *                                                                           # 
# * @copyright Copyright (C) 2008 - 2009 By lucky from xgproyect.net           # 
# *                                                                             # 
# *                                                                             # 
# *  This program is free software: you can redistribute it and/or modify    # 
# *  it under the terms of the GNU General Public License as published by    # 
# *  the Free Software Foundation, either version 3 of the License, or       # 
# *  (at your option) any later version.                                     # 
# *                                                                             # 
# *  This program is distributed in the hope that it will be useful,         # 
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of             # 
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             # 
# *  GNU General Public License for more details.                             # 
# *                                                                             # 
############################################################################## 

if(!defined('INSIDE')){ die(header("location:../../"));} 

function ShowTechTreePage($CurrentUser, $CurrentPlanet) 
{ 
    global $resource, $requeriments, $lang; 

    $parse = $lang; 

    foreach($lang['tech'] as $Element => $ElementName) 
    { 
        $parse            = array(); 
        $parse['tt_name'] = $ElementName; 
        $parse['dpath']        = $dpath.'./styles/skins/evolution/gebaeude/'; 
        $parse['ext'] = 'gif'; 

        if (!isset($resource[$Element])) 
        { 
            $parse['level']         = $lang['tt_level']; 
            $parse['Requirements']  = $lang['tt_requirements'];
            $parse['image']  = $lang['tt_image'];
            $page                  .= parsetemplate(gettemplate('techtree/techtree_head'), $parse); 
        } 
        else 
        { 
     
        if (isset($requeriments[$Element])) 
            { 
                $parse['required_name'] = ""; 
                foreach($requeriments[$Element] as $ResClass => $Level) 
                { 
                    if( isset($CurrentUser[$resource[$ResClass]] ) && $CurrentUser[$resource[$ResClass]] >= $Level) 

                        $parse['required_name'] .= "<font color=\"#00ff00\">"; 
                    elseif ( isset($CurrentPlanet[$resource[$ResClass]] ) && $CurrentPlanet[$resource[$ResClass]] >= $Level) 
                        $parse['required_name'] .= "<font color=\"#00ff00\">"; 


                    else 
                     

                    $parse['required_name'] .= "<font color=\"#ff0000\">"; 
                    $parse['required_name'] .= "".$lang['tech'][$ResClass]." - ".$Level.""; 
                    $parse['required_name'] .= "</font><br>"; 
                }; 
            } 
            else 
            { 
                $parse['required_name'] = "-"; 
                $parse['tt_detail']     = ""; 
            } 
             
                    if (isset($requeriments[$Element])) 
            { 
                $parse['required_have'] = ""; 
                foreach($requeriments[$Element] as $ResClass => $Level) 
                { 
                    if( isset($CurrentUser[$resource[$ResClass]] ) && $CurrentUser[$resource[$ResClass]] >= $Level) 

                        $parse['required_have'] .= "<font color=\"#00ff00\">"; 
                    elseif ( isset($CurrentPlanet[$resource[$ResClass]] ) && $CurrentPlanet[$resource[$ResClass]] >= $Level) 
                        $parse['required_have'] .= "<font color=\"#00ff00\">"; 


                    else 
                     

                    $parse['required_have'] .= "<font color=\"#ff0000\">"; 
                    $parse['required_have'] .= "".$CurrentUser[$resource[$ResClass]]." ".$CurrentPlanet[$resource[$ResClass]].""; 
                    $parse['required_have'] .= "</font><br>"; 
                }; 
            } 
            else 
            { 
                $parse['required_have'] = "-"; 
                $parse['tt_detail']     = ""; 
            } 
             
            $parse['tt_info']   = $Element; 
            $page              .= parsetemplate(gettemplate('techtree/techtree_row'), $parse); 
        } 
    } 

 $parse['techtree_list'] = $page; 

    return display(parsetemplate(gettemplate('techtree/techtree_body'), $parse)); 
} 

?> 