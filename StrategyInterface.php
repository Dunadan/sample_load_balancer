<?php

interface StrategyInterface
{
    public function getWorker(array $availableWorkers): WorkerInterface;
}