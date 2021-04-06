<?php
/**
 * Tis file is part of XNova:Legacies
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
define('IN_ADMIN', true);
require_once dirname(dirname(__FILE__)) .'/common.php';
includeLang('credit');
$parse   = $lang;

if (in_array($user['authlevel'], array(LEVEL_ADMIN))) {
	if ($_POST['opt_save'] == "1") {
		// Extended copyright is activated?
		if (isset($_POST['ExtCopyFrame']) && $_POST['ExtCopyFrame'] == 'on') {
			$game_config['ExtCopyFrame'] = "1";
			$game_config['ExtCopyOwner'] = $_POST['ExtCopyOwner'];
			$game_config['ExtCopyFunct'] = $_POST['ExtCopyFunct'];
		} else {
			$game_config['ExtCopyFrame'] = "0";
			$game_config['ExtCopyOwner'] = "";
			$game_config['ExtCopyFunct'] = "";
		}

		// Update values
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ExtCopyFrame'] ."' WHERE `config_name` = 'ExtCopyFrame';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ExtCopyOwner'] ."' WHERE `config_name` = 'ExtCopyOwner';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ExtCopyFunct'] ."' WHERE `config_name` = 'ExtCopyFunct';", 'config');

		AdminMessage ($lang['cred_done'], $lang['cred_ext']);

	} else {
		//View values
		$parse['ExtCopyFrame'] = ($game_config['ExtCopyFrame'] == 1) ? " checked = 'checked' ":"";
		$parse['ExtCopyOwnerVal'] = $game_config['ExtCopyOwner'];
		$parse['ExtCopyFunctVal'] = $game_config['ExtCopyFunct'];

		$BodyTPL = gettemplate('admin/credit_body');
		$page = parsetemplate($BodyTPL, $parse);
		display($page, $lang['cred_credit'], false);
	}

} else {
	message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

?>