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

$lang['user_reset_cheater'] = "Une action non autorisée a été détectée et votre compte en était à l'origine. En guise de sanction, votre compte a été remis à zéro par le système. Tricher, c'est pas bien.";
$lang['user_reset_attempt'] = "Tentative de triche";
$lang['user_reset_attempt_adm'] = "Tentative de triche détectée, ID du joueur : ";

$lang['user_level'] = array (
	'0' => 'Joueur',
	'1' => 'Modérateur',
	'2' => 'Opérateur',
	'3' => 'Administrateur',
);

$lang['sys_phalanx'] = "Phalange";
$lang['sys_overview'] = "Vue Générale";
$lang['mod_marchand'] = "Marchand";
$lang['sys_moon'] = "Lune";
$lang['sys_error'] = "Erreur";
$lang['sys_no_vars'] = "Le fichier vars.php n'est pas présent, veuillez contacter un administrateur !";
$lang['sys_attacker_lostunits'] = "L'attaquant a perdu au total %s unités.";
$lang['sys_defender_lostunits'] = "Le défenseur a perdu au total %s unités.";
$lang['sys_gcdrunits'] = "Un champ de débris contenant %s unités de %s et %s unités de %s se forme dans l'orbite de cette planète.";
$lang['sys_moonproba'] = "La probabilitée de création d'une lune est de : %d %% ";
$lang['sys_moonbuilt'] = "Une lune fait son apparition autour de la planète %s [%d:%d:%d] !";
$lang['sys_attack_title']    = "Les flottes suivantes se sont affrontées le %s :";
$lang['sys_attack_attacker_pos'] = "Attaquant %s [%s:%s:%s]";
$lang['sys_attack_techologies'] = "Armes: %d %% Bouclier: %d %% Coque: %d %% ";
$lang['sys_attack_defender_pos'] = "Défenseur %s [%s:%s:%s]";
$lang['sys_ship_type'] = "Type";
$lang['sys_ship_count'] = "Nombre";
$lang['sys_ship_weapon'] = "Armes";
$lang['sys_ship_shield'] = "Bouclier";
$lang['sys_ship_armour'] = "Coque";
$lang['sys_destroyed'] = "Détruit!";
$lang['sys_attack_attack_wave'] = "La flotte attaquante tire avec une puissance de %s sur le défenseur. Les boucliers du défenseur absorbent %s points de dégâts.";
$lang['sys_attack_defend_wave'] = "La flotte défensive tire au total %s sur l'attaquant. Les boucliers de l'attaquant absorbent %s points de dégâts.";
$lang['sys_attacker_won'] = "L'attaquant a gagné la bataille !";
$lang['sys_defender_won'] = "Le défenseur a gagné la bataille !";
$lang['sys_both_won'] = "La bataille se termine par un match nul !";
$lang['sys_stealed_ressources'] = "Il emporte %s unités de %s, %s unités de %s et %s unités de %s.";
$lang['sys_rapport_build_time'] = "Rapport simulé en %s secondes";
$lang['sys_mess_tower'] = "Tour de contrôle";
$lang['sys_mess_attack_report'] = "Rapport de combat";
$lang['sys_spy_maretials'] = "Matières premières sur";
$lang['sys_spy_fleet'] = "Flotte";
$lang['sys_spy_defenses'] = "Défenses";
$lang['sys_mess_qg'] = "Quartier général";
$lang['sys_mess_spy_report'] = "Rapport d\'espionnage";
$lang['sys_mess_spy_lostproba'] = "Probabilité de destruction de la flotte d\'espionnage : %d %% ";
$lang['sys_mess_spy_control'] = "Contrôle aérospatial";
$lang['sys_mess_spy_activity'] = "Activité d'espionnage";
$lang['sys_mess_spy_ennemyfleet'] = "Une flotte ennemie de la planète";
$lang['sys_mess_spy_seen_at'] = "a été aperçue à proximité de votre planète";
$lang['sys_mess_spy_destroyed'] = "Votre flotte a été détruites !";
$lang['sys_object_arrival'] = "Arrivée sur une planète";
$lang['sys_stay_mess_stay'] = "Stationnement de flotte";
$lang['sys_stay_mess_start'] = "Votre flotte atteint la planète ";
$lang['sys_stay_mess_back'] = "Votre flotte retourne à la planète ";
$lang['sys_stay_mess_end'] = " et y livre les ressources suivantes :";
$lang['sys_stay_mess_bend'] = " et y restitue les ressources suivantes :";
$lang['sys_adress_planet'] = "[%s:%s:%s]";
$lang['sys_stay_mess_goods'] = "%s : %s, %s : %s, %s : %s";
$lang['sys_colo_mess_from'] = "Colonisation";
$lang['sys_colo_mess_report'] = "Rapport de colonisation";
$lang['sys_colo_defaultname'] = "Colonie";
$lang['sys_colo_arrival'] = "La flotte atteint les coordonnées ";
$lang['sys_colo_maxcolo'] = ", mais malheureusement la colonisation est impossible, vous ne pouvez pas avoir plus de ";
$lang['sys_colo_allisok'] = ", et les colons commencent à développer cette nouvelle partie de l\'empire.";
$lang['sys_colo_badpos']  = ", et les colons ont trouvé un environnement peu propice à l\'extention de votre empire. Ils ont décidé de rebrousser chemin totalement dégoutés";
$lang['sys_colo_notfree'] = ", et les colons n\'ont pas trouvé de planète à ces coordonnées. Ils sont forcés de rebrousser chemin totalement démoralisés";
$lang['sys_colo_planet']  = " planètes !";
$lang['sys_expe_report'] = "Rapport d\'expédition";
$lang['sys_recy_report'] = "Rapport d\'exploitation";
$lang['sys_expe_blackholl_1'] = "La flotte a été aspirée dans un trou noir, elle est partiellement détruite !";
$lang['sys_expe_blackholl_2'] = "La flotte a été aspirée dans un trou noir, elle est entièrement détruite !";
$lang['sys_expe_nothing_1'] = "Vos explorateurs sont passés à côté d\'une superbe SuperNova et ont prit de magnifiques photos. Mais ils n\'ont trouvés aucune ressources";
$lang['sys_expe_nothing_2'] = "Vos explorateurs ont passés tout le temps imparti dans la zone choisie. Mais ils n\'ont trouvés ni ressources ni planète.";
$lang['sys_expe_found_goods'] = "La flotte a découvert un planète non habitée !<br>Vos explorateurs ont récupérés %s de %s, %s de %s et %s de %s";
$lang['sys_expe_found_ships'] = "Vos explorateurs ont trouvés des vaisseaux abandonnés en parfait état de marche.<br>Ils ont trouvés : ";
$lang['sys_expe_back_home'] = "Votre flotte d\'expédition rentre à quai.";
$lang['sys_mess_transport'] = "Flotte de Transport";
$lang['sys_tran_mess_owner'] = "Une de vos flottes arrive sur %s %s. Elle livre %s unitées de %s, %s unitées de %s et %s unitées de %s.";
$lang['sys_tran_mess_user']  = "Une flotte alliée venant de %s %s arrive sur %s %s elle livre %s unitées de %s, %s unitées de %s et %s unitées de %s.";
$lang['sys_mess_fleetback'] = "Retour de flotte";
$lang['sys_tran_mess_back'] = "Une de vos flottes rentre de %s %s. La flotte ne livre pas de ressources.";
$lang['sys_recy_gotten'] = "Vous avez collecté %s unités de %s et %s unités de %s.";
$lang['sys_notenough_money'] = "Vous ne disposez pas de suffisement de ressources pour lancer la construction de %s. Vous disposez de %s de %s, %s de %s et de %s de %s le cout du batiment etait de %s de %s, %s de %s et de %s de %s.";
$lang['sys_nomore_level'] = "Vous tentez de détruire un batiment que vous ne possédez plus ( %s ).";
$lang['sys_buildlist'] = "Liste de construction";
$lang['sys_buildlist_fail'] = "Construction impossible";
$lang['sys_gain'] = "Gains";
$lang['sys_perte_attaquant'] = "Perte Attaquant";
$lang['sys_perte_defenseur'] = "Perte Defenseur";
$lang['sys_debris'] = "Débris";
$lang['sys_noaccess'] = "Accés refusé";
$lang['sys_noalloaw'] = "Vous n'avez pas accés à cette page";
$lang['sys_request_ok'] = "Votre requête à bien été envoyée !";
$lang['sys_ok'] = "OK";

