### Worker 进程
Swoole 的工作进程，所有业务逻辑都在此进程上运行
Reactor 线程接收客户端数据，打包通过***管道***发送给某个 Worker 进程
（数据分配方法见 [dispatch_mode](http://www.baidu.com/)）

### Worker 生命周期
- 创建
- 调用 onWorkerStart
- 进入 EventLoop 等待数据
- 接受数据
- 处理数据
- 出现严重错误或总请求数达到指定上限
- 调用 onWorkerStop
- 结束进程