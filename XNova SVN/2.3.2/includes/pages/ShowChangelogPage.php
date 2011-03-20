<?php
//version 1.1


if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowChangelogPage()
{
    if($_POST){
	global $lang,$displays,$db;

	includeLang('CHANGELOG');
	
	//$displays->assignContent('changelog');
        $displays->TemplatePower($svn_root . TEMPLATE_DIR  . "changelog".$displays->tpl );
        $displays->prepare();
	foreach($lang['changelog'] as $a => $b)
	{
		$displays->newBlock("version");
                if($a == $db->game_config["VERSION"]){
                    $parse['version_number'] = "<span style=\"color:red\">".$a."</span>";
                }else{
                    $parse['version_number'] = $a;
                }
		
		$parse['description'] = nl2br($b);
		foreach($parse as $name => $trans){
                        $displays->assign($name, $trans);
                }
	}
        $displays->getOutputContent();
        $displays->printToScreen();
        //$displays->display('Changelog');
    }else{
        header("location: ?page=overview");
    }
	
}
?>