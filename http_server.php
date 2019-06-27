<?php
use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;

class HttpServer
{
    public $server = null;

    /**
     * HttpServer constructor.
     * @param string $host
     * @param int $port
     */
    public function __construct(string $host, int $port)
    {
        $this->server = new Server($host, $port);
        $this->server->set([
            'enable_static_handler' => true, 'document_root' => '/home/vagrant/code/assets',
        ]);
        $this->server->on("request" , [$this, "onRequest"]);
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function onRequest(Request $request, Response $response)
    {
        $get = $request->get;
        if (isset($get["name"]) && $get["name"] == "august") {
            $response->end("Love you!!!");
        } else {
            $response->end("Fuck you !!!!");
        }
    }
}

$httpServer = new HttpServer("0.0.0.0", 8080);
$httpServer->server->start();
