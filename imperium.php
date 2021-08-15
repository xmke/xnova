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

define('INSIDE', true);
define('INSTALL', false);
require_once dirname(__FILE__) . '/common.php';

includeLang('imperium');

$Order = ($user['planet_sort_order'] == 1) ? "DESC" : "ASC";
$Sort  = $user['planet_sort'];
$user = MergeUserTechnology($user);
$QryPlanets  = "SELECT * FROM {{table}} WHERE `id_owner` = '" . $user['id'] . "' ORDER BY ";
if ($Sort == 0) {
	$QryPlanets .= "`id` " . $Order;
} elseif ($Sort == 1) {
	$QryPlanets .= "`galaxy`, `system`, `planet`, `planet_type` " . $Order;
} elseif ($Sort == 2) {
	$QryPlanets .= "`name` " . $Order;
}
$planetsrow = doquery($QryPlanets, 'planets');

$planet = array();
$parse  = $lang;

while ($p = mysqli_fetch_array($planetsrow)) {
	$planet[] = $p;
}

$parse['mount'] = count($planet) + 1;
// primera tabla, con las imagenes y coordenadas
$row  = gettemplate('imperium_row');
$row2 = gettemplate('imperium_row2');

$parse['file_images'] 		= "";
$parse['file_names'] 		= "";
$parse['file_coordinates'] 	= "";
$parse['file_fields'] 		= "";
$parse['file_metal'] 		= "";
$parse['file_crystal'] 		= "";
$parse['file_deuterium'] 	= "";
$parse['file_energy'] 		= "";
foreach ($planet as $p) {
	// {file_images}
	$data['text'] = '<a href="overview.php?cp=' . $p['id'] . '&amp;re=0"><img src="skins/epicblue/planeten/small/s_' . $p['image'] . '.jpg" border="0" height="71" width="75"></a>';
	$parse['file_images'] .= $MustacheEngine->render($row, $data);
	// {file_names}
	$data['text'] = $p['name'];
	$parse['file_names'] .= $MustacheEngine->render($row2, $data);
	// {file_coordinates}
	$data['text'] = "[<a href=\"galaxy.php?mode=3&galaxy={$p['galaxy']}&system={$p['system']}\">{$p['galaxy']}:{$p['system']}:{$p['planet']}</a>]";
	$parse['file_coordinates'] .= $MustacheEngine->render($row2, $data);
	// {file_fields}
	$data['text'] = $p['field_current'] . '/' . $p['field_max'];
	$parse['file_fields'] .= $MustacheEngine->render($row2, $data);
	// {file_metal}
	$data['text'] = '<a href="resources.php?cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">' . pretty_number($p['metal']) . '</a> / ' . pretty_number($p['metal_perhour']);
	$parse['file_metal'] .= $MustacheEngine->render($row2, $data);
	// {file_crystal}
	$data['text'] = '<a href="resources.php?cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">' . pretty_number($p['crystal']) . '</a> / ' . pretty_number($p['crystal_perhour']);
	$parse['file_crystal'] .= $MustacheEngine->render($row2, $data);
	// {file_deuterium}
	$data['text'] = '<a href="resources.php?cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">' . pretty_number($p['deuterium']) . '</a> / ' . pretty_number($p['deuterium_perhour']);
	$parse['file_deuterium'] .= $MustacheEngine->render($row2, $data);
	// {file_energy}
	$data['text'] = pretty_number($p['energy_max'] - $p['energy_used']) . ' / ' . pretty_number($p['energy_max']);
	$parse['file_energy'] .= $MustacheEngine->render($row2, $data);

	foreach ($resource as $i => $res) {
		if (in_array($i, $reslist['build']))
			$data['text'] = ($p[$resource[$i]]    == 0) ? '-' : "<a href=\"buildings.php?cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>";
		elseif (in_array($i, $reslist['tech']))
			$data['text'] = ($user[$resource[$i]] == 0) ? '-' : "<a href=\"buildings.php?mode=research&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$user[$resource[$i]]}</a>";
		elseif (in_array($i, $reslist['fleet']))
			$data['text'] = ($p[$resource[$i]]    == 0) ? '-' : "<a href=\"buildings.php?mode=fleet&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>";
		elseif (in_array($i, $reslist['defense']))
			$data['text'] = ($p[$resource[$i]]    == 0) ? '-' : "<a href=\"buildings.php?mode=defense&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>";

		@$r[$i] .= $MustacheEngine->render($row2, $data);
	}
}

// {building_row}
$parse['building_row'] = "";
foreach ($reslist['build'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['building_row'] .= "<tr>" . $MustacheEngine->render($row2, $data) . $r[$i] . "</tr>";
}
// {technology_row}
$parse['technology_row'] = "";
foreach ($reslist['tech'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['technology_row'] .= "<tr>" . $MustacheEngine->render($row2, $data) . $r[$i] . "</tr>";
}
// {fleet_row}
$parse['fleet_row'] = "";
foreach ($reslist['fleet'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['fleet_row'] .= "<tr>" . $MustacheEngine->render($row2, $data) . $r[$i] . "</tr>";
}
// {defense_row}
$parse['defense_row'] = "";
foreach ($reslist['defense'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['defense_row'] .= "<tr>" . $MustacheEngine->render($row2, $data) . $r[$i] . "</tr>";
}

$page = $MustacheEngine->render(gettemplate('imperium_table'), $parse);

display($page, $lang['imperium_vision'], false);
// Created by Perberos. All rights reserved (C) 2006
