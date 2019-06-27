<?php
use Swoole\WebSocket\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\WebSocket\Frame;

class WebSocketServer
{
    public $server = null;

    public function __construct(string $host, int $port)
    {
        $this->server = new Server($host, $port);
        $this->server->set([
            'worker_num' => 2, 'task_worker_num' => 2,
        ]);
        $this->server->on("start", [$this, "onStart"]);
        $this->server->on("WorkerStart", [$this, "onWorkerStart"]);
        $this->server->on("connect", [$this, "onConnect"]);
        $this->server->on("receive", [$this, "onReceive"]);
        $this->server->on("close", [$this, "onClose"]);
        $this->server->on("WorkerStop", [$this, "onWorkerStop"]);
        $this->server->on("WorkerExit", [$this, "onWorkerExit"]);
        $this->server->on("task", [$this, "onTask"]);
        $this->server->on("finish", [$this, "onFinish"]);
        $this->server->on("open", [$this, "onOpen"]);
//        $this->server->on("Handshake", [$this, "onHandshake"]);
        $this->server->on("message", [$this, "onMessage"]);
    }

    public static function msg(string $str)
    {
        echo date("Y-m-d H:i:s", time()) . " $str" . "\n";
    }

    public function onStart(Server $server)
    {
        static::msg(__METHOD__);
    }

    public function onWorkerStart(Server $server, int $workerId)
    {
        static::msg(__METHOD__);
        static::msg("My worker id is {$workerId}");
    }

    public function onConnect(Server $server, int $fd, int $reactorId)
    {
        static::msg(__METHOD__);
        static::msg("Client {$fd} is connect to me, and i was give he {$reactorId} reactor");
    }

    public function onReceive(Server $server, int $fd, int $reactorId, string $data)
    {
        static::msg(__METHOD__);
        static::msg("{$fd} - {$reactorId} - receive:{$data}");
    }

    public function onClose(Server $server, int $fd, int $reactorId)
    {
        static::msg(__METHOD__);
        static::msg("{$fd} - {$reactorId} - close");
    }

    public function onWorkerStop(Server $server, int $workerId)
    {
        static::msg(__METHOD__);
        static::msg("worker id:{$workerId} stop works");
    }

    public function onWorkerExit(Server $server, int $workerId)
    {
        static::msg(__METHOD__);
        static::msg("worker id:{$workerId} exit works");
    }

    public function onTask(Server $server, int $taskId, int $srcWorkerId, array $data)
    {
        static::msg(__METHOD__);
        static::msg("task id:{$taskId} | src worker id:{$srcWorkerId} | data:" . json_encode($data));
        sleep(10);
        return "task finish";
    }

    public function onFinish(Server $server, int $taskId, string $data)
    {
        static::msg(__METHOD__);
        static::msg("task id:{$taskId} {$data}");
    }

    public function onOpen(Server $server, Request $request)
    {
        static::msg(__METHOD__);
        $data = ["name" => "haha"];
        $server->task($data);
        static::msg("request:" . json_encode($request->get));
    }

//    public function onHandshake(Request $request, Response $response)
//    {
//        static::msg(__METHOD__);
//    }

    public function onMessage(Server $server, Frame $frame)
    {
        static::msg(__METHOD__);
        static::msg("get:" . $frame->data);
        $server->push($frame->fd, "You give me this {$frame->data}");
    }
}

$ws = new WebSocketServer("0.0.0.0", 8081);
$server = $ws->server;

$server->start();
