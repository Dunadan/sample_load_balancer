<?php
declare(strict_types=1);

interface WorkerInterface
{
    public function processTask(TaskInterface $task);

    public function isBusy(): bool;

    public function getLoad(): int;

}