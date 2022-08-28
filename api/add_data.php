<?php

/**
 * 增加待办记录
 */
require 'Poncon.php';

use Poncon\Poncon;

$poncon = new Poncon;

$username = $poncon->POST('username', '', true);
$password = $poncon->POST('password', '', true);
$content = $poncon->POST('data', '', true);
$need_time = $poncon->POST('need_date', '', true);
$conn = $poncon->initDb();
$poncon->login($conn, $username, $password);
$table = $poncon->getConfig()['table']['data'];
$sql = "INSERT INTO `$table` (`username`, `need_time`, `content`) VALUES ('$username', '$need_time', '$content')";
$result = mysqli_query($conn, $sql);
if (!$result) {
    $poncon->error(903, '数据库错误');
}
$poncon->success('添加成功');
