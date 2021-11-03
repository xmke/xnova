<?php
/**
 * This file is part of XNova:Legacies
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see http://www.xnova-ng.org/
 *
 * Copyright (c) 2009-Present, XNova Support Team <http://www.xnova-ng.org>
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

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

require_once dirname(dirname(__FILE__)) .'/common.php';

include(ROOT_PATH . 'admin/statfunctions.php');
//Record à battre : Page générée en 7813.151 secondes avec 293525 requêtes.

if (strtolower(substr(PHP_SAPI, 0, 3)) == 'cli' || in_array($user['authlevel'], array(LEVEL_ADMIN, LEVEL_OPERATOR, LEVEL_MODERATOR))) {
	includeLang('admin/interface');

	$StatDate   = time();
	/*doquery("TRUNCATE TABLE {{table}}", "statpoints");
	$users = doquery("SELECT * from game_users WHERE 1", "users");
	while($u = mysqli_fetch_assoc($users)){
			$QryInsertStats  = "INSERT INTO {{table}} SET ";
			$QryInsertStats .= "`id_owner` = '". $u['id'] ."', ";
			$QryInsertStats .= "`id_ally` = '". $u['ally_id'] ."', ";
			$QryInsertStats .= "`stat_type` = '1', "; // 1 pour joueur , 2 pour alliance
			$QryInsertStats .= "`stat_code` = '1', "; // de 1 a 5 mis a jour de maniere automatique
			$QryInsertStats .= "`tech_points` = '0', ";
			$QryInsertStats .= "`tech_count` = '0', ";
			$QryInsertStats .= "`tech_rank` = '0', ";
			$QryInsertStats .= "`tech_old_rank` = '0', ";
			$QryInsertStats .= "`build_points` = '0', ";
			$QryInsertStats .= "`build_count` = '0', ";
			$QryInsertStats .= "`build_rank` = '0', ";
			$QryInsertStats .= "`build_old_rank` = '0', ";
			$QryInsertStats .= "`defs_points` = '0', ";
			$QryInsertStats .= "`defs_count` = '0', ";
			$QryInsertStats .= "`defs_rank` = '0', ";
			$QryInsertStats .= "`defs_old_rank` = '0', ";
			$QryInsertStats .= "`fleet_points` = '0', ";
			$QryInsertStats .= "`fleet_count` = '0', ";
			$QryInsertStats .= "`fleet_rank` = '0', ";
			$QryInsertStats .= "`fleet_old_rank` = '0', ";
			$QryInsertStats .= "`total_points` = '0', ";
			$QryInsertStats .= "`total_count` = '0', ";
			$QryInsertStats .= "`total_rank` = '0', ";
			$QryInsertStats .= "`total_old_rank` = '0', ";
			$QryInsertStats .= "`stat_date` = '". time() ."';";
			doquery ( $QryInsertStats , 'statpoints');
	}

die();*/
	// Rotation des statistiques
	//doquery ( "UPDATE {{table}} SET `stat_code` = `stat_code` + '1';" , 'statpoints');

	//@Todo
	//$GameUsers  = doquery("SELECT * FROM {{table}} WHERE authlevel<3", 'users');

	
	$GameUsers = <<<SQL_EOF
	SELECT 
		u.*,
		s.total_rank,
		s.tech_rank,
		s.build_rank,
		s.defs_rank, 
		s.fleet_rank, 
		s.tech_points, 
		s.tech_count, 
		s.tech_old_rank, 
		s.build_points, 
		s.build_count, 
		s.build_old_rank, 
		s.defs_points, 
		s.defs_count, 
		s.defs_old_rank, 
		s.fleet_points, 
		s.fleet_count, 
		s.fleet_old_rank, 
		s.total_points, 
		s.total_count, 
		s.total_old_rank 
	FROM
		game_users u
	LEFT JOIN
		game_statpoints s
	ON u.id = s.id_owner
	WHERE
		s.stat_type = 1
