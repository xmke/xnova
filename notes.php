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


$a = isset($_GET['a']) ? mysqli_real_escape_string(Database::$dbHandle, $_GET['a']) : "";
$n = isset($_GET['n']) ? intval($_GET['n']) : 0;
$s = isset($_POST['s']) ? mysqli_real_escape_string(Database::$dbHandle, $_POST['s']) : "";

$lang['Please_Wait'] = "Patientez...";

//lenguaje
includeLang('notes');

$lang['PHP_SELF'] = 'notes.php';

if($s == 1 || $s == 2){//Edicion y agregar notas

	$time = time();
	$priority = ($_POST["u"]) ? mysqli_real_escape_string(Database::$dbHandle, strip_tags($_POST["u"])) : $lang['NoTitle'];
	$title = ($_POST["title"]) ? mysqli_real_escape_string(Database::$dbHandle, strip_tags($_POST["title"])) : $lang['NoTitle'];
	$text = ($_POST["text"]) ? mysqli_real_escape_string(Database::$dbHandle, strip_tags($_POST["text"])) : $lang['NoText'];

	if($s ==1){
		doquery("INSERT INTO {{table}} SET owner={$user['id']}, time=$time, priority=$priority, title='$title', text='$text'","notes");
		message($lang['NoteAdded'], $lang['Please_Wait'],'notes.php',"3");
	}elseif($s == 2){
		/*
		  pequeño query para averiguar si la nota que se edita es del propio jugador
		*/
		$id = isset($_POST['n']) ? intval($_POST['n']) : 0;

		$note_query = doquery("SELECT * FROM {{table}} WHERE id=$id AND owner=".$user["id"],"notes");

		if(!$note_query){ message($lang['notpossiblethisway'],$lang['Notes']); }

		doquery("UPDATE {{table}} SET time=$time, priority=$priority, title='$title', text='$text' WHERE id=$id","notes");
		message($lang['NoteUpdated'], $lang['Please_Wait'], 'notes.php', "3");
	}

}
elseif($_POST){//Borrar

	foreach($_POST as $a => $b){
		/*
		  Los checkbox marcados tienen la palabra delmes seguido del id.
		  Y cada array contiene el valor "y" para compro
		*/
		if(preg_match("/delmes/i",$a) && $b == "y"){

			$id = intval(str_replace("delmes","",$a));
			$note_query = doquery("SELECT * FROM {{table}} WHERE id=$id AND owner={$user['id']}","notes");
			//comprobamos,
			if($note_query){
				$deleted++;
				doquery("DELETE FROM {{table}} WHERE `id`=$id;","notes");// y borramos
			}
		}
	}
	if ($deleted) {
		$mes = ($deleted == 1) ? $lang['NoteDeleted'] : $lang['NoteDeleteds'];
		message($mes,$lang['Please_Wait'],'notes.php',"3");
	} else {
		header("Location: notes.php");
	}

}else{//sin post...
	if($a == 1){//crear una nueva nota.
		/*
		  Formulario para crear una nueva nota.
		*/

		$parse = $lang;

		$parse['c_Options'] = "<option value=2 selected=selected>{$lang['Important']}</option>
			  <option value=1>{$lang['Normal']}</option>
			  <option value=0>{$lang['Unimportant']}</option>";

		$parse['cntChars'] = '0';
		$parse['TITLE'] = $lang['Createnote'];
		$parse['text'] = '';
		$parse['title'] = '';
		$parse['inputs'] = '<input type=hidden name=s value=1>';

		$page = $MustacheEngine->render(gettemplate('notes_form'), $parse);

		display($page,$lang['Notes'],false);

	}
	elseif($a == 2){//editar
		/*
		  Formulario donde se puestra la nota y se puede editar.
		*/
		$note = doquery("SELECT * FROM {{table}} WHERE owner={$user['id']} AND id=$n",'notes',true);

		if(!$note){ message($lang['notpossiblethisway'],$lang['Error']); }

		$cntChars = strlen($note['text']);

		$SELECTED[$note['priority']] = ' selected="selected"';

		$parse = array_merge($note,$lang);

		$parse['c_Options'] = "<option value=2{$SELECTED[2]}>{$lang['Important']}</option>
			  <option value=1{$SELECTED[1]}>{$lang['Normal']}</option>
			  <option value=0{$SELECTED[0]}>{$lang['Unimportant']}</option>";

		$parse['cntChars'] = $cntChars;
		$parse['TITLE'] = $lang['Editnote'];
		$parse['inputs'] = '<input type=hidden name=s value=2><input type=hidden name=n value='.$note['id'].'>';

		$page .= $MustacheEngine->render(gettemplate('notes_form'), $parse);

		display($page,$lang['Notes'],false);

	}
	else{//default

		$notes_query = doquery("SELECT * FROM {{table}} WHERE owner={$user['id']} ORDER BY time DESC",'notes');
		//Loop para crear la lista de notas que el jugador tiene
		$count = 0;
		$parse=$lang;
		$list = "";
		while($note = mysqli_fetch_array($notes_query)){
			$count++;
			//Colorea el titulo dependiendo de la prioridad
			if($note["priority"] == 0){ $parse['NOTE_COLOR'] = "lime";}//Importante
			elseif($note["priority"] == 1){ $parse['NOTE_COLOR'] = "yellow";}//Normal
			elseif($note["priority"] == 2){ $parse['NOTE_COLOR'] = "red";}//Sin importancia

			//fragmento de template
			$parse['NOTE_ID'] = $note['id'];
			$parse['NOTE_TIME'] = date("Y-m-d h:i:s",$note["time"]);
			$parse['NOTE_TITLE'] = $note['title'];
			$parse['NOTE_TEXT'] = strlen($note['text']);

			$list .= $MustacheEngine->render(gettemplate('notes_body_entry'), $parse);

		}

		if($count == 0){
			$list .= "<tr><th colspan=4>{$lang['ThereIsNoNote']}</th>\n";
		}

		$parse = $lang;
		$parse['BODY_LIST'] = $list;
		//fragmento de template
		$page = $MustacheEngine->render(gettemplate('notes_body'), $parse);

		display($page,$lang['Notes'],false);
	}
}