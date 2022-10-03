<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleChecklist;
use App\Models\VehicleChecklistImage;
use App\Models\VehicleLastStatus;
use App\Transaction\Constants\NotifactionTypeConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChecklistController extends Controller
{

  public function index()
  {
    $lampLabel = ['lampu_besar', 'lampu_kota', 'lampu_rem', 'lampu_sein', 'lampu_mundur', 'lampu_kabin'];
    $oilLabel = ['oli_mesin', 'minyak_rem', 'minyak_kopling', 'oli_hidraulic', 'exhaust_brake'];
    $tireLabel = ['ban_depan', 'ban_belakang_dalam', 'ban_belakang_luar', 'ban_serep'];
    $velgLabel = ['velg_ban_depan', 'velg_ban_belakang_dalam', 'velg_ban_belakang_luar', 'velg_ban_serep'];
    $tirePreasureLabel = ['tekanan_angin_ban_depan', 'tekanan_angin_ban_belakang_dalam', 'tekanan_angin_ban_belakang_luar', 'tekanan_angin_ban_serep'];
    $glassLabel = ['kaca_depan', 'kaca_belakang', 'kaca_samping'];
    $otherOutsideLabel = ['accu', 'tutup_radiator', 'tangki_bahan_bakar', 'tutup_tangki_bahan_bakar'];
    $otherInsideLabel = ['spion', 'wiper', 'klakson', 'panel_speedometer', 'panel_bahan_bakar', 'sunvisor', 'jok'];

    $totalElement = count($lampLabel) + count($oilLabel) + count($tireLabel) + count($velgLabel) + count($tirePreasureLabel) + count($glassLabel) + count($otherOutsideLabel) + count($otherInsideLabel);

    $lampLabel = implode('+', $lampLabel);
    $oilLabel = implode('+', $oilLabel);
    $tireLabel = implode('+', $tireLabel);
    $velgLabel = implode('+', $velgLabel);
    $tirePreasureLabel = implode('+', $tirePreasureLabel);
    $glassLabel = implode('+', $glassLabel);
    $otherOutsideLabel = implode('+', $otherOutsideLabel);
    $otherInsideLabel = implode('+', $otherInsideLabel);

    $user = auth()->user();

    $checklists = DB::table('vehicle_checklists')
      ->join('vehicles', 'vehicle_checklists.vehicle_id', 'vehicles.id')
      ->orderBy('vehicle_checklists.created_at', 'desc')
      ->when($user->hasRole('driver'), function ($q) use ($user) {
        return $q->where('user_id', $user->id);
      })
      ->get([
        'vehicles.license_plate',
        'vehicle_checklists.created_at',
        DB::raw("({$totalElement} - SUM({$lampLabel} + {$oilLabel} + {$tireLabel} + {$velgLabel} + {$tirePreasureLabel} + {$glassLabel} + {$otherOutsideLabel} + {$otherInsideLabel}))/ {$totalElement} * 100 AS percentage"),
        'vehicle_checklists.id'
      ]);

    return view('driver.checklists.index', [
      'title' => 'Checklist',
      'checlists' => $checklists
    ]);
  }

  public function create()
  {
    $isDriver = auth()->user()->hasRole('driver');

    $vehicles = Vehicle::when($isDriver, function ($query) {
      $query->where('project_id', auth()->user()->person->project_id);
    })->orderBy('license_plate')->get();

    return view('driver.checklists.create', [
      'title' => 'Checklist',
      'vehicles' => $vehicles
    ]);
  }

  public function store(Request $request)
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
      'image_1_description' => 'nullable|string',
      'image_2_description' => 'nullable|string',
      'image_3_description' => 'nullable|string',
      'image_4_description' => 'nullable|string',
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

    if (auth()->user()->hasRole('mechanic')) {
      if ($request->periodic_maintenance == 1) {
        $vehicle->update([
          'maintenance_odo' => $vehicle->odo + 10000,
          'maintenance_date' => now()->addDays(180),
        ]);
      }
    }

    // 1 --> false
    // 0 --> true
    // when lamp is false than it's give no value

    // ketika tidak tersedia (rusak) maka beri value 1
    // namun ketika benar maka beri value sebelumnya
    // 'lampu_besar' => !isset($request->lampu_besar) ? 1 : DB::raw('lampu_besar')

    // ketika tidak tersedia (rusak) maka beri value SEBELUMNYA
    // namun ketika benar maka beri value 0
    // 'lampu_besar' => !isset($request->lampu_besar) ? DB::raw('lampu_besar') : 0

    // Driver
    function getChecklistVal($checklistName)
    {
      global $request;
      if (auth()->user()->hasRole('driver')) {
        return !isset($request[$checklistName]) ? 1 : DB::raw($checklistName);
      } else {
        return !isset($request[$checklistName]) ? DB::raw($checklistName) : 0;
      }
    }

    VehicleLastStatus::updateOrCreate(
      ['vehicle_id' => $request->vehicle_id],
      [
        'lampu_besar' => getChecklistVal('lampu_besar'),
        'lampu_kota' => getChecklistVal('lampu_kota'),
        'lampu_rem' => getChecklistVal('lampu_rem'),
        'lampu_sein' => getChecklistVal('lampu_sein'),
        'lampu_mundur' => getChecklistVal('lampu_mundur'),
        'lampu_kabin' => getChecklistVal('lampu_kabin'),
        'lampu_senter' => getChecklistVal('lampu_senter'),
        'kaca_depan' => getChecklistVal('kaca_depan'),
        'kaca_samping' => getChecklistVal('kaca_samping'),
        'kaca_belakang' => getChecklistVal('kaca_belakang'),
        'ban_depan' => getChecklistVal('ban_depan'),
        'ban_belakang_dalam' => getChecklistVal('ban_belakang_dalam'),
        'ban_belakang_luar' => getChecklistVal('ban_belakang_luar'),
        'ban_serep' => getChecklistVal('ban_serep'),
        'tekanan_angin_ban_depan' => getChecklistVal('tekanan_angin_ban_depan'),
        'tekanan_angin_ban_belakang_dalam' => getChecklistVal('tekanan_angin_ban_belakang_dalam'),
        'tekanan_angin_ban_belakang_luar' => getChecklistVal('tekanan_angin_ban_belakang_luar'),
        'tekanan_angin_ban_serep' => getChecklistVal('tekanan_angin_ban_serep'),
        'velg_ban_depan' => getChecklistVal('velg_ban_depan'),
        'velg_ban_belakang_dalam' => getChecklistVal('velg_ban_belakang_dalam'),
        'velg_ban_belakang_luar' => getChecklistVal('velg_ban_belakang_luar'),
        'velg_ban_serep' => getChecklistVal('velg_ban_serep'),
        'ganjal_ban' => getChecklistVal('ganjal_ban'),
        'dongkrak' => getChecklistVal('dongkrak'),
        'kunci_roda' => getChecklistVal('kunci_roda'),
        'stang_kunci_roda' => getChecklistVal('stang_kunci_roda'),
        'pipa_bantu' => getChecklistVal('pipa_bantu'),
        'kotak_p3k' => getChecklistVal('kotak_p3k'),
        'apar' => getChecklistVal('apar'),
        'emergency_triangle' => getChecklistVal('emergency_triangle'),
        'tool_kit' => getChecklistVal('tool_kit'),
        'seragam' => getChecklistVal('seragam'),
        'safety_shoes' => getChecklistVal('safety_shoes'),
        'driver_license' => getChecklistVal('driver_license'),
        'kartu_keur' => getChecklistVal('kartu_keur'),
        'stnk' => getChecklistVal('stnk'),
        'helmet' => getChecklistVal('helmet'),
        'tatakan_menulis' => getChecklistVal('tatakan_menulis'),
        'ballpoint' => getChecklistVal('ballpoint'),
        'straples' => getChecklistVal('straples'),
        'exhaust_brake' => getChecklistVal('exhaust_brake'),
        'spion' => getChecklistVal('spion'),
        'wiper' => getChecklistVal('wiper'),
        'tangki_bahan_bakar' => getChecklistVal('tangki_bahan_bakar'),
        'tutup_tangki_bahan_bakar' => getChecklistVal('tutup_tangki_bahan_bakar'),
        'tutup_radiator' => getChecklistVal('tutup_radiator'),
        'accu' => getChecklistVal('accu'),
        'oli_mesin' => getChecklistVal('oli_mesin'),
        'minyak_rem' => getChecklistVal('minyak_rem'),
        'minyak_kopling' => getChecklistVal('minyak_kopling'),
        'oli_hidraulic' => getChecklistVal('oli_hidraulic'),
        'klakson' => getChecklistVal('klakson'),
        'panel_speedometer' => getChecklistVal('panel_speedometer'),
        'panel_bahan_bakar' => getChecklistVal('panel_bahan_bakar'),
        'sunvisor' => getChecklistVal('sunvisor'),
        'jok' => getChecklistVal('jok'),
        'air_conditioner' => getChecklistVal('air_conditioner'),
        'address_id' => intval($vehicle->address_id),
        'odo' => intval($vehicle->odo),
      ]
    );

    for ($i = 1; $i <= 4; $i++) {
      if (!array_key_exists("image_$i", $imageData)) break;
      $vehicleChecklistImage = new VehicleChecklistImage();
      $vehicleChecklistImage->image = uploadImage($imageData["image_$i"], 'checklist', auth()->user()->person->name . "-image_$i", $timestamp);
      $vehicleChecklistImage->description = $imageData["image_" . $i . "_description"];
      $vehicleChecklistImage->vehicle_checklist_id = $vehicleChecklist->id;
      $vehicleChecklistImage->save();
    }

    return to_route('index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'checlist', 'created'));
  }
}