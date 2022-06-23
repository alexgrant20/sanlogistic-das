@extends('driver.layouts.main')

@section('container')
  <div class="position-fixed m-auto text-center align-items-center justify-content-center bg-main" id="pageSpinner"
    style="display:flex; top: 0; left: 0; right: 0; bottom: 0; margin: auto; z-index: 12;">
    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"></div>
  </div>
  <input type="hidden" value="{{ auth()->user()->person->project_id }}" id="project_id">

  <form method="POST" action="{{ route('driver.activity.store') }}" class="px-3 needs-validation" id="myForm"
    enctype="multipart/form-data">
    @csrf
    <div class="row g-5">
      <div class="col-xl-4">
        <h4 class="text-blue">Choose Vehicle</h4>
        <hr>
        <label for="vehicle_id" class="form-label fs-5">Pilih Kendaraan</label>
        <select id="vehicle_id" name="vehicle_id" class="form-dark form-select form-select-lg" required>
          <option class="d-none" value=""></option>
        </select>
      </div>
      <div class="d-none" id="userInput">
        <div class="col-xl-4">
          <h4 class="text-blue">Vehicle Detail</h4>
          <hr>
          <div class="row g-3">
            <input type="hidden" id="departure_location_id" name="departure_location_id">
            <div class="col-md-6">
              <label for="odo" class="form-label fs-5">Odometer Awal</label>
              <input type="number" name="departure_odo" id="odo" class="form-control form-control-lg form-dark"
                readonly>
            </div>
            <div class="col-md-6">
              <label for="departure_location_name" class="form-label fs-5">Lokasi Awal</label>
              <input type="text" id="departure_location_name" class="form-control form-control-lg form-dark" disabled>
            </div>
          </div>
        </div>

        <div class="col-xl-4">
          <h4 class="text-blue">Data Input</h4>
          <hr>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="do_number" class="form-label fs-5">Nomor DO</label>
              <input type="text" id="do_number" name="do_number" class="form-control form-control-lg form-dark"
                required>
            </div>
            <div class="col-md-6">
              <label for="arrival_location_id" class="form-label fs-5">Lokasi Akhir</label>
              <select id="arrival_location_id" name="arrival_location_id" class="form-dark form-select form-select-lg"
                required></select>
            </div>
          </div>
        </div>

        <div class="col-xl-8">
          <h4 class="text-blue">Input Image</h4>
          <hr>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="d-flex flex-column">
                <div class="mb-3">
                  <label for="do_image" class="form-label fs-5">DO Image</label>
                  <input class="form-control form-dark form-control-lg" id="do_image" name="do_image" type="file"
                    accept=".png, .jpeg, .jpg" onchange="previewImage('do_image')" required>
                </div>
                <img src="{{ asset('/img/default.jpg') }}" style="height: 300px;" id="do_image-preview"
                  class="img-fluid zoom m-auto d-block mw-100" alt="" data-action="zoom">
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex flex-column">
                <div class="mb-3">
                  <label for="departure_odo_image" class="form-label fs-5">ODO Image</label>
                  <input class="form-control form-dark form-control-lg" id="departure_odo_image"
                    name="departure_odo_image" type="file" accept=".png, .jpeg, .jpg"
                    onchange="previewImage('departure_odo_image')" required>
                </div>
                <img src="{{ asset('/img/default.jpg') }}" style="height: 300px;" id="departure_odo_image-preview"
                  class="img-fluid zoom m-auto d-block mw-100" alt="" data-action="zoom">
              </div>
            </div>
          </div>
        </div>
        <span class="col-md-12 d-flex justify-content-end">
          <button type="submit" class="btn btn-lg btn-primary">
            <span class="spinner-border spinner-border-sm spinnerButton" style="display: none;" role="status"
              aria-hidden="true"></span>
            Create
          </button>
        </span>
      </div>
    </div>
  </form>
@endsection

@section('footJS')
  <script src="{{ asset('/js/driver/activity/create.js') }}"></script>
@endsection
