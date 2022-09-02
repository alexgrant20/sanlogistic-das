@extends('driver.layouts.main')

@section('content')
  @if ($errors->any())
    <div class="alert alert-danger">
      <p><strong>Opps Something went wrong</strong></p>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <x-modal id="assure-modal" size="modal-lg">
    <x-slot:body>
      <div class="d-flex flex-column align-items-center mb-3">
        <i class="bi bi-exclamation-circle display-1 text-warning"></i>
        <p class="display-6 text-white mb-1 fw-bold">{{ __('Are you want to create checklist?') }}</p>
        <p class="fs-3 text-gray-700">You will not able to recover it</p>
      </div>
      <div class="d-grid gap-2 w-100">
        <button type="submit" id="submit" class="btn btn-lg btn-primary">{{ __('Create Checklist') }}</button>
        <button type="button" class="btn btn-lg" data-bs-dismiss="modal">{{ __('Close') }}</button>
      </div>
    </x-slot:body>
  </x-modal>
  <form action="{{ route('driver.checklist.store') }}" enctype="multipart/form-data" method="POST" id="form">
    @csrf
    <div class="mb-5">
      <label for="vehicle_id" class="form-label fs-5 text-primary">Kendaraan</label>
      <select id="vehicle_id" name="vehicle_id" class="form-dark form-select form-select-lg">
        <option value="" hidden>Pilih Kendaraan</option>
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

    @include('driver.components.vehicle-checklist-form')

    <div class="d-grid">
      <button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#assure-modal">
        {{ __('Submit') }}
      </button>
    </div>

  </form>
@endsection

@section('footJS')
  <script>
    $(document).ready(function() {
      let totalImage = 1;
      getVehicleLastStatus()
      $("#add-image").click((e) => {
        totalImage++;
        $("#image-container")
          .last()
          .append(
            `
            <div class="mb-5">
              <x-input-image id="image_${totalImage}" :label="__('Image')" />
              <div class="mt-5">
                <label class="form-label fs-5 text-primary" for="image_${totalImage}_description">{{ __('Image Description') }}</label>
                <textarea class="form-control" name="image_${totalImage}_description" id="image_${totalImage}_description"></textarea>
              </div>
            </div>
          `
          );

        // Check if exeeding
        if (totalImage === 4) {
          $("#add-image").remove();
          return;
        }
      });
    });
  </script>
@endsection
