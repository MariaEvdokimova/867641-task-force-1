<?php
/**
 * Created by PhpStorm.
 * User: Машенька
 * Date: 07.12.2019
 * Time: 22:28
 */

namespace TaskForce\models;


class CompleteAction extends AbstractAction
{
    /**
     * Retrieves internal name
     *
     * @return string
     */
    public function getActionName(): string
    {
        return 'complete';
    }

    /**
     * Compare executor Id with user Id
     *
     * @param Task $task
     * @param int $userId
     * @return bool
     */
    public function checkAccess(Task $task, int $userId): bool
    {
        return $userId === $task->executorId;
    }
}