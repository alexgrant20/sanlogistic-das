<?php

namespace App\Imports;

use App\Models\Project;
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

class ProjectImport implements
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
    return new Project([
      'company_id' => $row['company_id'],
      'name' => $row['name'],
      'date_start' => $row['date_start'],
      'date_end' => $row['date_end'],
      'catatan' => $row['catatan'],
      'created_by' => $row['created_by'],
      'updated_by' => $row['updated_by'],
      'created_at' => $row['created_at'],
      'updated_at' => $row['updated_at'],
    ]);
  }

  public function rules(): array
  {
    return [
      '*.name' => ['unique:people']
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
