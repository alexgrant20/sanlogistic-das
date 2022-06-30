<?php

namespace App\Http\Livewire\Driver\Activity;


use App\Models\AddressProject;
use App\Models\Vehicle;
use Livewire\Component;

class VehicleForm extends Component
{
  public $vehicleId;
  public $departureAddress;
  public $odo;
  public $doNumber;
  public $arrivalAddressLists;
  public $projectId;
  public $vehicles;

  public function render()
  {
    return view('livewire.driver.activity.vehicle-form');
  }

  public function updatedVehicleId($vehicleId)
  {
    $vehicle = Vehicle::find($vehicleId);
    $departureAddress = $vehicle->address;

    $this->arrivalAddressLists = AddressProject::where('project_id', $this->projectId)
      ->where('address_id', '!=', $departureAddress->id)
      ->with('address')
      ->get();;
    $this->odo = $vehicle->odo;
    $this->departureAddress = $departureAddress;
    $this->doNumber = $vehicle->last_do_number;
  }
}