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
use App\Http\Requests\Admin\StorePersonRequest;
use App\Http\Requests\Admin\UpdatePersonRequest;
use App\Imports\PersonImport;
use App\Models\City;
use App\Models\PersonDocument;
use App\Transaction\Constants\NotifactionTypeConstant;
use App\Transaction\Constants\PersonDTConstant;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PersonController extends Controller
{
  public function index()
  {
    $people = Person::with('department', 'project', 'user')->latest()->get();

    return view('admin.people.index', [
      'people' => $people,
      'title' => 'People',
      'importPath' => '/admin/people/import/excel',
    ]);
  }

  public function create()
  {
    return view('admin.people.create', [
      'person' => new Person(),
      'areas' => Area::orderBy('name')->get(),
      'departments' => Department::orderBy('name')->get(),
      'projects' => Project::orderBy('name')->get(),
      'cities' => City::orderBy('name')->get(),
      'simTypes' => SimType::orderBy('name')->get(),
      'title' => 'Create Person',
    ]);
  }

  public function store(StorePersonRequest $request)
  {
    $timestamp = now()->timestamp;
    $personData = $request->safe()->except(PersonDTConstant::DOCUMENT_TYPE_INPUT);
    $personData['image'] = $request->hasFile('image')
      ? uploadImage($request->file('image'), 'person_image', $request->name, $timestamp)
      : null;
    $documentQuery = [];

    DB::beginTransaction();

    try {
      $person = Person::create($personData);
      $personName = str_replace(' ', '', $person['name']);

      foreach (PersonDTConstant::DOCUMENT_TYPE as $docType) {
        $imageKey = "{$docType}_image";
        $imagePath = $request->hasFile($imageKey)
          ? uploadImage($request->file($imageKey), $docType, $personName, $timestamp)
          : null;

        $expireKey = "{$docType}_expire";
        $active = $request->has($expireKey) && ($request->get($expireKey) > now()) ? 1 : 0;

        array_push($documentQuery, [
          'person_id' => $person->id,
          'type' => $docType,
          'specialID' => $request->get("{$docType}_type_id") ?? null,
          'number' => $request->get($docType),
          'address' => $request->get("{$docType}_address") ?? null,
          'image' => $imagePath,
          'expire' => $request->get($expireKey) ?? null,
          'active' => $active,
        ]);
      }

      PersonDocument::insert($documentQuery);
    } catch (Exception $e) {
      DB::rollback();

      return to_route('admin.person.create')->withInput()
        ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'person', 'create'));
    }
    DB::commit();

    return to_route('admin.person.index')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'person', 'created'));
  }

  public function edit(Person $person)
  {
    $personDocuments = PersonDocument::where('person_id', $person->id)->get();

    $ktp = $personDocuments->filter(fn ($item) => $item->type === 'ktp')->first();
    $sim = $personDocuments->filter(fn ($item) => $item->type === 'sim')->first();
    $assurance = $personDocuments->filter(fn ($item) => $item->type === 'assurance')->first();
    $bpjs_kesehatan = $personDocuments->filter(fn ($item) => $item->type === 'bpjs_kesehatan')->first();
    $bpjs_ketenagakerjaan = $personDocuments->filter(fn ($item) => $item->type === 'bpjs_ketenagakerjaan')->first();
    $npwp = $personDocuments->filter(fn ($item) => $item->type === 'npwp')->first();

    return view('admin.people.edit', [
      'person' => $person,
      'areas' => Area::orderBy('name')->get(),
      'departments' => Department::orderBy('name')->get(),
      'projects' => Project::orderBy('name')->get(),
      'cities' => City::orderBy('name')->get(),
      'simTypes' => SimType::orderBy('name')->get(),
      'ktp' => $ktp,
      'sim' => $sim,
      'assurance' => $assurance,
      'bpjs_kesehatan' => $bpjs_kesehatan,
      'bpjs_ketenagakerjaan' => $bpjs_ketenagakerjaan,
      'npwp' => $npwp,
      'title' => "Update Person : {$person->name}"
    ]);
  }

  public function update(UpdatePersonRequest $request, Person $person)
  {
    $timestamp = now()->timestamp;
    $personPayload = $request->safe()->except(PersonDTConstant::DOCUMENT_TYPE_INPUT);
    $personPayload['image'] = $request->hasFile('image')
      ? uploadImage($request->file('image'), 'person_image', $request->name, $timestamp)
      : $person->image;
    $personDocuments = collect(PersonDocument::where('person_id', $person->id)->get());

    DB::beginTransaction();

    try {
      $person->update($personPayload);

      foreach (PersonDTConstant::DOCUMENT_TYPE as $docType) {
        $doc = $personDocuments->firstWhere('type', $docType);

        $imageKey = "{$docType}_image";

        $imagePath = $request->hasFile($imageKey)
          ? uploadImage($request->file($imageKey), $docType, $request->name, $timestamp)
          : $doc->image ?? null;

        $expireKey = "{$docType}_expire";
        $active = $request->has($expireKey) && ($request->get($expireKey) > now()) ? 1 : 0;

        PersonDocument::updateOrCreate(
          [
            'id' => $doc->id ?? null,
          ],
          [
            'person_id' => $person->id,
            'type' => $docType,
            'specialID' => $request->get("{$docType}_type_id") ?? null,
            'number' => $request->get($docType),
            'address' => $request->get("{$docType}_address") ?? null,
            'image' => $imagePath,
            'expire' => $request->get("{$docType}_expire") ?? null,
            'active' => $active,
          ]
        );
      }
    } catch (Exception $e) {
      DB::rollback();

      return to_route('admin.person.edit', $person->id)->withInput()
        ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'person', 'update'));
    }

    DB::commit();

    return to_route('admin.person.index')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'person', 'updated'));
  }

  public function importExcel(Request $request)
  {
    $request->validate([
      'file' => 'required|mimes:csv,xls,xlsx'
    ]);
    $import = new PersonImport;

    try {
      $file = $request->file('file')->store('file-import/person/');
      $import->import($file);

      if ($import->failures()->isNotEmpty()) {
        return back()->with('importErrorList', $import->failures());
      }
    } catch (Exception $e) {
      return to_route('admin.person.index')
        ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'person', 'import'));
    }

    return to_route('admin.person.index')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'person', 'imported'));
  }

  public function exportExcel(Request $request)
  {
    $timestamp = now()->timestamp;
    $params = $request->input('ids');
    $ids = preg_split("/[,]/", $params);
    return Excel::download(new PersonExport($ids), "people_export_{$timestamp}.xlsx");
  }
}