<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Address;
use App\Models\PersonDocument;
use App\Models\Vehicle;
use App\Models\VehicleChecklist;
use App\Models\VehicleChecklistImage;
use App\Models\VehicleLastStatus;
use App\Transaction\Constants\NotifactionTypeConstant;
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

  public function getChecklistLastStatus(int $vehicleId)
  {
    $data = VehicleLastStatus::where(['vehicle_id' => $vehicleId])->first();
    return response()->json($data);
  }

  public function checklistStore(Request $request)
  {
    $timestamp = now()->timestamp;

    $basicData = $request->validate([
      'vehicle_id' => 'required|integer',
      'lamp_notes' => 'nullable|string',
      'glass_notes' => 'nullable|string',
      'tire_notes' => 'nullable|string',
      'equipment_notes' => 'nullable|string',
      'gear_notes' => 'nullable|string',
      'other_notes' => 'nullable|string',
    ]);

    $imageData = $request->validate([
      'image_1' => 'nullable|image|mimes:png,jpg,jpeg',
      'image_2' => 'nullable|image|mimes:png,jpg,jpeg',
      'image_3' => 'nullable|image|mimes:png,jpg,jpeg',
      'image_4' => 'nullable|image|mimes:png,jpg,jpeg',
      'image_1_description' => 'required_with:image_1|string',
      'image_2_description' => 'required_with:image_2|string',
      'image_3_description' => 'required_with:image_3|string',
      'image_4_description' => 'required_with:image_4|string',
    ]);

    $vehicle = Vehicle::find($request->vehicle_id);

    $checklistData = [
      'lampu_besar' => intval($request->lampu_besar ?? 1),
      'lampu_kota' => intval($request->lampu_kota ?? 1),
      'lampu_rem' => intval($request->lampu_rem ?? 1),
      'lampu_sein' => intval($request->lampu_sein ?? 1),
      'lampu_mundur' => intval($request->lampu_mundur ?? 1),
      'lampu_kabin' => intval($request->lampu_kabin ?? 1),
      'lampu_senter' => intval($request->lampu_senter ?? 1),
      'kaca_depan' => intval($request->kaca_depan ?? 1),
      'kaca_samping' => intval($request->kaca_samping ?? 1),
      'kaca_belakang' => intval($request->kaca_belakang ?? 1),
      'ban_depan' => intval($request->ban_depan ?? 1),
      'ban_belakang_dalam' => intval($request->ban_belakang_dalam ?? 1),
      'ban_belakang_luar' => intval($request->ban_belakang_luar ?? 1),
      'ban_serep' => intval($request->ban_serep ?? 1),
      'tekanan_angin_ban_depan' => intval($request->tekanan_angin_ban_depan ?? 1),
      'tekanan_angin_ban_belakang_dalam' => intval($request->tekanan_angin_ban_belakang_dalam ?? 1),
      'tekanan_angin_ban_belakang_luar' => intval($request->tekanan_angin_ban_belakang_luar ?? 1),
      'tekanan_angin_ban_serep' => intval($request->tekanan_angin_ban_serep ?? 1),
      'velg_ban_depan' => intval($request->velg_ban_depan ?? 1),
      'velg_ban_belakang_dalam' => intval($request->velg_ban_belakang_dalam ?? 1),
      'velg_ban_belakang_luar' => intval($request->velg_ban_belakang_luar ?? 1),
      'velg_ban_serep' => intval($request->velg_ban_serep ?? 1),
      'ganjal_ban' => intval($request->ganjal_ban ?? 1),
      'dongkrak' => intval($request->dongkrak ?? 1),
      'kunci_roda' => intval($request->kunci_roda ?? 1),
      'stang_kunci_roda' => intval($request->stang_kunci_roda ?? 1),
      'pipa_bantu' => intval($request->pipa_bantu ?? 1),
      'kotak_p3k' => intval($request->kotak_p3k ?? 1),
      'apar' => intval($request->apar ?? 1),
      'emergency_triangle' => intval($request->emergency_triangle ?? 1),
      'tool_kit' => intval($request->tool_kit ?? 1),
      'seragam' => intval($request->seragam ?? 1),
      'safety_shoes' => intval($request->safety_shoes ?? 1),
      'driver_license' => intval($request->driver_license ?? 1),
      'kartu_keur' => intval($request->kartu_keur ?? 1),
      'stnk' => intval($request->stnk ?? 1),
      'helmet' => intval($request->helmet ?? 1),
      'tatakan_menulis' => intval($request->tatakan_menulis ?? 1),
      'ballpoint' => intval($request->ballpoint ?? 1),
      'straples' => intval($request->straples ?? 1),
      'exhaust_brake' => intval($request->exhaust_brake ?? 1),
      'spion' => intval($request->spion ?? 1),
      'wiper' => intval($request->wiper ?? 1),
      'tangki_bahan_bakar' => intval($request->tangki_bahan_bakar ?? 1),
      'tutup_tangki_bahan_bakar' => intval($request->tutup_tangki_bahan_bakar ?? 1),
      'tutup_radiator' => intval($request->tutup_radiator ?? 1),
      'accu' => intval($request->accu ?? 1),
      'oli_mesin' => intval($request->oli_mesin ?? 1),
      'minyak_rem' => intval($request->minyak_rem ?? 1),
      'minyak_kopling' => intval($request->minyak_kopling ?? 1),
      'oli_hidraulic' => intval($request->oli_hidraulic ?? 1),
      'klakson' => intval($request->klakson ?? 1),
      'panel_speedometer' => intval($request->panel_speedometer ?? 1),
      'panel_bahan_bakar' => intval($request->panel_bahan_bakar ?? 1),
      'sunvisor' => intval($request->sunvisor ?? 1),
      'jok' => intval($request->jok ?? 1),
      'air_conditioner' => intval($request->air_conditioner ?? 1),
      'address_id' => intval($vehicle->address_id),
      'odo' => intval($vehicle->odo),
      'user_id' => auth()->user()->id,
    ];

    $payload = array_merge($basicData, $checklistData);

    $vehicleChecklist = VehicleChecklist::create($payload);

    VehicleLastStatus::updateOrCreate(
      ['vehicle_id' => $request->vehicle_id],
      [
        'lampu_besar' => $checklistData['lampu_besar'],
        'lampu_kota' => $checklistData['lampu_kota'],
        'lampu_rem' => $checklistData['lampu_rem'],
        'lampu_sein' => $checklistData['lampu_sein'],
        'lampu_mundur' => $checklistData['lampu_mundur'],
        'lampu_kabin' => $checklistData['lampu_kabin'],
        'lampu_senter' => $checklistData['lampu_senter'],
        'kaca_depan' => $checklistData['kaca_depan'],
        'kaca_samping' => $checklistData['kaca_samping'],
        'kaca_belakang' => $checklistData['kaca_belakang'],
        'ban_depan' => $checklistData['ban_depan'],
        'ban_belakang_dalam' => $checklistData['ban_belakang_dalam'],
        'ban_belakang_luar' => $checklistData['ban_belakang_luar'],
        'ban_serep' => $checklistData['ban_serep'],
        'tekanan_angin_ban_depan' => $checklistData['tekanan_angin_ban_depan'],
        'tekanan_angin_ban_belakang_dalam' => $checklistData['tekanan_angin_ban_belakang_dalam'],
        'tekanan_angin_ban_belakang_luar' => $checklistData['tekanan_angin_ban_belakang_luar'],
        'tekanan_angin_ban_serep' => $checklistData['tekanan_angin_ban_serep'],
        'velg_ban_depan' => $checklistData['velg_ban_depan'],
        'velg_ban_belakang_dalam' => $checklistData['velg_ban_belakang_dalam'],
        'velg_ban_belakang_luar' => $checklistData['velg_ban_belakang_luar'],
        'velg_ban_serep' => $checklistData['velg_ban_serep'],
        'ganjal_ban' => $checklistData['ganjal_ban'],
        'dongkrak' => $checklistData['dongkrak'],
        'kunci_roda' => $checklistData['kunci_roda'],
        'stang_kunci_roda' => $checklistData['stang_kunci_roda'],
        'pipa_bantu' => $checklistData['pipa_bantu'],
        'kotak_p3k' => $checklistData['kotak_p3k'],
        'apar' => $checklistData['apar'],
        'emergency_triangle' => $checklistData['emergency_triangle'],
        'tool_kit' => $checklistData['tool_kit'],
        'seragam' => $checklistData['seragam'],
        'safety_shoes' => $checklistData['safety_shoes'],
        'driver_license' => $checklistData['driver_license'],
        'kartu_keur' => $checklistData['kartu_keur'],
        'stnk' => $checklistData['stnk'],
        'helmet' => $checklistData['helmet'],
        'tatakan_menulis' => $checklistData['tatakan_menulis'],
        'ballpoint' => $checklistData['ballpoint'],
        'straples' => $checklistData['straples'],
        'exhaust_brake' => $checklistData['exhaust_brake'],
        'spion' => $checklistData['spion'],
        'wiper' => $checklistData['wiper'],
        'tangki_bahan_bakar' => $checklistData['tangki_bahan_bakar'],
        'tutup_tangki_bahan_bakar' => $checklistData['tutup_tangki_bahan_bakar'],
        'tutup_radiator' => $checklistData['tutup_radiator'],
        'accu' => $checklistData['accu'],
        'oli_mesin' => $checklistData['oli_mesin'],
        'minyak_rem' => $checklistData['minyak_rem'],
        'minyak_kopling' => $checklistData['minyak_kopling'],
        'oli_hidraulic' => $checklistData['oli_hidraulic'],
        'klakson' => $checklistData['klakson'],
        'panel_speedometer' => $checklistData['panel_speedometer'],
        'panel_bahan_bakar' => $checklistData['panel_bahan_bakar'],
        'sunvisor' => $checklistData['sunvisor'],
        'jok' => $checklistData['jok'],
        'air_conditioner' => $checklistData['air_conditioner'],
        'address_id' => intval($vehicle->address_id),
        'odo' => intval($vehicle->odo),
      ]
    );

    for ($i = 1; $i <= 4; $i++) {
      if (!array_key_exists("image_$i", $imageData)) break;
      $vehicleChecklistImage = new VehicleChecklistImage();
      $vehicleChecklistImage->image = uploadImage($imageData["image_$i"], 'checklist', auth()->user()->person->name, $timestamp);
      $vehicleChecklistImage->description = $imageData["image_" . $i . "_description"];
      $vehicleChecklistImage->vehicle_checklist_id = $vehicleChecklist->id;
      $vehicleChecklistImage->save();
    }

    return to_route('index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'checlist', 'created'));
  }
}