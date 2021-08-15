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

function ShowTopNavigationBar ( $CurrentUser, $CurrentPlanet ) { 
	global $lang, $_GET, $MustacheEngine;

//	debug_print_backtrace();

	if ($CurrentUser) {
		// Actualisation des ressources de la planete
		PlanetResourceUpdate($CurrentUser, $CurrentPlanet, time());
		$NavigationTPL       = gettemplate('topnav');

		$parse               = $lang;
		$parse['image']      = $CurrentPlanet['image'];

		// Genearation de la combo des planetes du joueur
		$PlanetList = array();
		//$parse['planetlist'] = '';
		$ThisUsersPlanets    = SortUserPlanets ( $CurrentUser );
		while ($CurPlanet = mysqli_fetch_array($ThisUsersPlanets)) {
			if ($CurPlanet["destruyed"] == 0) {
				$PlanetList[] = array("currentSelectedPlanet" => $CurPlanet['id'] == $CurrentUser['current_planet'], "id" => $CurPlanet['id'], "name" => $CurPlanet['name'], "galaxy" => $CurPlanet['galaxy'], "system" => $CurPlanet['system'], "planet" => $CurPlanet['planet']);
			}
		}
		$parse['planetlist'] = $PlanetList;
		$energy = pretty_number($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) . "/" . pretty_number($CurrentPlanet["energy_max"]);
		// Energie
		if (($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) < 0) {
			$parse['energy'] = colorRed($energy);
		} else {
			$parse['energy'] = $energy;
		}
		// Metal
		$metal = pretty_number($CurrentPlanet["metal"]);
		if (($CurrentPlanet["metal"] > $CurrentPlanet["metal_max"])) {
			$parse['metal'] = colorRed($metal);
		} else {
			$parse['metal'] = $metal;
		}
		// Cristal
		$crystal = pretty_number($CurrentPlanet["crystal"]);
		if (($CurrentPlanet["crystal"] > $CurrentPlanet["crystal_max"])) {
			$parse['crystal'] = colorRed($crystal);
		} else {
			$parse['crystal'] = $crystal;
		}
		// Deuterium
		$deuterium = pretty_number($CurrentPlanet["deuterium"]);
		if (($CurrentPlanet["deuterium"] > $CurrentPlanet["deuterium_max"])) {
			$parse['deuterium'] = colorRed($deuterium);
		} else {
			$parse['deuterium'] = $deuterium;
		}

		// Message
		if ($CurrentUser['new_message'] > 0) {
			$parse['message'] = "<a href=\"messages.php\">[ ". $CurrentUser['new_message'] ." ]</a>";
		} else {
			$parse['message'] = "0";
		}

		// Le tout passe dans la template
		$TopBar = $MustacheEngine->render( $NavigationTPL, $parse);
	} else {
		$TopBar = "";
	}

	return $TopBar;
}

?>
