<div class="col-xl-12 row gy-5">
  <div class="col-xl-4">
    <h4>Pilih Kendaraan</h4>
    <hr>
    <label for="vehicle_id" class="form-label fs-5 text-primary">Pilih Kendaraan</label>
    <select id="vehicle_id" name="vehicle_id"
      class="form-dark form-select form-select-lg @error('vehicle_id') is-invalid @enderror" wire:model="vehicleId">
      <option value="" hidden>Pilih Kendaraan</option>
      @foreach ($vehicles as $vehicle)
        <option value="{{ $vehicle->id }}">{{ $vehicle->license_plate }}</option>
      @endforeach
    </select>

    @error('vehicle_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="col-xl-4">
    <h4>Detail Kendaraan</h4>
    <hr>
    <div class="row g-3">
      <input type="hidden" id="departure_location_id" name="departure_location_id"
        value="{{ $departureAddress->id ?? null }}">
      <div class="col-md-6">
        <label for="odo" class="form-label fs-5 text-primary">Odometer Awal</label>
        <input type="number" value="{{ $odo }}" name="departure_odo" id="odo"
          class="form-control form-control-lg form-dark" readonly>
      </div>
      <div class="col-md-6">
        <label for="departure_location_name" class="form-label fs-5 text-primary">Lokasi Awal</label>
        <input type="text" id="departure_location_name" value="{{ $departureAddress->name ?? null }}"
          class="form-control form-control-lg form-dark" disabled>
      </div>
    </div>
  </div>

  <div class="col-xl-4">
    <h4>Masukan Data</h4>
    <hr>
    <div class="row g-3">
      <div class="col-md-6">
        <label for="do_number" class="form-label fs-5 text-primary">Nomor DO</label>
        <input type="text" id="do_number" name="do_number" value="{{ old('do_number') }}"
          class="form-control form-control-lg form-dark @error('do_number') is-invalid @enderror" wire:model="doNumber"
          wire:loading.attr="disabled" wire:target="vehicleId">

        @error('do_number')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      @if (!is_null($arrivalAddressLists))
        <div class="col-md-6">
          <label for="arrival_location_id" class="form-label fs-5 text-primary">Lokasi Akhir</label>
          <select id="arrival_location_id" name="arrival_location_id"
            class="select2 form-dark form-select form-select-lg @error('arrival_location_id') is-invalid @enderror"
            wire:loading.attr="disabled" wire:target="vehicleId">
            <option value="" hidden>Pilih Lokasi Akhir</option>
            @foreach ($arrivalAddressLists as $arrivalAddress)
              <option value="{{ $arrivalAddress->address->id }}" @if ($arrivalAddress->address->id == old('arrival_location_id')) selected @endif>
                {{ $arrivalAddress->address->name }}
            @endforeach
          </select>

          @error('arrival_location_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      @endif
    </div>
  </div>
</div>
