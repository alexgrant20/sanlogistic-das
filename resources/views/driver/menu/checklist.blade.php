@extends('driver.layouts.main')

@section('content')
  <div class="mb-3">
    <label for="vehicle_id" class="form-label fs-5 text-primary">Kendaraan</label>
    <select id="vehicle_id" name="vehicle_id" class="form-dark form-select form-select-lg">
      <option value="">Pilih Kendaraan</option>
      @foreach ($vehicles as $vehicle)
        <option value="{{ $vehicle->id }}">{{ $vehicle->license_plate }}</option>
      @endforeach
    </select>

    @error('vehicle_id')
      <div class="invalid-feedback d-block">
        {{ $message }}
      </div>
    @enderror
  </div>
@endsection
