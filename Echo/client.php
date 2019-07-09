<?php

class Client
{
    private $client;

    public function __construct()
    {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP);
    }

    public function connect($host, $port)
    {
        if (!$this->client->connect($host, $port)) {
            exit("Error({$this->client->errCode}):{$this->client->errMsg}" . PHP_EOL);
        }

        fwrite(STDOUT, "input message:");
        $message = trim(fgets(STDIN));
        $this->client->send($message);
//        $receiveMsg = $this->client->recv();
//        echo "Get message from server : {$receiveMsg}" . PHP_EOL;
    }
}

$client = new Client();
$client->connect('127.0.0.1', 8080);