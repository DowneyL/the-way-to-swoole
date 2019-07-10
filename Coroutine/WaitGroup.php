<?php
class WaitGroup
{
    private $chan;
    private $count = 0;

    public function __construct()
    {
        $this->chan = new chan();
    }

    public function add()
    {
        $this->count++;
    }

    public function done()
    {
        $this->chan->push(true);
    }

    public function wait()
    {
        while ($this->count--) {
            $this->chan->pop();
        }
    }
}

go(function () {
   $wg = new WaitGroup();

   for ($i = 0; $i < 3000; $i++) {
       $wg->add();
       go(function () use ($wg, $i) {
           echo "task {$i}", PHP_EOL;
           $wg->done();
       });
   }

   $wg->wait();

   echo "finish", PHP_EOL;
});