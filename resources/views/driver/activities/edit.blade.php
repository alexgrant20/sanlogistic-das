@extends('admin.layouts.main')

@section('container')
  <form action="{{ url('/driver/activities/' . $activity->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @if (session()->has('error'))
      <div class="alert alert-danger" role="alert">
        {{ session('error') }}
      </div>
    @endif

    <div class="row g-5 mb-3">
      <div class="col-xxl-8 col-md-12 order-xl-5">
        <h4 class="text-blue">Trip Detail</h4>
        <hr>
        <div class="row g-3">
          <div class="col-md-3">
            <label for="departure_odo" class="form-label fs-5">Odometer Awal</label>
            <input type="text" id="departure_odo" value="{{ $activity->departure_odo }}"
              class="form-control form-control-lg form-dark" disabled>
          </div>
          <div class="col-md-3">
            <label for="do_number" class="form-label fs-5">Nomer DO</label>
            <input type="text" id="do_number" value="{{ $activity->do_number }}"
              class="form-control form-control-lg form-dark" disabled>
          </div>
          <div class="col-md-3">
            <label for="license_plate" class="form-label fs-5">Plat Nomer</label>
            <input type="text" id="license_plate" value="{{ $activity->vehicle->license_plate }}"
              class="form-control form-control-lg form-dark" disabled>
          </div>
          <div class="col-md-3">
            <label for="departure_name" class="form-label fs-5">Lokasi Awal</label>
            <input type="text" id="departure_name" value="{{ $activity->departureLocation->name }}"
              class="form-control form-control-lg form-dark" disabled>
          </div>
        </div>

      </div>
      <div class="col-xxl-4 col-md-6 order-xl-1">
        <h4 class="text-blue">Data Input</h4>
        <hr>
        <div class="row g-3">
          <div class="col-md-6">
            <label for="arrival_id" class="form-label fs-5">Lokasi Tujuan</label>
            <select id="arrival_id" name="arrival_id" class="form-dark form-select form-select-lg">
              <option hidden></option>
              @foreach ($arrival_addresses as $arrival_address)
                @if ($arrival_address->address->id == old('arrival_id', $activity->arrival_location_id))
                  <option value="{{ $arrival_address->address->id }}" selected>{{ $arrival_address->address->name }}
                  </option>
                @else
                  <option value="{{ $arrival_address->address->id }}">{{ $arrival_address->address->name }}</option>
                @endif
              @endforeach
            </select>

            @error('arrival_id')
              <div class="text-danger mt-2">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="col-md-6">
            <label for="arrival_odo" class="form-label fs-5">Odometer</label>
            <input type="number" id="arrival_odo" name="arrival_odo" class="form-control form-control-lg form-dark"
              value="{{ old('arrival_odo', $activity->arrival_odo) }}">

            @error('arrival_odo')
              <div class="text-danger mt-2">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="col-md-12">
            <div class="d-flex flex-column">
              <div class="mb-3">
                <label for="arrival_odo_img" class="form-label fs-5">Foto Odometer</label>
                <input class="form-control form-dark form-control-lg" id="arrival_odo_img" name="arrival_odo_img"
                  accept="image/*" onchange="previewImage('arrival_odo_img')" type="file">
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <img src="" style="height: 300px;" id="arrival_odo_img-preview" data-action="zoom"
              class="img-fluid zoom m-auto d-block mw-100" alt="">
          </div>
        </div>
      </div>

      <div class="col-xxl-4 col-md-6 order-xl-2">
        <h4 class="text-blue">BBM</h4>
        <hr>
        <div class="row g-3 row-cols-1">
          <div>
            <label for="bbm_amount" class="form-label fs-5">Jumlah Pembelian BBM</label>
            <input type="text" value="{{ $activity->activityStatus->activityPayment->bbm_amount }}" id="bbm_amount"
              name="bbm_amount" class="form-control form-control-lg form-dark" data="money">
          </div>
          <div>
            <div class="d-flex flex-column">
              <div class="mb-3">
                <label for="bbm_img" class="form-label fs-5">Foto Pembelian BBM</label>
                <input class="form-control form-dark form-control-lg" id="bbm_img" name="bbm_img" accept="image/*"
                  onchange="previewImage('bbm_img')" type="file">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <img src="" style="height: 300px;" class="img-fluid zoom m-auto d-block mw-100" id="bbm_img-preview"
              data-action="zoom" alt="">
          </div>
        </div>
      </div>

      <div class="col-xxl-4 col-md-6 order-xl-3">
        <h4 class="text-blue">Toll</h4>
        <hr>
        <div class="row g-3 row-cols-1">
          <div>
            <label for="toll_amount" class="form-label fs-5">Biaya Toll</label>
            <input type="text" id="toll_amount"
              value="{{ $activity->activityStatus->activityPayment->toll_amount }}" name="toll_amount"
              class="form-control form-control-lg form-dark" data="money">
          </div>
          <div>
            <div class="d-flex flex-column">
              <div class="mb-3">
                <label for="toll_img" class="form-label fs-5">Foto Toll</label>
                <input class="form-control form-dark form-control-lg" id="toll_img" name="toll_img" accept="image/*"
                  onchange="previewImage('toll_img')" type="file">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <img src="" style="height: 300px;" class="img-fluid zoom m-auto d-block mw-100"
              id="toll_img-preview" data-action="zoom" alt="">
          </div>
        </div>
      </div>

      <div class="col-xxl-4 col-md-6 order-xl-4">
        <h4 class="text-blue">Park</h4>
        <hr>
        <div class="row g-3 row-cols-1">
          <div>
            <label for="parking_amount" class="form-label fs-5">Biaya Parkir</label>
            <input type="text" id="parking_amount"
              value="{{ $activity->activityStatus->activityPayment->parking_amount }}" name="parking_amount"
              class="form-control form-control-lg form-dark" data="money">
          </div>
          <div>
            <div class="d-flex flex-column">
              <div class="mb-3">
                <label for="parking_img" class="form-label fs-5">Foto Biaya Parkir</label>
                <input class="form-control form-dark form-control-lg" id="parking_img" name="parking_img"
                  accept="image/*" onchange="previewImage('parking_img')" type="file">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <img src="" style="height: 300px;" class="img-fluid zoom m-auto d-block mw-100"
              id="parking_img-preview" data-action="zoom" alt="">
          </div>
        </div>
      </div>
      <div class="col-12 order-last">
        <div class="d-flex">
          <button type="submit" value="submit" id="submit" class="ms-auto d-block btn btn-lg btn-primary"
            button="spinOnClick">
            End Journey
          </button>
        </div>
      </div>

    </div>
  </form>
@endsection
