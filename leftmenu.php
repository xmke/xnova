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
define('QRYLESS', true);
require_once dirname(__FILE__) .'/common.php';

function ShowLeftMenu ( $Level , $Template = 'left_menu') {
	global $lang, $user, $game_config, $MustacheEngine;

	includeLang('leftmenu');

	$MenuTPL                  = gettemplate( $Template );
	$parse                    = $lang;
	$parse['lm_tx_serv']      = $game_config['resource_multiplier'];
	$parse['lm_tx_game']      = $game_config['game_speed'] / 2500;
	$parse['lm_tx_fleet']     = $game_config['fleet_speed'] / 2500;
	$parse['lm_tx_queue']     = MAX_FLEET_OR_DEFS_PER_ROW;

	$parse['XNovaRelease']    = VERSION;
	$parse['forum_url']       = $game_config['forum_url'];
	$parse['mf']              = "Hauptframe";
	$parse['userIsAdmin'] = $Level > 0;
	
	//Lien suppl�mentaire d�termin� dans le panel admin
	$parse['link_enable'] = $game_config['link_enable'] == 1;
	if($parse['link_enable']){
		$parse["link_url"] = $game_config['link_url'];
		$parse["link_name"] = $game_config['link_name'];
	}else{
		$parse["link_url"] = "";
		$parse["link_name"] = "";
	}

	//Maintenant on v�rifie si les annonces sont activ�es ou non
	$parse["enable_announces"] = $game_config['enable_announces'] == 1;
	//Maintenant le marchand
	$parse["enable_marchand"] = $game_config['enable_marchand'] == 1;
	//Maintenant les notes
	$parse["enable_notes"] = $game_config['enable_notes'] == 1;
	
	$parse['servername']   = $game_config['game_name'];
	$Menu                  = $MustacheEngine->render( $MenuTPL, $parse);

	return $Menu;
}
	$Menu = ShowLeftMenu ( $user['authlevel'] );
	display ( $Menu, "Menu", '', false );

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Passage en fonction pour XNova version future
// 1.1 - Modification pour gestion Admin / Game OP / Modo