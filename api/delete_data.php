<?php

/**
 * 删除记录
 */
require 'Poncon.php';

use Poncon\Poncon;

$poncon = new Poncon;

$username = $poncon->POST('username', '', true);
$password = $poncon->POST('password', '', true);
$id = $poncon->POST('id', '', true);
$conn = $poncon->initDb();
$poncon->login($conn, $username, $password);
$table = $poncon->getConfig()['table']['data'];
// 删除数据
$sql = "DELETE FROM `$table` WHERE `id` = '$id' AND `username` = '$username' LIMIT 1;";
$result = mysqli_query($conn, $sql);
if (!$result) {
    $poncon->error(903, '数据库错误');
}
$poncon->success('删除成功', [
    'id' => $id,
    'result' => $result
]);
