<?php

/**
 * 修改待办数据
 */
require 'Poncon.php';

use Poncon\Poncon;

$poncon = new Poncon;

$username = $poncon->POST('username', '', true);
$password = $poncon->POST('password', '', true);
$content = $poncon->POST('content', '', true);
$need_time = $poncon->POST('need_time', '', true);
$id = $poncon->POST('id', '', true);
$conn = $poncon->initDb();
$poncon->login($conn, $username, $password);
$table = $poncon->getConfig()['table']['data'];
$update_time = date("Y-m-d H:i:s");
$sql = "UPDATE `$table` SET `content` = '$content', `update_time` = '$update_time', `need_time` = '$need_time' WHERE `id` = '$id' LIMIT 1;";
$result = mysqli_query($conn, $sql);
if (!$result) {
    $poncon->error(903, '数据库错误');
}
$poncon->success('更新成功', [
    'username' => $username,
    'id' => $id,
    'update_time' => $update_time
]);
