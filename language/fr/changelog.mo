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

$lang['Version']     = 'Version';
$lang['Description'] = 'Description';
$lang['changelog']   = array(


'0.8e' => '- ADD : Fonction SecureArray() pour les variables POST et GET (Bono)<br />
- ADD : Les administrateurs choisissent desormais le fond de la baniere... (Bono)<br />
- ADD : Mode vacances + Production a 0 + Interdiction de construire(Prethorian)',

'0.8d' => '- ADD : Les administrateurs voient désormais quelle page est consultée par quel joueur (Bono)<br />
- ADD : Bot antimulticompte, personnalisation et activation/désactivation a volonté...  (Bono)<br />
- ADD : Politique de customisation du serveur entamée...  (Bono)<br />
- ADD : Possibilité d\'activer/personnaliser/customiser un lien personnalisé (Bono)<br />
- ADD : Possibilité d\'afficher/desactiver des liens dans le menu (Bono)<br />
- FIX : Lien vers les alliances corrigé<br />
- NEW: Destruction des lunes (juju67)<br />
- NEW: Stationnement chez un allié (juju67)<br />
- FIX: Lien vers la galaxie du joueur dans la fonction de recherche',



'0.8c' => 'Modules et corrections (e-Zobar)<br />
- NEW: Fonction copyright étendus<br />
- NEW: Générateur de bannière-profil (signatures pour forum) dans \'Vue générale\' (désactivable)<br />
- ADD: Déclaration des multi-comptes<br />
- FIX: Nombreuses erreurs visuelles: admin chat, règles<br />
- FIX: Variable root_path sur toutes les pages<br />
- FIX: Sécurité panneau d\'administration<br />
- FIX: Illustrations officiers manquantes<br />
- ADD: Message d\'accueil à l\'inscription (Tom1991)<br />
- ADD: Affichage points raids (Tom1991)',

'0.8b' => 'Correction de bugs (Chlorel)<br />
- ADD: Fonction de remise à zéro du joueur qui triche<br />
- FIX: Liste des planètes triées dans la vue empire<br />
- FIX: Liste des planètes triées dans la vue générale aussi<br />
- FIX: Mise à de toutes les planètes au passage par la vue générale et la vue empire',

'0.8a' => 'Correction de bugs (Chlorel)<br />
- FIX: message.php ne fait plus d\'erreurs SQL quand y pas de message<br />
- FIX: Correction page records pour pouvoir prendre en compte ou pas les admins<br />
- NEW: phalange version recodée ... a tester sous toutes les coutures<br />
- FIX: Plus de possibilité d\'espionner sans sondes<br />
- MOD: Mise en forme des chiffres dans les rapports de combat (avec des .)<br />
- MOD: Modification du template de login pour qu\'il passe par display avec 1 seul <body><br />
- FIX: Suppression d\'une cause possible d\'erreurs MySQL<br />
- FIX: Extraction des dernieres chaines de la vue generale<br />
- FIX: Surprise pour les cheater au marchand !<br />
- FIX: Fonction DeleSelectedUser efface aussi les planetes maintenant<br />
- ADD: Page des règles (XxmangaxX)',

'0.8' => 'Infos (Chlorel)<br />
- FIX: Skin sur nouvel installeur<br />
- DIV: Travaux esthetique sur l\'ensemble des fichiers<br />
- FIX: Oublie de modification d\'appel sur quelques functions nouvellement modifiees',

'0.7m' => 'Correction de bugs (Chlorel)<br />
- ADD: Interface d\'activation de protection des planètes<br />
- FIX: Les lunes vont a nouveau au bon joueur et pas a "un" joueur quand elles sont crees depuis l\'administration<br />
- FIX: Overview Evenements de flottes (les personnelles pour le moment) utilisent a present le css (default.css)<br />
- MOD: Adaption de diverses fonctions a l\'utilisation du css<br />
- FIX: Chat interne (divers ajustements) (e-Zobar)',

'0.7k' => 'Correction de bugs (Chlorel)<br />
- FIX: Retour de flotte en transport<br />
- ADD: Protection des planetes d\'administration<br />
- MOD: Liste des joueurs dans la section admin liens sur les entêtes pour tri<br />
- MOD: Page générale section admin avec liens sur les entêtes pour tri<br />
- FIX: Lors de l\'utilisation d\'un skin autre que celui d\'XNova, il s\'applique aussi en section admin<br />
- FIX: Ajout du lune dans le panneau d\'administration (e-Zobar)<br />
- ADD: Mode transfère dans l\'installateur (e-Zobar)',

'0.7j' => 'Correction de bugs (Chlorel)<br />
- FIX: On peut a nouveau retirer une construction de la queue de fabrication<br />
- FIX: On peut a nouveau envoyer une flotte en transport entre deux planetes<br />
- FIX: La liste des raccourcis dans la selection de la cible fonctionne a nouveau<br />
- FIX: On ne peut plus detruire un batiment que l\'on ne possede pas<br />
- ADD: Tout beau tout nouveau installeur (e-Zobar)<br />
- FIX: Rarcellage de hieroglyphes (e-Zobar)',

'0.7i' => 'Correction de bugs (Chlorel)<br />
- Suppression cheat +1<br />
- Ajustement des durée de vols / consommation des flottes entre le code PHP et le code JAVA<br />
- Tri des colonies par le joueur dans options<br />
- Preparation du multiskin dans options<br />
- Divers amenagements dans le code pour les Administrateurs (Liste de messages, Liste de Joueurs)<br />
- Travaux sur le skin (e-Zobar)<br />
- Travaux sur l\'installeur (e-Zobar)',

'0.7h' => 'Correction de bugs (Chlorel)<br />
- Interface Officier refaite<br />
- Ajout blocage des "refresh meta"<br />
- Ajustement de divers Bugs<br />
- Correction de divers textes (flousedid)<br />
- Correction de defauts visuels (e-Zobar)',

'0.7g' => 'Correction diverses (Chlorel)<br />
- Modification de l\'ordre du traitement de la liste de construction de batiments<br />
- Mise en conformité du code pour une seule commande "echo"<br />
- Quelques modules de réécrits<br />
- Correction bug de dédoublement de flotte<br />
- Mise à jour dynamique de la taille des silos, production des mines et de l\'énergie<br />
- Divers adaptations dans la section admin (e-Zobar)<br />
- Modification lourde du style XNova (e-Zobar)',

'0.7f' => 'Informations et porte de saut: (Chlorel)<br />
- Nouvelle page d\'information completement repensée<br />
- Nouvelle interface porte de saut intégrée a la page d\'information<br />
- Nouvelle gestion de l\'affichage des rapid fire dans la page d\'information<br />
- Multitude de correction faites par e-Zobar',

'0.7e' => 'Partout et nulle part : (Chlorel)<br />
- Nouvelle page registration (mise au standard)<br />
- Nouvelle page records (mise en conformité avec le site)<br />
- Modif kernel (y en a pas mal mais pas possible de toutes les expliquer là et de toutes maniere pas
  grand monde ne serait capable de les comprendre',

'0.7d' => 'Partie admin : (e-Zobar)<br />
- menage dans pas mal de modules<br />
- alignement du menu au style de fonctionnement du site<br />
- traduction complete de ce qui n\'etait pas encore en francais',

'0.7c' => 'Statistiques : (Chlorel)<br />
- Suppression des appels base de données de l\ancien systeme de Statistiques<br />
- Bug Impossibilité de fabriquer des defenses ou des elements de flotte n\'utilisant pas de metal<br />
- Bug Comme certains petits rigolos s\'amusent a lancer des quantitées enormes de vaisseau dans<br />
  une meme ligne de la queue de construction vaisseau, nous en sommes arrivés a limiter le nombre<br />
  d\'element fabriquable par ligne donc maximum 1000 vaisseaux ou defenses a la fois !!<br />
- Bug erreur lors de la selection planete par la combo<br />
- Mise a jour de l\'installeur',

'0.7b' => 'Statistiques : (Chlorel)<br />
- Reecriture de la page de Statistique (appellée par l\'utilisateur)<br />
- Les stat alliance s\'affichent !<br />
- Ecriture du generateur admin des stats<br />
- Separation des stats de l\'enregistrement utilisateur (les stats on leur propre base de données)',

'0.7a' => 'Divers : (Chlorel)<br />
- Bug Technologies (la duree de recherche apparait a nouveau quand on revient dans le laboratoire<br />
- Bug Missiles (mis a plat de la portée des missiles interplanetaires, et mise en place de la limite de fabrication par rapport a la taille du silo)<br />
- Bug Portée des phalange corrigé (on ne peut plus phalanger toute la galaxie)<br />
- Bug Correction de la conssomation de deuterium quand on passe par le menu galaxie',

'0.7' => 'Building :<br />
- Reecriture de la page<br />
- Modularisation<br />
- Correction bugs de statistiques<br />
- Debugage de la liste de construction batiments<br />
- Diverses retouches (Chlorel)<br />
- Divers debug (au fil de l\'eau) (e-Zobar)<br />
- Ajout de fonction sur la vue principale (Tom1991)',

'0.6b' => 'Divers :<br />
- Correction & Ajouts de fonctions pour les officiers (Tom1991)<br />
- Menage dans les scripts java inclus (Chlorel)<br />
- Correction divers bug (Chlorel)<br />
- Mise en place version 0.5 de la liste de construction batiments (Chlorel)',

'0.6a' => 'Graphisme :<br />
- Ajout Skin XNova (e-Zobar)<br />
- Correction d\'effets nefastes (e-Zobar)<br />
- Ajout de bugs involotaires (Chlorel)',

'0.6' => 'Galaxy (suite): (by Chlorel)<br />
- Modification et reecriture de flottenajax.php<br />
- Modification des routine javascript et ajax pour permettre les modification dynamiques de la galaxie<br />
- Corrections bug dans certains liens des popups<br />
- Definition nouveau protocole d\'appel, dorenavant meme sur une lune, la galaxie s\'affiche a partir de la bonne position<br />
- Correction des appels de recyclage<br />
- Ajout module "Officier" (by Tom1991)',

'0.5' => 'Galaxy: (by Chlorel)<br />
- Decoupage ancien module<br />
- Modification systeme de generation des popup dans la vue de la galaxie<br />
- Modularisation de la generation de page',

'0.4' => 'Overview: (by Chlorel)<br />
- Mise en forme ancien module<br />
- Gestion de l\'affichage des flotte personnelle 100%<br />
- Modification affichage des lunes quand presentes<br />
- Correction bug renommer les lunes (pour qu\'elles soient effectivement renommées)',

'0.3' => 'Gestion de flottes: (by Chlorel)<br />
- Modification / modularisation / documentation de la boucle de gestion des vols 100%<br />
- Modification Mission d\'espionnage 100%<br />
- Modification Mission de Colonisation 100%<br />
- Modification Mission Transport 100%<br />
- Modification Mission Stationnement 100%<br />
- Modification Mission Recyclage 100%',

'0.2' => 'Corrections<br />
- Ajouts de la version 0.5 des Exploration (by Tom1991)<br />
- Modification de la boucle de controle des flottes 10% (by Chlorel)',

'0.1' => 'Merge des version flotte:<br />
- Mise en place de la stratégie de developpement<br />
- Mise en place de nouvelles pages de gestion de flotte',

'0.0' => 'Version de depart:<br />
- Base du repack a Tom1991',
);

?>