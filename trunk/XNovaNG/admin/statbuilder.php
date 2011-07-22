<?php
/**
 * This file is part of XNova:Legacies
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see http://www.xnova-ng.org/
 *
 * Copyright (c) 2009-2010, XNova Support Team <http://www.xnova-ng.org>
 * All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *                                --> NOTICE <--
 *  This file is part of the core development branch, changing its contents will
 * make you unable to use the automatic updates manager. Please refer to the
 * documentation for further information about customizing XNova.
 *
 */

define('IN_ADMIN', true);

require_once dirname(dirname(__FILE__)) .'/common.'.PHPEXT;

include(ROOT_PATH . 'admin/statfunctions.php');

if ($user['authlevel'] >= 1) {
    $db = Legacies_Database::getInstance();
	$db = Legacies_Database::getInstance();



    includeLang('admin');
    $statDate = time();

    $statsTable = Legacies_Database::getTable('deprecated/statpoints');
    $db->delete($statsTable, array('stat_code>=?' => 2));
    $db->update($statsTable, array('stat_code=stat_code+1' => 'stat_code' + 1));

    $statement = $db->select(array('user_id' => 'user.id'))
        ->from(array('user' => Legacies_Database::getTable('deprecated/users')))
        ->join(array('stats' => $statsTable), 'user.id=stats.id_owner')
        ->where('stats.stat_code=?', 2)
        ->query(Legacies_Database::FETCH_ASSOC)
    ;

    foreach ($statement as $curUserStats) {
        if ($OldStatRecord) {
            $OldTotalRank = $curUserStats['total_rank'];
            $OldTechRank  = $curUserStats['tech_rank'];
            $OldBuildRank = $curUserStats['build_rank'];
            $OldDefsRank  = $curUserStats['defs_rank'];
            $OldFleetRank = $curUserStats['fleet_rank'];
            // Suppression de l'ancien enregistrement
            $db->delete($statsTable, array ('stat_type =?' => 1), array ('id_owner =?' => $CurUser['id']));
        } else {
            $OldTotalRank = 0;
            $OldTechRank  = 0;
            $OldBuildRank = 0;
            $OldDefsRank  = 0;
            $OldFleetRank = 0;
        }

        // Total des unitées consommée pour la recherche
        $Points         = GetTechnoPoints ( $CurUser );
        $TTechCount     = $Points['TechCount'];
        $TTechPoints    = ($Points['TechPoint'] / $game_config['stat_settings']);

        // Totalisation des points accumulés par planete
        $TBuildCount    = 0;
        $TBuildPoints   = 0;
        $TDefsCount     = 0;
        $TDefsPoints    = 0;
        $TFleetCount    = 0;
        $TFleetPoints   = 0;
        $GCount         = $TTechCount;
        $GPoints        = $TTechPoints;
        $UsrPlanets = $db
        ->select()
        ->from(Legacies_Database::getTable('deprecated/planets'))
        ->where('id_owner=?', $CurUser['id'])
        ->query()
        ;

        $statement2 = $db->fetchAssoc($UsrPlanets);

        foreach ($statement2 as $CurPlanet) {
            $Points           = GetBuildPoints ( $CurPlanet );
            $TBuildCount     += $Points['BuildCount'];
            $GCount          += $Points['BuildCount'];
            $PlanetPoints     = ($Points['BuildPoint'] / $game_config['stat_settings']);
            $TBuildPoints    += ($Points['BuildPoint'] / $game_config['stat_settings']);

            $Points           = GetDefensePoints ( $CurPlanet );
            $TDefsCount      += $Points['DefenseCount'];;
            $GCount          += $Points['DefenseCount'];
            $PlanetPoints    += ($Points['DefensePoint'] / $game_config['stat_settings']);
            $TDefsPoints     += ($Points['DefensePoint'] / $game_config['stat_settings']);

            $Points           = GetFleetPoints ( $CurPlanet );
            $TFleetCount     += $Points['FleetCount'];
            $GCount          += $Points['FleetCount'];
            $PlanetPoints    += ($Points['FleetPoint'] / $game_config['stat_settings']);
            $TFleetPoints    += ($Points['FleetPoint'] / $game_config['stat_settings']);

            $GPoints         += $PlanetPoints;
            $db->update(Legacies_Database::getTable('deprecated/planets'), array ('points' => $PlanetPoints), array ('id =?' => $CurPlanet['id']));

        }

        $StatData = array(
                'id_owner' => $CurUser['id'],
                'id_ally' => $CurUser['ally_id'],
                'stat_type' => '1',
                'stat_code' => '1',
                'tech_points' => $TTechPoints,
                'tech_count' => $TTechCount,
                'tech_old_rank' => $OldTechRank,
                'build_points' => $TBuildPoints,
                'build_count' => $TBuildCount,
                'build_old_rank' => $OldBuildRank,
                'defs_points' => $TDefsPoints,
                'defs_count' => $TDefsCount,
                'defs_old_rank' => $OldDefsRank,
                'fleet_points' => $TFleetPoints,
                'fleet_count' => $TFleetCount,
                'fleet_old_rank' => $OldFleetRank,
                'total_points' => $GPoints,
                'total_count' => $GCount,
                'total_old_rank' => $OldTotalRank,
                'stat_date' => new Zend_Db_Expr('UNIX_TIMESTAMP()')
            );
                //@todo Suite indentation
                $db->insert(Legacies_Database::getTable('deprecated/statpoints'), $StatData);
    }

    $Rank           = 1;
    $RankQry = $db
        ->select()
        ->from(Legacies_Database::getTable('deprecated/statpoints'))
        ->where('stat_type=?', '1')
        ->where('stat_code=?', '1')
        ->order('tech_points DESC')
        ->query()
    ;
    $statement = $db->fetchAssoc($sql);

    foreach ($statement as $TheRank) {
        $db->update(Legacies_Database::getTable('deprecated/statpoints'), array ('tech_rank' => $Rank), array ('stat_type =?' => '1', 'stat_code =?' => '1', 'id_owner =?' => $TheRank['id_owner']));
        $Rank++;
    }

    $Rank           = 1;
    $RankQry = $db
        ->select()
        ->from(Legacies_Database::getTable('deprecated/statpoints'))
        ->where('stat_type=?', '1')
        ->where('stat_code=?', '1')
        ->order('build_points DESC')
        ->query()
    ;
    $statement = $db->fetchAssoc($sql);

    foreach ($statement as $TheRank) {
        $db->update(Legacies_Database::getTable('deprecated/statpoints'), array ('build_rank' => $Rank), array ('stat_type =?' => '1', 'stat_code =?' => '1', 'id_owner =?' => $TheRank['id_owner']));
        $Rank++;
    }

    $Rank           = 1;
    $RankQry = $db
        ->select()
        ->from(Legacies_Database::getTable('deprecated/statpoints'))
        ->where('stat_type=?', '1')
        ->where('stat_code=?', '1')
        ->order('defs_points DESC')
        ->query()
    ;
    $statement = $db->fetchAssoc($sql);

    foreach ($statement as $TheRank) {
        $db->update(Legacies_Database::getTable('deprecated/statpoints'), array ('defs_rank' => $Rank), array ('stat_type =?' => '1', 'stat_code =?' => '1', 'id_owner =?' => $TheRank['id_owner']));
        $Rank++;
    }

    $Rank           = 1;
    $RankQry = $db
        ->select()
        ->from(Legacies_Database::getTable('deprecated/statpoints'))
        ->where('stat_type=?', '1')
        ->where('stat_code=?', '1')
        ->order('fleet_points DESC')
        ->query()
    ;
    $statement = $db->fetchAssoc($sql);

    foreach ($statement as $TheRank) {
        $db->update(Legacies_Database::getTable('deprecated/statpoints'), array ('fleet_rank' => $Rank), array ('stat_type =?' => '1', 'stat_code =?' => '1', 'id_owner =?' => $TheRank['id_owner']));
        $Rank++;
    }

    $Rank           = 1;
    $RankQry = $db
        ->select()
        ->from(Legacies_Database::getTable('deprecated/statpoints'))
        ->where('stat_type=?', '1')
        ->where('stat_code=?', '1')
        ->order('total_points DESC')
        ->query()
    ;
    $statement = $db->fetchAssoc($sql);

    foreach ($statement as $TheRank) {
        $db->update(Legacies_Database::getTable('deprecated/statpoints'), array ('total_rank' => $Rank), array ('stat_type =?' => '1', 'stat_code =?' => '1', 'id_owner =?' => $TheRank['id_owner']));
        $Rank++;
    }

    // Statistiques des alliances ...
    $GameAllys = $db
        ->select()
        ->from(Legacies_Database::getTable('deprecated/alliance'))
        ->query()
    ;
    $statement = Legacies_Database::getInstance()->fetchAssoc($sql);

    foreach ($statement as $CurAlly) {
        // Recuperation des anciennes statistiques
        $OldStatRecord = $db
            ->select()
            ->from(Legacies_Database::getTable('deprecated/statpoints'))
            ->where('stat_type=?', '2')
            ->where('id_owner=?', $CurAlly['id'])
            ->query()
            ->fetch()
        ;
        if ($OldStatRecord) {
            $OldTotalRank = $OldStatRecord['total_rank'];
            $OldTechRank  = $OldStatRecord['tech_rank'];
            $OldBuildRank = $OldStatRecord['build_rank'];
            $OldDefsRank  = $OldStatRecord['defs_rank'];
            $OldFleetRank = $OldStatRecord['fleet_rank'];
            // Suppression de l'ancien enregistrement
            $db->delete(Legacies_Database::getTable('deprecated/statpoints'), array ('stat_code =?' => '2', 'id_owner =?' => $CurAlly['id']));

        } else {
            $OldTotalRank = 0;
            $OldTechRank  = 0;
            $OldBuildRank = 0;
            $OldDefsRank  = 0;
            $OldFleetRank = 0;
        }

        // Total des unitées consommée pour la recherche
        $SUM_Array = array(new Zend_Db_Expr('SUM(`tech_points`) AS `TechPoint`'),
                           new Zend_Db_Expr('SUM(`tech_count`) AS `TechCount`'),
                           new Zend_Db_Expr('SUM(`build_points`) AS `BuildPoint`'),
                           new Zend_Db_Expr('SUM(`build_count`) AS `BuildCount`'),
                           new Zend_Db_Expr('SUM(`defs_points`) AS `DefsPoint`'),
                           new Zend_Db_Expr('SUM(`defs_count`) AS `DefsCount`'),
                           new Zend_Db_Expr('SUM(`fleet_points`) AS `FleetPoint`'),
                           new Zend_Db_Expr('SUM(`fleet_count`) AS `FleetCount`'),
                           new Zend_Db_Expr('SUM(`total_points`) AS `TotalPoint`'),
                           new Zend_Db_Expr('SUM(`total_count`) AS `TotalCount`'));
        $Points = $db
            ->select()
            ->from(Legacies_Database::getTable('deprecated/statpoints'), $SUM_Array)
            ->where('stat_type=?', '2')
            ->where('id_ally=?', $CurAlly['id'])
            ->query()
            ->fetch()
        ;
        //array('thecolumn' => new Zend_Db_Expr('SUM(amount)'))

        $TTechCount     = $Points['TechCount'];
        $TTechPoints    = $Points['TechPoint'];
        $TBuildCount    = $Points['BuildCount'];
        $TBuildPoints   = $Points['BuildPoint'];
        $TDefsCount     = $Points['DefsCount'];
        $TDefsPoints    = $Points['DefsPoint'];
        $TFleetCount    = $Points['FleetCount'];
        $TFleetPoints   = $Points['FleetPoint'];
        $GCount         = $Points['TotalCount'];
        $GPoints        = $Points['TotalPoint'];

            $QryInsertStats = array(
                'id_owner' => $CurAlly['id'],
                'id_ally' => '0',
                'stat_type' => '2',
                'stat_code' => '1',
                'tech_points' => $TTechPoints,
                'tech_count' => $TTechCount,
                'tech_old_rank' => $OldTechRank,
                'build_points' => $TBuildPoints,
                'build_count' => $TBuildCount,
                'build_old_rank' => $OldBuildRank,
                'defs_points' => $TDefsPoints,
                'defs_count' => $TDefsCount,
                'defs_old_rank' => $OldDefsRank,
                'fleet_points' => $TFleetPoints,
                'fleet_count' => $TFleetCount,
                'fleet_old_rank' => $OldFleetRank,
                'total_points' => $GPoints,
                'total_count' => $GCount,
                'total_old_rank' => $OldTotalRank,
                'stat_date' => new Zend_Db_Expr('UNIX_TIMESTAMP()')
            );
                //@todo Suite indentation
            $db->insert(Legacies_Database::getTable('deprecated/statpoints'), $QryInsertStats);
    }

    AdminMessage ( $lang['adm_done'], $lang['adm_stat_title'] );

    } else {
        AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
    }

