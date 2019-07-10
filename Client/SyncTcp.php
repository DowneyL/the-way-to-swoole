<?php
$client = new swoole_client(SWOOLE_SOCK_TCP);

if (!$client->connect("127.0.0.1", 8080, 1)) {
    echo  "connect failed", PHP_EOL;
}

if (!$client->send("hello tcp")) {
    echo  "send failed", PHP_EOL;
}

$message = $client->recv(1024);
echo $message, PHP_EOL;

$client->close();
