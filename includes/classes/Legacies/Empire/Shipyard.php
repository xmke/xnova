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

/**
 *
 * Enter description here ...
 * @author Greg
 *
 */
class Legacies_Empire_Shipyard
{
    protected $_currentPlanet = null;
    protected $_currentUser = null;
    protected $_queue = null;

    private $_now = 0;

    protected $_resourcesTypes = array(
        Legacies_Empire::RESOURCE_METAL,
        Legacies_Empire::RESOURCE_CRISTAL,
        Legacies_Empire::RESOURCE_DEUTERIUM
        );

    protected static $_instances = array();

    public static function factory($currentPlanet, $currentUser)
    {
        if (!isset($currentPlanet['id'])) {
            return false;
        }

        if (!isset(self::$_instances[$currentPlanet['id']])) {
            self::$_instances[$currentPlanet['id']] = new self($currentPlanet, $currentUser);
        }
        return self::$_instances[$currentPlanet['id']];
    }

    public function __construct($currentPlanet, $currentUser)
    {
        $this->_currentPlanet = $currentPlanet;
        $this->_currentUser = $currentUser;

        $this->_queue = unserialize($this->_currentPlanet['b_hangar_id']);
        if (!is_array($this->_queue)) {
            $this->_queue = array();
        }

        $this->_now = time();
    }

    protected function _now()
    {
        return $this->_now;
    }

    public function save()
    {
        global $reslist, $resource;

        $this->_currentPlanet['b_hangar_id'] = serialize($this->_queue);

        $sql = "UPDATE {{table}} AS planet SET ";

        $fieldList = array_merge($reslist[Legacies_Empire::TYPE_SHIP], $reslist[Legacies_Empire::TYPE_DEFENSE]);
        foreach ($fieldList as $field) {
            $sql .= "{$resource[$field]}='{$this->_currentPlanet[$resource[$field]]}',";
        }

        foreach ($this->_resourcesTypes as $field) {
            $sql .= "{$field}='{$this->_currentPlanet[$field]}',";
        }

        $escapedQueue = mysqli_real_escape_string (Database::$dbHandle, $this->_currentPlanet['b_hangar_id']);
$sql .=<<<SQL_EOF
  b_hangar_id = "{$escapedQueue}",
  b_hangar    = "{$this->_now()}",
  last_update    = "{$this->_currentPlanet['last_update']}" 
  WHERE planet.id={$this->_currentPlanet['id']}
  /*save*/
SQL_EOF;
        doquery($sql, 'planets'); // FIXME
        //die($this->_currentPlanet['energy_max'] + $this->_currentPlanet["energy_used"]);
        return $this->_currentPlanet;
    }

    public function appendQueue($shipId, $qty)
    {
        global $reslist;

        if (bccomp($qty, 0) <= 0) {
            return $this;
        }

        if (!in_array($shipId, $reslist[Legacies_Empire::TYPE_SHIP]) && !in_array($shipId, $reslist[Legacies_Empire::TYPE_DEFENSE])) {
            return $this;
        }

        if (!$this->checkAvailability($shipId)) {
            return $this;
        }

        $qty = $this->_checkMaximumQuantity($shipId, $qty);

        if (MAX_FLEET_OR_DEFS_PER_ROW > 0 && bccomp($qty, MAX_FLEET_OR_DEFS_PER_ROW) > 0) {
            $qty = MAX_FLEET_OR_DEFS_PER_ROW;
        }

        $resourcesUsed = $this->_updateResources($shipId, $qty);
        $buildTime = $this->getBuildTime($shipId, $qty);

        $this->_queue[] = array(
            'ship_id'    => $shipId,
            'qty'        => $qty,
            'created_at' => $this->_now(),
            'updated_at' => $this->_now()
            );

        foreach ($this->_resourcesTypes as $resourceType) {
            if(isset($this->_currentPlanet[$resourceType]) && isset($resourcesUsed[$resourceType])){
                $this->_currentPlanet[$resourceType] = bcsub($this->_currentPlanet[$resourceType], $resourcesUsed[$resourceType]);
            }
        }

        return $this;
    }

