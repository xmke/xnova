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
define('LOGIN'   , true);
define('DISABLE_IDENTITY_CHECK', true);
define('QRYLESS', true);
require_once dirname(__FILE__) .'/common.php';

includeLang('login');

if (!empty($_POST)) {
    $userData = array(
        'username' => mysqli_real_escape_string (Database::$dbHandle, $_POST['username']),
        'password' => mysqli_real_escape_string (Database::$dbHandle, $_POST['password'])
    );
    $sql =<<<EOF
SELECT
    users.id,
    users.username,
    users.banaday,
    (CASE WHEN MD5("{$userData['password']}")=users.password THEN 1 ELSE 0 END) AS login_success,
    CONCAT((@salt:=MID(MD5(RAND()), 0, 4)), SHA1(CONCAT(users.username, users.password, @salt))) AS login_rememberme
    FROM {{table}}users AS users
        WHERE users.username="{$userData['username']}"
        LIMIT 1
EOF;

    $login = doquery($sql, '', true);

    if($login['banaday'] <= time() & $login['banaday'] !='0' ){
        doquery("UPDATE {{table}} SET `banaday` = '0', `bana` = '0', `urlaubs_modus` ='0'  WHERE `username` = '".$login['username']."' LIMIT 1;", 'users');
        doquery("DELETE FROM {{table}} WHERE `who` = '".$login['username']."'",'banned');
    }

    if ($login) {
        if (intval($login['login_success'])) {
            if (isset($_POST["rememberme"])) {
                setcookie('nova-cookie', serialize(array('id' => $login['id'], 'key' => $login['login_rememberme'])), time() + 2592000);
            }

            $sql =<<<EOF
UPDATE {{table}} AS users
  SET users.onlinetime=UNIX_TIMESTAMP()
  WHERE users.id={$login['id']}
EOF;
            doquery($sql, 'users');

            $_SESSION['user_id'] = $login['id'];
            header("Location: frames.php");
            exit(0);
        } else {
            message($lang['Login_FailPassword'], $lang['Login_Error']);
        }
    } else {
        message($lang['Login_FailUser'], $lang['Login_Error']);
    }
} else {
    

   
    


    $parse                 = $lang;
    $Count                 = doquery('SELECT COUNT(DISTINCT users.id) AS `players` FROM {{table}} AS users WHERE users.authlevel < 3', 'users', true);
    $LastPlayer            = doquery('SELECT users.`username` FROM {{table}} AS users ORDER BY `register_time` DESC LIMIT 1', 'users', true);
    $parse['last_user']    = $LastPlayer['username'];
    $PlayersOnline         = doquery("SELECT COUNT(DISTINCT id) AS `onlinenow` FROM {{table}} AS users WHERE `onlinetime` > (UNIX_TIMESTAMP()-900) AND users.authlevel < 3", 'users', true);
    $parse['online_users'] = $PlayersOnline['onlinenow'];
    $parse['users_amount'] = $Count['players'];
    $parse['servername']   = $game_config['game_name'];
    $parse['forum_url']    = $game_config['forum_url'];
    $parse['PasswordLost'] = $lang['PasswordLost'];

    $page = $MustacheEngine->render(gettemplate('login_body'), $parse); // "Hello, World!"
   

    // Test pour prendre le nombre total de joueur et le nombre de joueurs connect�s
    if (isset($_GET['ucount']) && $_GET['ucount'] == 1) {
        $page = $PlayersOnline['onlinenow']."/".$Count['players'];
        die ( $page );
    } else {
        display($page, $lang['Login']);
    }
}

