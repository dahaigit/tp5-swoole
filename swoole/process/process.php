<?php
//$process = new swoole_process(function($pro){
//    $pro->exec('/usr/bin/php', [
//        __DIR__. '/../server/http.php',
//    ]);
//});
//
//$pid = $process->start();
//print_r($pid);
//swoole_process::wait();

echo "start-at:" . date('Y-m-d H:i:s');
$urls = [
    'http://www.baidu.com',
    'http://www.360.com',
    'http://www.qq.com',
    'http://www.al.com',
    'http://www.lx.com',
];
$workers = [];
foreach ($urls as $key => $url)
{
    // 开启子进程，处理
    $process = new swoole_process(function($worker) use ($url){
        $content = getContent($url);
        echo $content . PHP_EOL;
    }, true);
    $pid = $process->start();
    $workers[$pid] = $process;
}
function getContent($url)
{
    sleep(1);
    return $url . 'success' . PHP_EOL;
}
//从管道 获取打印的信息
foreach ($workers as $worker)
{
   echo $worker->read();
}
echo "end-at:" . date('Y-m-d H:i:s');









