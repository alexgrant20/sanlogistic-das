<?php

namespace App\Transaction\Constants;

final class NotifactionTypeConstant
{
  public const ERROR = 'error';
  public const SUCCESS = 'success';

  public const NOTIFICATIONS = [
    'error' => '? Failed To ?!',
    'success' => '? Successfully ?!',
  ];
}