@extends('admin.layouts.index')

@section('container')
  <div class="page-content">

    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Vehicles</h2>
      </div>
    </div>
    <section class="container-fluid">
      @include('admin.partials.import')
      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <input type="hidden" id="tableName" value="vehicles">
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <div class="table-responsive">
        <table class="table table-striped table-dark text-center" data-display="datatables">
          <thead>
            <tr>
              <th>ID</th>
              <th></th>
              <th></th>
              <th>License Plate</th>
              <th>Owner</th>
              <th>Project</th>
              <th>Brand</th>
              <th>Model</th>
              <th>Odo</th>
              <th>KIR Exp</th>
              <th>STNK Exp</th>
              <th>Lamp</th>
              <th>Glass</th>
              <th>Tire</th>
              <th>Equipment</th>
              <th>Gear</th>
              <th>Other</th>
              {{-- <th>Odometer Service</th>
            <th>Service Expired</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($vehicles as $vehicle)
              <tr>
                <td>{{ $vehicle->id }}</td>
                <td></td>
                <td>
                  <div class="dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="{{ route('admin.vehicle.edit', $vehicle->license_plate) }}" class="dropdown-item">
                          Edit
                        </a>
                      </li>
                      @if (!empty($vehicle->vehicle_last_status_id))
                        <li>
                          <a href="{{ route('admin.vehicleLastStatus.show', $vehicle->license_plate) }}"
                            class="dropdown-item">
                            Last Status
                          </a>
                        </li>
                      @endif
                    </ul>
                  </div>
                </td>
                <td>
                  @php
                    $licese_plate_color = intval($vehicle->vehicle_license_plate_color_id) === 2 ? 'bg-warning' : 'bg-white';
                  @endphp
                  <span class="text-dark {{ $licese_plate_color }}">{{ $vehicle->license_plate }}</span>
                </td>
                <td>{{ $vehicle->company_name }}</td>
                <td>{{ $vehicle->project_name }}</td>
                <td>{{ $vehicle->vehicle_brand }}</td>
                <td>{{ $vehicle->vehicle_type }}</td>
                <td>{{ $vehicle->odo }}</td>
                @if ($vehicle->kir_expire)
                  <td>{{ $vehicle->kir_expire }}</td>
                @else
                  <td>No Data</td>
                @endif
                @if ($vehicle->kir_expire)
                  <td>{{ $vehicle->stnk_expire }}</td>
                @else
                  <td>No Data</td>
                @endif
                <td>{{ $vehicle->total_broken_lamp }}</td>
                <td>{{ $vehicle->total_broken_glass }}</td>
                <td>{{ $vehicle->total_broken_tire }}</td>
                <td>{{ $vehicle->total_broken_equipment }}</td>
                <td>{{ $vehicle->total_broken_gear }}</td>
                <td>{{ $vehicle->total_broken_other }}</td>
                {{-- <td></td>
              <td></td> --}}
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>
  </div>
@endsection
