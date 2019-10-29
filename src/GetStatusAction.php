<?php

class GetStatusAction
{
  const TABLE_STATUSES = 'statuses';
  const TABLE_ACTIONS = 'actions';
  const TABLE_ROLES = 'roles';

  public $activeStatus;
  public $idContractor;
  public $idCustomer;
  public $expirationDate;

  public function __construct($activeStatus, $idContractor, $idCustomer, $expirationDate)
  {
    $this->activeStatus = $activeStatus;
    $this->idContractor = $idContractor;
    $this->idCustomer = $idCustomer;
    $this->expirationDate = $expirationDate;
  }

  public function getListStatusesActions(){}

  public function getStatus($name){}
}
