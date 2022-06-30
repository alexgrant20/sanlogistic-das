<?php

namespace App\Transaction\Constants;

final class CompanyDTConstant
{
  public const DOCUMENT_TYPE = ['siup', 'sipa'];
  public const DOCUMENT_TYPE_INPUT = [
    'siup',
    'siup_image',
    'siup_expire',
    'sipa',
    'sipa_image',
    'sipa_expire'
  ];
}