<?php
//version 1.3
class statfunction{
        var $select_defenses;
        var $select_buildings;
        var $selected_tech;
        var $select_fleets;
        var $start_time;

        //var $Ally_Fleet=array();
        //var $Ally_Defs=array();
        //var $Ally_Tech=array();
        //var $Ally_Build=array();
        //var $Ally_array=array();
        //var $Ally_rank=array();

        function  __construct() {
            global $resource,$reslist,$db;
            $this->stats_time   = time();

            //Carga la query de la defensa
            foreach($reslist['defense'] as $n => $Defense)
            {
                $this->select_defenses.= " SUM(p.".$resource[ $Defense ].") AS ".$resource[ $Defense ].",";
            }

            //Carga la query de la construciones
            foreach($reslist['build'] as $n => $Building)
            {
                $this->select_buildings	.= " p.".$resource[ $Building ].",";
            }

            //Carga la query de la tecnologia
            foreach($reslist['tech'] as $n => $Techno)
            {
                $this->selected_tech	.= " u.".$resource[ $Techno ].",";
            }

            //Carga la query de la flota
            foreach($reslist['fleet'] as $n => $Fleet)
            {
                $this->select_fleets	.= " SUM(p.".$resource[ $Fleet ].") AS ".$resource[ $Fleet ].",";
            }

            //NUMERO TOTAL DE USUARIOS.
            $count=$db->query("SELECT COUNT(*) AS `count` FROM {{table}};", 'users', true);

            $this->total_users=$count["count"];

        }
        function MakeStats(){
            global $db;
            // Initial Time
            $mtime        = microtime();
            $mtime        = explode(" ", $mtime);
            $mtime        = $mtime[1] + $mtime[0];
            $this->starttime    = $mtime;
            //Initial Memory
            $result['initial_memory']= array(round(memory_get_usage() / 1024,1),round(memory_get_usage(1) / 1024,1));

            $this->MakeStatsUser();
            if(is_array($this->Ally_array)){
                $this->MakeStatsAlian();
            }
            ///RESULTADO XD
            $mtime        = microtime();
            $mtime        = explode(" ", $mtime);
            $mtime        = $mtime[1] + $mtime[0];
            $this->endtime= $mtime;
            $result['stats_time']	= $this->stats_time;
            $result['totaltime']        = ($this->endtime - $this->starttime);
            $result['memory_peak']	= array(round(memory_get_peak_usage() / 1024,1),round(memory_get_peak_usage(1) / 1024,1));
            $result['end_memory']	= array(round(memory_get_usage() / 1024,1),round(memory_get_usage(1) / 1024,1));
            $result['amount_per_block']	= $db->game_config['stat_amount'];

            return $result;
        }

