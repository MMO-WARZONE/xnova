<?php
//version 1.1


if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowMarchandPage(&$CurrentPlanet)
{
	global $phpEx, $lang, $displays, $db;


	if (isset($_POST['ress']) && $_POST['ress'] != '')
	{
		switch ($_POST['ress'])
		{
			case 'metal':
			{
				if ($_POST['cristal'] < 0 or $_POST['deut'] < 0)
				{
					$displays->message($lang['tr_only_positive_numbers'], "game." . $phpEx . "?page=marchand",1);
				}
				else
				{
					$necessaire   = (($_POST['cristal'] * 2) + ($_POST['deut'] * 4));

					if ($CurrentPlanet['metal'] > $necessaire)
					{                                               
                                                $CurrentPlanet['crystal']   += $_POST['cristal'];
						$CurrentPlanet['deuterium'] += $_POST['deut'];
						$CurrentPlanet['metal']     -= $necessaire;
						
					}
					else
					{
						$displays->message($lang['tr_not_enought_metal'], "?page=marchand",1);
					}
				}
				break;
			}
			case 'cristal':
			{
				if ($_POST['metal'] < 0 or $_POST['deut'] < 0)
				{
					$displays->message($lang['tr_only_positive_numbers'], "?page=marchand",1);
				}
				else
				{
					$necessaire   = ((abs($_POST['metal']) * 0.5) + (abs($_POST['deut']) * 2));

					if ($CurrentPlanet['crystal'] > $necessaire)
					{
						$CurrentPlanet['metal']     += $_POST['metal'];
						$CurrentPlanet['crystal']   -= $necessaire;
						$CurrentPlanet['deuterium'] += $_POST['deut'];
					}
					else
					{
						$displays->message($lang['tr_not_enought_crystal'], "?page=marchand",1);
					}
				}
				break;
			}
			case 'deuterium':
			{
				if ($_POST['cristal'] < 0 or $_POST['metal'] < 0)
				{
					$displays->message($lang['tr_only_positive_numbers'], "?page=marchand",1);
				}
				else
				{
					$necessaire   = ((abs($_POST['metal']) * 0.25) + (abs($_POST['cristal']) * 0.5));

					if ($CurrentPlanet['deuterium'] > $necessaire)
					{
						$CurrentPlanet['metal']     += $_POST['metal'];
						$CurrentPlanet['crystal']   += $_POST['cristal'];
						$CurrentPlanet['deuterium'] -= $necessaire;
					}
					else
					{
						$displays->message($lang['tr_not_enought_deuterium'], "?page=marchand",1);
					}
				}
				break;
			}
		}

		$displays->message($lang['tr_exchange_done'],"game." . $phpEx . "?page=marchand",10,true,true);
	}
	else
	{
		if ($_POST['action'] != 2)
		{
                          $displays->assignContent("marchand/marchand_main");

		}
		else
		{
			$lang['mod_ma_res'] = '1';

			switch ($_POST['choix'])
			{
				case 'metal':
                          $displays->assignContent("marchand/marchand_metal");
				$lang['mod_ma_res_a'] = '2';
				$lang['mod_ma_res_b'] = '4';
				break;
				case 'cristal':
                          $displays->assignContent("marchand/marchand_cristal");
				$lang['mod_ma_res_a'] = '0.5';
				$lang['mod_ma_res_b'] = '2';
				break;
				case 'deut':
                          $displays->assignContent("marchand/marchand_deuterium");
				$lang['mod_ma_res_a'] = '0.25';
				$lang['mod_ma_res_b'] = '0.5';
				break;
			}
		}
	}

        $displays->display();

}
?>