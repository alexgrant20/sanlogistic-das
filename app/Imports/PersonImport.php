<?php

namespace App\Imports;

use App\Models\Person;
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

class PersonImport implements
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
    return new Person([
      'project_id' => $row['project_id'],
      'department_id' => $row['department_id'],
      'area_id' => $row['area_id'],
      'address_id' => $row['address_id'],
      'name' => $row['name'],
      'image' => $row['image'],
      'place_of_birth' => $row['place_of_birth'],
      'date_of_birth' => $row['date_of_birth'],
      'phone_number' => $row['phone_number'],
      'joined_at' => $row['joined_at'],
      'note' => $row['note'],
      'active' => $row['active'],
      'created_by' => $row['created_by'],
      'updated_by' => $row['updated_by'],
      'created_at' => $row['created_at'],
      'updated_at' => $row['updated_at'],
    ]);
  }

  public function rules(): array
  {
    return [];
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
