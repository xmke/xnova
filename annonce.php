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

define('INSIDE' , true);
define('INSTALL' , false);
require_once dirname(__FILE__) .'/common.php';

$annonce = doquery("SELECT * FROM {{table}} ", 'annonce');
$action  = isset($_GET['action']) ? intval($_GET['action']) : "";

if ($action == 5) {
	$metalvendre = is_numeric($_POST['metalvendre']) ? $_POST['metalvendre'] : 0;
	$cristalvendre = is_numeric($_POST['cristalvendre']) ? $_POST['cristalvendre'] : 0;
	$deutvendre = is_numeric($_POST['deutvendre']) ? $_POST['deutvendre'] : 0;

	$metalsouhait = is_numeric($_POST['metalsouhait']) ? $_POST['metalsouhait'] : 0;
	$cristalsouhait = is_numeric($_POST['cristalsouhait']) ? $_POST['cristalsouhait'] : 0;
	$deutsouhait = is_numeric($_POST['deutsouhait']) ? $_POST['deutsouhait'] : 0;

	$page2 = "";
	if($metalvendre == 0 &&
	$cristalvendre == 0 &&
	$deutvendre == 0 &&
	$metalsouhait == 0 &&
	$cristalsouhait == 0 &&
	$deutsouhait == 0){
		$page2 = <<<HTML
		<center>
		<br>
		<p>Votre annonce est incorrecte. Elle n'a pas été ajoutée.</p>
		<br><p><a href="annonce.php">Retour aux annonces</a></p>
		
		HTML;
	}else{
	
		doquery("INSERT INTO {{table}} SET
	user='{$user['username']}',
	galaxie='{$planetrow['galaxy']}',
	systeme='{$planetrow['system']}',
	metala='{$metalvendre}',
	cristala='{$cristalvendre}',
	deuta='{$deutvendre}',
	metals='{$metalsouhait}',
	cristals='{$cristalsouhait}',
	deuts='{$deutsouhait}'" , "annonce");
	
	$page2 = <<<HTML
	<center>
	<br>
	<p>Votre Annonce a bien &eacute;t&eacute; enregistr&eacute;e !</p>
	<br><p><a href="annonce.php">Retour aux annonces</a></p>
	
	HTML;
	}
	

	display($page2);
}else{
	$annonce = doquery("SELECT * FROM {{table}} ORDER BY `id` DESC ", "annonce");

	$page2 = "<HTML>
<center>
<br>
<table width=\"600\">
<td class=\"c\" colspan=\"10\"><font color=\"#FFFFFF\">Petites Annonces</font></td></tr>
<tr><th colspan=\"3\">Infos de livraison</th><th colspan=\"3\">Ressources &agrave; vendre</th><th colspan=\"3\">Ressources souhait&eacute;es</th><th>Action</th></tr>
<tr><th>Vendeur</th><th>Galaxie</th><th>Syst&egrave;me</th><th>M&eacute;tal</th><th>Cristal</th><th>Deuterium</th><th>M&eacute;tal</th><th>Cristal</th><th>Deuterium</th><th>Delet</th></tr>




";
	while ($b = mysqli_fetch_array($annonce)) {
		$page2 .= '<tr><th> ';
		$page2 .= $b["user"] ;
		$page2 .= '</th><th>';
		$page2 .= $b["galaxie"];
		$page2 .= '</th><th>';
		$page2 .= $b["systeme"];
		$page2 .= '</th><th>';
		$page2 .= $b["metala"];
		$page2 .= '</th><th>';
		$page2 .= $b["cristala"];
		$page2 .= '</th><th>';
		$page2 .= $b["deuta"];
		$page2 .= '</th><th>';
		$page2 .= $b["metals"];
		$page2 .= '</th><th>';
		$page2 .= $b["cristals"];
		$page2 .= '</th><th>';
		$page2 .= $b["deuts"];
		$page2 .= '</th><th>';
		$page2 .= "</th></tr>";
	}

	$page2 .= "
<tr><th colspan=\"10\" align=\"center\"><a href=\"annonce2.php?action=2\">Ajouter une Annonce</a></th></tr>
</td>
</table>
</HTML>";

	display($page2, "Annonces", false);
}

// Créer par Tom1991 Copyright 2008
// Merci au site Spacon pour m'avoir donner l'inspiration