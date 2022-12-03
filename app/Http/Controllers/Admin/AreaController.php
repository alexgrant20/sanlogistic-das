<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AreaRequest;
use App\Models\Area;
use App\Models\Regional;
use App\Transaction\Constants\NotifactionTypeConstant;
use Illuminate\Http\Request;

class AreaController extends Controller
{
  public function index()
  {
    return view('admin.areas.index', [
      'title' => 'Areas',
      'areas' => Area::with('regional')->orderBy('name')->get(),
    ]);
  }

  public function create()
  {
    return view('admin.areas.create', [
      'title' => 'Create Areas',
      'area' => new Area(),
      'regionals' => Regional::orderBy('name')->get()
    ]);
  }

  public function store(AreaRequest $request)
  {
    Area::create($request->safe()->toArray());

    return to_route('admin.areas.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'area', 'created'));
  }

  public function edit(Area $area)
  {
    return view('admin.areas.edit', [
      'title' => "Update Areas",
      'area' => $area,
      'regionals' => Regional::orderBy('name')->get(),
    ]);
  }

  public function update(AreaRequest $request, Area $area)
  {
    $area->update($request->safe()->toArray());

    return to_route('admin.areas.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'area', 'updated'));
  }

  public function destroy(Area $area)
  {
    $area->delete();

    return to_route('admin.areas.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'area', 'deleted'));
  }
}