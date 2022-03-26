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

      @if (session()->has('importErrorList'))
        <div class="modal openModal" tabindex="-1">
          <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title text-primary fw-bold">Erorr List</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <table class="table table-danger">
                  <tr>
                    <th>Row</th>
                    <th>Attribute</th>
                    <th>Errors</th>
                    <th>Value</th>
                  </tr>
                  @foreach (session()->get('importErrorList') as $validation)
                    <tr>
                      <td>{{ $validation->row() }}</td>
                      <td>{{ $validation->attribute() }}</td>
                      <td>
                        <ul>
                          @foreach ($validation->errors() as $e)
                            <li>{{ $e }}</li>
                          @endforeach
                        </ul>
                      </td>
                      <td>
                        {{ $validation->values()[$validation->attribute()] }}
                      </td>
                    </tr>
                  @endforeach
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
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
