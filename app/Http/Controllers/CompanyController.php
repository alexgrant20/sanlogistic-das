<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Address;
use App\Models\Company;
use App\Models\CompanyType;
use App\Models\CompanyDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

class CompanyController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    $companiesDocuments = ['siup', 'sipa'];

    $companies = Company::with('companyDocuments', 'address')->latest()->get();
    $totalCompany = $companies->count();
    $totalCompanyDocument = CompanyDocument::all()->count();

    return view('companies.index', [
      'companies' => $companies,
      'imagesMigrated' => $totalCompany * count($companiesDocuments) === $totalCompanyDocument,

    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('companies.create', [
      'addresses' => Address::all(),
      'companiesTypes' => CompanyType::all(),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreCompanyRequest  $request
   * @return \Illuminate\Http\Response
   */
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
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ]
        );
      }

      CompanyDocument::insert($companyDocumentQuery);

      DB::commit();

      return redirect('/companies')->with('success', 'New company has been added!');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('/companies/create')->withInput()->with('error', $e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Company  $company
   * @return \Illuminate\Http\Response
   */
  public function show(Company $company)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Company  $company
   * @return \Illuminate\Http\Response
   */
  public function edit(Company $company)
  {
    $siup = $company->companyDocuments->where('type', 'siup')->first();
    $sipa = $company->companyDocuments->where('type', 'sipa')->first();

    return view('companies.edit', [
      'addresses' => Address::all(),
      'company' => $company,
      'siup' => is_null($siup) ? [] : $siup,
      'sipa' => is_null($sipa) ? [] : $sipa,
      'companies_types' => CompanyType::all(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateCompanyRequest  $request
   * @param  \App\Models\Company  $company
   * @return \Illuminate\Http\Response
   */
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

      return redirect('/companies')->with('success', 'Company has been updated!');
    } catch (Exception $e) {
      DB::rollback();
      return redirect("/companies/{$request->name}/edit")->withInput()->with('error', $e->getMessage());
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


  /**
   * Migrate from old company DB File System to new.
   *
   * @param  \App\Models\Company  $company
   * @return \Illuminate\Http\Response
   */
  public function migrateImage()
  {
    try {
      $companies = Company::with('companyDocuments')->get();
      $companiesDocument = CompanyDocument::all();

      // Document Type
      $types = ['siup', 'sipa'];
      $totalDocument = count($types);

      if ($companies->count() * $totalDocument === $companiesDocument->count()) {
        return redirect('/companies')->with('error', 'Migration is not needed!');
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
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
              ]
            );
          }
        }
      }

      DB::beginTransaction();

      CompanyDocument::insert($queryArray);

      DB::commit();
      return redirect('/companies')->with('success', 'Migrate image completed!');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect('/companies')->with('error', $e->getMessage());
    }
  }
}