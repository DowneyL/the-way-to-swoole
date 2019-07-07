<?php

class BaseServer
{
    protected $server;
    protected $workerNum = 2;
    protected $daemonize = false;

    public function __construct(string $host, int $port)
    {
        $this->server = new swoole_server($host, $port);
        $this->server->set(
            [
                'worker_num' => $this->workerNum,
                'daemonize' => $this->daemonize,
            ]
        );
        $this->bind();
    }

    public function setTaskWorkerNum(int $taskWorkerNum): void
    {
        $this->server->set(['task_worker_num' => $taskWorkerNum]);
    }

    public function bind()
    {
        $this->server->on('start', [$this, 'onStart']);
        $this->server->on('connect', [$this, 'onConnect']);
        $this->server->on('receive', [$this, 'onReceive']);
    }

    public function start()
    {
        $this->server->start();
    }

    public function onStart($server)
    {
        echo "Server start" . PHP_EOL;
    }

    public function onConnect($server, $fd, $reactorId)
    {
        echo "Client({$fd}) is connected" . PHP_EOL;
    }

    public function onReceive($server, $fd, $reactorId, $data)
    {
        echo "Client({$fd}):{$data}" . PHP_EOL;
    }
}