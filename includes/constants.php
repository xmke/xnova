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

define('ADMINEMAIL', "admin@xnova-ng.org");
define('GAMEURL', "http://".$_SERVER['HTTP_HOST']."/");

// Definition du monde connu !
define('MAX_GALAXY_IN_WORLD', 9);
define('MAX_SYSTEM_IN_GALAXY', 499);
define('MAX_PLANET_IN_SYSTEM', 15);

define('LEVEL_ADMIN', 3);
define('LEVEL_OPERATOR', 2);
define('LEVEL_MODERATOR', 1);
define('LEVEL_PLAYER', 0);

// Nombre de colones pour les rapports d'espionnage
define('SPY_REPORT_ROW'           , 2);

// Cases données par niveau de Base Lunaire
define('FIELDS_BY_MOONBASIS_LEVEL', 4);

// Nombre maximum de colonie par joueur
define('MAX_PLAYER_PLANETS'       , 9000);
// Nombre maximum d'element dans la liste de construction de batiments

define('MAX_BUILDING_QUEUE_SIZE'  , 5);
// Nombre maximum d'element dans une ligne de liste de construction flotte et defenses
define('MAX_FLEET_OR_DEFS_PER_ROW', 100000000);
// Taux de depassement possible dans l'espace de stockage des hangars ...
// 1.0 pour 100% - 1.1 pour 110% etc ...
define('MAX_OVERFLOW'             , 1.1);
// Affiche les administrateur dans la page des records ...
// 0 -> les affiche
// 1 -> les affiche pas
define('SHOW_ADMIN_IN_RECORDS'    , 0);

// Valeurs de bases pour les colonies ou planetes fraichement crées
define('BASE_STORAGE_SIZE'        , 10000000);
define('BUILD_METAL'              , 500);
define('BUILD_CRISTAL'            , 500);
define('BUILD_DEUTERIUM'          , 0);
