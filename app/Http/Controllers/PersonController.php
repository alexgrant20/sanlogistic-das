<?php

namespace App\Http\Controllers;

use App\Exports\PersonExport;
use App\Models\Area;
use App\Models\Person;
use App\Models\Address;
use App\Models\Project;
use App\Models\SimType;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\PersonDocument;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class PersonController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('people.index', [
      'people' => Person::with('department')->latest()->get(),
      'title' => 'People'
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('people.create', [
      'areas' => Area::all(),
      'departments' => Department::all(),
      'projects' => Project::all(),
      'addresses' => Address::all(),
      'simTypes' => SimType::all(),
      'title' => 'Create Person',
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StorePersonRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StorePersonRequest $request)
  {
    try {
      // Init Configuration
      $otherTable = [
        'ktp',
        'ktp_address',
        'ktp_image',
        'sim',
        'sim_type_id',
        'sim_expire',
        'sim_address',
        'sim_image',
        'assurance',
        'assurance_image',
        'bpjs_kesehatan',
        'bpjs_kesehatan_image',
        'bpjs_ketenagakerjaan',
        'bpjs_ketenagakerjaan_image',
        'npwp',
        'npwp_image',
      ];

      $timestamp = now()->timestamp;
      $documents = ['ktp', 'sim', 'assurance', 'bpjs_kesehatan', 'bpjs_ketenagakerjaan', 'npwp'];
      $documentQuery = [];

      $personData = $request->safe()->except($otherTable);

      if ($request->file("image")) {
        $fileName = "person_image-{$personData['name']}-{$timestamp}.{$request->file('image')->extension()}";
        $imagePath = $request->file('image')->storeAs("person-images", $fileName, 'public');
      }

      $personData['image'] = $imagePath;

      DB::beginTransaction();

      $newPerson = Person::create($personData);
      $personID = $newPerson['id'];
      $personName = str_replace(' ', '', $newPerson['name']);

      foreach ($documents as $doc) {

        if ($request->file("{$doc}_image")) {
          $fileName = "{$doc}-{$personName}-{$timestamp}.{$request->file("{$doc}_image")->extension()}";
          $imagePath = $request->file("{$doc}_image")->storeAs("{$doc}-images", $fileName, 'public');
        }

        if (isset($doc["{$doc}_expire"])) {
          $active = $doc["{$doc}_expire"] > now() ? 1 : 0;
        } else {
          $active = 1;
        }

        array_push($documentQuery, [
          'person_id' => $personID,
          'type' => $doc,
          'specialID' => $request["{$doc}_type_id"] ?? null,
          'number' => $request[$doc],
          'address' => $request["{$doc}_address"] ?? null,
          'image' => $imagePath,
          'expire' => $request["{$doc}_expire"] ?? null,
          'active' => $active,
        ]);
      }

      PersonDocument::insert($documentQuery);

      DB::commit();
      return redirect('/people')->with('success', 'New person has been added!');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('/people/create')->withInput()->with('error', $e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Person  $person
   * @return \Illuminate\Http\Response
   */
  public function show(Person $person)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Person  $person
   * @return \Illuminate\Http\Response
   */
  public function edit(Person $person)
  {
    $ktp = $person->personDocuments->where('type', 'ktp')->first();
    $sim = $person->personDocuments->where('type', 'sim')->first();
    $assurance = $person->personDocuments->where('type', 'assurance')->first();
    $bpjs_kesehatan = $person->personDocuments->where('type', 'bpjs_kesehatan')->first();
    $bpjs_ketenagakerjaan = $person->personDocuments->where('type', 'bpjs_ketenagakerjaan')->first();
    $npwp = $person->personDocuments->where('type', 'npwp')->first();

    return view('people.edit', [
      'person' => $person,
      'areas' => Area::all(),
      'departments' => Department::all(),
      'projects' => Project::all(),
      'addresses' => Address::all(),
      'simTypes' => SimType::all(),
      'ktp' => $ktp,
      'sim' => $sim,
      'assurance' => $assurance,
      'bpjs_kesehatan' => $bpjs_kesehatan,
      'bpjs_ketenagakerjaan' => $bpjs_ketenagakerjaan,
      'npwp' => $npwp,
      'title' => "Update Person : {$person->name}"
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdatePersonRequest  $request
   * @param  \App\Models\Person  $person
   * @return \Illuminate\Http\Response
   */
  public function update(UpdatePersonRequest $request, Person $person)
  {

    try {
      // Init Configuration
      $otherTable = [
        'ktp',
        'ktp_address',
        'ktp_image',
        'sim',
        'sim_type_id',
        'sim_expire',
        'sim_address',
        'sim_image',
        'assurance',
        'assurance_image',
        'bpjs_kesehatan',
        'bpjs_kesehatan_image',
        'bpjs_ketenagakerjaan',
        'bpjs_ketenagakerjaan_image',
        'npwp',
        'npwp_image',
      ];

      $timestamp = now()->timestamp;
      $types = ['ktp', 'sim', 'assurance', 'bpjs_kesehatan', 'bpjs_ketenagakerjaan', 'npwp'];

      $personUpdatedData = $request->safe()->except($otherTable);
      $personName = $request->name;
      $personID = $person->id;

      if ($request->file("image")) {
        $fileName = "person_image-{$personName}-{$timestamp}.{$request->file("image")->extension()}";
        $imagePath = $request->file("image")->storeAs("person-images", $fileName, 'public');
        $personUpdatedData['image'] = $imagePath;
      }

      DB::beginTransaction();

      $person->update($personUpdatedData);

      foreach ($types as $type) {

        $document = $person->personDocuments->where('type', $type)->first();

        $imagePath = $document->image;

        if ($request->file("{$type}_image")) {
          $fileName = "{$type}-{$personName}-{$timestamp}.{$request->file("{$type}_image")->extension()}";
          $imagePath = $request->file("{$type}_image")->storeAs("{$type}-images", $fileName, 'public');
        }

        if (isset($type["{$type}_expire"])) {
          $active = $type["{$type}_expire"] > now() ? 1 : 0;
        } else {
          $active = 1;
        }

        $document->update([
          'specialID' => $request["{$type}_type_id"] ?? null,
          'number' => $request[$type],
          'address' => $request["{$type}_address"] ?? null,
          'image' => $imagePath,
          'expire' => $request["{$type}_expire"] ?? null,
          'active' => $active,
        ]);
      }

      DB::commit();

      return redirect("/people")->with('success', "Person has been updated!");
    } catch (Exception $e) {
      DB::rollback();
      return redirect("/people/{$personID}/edit")->withInput()->with('error', $e->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Person  $person
   * @return \Illuminate\Http\Response
   */
  public function destroy(Person $person)
  {
    //
  }

  public function exportExcel()
  {
    $timestamp = now()->timestamp;
    return Excel::download(new PersonExport, "people_export_{$timestamp}.xlsx");
  }
}