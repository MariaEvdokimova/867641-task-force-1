<?php

use TaskForce\models\Task;

require_once 'vendor/autoload.php';

$obj = new Task(1, 1, 'ff');

$nextStatus = $obj->getNextStatus('complete');
var_dump($obj->getAvailableStatuses());
var_dump($obj->getAvailableActions());
var_dump($nextStatus);
