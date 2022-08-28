<?php

/**
 * 用户登录
 */

require 'Poncon.php';

use Poncon\Poncon;

$poncon = new Poncon;

$username = $poncon->POST('username', '', true);
$password = $poncon->POST('password', '', true);
$conn = $poncon->initDb();
$poncon->login($conn, $username, $password);
$poncon->success('登陆成功', [
    'username' => $username
]);
