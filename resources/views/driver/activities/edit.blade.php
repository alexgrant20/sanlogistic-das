@extends('driver.layouts.main')

@section('content')
  <form action="{{ url('/driver/activities/' . $activity->id) }}" method="POST" enctype="multipart/form-data"
    id="form">
    @csrf
    @method('PUT')

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
            <select id="arrival_id" name="arrival_id"
              class="form-dark form-select form-select-lg @error('arrival_id') is-invalid @enderror">
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
              <div class="invalid-feedback d-block">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="col-md-6">
            <label for="arrival_odo" class="form-label fs-5">Odometer</label>
            <input type="number" id="arrival_odo" name="arrival_odo"
              class="form-control form-control-lg form-dark  @error('arrival_odo') is-invalid @enderror"
              value="{{ old('arrival_odo', $activity->arrival_odo) }}"
              onkeypress="return event.keyCode === 8 || event.charCode >= 48 && event.charCode <= 57">

            @error('arrival_odo')
              <div class="invalid-feedback d-block">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="col-md-12">
            @livewire('component.image-input', ['name' => 'arrival_odo_image', 'label' => 'ODO Image'])
          </div>
        </div>
      </div>

      <div class="col-xxl-4 col-md-6 order-xl-2">
        <h4 class="text-blue">BBM</h4>
        <hr>
        <div class="row g-3 row-cols-1">
          <div>
            <label for="bbm_amount" class="form-label fs-5">Jumlah Pembelian BBM</label>
            <input type="text"
              value="{{ old('bbm_amount', $activity->activityStatus->activityPayment->bbm_amount ?? 0) }}"
              id="bbm_amount" name="bbm_amount" class="form-control form-control-lg form-dark" data="money">

            @error('bbm_amount')
              <div class="invalid-feedback d-block">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div>
            <div class="d-flex flex-column">
              <div class="mb-3">
                <label for="bbm_image" class="form-label fs-5">Foto Pembelian BBM</label>
                <input class="form-control form-dark form-control-lg" id="bbm_image" name="bbm_image" accept="image/*"
                  onchange="previewImage('bbm_image')" type="file">

                @error('bbm_image')
                  <div class="invalid-feedback d-block">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <img src="#" style="height: 300px;" class="img-fluid zoom m-auto d-block mw-100" id="bbm_image-preview"
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
              value="{{ old('toll_amount', $activity->activityStatus->activityPayment->toll_amount ?? 0) }}"
              name="toll_amount" class="form-control form-control-lg form-dark" data="money">

            @error('toll_amount')
              <div class="invalid-feedback d-block">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div>
            <div class="d-flex flex-column">
              <div class="mb-3">
                <label for="toll_image" class="form-label fs-5">Foto Toll</label>
                <input class="form-control form-dark form-control-lg" id="toll_image" name="toll_image"
                  accept="image/*" onchange="previewImage('toll_image')" type="file">
                @error('toll_image')
                  <div class="invalid-feedback d-block">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <img src="" style="height: 300px;" class="img-fluid zoom m-auto d-block mw-100"
              id="toll_image-preview" data-action="zoom" alt="">
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
              value="{{ old('parking_amount', $activity->activityStatus->activityPayment->parking_amount ?? 0) }}"
              name="parking_amount" class="form-control form-control-lg form-dark" data="money">

            @error('parking_amount')
              <div class="invalid-feedback d-block">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div>
            <div class="d-flex flex-column">
              <div class="mb-3">
                <label for="parking_image" class="form-label fs-5">Foto Biaya Parkir</label>
                <input class="form-control form-dark form-control-lg" id="parking_image" name="parking_image"
                  accept="image/*" onchange="previewImage('parking_image')" type="file">

                @error('parking_image')
                  <div class="invalid-feedback d-block">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <img src="" style="height: 300px;" class="img-fluid zoom m-auto d-block mw-100"
              id="parking_image-preview" data-action="zoom" alt="">
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

@section('footJS')
  {{-- <script src="{{ asset('/js/driver/activity/edit.js') }}"></script> --}}
@endsection
