<?php
// 创建 server 对象， 监听 0.0.0.0:8080 端口
$server = new swoole_server("0.0.0.0", 8080);


// 5 秒侦测一次心跳，如果有链连接 10s 都没向服务器发送数据，就主动断开连接
$server->set([
    'heartbeat_check_interval' => 5,
    'heartbeat_idle_time' => 10,
]);

// 监听连接事件
/**
 * 回调函数
 * onConnect
 * 发生在 worker 进程中
 * $server 是 Swoole\Server 对象
 * $fd 是连接的文件描述符，发送数据/关闭连接时需要此参数
 * $reactorId 来自哪个 Reactor 线程
 */
$server->on("connect", function (swoole_server $server, int $fd, int $reactorId) {
    echo "From($reactorId) - Client($fd): connected." . PHP_EOL;
});

// 监听数据接收事件
/**
 * onReceive
 * 发生在 worker 进程中
 * $data 收到的数据内容，可能是文本或二进制内容
 * UDP 协议下只有 onReceive 事件， 没有 onConnect 和 onClose
 */
$server->on("receive", function (swoole_server $server, int $fd, int $reactorId, string $data) {
    echo "From($reactorId) - Client($fd): $data" . PHP_EOL;

    // 将客户端发送过来的数据，发回给客户端
    $server->send($fd, $data);
//    $server->close($fd);
//    throw new Exception("test exception", 50001);
});


/**
 * onClose
 * 此回调函数发生致命错误是，会导致连接泄露
 * 大量的 CLOSE_WAIT 状态的 TCP 连接
 * 客户端发起 close 或是 调用 $server->close($fd) 都会处罚此回调函数
 */
$server->on("close", function (swoole_server $server, int $fd, int $reactorId) {
    echo "From($reactorId) - Client($fd): close" . PHP_EOL;
});

$server->start();
