<?php
/**
 * Created by PhpStorm.
 * User: Машенька
 * Date: 10.12.2019
 * Time: 23:20
 */

namespace TaskForce\models;


class CancelAction extends AbstractAction
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
        return 'Отменить';
    }

    /**
     * Compare owner Id with user Id
     *
     * @param object $actionTask
     * @param int $userId
     * @return bool
     */
    public function verificationRights(object $actionTask, int $userId)
    {
        $ownerId = $actionTask->getOwnerId();
        return $ownerId === $userId ? true : false;
    }

}