<?php

use TaskForce\Task\GetStatusAction;

require_once 'vendor/autoload.php';

$obj = new GetStatusAction(1, 1, 'ff');

$nextStatus = $obj->getNextStatus('complete');
var_dump($obj->getAvailableStatuses());
var_dump($obj->getAvailableActions());
var_dump($nextStatus);
