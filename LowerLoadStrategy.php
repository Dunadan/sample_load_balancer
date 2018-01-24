<?php

class LowerLoadStrategy implements StrategyInterface
{
    public function getWorker(array $availableWorkers): WorkerInterface
    {
        usort($availableWorkers, function (WorkerInterface $w1, WorkerInterface $w2) {
            return ($w1->getLoad() <=> $w2->getLoad());
        });
        return $availableWorkers[0];
    }

}