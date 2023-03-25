@extends('driver.layouts.main')

@section('content')
  <x-modal id="assure-modal" size="modal-lg">
    <x-slot:body>
      <div class="d-flex flex-column align-items-center mb-3">
        <i class="bi bi-exclamation-circle display-1 text-warning"></i>
        <p class="display-6 text-white mb-1 fw-bold">{{ __('Are you want to create activity?') }}</p>
        <p class="fs-3 text-gray-600">{{ __('Make sure all the data is correct') }}</p>
      </div>
      <div class="d-grid gap-2 w-100">
        <button type="submit" id="submit" class="btn btn-lg btn-primary">{{ __('Create Activity') }}</button>
        <button type="button" class="btn btn-lg" data-bs-dismiss="modal">{{ __('Close') }}</button>
      </div>
    </x-slot:body>
  </x-modal>
  <section>
    <form method="POST" action="{{ route('driver.activity.store-gojek') }}" enctype="multipart/form-data" id="form">
      @csrf

      <div class="row gy-5 mb-5">

        <div class="col-md-6">
          <label for="departure_location_id" class="form-label fs-5 text-primary">Lokasi Awal</label>
          <input type="hidden" name="departure_location_id" value="{{ \Crypt::encryptString($departureAddress->id) }}">
          <input type="text" value="{{ $departureAddress->name }}" class="form-control form-control-lg form-dark w-100"
            disabled>
          @error('departure_location_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="arrival_location_id" class="form-label fs-5 text-primary">Lokasi Akhir</label>
          <div style="flex-grow: 1">
            <select id="arrival_location_id" name="arrival_location_id"
              class="form-dark form-select form-select-lg @error('arrival_location_id') is-invalid @enderror">
              <option value="" hidden>Pilih Lokasi Akhir</option>
              @foreach ($arrivalAddresses as $arrivalAddress)
                <option value="{{ $arrivalAddress->address->id }}" @if ($arrivalAddress->address->id == old('arrival_location_id')) selected @endif>
                  {{ $arrivalAddress->address->name }}
              @endforeach
            </select>
          </div>

          @error('arrival_location_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-12">
          <div class="d-grid">
            <button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#assure-modal">
              {{ __('Submit') }}
            </button>
          </div>
        </div>
      </div>
    </form>
  </section>
@endsection

@section('footJS')
@endsection
