<?php
/**
 * 创建 Http\Server 对象（继承自 Server 对象）
 * Http\Server 对 Http 协议的支持并不完整，建议只做 server 端， 并且在前端增加 nginx 做代理
 */
$server = new swoole_http_server("0.0.0.0", 8080);

/**
 * 回调函数
 * Http\Server->on 不接收 connect / receive 回调设置
 * 额外接受 request 如下所示:
 */
$server->on('request', function (swoole_http_request $request, swoole_http_response $response) {
    /**
     * 打印 $request
     */
//    echo $request->header['x-real-ip'] . " request" . PHP_EOL;
//    var_export($request->header);
//    echo PHP_EOL;
//    var_export($request->server);
//    echo PHP_EOL;

    /**
     * 基本 response
     */
//    $response->header("Content-Type", "application/json; charset=utf-8");
//    $response->end(json_encode($request->get));


    /**
     * 分段响应
     */
//    $response->write("<h1>Text1</h1>");
//    $response->write("<h2>Text22</h2>");
//    $response->write("<h3>Text333</h3>");
//    $response->write("<h4>Text4444</h4>");
//    $response->end();

    /**
     * 文件传输
     */
//    $response->header("Content-Type", "video/x-ms-wmv");
//    $response->sendfile("./test.wmv");
});

$server->start();