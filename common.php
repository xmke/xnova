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

require realpath(dirname(__FILE__)) . '/vendor/autoload.php';

use Mustache_Engine;
use Xmke\Xnova\Common\Language;

function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}
$StartPageGeneration = getmicrotime();
$SqlQueries = 0;
session_start();

if (in_array(strtolower(getenv('DEBUG')), array('1', 'on', 'true'))) {
    define('DEBUG', true);
}

!defined('DEBUG') || @ini_set('display_errors', false);
!defined('DEBUG') || @error_reporting(E_ALL | E_STRICT);

define('ROOT_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

$MustacheEngine = new Mustache_Engine();

define('VERSION', '2021a');

if (0 === filesize(ROOT_PATH . 'config.php')) {
    header('Location: install/');
    die();
}

$game_config   = array();
$user          = array();
$lang          = array();
$IsUserChecked = false;

define('DEFAULT_SKINPATH', 'skins/epicblue/');
define('TEMPLATE_DIR', realpath(ROOT_PATH . '/templates/'));
define('TEMPLATE_NAME', 'OpenGame');

include(ROOT_PATH . 'includes/constants.php');
include(ROOT_PATH . 'includes/functions.php');
include(ROOT_PATH . 'includes/unlocalised.php');
include(ROOT_PATH . 'includes/todofleetcontrol.php');
include(ROOT_PATH . 'language/' . Language::DEFAULT_LANGUAGE . '/lang_info.cfg');
include(ROOT_PATH . 'includes/vars.php');
include(ROOT_PATH . 'includes/db.php');
include(ROOT_PATH . 'includes/strings.php');

$query = doquery('SELECT * FROM {{table}}', 'config');
while($row = mysqli_fetch_assoc($query)) {
    $game_config[$row['config_name']] = $row['config_value'];
}

if (!defined('DISABLE_IDENTITY_CHECK')) {
    $Result        = CheckTheUser ( $IsUserChecked );
    $IsUserChecked = $Result['state'];
    $user          = $Result['record'];
} else if (!defined('DISABLE_IDENTITY_CHECK') && $game_config['game_disable'] && $user['authlevel'] == LEVEL_PLAYER) {
    message(stripslashes($game_config['close_reason']), $game_config['game_name']);
}

includeLang('system');
includeLang('tech');

if (empty($user) && !defined('DISABLE_IDENTITY_CHECK')) {
    header('Location: login.php');
    exit(0);
}else{
    if(!defined('QRYLESS')){
       $now = time();
    $sql =<<<SQL_EOF
    SELECT
      fleet_start_galaxy AS galaxy,
      fleet_start_system AS sys,
      fleet_start_planet AS planet,
      fleet_start_type AS planet_type
        FROM {{table}}
        WHERE `fleet_start_time` <= {$now}
    UNION
    SELECT
      fleet_end_galaxy AS galaxy,
      fleet_end_system AS sys,
      fleet_end_planet AS planet,
      fleet_end_type AS planet_type
        FROM {{table}}
        WHERE `fleet_end_time` <= {$now}
    SQL_EOF;
    
    $_fleets = doquery($sql, 'fleets');
    while ($row = mysqli_fetch_array($_fleets)) {
        FlyingFleetHandler($row);
    }
    
    unset($_fleets); 
    }
    
}
 
include(ROOT_PATH . 'rak.php');

if (!empty($user) && !defined('QRYLESS')) {
    SetSelectedPlanet($user);
    
    $planetrowQry  = "SELECT game_planets.*,";
    $planetrowQry .= "game_galaxy.metal AS metal_debris, ";
    $planetrowQry .= "game_galaxy.crystal AS cristal_debris, ";
    $planetrowQry .= "game_galaxy.id_luna, ";
    $planetrowQry .= "game_galaxy.luna ";
    $planetrowQry .= "FROM game_planets ";
    $planetrowQry .= "LEFT JOIN game_galaxy ";
    $planetrowQry .= "ON game_planets.id = game_galaxy.id_planet WHERE game_planets.id = " . $user['current_planet'];
    $planetrow = doquery($planetrowQry, 'planets', true); //@todo prefix


    
    CheckPlanetUsedFields($planetrow);
    
} else {
    $planetrow = array();
}