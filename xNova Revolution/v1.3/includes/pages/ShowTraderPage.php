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

function ShowTraderPage($CurrentUser, $CurrentPlanet)
{
	global $phpEx, $lang;

	$parse = $lang;

	if($CurrentPlanet['darkmatter'] < TR_DARK_MATTER)
	{
		message(str_replace('%s',TR_DARK_MATTER,$lang['tr_darkmatter_needed']), '', '', true);
		die();
	}

	if (isset($_POST['ress']) && $_POST['ress'] != '')
	{
		switch ($_POST['ress'])
		{
			case 'metal':
			{
				if ($_POST['cristal'] < 0 or $_POST['deut'] < 0)
				{
					message($lang['tr_only_positive_numbers'], "game." . $phpEx . "?page=trader",1);
				}
				else
				{
					$necessaire   = (($_POST['cristal'] * 2) + ($_POST['deut'] * 4));

					if ($CurrentPlanet['metal'] > $necessaire)
					{
						$QryUpdatePlanet  = "UPDATE {{table}} SET ";
						$QryUpdatePlanet .= "`metal` = `metal` - ".round($necessaire).", ";
						$QryUpdatePlanet .= "`crystal` = `crystal` + ".round($_POST['cristal']).", ";
						$QryUpdatePlanet .= "`deuterium` = `deuterium` + ".round($_POST['deut'])." ";
						$QryUpdatePlanet .= "WHERE ";
						$QryUpdatePlanet .= "`id` = '".$CurrentPlanet['id']."';";

						doquery($QryUpdatePlanet , 'planets');

						$planetrow['metal']     -= $necessaire;
						$CurrentPlanet['cristal']   += $_POST['cristal'];
						$CurrentPlanet['deuterium'] += $_POST['deut'];
						doquery("UPDATE `{{table}}` SET `darkmatter` = `darkmatter` - ".TR_DARK_MATTER." WHERE `id` = ".$CurrentUser['id']."", 'users');
					}
					else
					{
						message($lang['tr_not_enought_metal'], "game." . $phpEx . "?page=trader",1);
					}
				}
				break;
			}
			case 'cristal':
			{
				if ($_POST['metal'] < 0 or $_POST['deut'] < 0)
				{
					message($lang['tr_only_positive_numbers'], "game." . $phpEx . "?page=trader",1);
				}
				else
				{
					$necessaire   = ((abs($_POST['metal']) * 0.5) + (abs($_POST['deut']) * 2));

					if ($CurrentPlanet['crystal'] > $necessaire)
					{
						$QryUpdatePlanet  = "UPDATE {{table}} SET ";
						$QryUpdatePlanet .= "`metal` = `metal` + ".round($_POST['metal']).", ";
						$QryUpdatePlanet .= "`crystal` = `crystal` - ".round($necessaire).", ";
						$QryUpdatePlanet .= "`deuterium` = `deuterium` + ".round($_POST['deut'])." ";
						$QryUpdatePlanet .= "WHERE ";
						$QryUpdatePlanet .= "`id` = '".$CurrentPlanet['id']."';";

						doquery($QryUpdatePlanet , 'planets');

						$CurrentPlanet['metal']     += $_POST['metal'];
						$CurrentPlanet['cristal']   -= $necessaire;
						$CurrentPlanet['deuterium'] += $_POST['deut'];
						doquery("UPDATE `{{table}}` SET `darkmatter` = `darkmatter` - ".TR_DARK_MATTER." WHERE `id` = ".$CurrentPlanet['id']."", 'users');
					}
					else
					{
						message($lang['tr_not_enought_crystal'], "game." . $phpEx . "?page=trader",1);
					}
				}
				break;
			}
			case 'deuterium':
			{
				if ($_POST['cristal'] < 0 or $_POST['metal'] < 0)
				{
					message($lang['tr_only_positive_numbers'], "game." . $phpEx . "?page=trader",1);
				}
				else
				{
					$necessaire   = ((abs($_POST['metal']) * 0.25) + (abs($_POST['cristal']) * 0.5));

					if ($CurrentPlanet['deuterium'] > $necessaire)
					{
						$QryUpdatePlanet  = "UPDATE {{table}} SET ";
						$QryUpdatePlanet .= "`metal` = `metal` + ".round($_POST['metal']).", ";
						$QryUpdatePlanet .= "`crystal` = `crystal` + ".round($_POST['cristal']).", ";
						$QryUpdatePlanet .= "`deuterium` = `deuterium` - ".round($necessaire)." ";
						$QryUpdatePlanet .= "WHERE ";
						$QryUpdatePlanet .= "`id` = '".$CurrentPlanet['id']."';";

						doquery($QryUpdatePlanet , 'planets');

						$CurrentPlanet['metal']     += $_POST['metal'];
						$CurrentPlanet['cristal']   += $_POST['cristal'];
						$CurrentPlanet['deuterium'] -= $necessaire;
						doquery("UPDATE `{{table}}` SET `darkmatter` = `darkmatter` - ".TR_DARK_MATTER." WHERE `id` = ".$CurrentPlanet['id']."", 'users');
					}
					else
					{
						message($lang['tr_not_enought_deuterium'], "game." . $phpEx . "?page=trader",1);
					}
				}
				break;
			}
		}

		message($lang['tr_exchange_done'],"game." . $phpEx . "?page=trader",1);
	}
	else
	{
		if ($_POST['action'] != 2)
		{
			$template = gettemplate('trader/trader_main');
		}
		else
		{
			$parse['mod_ma_res'] = '1';

			switch ($_POST['choix'])
			{
				case 'metal':
				$template = gettemplate('trader/trader_metal');
				$parse['mod_ma_res_a'] = '2';
				$parse['mod_ma_res_b'] = '4';
				break;
				case 'cristal':
				$template = gettemplate('trader/trader_cristal');
				$parse['mod_ma_res_a'] = '0.5';
				$parse['mod_ma_res_b'] = '2';
				break;
				case 'deut':
				$template = gettemplate('trader/trader_deuterium');
				$parse['mod_ma_res_a'] = '0.25';
				$parse['mod_ma_res_b'] = '0.5';
				break;
			}
		}
	}

	return display(parsetemplate($template,$parse));
}
?>
