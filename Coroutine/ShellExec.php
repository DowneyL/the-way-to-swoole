<?php
/**
 * 普通执行 shell_exec 是同步阻塞的
 */

//$i = 3;
//
//while ($i--) {
//    shell_exec("sleep 3");
//}

/**
 * 上面例子的执行结果
 * [root@vagrant Coroutine]# time php ShellExec.php
 * real    0m9.029s
 * user    0m0.017s
 * sys     0m0.011s
 */

// ---------------------------------------------------------

/**
 * 以下是协程方式实现的 异步非阻塞版本
 */
$i = 3;

while ($i--) {
    go(function () {
        co::exec("sleep 3");
    });
}
/**
 * [root@vagrant Coroutine]# time php ShellExec.php
 * real    0m3.032s
 * user    0m0.012s
 * sys     0m0.019s
 */