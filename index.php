<?php
declare(strict_types=1);

session_start();

use TaskForce\models\Task;
use TaskForce\exceptions\DataCorrectException;

require_once 'vendor/autoload.php';

$propertyArray = [
    'ownerId' => 1,
    'executorId' => 2,
    'expirationDate' => '09.11.2019'
];

$task = new Task($propertyArray);
$task->setActiveStatus(0);

$nextStatus = $task->getNextStatus('respond');
var_dump($task->getAvailableStatuses());
var_dump($task->getAvailableActions());
var_dump($nextStatus);

$currentAction = [];

try {
    $currentAction = $task->getCurrentActions(2);
}
catch (DataCorrectException $exception) {
    error_log("Такой роли не существует. " . $exception->getMessage());
}

var_dump($currentAction);


