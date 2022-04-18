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

include(ROOT_PATH . 'includes/functions/FlyingFleetHandler.php');
include(ROOT_PATH . 'includes/functions/MissionCaseAttack.php');
include(ROOT_PATH . 'includes/functions/MissionCaseStay.php');
include(ROOT_PATH . 'includes/functions/MissionCaseStayAlly.php');
include(ROOT_PATH . 'includes/functions/MissionCaseTransport.php');
include(ROOT_PATH . 'includes/functions/MissionCaseSpy.php');
include(ROOT_PATH . 'includes/functions/MissionCaseRecycling.php');
include(ROOT_PATH . 'includes/functions/MissionCaseDestruction.php');
include(ROOT_PATH . 'includes/functions/MissionCaseColonisation.php');
include(ROOT_PATH . 'includes/functions/MissionCaseExpedition.php');
include(ROOT_PATH . 'includes/functions/SendSimpleMessage.php');
include(ROOT_PATH . 'includes/functions/SpyTarget.php');
include(ROOT_PATH . 'includes/functions/RestoreFleetToPlanet.php');
include(ROOT_PATH . 'includes/functions/StoreGoodsToPlanet.php');
include(ROOT_PATH . 'includes/functions/CheckPlanetBuildingQueue.php');
include(ROOT_PATH . 'includes/functions/CheckPlanetUsedFields.php');
include(ROOT_PATH . 'includes/functions/CreateOneMoonRecord.php');
include(ROOT_PATH . 'includes/functions/CreateOnePlanetRecord.php');
include(ROOT_PATH . 'includes/functions/InsertJavaScriptChronoApplet.php');
include(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.php');
include(ROOT_PATH . 'includes/functions/GetBuildingTime.php');
include(ROOT_PATH . 'includes/functions/GetBuildingTimeLevel.php');
include(ROOT_PATH . 'includes/functions/GetRestPrice.php');
include(ROOT_PATH . 'includes/functions/GetElementPrice.php');
include(ROOT_PATH . 'includes/functions/GetBuildingPrice.php');
include(ROOT_PATH . 'includes/functions/IsElementBuyable.php');
include(ROOT_PATH . 'includes/functions/CheckCookies.php');
include(ROOT_PATH . 'includes/functions/ChekUser.php');
include(ROOT_PATH . 'includes/functions/InsertGalaxyScripts.php');
include(ROOT_PATH . 'includes/functions/GalaxyCheckFunctions.php');
include(ROOT_PATH . 'includes/functions/ShowGalaxyRows.php');
include(ROOT_PATH . 'includes/functions/GetPhalanxRange.php');
include(ROOT_PATH . 'includes/functions/GetMissileRange.php');
include(ROOT_PATH . 'includes/functions/GalaxyRowPos.php');
include(ROOT_PATH . 'includes/functions/GalaxyRowPlanet.php');
include(ROOT_PATH . 'includes/functions/GalaxyRowPlanetName.php');
include(ROOT_PATH . 'includes/functions/GalaxyRowMoon.php');
include(ROOT_PATH . 'includes/functions/GalaxyRowDebris.php');
include(ROOT_PATH . 'includes/functions/GalaxyRowUser.php');
include(ROOT_PATH . 'includes/functions/GalaxyRowAlly.php');
include(ROOT_PATH . 'includes/functions/GalaxyRowActions.php');
include(ROOT_PATH . 'includes/functions/ShowGalaxySelector.php');
include(ROOT_PATH . 'includes/functions/ShowGalaxyMISelector.php');
include(ROOT_PATH . 'includes/functions/ShowGalaxyTitles.php');
include(ROOT_PATH . 'includes/functions/GalaxyLegendPopup.php');
include(ROOT_PATH . 'includes/functions/ShowGalaxyFooter.php');
include(ROOT_PATH . 'includes/functions/GetMaxConstructibleElements.php');
include(ROOT_PATH . 'includes/functions/GetElementRessources.php');
include(ROOT_PATH . 'includes/functions/ElementBuildListBox.php');
include(ROOT_PATH . 'includes/functions/ElementBuildListQueue.php');
include(ROOT_PATH . 'includes/functions/FleetBuildingPage.php');
include(ROOT_PATH . 'includes/functions/DefensesBuildingPage.php');
include(ROOT_PATH . 'includes/functions/ResearchBuildingPage.php');
include(ROOT_PATH . 'includes/functions/BatimentBuildingPage.php');
include(ROOT_PATH . 'includes/functions/CheckLabSettingsInQueue.php');
include(ROOT_PATH . 'includes/functions/InsertBuildListScript.php');
include(ROOT_PATH . 'includes/functions/AddBuildingToQueue.php');
include(ROOT_PATH . 'includes/functions/ShowBuildingQueue.php');
include(ROOT_PATH . 'includes/functions/HandleTechnologieBuild.php');
include(ROOT_PATH . 'includes/functions/BuildingSavePlanetRecord.php');
include(ROOT_PATH . 'includes/functions/BuildingSaveUserRecord.php');
include(ROOT_PATH . 'includes/functions/RemoveBuildingFromQueue.php');
include(ROOT_PATH . 'includes/functions/CancelBuildingFromQueue.php');
include(ROOT_PATH . 'includes/functions/SetNextQueueElementOnTop.php');
include(ROOT_PATH . 'includes/functions/ShowTopNavigationBar.php');
include(ROOT_PATH . 'includes/functions/SetSelectedPlanet.php');
include(ROOT_PATH . 'includes/functions/MessageForm.php');
include(ROOT_PATH . 'includes/functions/PlanetResourceUpdate.php');
include(ROOT_PATH . 'includes/functions/SendNewPassword.php');
include(ROOT_PATH . 'includes/functions/UpdatePlanetBatimentQueueList.php');
include(ROOT_PATH . 'includes/functions/IsOfficierAccessible.php');
include(ROOT_PATH . 'includes/functions/CheckInputStrings.php');
include(ROOT_PATH . 'includes/functions/MipCombatEngine.php');
include(ROOT_PATH . 'includes/functions/DeleteSelectedUser.php');
include(ROOT_PATH . 'includes/functions/SortUserPlanets.php');
include(ROOT_PATH . 'includes/functions/BuildFleetEventTable.php');
include(ROOT_PATH . 'includes/functions/ResetThisFuckingCheater.php');
include(ROOT_PATH . 'includes/functions/IsVacationMode.php');

//Only if authlevel > player level 
if(defined('IN_ADMIN') && IN_ADMIN == true){
    include(ROOT_PATH . 'includes/functions/BuildFlyingFleetTable.php');
}

