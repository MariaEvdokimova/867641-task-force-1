<?php

/**
 * Class GetStatusAction
 */
class GetStatusAction
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
  const ACTION_STATUS = array(
    self::ACTION_RESPOND => self::STATUS_IN_PROGRESS,
    self::ACTION_CANCEL => self::STATUS_CANCEL,
    self::ACTION_FAIL => self::STATUS_FAILED,
    self::ACTION_COMPLETE => self::STATUS_COMPLETED
  );

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
  private $OwnerId;

  /**
   * Executor ID
   *
   * @var int
   */

  private $ExecutorId;

  /**
   * Expiration date
   *
   * @var string
   */
  private $expirationDate;

  public function __construct(int $OwnerId, int $ExecutorId, string $expirationDate)
  {
    $this->OwnerId = $OwnerId;
    $this->ExecutorId = $ExecutorId;
    $this->expirationDate = $expirationDate;
  }

  /**
   * Set active status
   *
   * @param int $activeStatus
   * @throws Exception Status does not exist
   */
  public function setActiveStatus (int $activeStatus)
  {
    try {
      $this->activeStatus = $activeStatus;

      if ($activeStatus !== self::STATUS_NEW
        && $activeStatus !== self::STATUS_IN_PROGRESS
        && $activeStatus !== self::STATUS_CANCEL
        && $activeStatus !== self::STATUS_FAILED
        && $activeStatus !== self::STATUS_COMPLETED
      ) {
        throw new Exception('Ошибка: статуса ' . $activeStatus . ' статус не существует');
      }
    }
    catch (Exception $e) {
      error_log("Не удалось определить статус: " . $e->getMessage());
    }
  }

  /**
   * Retrieves list available statuses
   *
   * @return array
   */
  public function getAvailableStatuses(): array{}

  /**
   * Retrieves list available actions
   *
   * @return array
   */
  public function getAvailableActions(): array{}

  /**
   * Retrieves appropriate status after action
   *
   * @param string $action Action
   * @return int|null $nextStatus next status
   */
  public function getNextStatus(string $action): ?int
  {
    $nextStatus = array_key_exists($action, self::ACTION_STATUS) ? self::ACTION_STATUS[$action] : null;
    return $nextStatus;
  }
}
