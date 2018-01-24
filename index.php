<?php
// Remove composer dependency
require_once 'TaskInterface.php';
require_once 'Task.php';
require_once 'WorkerInterface.php';
require_once 'LoadBalancerWorker.php';
require_once 'StrategyInterface.php';
require_once 'LowerLoadStrategy.php';
require_once 'RoundRobinStrategy.php';
require_once 'LoadBalancer.php';


function createFakeWorkers($count, $capacity = 10)
{
    $workers = [];
    for ($i = 0; $i < $count; $i++) {
        $worker = new LoadBalancerWorker($capacity);
        $worker->workerId = uniqid('worker_', true);
        $workers[] = $worker;
    }
    return $workers;
}

function createFakeTasks($count)
{
    $tasks = [];
    for ($i = 0; $i < $count; $i++) {
        $task = new Task();
        $task->taskId = 'task_' . $i;
        $tasks[] = $task;
    }
    return $tasks;
}

function printBalancerStatus(LoadBalancer $loadBalancer)
{
    foreach ($loadBalancer->getWorkers() as $worker) {
        echo "--------------------------------------\n";
        echo '-- Worker "' . $worker->workerId . "\" : \n";
        echo "--------------------------------------\n";
        foreach ($worker->getTasks() as $task) {
            echo '* Task "' . $task->taskId . "\" \n";
        }
    }
}

$workers = createFakeWorkers(4);
$tasks = createFakeTasks(10);

echo "\n\n ==== Lower load balancer ==== \n\n";

$lowerLoadBalancer = new LoadBalancer($workers, new LowerLoadStrategy());
foreach ($tasks as $task) {
    $lowerLoadBalancer->processTask($task);
}
printBalancerStatus($lowerLoadBalancer);


echo "\n\n ==== Round robin balancer ==== \n\n";
$workers = createFakeWorkers(4);
$tasks = createFakeTasks(10);
$roundRobinBalancer = new LoadBalancer($workers, new RoundRobinStrategy());
foreach ($tasks as $task) {
    $roundRobinBalancer->processTask($task);
}
printBalancerStatus($roundRobinBalancer);