    public function updateQueue()
    {
        global $resource;

        $elapsedTime = $this->_now() - $this->_currentPlanet['b_hangar'];

        foreach ($this->_queue as $id => &$element) {
            $buildTime = $this->getBuildTime($element['ship_id'], $element['qty']);

            if ($elapsedTime >= $buildTime) {
                $this->_currentPlanet[$resource[$element['ship_id']]] = bcadd($this->_currentPlanet[$resource[$element['ship_id']]], $element['qty']);
                $elapsedTime -= $buildTime;
                unset($this->_queue[$id]);
                continue;
            }

            $timeRatio = $elapsedTime / $buildTime;
            $itemsBuilt = bcmul($timeRatio, $element['qty']);

            $element['updated_at'] = $this->_now();
            $element['qty'] = bcsub($element['qty'], $itemsBuilt);
            $this->_currentPlanet[$resource[$element['ship_id']]] = bcadd($this->_currentPlanet[$resource[$element['ship_id']]], $itemsBuilt);
            break;
        }
        unset($element);

        return $this;
    }

    public function getQueue()
    {
        return $this->_queue;
    }

    public function checkAvailability($shipId)
    {
        global $requirements, $resource, $reslist;

        if (!isset($requirements[$shipId]) || empty($requirements[$shipId])) {
            return true;
        }

        foreach ($requirements[$shipId] as $requirement => $level) {
            if (in_array($requirement, $reslist[Legacies_Empire::TYPE_BUILDING]) &&
                isset($this->_currentPlanet[$resource[$requirement]]) &&
                $this->_currentPlanet[$resource[$requirement]] >= $level) {
                continue;
            } else if (in_array($requirement, $reslist[Legacies_Empire::TYPE_RESEARCH]) &&
                isset($this->_currentUser[$resource[$requirement]]) &&
                $this->_currentUser[$resource[$requirement]] >= $level) {
                continue;
            } else if (in_array($requirement, $reslist[Legacies_Empire::TYPE_DEFENSE]) &&
                isset($this->_currentPlanet[$resource[$requirement]]) &&
                $this->_currentPlanet[$resource[$requirement]] >= $level) {
                continue;
            } else if (in_array($requirement, $reslist[Legacies_Empire::TYPE_SHIP]) &&
                isset($this->_currentPlanet[$resource[$requirement]]) &&
                $this->_currentPlanet[$resource[$requirement]] >= $level) {
                continue;
            }
            return false;
        }
        return true;
    }

    protected function _checkMaximumQuantity($shipId, $qty)
    {
        $max = $this->getMaximumBuildableElementsCount($shipId);
        //die("qty: ".$qty." max: ". $max);
        if (bccomp($qty, $max) > 0) {
            return $max;
        }

        return $qty;
    }

