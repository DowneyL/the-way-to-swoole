<?php
$int = mt_rand(0, 100);
echo $int . PHP_EOL;

$workerNum = 4;

for($i = 0; $i < $workerNum; $i++) {
    $worker = new swoole_process('child_async', false, 2);
    $pid = $worker->start();
}

function child_async(swoole_process $worker)
{
    mt_srand();
    echo mt_rand(0, 100) , PHP_EOL;
    $worker->exit(9);
}