SQL_EOF;

	$GameUsers  = doquery($GameUsers, 'users'); //@todo prefix
	$MesurablePlanetsUnits = array_merge($reslist['build'], $reslist['defense'], $reslist['fleet']);

	$PlanetQry = "SELECT id, points, ";
	foreach($MesurablePlanetsUnits as $n => $unit) {
		$PlanetQry .= $resource[ $unit ] .", ";
	}
	$PlanetQry = substr($PlanetQry, 0, -2);
	$PlanetQry .= " FROM {{table}} WHERE `id_owner` = %s";
	

	while ($CurUser = mysqli_fetch_assoc($GameUsers)) {
		
		
		
		// Total des unitées consommée pour la recherche
		$Points         = GetTechnoPoints ( $CurUser ); //todo optimiser la requête du while
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
		$UsrPlanets = sprintf($PlanetQry, $CurUser['id']);
		$UsrPlanets     = doquery($UsrPlanets, 'planets');
		while ($CurPlanet = mysqli_fetch_assoc($UsrPlanets) ) {
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
			if($CurPlanet['points'] != $PlanetPoints){
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`points` = '". $PlanetPoints ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $CurPlanet['id'] ."';";
				doquery ( $QryUpdatePlanet , 'planets');
			}
		}
		
		
			
			$OldTotalRank = 0;
			$OldTechRank  = 0;
			$OldBuildRank = 0;
			$OldDefsRank  = 0;
			$OldFleetRank = 0;
			
			$hasModifications = false;

			//update
			$QryInsertStats  = "UPDATE {{table}} SET ";
			$QryInsertStats .= "`id_owner` = '". $CurUser['id'] ."', ";
			$QryInsertStats .= "`stat_code` = '1', "; // de 1 a 5 mis a jour de maniere automatique
			$QryInsertStats .= "`id_ally` = '". $CurUser['ally_id'] ."', ";
			if($CurUser['tech_points'] != $TTechPoints){
				$hasModifications = true;
				$QryInsertStats .= "`tech_points` = '". $TTechPoints ."', "; //+
			}
			if($CurUser['tech_count'] != $TTechCount){
				$hasModifications = true;
				$QryInsertStats .= "`tech_count` = '". $TTechCount ."', "; //+
			}
			$QryInsertStats .= "`tech_rank` = '0', "; //s
			if($CurUser['tech_old_rank'] != $OldTechRank){
				$hasModifications = true;
				$QryInsertStats .= "`tech_old_rank` = '". $OldTechRank ."', "; //+
			}
			if($CurUser['build_points'] != $TBuildPoints){
				$hasModifications = true;
				$QryInsertStats .= "`build_points` = '". $TBuildPoints ."', "; //+
			}
			if($CurUser['build_count'] != $TBuildCount){
				$hasModifications = true;
				$QryInsertStats .= "`build_count` = '". $TBuildCount ."', "; //+
			}
			$QryInsertStats .= "`build_rank` = '0', "; //s
			if($CurUser['build_old_rank'] != $OldBuildRank){
				$hasModifications = true;
				$QryInsertStats .= "`build_old_rank` = '". $OldBuildRank ."', "; //+
			}
			if($CurUser['defs_points'] != $TDefsPoints){
				$hasModifications = true;
				$QryInsertStats .= "`defs_points` = '". $TDefsPoints ."', "; //+
			}
			if($CurUser['defs_count'] != $TDefsCount){
				$hasModifications = true;
				$QryInsertStats .= "`defs_count` = '". $TDefsCount ."', "; //+
			}
			$QryInsertStats .= "`defs_rank` = '0', "; //s
			if($CurUser['defs_old_rank'] != $OldDefsRank){
				$hasModifications = true;
				$QryInsertStats .= "`defs_old_rank` = '". $OldDefsRank ."', "; //+
			}
			if($CurUser['fleet_points'] != $TFleetPoints){
				$hasModifications = true;
				$QryInsertStats .= "`fleet_points` = '". $TFleetPoints ."', "; //+
			}
			if($CurUser['fleet_count'] != $TFleetCount){
				$hasModifications = true;
				$QryInsertStats .= "`fleet_count` = '". $TFleetCount ."', "; //+
			}
			$QryInsertStats .= "`fleet_rank` = '0', "; //s
			if($CurUser['fleet_old_rank'] != $OldFleetRank){
				$hasModifications = true;
				$QryInsertStats .= "`fleet_old_rank` = '". $OldFleetRank ."', "; //+
			}
			if($CurUser['total_points'] != $GPoints){
				$hasModifications = true;
				$QryInsertStats .= "`total_points` = '". $GPoints ."', "; //+
			}
			if($CurUser['total_count'] != $GCount){
				$hasModifications = true;
				$QryInsertStats .= "`total_count` = '". $GCount ."', "; //+
			}
			$QryInsertStats .= "`total_rank` = '0', "; //s
			if($CurUser['total_old_rank'] != $OldTotalRank){
				$hasModifications = true;
				$QryInsertStats .= "`total_old_rank` = '". $OldTotalRank ."', "; //+
			}
			$QryInsertStats .= "`stat_date` = '". $StatDate ."' ";
			$QryInsertStats .= "WHERE `id_owner` = '". $CurUser['id'] ."' AND `stat_type` = '1';";// 1 pour joueur , 2 pour alliance
			if($hasModifications){
				doquery ( $QryInsertStats , 'statpoints');
			}
			
			
		
		// Suppression de l'ancien enregistrement
		//doquery ("DELETE FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '".$CurUser['id']."';",'statpoints');
	
	}

	/*
	$Rank           = 1;
	$RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `tech_points` DESC;", 'statpoints');
	while ($TheRank = mysqli_fetch_assoc($RankQry) ) {
		$QryUpdateStats  = "UPDATE {{table}} SET ";
		$QryUpdateStats .= "`tech_rank` = '". $Rank ."' ";
		$QryUpdateStats .= "WHERE ";
		$QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
		doquery ( $QryUpdateStats , 'statpoints');
		$Rank++;
	}

	$Rank           = 1;
	$RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `build_points` DESC;", 'statpoints');
	while ($TheRank = mysqli_fetch_assoc($RankQry) ) {
		$QryUpdateStats  = "UPDATE {{table}} SET ";
		$QryUpdateStats .= "`build_rank` = '". $Rank ."' ";
		$QryUpdateStats .= "WHERE ";
		$QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
		doquery ( $QryUpdateStats , 'statpoints');
		$Rank++;
	}

	$Rank           = 1;
	$RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `defs_points` DESC;", 'statpoints');
	while ($TheRank = mysqli_fetch_assoc($RankQry) ) {
		$QryUpdateStats  = "UPDATE {{table}} SET ";
		$QryUpdateStats .= "`defs_rank` = '". $Rank ."' ";
		$QryUpdateStats .= "WHERE ";
		$QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
		doquery ( $QryUpdateStats , 'statpoints');
		$Rank++;
	}

	$Rank           = 1;
	$RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `fleet_points` DESC;", 'statpoints');
	while ($TheRank = mysqli_fetch_assoc($RankQry) ) {
		$QryUpdateStats  = "UPDATE {{table}} SET ";
		$QryUpdateStats .= "`fleet_rank` = '". $Rank ."' ";
		$QryUpdateStats .= "WHERE ";
		$QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
		doquery ( $QryUpdateStats , 'statpoints');
		$Rank++;
	}

	$Rank           = 1;
	$RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `total_points` DESC;", 'statpoints');
	while ($TheRank = mysqli_fetch_assoc($RankQry) ) {
		$QryUpdateStats  = "UPDATE {{table}} SET ";
		$QryUpdateStats .= "`total_rank` = '". $Rank ."' ";
		$QryUpdateStats .= "WHERE ";
		$QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
		doquery ( $QryUpdateStats , 'statpoints');
		$Rank++;
	}
	*/
	//@Todo : le rang peut se déterminer à l'affichage ?
	// Statistiques des alliances ...
	
	$GameAllys = <<<SQL_EOF
	SELECT 
    a.*,
    s.total_rank,
    s.build_rank,
    s.defs_rank,
    s.fleet_rank
