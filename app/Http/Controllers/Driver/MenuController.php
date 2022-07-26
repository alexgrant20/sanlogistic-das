<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Address;
use App\Models\PersonDocument;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
  public function profile()
  {
    $sim = PersonDocument::where('person_id', auth()->user()->person_id)
      ->where('type', '=', 'sim')
      ->get(['number', 'expire', 'image'])
      ->first();

    $personImage = auth()->user()->person->image;

    return view('driver.menu.profile', [
      'title' => 'Profile',
      'sim' => $sim,
      'personImage' => $personImage
    ]);
  }

  public function location(int $id = null)
  {
    $addresses = Address::all();

    return view('driver.menu.location', [
      'addresses' => $addresses,
      'title' => 'Location',
      'addressData' => $id ? $addresses->find($id) :
        Activity::find(Session::get('activity_id'))->arrivalLocation ?? null,
    ]);
  }

  public function checklist()
  {
    return view('driver.menu.checklist', [
      'title' => 'Checklist',
      'vehicles' => Vehicle::all()
    ]);
  }
}