@extends('layouts.main')

@section('headCSS')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" />
@endsection

@section('headJS')
  <script type="text/javascript" src="/js/tableConfig.js"></script>
@endsection

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

      <div class="d-flex mb-4">
        <form class="me-2" action="/vehicles/export/excel">
          @csrf
          <button class="btn btn-success">Export Excel</button>
        </form>

        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#importExcel">
          Import Excel
        </button>

        <!-- Modal -->
        <div class="modal fade" id="importExcel" tabindex="-1" aria-labelledby="importExcelLabel" aria-hidden="true">
          <form method="post" action="/vehicles/import/excel" enctype="multipart/form-data">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="importExcelLabel">Modal title</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  @csrf

                  <label>Pilih file excel</label>
                  <div class="form-group">
                    <input type="file" name="file" required="required">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Import</button>
                </div>
              </div>
            </div>
          </form>
        </div>

        @if (!$imagesMigrated)
          <form action="/vehicles/migrate/image">
            @csrf
            <button class="btn btn-primary">Migrate</button>
          </form>
        @endif
      </div>

      <table class="table table-hover text-center  table-dark table-striped" id="myTable">
        <thead>
          <tr class="header">
            <th>No</th>
            <th>Owner</th>
            <th>User</th>
            <th>Status</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Odometer</th>
            <th>KIR Expired</th>
            <th>STNK Expired</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($vehicles as $vehicle)
            <tr>
              <td>{{ $loop->iteration }}</td>
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

              <td>
                <a href="/vehicles/{{ $vehicle->license_plate }}/edit" class="badge bg-primary"><i
                    class="bi bi-pencil"></i></a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </div>
@endsection

@section('footJS')
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
@endsection
