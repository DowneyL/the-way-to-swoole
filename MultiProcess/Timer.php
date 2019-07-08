<?php

/**
 * tick 定时器是永久定时器
 * 每隔指定毫秒数后执行一次 callback 函数
 */

/*
$str = "say";

$timerId = swoole_timer_tick(1000, function ($timerId, $params) use ($str) {
    echo $str . $params . PHP_EOL;
}, " hello!");
*/

/**
 * after 定时器是临时定时器
 * 指定毫秒数后制定一次 callback 函数，即删除该定时器
 * 回调函数不可接受任何参数，可以通过闭包的方式传递参数
 */


class Test
{
    private $str = "say hello";
    public function onAfter()
    {
        echo $this->str . PHP_EOL;
    }
}

$test = new Test();
swoole_timer_after(2000, [$test, "onAfter"]);

$str = "say bye";
swoole_timer_after(1000, function () use ($str) {
   echo $str . PHP_EOL;
});