<?php
/**
 * Created by PhpStorm.
 * User: Машенька
 * Date: 07.12.2019
 * Time: 22:02
 */

namespace TaskForce\models;


abstract class AbstractAction
{
    public static function who()
    {
        return __CLASS__;
    }

    /**
     * Retrieves Class Name
     */
    public static function getClassName()
    {
       static::who();
    }

    /**
     * Retrieves internal name
     *
     * @return string
     */
    abstract public function getActionName();

    /**
     * Compare necessary Id with user Id
     *
     * @param object $actionTask
     * @param int $userId
     * @return mixed
     */
    abstract public function verificationRights(object $actionTask, int $userId);
}