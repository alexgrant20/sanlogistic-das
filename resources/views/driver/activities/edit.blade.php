@extends('driver.layouts.main')

@section('content')
  <x-modal id="assure-modal" size="modal-lg">
    <x-slot:body>
      <div>
        <p class="fs-2 fw-bold text-center">Summary</p>
        <div class="row g-4 mb-5">
          <div class="col-xl-6">
            <div class="d-flex align-items-center p-2 gap-3 rounded" style="background-color: #495057;">
              <div class="rounded-circle d-flex align-items-center justify-content-center p-2"
                style="background-color: #212529">
                <i class="fa-solid fa-plane-departure text-gray-500" style="width: 30px; height: 30px;"></i>
              </div>
              <div class="d-flex flex-column">
                <span class="fs-5 fw-bold text-ocean-200">Lokasi Awal</span>
                <span class="fs-5 text-gray-500">{{ $activity->departureLocation->name }}</span>
              </div>
            </div>
          </div>
          <div class="col-xl-6">
            <div class="d-flex align-items-center p-2 gap-3 rounded" style="background-color: #495057;">
              <div class="rounded-circle d-flex align-items-center justify-content-center p-2"
                style="background-color: #212529">
                <i class="fa-solid fa-plane-arrival text-gray-500" style="width: 30px; height: 30px;"></i>
              </div>
              <div class="d-flex flex-column">
                <span class="fs-5 fw-bold text-ocean-200">Lokasi Tujuan</span>
                <span class="fs-5 text-gray-500" id="arrival_name"></span>
              </div>
            </div>
          </div>
          <div class="col-xl-6">
            <div class="d-flex align-items-center p-2 gap-3 rounded" style="background-color: #495057;">
              <div class="rounded-circle d-flex align-items-center justify-content-center p-2"
                style="background-color: #212529">
                <i class="fa-solid fa-clock text-gray-500" style="width: 30px; height: 30px;"></i>
              </div>
              <div class="d-flex flex-column">
                <span class="fs-5 fw-bold text-ocean-200">Total Waktu</span>
                <span class="fs-5 text-gray-500">{{ gmdate('H:i:s', $activity->created_at->diffInSeconds(now())) }}
                </span>
              </div>
            </div>
          </div>
          <div class="col-xl-6">
            <div class="d-flex align-items-center p-2 gap-3 rounded" style="background-color: #495057;">
              <div class="rounded-circle d-flex align-items-center justify-content-center p-2"
                style="background-color: #212529">
                <i class="fa-solid fa-rupiah-sign text-gray-500" style="width: 30px; height: 30px;"></i>
              </div>
              <div class="d-flex flex-column">
                <span class="fs-5 fw-bold text-ocean-200">Biaya</span>
                <span class="fs-5 text-gray-500" id="summary_price"></span>
              </div>
            </div>
          </div>
          <div class="col-xl-6">
            <div class="d-flex align-items-center p-2 gap-3 rounded" style="background-color: #495057;">
              <div class="rounded-circle d-flex align-items-center justify-content-center p-2"
                style="background-color: #212529">
                <i class="fa-solid fa-map-location-dot text-gray-500" style="width: 30px; height: 30px;"></i>
              </div>
              <div class="d-flex flex-column">
                <span class="fs-5 fw-bold text-ocean-200">Jarak</span>
                <span class="fs-5 text-gray-500" id="distance"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div>
      </div>
      <div class="d-grid gap-2 w-100">
        <button type="submit" class="btn btn-lg btn-primary" id="submit">{{ __('End Activity') }}</button>
        <button type="button" class="btn btn-lg" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
      </div>
    </x-slot:body>
  </x-modal>
  <section>
    <form action="{{ url('/driver/activities/' . $activity->id) }}" method="POST" enctype="multipart/form-data"
      id="form">
      @csrf
      @method('PUT')

      <div class="row g-5 mb-3">
        <div class="col-xxl-8 col-md-12 order-xl-5">
          <h4>Trip Detail</h4>
          <hr>
          <div class="row g-3">
            <div class="col-md-3">
              <label for="departure_odo" class="form-label fs-5 text-primary">Odometer Awal</label>
              <input type="text" id="departure_odo" value="{{ $activity->departure_odo }}"
                class="form-control form-control-lg form-dark" disabled>
            </div>
            <div class="col-md-3">
              <label for="do_number" class="form-label fs-5 text-primary">Nomer DO</label>
              <input type="text" id="do_number" value="{{ $activity->do_number }}"
                class="form-control form-control-lg form-dark" disabled>
            </div>
            <div class="col-md-3">
              <label for="license_plate" class="form-label fs-5 text-primary">Plat Nomer</label>
              <input type="text" id="license_plate" value="{{ $activity->vehicle->license_plate }}"
                class="form-control form-control-lg form-dark" disabled>
            </div>
            <div class="col-md-3">
              <label for="departure_name" class="form-label fs-5 text-primary">Lokasi Awal</label>
              <input type="text" id="departure_name" value="{{ $activity->departureLocation->name }}"
                class="form-control form-control-lg form-dark" disabled>
            </div>
          </div>

        </div>
        <div class="col-xxl-4 col-md-6 order-xl-1">
          <h4>Data Input</h4>
          <hr>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="arrival_id" class="form-label fs-5 text-primary">Lokasi Tujuan</label>
              <select id="arrival_id" name="arrival_id"
                class="form-dark form-select form-select-lg @error('arrival_id') is-invalid @enderror">
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
              <label for="arrival_odo" class="form-label fs-5 text-primary">Odometer</label>
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
              <x-input-image id="arrival_odo_image" :label="__('ODO Image')" :required="true" />
            </div>
          </div>
        </div>

        <div class="col-xxl-4 col-md-6 order-xl-2">
          <h4>BBM</h4>
          <hr>
          <div class="row g-3 row-cols-1">
            <div>
              <label for="bbm_amount" class="form-label fs-5 text-primary">Jumlah Pembelian BBM</label>
              <input type="text"
                value="{{ old('bbm_amount', $activity->activityStatus->activityPayment->bbm_amount ?? 0) }}"
                id="bbm_amount" name="bbm_amount" class="form-control form-control-lg form-dark" data="money">

              @error('bbm_amount')
                <div class="invalid-feedback d-block">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="col-md-12">
              <x-input-image id="bbm_image" :label="__('BBM Image')" />
            </div>
          </div>
        </div>

        <div class="col-xxl-4 col-md-6 order-xl-3">
          <h4>Toll</h4>
          <hr>
          <div class="row g-3 row-cols-1">
            <div>
              <label for="toll_amount" class="form-label fs-5 text-primary">Biaya Toll</label>
              <input type="text" id="toll_amount"
                value="{{ old('toll_amount', $activity->activityStatus->activityPayment->toll_amount ?? 0) }}"
                name="toll_amount" class="form-control form-control-lg form-dark" data="money">

              @error('toll_amount')
                <div class="invalid-feedback d-block">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-md-12">
              <x-input-image id="toll_image" :label="__('Toll Image')" />
            </div>
          </div>
        </div>

        <div class="col-xxl-4 col-md-6 order-xl-4">
          <h4>Park</h4>
          <hr>
          <div class="row g-3 row-cols-1">
            <div>
              <label for="parking_amount" class="form-label fs-5 text-primary">Biaya Parkir</label>
              <input type="text" id="parking_amount"
                value="{{ old('parking_amount', $activity->activityStatus->activityPayment->parking_amount ?? 0) }}"
                name="parking_amount" class="form-control form-control-lg form-dark" data="money">

              @error('parking_amount')
                <div class="invalid-feedback d-block">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-md-12">
              <x-input-image id="parking_image" :label="__('Parking Image')" />
            </div>
          </div>
        </div>
        <div class="d-grid order-last align-items-center">
          <button type="button" id="modal-opener" class="btn btn-lg btn-primary" data-bs-toggle="modal"
            data-bs-target="#assure-modal">
            {{ __('Submit') }}
          </button>
        </div>
      </div>
    </form>
  </section>
@endsection


@section('footJS')
  <script>
    $('#modal-opener').click(function() {
      const arrival_name = $('#arrival_id').find(':selected').text();
      const departureOdo = Number($('#departure_odo').val());
      const arrivalOdo = Number($('#arrival_odo').val());
      const distance = arrivalOdo - departureOdo;
      let parking = $('#parking_amount').val();
      let toll = $('#toll_amount').val();
      let bbm = $('#bbm_amount').val();

      parking = Number(parking.replaceAll('Rp. ', '').replaceAll('.', ''));
      toll = Number(toll.replaceAll('Rp. ', '').replaceAll('.', ''));
      bbm = Number(bbm.replaceAll('Rp. ', '').replaceAll('.', ''));

      $('#arrival_name').text(arrival_name.trim());
      $('#distance').text(distance <= 0 ? 'Value Incorrect' : distance + ' km');
      $('#summary_price').text(formatIDR(bbm + toll + parking));
    });
  </script>
  {!! JsValidator::formRequest('App\Http\Requests\Driver\UpdateActivityRequestView', 'form') !!}
@endsection
