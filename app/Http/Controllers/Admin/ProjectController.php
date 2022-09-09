<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ProjectExport;
use App\Models\Company;
use App\Models\Project;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Imports\ProjectImport;
use App\Models\Address;
use App\Models\AddressProject;
use App\Models\Person;
use App\Models\Vehicle;
use App\Transaction\Constants\NotifactionTypeConstant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
  public function __construct()
  {
    $this->middleware('can:create-project', ['only' => ['create', 'store']]);
    $this->middleware('can:edit-project', ['only' => ['edit', 'update']]);
    $this->middleware('can:view-project', ['only' => ['index']]);
  }

  public function index()
  {
    return view('admin.projects.index', [
      'projects' => Project::with('company')->latest()->get(),
      'title' => 'Projects',
      'importPath' => '/admin/projects/import/excel',
    ]);
  }

  public function create()
  {
    return view('admin.projects.create', [
      'customers' => Company::latest()->get(),
      'title' => 'Create Project',
    ]);
  }

  public function store(StoreProjectRequest $request)
  {
    Project::create($request->safe()->toArray());

    return to_route('admin.projects.index')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'project', 'created'));
  }

  public function edit(Project $project)
  {
    return view('admin.projects.edit', [
      'project' => $project,
      'customers' => Company::orderBy('name')->get(),
      'title' => "Update Project : {$project->name}"
    ]);
  }

  public function update(UpdateProjectRequest $request, Project $project)
  {
    $project->update($request->safe()->toArray());

    return to_route('admin.projects.index')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'project', 'updated'));
  }

  public function importExcel(Request $request)
  {
    $request->validate([
      'file' => 'required|mimes:csv,xls,xlsx'
    ]);
    $import = new ProjectImport;

    try {
      $file = $request->file('file')->store('file-import/project/');

      $import->import($file);
    } catch (Exception $e) {
      return to_route('admin.projects.index')
        ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'project', 'import'));
    }

    if ($import->failures()->isNotEmpty()) {
      return back()->with('importErrorList', $import->failures());
    }

    return to_route('admin.projects.index')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'project', 'imported'));
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
    return view('admin.projects.assign.vehicle', [
      'title' => 'Assign Vehicle',
      'project' => $project,
      'projects' => Project::orderBy('name')->get(),
      'totalVehicle' => Vehicle::where('project_id', $project->id)->count(),
      'totalAddress' => AddressProject::where('project_id', $project->id)->count(),
      'totalPerson' => Person::where('project_id', $project->id)->count(),
    ]);
  }

  public function indexAssignPerson(Project $project)
  {
    // Set cookie for js
    setcookie('project_id', $project->id);
    return view('admin.projects.assign.person', [
      'title' => 'Assign Person',
      'project' => $project,
      'projects' => Project::orderBy('name')->get(),
      'totalVehicle' => Vehicle::where('project_id', $project->id)->count(),
      'totalAddress' => AddressProject::where('project_id', $project->id)->count(),
      'totalPerson' => Person::where('project_id', $project->id)->count(),
    ]);
  }

  public function indexAssignAddress(Project $project)
  {
    // Set cookie for js
    setcookie('project_id', $project->id);
    return view('admin.projects.assign.address', [
      'title' => 'Assign Address',
      'project' => $project,
      'projects' => Project::orderBy('name')->get(),
      'totalVehicle' => Vehicle::where('project_id', $project->id)->count(),
      'totalAddress' => AddressProject::where('project_id', $project->id)->count(),
      'totalPerson' => Person::where('project_id', $project->id)->count(),
    ]);
  }

  public function assignVehicle(Request $request)
  {
    $request->validate([
      'vehicle_id' => 'required',
      'project_id' => 'required',
      'action' => 'required'
    ]);

    $action = $request->action;
    $vehicle = Vehicle::find($request->vehicle_id);
    $actionMsg = $action == 'assign' ? 'Assigned' : 'Removed';

    try {
      $vehicle->update(['project_id' => $action == 'assign' ?  $request->project_id : null]);

      exit(json_encode(
        array(
          'status' => true,
          'message' => "{$vehicle->license_plate} {$actionMsg}!",
          'action' => $action
        )
      ));
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
    $request->validate([
      'person_id' => 'required',
      'project_id' => 'required',
      'action' => 'required'
    ]);

    $action = $request->action;
    $person = Person::find($request->person_id);
    $actionMsg = $action == 'assign' ? 'Assigned' : 'Removed';

    try {
      $person->update(['project_id' =>  $action == 'assign' ? $request->project_id : null]);

      exit(json_encode(
        array(
          'status' => true,
          'message' => "{$person->name} {$actionMsg}!",
          'action' => $action
        )
      ));
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
    $request->validate([
      'address_id' => 'required',
      'project_id' => 'required',
      'action' => 'required'
    ]);

    $action = $request->action;
    $address_id = $request->address_id;
    $project_id = $request->project_id;

    try {
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