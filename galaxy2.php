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

define('INSIDE' , true);
define('INSTALL' , false);
define('NO_TEMPLATE_CACHE', true);
require_once dirname(__FILE__) .'/common.php';

includeLang('galaxy');
    

$Position_Galaxy = isset($_GET["g"]) ? intval($_GET["g"]) : $planetrow['galaxy'];
$Position_System = isset($_GET["s"]) ? intval($_GET["s"]) : $planetrow['system'];

if (isset($_POST["galaxyLeft"])) {
    if (!isset($_POST["galaxy"]) || $_POST["galaxy"] <= 1 || $_POST["galaxy"] > MAX_GALAXY_IN_WORLD) {
        $Position_Galaxy = 1;
    } else {
        $Position_Galaxy = intval($_POST["galaxy"]) - 1;
    }
} elseif (isset($_POST["galaxyRight"])) {
    if (!isset($_POST["galaxy"]) || $_POST["galaxy"] >= MAX_GALAXY_IN_WORLD) {
        $Position_Galaxy = MAX_GALAXY_IN_WORLD;
    } else {
        $Position_Galaxy = intval($_POST["galaxy"]) + 1;
    }
} else if (!isset($_POST["galaxy"]) || $_POST["galaxy"] <= 1 || $_POST["galaxy"] > MAX_GALAXY_IN_WORLD) {
    $Position_Galaxy = 1;
} else {
    $Position_Galaxy = intval($_POST["galaxy"]);
}

if (isset($_POST["systemLeft"])) {
    if (!isset($_POST["system"]) || $_POST["system"] <= 1 || $_POST["system"] > MAX_SYSTEM_IN_GALAXY) {
        $Position_System = 1;
    } else {
        $Position_System = intval($_POST["system"]) - 1;
    }
} elseif (isset($_POST["systemRight"])) {
    if (!isset($_POST["system"]) || $_POST["system"] >= MAX_SYSTEM_IN_GALAXY) {
        $Position_System = MAX_SYSTEM_IN_GALAXY;
    } else {
        $Position_System = intval($_POST["system"]) + 1;
    }
} else if (!isset($_POST["system"]) || $_POST["system"] <= 1 || $_POST["system"] > MAX_SYSTEM_IN_GALAXY) {
    $Position_System = 1;
} else {
    $Position_System = intval($_POST["system"]);
}



$query = <<<SQL_EOF
SELECT 
    u.`username`,
    u.`ally_id`,
    p.`name`,
    p.`id`,
    p.`id_owner`,
    p.`galaxy`,
    p.`system`,
    p.`planet`,
    p.`image`,
    a.`ally_name`,
    a.`ally_tag`,
    g.`metal` AS metal_debris,
    g.`crystal` AS cristal_debris,
    l.`id_luna` AS moon_id,
    l.`name` AS moon_name,
    l.`temp_min` AS moon_temp_min,
    l.`temp_max` AS moon_temp_max,
    l.`diameter` AS moon_diameter
FROM
    game_planets p
        INNER JOIN
    game_users u ON p.id_owner = u.id
        LEFT JOIN
    game_alliance a ON u.ally_id = a.id
        LEFT JOIN
    game_galaxy g ON g.`galaxy` = p.`galaxy`
        AND g.`system` = p.`system`
        AND g.`planet` = p.`planet`
        LEFT JOIN
    game_lunas l ON p.`galaxy` = l.`galaxy`
        AND p.`system` = l.`system`
        AND p.`planet` = l.`lunapos`
WHERE
    p.`galaxy` = '{$Position_Galaxy}' AND p.`system` = '{$Position_System}'
        AND p.`planet_type` = 1;

SQL_EOF;
$query = str_replace("{{table_prefix}}", "game_", $query); //@todo

$GalaxyViewRows = doquery($query, '');
//



//List of planets in db
$GalaxyPlanetsRows = array();
while ($results = mysqli_fetch_assoc($GalaxyViewRows)){
    $GalaxyPlanetsRows[$results['planet']] = $results;
}

$GalaxyViewData = array();
for($pos = 0; $pos < MAX_PLANET_IN_SYSTEM; $pos++){
    if(isset($GalaxyPlanetsRows[$pos+1])){

        $GalaxyViewData[$pos] = $GalaxyPlanetsRows[$pos+1];
        $GalaxyViewData[$pos]['existant'] = true;
        $GalaxyViewData[$pos]['hasDebrisField'] = (isset($GalaxyPlanetsRows[$pos+1]['metal_debris']) && $GalaxyPlanetsRows[$pos+1]['metal_debris'] != 0) || (isset($GalaxyPlanetsRows[$pos+1]['cristal_debris']) && $GalaxyPlanetsRows[$pos+1]['cristal_debris'] != 0);
        $GalaxyViewData[$pos]['hasMoon'] = isset($GalaxyPlanetsRows[$pos+1]['moon_id']);
        $GalaxyViewData[$pos]['count'] = "true";
        $GalaxyViewData[$pos]['isMySelf'] = $GalaxyViewData[$pos]['id_owner'] == $user['id'];
    }else{
        $GalaxyViewData[$pos]['existant'] = false;
        $GalaxyViewData[$pos]['planet'] = $pos+1;
        //$GalaxyViewData[$pos]['id'] = "0";
        $GalaxyViewData[$pos]['name'] = "Espace disponible";
        $GalaxyViewData[$pos]['id_owner'] = "0";
        $GalaxyViewData[$pos]['galaxy'] = $Position_Galaxy;
        $GalaxyViewData[$pos]['system'] = $Position_System;
        $GalaxyViewData[$pos]['hasMoon'] = false;
        $GalaxyViewData[$pos]['hasDebrisField'] = false; //Peut-être utile pour introduire des champs de débris flottants dans l'espace ?
    }
    $GalaxyViewData[$pos]['position'] = $pos+1;
    
}




$parse = $lang;
$parse['ExpeditionPosition'] = MAX_PLANET_IN_SYSTEM + 1;

$parse['leftG'] = $Position_Galaxy - 1;
$parse['rightG'] = $Position_Galaxy + 1;
$parse['leftS'] = $Position_System == 1 ? 1 : $Position_System - 1;
$parse['rightS'] = $Position_System + 1;

$parse['ViewGalaxy'] = $Position_Galaxy;
$parse['ViewSystem'] = $Position_System;
$parse["ViewData"] = $GalaxyViewData;
$NumberOfPlanets = array_count_values(array_column($GalaxyViewData, 'count'));
$NumberOfPlanets = isset($NumberOfPlanets['true']) ? $NumberOfPlanets['true'] : "0";
$PopulatedPlanetsLabel = $lang['gf_cntmnone'];
if($NumberOfPlanets == 1){
    $PopulatedPlanetsLabel = $lang['gf_cntmone'];
}else if($NumberOfPlanets > 1){
    $PopulatedPlanetsLabel = $lang['gf_cntmsome'];
}

$parse['lbl_ColonizedPlanets'] = sprintf($PopulatedPlanetsLabel, $NumberOfPlanets);
$page  = gettemplate('ng_galaxy_scripts');
$page .= gettemplate('ng_galaxy_body');
$page  = $MustacheEngine->render($page, $parse);
display ($page, 'GalaxyNG', false, '', false);

    
