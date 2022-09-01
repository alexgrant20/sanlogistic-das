<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleChecklist;
use App\Models\Vehicle;
use Illuminate\Support\Arr;

class VehicleChecklistController extends Controller
{
  public function show(VehicleChecklist $vehicleChecklist)
  {
    $lampLabel = ['lampu_besar', 'lampu_kota', 'lampu_rem', 'lampu_sein', 'lampu_mundur', 'lampu_kabin'];
    $oilLabel = ['oli_mesin', 'minyak_rem', 'minyak_kopling', 'oli_hidraulic', 'exhaust_brake'];
    $tireLabel = ['ban_depan', 'ban_belakang_dalam', 'ban_belakang_luar', 'ban_serep'];
    $velgLabel = ['velg_ban_depan', 'velg_ban_belakang_dalam', 'velg_ban_belakang_luar', 'velg_ban_serep'];
    $tirePreasureLabel = ['tekanan_angin_ban_depan', 'tekanan_angin_ban_belakang_dalam', 'tekanan_angin_ban_belakang_luar', 'tekanan_angin_ban_serep'];
    $glassLabel = ['kaca_depan', 'kaca_belakang', 'kaca_samping'];
    $otherOutsideLabel = ['accu', 'tutup_radiator', 'tangki_bahan_bakar', 'tutup_tangki_bahan_bakar'];
    $otherInsideLabel = ['spion', 'wiper', 'klakson', 'panel_speedometer', 'panel_bahan_bakar', 'sunvisor', 'jok'];

    $vehicleChecklist__ori = $vehicleChecklist;
    $vehicle =  $vehicleChecklist->vehicle;
    $vehicleChecklist = collect($vehicleChecklist);
    $vehicleChecklists = VehicleChecklist::where('vehicle_id', $vehicle->id)->latest()->with('address', 'user', 'user.person')->get();

    $vehicleCheclistsModif = collect();

    foreach ($vehicleChecklists as $item) {

      $uniqueVal = collect($item)->only([
        ...$lampLabel,
        ...$oilLabel,
        ...$tireLabel,
        ...$velgLabel,
        ...$tirePreasureLabel,
        ...$glassLabel,
        ...$otherOutsideLabel,
        ...$otherInsideLabel
      ])->countBy();

      $vehicleCondition = round(((int)$uniqueVal->get(0) / ((int)$uniqueVal->get(0) + (int)$uniqueVal->get(1))) * 100);

      $vehicleCheclistsModif->push(
        collect([
          ...$item->toArray(),
          'vehicle_condition' => $vehicleCondition,
          'created_at' => $item->created_at->format('Y-m-d')
        ])
      );
    }

    $lamp = $vehicleChecklist->only($lampLabel);
    $oil = $vehicleChecklist->only($oilLabel);
    $tire = $vehicleChecklist->only($tireLabel);
    $velg = $vehicleChecklist->only($velgLabel);
    $tirePreasure = $vehicleChecklist->only($tirePreasureLabel);
    $glass = $vehicleChecklist->only($glassLabel);
    $otherOutside = $vehicleChecklist->only($otherOutsideLabel);
    $otherInside = $vehicleChecklist->only($otherInsideLabel);

    $lampCount = $lamp->countBy();
    $oilCount = $oil->countBy();
    $tireCount = $tire->countBy();
    $velgCount = $velg->countBy();
    $tirePreasureCount = $tirePreasure->countBy();
    $glassCount = $glass->countBy();
    $otherOutsideCount = $otherOutside->countBy();
    $otherInsideCount = $otherInside->countBy();

    $lastStatusSummary = $vehicleChecklist->only([
      ...$lampLabel,
      ...$oilLabel,
      ...$tireLabel,
      ...$velgLabel,
      ...$tirePreasureLabel,
      ...$glassLabel,
      ...$otherOutsideLabel,
      ...$otherInsideLabel
    ])->countBy();

    $totalOk = (int) $lastStatusSummary->get(0);
    $totalBroken = (int) $lastStatusSummary->get(1);
    $totalItem =  $totalOk + $totalBroken;

    $okItemPercentage = round(($totalOk / $totalItem) * 100);

    $vehicleChecklistData = [
      'Lampu-Lampu' => [
        'config' => ['icon' => 'fa-solid fa-lightbulb'],
        'items' => $lamp,
        'notes' => $vehicleChecklist->get('lamp_notes'),
        'summary' => [
          'ok' => $lampCount->get(0),
          'broken' => $lampCount->get(1),
          'total' => (int) $lampCount->get(0) + (int) $lampCount->get(1)
        ]
      ],
      'Oil' => [
        'config' => ['icon' => 'fa-solid fa-oil-can'],
        'items' => $oil,
        'notes' => $vehicleChecklist->get('equipment_notes'),
        'summary' => [
          'ok' => $oilCount->get(0),
          'broken' => $oilCount->get(1),
          'total' => (int) $oilCount->get(0) + (int) $oilCount->get(1)
        ]
      ],
      'Ban Luar' => [
        'config' => ['icon' => 'fa-solid fa-circle-dot'],
        'items' => $tire,
        'notes' => $vehicleChecklist->get('tire_notes'),
        'summary' => [
          'ok' => $tireCount->get(0),
          'broken' => $tireCount->get(1),
          'total' => (int) $tireCount->get(0) + (int) $tireCount->get(1)
        ]
      ],
      'Velg' => [
        'config' => ['icon' => 'fa-brands fa-first-order-alt'],
        'items' => $velg,
        'summary' => [
          'ok' => $velgCount->get(0),
          'broken' => $velgCount->get(1),
          'total' => (int) $velgCount->get(0) + (int) $velgCount->get(1)
        ]
      ],
      'Tekanan Ban' => [
        'config' => ['icon' => 'fa-solid fa-gauge'],
        'items' => $tirePreasure,
        'summary' => [
          'ok' => $tirePreasureCount->get(0),
          'broken' => $tirePreasureCount->get(1),
          'total' => (int) $tirePreasureCount->get(0) + (int) $tirePreasureCount->get(1)
        ]
      ],
      'Kaca' => [
        'config' => ['icon' => 'fa-regular fa-window-maximize'],
        'items' => $glass,
        'notes' => $vehicleChecklist->get('glass_notes'),
        'summary' => [
          'ok' => $glassCount->get(0),
          'broken' => $glassCount->get(1),
          'total' => (int) $glassCount->get(0) + (int) $glassCount->get(1)
        ]
      ],
      'Lain-Lain Luar' => [
        'config' => ['icon' => 'fa-solid fa-ellipsis'],
        'items' => $otherOutside,
        'notes' => $vehicleChecklist->get('other_notes'),
        'summary' => [
          'ok' => $otherOutsideCount->get(0),
          'broken' => $otherOutsideCount->get(1),
          'total' => (int) $otherOutsideCount->get(0) + (int) $otherOutsideCount->get(1)
        ]
      ],
      'Lain-Lain Dalam' => [
        'config' => ['icon' => 'fa-solid fa-ellipsis'],
        'items' => $otherInside,
        'notes' => $vehicleChecklist->get('other_notes'),
        'summary' => [
          'ok' => $otherInsideCount->get(0),
          'broken' => $otherInsideCount->get(1),
          'total' => (int) $otherInsideCount->get(0) + (int) $otherInsideCount->get(1)
        ]
      ],
    ];

    return view('admin.vehicle_checklists.show', [
      'title' => $vehicle->license_plate . ' Last Status',
      'vehicle' => $vehicle,
      'okItemPercentage' => $okItemPercentage,
      'totalOk' => $totalOk,
      'totalBroken' => $totalBroken,
      'vehicleChecklist' => $vehicleChecklistData,
      'vehicleChecklists' => $vehicleCheclistsModif,
      'vehicleChecklist__ori' => $vehicleChecklist__ori
    ]);
  }
}