//Destruction de lune
$lang['sys_destruc_title']    = "Tentative de destruction lunaire du %s :";
$lang['sys_mess_destruc_report'] = "Rapport de destruction";
$lang['sys_destruc_lune'] = "La probabilitée de destruction de lune est de : %d %% ";
$lang['sys_destruc_rip'] = "La probabilitée de destruction de la flotte d\'étoile de la mort est de : %d %% ";
$lang['sys_destruc_stop'] = "Le défenseur a réussi a bloquer la tentative de destruction de lune";
$lang['sys_destruc_mess1'] = "Cette flotte d\'étoile de la mort concentre leurs chocs de gravitons alternants sur cette lune";
$lang['sys_destruc_mess'] = "Une flotte de la planète %s [%d:%d:%d] atteint la lune de la planète en [%d:%d:%d]";
$lang['sys_destruc_echec'] = ". Des tremblements secouent la surface de la lune. Mais quelque chose se passe mal. Les canons de gravitons secouent la flotte d\'étoile de la mort, il y a retour fatal. Hélas ! La flotte d\'étoile de la mort explose en millions de fragments! L\'explosion détruit entièrement la flotte.";
$lang['sys_destruc_reussi'] = ", provoquant un tremblement puis un déchirement total de celle-ci. Tous les bàtiments sont détruits - Mission accomplie !La lune est détruite! La flotte rentre à la planète de départ.";
$lang['sys_destruc_null'] = ", visiblement la flotte ne développe pas la puissance nécessaire - Echec de la mission! La flotte rentre à la planète de départ.";

$lang['frames_error'] = "Votre navigateur internet ne supporte pas les frames.";

// Created by Perberos. All rights reversed (C) 2006
// Complet by XNova Team. All rights reversed (C) 2008
?>