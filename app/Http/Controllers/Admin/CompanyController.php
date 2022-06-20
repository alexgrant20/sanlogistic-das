<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\CompanyExport;
use Exception;
use App\Models\Address;
use App\Models\Company;
use App\Models\CompanyType;
use App\Models\CompanyDocument;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Imports\CompanyImport;
use App\Models\City;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CompanyController extends Controller
{

  public function index()
  {

    $companiesDocuments = ['siup', 'sipa'];

    $companies = Company::with('companyDocuments', 'city')->latest()->get();
    $totalCompany = $companies->count();
    $totalCompanyDocument = CompanyDocument::all()->count();

    if ($totalCompany * count($companiesDocuments) !== $totalCompanyDocument) return to_route('admin.company.migrate_image');

    return view('admin.companies.index', [
      'companies' => $companies,
      'title' => 'Companies',
      'importPath' => '/admin/companies/import/excel',
    ]);
  }

  public function create()
  {
    return view('admin.companies.create', [
      'cities' => City::all(),
      'companiesTypes' => CompanyType::all(),
      'title' => 'Create Company'
    ]);
  }

  public function store(StoreCompanyRequest $request)
  {
    try {
      // Init Configuration
      $otherTable = ['siup', 'siup_image', 'siup_expire', 'sipa', 'sipa_image', 'sipa_expire'];
      $types = ['siup', 'sipa'];
      $timestamp = now()->timestamp;
      $companyDocumentQuery = [];

      DB::beginTransaction();

      $newCompany = Company::create($request->safe()->except($otherTable));
      $companyID = $newCompany['id'];
      $companyName = str_replace(' ', '', $newCompany['name']);


      foreach ($types as $type) {
        if ($request->file("{$type}_image")) {
          $fileName = "{$type}-{$companyName}-{$timestamp}.{$request->file("{$type}_image")->extension()}";
          $imagePath = $request->file("{$type}_image")->storeAs("{$type}-images", $fileName, 'public');
        }

        array_push(
          $companyDocumentQuery,
          [
            'company_id' => $companyID,
            'type' => $type,
            'number' => $request[$type],
            'image' =>  $imagePath,
            'expire' => $request["{$type}_expire"],
            'active' => $request["{$type}_expire"] > now() ? 1 : 0,
          ]
        );
      }

      CompanyDocument::insert($companyDocumentQuery);

      DB::commit();

      $notification = array(
        'message' => 'Company successfully created!',
        'alert-type' => 'success',
      );

      return to_route('admin.company.index')->with($notification);
    } catch (Exception $e) {
      DB::rollback();

      $notification = array(
        'message' => 'Company failed to create!',
        'alert-type' => 'error',
      );
      return to_route('admin.company.create')->withInput()->with($notification);
    }
  }

  public function show(Company $company)
  {
    //
  }

  public function edit(Company $company)
  {
    $siup = $company->companyDocuments->where('type', 'siup')->first();
    $sipa = $company->companyDocuments->where('type', 'sipa')->first();

    return view('admin.companies.edit', [
      'cities' => City::all(),
      'company' => $company,
      'siup' => is_null($siup) ? [] : $siup,
      'sipa' => is_null($sipa) ? [] : $sipa,
      'companies_types' => CompanyType::all(),
      'title' => "Update Company : {$company->name}"
    ]);
  }

  public function update(UpdateCompanyRequest $request, Company $company)
  {
    try {
      // Init Configuration
      $otherTable = ['siup', 'siup_image', 'siup_expire', 'sipa', 'sipa_image', 'sipa_expire'];
      $types = ['siup', 'sipa'];
      $timestamp = now()->timestamp;
      $companyName = str_replace(' ', '', $request['name']);

      DB::beginTransaction();

      $company->update($request->safe()->except($otherTable));

      foreach ($types as $type) {
        $document = $company->companyDocuments->where('type', $type)->first();

        $imagePath = $document->image;

        if ($request->file("{$type}_image")) {
          $fileName = "{$type}-{$companyName}-{$timestamp}.{$request->file("{$type}_image")->extension()}";
          $imagePath = $request->file("{$type}_image")->storeAs("{$type}-images", $fileName, 'public');
        }

        $document->update([
          'number' => $request[$type],
          'expire' => $request["{$type}_expire"],
          'active' => $request["{$type}_expire"] > now() ? 1 : 0,
          'image' => $imagePath,
        ]);
      }

      DB::commit();

      $notification = array(
        'message' => 'Company successfully updated!',
        'alert-type' => 'success',
      );

      return to_route('admin.company.index')->with($notification);
    } catch (Exception $e) {
      DB::rollback();

      $notification = array(
        'message' => 'Company failed to update!',
        'alert-type' => 'error',
      );

      return redirect("/admin/companies/{$request->name}/edit")->withInput()->with($notification);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Company  $company
   * @return \Illuminate\Http\Response
   */
  public function destroy(Company $company)
  {
    //
  }

  public function migrateImage()
  {
    try {
      $companies = Company::with('companyDocuments')->get();
      $companiesDocument = CompanyDocument::all();

      // Document Type
      $types = ['siup', 'sipa'];
      $totalDocument = count($types);

      $notification = array(
        'message' => 'Company image failed to migrate!',
        'alert-type' => 'error',
      );

      if ($companies->count() * $totalDocument === $companiesDocument->count()) {
        return to_route('admin.company.index')->with($notification);
      }

      $queryArray = [];

      foreach ($companies as $company) {

        $curDocComCount = $company->companyDocuments->count();

        if ($curDocComCount === $totalDocument) {
          continue;
        }

        foreach ($types as $type) {
          if (!$company->companyDocuments->contains('type', $type)) {
            array_push(
              $queryArray,
              [
                'company_id' => $company->id,
                'type' => $type,
                'number' => 0,
                'image' => 'default/default.jpg',
                'expire' => now(),
                'active' => 0,
              ]
            );
          }
        }
      }

      DB::beginTransaction();

      CompanyDocument::insert($queryArray);

      DB::commit();

      $notification = array(
        'message' => 'Company image successfully migrated!',
        'alert-type' => 'success',
      );

      return to_route('admin.company.index')->with($notification);
    } catch (Exception $e) {
      DB::rollBack();

      $notification = array(
        'message' => 'Company image failed to migrate!',
        'alert-type' => 'error',
      );

      return to_route('admin.company.index')->with($notification);
    }
  }

  public function importExcel(Request $request)
  {
    try {
      $request->validate([
        'file' => 'required|mimes:csv,xls,xlsx'
      ]);

      $file = $request->file('file')->store('file-import/company/');

      $import = new CompanyImport;
      $import->import($file);

      if ($import->failures()->isNotEmpty()) {
        return back()->with('importErrorList', $import->failures());
      }

      $notification = array(
        'message' => 'Company successfully imported!',
        'alert-type' => 'success',
      );

      return to_route('admin.company.index')->with($notification);
    } catch (Exception $e) {

      $notification = array(
        'message' => 'Company failed to import!',
        'alert-type' => 'error',
      );

      return to_route('admin.company.index')->with($notification);
    }
  }

  public function exportExcel(Request $request)
  {
    $timestamp = now()->timestamp;
    $params = $request->input('ids');
    $ids = preg_split("/[,]/", $params);
    return Excel::download(new CompanyExport($ids), "companies_export_{$timestamp}.xlsx");
  }
}