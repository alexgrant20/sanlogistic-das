<?php

namespace App\Helpers;

use App\Interface\ActivityStatusInterface;
use App\Interface\CompanyInterface;
use App\Interface\ResponseCodeInterface;
use App\Models\Activity;
use App\Models\IncentiveRate;
use Illuminate\Support\Facades\Auth;

class ActivityHelper implements CompanyInterface, ActivityStatusInterface, ResponseCodeInterface
{
  public $isHalfTrip = false;

  public function getActivityParentId(Activity $currentActivity)
  {
    $relatedActivity = Activity::where([
      ['user_id', Auth::id()],
      ['type', '!=', 'tbd'],
    ])
      ->latest()
      ->first();

    if (
      !in_array(@$relatedActivity->type, ['return', 'manuver']) &&
      @$relatedActivity->parent_activity_id
    ) return $relatedActivity->parent_activity_id;

    return $currentActivity->id;
  }

  public function getTotalDistance($parentActivityId)
  {
    $activities = Activity::where('id', $parentActivityId)
      ->orWhere('parent_activity_id', $parentActivityId)
      ->get();

    $totalDistance = 0;

    $halfTripCriteria = [0, $activities->count() - 1];

    $loop = 0;

    $activities->each(function ($activity) use (&$totalDistance, &$loop, $halfTripCriteria) {

      if (($activity->do_number == "PT" && in_array($loop, $halfTripCriteria)) || $activity->type === "manuver") {
        $this->isHalfTrip = true;
      }

      if (
        !(in_array(@$activity->vehicle->owner_id, [self::BESTINDO, self::SURYA_ANUGERAH]) &&
          $activity->type === "maintenance")
      ) {
        $totalDistance += $activity->arrival_odo - $activity->departure_odo;
      }

      $loop++;
    });

    return $totalDistance;
  }

  public function getIncentiveType($totalDistance)
  {
    if ($this->isHalfTrip) $totalDistance *= 2;

    $maxRange = IncentiveRate::max('range');

    return IncentiveRate::where('range', '>=', $totalDistance)
      ->orWhere('range', $maxRange)
      ->orderBy('incentive', 'asc')
      ->first();
  }

  public function getActivityIncentiveRatePayload($parentActivityId)
  {
    $totalDistance = $this->getTotalDistance($parentActivityId);
    $incentiveType = $this->getIncentiveType($totalDistance);

    $divider = $this->isHalfTrip ? 2 : 1;

    $incentive = $incentiveType->incentive / $divider;
    $incentiveWithDepsoit = $incentiveType->incentive_with_deposit / $divider;

    return [
      'activity_id' => $parentActivityId,
      'total_distance' => $totalDistance,
      'incentive' => $incentive,
      'incentive_with_deposit' => $incentiveWithDepsoit,
      'is_half_trip' => $this->isHalfTrip
    ];
  }
}
