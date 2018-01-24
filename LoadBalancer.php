<?php

class LoadBalancer
{
    /** @var  StrategyInterface */
    private $strategy;

    /** @var  WorkerInterface[] */
    private $workers = [];

    public function __construct(array $workers, StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
        foreach ($workers as $worker) {
            $this->addWorker($worker);
        }
    }

    private function addWorker(WorkerInterface $worker):void
    {
        $this->workers[] = $worker;
    }

    public function getWorkers():array
    {
        return $this->workers;
    }

    public function processTask(TaskInterface $task):void
    {
        $availableWorkers = array_filter($this->workers, function (WorkerInterface $worker) {
            return !$worker->isBusy();
        });
        if (!$availableWorkers) {
            throw new Exception('Workers overloaded!');
        }
        $this->strategy->getWorker($this->workers)->processTask($task);
    }
}