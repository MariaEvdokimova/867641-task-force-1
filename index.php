<?php
session_start();

use TaskForce\models\Task;
use TaskForce\models\CancelAction;

require_once 'vendor/autoload.php';

$propertyArray = [
    'ownerId' => 1,
    'executorId' => 2,
    'expirationDate' => '09.11.2019',
    'activeStatus' => 0
];

$task = new Task($propertyArray);

$nextStatus = $task->getNextStatus('respond');
var_dump($task->getAvailableStatuses());
var_dump($task->getAvailableActions());
var_dump($nextStatus);

$currentAction = $task->getCurrentActions(1);
var_dump($currentAction);
