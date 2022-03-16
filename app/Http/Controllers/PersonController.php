<?php

namespace App\Http\Controllers;

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
      'people' => Person::all(),
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
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s')
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

    return view('people.edit', [
      'person' => $person,
      'areas' => Area::all(),
      'departments' => Department::all(),
      'projects' => Project::all(),
      'addresses' => Address::all(),
      'simTypes' => SimType::all(),
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
    //
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
}