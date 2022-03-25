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

      @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
          {{ session('error') }}
        </div>
      @endif

      @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      @endif

      <!-- Import Modal -->
      <div class="modal fade" id="importExcel" tabindex="-1" aria-labelledby="importExcelLabel" aria-hidden="true">
        <form method="post" action="{{ url('/vehicles/import/excel') }}" enctype="multipart/form-data">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="importExcelLabel">Import</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                @csrf

                <label class="form-label">Pilih file excel</label>
                <div class="form-group">
                  <input class="form-control" type="file" name="file" required="required">
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Import</button>
              </div>
            </div>
          </div>
        </form>
      </div>

      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <table class="table table-hover text-center  table-dark nowrap" style="width: 100%">
        <thead>
          <tr class="header">
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
              <td>
                <a href="{{ url("/vehicles/$vehicle->license_plate/edit") }}" class="badge bg-primary">
                  <i class="bi bi-pencil"></i>
                </a>
              </td>
              <td>{{ $vehicle->owner->name }}</td>
              <td>{{ $vehicle->project->name }}</td>
              <td>{{ $vehicle->status }}</td>
              <td>{{ $vehicle->vehicleVariety->vehicleType->vehicleBrand->name }}</td>
              <td>{{ $vehicle->vehicleVariety->vehicleType->name }}</td>
              <td>{{ $vehicle->odo }}</td>

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
