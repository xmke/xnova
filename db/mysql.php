<?php
/**
 * Tis file is part of XNova:Legacies
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

class Database
{
    static $dbHandle = NULL;
    static $config = NULL;
}

function doquery($query, $table, $fetch = false)
{
    global $SqlQueries;
    if (!isset(Database::$config)) {
        $config = require dirname(dirname(__FILE__)) . '/config.php';
    }

    if(!isset(Database::$dbHandle))
    {
        Database::$dbHandle = mysqli_connect(
            $config['global']['database']['options']['hostname'],
            $config['global']['database']['options']['username'],
            $config['global']['database']['options']['password'])
                or trigger_error(mysqli_error() . "$query<br />" . PHP_EOL, E_USER_WARNING);

        mysqli_select_db(Database::$dbHandle, $config['global']['database']['options']['database'])
            or trigger_error(mysqli_error(Database::$dbHandle)."$query<br />" . PHP_EOL, E_USER_WARNING);
    }
    $sql = str_replace("{{table}}", "{$config['global']['database']['table_prefix']}{$table}", $query);

    $SqlQueries++;
    $dbt=debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2);
    $caller = isset($dbt[1]['file']) ? $dbt[1]['file'] : null;

    if(!defined('IS_AJAX_SCRIPT')){
        echo "<!-- Caller : ".$caller ." -->\r\n";
        echo "<!-- ".$sql." -->\r\n";
    }
    
    if (false === ($sqlQuery = mysqli_query(Database::$dbHandle, $sql))) {
        trigger_error(mysqli_error(Database::$dbHandle) . PHP_EOL . "<br /><pre></code>$sql<code></pre><br />" . PHP_EOL, E_USER_WARNING);
    }
    if($fetch) {
        return mysqli_fetch_array($sqlQuery);
    }else{
        return $sqlQuery;
    }
}
