<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

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
use App\Imports\PersonImport;
use App\Models\City;
use App\Models\PersonDocument;
use Exception;
use Illuminate\Http\Request;
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
    return view('admin.people.index', [
      'people' => Person::with('department', 'project', 'user')->latest()->get(),
      'title' => 'People',
      'importPath' => '/admin/people/import/excel',
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.people.create', [
      'areas' => Area::all(),
      'departments' => Department::all(),
      'projects' => Project::all(),
      'cities' => City::all(),
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

      $notification = array(
        'message' => 'Person successfully created!',
        'alert-type' => 'success',
      );

      return to_route('admin.person.index')->with($notification);
    } catch (Exception $e) {
      DB::rollback();

      $notification = array(
        'message' => 'Person failed to create!',
        'alert-type' => 'error',
      );

      return to_route('admin.person.create')->withInput()->with($notification);
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

    return view('admin.people.edit', [
      'person' => $person,
      'areas' => Area::all(),
      'departments' => Department::all(),
      'projects' => Project::all(),
      'cities' => City::all(),
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

        $imagePath = $document->image ?? null;

        if ($request->file("{$type}_image")) {
          $fileName = "{$type}-{$personName}-{$timestamp}.{$request->file("{$type}_image")->extension()}";
          $imagePath = $request->file("{$type}_image")->storeAs("{$type}-images", $fileName, 'public');
        }

        if (isset($type["{$type}_expire"])) {
          $active = $type["{$type}_expire"] > now() ? 1 : 0;
        } else {
          $active = 1;
        }

        PersonDocument::updateOrCreate(
          [
            'id' => $document->id ?? null,
          ],
          [
            'person_id' => $personID,
            'type' => $type,
            'specialID' => $request["{$type}_type_id"] ?? null,
            'number' => $request[$type],
            'address' => $request["{$type}_address"] ?? null,
            'image' => $imagePath,
            'expire' => $request["{$type}_expire"] ?? null,
            'active' => $active,
          ]
        );
      }

      DB::commit();

      $notification = array(
        'message' => 'Person successfully updated!',
        'alert-type' => 'success',
      );

      return to_route('admin.person.index')->with($notification);
    } catch (Exception $e) {
      DB::rollback();

      $notification = array(
        'message' => 'Person failed to update! Error:' . $e->getMessage(),
        'alert-type' => 'error',
      );

      return redirect("/admin/people/{$personID}/edit")->withInput()->with($notification);
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

  public function importExcel(Request $request)
  {
    try {
      $request->validate([
        'file' => 'required|mimes:csv,xls,xlsx'
      ]);

      $file = $request->file('file')->store('file-import/person/');

      $import = new PersonImport;
      $import->import($file);

      if ($import->failures()->isNotEmpty()) {
        return back()->with('importErrorList', $import->failures());
      }

      $notification = array(
        'message' => 'Person successfully imported!',
        'alert-type' => 'success',
      );

      return to_route('admin.person.index')->with($notification);
    } catch (Exception $e) {

      $notification = array(
        'message' => 'Person failed to import!',
        'alert-type' => 'error',
      );

      return to_route('admin.person.index')->with($notification);
    }
  }

  public function exportExcel(Request $request)
  {
    $timestamp = now()->timestamp;
    $params = $request->input('ids');
    $ids = preg_split("/[,]/", $params);
    return Excel::download(new PersonExport($ids), "people_export_{$timestamp}.xlsx");
  }
}