<?php
session_start();

use TaskForce\models\Task;
use TaskForce\models\CancelAction;

require_once 'vendor/autoload.php';

$propertyArray = [
    'ownerId' => 1,
    'executorId' => 2,
    'expirationDate' => '09.11.2019'
];

$obj = new Task($propertyArray);

$nextStatus = $obj->getNextStatus('respond', 0, $obj, 2);
var_dump($obj->getAvailableStatuses());
var_dump($obj->getAvailableActions());
var_dump($nextStatus);
