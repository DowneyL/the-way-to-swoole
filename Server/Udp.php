<?php
// 创建 Server 对象，监听 0.0.0.0:8080, 类型为 SWOOLE_SOCK_UDP
$server = new swoole_server("0.0.0.0", 8080, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

/**
 * 回调函数
 * onPacket
 * 发生在 worker 进程中
 * 接收到 UDP 数据包时回调此函数
 * $data 收到的数据内容，可能是文本或者二进制内容
 * $client_info, 客户端信息
 * array (
 *  'server_socket' => 3,
 *  'server_port' => 8080,
 *  'address' => '127.0.0.1',
 *  'port' => 46765,
 * )
 */
$server->on("packet", function (swoole_server $server, string $data, array $clientInfo) {
    echo $data . PHP_EOL;
    var_export($clientInfo);
    echo PHP_EOL;
    $server->sendto($clientInfo['address'], $clientInfo['port'], "Server: " . $data);
});

$server->start();