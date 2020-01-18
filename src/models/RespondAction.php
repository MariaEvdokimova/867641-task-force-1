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
        return 'Откликнуться';
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