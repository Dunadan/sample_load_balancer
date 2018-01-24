<?php

class RoundRobinStrategy implements StrategyInterface
{
    public function getWorker(array $availableWorkers): WorkerInterface
    {
        return $availableWorkers[random_int(0, count($availableWorkers) - 1)];
    }

}