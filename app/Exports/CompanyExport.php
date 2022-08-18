<?php

namespace App\Exports;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompanyExport implements FromCollection, WithHeadings, ShouldAutoSize
{
  private $ids;

  public function __construct(array $ids)
  {
    $this->ids = $ids;
  }

  public function collection()
  {
    $idsExists = count($this->ids) === 0;

    $companies =  DB::table('companies')
      ->leftJoin('cities', 'companies.city_id', '=', 'cities.id')
      ->leftJoin('company_documents AS siup', function ($join) {
        $join->on('siup.company_id', '=', 'companies.id');
        $join->where('siup.type', '=', 'siup');
      })
      ->leftJoin('company_documents AS sipa', function ($join) {
        $join->on('sipa.company_id', '=', 'companies.id');
        $join->where('sipa.type', '=', 'sipa');
      })
      ->when($idsExists, function ($query, $idsExists) {
        if ($idsExists) {
          return $query->whereIn('companies.id', $this->ids);
        }
      })
      ->orderByDesc('companies.created_at')
      ->get(
        [
          'companies.id AS company_id',
          'companies.name AS company_name',
          'director AS company_director',
          'cities.name AS cities_name',
          'siup.number AS siup_number',
          'sipa.number AS sipa_number'
        ]
      );
    return $companies;
  }

  public function headings(): array
  {
    return [
      'ID',
      'COMPANY NAME',
      'DIRECTOR',
      'CITY',
      'SIUP',
      'SIPA'
    ];
  }
}