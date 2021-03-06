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

function BuildFleetEventTable ( $FleetRow, $Status, $Owner, $Label, $Record ) {
	global $lang, $MustacheEngine;

	$FleetStyle  = array (
		 1 => 'attack',
		 2 => 'federation',
		 3 => 'transport',
		 4 => 'deploy',
		 5 => 'hold',
		 6 => 'espionage',
		 7 => 'colony',
		 8 => 'harvest',
		 9 => 'destroy',
		10 => 'missile',
		15 => 'transport',
	);
	$FleetStatus = array ( 0 => 'flight', 1 => 'holding', 2 => 'return' );
	if ( $Owner == true ) {
		$FleetPrefix = 'own';
	} else {
		$FleetPrefix = '';
	}

	$RowsTPL        = gettemplate ('overview_fleet_event');
	$MissionType    = $FleetRow['fleet_mission'];
	$FleetContent   = CreateFleetPopupedFleetLink ( $FleetRow, $lang['ov_fleet'], $FleetPrefix . $FleetStyle[ $MissionType ] );
	$FleetCapacity  = CreateFleetPopupedMissionLink ( $FleetRow, $lang['type_mission'][ $MissionType ], $FleetPrefix . $FleetStyle[ $MissionType ] );

	$NameQuery  = "SELECT `name` ";
	$NameQuery .= "FROM {{table}} ";
	$NameQuery .= "WHERE `galaxy` = '".$FleetRow['fleet_start_galaxy']."' AND `system` = '".$FleetRow['fleet_start_system']."' AND `planet` = '".$FleetRow['fleet_start_planet']."' AND `planet_type` = '".$FleetRow['fleet_start_type']."' ";
	$NameQuery .= "UNION ";
	$NameQuery .= "SELECT `name` ";
	$NameQuery .= "FROM {{table}} ";
	$NameQuery .= "WHERE `galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND `system` = '".$FleetRow['fleet_end_system']."' AND `planet` = '".$FleetRow['fleet_end_planet']."' AND `planet_type` = '".$FleetRow['fleet_end_type']."';";
	$NameQuery = doquery($NameQuery, "planets", true);
	
	$StartType      = $FleetRow['fleet_start_type'];
	$TargetType     = $FleetRow['fleet_end_type'];

	if       ($Status != 2) {
		if       ($StartType == 1) {
			$StartID  = $lang['ov_planet_to'];
		} elseif ($StartType == 3) {
			$StartID  = $lang['ov_moon_to'];
		}
		$StartID .= isset($NameQuery) && isset($NameQuery[0]) ? $NameQuery[0] ." " : "";
		$StartID .= GetStartAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );

		if ( $MissionType != 15 ) {
			if       ($TargetType == 1) {
				$TargetID  = $lang['ov_planet_to_target'];
			} elseif ($TargetType == 2) {
				$TargetID  = $lang['ov_debris_to_target'];
			} elseif ($TargetType == 3) {
				$TargetID  = $lang['ov_moon_to_target'];
			}
		} else {
			$TargetID  = $lang['ov_explo_to_target'];
		}
		$TargetID .= isset($NameQuery) && isset($NameQuery[1]) ? $NameQuery[1] ." " : "";
		$TargetID .= GetTargetAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );
	} else {
		if       ($StartType == 1) {
			$StartID  = $lang['ov_back_planet'];
		} elseif ($StartType == 3) {
			$StartID  = $lang['ov_back_moon'];
		}
		$StartID .= isset($NameQuery) && isset($NameQuery[0]) ? $NameQuery[0] ." " : "";
		$StartID .= GetStartAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );

		if ( $MissionType != 15 ) {
			if       ($TargetType == 1) {
				$TargetID  = $lang['ov_planet_from'];
			} elseif ($TargetType == 2) {
				$TargetID  = $lang['ov_debris_from'];
			} elseif ($TargetType == 3) {
				$TargetID  = $lang['ov_moon_from'];
			}
		} else {
			$TargetID  = $lang['ov_explo_from'];
		}
		$TargetID .= isset($NameQuery) && isset($NameQuery[1]) ? $NameQuery[1] ." " : "";
		$TargetID .= GetTargetAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );
	}

	if ($Owner == true) {
		$EventString  = $lang['ov_une'];     // 'Une de tes '
		$EventString .= $FleetContent;
	} else {
		$EventString  = $lang['ov_une_hostile']; // 'Une '
		$EventString .= $FleetContent;
		$EventString .= $lang['ov_hostile'];	// ' hostile de '
		$EventString .= BuildHostileFleetPlayerLink ( $FleetRow );
	}

	if       ($Status == 0) {
		$Time         = $FleetRow['fleet_start_time'];
		$Rest         = $Time - time();
		$EventString .= $lang['ov_vennant']; // ' venant '
		$EventString .= $StartID;
		$EventString .= $lang['ov_atteint']; // ' atteint '
		$EventString .= $TargetID;
		$EventString .= $lang['ov_mission']; // '. Elle avait pour mission: '
	} elseif ($Status == 1) {
		$Time         = $FleetRow['fleet_end_stay'];
		$Rest         = $Time - time();
		$EventString .= $lang['ov_vennant']; // ' venant '
		$EventString .= $StartID;
		$EventString .= $lang['ov_explo_stay']; // ' explore '
		$EventString .= $TargetID;
		$EventString .= $lang['ov_explo_mission']; // '. Elle a pour mission: '
	} elseif ($Status == 2) {
		$Time         = $FleetRow['fleet_end_time'];
		$Rest         = $Time - time();
		$EventString .= $lang['ov_rentrant'];// ' rentrant '
		$EventString .= $TargetID;
		$EventString .= $StartID;
		$EventString .= $lang['ov_mission']; // '. Elle avait pour mission: '
	}
	$EventString .= $FleetCapacity;

	$bloc['fleet_status'] = $FleetStatus[ $Status ];
	$bloc['fleet_prefix'] = $FleetPrefix;
	$bloc['fleet_style']  = $FleetStyle[ $MissionType ];
	$bloc['fleet_javai']  = InsertJavaScriptChronoApplet ( $Label, $Record, $Rest, true );
	$bloc['fleet_order']  = $Label . $Record;
	$bloc['fleet_time']   = date("H:i:s", $Time);
	$bloc['fleet_descr']  = $EventString;
	$bloc['fleet_javas']  = InsertJavaScriptChronoApplet ( $Label, $Record, $Rest, false );

	return $MustacheEngine->render($RowsTPL, $bloc);
}

?>