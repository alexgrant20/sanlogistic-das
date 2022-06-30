<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\PersonDocument;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
  public function index()
  {
    $sim = PersonDocument::where('person_id', auth()->user()->person_id)
      ->where('type', '=', 'sim')
      ->get(['number', 'expire', 'image'])
      ->first();

    $personImage = auth()->user()->person->image;

    return view('driver.profile.index', [
      'title' => 'Profile',
      'sim' => $sim,
      'personImage' => $personImage
    ]);
  }
}