FROM
    game_alliance a
LEFT JOIN
	game_statpoints s
ON a.id = s.id_owner
WHERE
s.stat_type = 2
SQL_EOF;
	$GameAllys  = doquery($GameAllys, 'alliance'); //todo db prefix

	while ($CurAlly = mysqli_fetch_assoc($GameAllys)) {
		// Recuperation des anciennes statistiques
		$OldTotalRank = isset($CurAlly['total_rank']) ? $CurAlly['total_rank'] : 0;
		$OldTechRank  = isset($CurAlly['tech_rank']) ? $CurAlly['tech_rank'] : 0;
		$OldBuildRank = isset($CurAlly['build_rank']) ? $CurAlly['build_rank'] : 0;
		$OldDefsRank  = isset($CurAlly['defs_rank']) ? $CurAlly['defs_rank'] : 0;
		$OldFleetRank = isset($CurAlly['fleet_rank']) ? $CurAlly['fleet_rank'] : 0;

		
		doquery ("DELETE FROM {{table}} WHERE `stat_type` = '2' AND `id_owner` = '".$CurAlly['id']."';",'statpoints');
		

		// Total des unitées consommée pour la recherche
		$QrySumSelect   = "SELECT ";
		$QrySumSelect  .= "SUM(`tech_points`)  as `TechPoint`, ";
		$QrySumSelect  .= "SUM(`tech_count`)   as `TechCount`, ";
		$QrySumSelect  .= "SUM(`build_points`) as `BuildPoint`, ";
		$QrySumSelect  .= "SUM(`build_count`)  as `BuildCount`, ";
		$QrySumSelect  .= "SUM(`defs_points`)  as `DefsPoint`, ";
		$QrySumSelect  .= "SUM(`defs_count`)   as `DefsCount`, ";
		$QrySumSelect  .= "SUM(`fleet_points`) as `FleetPoint`, ";
		$QrySumSelect  .= "SUM(`fleet_count`)  as `FleetCount`, ";
		$QrySumSelect  .= "SUM(`total_points`) as `TotalPoint`, ";
		$QrySumSelect  .= "SUM(`total_count`)  as `TotalCount` ";
		$QrySumSelect  .= "FROM {{table}} ";
		$QrySumSelect  .= "WHERE ";
		$QrySumSelect  .= "`stat_type` = '1' AND ";
		$QrySumSelect  .= "`id_ally` = '". $CurAlly['id'] ."';";
		$Points         = doquery( $QrySumSelect, 'statpoints', true);

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

		$QryInsertStats  = "INSERT INTO {{table}} SET ";
		$QryInsertStats .= "`id_owner` = '". $CurAlly['id'] ."', ";
		$QryInsertStats .= "`id_ally` = '0', ";
		$QryInsertStats .= "`stat_type` = '2', "; // 1 pour joueur , 2 pour alliance
		$QryInsertStats .= "`stat_code` = '1', "; // de 1 a 5 mis a jour de maniere automatique
		$QryInsertStats .= "`tech_points` = '". $TTechPoints ."', ";
		$QryInsertStats .= "`tech_count` = '". $TTechCount ."', ";
		$QryInsertStats .= "`tech_old_rank` = '". $OldTechRank ."', ";
		$QryInsertStats .= "`build_points` = '". $TBuildPoints ."', ";
		$QryInsertStats .= "`build_count` = '". $TBuildCount ."', ";
		$QryInsertStats .= "`build_old_rank` = '". $OldBuildRank ."', ";
		$QryInsertStats .= "`defs_points` = '". $TDefsPoints ."', ";
		$QryInsertStats .= "`defs_count` = '". $TDefsCount ."', ";
		$QryInsertStats .= "`defs_old_rank` = '". $OldDefsRank ."', ";
		$QryInsertStats .= "`fleet_points` = '". $TFleetPoints ."', ";
		$QryInsertStats .= "`fleet_count` = '". $TFleetCount ."', ";
		$QryInsertStats .= "`fleet_old_rank` = '". $OldFleetRank ."', ";
		$QryInsertStats .= "`total_points` = '". $GPoints ."', ";
		$QryInsertStats .= "`total_count` = '". $GCount ."', ";
		$QryInsertStats .= "`total_old_rank` = '". $OldTotalRank ."', ";
		$QryInsertStats .= "`stat_date` = '". $StatDate ."';";
		doquery ( $QryInsertStats , 'statpoints');
	}

	AdminMessage ( $lang['adm_done'], $lang['adm_stat_title'] );

} else {
	AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

