<?php

/**
 * 配置文件
 */

$config = [
    'title' => 'APEE 待办清单', // 网站标题
    'description' => '轻量免费的待办清单工具', // 网站描述
    'logo_url' => 'img/logo-blue.png', // 网站logo URL
    'mysql' => [
        'host' => 'localhost', // 数据库地址
        'user' => 'root', // 数据库用户名
        'pass' => '', // 数据库密码
        'db' => '', // 数据库名称
    ],
    'table' => [
        'key' => 'apee_to_do_list', // 文件表名
    ],
];
