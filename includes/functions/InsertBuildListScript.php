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

function InsertBuildListScript ( $CallProgram, $languageStrings) {


	$BuildListScript  = "<script type=\"text/javascript\">\n";
	$BuildListScript .= "<!--\n";
	$BuildListScript .= "function t() {\n";
	$BuildListScript .= "	v           = new Date();\n";
	$BuildListScript .= "	var blc     = document.getElementById('blc');\n";
	$BuildListScript .= "	var timeout = 1;\n";
	$BuildListScript .= "	n           = new Date();\n";
	$BuildListScript .= "	ss          = pp;\n";
	$BuildListScript .= "	aa          = Math.round( (n.getTime() - v.getTime() ) / 1000. );\n";
	$BuildListScript .= "	s           = ss - aa;\n";
	$BuildListScript .= "	m           = 0;\n";
	$BuildListScript .= "	h           = 0;\n\n";
	$BuildListScript .= "	if ( (ss + 3) < aa ) {\n";
	$BuildListScript .= "		blc.innerHTML = \"". $languageStrings['completed'] ."<br>\" + \"<a href=". $CallProgram .".php?planet=\" + pl + \">". $languageStrings['continue'] ."</a>\";\n";
	$BuildListScript .= "		if ((ss + 6) >= aa) {\n";
	$BuildListScript .= "			window.setTimeout('document.location.href=\"". $CallProgram .".php?planet=' + pl + '\";', 3500);\n";
	$BuildListScript .= "		}\n";
	$BuildListScript .= "	} else {\n";
	$BuildListScript .= "		if ( s < 0 ) {\n";
	$BuildListScript .= "			if (1) {\n";
	$BuildListScript .= "				blc.innerHTML = \"". $languageStrings['completed'] ."<br>\" + \"<a href=". $CallProgram .".php?planet=\" + pl + \">". $languageStrings['continue'] ."</a>\";\n";
	$BuildListScript .= "				window.setTimeout('document.location.href=\"". $CallProgram .".php?planet=' + pl + '\";', 2000);\n";
	$BuildListScript .= "			} else {\n";
	$BuildListScript .= "				timeout = 0;\n";
	$BuildListScript .= "				blc.innerHTML = \"". $languageStrings['completed'] ."<br>\" + \"<a href=". $CallProgram .".php?planet=\" + pl + \">". $languageStrings['continue'] ."</a>\";\n";
	$BuildListScript .= "			}\n";
	$BuildListScript .= "		} else {\n";
	$BuildListScript .= "			if ( s > 59) {\n";
	$BuildListScript .= "				m = Math.floor( s / 60);\n";
	$BuildListScript .= "				s = s - m * 60;\n";
	$BuildListScript .= "			}\n";
	$BuildListScript .= "			if ( m > 59) {\n";
	$BuildListScript .= "				h = Math.floor( m / 60);\n";
	$BuildListScript .= "				m = m - h * 60;\n";
	$BuildListScript .= "			}\n";
	$BuildListScript .= "			if ( s < 10 ) {\n";
	$BuildListScript .= "				s = \"0\" + s;\n";
	$BuildListScript .= "			}\n";
	$BuildListScript .= "			if ( m < 10 ) {\n";
	$BuildListScript .= "				m = \"0\" + m;\n";
	$BuildListScript .= "			}\n";
	$BuildListScript .= "			if (1) {\n";
	$BuildListScript .= "				blc.innerHTML = h + \":\" + m + \":\" + s + \"<br><a href=buildings.php?listid=\" + pk + \"&cmd=\" + pm + \"&planet=\" + pl + \">". $languageStrings['DelFirstQueue'] ."</a>\";\n";
	$BuildListScript .= "			} else {\n";
	$BuildListScript .= "				blc.innerHTML = h + \":\" + m + \":\" + s + \"<br><a href=buildings.php?listid=\" + pk + \"&cmd=\" + pm + \"&planet=\" + pl + \">". $languageStrings['DelFirstQueue'] ."</a>\";\n";
	$BuildListScript .= "			}\n";
	$BuildListScript .= "		}\n";
	$BuildListScript .= "		pp = pp - 1;\n";
	$BuildListScript .= "		if (timeout == 1) {\n";
	$BuildListScript .= "			window.setTimeout(\"t();\", 999);\n";
	$BuildListScript .= "		}\n";
	$BuildListScript .= "	}\n";
	$BuildListScript .= "}\n";
	$BuildListScript .= "//-->\n";
	$BuildListScript .= "</script>\n";

	return $BuildListScript;
}

?>