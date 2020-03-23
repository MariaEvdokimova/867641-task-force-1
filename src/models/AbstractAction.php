<?php
declare(strict_types=1);

namespace TaskForce\models;


abstract class AbstractAction
{
    /**
     * Retrieves Class Name
     *
     * @return string
     */
    public static function getClassName(): string
    {
        return static::class;
    }

    /**
     * Retrieves internal name
     *
     * @return string
     */
    abstract public function getActionName(): string;

    /**
     * Compare necessary Id with user Id
     *
     * @param Task $task
     * @param int $userId
     * @return mixed
     */
    abstract public function checkAccess(Task $task, int $userId): bool;
}
