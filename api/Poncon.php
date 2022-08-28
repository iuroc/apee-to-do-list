<?php

/**
 * @author 鹏优创
 * @version 1.0
 */

namespace Poncon;

header('Content-Type: application/json');

class Poncon
{
    /**
     * 创建ID，语法：createId([$length])
     * @param int $length 长度 范围：1-32
     * @return string
     */
    function createId(...$args)
    {
        return substr(str_shuffle(md5(str_shuffle(time()))), 0, isset($args[0]) ? $args[0] : 10);
    }

    /**
     * 获取POST参数
     * @param string $key 参数名
     * @param mixed $default 默认值
     * @param bool $ifAddslashes 是否进行addslashes处理
     * @return mixed
     */
    function POST($key, ...$args)
    {
        $temp = isset($_POST[$key]) ? $_POST[$key] : (isset($args[0]) ? $args[0] : null);
        return isset($args[1]) && $args[1] ? addslashes($temp) : $temp;
    }
    /**
     * 获取GET参数
     * @param string $key 参数名
     * @param mixed $default 默认值
     * @param bool $ifAddslashes 是否进行addslashes处理
     * @return mixed
     */
    function GET($key, ...$args)
    {
        $temp = isset($_GET[$key]) ? $_GET[$key] : (isset($args[0]) ? $args[0] : null);
        return isset($args[1]) && $args[1] ? addslashes($temp) : $temp;
    }

    /**
     * 发送请求
     * @param string $url 请求地址
     * @param string $method 请求方式
     * @param string|array $data 请求数据
     * @param string $header 请求头
     * @param bool|null $return 是否返回curl对象 默认为false 即直接返回结果
     * @return mixed
     */
    function request($url, ...$args)
    {
        $method = isset($args[0]) ? $args[0] : 'GET';
        $data = isset($args[1]) ? $args[1] : null;
        $header = isset($args[2]) ? $args[2] : null;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, $header);
        if (isset($args[3]) && $args[3] == true) {
            return $ch;
        } else {
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }
    }

    /**
     * 截取两个字符串之间的字符串，不包含两端，语法：sj($str, $start, $end);
     * @param string $str 待操作字符串
     * @param string|null $start 开始字符串
     * @param string|null $end 结束字符串
     * @return string
     */
    function sj($str, $start, $end)
    {
        $j1 = $start ? strpos($str, $start) : 0;
        $j2 = $start ? strlen($start) : 0;
        $j3 = strlen($str);
        $j4 = ($j1 + $j2);
        $j5 = ($j3 - $j4);
        $j6 = substr($str, $j4, $j5);
        $j7 = $end ? strpos($j6, $end) : $j5;
        $j8 = substr($j6, 0, $j7);
        return $j8;
    }

    /**
     * 返回错误信息
     * @param int $code 错误码
     * @param string $msg 错误信息
     * | 状态码 | 描述         |
     * | ------ | ------------ |
     * | 900    | 参数缺失     |
     * | 901    | 验证出错     |
     * | 902    | 记录已经存在 |
     * | 903    | 数据库错误   |
     * | 904    | 记录或资源不存在或失效   |
     * | 905    | 类型或格式错误 |
     * | 906    | 资源获取失败 |
     */
    function error($code, $msg)
    {
        echo json_encode([
            'code' => $code,
            'msg' => $msg
        ]);
        die();
    }

    /**
     * 返回成功信息
     * @param string $msg 成功信息
     * @param array|string $data 返回数据
     */
    function success($msg, ...$args)
    {
        $data = [
            'code' => 200,
            'msg' => $msg,
            'data' => isset($args[0]) ? $args[0] : null
        ];
        echo json_encode($data);
    }

    /**
     * 获取配置信息，语法：getConfig();
     * @return array
     */
    function getConfig()
    {
        require '../config.php';
        return $config;
    }

    /**
     * 初始化数据库，语法：initDB();
     * @return object|array
     */
    function initDb()
    {
        $config = $this->getConfig();
        $conn = mysqli_connect($config['mysql']['host'], $config['mysql']['user'], $config['mysql']['pass'], $config['mysql']['db']);
        if (!$conn) {
            $this->error(903, '数据库连接失败');
        }

        // 新建数据表
        $table = $config['table']['data'];
        $sql = "CREATE TABLE IF NOT EXISTS `$table` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` VARCHAR(255) NOT NULL, -- 用户名
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `need_time` VARCHAR(255) NOT NULL, -- 要求完成时间
            `content` TEXT NOT NULL, -- 待办内容
            `finish` INT(11) NOT NULL DEFAULT 0, -- 是否完成待办
            PRIMARY KEY (`id`) -- 主键
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $this->error(903, '数据库错误');
        }



        return $conn;
    }

    /**
     * 登录验证
     * @param object $conn 数据库连接
     * @param string $username 用户名
     * @param string $password 密码
     * @return array|null
     */
    function login($conn, $username, $password)
    {
        $config = $this->getConfig();
        if (!$username || !$password) {
            $this->error(900, '参数缺失');
        }
        $table = $config['table']['user'];
        $sql = "SELECT * FROM `$table` WHERE `username` = '$username' AND `password_md5` = '$password';";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $this->error(903, '数据库错误');
        }
        $row = mysqli_fetch_assoc($result);
        if (!$row) {
            $this->error(901, '用户名或密码错误');
        }
        return $row;
    }
}
