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

require_once ROOT_PATH . 'includes/classes/Legacies/Empire/Shipyard.php';

function PlanetResourceUpdate ( $CurrentUser, &$CurrentPlanet, $UpdateTime, $Simul = false ) {
    global $ProdGrid, $resource, $reslist, $game_config;

    // Mise a jour de l'espace de stockage
    $CurrentPlanet['metal_max']     = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[22] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));
    $CurrentPlanet['crystal_max']   = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[23] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));
    $CurrentPlanet['deuterium_max'] = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[24] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));

    // Calcul de l'espace de stockage (avec les debordements possibles)
    $MaxMetalStorage                = $CurrentPlanet['metal_max']     * MAX_OVERFLOW;
    $MaxCristalStorage              = $CurrentPlanet['crystal_max']   * MAX_OVERFLOW;
    $MaxDeuteriumStorage            = $CurrentPlanet['deuterium_max'] * MAX_OVERFLOW;

    // Calcul de production lin�aire des divers types
    //$Caps is set to null to prevent NOTICE errors
    $Caps             = array('metal_perhour' => 0, 'crystal_perhour' => 0, 'deuterium_perhour' => 0, 'energy_used' => 0, 'energy_max' => 0);
    $BuildTemp        = $CurrentPlanet[ 'temp_max' ];

    for ( $ProdID = 0; $ProdID < 300; $ProdID++ ) {
        if ( in_array( $ProdID, $reslist['prod']) ) {
            $BuildLevelFactor = $CurrentPlanet[ $resource[$ProdID]."_porcent" ];
            $BuildLevel       = $CurrentPlanet[ $resource[$ProdID] ];
            $Caps['metal_perhour']     +=  floor( eval  ( $ProdGrid[$ProdID]['formule']['metal']     ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
            $Caps['crystal_perhour']   +=  floor( eval  ( $ProdGrid[$ProdID]['formule']['crystal']   ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
            $Caps['deuterium_perhour'] +=  floor( eval  ( $ProdGrid[$ProdID]['formule']['deuterium'] ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
            if ($ProdID < 4) {
                $Caps['energy_used']   +=  floor( eval  ( $ProdGrid[$ProdID]['formule']['energy']    ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_ingenieur'] * 0.05 ) ) );
            } elseif ($ProdID >= 4 ) {
                $Caps['energy_max']    +=  floor( eval  ( $ProdGrid[$ProdID]['formule']['energy']    ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_ingenieur'] * 0.05 ) ) );
            }
        }
    }

    // Il n'y a pas de production de base sur une lune (ni de production tout court d'ailleurs
    if ($CurrentPlanet['planet_type'] == 3) {
        $game_config['metal_basic_income']     = 0;
        $game_config['crystal_basic_income']   = 0;
        $game_config['deuterium_basic_income'] = 0;
        $CurrentPlanet['metal_perhour']        = 0;
        $CurrentPlanet['crystal_perhour']      = 0;
        $CurrentPlanet['deuterium_perhour']    = 0;
        $CurrentPlanet['energy_used']          = 0;
        $CurrentPlanet['energy_max']           = 0;
    } else {
        $CurrentPlanet['metal_perhour']        = $Caps['metal_perhour'];
        $CurrentPlanet['crystal_perhour']      = $Caps['crystal_perhour'];
        $CurrentPlanet['deuterium_perhour']    = $Caps['deuterium_perhour'];
        $CurrentPlanet['energy_used']          = $Caps['energy_used'];
        $CurrentPlanet['energy_max']           = $Caps['energy_max'];
    }

    // Depuis quand n'avons nous pas les infos ressources a jours ?
    $ProductionTime               = ($UpdateTime - $CurrentPlanet['last_update']);
    $CurrentPlanet['last_update'] = $UpdateTime;

    if ($CurrentPlanet['energy_max'] == 0) {
        // Ah ha ... l'energie max est 0 ...
        // Soit pas de production d'energie ... Soit mode vacance
        $CurrentPlanet['metal_perhour']     = $game_config['metal_basic_income'];
        $CurrentPlanet['crystal_perhour']   = $game_config['crystal_basic_income'];
        $CurrentPlanet['deuterium_perhour'] = $game_config['deuterium_basic_income'];
        $production_level            = 100;
    } elseif ($CurrentPlanet["energy_max"] >= $CurrentPlanet["energy_used"]) {
        // Cas normal (Y a assez d'energie toutes les mines tournent a plein rendement)
        $production_level            = 100;
    } else {
        // Cas ou il manque de l'energie ... On calcule un pourcentage de production
        $production_level            = floor(($CurrentPlanet['energy_max'] / $CurrentPlanet['energy_used']) * 100);
    }
    // Mise a l'echele des valeurs
    if       ($production_level > 100) {
        $production_level = 100;
    } elseif ($production_level < 0) {
        $production_level = 0;
    }

    if ( $CurrentPlanet['metal'] <= $MaxMetalStorage ) {
        $MetalProduction = (($ProductionTime * ($CurrentPlanet['metal_perhour'] / 3600)) * $game_config['resource_multiplier']) * (0.01 * $production_level);
        $MetalBaseProduc = (($ProductionTime * ($game_config['metal_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
        $MetalTheorical  = $CurrentPlanet['metal'] + $MetalProduction  +  $MetalBaseProduc;
        if ( $MetalTheorical <= $MaxMetalStorage ) {
            $CurrentPlanet['metal']  = $MetalTheorical;
        } else {
            $CurrentPlanet['metal']  = $MaxMetalStorage;
        }
    }

    if ( $CurrentPlanet['crystal'] <= $MaxCristalStorage ) {
        $CristalProduction = (($ProductionTime * ($CurrentPlanet['crystal_perhour'] / 3600)) * $game_config['resource_multiplier']) * (0.01 * $production_level);
        $CristalBaseProduc = (($ProductionTime * ($game_config['crystal_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
        $CristalTheorical  = $CurrentPlanet['crystal'] + $CristalProduction  +  $CristalBaseProduc;
        if ( $CristalTheorical <= $MaxCristalStorage ) {
            $CurrentPlanet['crystal']  = $CristalTheorical;
        } else {
            $CurrentPlanet['crystal']  = $MaxCristalStorage;
        }
    }

    if ( $CurrentPlanet['deuterium'] <= $MaxDeuteriumStorage ) {
        $DeuteriumProduction = (($ProductionTime * ($CurrentPlanet['deuterium_perhour'] / 3600)) * $game_config['resource_multiplier']) * (0.01 * $production_level);
        $DeuteriumBaseProduc = (($ProductionTime * ($game_config['deuterium_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
        $DeuteriumTheorical  = $CurrentPlanet['deuterium'] + $DeuteriumProduction  +  $DeuteriumBaseProduc;
        if ( $DeuteriumTheorical <= $MaxDeuteriumStorage ) {
            $CurrentPlanet['deuterium']  = $DeuteriumTheorical;
        } else {
            $CurrentPlanet['deuterium']  = $MaxDeuteriumStorage;
        }
    }

    if ($Simul == false) {
        $shipyard = Legacies_Empire_Shipyard::factory($CurrentPlanet, $CurrentUser);
        $shipyard->updateQueue();
        $CurrentPlanet = $shipyard->save();
    }

}