        private  function MakeStatsAlian(){
            global $db;

            //ARRAYS de las alianzas
            $Ally_Tech  =$this->Ally_Tech;
            $Ally_Defs  =$this->Ally_Defs;
            $Ally_Fleet =$this->Ally_Fleet;
            $Ally_Build =$this->Ally_Build;
            $Ally_array =$this->Ally_array;
            $Ally_rank  =$this->Ally_rank;

            //PUNTOS DE LA ALIANZA EN TECNOLOGIA
            arsort($Ally_Tech);
            $i=1;
            foreach ($Ally_Tech as $key => $val) {
                $Ally_Tech[$key]["rank"]=$i;
                ++$i;
            }

            //PUNTOS DE LA ALIANZA EN DEFENSA
            arsort($Ally_Defs);
            $i=1;
            foreach ($Ally_Defs as $key => $val) {
                $Ally_Defs[$key]["rank"]=$i;
                ++$i;
            }

            //PUNTOS DE LA ALIANZA EN FLOTA
            arsort($Ally_Fleet);
            $i=1;
            foreach ($Ally_Fleet as $key => $val) {
                $Ally_Fleet[$key]["rank"]=$i;
                ++$i;
            }

            //PUNTOS DE LA ALIANZA EN CONSTRUCION
            arsort($Ally_Build);
            $i=1;
            foreach ($Ally_Build as $key => $val) {
                $Ally_Build[$key]["rank"]=$i;
                ++$i;
            }

            //RANKIN DE LA ALIANZA
            arsort($Ally_rank);
            $i=1;
            foreach ($Ally_rank as $key => $val) {
                $rank[$key]=$i;
                ++$i;
            }

            //Borramos las alianzas sin usuarios
            $db->query("DELETE FROM {{table}} WHERE ally_members='0'", "alliance");
            $select_old_ranks= "s.id_ally, s.stat_type,s.tech_rank AS old_tech_rank, s.build_rank AS old_build_rank, s.defs_rank AS old_defs_rank, s.fleet_rank AS old_fleet_rank,s. total_rank AS old_total_rank";


            $sql_ally	=	'SELECT '.$select_old_ranks.' FROM {{table}} as s WHERE stat_type = 2 ;';
	    $ally_data	=	$db->query ($sql_ally,'statpoints');

            while ($CurAlly = mysql_fetch_assoc($ally_data))
            {
                    $ally_old_data[$CurAlly['id_ally']]=$CurAlly;
            }

            //SACAMOS TODAS LAS ALIANZAS
            $ally_check  = $db->query("SELECT `id` FROM {{table}}", 'alliance');

            while ($CurAlly = mysql_fetch_assoc($ally_check))
            {
                    //BUSCAMOS SI EXISTE LA ALIANZA EN LOS USUARIOS.
                    if(in_array($CurAlly['id'],$Ally_array)){

                        if($ally_old_data[$CurAlly['id']]){
                            $u_OldTotalRank = $ally_old_data[$CurAlly['id']]['old_total_rank'];
                            $u_OldTechRank  = $ally_old_data[$CurAlly['id']]['old_tech_rank'];
                            $u_OldBuildRank = $ally_old_data[$CurAlly['id']]['old_build_rank'];
                            $u_OldDefsRank  = $ally_old_data[$CurAlly['id']]['old_defs_rank'];
                            $u_OldFleetRank = $ally_old_data[$CurAlly['id']]['old_fleet_rank'];
                        }else{
                            $u_OldTotalRank = 0;
                            $u_OldTechRank  = 0;
                            $u_OldBuildRank = 0;
                            $u_OldDefsRank  = 0;
                            $u_OldFleetRank = 0;
                        }
                        $u_TTechCount     = $Ally_Tech[$CurAlly['id']]['count'];
                        $u_TTechPoints    = $Ally_Tech[$CurAlly['id']]['point'];
                        $u_TBuildCount    = $Ally_Build[$CurAlly['id']]['count'];
                        $u_TBuildPoints   = $Ally_Build[$CurAlly['id']]['point'];
                        $u_TDefsCount     = $Ally_Defs[$CurAlly['id']]['count'];
                        $u_TDefsPoints    = $Ally_Defs[$CurAlly['id']]['point'];
                        $u_TFleetCount    = $Ally_Fleet[$CurAlly['id']]['count'];
                        $u_TFleetPoints   = $Ally_Fleet[$CurAlly['id']]['point'];
                        $u_GCount         = $u_TDefsCount  + $u_TTechCount  + $u_TFleetCount  + $u_TBuildCount;
                        $u_GPoints        = $u_TTechPoints + $u_TDefsPoints + $u_TFleetPoints + $u_TBuildPoints;
                        $u_fleet_rank     = $Ally_Fleet[$CurAlly['id']]['rank'];
                        $u_defs_rank      = $Ally_Defs[$CurAlly['id']]['rank'];
                        $u_build_rank     = $Ally_Build[$CurAlly['id']]['rank'];
                        $u_tech_rank      = $Ally_Tech[$CurAlly['id']]['rank'];

                        $insert_ally__query[]  = '('.$CurAlly['id'].',0,2,1,'.$u_OldTechRank.',
                                                '.$u_TTechPoints.','.$u_TTechCount.','.$u_OldBuildRank.','.$u_TBuildPoints.',
                                                '.$u_TBuildCount.','.$u_OldDefsRank.','.$u_TDefsPoints.','.$u_TDefsCount.',
                                                '.$u_OldFleetRank.','.$u_TFleetPoints.','.$u_TFleetCount.','.$u_OldTotalRank.',
                                                '.$u_GPoints.','.$u_GCount.','.$this->stats_time.',
                                                '.$u_fleet_rank.','.$u_defs_rank.','.$u_build_rank.','.$u_tech_rank.','.$rank[$CurAlly['id']].'),' ;

                        unset_vars( 'u_' );

                    }else{
                        //BORRAMOS ALIANZAS SIN NINGUN USUARIO VINCULADA A ELLA.
                        $db->query("DELETE FROM {{table}} WHERE id='{$CurAlly['id']}'", "alliance");
                    }
                    //unset($Ally_Tech[$CurAlly['id']],$Ally_Defs[$CurAlly['id']],$Ally_Fleet[$CurAlly['id']],$Ally_Build[$CurAlly['id']],$CurAlly);
            }
            //unset($Ally_Tech,$Ally_Defs,$Ally_Fleet,$Ally_Build);

