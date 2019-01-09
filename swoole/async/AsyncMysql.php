<?php
/*
 * 注意，v4.3.0异步mysql将被弃用，请用协程mysql
 */
class AsyncMysql
{
    public $db = '';

    public $config = [
        'host' => '192.168.10.10',
        'port' => 3306,
        'user' => 'homestead',
        'password' => 'secret',
        'database' => 'app_my_spa',
        'charset' => 'utf8',
    ];

    public function __construct() {
        $this->connect();
    }

    public function connect()
    {
        // 注意，v4.3.0异步mysql将被弃用，请用协程
        $this->db = new Swoole\Mysql();
        $this->db->connect($this->config, function($db, $result){
            if ($result === false) {
                var_dump($db->connect_errno, $db->connect_error);
                die('数据库连接失败');
            }
        });
    }

    public function execute($sql) {
        $this->db->query($sql, function($db, $result){
            if ($result === false) {
                var_dump($db->connect_errno, $db->connect_error);
            } elseif ($result === true) {
                var_dump($db->affected_rows, $db->insert_id);
            }
            var_dump($result);
            $db->close();
        });
    }
}

$mysql = new AsyncMysql();
$sql = 'show tables';
$result = $mysql->execute($sql);
