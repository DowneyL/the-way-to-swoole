<?php

include_once 'BaseServer.php';

class TaskWorkerTestServer extends BaseServer
{
    public function bind()
    {
        $this->server->on('task', [$this, 'onTask']);
        $this->server->on('finish', [$this, 'onFinish']);
        parent::bind();
    }

    public function onReceive($server, $fd, $reactorId, $data)
    {
        if ($data == 'task') {
            $this->server->task("task data");
        } else {
            parent::onReceive($server, $fd, $reactorId, $data);
        }
    }

    public function onTask($server, $taskId, $reactorId, $data)
    {
        echo "Task($taskId): $data" . PHP_EOL;
    }

    public function onFinish($server, $taskId, $data)
    {
        echo  "Task({$taskId}) finished" . PHP_EOL;
    }
}

$server = new TaskWorkerTestServer('0.0.0.0', 8080);
$server->setTaskWorkerNum(2);
$server->start();