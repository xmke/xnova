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

function GetElementPrice ($user, $planet, $Element, $userfactor = true) {
	global $pricelist, $resource, $lang;

	if (isset($userfactor)) {
		$level = 0;
        if(isset($planet) && isset($planet[$resource[$Element]])){
            $level  = $planet[$resource[$Element]];
        }else if(isset($user) && isset($user[$resource[$Element]])){
            $level = $user[$resource[$Element]];
        }
	}

	$is_buyeable = true;
	$array = array(
		'metal'      => $lang["Metal"],
		'crystal'    => $lang["Crystal"],
		'deuterium'  => $lang["Deuterium"],
		'energy_max' => $lang["Energy"]
		);

	$text = $lang['Requires'] . ": ";
	foreach ($array as $ResType => $ResTitle) {
		if (isset($pricelist) && isset($pricelist[$Element]) && isset($pricelist[$Element][$ResType]) && $pricelist[$Element][$ResType] != 0) {
			$text .= $ResTitle . ": ";
			if ($userfactor) {
				$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
			} else {
				$cost = floor($pricelist[$Element][$ResType]);
			}
			if ($cost > $planet[$ResType]) {
				$text .= "<b style=\"color:red;\"> <t title=\"-" . pretty_number ($cost - $planet[$ResType]) . "\">";
				$text .= "<span class=\"noresources\">" . pretty_number($cost) . "</span></t></b> ";
				$is_buyeable = false; //style="cursor: pointer;"
			} else {
				$text .= "<b style=\"color:lime;\"> <span class=\"noresources\">" . pretty_number($cost) . "</span></b> ";
			}
		}
	}
	return $text;
}

?>