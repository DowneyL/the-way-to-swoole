<?php
class Server
{
    private $server;

    public function __construct()
    {
        $this->server = new swoole_server('0.0.0.0', 8080);
        $this->server->set(['worker_num' => 4, 'daemonize' => false]);

        $this->server->on('start', [$this, 'onStart']);
        $this->server->on('connect', [$this, 'onConnect']);
        $this->server->on('receive', [$this, 'onReceive']);
        $this->server->on('close', [$this, 'onClose']);

        $this->server->start();
    }

    public function onStart($server)
    {
        echo 'echo server start' . PHP_EOL;
    }

    public function onConnect($server, $fd, $fromId)
    {
        $server->send($fd, "Hello {$fd}!");
    }

    public function onReceive($server, $fd, $fromId, $data)
    {
        echo "Get message from client {$fd} : {$data}" . PHP_EOL;
        $server->send($fd, $data);
    }

    public function onClose($server, $fd, $fromId)
    {
        echo "Client {$fd} close connection" . PHP_EOL;
    }
}

$server = new Server();