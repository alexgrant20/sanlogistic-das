<?php

namespace App\Exports;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectExport implements FromCollection, WithHeadings, ShouldAutoSize
{
  private $ids;

  public function __construct(array $ids)
  {
    $this->ids = $ids;
  }

  public function collection()
  {
    $idsExists = count($this->ids) === 0;

    $projects =  DB::table('projects')
      ->leftJoin('companies', 'projects.company_id', '=', 'companies.id')
      ->when($idsExists, function ($query, $idsExists) {
        if ($idsExists) {
          return $query->whereIn('projects.id', $this->ids);
        }
      })
      ->orderByDesc('projects.created_at')
      ->get(
        [
          'projects.id AS project_id',
          'companies.name AS company_name',
          'projects.name AS project_name',
          'projects.date_start AS date_start',
          'projects.date_end AS date_end',
        ]
      );

    return $projects;
  }

  public function headings(): array
  {
    return [
      'ID',
      'COMPANY NAME',
      'PROJECT NAME',
      'DATE START',
      'DATE END',
    ];
  }
}