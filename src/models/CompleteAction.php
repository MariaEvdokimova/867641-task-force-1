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
    public static function who()
    {
        return __CLASS__;
    }

    /**
     * Retrieves internal name
     *
     * @return string
     */
    public function getActionName()
    {
        return 'Завершить';
    }

    /**
     * Compare executor Id with user Id
     *
     * @param object $actionTask
     * @param int $userId
     * @return bool
     */
    public function verificationRights(object $actionTask, int $userId)
    {
        $executorId = $actionTask->getExecutorId();
        return $executorId === $userId ? true : false;
    }
}