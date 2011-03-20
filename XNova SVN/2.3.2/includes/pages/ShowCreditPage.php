<?php

function ShowCreditPage()
{
	global $phpEx,$displays,$svn_root,$creditos;

	$displays->assignContent("credit");
	$parse["proyect_leader"]            =$creditos["proyect_leader"];
        
        $contribut=explode(",",$creditos["principal_contributors"]);
        foreach($contribut as $a){
            $parse["principal_contributors"]    .=$a."<br>";
        }
        $special=explode(",",$creditos["special_thanks"]);
        foreach($special as $a){
            $parse["special_thanks"]    .=$a."<br>";
        }


        foreach($parse as $name => $trans){
            $displays->assign($name, $trans);
        }
        $displays->display("Creditos");
}
?>