            //BORRAMOS LAS ANTIGUAS ESTADISTICAS
            $db->query ( "DELETE FROM {{table}} WHERE `stat_type` = '2';" , 'statpoints');
            //INSERTAMOS LAS NUEVAS ESTADISTICAS
            $this->NewQueryStats(count($insert_ally__query),$insert_ally__query);


        }

        


        private function MakeStatsUser(){
            global $db;
            $select_planet	= "p.id_owner";
            $select_old_ranks	= "s.id_owner, s.stat_type,s.tech_rank AS old_tech_rank, s.build_rank AS old_build_rank, s.defs_rank AS old_defs_rank, s.fleet_rank AS old_fleet_rank,s. total_rank AS old_total_rank";
            $select_user	= " u.id, u.ally_id, u.authlevel ";
            $sql                = 'SELECT p.id ,'.$this->select_buildings .$select_planet .'  FROM {{table}}planets as p ORDER BY p.id ASC ';
            $sql_old_stats	='SELECT '.$select_old_ranks.' FROM {{table}} as s WHERE stat_type = 1;';

            //CARGAMOS CONSTRUCCIONES
            $parcial_data	= $db->query($sql, '');
            while ($CurPlanet = mysql_fetch_assoc($parcial_data))
            {
                        $points		= $this->GetBuildPoints ( $CurPlanet );
                        $Buildings_array[$CurPlanet['id_owner']]['count']	+= $points['BuildCount'];
                        $Buildings_array[$CurPlanet['id_owner']]['point']	+= ($points['BuildPoint'] / $db->game_config['stat_settings']);
            }
            //unset($CurPlanet, $parcial_data);
            arsort($Buildings_array);
            $i=1;
            foreach ($Buildings_array as $key => $val) {
                $Buildings_array[$key]["rank"]=$i;
                ++$i;
            }
            //FIN DE CARGA CONSTRUCCIONES

            //CARGAMOS ANTIGUO RANQUIN
            $old_stats	= $db->query($sql_old_stats, 'statpoints');
            while ($CurStats = mysql_fetch_assoc($old_stats))
            {
                    $old_stats_array[$CurStats['id_owner']]=$CurStats;
            }
            
            //CARGAMOS TECNOLOGIA
            $sql	='SELECT  '.$this->selected_tech . ' u.id FROM {{table}} as u';
            $user_tech	= $db->query($sql, 'users');
            while ($CurStats = mysql_fetch_assoc($user_tech))
            {
                    $points	= $this->GetTechnoPoints ( $CurStats );
                    $tech_array[$CurStats['id']]['count']	= $points['TechCount'];
                    $tech_array[$CurStats['id']]['point']	= ($points['TechPoint'] / $db->game_config['stat_settings']);
                    $list_user[]=$CurStats['id'];

            }
            arsort($tech_array);
            $i=1;
            foreach ($tech_array as $key => $val) {
                $tech_array[$key]["rank"]=$i;
                ++$i;
            }

            //FIN DE CARGA TECNOLOGIA

            //CARGAMOS  FLOTA
            $sql	=	'SELECT '.$this->select_fleets.$select_planet.' FROM {{table}}planets as p GROUP BY p.id_owner;';
            $total_data	=	$db->query ($sql,'');
            while ($CurStats = mysql_fetch_assoc($total_data))
            {
                    $points	= $this->GetFleetPoints ( $CurStats );
                    $fleets_array[$CurStats['id_owner']]['count']	= $points['FleetCount'];
                    $fleets_array[$CurStats['id_owner']]['point']	= ($points['FleetPoint'] / $db->game_config['stat_settings']);
            }

            if($db->game_config['stat_flying'] == 1)
            {
                    $sql_flying_fleets	= 'SELECT fleet_array, fleet_owner FROM {{table}} ;';
                    $flying_fleets	= $db->query($sql_flying_fleets, 'fleets');
                    while ($CurFleets = mysql_fetch_assoc($flying_fleets))
                    {
                            $points		= $this->GetFlyingFleetPoints ( $CurFleets['fleet_array'] );
                            $fleets_array[$CurFleets['fleet_owner']]['count'] += $points['FleetCount'];
                            $fleets_array[$CurFleets['fleet_owner']]['point'] += ($points['FleetPoint'] / $db->game_config['stat_settings']);
                    }
                    
            }
            //unset($CurStats, $total_data);
            arsort($fleets_array);
            $i=1;
            foreach ($fleets_array as $key => $val) {
                $fleets_array[$key]["rank"]=$i;
                ++$i;
            }
            //FIN DE LA CARGA FLOTA

            //CARGAMOS DEFENSA
            $sql	=	'SELECT '.$this->select_defenses .$select_planet.' FROM {{table}}planets as p GROUP BY p.id_owner;';
            $total_data	=	$db->query ($sql,'');
            while ($CurStats = mysql_fetch_assoc($total_data))
            {
                    $points	= $this->GetDefensePoints ( $CurStats );
                    $defs_array[$CurStats['id_owner']]["count"]	= $points['DefenseCount'];
                    $defs_array[$CurStats['id_owner']]["point"]	= ($points['DefensePoint'] / $db->game_config['stat_settings']);
                    //unset($points);
            }

            arsort($defs_array);
            $i=1;
            foreach ($defs_array as $key => $val) {
                $defs_array[$key]["rank"]=$i;
                ++$i;
            }
            //FIN DE LA CARGA DEFENSA

            //CARGAMOS TODAS LAS PUNTUACIONES
            foreach($list_user as $id){
                $total[$id]=$defs_array[$id]["point"];
                $total[$id]+= $fleets_array[$id]['point'];
                $total[$id]+= $tech_array[$id]['point'];
                $total[$id]+= $Buildings_array[$id]['point'];
            }
            arsort($total);
            $i=1;
            foreach ($total as $key => $val) {
                unset($total[$key]);
                $orden[$key]=$i;
                ++$i;
            }

            //FIN DE LA CARGA DE PUNTUACIONES
            $sql	='SELECT  '.$select_user . ' FROM {{table}} as u';

            $users	= $db->query($sql, 'users');
            while ($CurUser = mysql_fetch_assoc($users))
            {

                if($old_stats_array[$CurUser['id']]){
                    $u_OldTotalRank = $old_stats_array[$CurUser['id']]['old_total_rank'];
                    $u_OldTechRank  = $old_stats_array[$CurUser['id']]['old_tech_rank'];
                    $u_OldBuildRank = $old_stats_array[$CurUser['id']]['old_build_rank'];
                    $u_OldDefsRank  = $old_stats_array[$CurUser['id']]['old_defs_rank'];
                    $u_OldFleetRank = $old_stats_array[$CurUser['id']]['old_fleet_rank'];
                    unset($old_stats_array[$CurUser['id']]);
                }else{
                    $u_OldTotalRank = 0;
                    $u_OldTechRank  = 0;
                    $u_OldBuildRank = 0;
                    $u_OldDefsRank  = 0;
                    $u_OldFleetRank = 0;
                }


                //VOLCAMOS LOS DATOS DE LA TECNOLOGIA AL USUARIO
                $u_tech_rank    = $tech_array[$CurUser['id']]['rank'];
                $u_TTechCount	= $tech_array[$CurUser['id']]['count'];
                $u_TTechPoints	= $tech_array[$CurUser['id']]['point'];
                unset($tech_array[$CurUser['id']]);

                //VOLCAMOS LOS DATOS DE LA DEFENSA AL USUARIO
                $u_defs_rank    = $defs_array[$CurUser['id']]["rank"];
                $u_TDefsCount	= $defs_array[$CurUser['id']]['count'];
                $u_TDefsPoints	= $defs_array[$CurUser['id']]['point'];
                unset($defs_array[$CurUser['id']]);

                
                //VOLCAMOS LOS DATOS DE LA FLOTA AL USUARIO
                $u_fleet_rank   = $fleets_array[$CurUser['id']]["rank"];
                $u_TFleetCount	= $fleets_array[$CurUser['id']]['count'];
                $u_TFleetPoints	= $fleets_array[$CurUser['id']]['point'];
                unset($fleets_array[$CurUser['id']]);


                if($Buildings_array[$CurUser['id']])
                {
                        $u_TBuildCount     = $Buildings_array[$CurUser['id']]['count'];
                        $u_TBuildPoints    = $Buildings_array[$CurUser['id']]['point'];
                        if($CurUser['ally_id']!=0){
                            $this->Ally_Build[$CurUser['ally_id']]['count']+=$u_TBuildCount;
                            $this->Ally_Build[$CurUser['ally_id']]['point']+=$u_TBuildPoints;
                        }

                        $u_build_rank      = $Buildings_array[$CurUser['id']]['rank'];
                        unset($Buildings_array[$CurUser['id']]);
                }

                //SI ESTA EN UNA ALIANZA CARGAMOS LOS VALORES
                if($CurUser['ally_id']!=0){
                    $this->Ally_Fleet[$CurUser['ally_id']]['count']+=$u_TFleetCount;
                    $this->Ally_Fleet[$CurUser['ally_id']]['point']+=$u_TFleetPoints;
                    $this->Ally_Defs[$CurUser['ally_id']]['count']+=$u_TDefsCount;
                    $this->Ally_Defs[$CurUser['ally_id']]['point']+=$u_TDefsPoints;
                    $this->Ally_Tech[$CurUser['ally_id']]['count']+=$u_TTechCount;
                    $this->Ally_Tech[$CurUser['ally_id']]['point']+=$u_TTechPoints;
                    $this->Ally_rank[$CurUser['ally_id']] += $u_TTechPoints + $u_TDefsPoints + $u_TFleetPoints + $u_TBuildPoints;
                    $this->Ally_array[]=$CurUser['ally_id'];
                }


                if (($CurUser['authlevel'] >= $db->game_config['stat_level']&& $db->game_config['stat']==1 ) || $CurUser['bana']==1)
                {
                        $insert__query[]  .= '('.$CurUser['id'].','.$CurUser['ally_id'].',1,1,'.$u_OldTechRank.',
                                                0,0,'.$u_OldBuildRank.',0,0,'.$u_OldDefsRank.',0,0,'.$u_OldFleetRank.',
                                                0,0,'.$u_OldTotalRank.',0,0,'.$this->stats_time.',
                                                0,0,0,0,0),' ;

                }
                else
                {
                        $u_GCount          = $u_TDefsCount  + $u_TTechCount  + $u_TFleetCount  + $u_TBuildCount;
			$u_GPoints         = $u_TTechPoints + $u_TDefsPoints + $u_TFleetPoints + $u_TBuildPoints;

                        $insert__query[]  .='('.$CurUser['id'].','.$CurUser['ally_id'].',1,1,'.$u_OldTechRank.',
                                            '.$u_TTechPoints.','.$u_TTechCount.','.$u_OldBuildRank.','.$u_TBuildPoints.',
                                            '.$u_TBuildCount.','.$u_OldDefsRank.','.$u_TDefsPoints.','.$u_TDefsCount.',
                                            '.$u_OldFleetRank.','.$u_TFleetPoints.','.$u_TFleetCount.','.$u_OldTotalRank.',
                                            '.$u_GPoints.','.$u_GCount.','.$this->stats_time.',
                                            '.$u_fleet_rank.','.$u_defs_rank.','.$u_build_rank.','.$u_tech_rank.','.$orden[$CurUser['id']].'),' ;
                }
                unset_vars('u_');

            }

            //BORRAMOS STAT_TYPE 1 USUARIOS
            $db->query ( "DELETE FROM {{table}} WHERE `stat_type` = '1';" , 'statpoints');
            //YA HEMOS CREADOS LOS ARRAYS DE LA ACTUALIZACION
            $this->NewQueryStats($this->total_users,$insert__query);

        }
        private function NewQueryStats($count,$array){
            global $db;

            $amount_per_block	= $db->game_config['stat_amount'];
            if ($count > $amount_per_block)
            {
                    $LastQuery = floor($count / $amount_per_block);
            }
            else
            {
                    $LastQuery = 0;
            }

            $querya=array_chunk($array, $amount_per_block);

            for($i=0 ; $i<=$LastQuery;$i++){
                    $insert	="INSERT INTO {{table}} (`id_owner`, `id_ally`, `stat_type`, `stat_code`,
                                                        `tech_old_rank`, `tech_points`, `tech_count`,
                                                        `build_old_rank`, `build_points`, `build_count`,
                                                        `defs_old_rank`, `defs_points`, `defs_count`,
                                                        `fleet_old_rank`, `fleet_points`, `fleet_count`,
                                                        `total_old_rank`, `total_points`, `total_count`, `stat_date`,
                                                        `fleet_rank`,`defs_rank`,`build_rank`,`tech_rank`,`total_rank`) VALUES ";
                    foreach($querya[$i] as $id => $querys){
                        $insert.=$querys;
                    }
                    unset($querya[$i]);
                    $insert = substr_replace($insert, ';', -1);
                    $db->query ($insert , 'statpoints');
             }

        }

        private  function GetTechnoPoints ( $CurrentUser ) {
            global $resource, $pricelist, $reslist;

            $TechCounts = 0;
            $TechPoints = 0;
            foreach ( $reslist['tech'] as $n => $Techno )
            {
                    if ( $CurrentUser[ $resource[ $Techno ] ] > 0 ) {
                            for ( $Level = 1; $Level < $CurrentUser[ $resource[ $Techno ] ]; $Level++ ) {
                                    $Units       = $pricelist[ $Techno ]['metal'] + $pricelist[ $Techno ]['crystal'] + $pricelist[ $Techno ]['deuterium'];
                                    $LevelMul    = pow( $pricelist[ $Techno ]['factor'], $Level );
                                    $TechPoints += ($Units * $LevelMul);
                                    $TechCounts += 1;
                            }
                    }
            }
            $RetValue['TechCount'] = $TechCounts;
            $RetValue['TechPoint'] = $TechPoints;
            return $RetValue;
        }

        private  function GetBuildPoints ( $CurrentPlanet ) {
            global $resource, $pricelist, $reslist;
            $BuildCounts = 0;
            $BuildPoints = 0;
            foreach($reslist['build'] as $n => $Building) {
                    if ( $CurrentPlanet[ $resource[ $Building ] ] > 0 )
                    {
                            for ( $Level = 1; $Level < $CurrentPlanet[ $resource[ $Building ] ]; $Level++ ) {
                                    $Units        = $pricelist[ $Building ]['metal'] + $pricelist[ $Building ]['crystal'] + $pricelist[ $Building ]['deuterium'];
                                    $LevelMul     = pow( $pricelist[ $Building ]['factor'], $Level );
                                    $BuildPoints += ($Units * $LevelMul);
                                    $BuildCounts += 1;
                            }
                    }
            }

            $RetValue['BuildCount'] = $BuildCounts;
            $RetValue['BuildPoint'] = $BuildPoints;

            return $RetValue;
        }

        private  function GetDefensePoints ( $CurrentPlanet ) {
            global $resource, $pricelist, $reslist;

            $DefenseCounts = 0;
            $DefensePoints = 0;
            foreach($reslist['defense'] as $n => $Defense) {
                    if ($CurrentPlanet[ $resource[ $Defense ] ] > 0) {
                            $Units          = $pricelist[ $Defense ]['metal'] + $pricelist[ $Defense ]['crystal'] + $pricelist[ $Defense ]['deuterium'];
                            $DefensePoints += ($Units * $CurrentPlanet[ $resource[ $Defense ] ]);
                            $DefenseCounts += $CurrentPlanet[ $resource[ $Defense ] ];
                    }
            }
            $RetValue['DefenseCount'] = $DefenseCounts;
            $RetValue['DefensePoint'] = $DefensePoints;

            return $RetValue;
        }

        private  function GetFleetPoints ( $CurrentPlanet ) {
            global $resource, $pricelist, $reslist;

            $FleetCounts = 0;
            $FleetPoints = 0;
            foreach($reslist['fleet'] as $n => $Fleet) {
                    if ($CurrentPlanet[ $resource[ $Fleet ] ] > 0) {
                            $Units          = $pricelist[ $Fleet ]['metal'] + $pricelist[ $Fleet ]['crystal'] + $pricelist[ $Fleet ]['deuterium'];
                            $FleetPoints   += ($Units * $CurrentPlanet[ $resource[ $Fleet ] ]);
                            $FleetCounts   += $CurrentPlanet[ $resource[ $Fleet ] ];
                    }
            }
            $RetValue['FleetCount'] = $FleetCounts;
            $RetValue['FleetPoint'] = $FleetPoints;

            return $RetValue;
        }

        private  function GetFlyingFleetPoints($fleet_array)
        {
            global $resource, $pricelist, $reslist;
                $FleetRec     = explode(";", $fleet_array);
                if(is_array($FleetRec))
                {
                        foreach($FleetRec as $Item => $Group)
                        {
                                if ($Group  != '')
                                {
                                        $Ship    = explode(",", $Group);
                                        $Units         = $pricelist[ $Ship[0] ]['metal'] + $pricelist[ $Ship[0] ]['crystal'] + $pricelist[ $Ship[0] ]['deuterium'];
                                        $FleetPoints   += ($Units * $Ship[1]);
                                        $FleetCounts   += $Ship[1];
                                }
                        }
                }
            $RetValue['FleetCount'] = $FleetCounts;
            $RetValue['FleetPoint'] = $FleetPoints;
            return $RetValue;
        }

        private function DeleteSelectedUser($UserID)
            {
                global $db;
                    $TheUser = $db->query ( "SELECT * FROM {{table}} WHERE `id` = '" . $UserID . "';", 'users', true );

                    if ( $TheUser['ally_id'] != 0 )
                    {
                            $TheAlly = $db->query ( "SELECT * FROM {{table}} WHERE `id` = '" . $TheUser['ally_id'] . "';", 'alliance', true );
                            $TheAlly['ally_members'] -= 1;

                            if ($TheAlly['ally_members'] > 0)
                            {
                                    $db->query ( "UPDATE {{table}} SET `ally_members` = '" . $TheAlly['ally_members'] . "' WHERE `id` = '" . $TheAlly['id'] . "';", 'alliance' );
                            }
                            else
                            {
                                    $db->query ( "DELETE FROM {{table}} WHERE `id` = '" . $TheAlly['id'] . "';", 'alliance' );
                                    $db->query ( "DELETE FROM {{table}} WHERE `stat_type` = '2' AND `id_owner` = '" . $TheAlly['id'] . "';", 'statpoints' );
                            }
                    }

                    $db->query ( "DELETE FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '" . $UserID . "';", 'statpoints' );

                    $ThePlanets = $db->query ( "SELECT * FROM {{table}} WHERE `id_owner` = '" . $UserID . "';", 'planets' );

                    while ( $OnePlanet = mysql_fetch_assoc ( $ThePlanets ) )
                    {

                            $db->query ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $OnePlanet['galaxy'] . "'
                                     AND `system` = '" . $OnePlanet['system'] . "'
                                     AND `planet` = '" . $OnePlanet['planet'] . "';", 'galaxy' );
                            $db->query ( "DELETE FROM {{table}} WHERE `id` = '" . $OnePlanet['id'] . "';", 'planets' );
                    }

                    $db->query ( "DELETE FROM {{table}} WHERE `message_sender` = '" . $UserID . "';", 'messages' );
                    $db->query ( "DELETE FROM {{table}} WHERE `message_owner` = '" . $UserID . "';", 'messages' );
                    $db->query ( "DELETE FROM {{table}} WHERE `owner` = '" . $UserID . "';", 'notes' );
                    $db->query ( "DELETE FROM {{table}} WHERE `fleet_owner` = '" . $UserID . "';", 'fleets' );
                    $db->query ( "DELETE FROM {{table}} WHERE `id_owner1` = '" . $UserID . "';", 'rw' );
                    $db->query ( "DELETE FROM {{table}} WHERE `id_owner2` = '" . $UserID . "';", 'rw' );
                    $db->query ( "DELETE FROM {{table}} WHERE `sender` = '" . $UserID . "';", 'buddy' );
                    $db->query ( "DELETE FROM {{table}} WHERE `owner` = '" . $UserID . "';", 'buddy' );
                    $db->query ( "DELETE FROM {{table}} WHERE `player_id` = '" . $UserID . "';", 'supp' );
                    $db->query ( "DELETE FROM {{table}} WHERE `id` = '" . $UserID . "';", 'users' );
                    $users_amount = $db->config_config["users_amount"]-1;
                    $db->query ( "UPDATE `{{table}}` SET `config_value` = '".abs($users_amount)."' WHERE CONVERT( `config_name` USING utf8 ) = 'users_amount' LIMIT 1 ;", "config" );
            }
       
        
        

}

?>