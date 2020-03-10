<?php
declare(strict_types=1);

namespace TaskForce\models;

use Exception;
use TaskForce\exceptions\InvalidDataException;
use Throwable;
/**
 * Class models
 */
class Task
{
    /**
     * Statuses list code
     */
    const STATUS_NEW = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_CANCEL = 2;
    const STATUS_FAILED = 3;
    const STATUS_COMPLETED = 4;

    /**
     * Actions list code
     */
    const ACTION_RESPOND = 'respond';
    const ACTION_CANCEL = 'cancel';
    const ACTION_FAIL = 'fail';
    const ACTION_COMPLETE = 'complete';

    /**
     * Users role list code
     */
    const USER_ROLE_OWNER = 'owner';
    const USER_ROLE_EXECUTOR = 'executor';

    /**
     * Array $key is action, $value is next status
     *
     * @var array
     */
    const ACTION_STATUS = [
        self::ACTION_RESPOND => self::STATUS_IN_PROGRESS,
        self::ACTION_CANCEL => self::STATUS_CANCEL,
        self::ACTION_FAIL => self::STATUS_FAILED,
        self::ACTION_COMPLETE => self::STATUS_COMPLETED
    ];

    /**
     * Active status
     *
     * @var int
     */
    private $activeStatus;

    /**
     * Owner ID
     *
     * @var int
     */
    public $ownerId;

    /**
     * Executor ID
     *
     * @var int
     */

    public $executorId;

    /**
     * Expiration date
     *
     * @var string
     */

    private $expirationDate;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Set active status
     *
     * @param int $activeStatus
     * @throws Exception Status does not exist
     */
    public function setActiveStatus(int $activeStatus): void
    {
        if (!in_array($activeStatus, $this->getAvailableStatuses())) {
            throw new InvalidDataException("Ошибка: статус {$activeStatus} не существует");
        }
        $this->activeStatus = $activeStatus;
    }

    /**
     * Retrieves list available statuses
     *
     * @return array
     */
    public function getAvailableStatuses(): array
    {
        return [
            self::STATUS_NEW,
            self::STATUS_IN_PROGRESS,
            self::STATUS_CANCEL,
            self::STATUS_FAILED,
            self::STATUS_COMPLETED
        ];
    }

    /**
     * Retrieves list available actions
     *
     * @return array
     */
    public function getAvailableActions(): array
    {
        return [
            self::ACTION_RESPOND,
            self::ACTION_CANCEL,
            self::ACTION_FAIL,
            self::ACTION_COMPLETE
        ];
    }

    /**
     * Retrieves appropriate status after action
     *
     * @param string $action Action
     * @return int|null $nextStatus next status
     */
    public function getNextStatus(string $action): ?int
    {
        return self::ACTION_STATUS[$action] ?? null;
    }

    /**
     * @param int $userId User Id
     *
     * @return array Action
     * @throws Exception User role does not exist
     */
    public function getCurrentActions(int $userId): ?array
    {
        if ($userId !== $this->ownerId && $userId !== $this->executorId) {
            throw new InvalidDataException("Ошибка: нет такой роли {$userId}");
        }

        switch ($this->activeStatus) {
            case self::STATUS_NEW:
                $actions = [
                    new CancelAction(),
                    new RespondAction(),
                ];
                break;
            case self::STATUS_IN_PROGRESS:
                $actions = [
                    new CompleteAction(),
                    new FailAction(),
                ];
                break;
            default:
                return [];
        }

        return array_filter($actions, function(AbstractAction $action) use ($userId) {
            return $action->checkAccess($this,$userId);
        });
    }
}
