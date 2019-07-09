<?php
/**
 * 跨进程响应
 * \Http\Response->detach + \Http\Response::create 实现
 */

$server = new swoole_http_server("0.0.0.0", 8080);

$server->set(['task_worker_num' => 1]);

$server->on("task", function (swoole_http_server $server, int $taskId, int $srcWorkerId, $data) {
    echo "SrcWorkerId($srcWorkerId) - Task($taskId): started" . PHP_EOL;
    echo $data['data'] . PHP_EOL;
    return strval($data['fd']);
});

$server->on("finish", function (swoole_http_server $server, int $taskId, string $data) {
    $response = \Swoole\Http\Response::create($data);
    $response->end("request and task($taskId) finish");
});

$server->on("request", function (swoole_http_request $request, swoole_http_response $response) use ($server) {
    $uri = $request->server['request_uri'];
    if ($uri == '/favicon.ico') {
        $response->status(404);
        $response->end();
    }
    $response->detach();
    $server->task(['fd' => $response->fd, 'data' => 'do something']);
});

$server->start();