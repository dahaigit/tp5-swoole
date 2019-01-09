<?php
/*
 * 文件异步写入
 */
$content = '大海真牛逼' . PHP_EOL;
// 以追加的方式写入文件数据
swoole_async_writefile(__DIR__ . '/swoole.log', $content, function ($filename){
    echo '文件写入成功啦' . PHP_EOL;
}, FILE_APPEND);
echo '程序执行到这里啦' . PHP_EOL;
