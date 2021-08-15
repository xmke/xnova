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

$cacheFile = ROOT_PATH . 'cache/' . basename(__FILE__) . '.cache';
$timeDelay = 21600; // 21600s = 6h
includeLang('records');

if(!file_exists($cacheFile) || (time() - filemtime($cacheFile)) > $timeDelay)
{

    
    $headerTpl = gettemplate('records_section_header');
    $tableRows = gettemplate('records_section_rows');
    $parse['rec_title'] = $lang['rec_title'];

    $bloc['section']    = $lang['rec_build'];
    $bloc['player']     = $lang['rec_playe'];
    $bloc['level']      = $lang['rec_level'];
    $parse['building']  = $MustacheEngine->render($headerTpl, $bloc);

    $bloc['section']    = $lang['rec_specb'];
    $bloc['player']     = $lang['rec_playe'];
    $bloc['level']      = $lang['rec_level'];
    $parse['buildspe']  = $MustacheEngine->render($headerTpl, $bloc);

    $bloc['section']    = $lang['rec_techn'];
    $bloc['player']     = $lang['rec_playe'];
    $bloc['level']      = $lang['rec_level'];
    $parse['research']  = $MustacheEngine->render($headerTpl, $bloc);

    $bloc['section']    = $lang['rec_fleet'];
    $bloc['player']     = $lang['rec_playe'];
    $bloc['level']      = $lang['rec_nbre'];
    $parse['fleet']     = $MustacheEngine->render($headerTpl, $bloc);

    $bloc['section']    = $lang['rec_defes'];
    $bloc['player']     = $lang['rec_playe'];
    $bloc['level']      = $lang['rec_nbre'];
    $parse['defenses']  = $MustacheEngine->render($headerTpl, $bloc);


    foreach($lang['tech'] as $element => $elementName)
    {
        if(!empty($elementName) && !empty($resource[$element]))
        {
            $data = array();
            if($element >= 0 && $element <  100 || $element >= 200 && $element < 600)
            {
              
                $record = doquery(sprintf(
                    'SELECT IF(COUNT(DISTINCT u.username)<=10,GROUP_CONCAT(DISTINCT u.username ORDER BY u.username DESC SEPARATOR ", "),"Plus de 10 joueurs ont ce record") AS players, p.%1$s AS level ' .
                    'FROM {{table}}users AS u ' .
                    'LEFT JOIN {{table}}planets AS p ON (u.id=p.id_owner) ' .
                    'LEFT JOIN {{table}}users_tech AS t ON (u.id=t.uid) ' .
                    'WHERE p.%1$s=(SELECT MAX(p2.%1$s) FROM {{table}}planets AS p2) AND p.%1$s>0 ' .
                    'GROUP BY p.%1$s ORDER BY players ASC', $resource[$element]), '', true);
            }
            else if($element >= 100 && $element < 200)
            {
                

                    $techRecordQry = <<<SQL
                        SELECT 
                            IF(COUNT(DISTINCT u.username) <= 10,
                                GROUP_CONCAT(DISTINCT u.username
                                    ORDER BY u.username DESC
                                    SEPARATOR ', '),
                                'Plus de 10 joueurs ont ce record') AS players,
                                t.%1\$s AS level
                        FROM
                            {{table}}users AS u
                        LEFT JOIN
                            {{table}}users_tech AS t ON (u.id = t.uid)
                        WHERE
                            t.%1\$s = (SELECT 
                                    MAX(t2.%1\$s)
                                FROM
                                {{table}}users_tech AS t2)
                                AND t.%1\$s > 0
                        GROUP BY t.%1\$s
                        ORDER BY players ASC
SQL;


                $record = doquery(sprintf($techRecordQry, $resource[$element]), '', true);
                    
            }
            else
            {
                continue;
            }
            
            $data['element'] = $elementName;
            $data['winner'] = !empty($record['players']) ? $record['players'] : '-';
            $data['count'] = isset($record['level']) ? intval($record['level']) : 0;

            if($element >= 0 && $element < 40 || $element == 44)
            {
                $parse['building'] .= $MustacheEngine->render($tableRows, $data);
            }
            else if($element >= 40 && $element < 100 && $element != 44)
            {
                $parse['buildspe'] .= $MustacheEngine->render($tableRows, $data);
            }
            else if($element >= 100 && $element < 200)
            {
                $parse['research'] .= $MustacheEngine->render($tableRows, $data);
            }
            else if($element >= 200 && $element < 400)
            {
                $data['count'] = number_format(intval($data['count']), 0, ',', '.');
                $parse['fleet'] .= $MustacheEngine->render($tableRows, $data);
            }
            else if($element >= 400 && $element < 600 && $element!=407 && $element!=408)
            {
                $data['count'] = number_format(intval($data['count']), 0, ',', '.');
                $parse['defenses'] .= $MustacheEngine->render($tableRows, $data);
            }
        }
    }
    
    file_put_contents($cacheFile, serialize($parse));
}
else
{
    
    $fileData = file_get_contents($cacheFile);
    $parse = unserialize($fileData);
}

    $recordTpl = gettemplate('records_body');
    $page = $MustacheEngine->render($recordTpl, $parse);
    
    display($page, $lang['rec_title']);