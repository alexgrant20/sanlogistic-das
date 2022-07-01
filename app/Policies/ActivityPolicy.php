<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Session;

class ActivityPolicy
{
  use HandlesAuthorization;

  public function viewAny(User $user)
  {
    return true;
  }

  public function view(User $user, Activity $activity)
  {
  }

  public function create(User $user)
  {
    # Driver
    if ($user->hasRole('driver')) {
      return !Session::has('activity_id');
    }

    # Default
    return true;
  }

  public function update(User $user, Activity $activity)
  {
    # Driver
    if ($user->hasRole('driver')) {
      return Session::has('activity_id')
        && $activity->user_id === $user->id
        && Session::get('activity_id') === $activity->id;
    }

    # Default
    return true;
  }

  public function delete(User $user, Activity $activity)
  {
    //
  }

  public function restore(User $user, Activity $activity)
  {
    //
  }

  public function forceDelete(User $user, Activity $activity)
  {
    //
  }
}