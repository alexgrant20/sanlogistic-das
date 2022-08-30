<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleChecklist;
use App\Models\VehicleLastStatus;
use Illuminate\Http\Request;

class VehicleLastStatusController extends Controller
{
  public function show(Vehicle $vehicle)
  {
    $lampLabel = ['lampu_besar', 'lampu_kota', 'lampu_rem', 'lampu_sein', 'lampu_mundur', 'lampu_kabin'];
    $oilLabel = ['oli_mesin', 'minyak_rem', 'minyak_kopling', 'oli_hidraulic', 'exhaust_brake'];
    $tireLabel = ['ban_depan', 'ban_belakang_dalam', 'ban_belakang_luar', 'ban_serep'];
    $velgLabel = ['velg_ban_depan', 'velg_ban_belakang_dalam', 'velg_ban_belakang_luar', 'velg_ban_serep'];
    $tirePreasureLabel = ['tekanan_angin_ban_depan', 'tekanan_angin_ban_belakang_dalam', 'tekanan_angin_ban_belakang_luar', 'tekanan_angin_ban_serep'];
    $glassLabel = ['kaca_depan', 'kaca_belakang', 'kaca_samping'];
    $otherOutsideLabel = ['accu', 'tutup_radiator', 'tangki_bahan_bakar', 'tutup_tangki_bahan_bakar'];
    $otherInsideLabel = ['spion', 'wiper', 'klakson', 'panel_speedometer', 'panel_bahan_bakar', 'sunvisor', 'jok'];

    $latestVehicleChecklist = collect(VehicleChecklist::where('vehicle_id', $vehicle->id)->latest()->first());


    $lamp__vc = $latestVehicleChecklist->only($lampLabel)->countBy();
    $oil__vc = $latestVehicleChecklist->only($oilLabel)->countBy();
    $tire__vc = $latestVehicleChecklist->only($tireLabel)->countBy();
    $velg__vc = $latestVehicleChecklist->only($velgLabel)->countBy();
    $tirePreasure__vc = $latestVehicleChecklist->only($tirePreasureLabel)->countBy();
    $glass__vc = $latestVehicleChecklist->only($glassLabel)->countBy();
    $otherOutside__vc = $latestVehicleChecklist->only($otherOutsideLabel)->countBy();
    $otherInside__vc = $latestVehicleChecklist->only($otherInsideLabel)->countBy();

    $oklatestChecklistSummary = [
      'lamp' => getPercentage($lamp__vc->get(0), $lamp__vc->sum()),
      'oil' => getPercentage($oil__vc->get(0), $oil__vc->sum()),
      'tire' => getPercentage($tire__vc->get(0), $tire__vc->sum()),
      'velg' => getPercentage($velg__vc->get(0), $velg__vc->sum()),
      'tirePreasure' => getPercentage($tirePreasure__vc->get(0), $tirePreasure__vc->sum()),
      'glass' => getPercentage($glass__vc->get(0), $glass__vc->sum()),
      'otherOutside' => getPercentage($otherOutside__vc->get(0), $otherOutside__vc->sum()),
      'otherInside' => getPercentage($otherInside__vc->get(0), $otherInside__vc->sum())
    ];


    $vehicleLastStatus = collect($vehicle->vehicleLastStatus);

    $lamp = $vehicleLastStatus->only($lampLabel);
    $oil = $vehicleLastStatus->only($oilLabel);
    $tire = $vehicleLastStatus->only($tireLabel);
    $velg = $vehicleLastStatus->only($velgLabel);
    $tirePreasure = $vehicleLastStatus->only($tirePreasureLabel);
    $glass = $vehicleLastStatus->only($glassLabel);
    $otherOutside = $vehicleLastStatus->only($otherOutsideLabel);
    $otherInside = $vehicleLastStatus->only($otherInsideLabel);

    $lampCount = $lamp->countBy();
    $oilCount = $oil->countBy();
    $tireCount = $tire->countBy();
    $velgCount = $velg->countBy();
    $tirePreasureCount = $tirePreasure->countBy();
    $glassCount = $glass->countBy();
    $otherOutsideCount = $otherOutside->countBy();
    $otherInsideCount = $otherInside->countBy();

    $lastStatusSummary = $vehicleLastStatus->only([
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

    $lastStatusesData = [
      'Lampu-Lampu' => [
        'config' => ['icon' => 'fa-solid fa-lightbulb'],
        'items' => $lamp,
        'summary' => [
          'ok' => $lampCount->get(0),
          'broken' => $lampCount->get(1),
          'total' => (int) $lampCount->get(0) + (int) $lampCount->get(1)
        ]
      ],
      'Oil' => [
        'config' => ['icon' => 'fa-solid fa-oil-can'],
        'items' => $oil,
        'summary' => [
          'ok' => $oilCount->get(0),
          'broken' => $oilCount->get(1),
          'total' => (int) $oilCount->get(0) + (int) $oilCount->get(1)
        ]
      ],
      'Ban Luar' => [
        'config' => ['icon' => 'fa-solid fa-circle-dot'],
        'items' => $tire,
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
        'summary' => [
          'ok' => $glassCount->get(0),
          'broken' => $glassCount->get(1),
          'total' => (int) $glassCount->get(0) + (int) $glassCount->get(1)
        ]
      ],
      'Lain-Lain Luar' => [
        'config' => ['icon' => 'fa-solid fa-ellipsis'],
        'items' => $otherOutside,
        'summary' => [
          'ok' => $otherOutsideCount->get(0),
          'broken' => $otherOutsideCount->get(1),
          'total' => (int) $otherOutsideCount->get(0) + (int) $otherOutsideCount->get(1)
        ]
      ],
      'Lain-Lain Dalam' => [
        'config' => ['icon' => 'fa-solid fa-ellipsis'],
        'items' => $otherInside,
        'summary' => [
          'ok' => $otherInsideCount->get(0),
          'broken' => $otherInsideCount->get(1),
          'total' => (int) $otherInsideCount->get(0) + (int) $otherInsideCount->get(1)
        ]
      ],
    ];


    return view('admin.vehicle_last_status.show', [
      'title' => $vehicle->license_plate . ' Last Status',
      'vehicleLastStatus' => $vehicle->vehicleLastStatus,
      'vehicle' => $vehicle,
      'okItemPercentage' => $okItemPercentage,
      'totalOk' => $totalOk,
      'totalBroken' => $totalBroken,
      'lastStatusesData' => $lastStatusesData,
      'latestSummary' => $oklatestChecklistSummary,
      'latestVehicleChecklist' => $latestVehicleChecklist
    ]);
  }
}