<?php

require_once 'src/GetStatusAction.php';

$obj = new GetStatusAction(1, 1, 'ff');

$nextStatus = $obj->getNextStatus('complete');
var_dump($obj);
var_dump($nextStatus);

