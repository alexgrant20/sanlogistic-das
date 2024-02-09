<?php

namespace App\Exports;

use App\Models\Activity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityExport implements FromCollection, WithHeadings, ShouldAutoSize
{
  private $startDate;
  private $endDate;
  private $useIncentive;

  public function __construct($startDate, $endDate, $useIncentive = false)
  {
    $this->startDate = $startDate;
    $this->endDate = $endDate;
    $this->useIncentive = $useIncentive;
  }

  public function collection()
  {
    $activities = DB::table('activities')
      ->selectRaw(
        "activities.do_number AS do_number,
        DAY(do_date) AS do_date,
        MONTHNAME(do_date) AS do_month,
        dep.name AS departure_address,
        DAY(departure_date) AS dep_date,
        MONTHNAME(departure_date) AS dep_month,
        TIME_FORMAT(departure_date,'%H:%i') AS dep_time,
        activities.departure_odo As dep_odo,
        arr.name AS arrival_address,
        DAY(arrival_date) AS arr_date,
        MONTHNAME(arrival_date) AS arr_month,
        TIME_FORMAT(arrival_date,'%H:%i') AS arr_time,
        activities.arrival_odo AS arr_odo,
        vehicles.license_plate AS license_plate,
        people.name AS person_name,
        companies.name AS comp_name,
        '' AS FREIGHT,
        '' AS PRODUCT,
        '' AS QUANTITY,
        '' AS FREIGHT_RETURNED,
        '' AS FREIGHT_LOST,
        '' AS VOLUMEPENGISIAN,
        activities.type AS act_type,
        '' AS DELIVERY_REMARKS_I,
        '' AS DELIVERY_REMARKS_II,
        '' AS Fuel_Note,
        activity_payments.bbm_amount AS bbm,
        activity_payments.toll_amount AS toll,
        activity_payments.parking_amount AS parking,
        activity_payments.maintenance_amount AS MAINTENANCE,
        activity_payments.load_amount AS LOADING_EXPENSES,
        activity_payments.unload_amount  AS UNLOADING_EXPENSES,
        '' AS Transport,
        '' AS retribution,
        '' AS IFRETRIBUTION_EXPENSES,
        '' AS ZONE,
        '' AS DCODE,
        arrival_odo - departure_odo AS DISTANCE,
        activity_payments.bbm_amount + activity_payments.toll_amount
   + activity_payments.parking_amount + activity_payments.load_amount + activity_payments.unload_amount + activity_payments.maintenance_amount AS total_cost,
        projects.name AS projects_name,
        departure_date AS dep_datetime,
        areas.name,
        TIMEDIFF(arrival_date, departure_date) AS duration,
        CONCAT(ROUND((arrival_odo - departure_odo) / (TIMESTAMPDIFF(SECOND, departure_date, arrival_date) / 3600)), ' Km/Jam') AS average_speed,
        activities.id,
        activities.parent_activity_id,
        ai.total_distance,
        CASE WHEN ai.is_half_trip = 1 THEN 'half'
        WHEN ai.is_half_trip = 0 THEN 'full' END,"
        . ($this->useIncentive ? 'incentive,incentive_with_deposit,' : '').
        "
        nik,
        CASE
         WHEN activity_statuses.status = 'paid' THEN activity_statuses.created_at
         ELSE ''
        END AS activity_paid_date
        "
      )
      ->leftJoin('activity_statuses', 'activities.activity_status_id', 'activity_statuses.id')
      ->leftJoin('users', 'activities.user_id', 'users.id')
      ->leftJoin('people', 'users.person_id', 'people.id')
      ->leftJoin('areas', 'people.area_id', 'areas.id')
      ->leftJoin('vehicles', 'activities.vehicle_id', 'vehicles.id')
      ->leftJoin(DB::raw('addresses dep'), 'activities.departure_location_id', 'dep.id')
      ->leftJoin(DB::raw('addresses arr'), 'activities.arrival_location_id', 'arr.id')
      ->leftJoin('projects', 'activities.project_id', 'projects.id')
      ->leftJoin('companies', 'projects.company_id', 'companies.id')
      ->leftJoin('activity_payments', 'activity_payments.activity_status_id', 'activity_statuses.id')
      ->leftJoin('activity_incentives AS ai', 'ai.activity_id', 'activities.id')
      ->whereBetween('departure_date', [date($this->startDate), date($this->endDate)])
      ->where('activity_statuses.status', '!=', 'draft')
      ->orderBy('activities.created_at')
      ->get();

    return $activities;
  }

  public function headings(): array
  {
    $headers =
    "NO DO,
    DODATE,
    DOMONTH,
    ORIGIN,
    DDATE,
    DMONTH,
    DTIME,
    DODOMETER,
    DESTINATION,
    ADATE,
    AMONTH,
    ATIME,
    AODOMETER,
    VEHICLE REG,
    DRIVER,
    CUSTOMER,
    FREIGHT,
    PRODUCT NAME,
    QUANTITY,
    FREIGHT RETURNED,
    FREIGHT LOST,
    VOLUMEPENGISIAN,
    DELIVERY CATEGORY,
    DELIVERY REMARKS I,
    DELIVERY REMARKS II,
    Fuel Note,
    FUEL EXPENSES,
    TOLL ROAD EXPENSES,
    PARKING EXPENSES,
    MAINTENANCE,
    LOADING EXPENSES,
    UNLOADING EXPENSES,
    Transport,
    FRETRIBUTION EXPENSES,
    IFRETRIBUTION EXPENSES,
    ZONE,
    DCODE,
    DISTANCE,
    TOTAL COST,
    PROJECT,
    DDateTime,
    AREA,
    DURATION,
    AVGSPEED,
    ACTIVITY ID,
    PARENT ACTIVITY ID,
    DISTANCE,
    TRIP,"
    . ($this->useIncentive ? 'INCENNTIVE, INCENNTIVE WITH RATE,' : '').
    "NIK,
    PAID DATE";

    return explode(",", str_replace(array("\r", "\n", "  "), '', $headers));
  }
}
