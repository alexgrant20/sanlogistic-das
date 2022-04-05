@extends('layouts.index')

@section('container')
  <div class="page-content">

    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Vehicles</h2>
      </div>
    </div>
    <section class="container-fluid">
      @include('partials.index_response')
      @include('partials.import')
      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <input type="hidden" id="tableName" value="vehicles">
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <table class="table table-hover text-center table-dark nowrap" style="width: 100%" data-display="datatables">
        <thead>
          <tr class="header">
            <th>ID</th>
            <th>Action</th>
            <th>Owner</th>
            <th>User</th>
            <th>Status</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Odometer</th>
            <th>KIR Expired</th>
            <th>STNK Expired</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($vehicles as $vehicle)
            <tr>
              <td>{{ $vehicle->id }}</td>
              <td>
                <a href="{{ url("/vehicles/$vehicle->license_plate/edit") }}" class="badge bg-primary">
                  <i class="bi bi-pencil"></i>
                </a>
              </td>
              <td>{{ $vehicle->owner->name ?? null }}</td>
              <td>{{ $vehicle->project->name ?? null }}</td>
              <td>{{ $vehicle->status ?? null }}</td>
              <td>{{ $vehicle->vehicleVariety->vehicleType->vehicleBrand->name ?? null }}</td>
              <td>{{ $vehicle->vehicleVariety->vehicleType->name ?? null }}</td>
              <td>{{ $vehicle->odo ?? null }}</td>

              @if ($vehicle->vehiclesDocuments->contains('type', 'kir'))
                <td>{{ $vehicle->vehiclesDocuments->where('type', 'kir')->first()->expire }}</td>
              @else
                <td></td>
              @endif

              @if ($vehicle->vehiclesDocuments->contains('type', 'stnk'))
                <td>{{ $vehicle->vehiclesDocuments->where('type', 'stnk')->first()->expire }}</td>
              @else
                <td></td>
              @endif
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </div>
@endsection
