<?php

namespace App\Http\Controllers;

use App\Exports\ProjectExport;
use App\Models\Company;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Imports\ProjectImport;
use App\Models\Address;
use App\Models\AddressProject;
use App\Models\Person;
use App\Models\Vehicle;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('projects.index', [
      'projects' => Project::with('company')->latest()->get(),
      'title' => 'Projects',
      'importPath' => '/projects/import/excel',
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('projects.create', [
      'customers' => Company::all(),
      'title' => 'Create Project',
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreProjectRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreProjectRequest $request)
  {
    try {
      $validatedData = $request->safe()->all();

      DB::beginTransaction();

      Project::create($validatedData);

      DB::commit();

      return redirect('/projects')->with('success', 'New project has been added!');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect('/projects/create')->withInput()->with('error', $e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Project  $project
   * @return \Illuminate\Http\Response
   */
  public function show(Project $project)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Project  $project
   * @return \Illuminate\Http\Response
   */
  public function edit(Project $project)
  {
    return view('projects.edit', [
      'project' => $project,
      'customers' => Company::all(),
      'title' => "Update Project : {$project->name}"
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateProjectRequest  $request
   * @param  \App\Models\Project  $project
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateProjectRequest $request, Project $project)
  {
    try {

      $validatedData = $request->safe()->all();

      DB::beginTransaction();

      Project::where('id', $project->id)->update($validatedData);

      DB::commit();

      return redirect('/projects')->with('success', 'Project has been updated!');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect("/projects/$project->id")->withInput()->with('error', $e->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Project  $project
   * @return \Illuminate\Http\Response
   */
  public function destroy(Project $project)
  {
    //
  }

  public function importExcel(Request $request)
  {
    try {
      $request->validate([
        'file' => 'required|mimes:csv,xls,xlsx'
      ]);

      $file = $request->file('file')->store('file-import/project/');

      $import = new ProjectImport;
      $import->import($file);

      if ($import->failures()->isNotEmpty()) {
        return back()->with('importErrorList', $import->failures());
      }

      return redirect('/projects')->with('success', 'Import completed!');
    } catch (Exception $e) {
      return redirect('/projects')->with('error', 'Import Failed! ' . $e->getMessage());
    }
  }

  public function exportExcel(Request $request)
  {
    $timestamp = now()->timestamp;
    $params = $request->input('ids');
    $ids = preg_split("/[,]/", $params);
    return Excel::download(new ProjectExport($ids), "projects_export_{$timestamp}.xlsx");
  }

  public function indexAssignVehicle(Project $project)
  {
    // Set cookie for js
    setcookie('project_id', $project->id);
    return view('projects.assign.vehicle', [
      'title' => 'Assign Vehicle',
      'projectName' => $project->name,
      'totalVehicle' => Vehicle::where('project_id', $project->id)->count(),
      'totalAddress' => AddressProject::where('project_id', $project->id)->count(),
      'totalPerson' => Person::where('project_id', $project->id)->count(),
    ]);
  }

  public function indexAssignPerson(Project $project)
  {
    // Set cookie for js
    setcookie('project_id', $project->id);
    return view('projects.assign.person', [
      'title' => 'Assign Person',
      'projectName' => $project->name,
      'totalVehicle' => Vehicle::where('project_id', $project->id)->count(),
      'totalAddress' => AddressProject::where('project_id', $project->id)->count(),
      'totalPerson' => Person::where('project_id', $project->id)->count(),
    ]);
  }

  public function indexAssignAddress(Project $project)
  {
    // Set cookie for js
    setcookie('project_id', $project->id);
    return view('projects.assign.address', [
      'title' => 'Assign Address',
      'projectName' => $project->name,
      'totalVehicle' => Vehicle::where('project_id', $project->id)->count(),
      'totalAddress' => AddressProject::where('project_id', $project->id)->count(),
      'totalPerson' => Person::where('project_id', $project->id)->count(),
    ]);
  }

  public function assignVehicle(Request $request)
  {
    try {
      $data = $request->validate([
        'vehicle_id' => 'required',
        'project_id' => 'required',
        'action' => 'required'
      ]);

      $action = $data['action'];
      $vehicle_id = $data['vehicle_id'];
      $project_id = $data['project_id'];

      if (!$action || !$vehicle_id || !$project_id) {
        throw new Exception('Input Invalid', 500);
      }

      $vehicle = Vehicle::where('id', $vehicle_id);

      if ($action == 'assign') {

        $vehicle->update(['project_id' => $project_id]);

        exit(json_encode(
          array(
            'status' => true,
            'message' => "{$vehicle->first()->license_plate} Assigned!",
            'action' => $action
          )
        ));
      } else {
        $vehicle->update(['project_id' => null]);

        exit(json_encode(
          array(
            'status' => true,
            'message' => "{$vehicle->first()->license_plate} Removed!",
            'action' => $action
          )
        ));
      }
    } catch (Exception $e) {

      echo json_encode(
        array(
          'status' => false,
          'error' => $e->getMessage(),
          'error_code' => $e->getCode(),
          'message' => $e->getMessage(),
        )
      );

      exit;
    }
  }

  public function assignPerson(Request $request)
  {
    try {

      $data = $request->validate([
        'person_id' => 'required',
        'project_id' => 'required',
        'action' => 'required'
      ]);

      $action = $data['action'];
      $person_id = $data['person_id'];
      $project_id = $data['project_id'];

      $person = Person::where('id', $person_id);

      if ($action == 'assign') {

        $person->update(['project_id' => $project_id]);

        exit(json_encode(
          array(
            'status' => true,
            'message' => "{$person->first()->name} Assigned!",
            'action' => $action
          )
        ));
      } else {

        $person->update(['project_id' => null]);

        exit(json_encode(
          array(
            'status' => true,
            'message' => "{$person->first()->name} Removed!",
            'action' => $action
          )
        ));
      }
    } catch (Exception $e) {

      echo json_encode(
        array(
          'status' => false,
          'error' => $e->getMessage(),
          'error_code' => $e->getCode(),
          'message' => 'Failed to send the request!',
        )
      );

      exit;
    }
  }

  public function assignAddress(Request $request)
  {
    try {

      $data = $request->validate([
        'address_id' => 'required',
        'project_id' => 'required',
        'action' => 'required'
      ]);

      $action = $data['action'];
      $address_id = $data['address_id'];
      $project_id = $data['project_id'];

      $addressName = Address::find($address_id)->name;

      if ($action == 'assign') {

        AddressProject::create([
          'address_id' => $address_id,
          'project_id' => $project_id,
        ]);

        exit(json_encode(
          array(
            'status' => true,
            'message' => "{$addressName} Assigned!",
            'action' => $action
          )
        ));
      } else {

        AddressProject::where(['project_id' => $project_id, 'address_id' => $address_id])->delete();

        exit(json_encode(
          array(
            'status' => true,
            'message' => "{$addressName} Removed!",
            'action' => $action
          )
        ));
      }
    } catch (Exception $e) {

      echo json_encode(
        array(
          'status' => false,
          'error' => $e->getMessage(),
          'error_code' => $e->getCode(),
          'message' => 'Failed to send the request!',
        )
      );

      exit;
    }
  }

  public function vehicles()
  {
    if (isset($_GET['keyword'])) {
      $keyword = $_GET['keyword'];
      $project_id = $_GET['projectId'];
      $type = $_GET['type'];

      if ($type == 'notInProject') {
        $result = Vehicle::with('vehiclesDocuments', 'vehiclesLicensePlateColor')
          ->where('license_plate', 'like', "%{$keyword}%")
          ->where('project_id', '!=', $project_id)
          ->orWhere('project_id', null)
          ->orderBy('license_plate')
          ->orderBy('project_id')
          ->get();
      } else {
        $result = Vehicle::with('vehiclesDocuments', 'vehiclesLicensePlateColor')
          ->where('license_plate', 'like', "%{$keyword}%")
          ->where('project_id', $project_id)
          ->orderBy('license_plate')
          ->get();
      }

      if (empty($result)) {
        echo json_encode([]);
      } else {
        echo json_encode($result);
      }
    }
  }

  public function people()
  {
    if (isset($_GET['keyword'])) {
      $keyword = $_GET['keyword'];
      $project_id = $_GET['projectId'];
      $type = $_GET['type'];

      if ($type == 'notInProject') {
        $result = Person::where('name', 'like', "%{$keyword}%")
          ->where('project_id', '!=', $project_id)
          ->orWhere('project_id', null)
          ->orderBy('project_id')
          ->orderBy('name')
          ->get();
      } else {
        $result = Person::where('name', 'like', "%{$keyword}%")
          ->where('project_id', $project_id)
          ->orderBy('name')
          ->get();
      }

      if (empty($result)) {
        echo json_encode([]);
      } else {
        echo json_encode($result);
      }
    }
  }

  public function address()
  {
    if (isset($_GET['keyword'])) {
      $keyword = $_GET['keyword'];
      $project_id = $_GET['projectId'];
      $type = $_GET['type'];

      $addressInProject = AddressProject::where('project_id', $project_id)->get('address_id');

      if ($type == 'notInProject') {
        $result = Address::where('name', 'like', "%{$keyword}%")
          ->whereNotIn('id',  $addressInProject)
          ->orderBy('name')
          ->get();
      } else {
        $result = Address::where('name', 'like', "%{$keyword}%")
          ->whereIn('id', $addressInProject)
          ->orderBy('name')
          ->get();

        foreach ($result as $res) {
          $res->project_id = $project_id;
        }
      }

      if (empty($result)) {
        echo json_encode([]);
      } else {
        echo json_encode($result);
      }
    }
  }
}