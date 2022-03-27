<?php

namespace App\Imports;

use App\Models\Address;
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

class AddressImport implements
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
    return new Address([
      'address_type_id' => $row['address_type_id'],
      'area_id' => $row['area_id'],
      'subdistrict_id' => $row['subdistrict_id'],
      'pool_type_id' => $row['pool_type_id'],
      'name' => $row['name'],
      'full_address' => $row['full_address'],
      'longitude' => $row['longitude'],
      'latitude' => $row['latitude'],
      'post_number' => $row['post_number'],
      'created_by' => $row['created_by'],
      'updated_by' => $row['updated_by'],
      'created_at' => $row['created_at'],
      'updated_at' => $row['updated_at'],
    ]);
  }

  public function rules(): array
  {
    return [
      '*.name' => ['unique:addresses']
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
