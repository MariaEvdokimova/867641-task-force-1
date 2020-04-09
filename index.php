<?php
declare(strict_types=1);

session_start();

use TaskForce\db\LoadData;
use TaskForce\models\Task;
use TaskForce\exceptions\InvalidDataException;
use TaskForce\db\Connection;

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
$columns = "`category_name`,`icon`";
$table = "categories";
$file_name = $_SERVER['DOCUMENT_ROOT'] . '/data/categories.csv';

try {
    $loadData = new LoadData($file_name, $table, $columns);
    $loadData->insertData();

} catch (Exception $e) {
    error_log("Такой файл не найден {$e->getMessage()}");
}
