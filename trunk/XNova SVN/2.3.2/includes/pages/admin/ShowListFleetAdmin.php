<?php
//version 1
function ShowListFleetAdmin(){
	global $lang,$db,$svn_root, $displays,$users;
		if ($users->user['authlevel'] < 3){ die($displays->message ($lang['not_enough_permissions']));}
                global $resource,$requeriments,$pricelist,$CombatCaps,$reslist;

                
		$displays->assignContent('adm/list_fleet');

                $list=array_merge($reslist['fleet'], $reslist['defense']);
                foreach($list as $id){
                  
                    if($id=="502" || $id=="503"){continue;}
                    $displays->newBlock("list_fleet");
                    if(in_array($id,$reslist['fleet'])){
                        $displays->assign("tipo","Flota");
                    }elseif(in_array($id,$reslist['defense'])){
                        $displays->assign("tipo","Defensa");
                    }

                    $displays->assign("nombres",$lang['tech_rc'][$id]);
                    $displays->assign("metals",$pricelist[$id]["metal"]);
                    $displays->assign("cristals",$pricelist[$id]["crystal"]);
                    $displays->assign("deuterios",$pricelist[$id]["deuterium"]);
                   
                }
                $displays->display();

}
?>