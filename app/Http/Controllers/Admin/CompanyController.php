<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\CompanyExport;
use Exception;
use App\Models\Company;
use App\Models\CompanyType;
use App\Models\CompanyDocument;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\StoreCompanyRequest;
use App\Http\Requests\Admin\UpdateCompanyRequest;
use App\Imports\CompanyImport;
use App\Models\City;
use App\Transaction\Constants\CompanyDTConstant;
use App\Transaction\Constants\NotifactionTypeConstant;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CompanyController extends Controller
{
  public function __construct()
  {
    $this->middleware('can:company-create', ['only' => ['create', 'store']]);
    $this->middleware('can:company-edit', ['only' => ['edit', 'update']]);
    $this->middleware('can:company-view', ['only' => ['index']]);
  }

  public function index()
  {
    $companies = Company::with('companyDocuments', 'city')->latest()->get();

    return view('admin.companies.index', [
      'companies' => $companies,
      'title' => 'Companies',
      'importPath' => '/admin/companies/import/excel',
    ]);
  }

  public function create()
  {
    return view('admin.companies.create', [
      'company' => new Company(),
      'cities' => City::orderBy('name')->get(),
      'companyTypes' => CompanyType::orderBy('name')->get(),
      'title' => 'Create Company'
    ]);
  }

  public function store(StoreCompanyRequest $request)
  {
    $companyPayload = $request->safe()->except(CompanyDTConstant::DOCUMENT_TYPE_INPUT);
    $timestamp = now()->timestamp;
    $companyDocumentPayload = [];

    DB::beginTransaction();

    try {
      $company = Company::create($companyPayload);
      $companyName = str_replace(' ', '', $company->name);

      foreach (CompanyDTConstant::DOCUMENT_TYPE as $docType) {
        $imageKey = "{$docType}_image";
        $imagePath = $request->hasFile($imageKey)
          ? uploadImage($request->file($imageKey), $docType, $companyName, $timestamp)
          : "";

        array_push(
          $companyDocumentPayload,
          [
            'company_id' => $company->id,
            'type' => $docType,
            'number' => $request->$docType,
            'image' =>  $imagePath,
            'expire' => $request->get("{$docType}_expire"),
            'active' => $request->get("{$docType}_expire") > now() ? 1 : 0,
          ]
        );
      }

      CompanyDocument::insert($companyDocumentPayload);
    } catch (Exception $e) {
      DB::rollback();

      return back()
        ->withInput()
        ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'company', 'create'));
    }

    DB::commit();

    return to_route('admin.companies.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'company', 'created'));
  }

  public function edit(Company $company)
  {
    $siup = $company->companyDocuments->where('type', 'siup')->first();
    $sipa = $company->companyDocuments->where('type', 'sipa')->first();

    return view('admin.companies.edit', [
      'cities' => City::orderBy('name')->get(),
      'companyTypes' => CompanyType::orderBy('name')->get(),
      'company' => $company,
      'siup' => is_null($siup) ? [] : $siup,
      'sipa' => is_null($sipa) ? [] : $sipa,
      'title' => "Update Company : {$company->name}"
    ]);
  }

  public function update(UpdateCompanyRequest $request, Company $company)
  {
    $companyPayload = $request->safe()->except(CompanyDTConstant::DOCUMENT_TYPE_INPUT);
    $timestamp = now()->timestamp;
    $companyName = str_replace(' ', '', $request['name']);
    $documents = collect(CompanyDocument::where('company_id', $company->id)->get());

    DB::beginTransaction();

    try {
      $company->update($companyPayload);

      foreach (CompanyDTConstant::DOCUMENT_TYPE as $docType) {
        $document = $documents->firstWhere('type', $docType);

        $imageKey = "{$docType}_image";

        $uploadedImagePath = $request->file($imageKey) ?
          uploadImage($request->file($imageKey), $docType, $companyName, $timestamp) :
          $document->image ?? null;

        CompanyDocument::updateOrCreate(
          [
            'id' => $document->id ?? null,
            'company_id' => $company->id,
            'type' => $docType
          ],
          [
            'number' => $request->$docType,
            'expire' => $request->get("{$docType}_expire"),
            'active' => $request->get("{$docType}_expire") > now() ? 1 : 0,
            'image' => $uploadedImagePath,
          ]
        );
      }
    } catch (Exception $e) {
      DB::rollback();
      dd($e->getMessage());

      return redirect("/admin/companies/{$request->name}/edit")
        ->withInput()
        ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'company', 'update'));
    }

    DB::commit();

    return to_route('admin.companies.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'company', 'updated'));
  }

  public function importExcel(Request $request)
  {
    $request->validate([
      'file' => 'required|mimes:csv,xls,xlsx'
    ]);
    $import = new CompanyImport;

    try {
      $file = $request->file('file')->store('file-import/company/');
      $import->import($file);
    } catch (Exception $e) {
      return to_route('admin.companies.index')->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'company', 'import'));
    }

    if ($import->failures()->isNotEmpty()) {
      return back()->with('importErrorList', $import->failures());
    }

    return to_route('admin.companies.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'company', 'imported'));
  }

  public function exportExcel(Request $request)
  {
    $timestamp = now()->timestamp;
    $params = $request->input('ids');
    $ids = preg_split("/[,]/", $params);
    return Excel::download(new CompanyExport($ids), "companies_export_{$timestamp}.xlsx");
  }
}