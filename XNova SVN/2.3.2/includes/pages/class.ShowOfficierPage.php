<?php
//version 1


if(!defined('INSIDE')){ die(header("location:../../"));}

class ShowOfficierPages
{
	private function IsOfficierAccessible ($CurrentUser, $Officier)
	{
		global $requeriments, $resource, $pricelist;

		if (isset($requeriments[$Officier]))
		{
			$enabled = true;
			foreach($requeriments[$Officier] as $ReqOfficier => $OfficierLevel)
			{
				if ($CurrentUser[$resource[$ReqOfficier]] && $CurrentUser[$resource[$ReqOfficier]] >= $OfficierLevel)
				{
					$enabled = 1;
				}
				else
				{
					return 0;
				}
			}
		}
		if ($CurrentUser[$resource[$Officier]] < $pricelist[$Officier]['max']  )
		{
			return 1;
		}
		else
		{
			return -1;
		}
	}

	public function ShowOfficierPage ( &$CurrentUser )
	{
		global $resource, $reslist, $lang, $pricelist,$db,$displays;

		$displays->assignContent("officier/officier_table");
		if ($_GET['mode'] == 2)
		{
			if ((floor($CurrentUser['darkmatter'] / 1000)) > 0)
			{
				$Selected    = $_GET['offi'];
				if ( in_array($Selected, $reslist['officier']) )
				{
					$Result = $this->IsOfficierAccessible ( $CurrentUser, $Selected );

					if ( $Result == 1 )
					{
						$CurrentUser[$resource[$Selected]] += 1;
						$CurrentUser['darkmatter']         -= 1000;

						$QryUpdateUser  = "UPDATE {{table}} SET ";
						$QryUpdateUser .= "`darkmatter` = '". $CurrentUser['darkmatter'] ."', ";
						$QryUpdateUser .= "`".$resource[$Selected]."` = '". $CurrentUser[$resource[$Selected]] ."' ";
						$QryUpdateUser .= "WHERE ";
						$QryUpdateUser .= "`id` = '". $CurrentUser['id'] ."';";
						$db->query( $QryUpdateUser, 'users' );
					}
					elseif ( $Result == -1 )
					{
						header("location:game.php?page=officier");
					}
					elseif ( $Result == 0 )
					{
						header("location:game.php?page=officier");
					}
				}
			}
			else
			{
				header("location:game.php?page=officier");
			}

			header("location:game.php?page=officier");

		}
		else
		{
			$parse['alv_points']   	= floor($CurrentUser['darkmatter'] / 1000);
			$i=0;
			foreach($reslist['officier'] as $Element)
			{
				
				$Result = $this->IsOfficierAccessible ($CurrentUser, $Element);
				if ($Result != 0 )
				{
                                        $displays->newblock("oficier");
					$i++;
					
					$bloc['off_id']       = $Element;
					if ($Result == 1 && $parse['alv_points'] >= 1)
					{
						
						$bloc['off_link'] = "<a href=\"game.php?page=officier&mode=2&offi=".$Element."\">";//<font color=\"#00ff00\">".$lang['of_recruit']."</font>";
						$bloc['off_link2'] = "</a>";
					}
					elseif($Result == 1 && $parse['alv_points'] == 0)
					{
						$bloc['off_link'] = "";
						$bloc['off_link2'] = "";
					}
					else
					{
						$bloc['off_link'] = "";
						$bloc['off_link2'] = "";
					}
					
					if($i%3==0){
						$bloc["p"] = "</tr><tr>";
					}

					$bloc['case_barre'] = ($CurrentUser[$resource[$Element]] / $pricelist[$Element]['max'])* 120 ;
					
					if ($bloc['case_barre'] >= 120) {
					   $bloc['case_barre'] = 120;
					   $bloc['case_barre_barcolor'] = '#C00000';
					} else {
					   $bloc['case_barre_barcolor'] = '#00C000';
					}
   
					$bloc["barra"]='<div align=left   style="border: 1px solid rgb(255, 255, 250); width: 120px;">
                                            <div align=center  id="CaseBarre" style="background-color: '.$bloc['case_barre_barcolor'].'; width: '.$bloc['case_barre'].'px;"><font color="#FFFFFF">'.$CurrentUser[$resource[$Element]].'</font>&nbsp;</div></div>';
						
					
					$bloc["onclick2"]=" style=\"cursor: pointer;text-align:  center;\" onmouseover='return overlib(\"<table width=500><tr><td class=k style= border:1px; colspan=2>".$lang['res']['descriptions'][$Element]."</td></tr></table>\", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );' onmouseout=\"return nd();\" ";
					
					foreach ($bloc as $key => $value) {
                                            $displays->assign($key,$value);
                                        }
                                        unset($bloc);
				}
			}
		}

		$displays->display();
	}
}
?>