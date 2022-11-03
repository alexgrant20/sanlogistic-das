<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ActivityExport;
use App\Http\Requests\Admin\StoreActivityRequest;
use App\Http\Requests\Admin\UpdateActivityRequest;
use App\Models\Activity;
use App\Imports\ActivityImport;
use App\Models\ActivityPayment;
use App\Models\ActivityStatus;
use App\Models\Address;
use App\Models\Project;
use App\Models\User;
use App\Models\Vehicle;
use App\Transaction\Constants\NotifactionTypeConstant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ActivityController extends Controller
{

   public function __construct()
   {
      $this->middleware('can:activity-create', ['only' => ['create', 'store']]);
      $this->middleware('can:activity-edit', ['only' => ['edit', 'update']]);
      $this->middleware('can:activity-view', ['only' => ['index']]);
   }

   public function index(Request $request)
   {
      $q_status = $request->status;

      $activities = DB::table('activities')
         ->leftJoin('activity_statuses', 'activities.activity_status_id', '=', 'activity_statuses.id')
         ->leftJoin('users', 'activities.user_id', '=', 'users.id')
         ->leftJoin('people', 'users.person_id', '=', 'people.id')
         ->leftJoin('vehicles', 'activities.vehicle_id', '=', 'vehicles.id')
         ->leftJoin(DB::raw('addresses dep'), 'activities.departure_location_id', '=', 'dep.id')
         ->leftJoin(DB::raw('addresses arr'), 'activities.arrival_location_id', '=', 'arr.id')
         ->orderByDesc('activities.created_at')
         ->get(
            [
               'activities.id',
               'activities.type',
               'activities.departure_date',
               'people.name AS person_name',
               'vehicles.license_plate',
               'activities.do_number',
               'dep.name AS departure_name',
               'arr.name AS arrival_name',
               'activity_statuses.status AS status'
            ]
         );


      $activities_filtered = empty($q_status) ? $activities : $activities->filter(fn ($item) => $item->status === $q_status);

      return view('admin.activities.index', [
         'title' => 'Activities',
         'activities' => $activities,
         'activities_filtered' => $activities_filtered,
         'importPath' => route('admin.activities.export.excel'),
      ]);
   }

   public function create()
   {
      $users = User::orderBy('username')->whereRelation('roles', 'name', 'driver')->get();

      return view('admin.activities.create', [
         'title' => 'Create Activity',
         'activity' => new Activity(),
         'addresses' => Address::orderBy('name')->get(),
         'vehicles' => Vehicle::orderBy('license_plate')->get(),
         'projects' => Project::orderBy('name')->get(),
         'users' => $users,
      ]);
   }

   public function store(StoreActivityRequest $request)
   {
      $images = collect($request->allFiles());
      $timestamp = now()->timestamp;

      $personName = User::with('person')
         ->find($request->user_id)
         ->person
         ->name;

      $listOfPath = uploadImages($images, $personName, $timestamp);

      $activityPaymentPayload = [
         'bbm_amount' => $request->bbm_amount,
         'toll_amount' => $request->toll_amount,
         'parking_amount' => $request->parking_amount,
         'maintenance_amount' => $request->maintenance_amount,
         'load_amount' => $request->load_amount,
         'unload_amount' => $request->unload_amount,
      ];

      $activityStatusPayload = [
         'status' => $request->status
      ];

      $activityPayload = array_merge(
         $request->safe()->except(
            array_merge(
               $images->keys()->all(),
               array_keys($activityPaymentPayload),
               array_keys($activityStatusPayload)
            )
         ),
         $listOfPath
      );

      DB::beginTransaction();

      try {
         $activity = Activity::create($activityPayload);

         $activityStatus = ActivityStatus::create(
            array_merge(
               ['activity_id' =>  $activity->id],
               $activityStatusPayload
            )
         );

         ActivityPayment::create(
            array_merge(
               ['activity_status_id' => $activityStatus->id],
               $activityPaymentPayload
            )
         );
      } catch (Exception $e) {
         DB::rollback();

         return back()
            ->withInput()
            ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'activity', 'create'));
      }

      DB::commit();

      return to_route('admin.activities.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'activity', 'created'));
   }

   public function edit(Activity $activity)
   {
      $users = User::orderBy('username')->whereRelation('roles', 'name', 'driver')->get();

      return view('admin.activities.edit', [
         'title' => 'Update Activity',
         'activity' => $activity,
         'addresses' => Address::orderBy('name')->get(),
         'vehicles' => Vehicle::orderBy('license_plate')->get(),
         'projects' => Project::orderBy('name')->get(),
         'users' => $users,
      ]);
   }

   public function update(UpdateActivityRequest $request, Activity $activity)
   {
      $images = collect($request->allFiles());
      $timestamp = now()->timestamp;

      $personName = User::with('person')
         ->find($request->user_id)
         ->person
         ->name;

      $listOfPath = uploadImages($images, $personName, $timestamp);

      $activityPaymentPayload = [
         'bbm_amount' => $request->bbm_amount,
         'toll_amount' => $request->toll_amount,
         'parking_amount' => $request->parking_amount,
         'maintenance_amount' => $request->maintenance_amount,
         'load_amount' => $request->load_amount,
         'unload_amount' => $request->unload_amount,
      ];

      $activityStatusPayload = [
         'status' => $request->status
      ];

      $activityPayload = array_merge(
         $request->safe()->except(
            array_merge(
               $images->keys()->all(),
               array_keys($activityPaymentPayload),
               array_keys($activityStatusPayload)
            )
         ),
         $listOfPath
      );

      DB::beginTransaction();

      try {
         $activity->update($activityPayload);

         if ($activity->activityStatus->status !== $request->status) {

            $activityStatus = ActivityStatus::create(
               array_merge(
                  ['activity_id' =>  $activity->id],
                  $activityStatusPayload
               )
            );

            ActivityPayment::create(
               array_merge(
                  ['activity_status_id' => $activityStatus->id],
                  $activityPaymentPayload
               )
            );
         } else {
            $activityPaymentId = $activity->activityStatus->activityPayment->id;
            ActivityPayment::find($activityPaymentId)->update($activityPaymentPayload);
         }
      } catch (Exception $e) {
         DB::rollback();

         dd($e->getMessage());

         return back()
            ->withInput()
            ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'activity', 'update'));
      }
      DB::commit();

      return to_route('admin.activities.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'activity', 'updated'));
   }

   public function importExcel(Request $request)
   {
      $request->validate([
         'file' => 'required|mimes:csv,xls,xlsx'
      ]);
      $import = new ActivityImport;

      try {
         $file = $request->file('file')->store('file-import/activity/');
         $import->import($file);
      } catch (Exception $e) {
         return to_route('admin.activities.index')->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'activity', 'import'));
      }

      if ($import->failures()->isNotEmpty()) {
         return back()->with('importErrorList', $import->failures());
      }

      return to_route('admin.activities.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'activity', 'imported'));
   }

   public function exportExcel(Request $request)
   {
      $request->validate([
         'start_date' => 'required|date',
         'end_date' => 'required|date|after_or_equal:start_date'
      ]);

      $timestamp = now()->timestamp;
      $params = $request->input('ids');
      $ids = preg_split("/[,]/", $params);
      return Excel::download(new ActivityExport($ids, $request->start_date, $request->end_date), "activities_export_{$timestamp}.xlsx");
   }

   public function showLog(Activity $activity)
   {
      $activityStatus = DB::table('activity_statuses')
         ->leftJoin('users', 'activity_statuses.created_by', '=', 'users.id')
         ->leftJoin('people', 'users.person_id', '=', 'people.id')
         ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
         ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
         ->where('activity_id', $activity->id)
         ->get(['status', 'people.name', 'activity_statuses.created_at', 'roles.name AS role']);

      return to_route('admin.activities.index')->with('log_data', $activityStatus);
   }
}