<?php
/*
 * 创建一个http服务，文件位置swoole/http
 * 兼容tp5步骤：
 * 1、加载tp5框架内容，为了能使用tp5的功能
 * 2、清除超全局变量，防止每次请求参数不一致导致数据污染问题
 * 3、给超全局变量赋值，因为tp5是从超全局数组中获取值得
 * 4、获取框架输出内容并输出
 * 5、去掉think\Request->path()的if (is_null($this->path)) {，和pathinfo()同样的操作
 *    为了解决路由被缓存的问题，我们的需求每次请求的路由都重新读取，不需要从缓存里面读
 */

$http = new swoole_http_server('0.0.0.0', 8811);
// 设置静态资源目录
$http->set([
    'enable_static_handler' => true,
    'document_root' => './public',
    'worker_num' => 5,
]);
// 在服务开启的时候，加载内容
$http->on('workerStart', function($server, $workerId)
{
    // 定义应用目录常量
    define('APP_PATH', __DIR__ . '/../application/');
    // 加载框架中的文件
    // ThinkPHP 引导文件
    // 1. 加载基础文件
    require __DIR__ . '/../thinkphp/base.php';
});
$http->on('request', function($request, $response){
    // 清除全局变量
    $_SERVER = [];
    $_GET = [];
    $_POST = [];
    // 绑定参数
    if (isset($request->server)) {
        foreach ($request->server as $k => $v)
        {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    if (isset($request->header)) {
        foreach ($request->header as $k => $v)
        {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    if (isset($request->get)) {
        foreach ($request->get as $k => $v)
        {
            $_GET[$k] = $v;
        }
    }
    if (isset($request->post)) {
        foreach ($request->post as $k => $v)
        {
            $_POST[$k] = $v;
        }
    }

    // 获取内容并输出
    ob_start();
    // swoole模式下会乱码
    //echo header("charset=utf-8");
   // echo "<meta http-equiv='Content-Type' content='charset=utf-8'>";
    // 还有cookie等
    // 2. 执行应用
    think\App::run()->send();
    $res = ob_get_contents();
    ob_end_clean();
    $response->end($res);
});

$http->start();




















