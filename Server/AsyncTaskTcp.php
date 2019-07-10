<?php
/**
 * 执行异步任务
 */
$server = new swoole_server("0.0.0.0", 8080, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);

$server->set(['worker_num' => 1, 'task_worker_num' => 1]);

$server->on("connect", function (swoole_server $server, int $fd, int $reactorId) {
    echo "ReactorId({$reactorId}) - Client({$fd}) connected" . PHP_EOL;
    $server->task("test");
});

$server->on("task", function (swoole_server $server, int $taskId, int $srcWorkerId, $data) {
    echo "New task({$taskId})" . PHP_EOL;
    echo "{$data}" . PHP_EOL;

    return "finish hah";
});

$server->on("finish", function (swoole_server $server, int $taskId, string $data) {
    echo "Task({$taskId}) {$data}" . PHP_EOL;
});

$server->on("receive", function (swoole_server $server, int $fd, int $reactorId, string $data) {
    echo "Receive: {$data}" . PHP_EOL;
});

$server->on("close", function (swoole_server $server, int $fd, int $reactorId) {
    echo "ReactorId($reactorId) - Client({$fd}) closed" . PHP_EOL;
});

$server->start();