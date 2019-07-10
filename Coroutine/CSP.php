<?php
Swoole\Runtime::enableCoroutine();

$chan = new chan(3);
go(function () use ($chan) {
    echo "a", PHP_EOL;
    go(function () use ($chan) {
        for ($i = 0; $i < 3; $i ++) {
            var_export($chan->pop(3));
            echo PHP_EOL;
        }
    });

    defer(function () {
        echo "~b", PHP_EOL;
    });

    go(function () use ($chan) {
        $chan->push(["test"]);
    });

    echo "c", PHP_EOL;

    go(function () use ($chan) {
        $chan->push(["test2"]);
    });

    defer(function () {
        echo "~d", PHP_EOL;
    });
    go(function () use ($chan) {
        swoole_timer_after(2000, function () use ($chan) {
            $chan->push(["test3"]);
            echo PHP_EOL;
        });
    });
});
