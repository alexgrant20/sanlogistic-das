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
            </tr>
          </thead>
          <tbody>
            @foreach ($vehicles as $vehicle)
              <tr>
                <td>{{ $vehicle->id }}</td>
                <td></td>
                <td>
                  @if (!empty($vehicle->vehicle_last_status_id) or
                      auth()->user()->can('edit-vehicle'))
                    <div class="dropdown">
                      <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                      </button>
                      <ul class="dropdown-menu">
                        @can('edit-vehicle')
                          <li>
                            <a href="{{ route('admin.vehicles.edit', $vehicle->license_plate) }}" class="dropdown-item">
                              Edit
                            </a>
                          </li>
                        @endcan
                        @if (!empty($vehicle->vehicle_last_status_id))
                          <li>
                            <a href="{{ route('admin.vehicles-last-statuses.show', $vehicle->license_plate) }}"
                              class="dropdown-item">
                              Last Status
                            </a>
                          </li>
                        @endif
                      </ul>
                    </div>
                  @endif
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

                <td
                  class={{ decideTextColorByDay($vehicle->kir_expire, [0 => 'text-red-700', 15 => 'text-red-300', 30 => 'text-warning'], 'text-green-300') }}>
                  {{ $vehicle->kir_expire ?? 'No Data' }}
                </td>

                <td
                  class={{ decideTextColorByDay($vehicle->stnk_expire, [0 => 'text-red-700', 15 => 'text-red-300', 30 => 'text-warning'], 'text-green-300') }}>
                  {{ $vehicle->stnk_expire ?? 'No Data' }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>
  </div>
@endsection
