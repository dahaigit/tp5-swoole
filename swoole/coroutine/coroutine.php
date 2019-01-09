<?php
go(function(){
    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis->set('username', '大海真牛逼');
    $value = $redis->get('username');
    var_dump($value);
});
echo '程序结束啦'; // 程序结束啦string(15) "大海真牛逼"















