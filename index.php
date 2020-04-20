<?php
declare(strict_types=1);

session_start();

use TaskForce\models\Task;
use TaskForce\exceptions\InvalidDataException;
use TaskForce\utils\Csv2SqlParser;

require_once 'vendor/autoload.php';
/*
$propertyArray = [
    'ownerId' => 1,
    'executorId' => 2,
    'expirationDate' => '09.11.2019'
];

$task = new Task($propertyArray);

try {
    $task->setActiveStatus(0);
} catch (InvalidDataException $exception) {
    error_log("Не удалось определить статус: {$exception->getMessage()}");
}

$nextStatus = $task->getNextStatus('respond');

$currentAction = [];

try {
    $currentAction = $task->getCurrentActions(2);
} catch (InvalidDataException $exception) {
    error_log("Такой роли не существует {$exception->getMessage()}");
}
*/

$file = $_SERVER['DOCUMENT_ROOT'] . '/data/reviews.csv';
try {
//CSV2SQLParser::parse($file, $_SERVER['DOCUMENT_ROOT'] . '/sqls', ',');
    CSV2SQLParser::parse($file, $_SERVER['DOCUMENT_ROOT'] . '/sqls', ',', ['task_id', 'executor_id'], function () {
        return [
            rand(31,40),
            rand(41,60),
            // '2020-01-10 12:00:58',
        ];
    });
} catch (Exception $e) {
    error_log("Ошибка {$e->getMessage()}");
}
