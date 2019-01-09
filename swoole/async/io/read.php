<?php
/*
 * 异步读取文件,只能读取4m以下的文件，如果有需要，则用swoole_async_read
 */
$result = swoole_async_readfile(__DIR__ . '/read.php', function($filename, $content){
    echo $filename . PHP_EOL;
    echo $content . PHP_EOL;
});

echo "开始读取啦";
var_dump($result);


