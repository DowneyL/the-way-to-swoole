<?php
/**
 * 异步 TCP 客户端
 */
$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

/**
 * TCP 客户端必须绑定的回调函数
 * onConnect
 * onError
 * onReceive
 * onClose
 */
$client->on("connect", function (swoole_client $client) {
    echo "Connected", PHP_EOL;
    $client->send("hello async tcp");
});

$client->on("error", function (swoole_client $client) {
    echo "({$client->errCode}): ", swoole_strerror($client->errCode), PHP_EOL ;
});

$client->on('receive', function (swoole_client $client, string $data) {
    echo "server:{$data}", PHP_EOL;
});

$client->on("close", function (swoole_client $client) {
    echo  "Closed";
});

$client->connect("127.0.0.1", 8080);