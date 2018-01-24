<?php

class LoadBalancerWorker implements WorkerInterface
{

    /**
     * @var int
     */
    private $capacity;
    private $tasks = [];

    public function __construct($capacity = 10)
    {
        $this->capacity = $capacity;
    }

    public function processTask(TaskInterface $task):void
    {
        $this->tasks[] = $task;
    }

    public function isBusy(): bool
    {
        return ($this->getLoad() >= $this->capacity);
    }

    public function getLoad(): int
    {
        return count($this->tasks);
    }

    public function runNextTask()
    {
        return (!$this->tasks) ? null : array_shift($this->tasks)->run();
    }

    /**
     * For debug
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}