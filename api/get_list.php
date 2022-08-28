<?php

/**
 * 获取待办列表
 */
require 'Poncon.php';

use Poncon\Poncon;

$poncon = new Poncon;

$username = $poncon->POST('username', '', true);
$password = $poncon->POST('password', '', true);
$page = $poncon->POST('page', 0, true);
$pageSize = $poncon->POST('pageSize', 100, true);
$offset = $page * $pageSize;
$conn = $poncon->initDb();
$poncon->login($conn, $username, $password);
$table = $poncon->getConfig()['table']['data'];
$sql = "SELECT * FROM `$table` WHERE `username` = '$username' LIMIT $offset, $pageSize";
$result = mysqli_query($conn, $sql);
if (!$result) {
    $poncon->error(903, '数据库错误');
}
$data = [];
if (mysqli_num_rows($result) >= 0) {
    $data = mysqli_fetch_assoc($result);
}
$poncon->success('获取成功', $data);
