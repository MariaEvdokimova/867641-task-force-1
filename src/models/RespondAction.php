<?php
/**
 * Created by PhpStorm.
 * User: Машенька
 * Date: 10.12.2019
 * Time: 23:19
 */

namespace TaskForce\models;


class RespondAction extends AbstractAction
{
    /**
     * Retrieves internal name
     *
     * @return string
     */
    public function getActionName(): string
    {
        return 'respond';
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