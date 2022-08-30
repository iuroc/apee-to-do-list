<?php

/**
 * 修改待办事项完成状态
 */
require 'Poncon.php';

use Poncon\Poncon;

$poncon = new Poncon;

$username = $poncon->POST('username', '', true);
$password = $poncon->POST('password', '', true);
$id = $poncon->POST('id', '', true);
$finish = (int)$poncon->POST('finish', 0, true);
$conn = $poncon->initDb();
$poncon->login($conn, $username, $password);
$table = $poncon->getConfig()['table']['data'];
$sql = "UPDATE `$table` SET `finish` = $finish WHERE `id` = $id AND `username` = '$username' LIMIT 1;";
$result = mysqli_query($conn, $sql);
if (!$result) {
    $poncon->error(903, '数据库错误');
}
$poncon->success('更新成功', [
    'username' => $username,
    'id' => $id,
    'finish' => $finish
]);
