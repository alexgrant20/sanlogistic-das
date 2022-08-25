<?php

namespace App\Exports;

use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonExport implements FromCollection, WithHeadings, ShouldAutoSize
{
  private $ids;

  public function __construct(array $ids)
  {
    $this->ids = $ids;
  }

  public function collection()
  {
    $idsExists = count($this->ids) !== 0;

    $people =  DB::table('people')
      ->leftJoin('departments', 'people.department_id', '=', 'departments.id')
      ->leftJoin('projects', 'people.project_id', '=', 'projects.id')
      ->when($idsExists, function ($query, $idsExists) {
        if ($idsExists) {
          return $query->whereIn('people.id', $this->ids);
        }
      })
      ->orderByDesc('people.created_at')
      ->get(
        [
          'people.id AS person_id',
          'people.name AS person_name',
          'projects.name AS project_name',
          'phone_number AS phone_number',
          'departments.name AS departement_name',
        ]
      );

    return $people;
  }

  public function headings(): array
  {
    return [
      'ID',
      'PERSON NAME',
      'PROJECT NAME',
      'PHONE NUMBER',
      'DEPARTMENT'
    ];
  }
}