    public function getMaximumBuildableElementsCount($shipId)
    {
        global $pricelist, $resource;

        $resources = array(
            Legacies_Empire::RESOURCE_METAL,
            Legacies_Empire::RESOURCE_CRISTAL,
            Legacies_Empire::RESOURCE_DEUTERIUM,
            Legacies_Empire::RESOURCE_ENERGY
            );

        $qty = 0;
        foreach ($resources as $resourceId) {
            if (isset($pricelist[$shipId]) && isset($pricelist[$shipId][$resourceId]) && $pricelist[$shipId][$resourceId] > 0) {
                $maxQty = bcdiv($this->_currentPlanet[$resourceId], $pricelist[$shipId][$resourceId]);

                if (bccomp($maxQty, $qty) > 0) {
                    $qty = $maxQty;
                }
            }
        }

        $limitedElementsQty = array(
            Legacies_Empire::ID_DEFENSE_SMALL_SHIELD_DOME      => array(
                'current'   => $this->_currentPlanet[$resource[Legacies_Empire::ID_DEFENSE_SMALL_SHIELD_DOME]],
                'requested' => $this->_currentPlanet[$resource[Legacies_Empire::ID_DEFENSE_SMALL_SHIELD_DOME]],
                'limit'     => 1
                ),
            Legacies_Empire::ID_DEFENSE_LARGE_SHIELD_DOME      => array(
                'current'   => $this->_currentPlanet[$resource[Legacies_Empire::ID_DEFENSE_LARGE_SHIELD_DOME]],
                'requested' => $this->_currentPlanet[$resource[Legacies_Empire::ID_DEFENSE_LARGE_SHIELD_DOME]],
                'limit'     => 1
                ),
            Legacies_Empire::ID_SPECIAL_ANTIBALLISTIC_MISSILE  => array(
                'current'   => $this->_currentPlanet[$resource[Legacies_Empire::ID_SPECIAL_ANTIBALLISTIC_MISSILE]],
                'requested' => $this->_currentPlanet[$resource[Legacies_Empire::ID_SPECIAL_ANTIBALLISTIC_MISSILE]],
                'limit'     => $this->_currentPlanet[$resource[Legacies_Empire::ID_BUILDING_MISSILE_SILO]] * 10
                ),
            Legacies_Empire::ID_SPECIAL_INTERPLANETARY_MISSILE => array(
                'current'   => $this->_currentPlanet[$resource[Legacies_Empire::ID_SPECIAL_INTERPLANETARY_MISSILE]],
                'requested' => $this->_currentPlanet[$resource[Legacies_Empire::ID_SPECIAL_INTERPLANETARY_MISSILE]],
                'limit'     => $this->_currentPlanet[$resource[Legacies_Empire::ID_BUILDING_MISSILE_SILO]] * 5
                )
            );

        if (in_array($shipId, array_keys($limitedElementsQty))) {
            foreach ($this->_queue as $element) {
                if ($element['ship_id'] != $shipId) {
                    continue;
                }

                $limitedElementsQty[$shipId]['requested'] = bcadd($limitedElementsQty[$shipId]['requested'], $element['qty']);
                if (bccomp($limitedElementsQty[$shipId]['requested'], $limitedElementsQty[$shipId]['limit']) >= 0) {
                    return 0;
                }
            }
            if (bccomp($limitedElementsQty[$shipId]['current'], $limitedElementsQty[$shipId]['limit']) >= 0) {
                return 0;
            }
            if (bccomp($qty, $limitedElementsQty[$shipId]['limit']) >= 0) {
                return $limitedElementsQty[$shipId]['limit'];
            }
        }
        
        return $qty;
    }

    protected function _updateResources($shipId, $qty)
    {
        global $pricelist;

        $resourcesUsed = array();
        foreach ($this->_resourcesTypes as $resourceId) {
            if (isset($pricelist[$shipId]) && isset($pricelist[$shipId][$resourceId]) && $pricelist[$shipId][$resourceId] > 0) {
                $resourcesUsed[$resourceId] = bcmul($pricelist[$shipId][$resourceId], $qty);
            }
        }

        return $resourcesUsed;
    }

    public function getBuildTime($shipId, $qty)
    {
        global $pricelist, $resource, $reslist, $game_config;

        $scale = 30;

        $totalCost = bcmul(bcadd($pricelist[$shipId][Legacies_Empire::RESOURCE_METAL], $pricelist[$shipId][Legacies_Empire::RESOURCE_CRISTAL]), $qty, $scale);
        $speedFactor = $game_config['game_speed'];

        $shipyardSpeedup = bcdiv(1, bcadd($this->_currentPlanet[$resource[Legacies_Empire::ID_BUILDING_SHIPYARD]], 1, $scale), $scale);
        $naniteSpeedup = bcpow(.5, $this->_currentPlanet[$resource[Legacies_Empire::ID_BUILDING_NANITE_FACTORY]], $scale);
        $structuresSpeedup = bcmul($shipyardSpeedup, $naniteSpeedup, $scale);

        $officerSpeedup = 1;
        if (in_array($shipId, $reslist[Legacies_Empire::TYPE_SHIP])) {
            $officerSpeedup = 1 - ($this->_currentUser['rpg_technocrate'] * .05);
        } else if (in_array($shipId, $reslist[Legacies_Empire::TYPE_SPECIAL])) {
            $officerSpeedup = 1 - ($this->_currentUser['rpg_technocrate'] * .05);
        } else if (in_array($shipId, $reslist[Legacies_Empire::TYPE_DEFENSE])) {
            $officerSpeedup = 1 - ($this->_currentUser['rpg_defenseur'] * .375);
        }

        $baseTime = ($totalCost / $speedFactor) * $structuresSpeedup;

        return $baseTime * $officerSpeedup * 3600;
    }
}