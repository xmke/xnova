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

function CheckPlanetUsedFields ( &$planet ) {
	global $resource;

	if(isset($planet)){

		// Tous les batiments	
		$CountedParcels = array(1,2,3,4,12,14,15,21,22,23,24,31,33,34,44,41,42,43);
			
		$cfc = 0;
		if(isset($resource)){
			foreach($CountedParcels as $val){
				$cfc += isset($planet[$resource[$val]]) ? $planet[$resource[$val]] : 0;
			}
		}

		// Mise a jour du nombre de case dans la BDD si incorrect
		if ((!isset($planet['field_current']) || $planet['field_current'] != $cfc) && isset($planet['id'])) {
			$planet['field_current'] = $cfc;
			doquery("UPDATE {{table}} SET field_current=$cfc WHERE id={$planet['id']}", 'planets');
		}
	}
	
}

?>