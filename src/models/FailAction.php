<?php
declare(strict_types=1);

namespace TaskForce\models;


class FailAction extends AbstractAction
{
    /**
     * Retrieves internal name
     *
     * @return string
     */
    public function getActionName(): string
    {
        return 'fail';
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
