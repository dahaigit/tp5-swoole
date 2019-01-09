<?php
//创建websocket服务器对象，监听0.0.0.0:9502端口
$ws = new swoole_websocket_server("0.0.0.0", 9502);

// 设置异步任务的工作进程数量
$ws->set([
    'task_worker_num' => 4,
]);

//监听WebSocket连接打开事件
$ws->on('open', function ($ws, $request) {
    var_dump($request->fd, $request->get, $request->server);
    // 毫秒定时器，只触发一次
    swoole_timer_after(5000, function(){
        echo "毫秒定时器真牛逼";
    });
    $ws->push($request->fd, "hello, welcome\n");
});

//监听WebSocket消息事件
$ws->on('message', function ($ws, $frame) {
    echo "Message: {$frame->data}\n";

    // 这个时候我们有个耗时10s的任务需要完成
    $data = [
        'fd' => $frame->fd,
        'task' => 1,
    ];
//    $ws->task($data);
    swoole_timer_tick(2000, function() use($ws, $frame){
        $ws->push($frame->fd, '每2秒，给客户端发送信息');
    });

    $ws->push($frame->fd, "server: {$frame->data}");
});

//监听WebSocket连接关闭事件
$ws->on('close', function ($ws, $fd) {
    echo "client-{$fd} is closed\n";
});

// 执行异步任务
$ws->on('task', function($ws, $task_id, $from_id, $data){
    echo '任务来了：' . $task_id;
    sleep(10);
    return '完成任务啦，亲';
});

// 监听异步任务完成事件
$ws->on('finish', function($ws, $task_id, $data){
    echo '完成事件：' . $data;
});

$ws->start();



