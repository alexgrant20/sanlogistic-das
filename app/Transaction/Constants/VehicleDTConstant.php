<?php

namespace App\Transaction\Constants;

final class VehicleDTConstant
{
  public const DOCUMENT_TYPE = ['kir', 'stnk'];
  public const IMAGE_TYPE = ['front', 'left', 'right', 'back'];
  public const DOCUMENT_TYPE_INPUT = [
    'kir_number',
    'kir_expire',
    'kir_image',
    'stnk_number',
    'stnk_expire',
    'stnk_image',
    'front_image',
    'left_image',
    'right_image',
    'back_image',
  ];
}