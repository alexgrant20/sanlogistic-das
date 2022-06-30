<?php

namespace App\Transaction\Constants;

final class PersonDTConstant
{
  public const DOCUMENT_TYPE = ['ktp', 'sim', 'assurance', 'bpjs_kesehatan', 'bpjs_ketenagakerjaan', 'npwp'];
  public const DOCUMENT_TYPE_INPUT = [
    'ktp',
    'ktp_address',
    'ktp_image',
    'sim',
    'sim_type_id',
    'sim_expire',
    'sim_address',
    'sim_image',
    'assurance',
    'assurance_image',
    'bpjs_kesehatan',
    'bpjs_kesehatan_image',
    'bpjs_ketenagakerjaan',
    'bpjs_ketenagakerjaan_image',
    'npwp',
    'npwp_image',
  ];
}