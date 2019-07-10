<?php
/**
 * 异步非阻塞多进程 WebSocket 服务
 */
$server = new swoole_websocket_server('0.0.0.0', 8080);

/**
 * onOpen
 * 当 websocket 客户端和服务端建立连接并完成握手后会回调此函数
 * 该事件可选
 */
$server->on("open", function (swoole_websocket_server $server, swoole_http_request $request) {
    var_export($request);
    echo "handshake success with fd({$request->fd})" . PHP_EOL;
});

/**
 * onMessage
 * 必选事件
 * web_socket_frame 包含客户端发来的数据帧
 */
$server->on("message", function (swoole_websocket_server $server, swoole_websocket_frame $frame) {
    echo "client($frame->fd): $frame->data" . PHP_EOL;
});

$server->on("close", function (swoole_websocket_server $server, int $fd, int $reactorId) {
    echo "client({$fd}) closed" . PHP_EOL;
});

$server->start();

