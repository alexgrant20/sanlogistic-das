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
      <table class="table table-hover text-center table-dark nowrap" style="width: 100%" data-display="datatables">
        <thead>
          <tr class="header">
            <th>ID</th>
            <th>Action</th>
            <th>License Plate</th>
            <th>Owner</th>
            <th>User</th>
            <th>Status</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Odometer</th>
            {{-- <th>Odometer Service</th>
            <th>Service Expired</th> --}}
            <th>KIR Expired</th>
            <th>STNK Expired</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($vehicles as $vehicle)
            <tr>
              <td>{{ $vehicle->id }}</td>
              <td>
                <a href="{{ url("/admin/vehicles/$vehicle->license_plate/edit") }}" class="badge bg-primary">
                  <i class="bi bi-pencil"></i>
                </a>
              </td>
              <td>{{ $vehicle->license_plate }}</td>
              <td>{{ $vehicle->company_name }}</td>
              <td>{{ $vehicle->project_name }}</td>
              <td>{{ $vehicle->status }}</td>
              <td>{{ $vehicle->vehicle_brand }}</td>
              <td>{{ $vehicle->vehicle_type }}</td>
              <td>{{ $vehicle->odo }}</td>
              {{-- <td></td>
              <td></td> --}}
              @if ($vehicle->kir_expire)
                <td>{{ $vehicle->kir_expire }}</td>
              @else
                <td class="text-primary">No Data</td>
              @endif
              @if ($vehicle->kir_expire)
                <td>{{ $vehicle->stnk_expire }}</td>
              @else
                <td class="text-primary">No Data</td>
              @endif
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </div>
@endsection
