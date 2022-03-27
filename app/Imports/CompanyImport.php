<?php

namespace App\Imports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CompanyImport implements
  ToModel,
  WithHeadingRow,
  SkipsOnError,
  WithValidation,
  SkipsOnFailure,
  WithBatchInserts,
  WithChunkReading
{
  use Importable, SkipsErrors, SkipsFailures;

  public function model(array $row)
  {
    return new Company([
      'address_id' => $row['address_id'],
      'company_type_id' => $row['company_type_id'],
      'name' => $row['name'],
      'phone_number' => $row['phone_number'],
      'email' => $row['email'],
      'note' => $row['note'],
      'website' => $row['website'],
      'director' => $row['director'],
      'npwp' => $row['npwp'],
      'fax' => $row['fax'],
      'created_by' => $row['created_by'],
      'updated_by' => $row['updated_by'],
      'created_at' => $row['created_at'],
      'updated_at' => $row['updated_at'],
    ]);
  }

  public function rules(): array
  {
    return [
      '*.name' => ['unique:companies']
    ];
  }

  public function batchSize(): int
  {
    return 1000;
  }

  public function chunkSize(): int
  {
    return 1000;
  }
}
