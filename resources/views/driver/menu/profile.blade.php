@extends('driver.layouts.main')

@section('content')
  <div class="card text-center bg-dash-dark-3">
    <div class="card-header d-flex justify-content-between align-items-center bg-dash-dark-3 border-bottom">
      <img
        src="{{ $personImage ? asset("/storage/$personImage") : 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6c/No_image_3x4.svg/1280px-No_image_3x4.svg.png' }}"
        class="rounded-circle shadow" alt="" width="75" height="75">
      <span class="fs-3">{{ auth()->user()->person->name }}</span>
    </div>
    <div class="card-body">
      <div class="row gy-4">
        <div class="col-xl-4">
          <div class="fs-4 mb-2 fw-bold text-white">{{ __('Address') }}</div>
          <div class="fs-4 text-truncate">
            {{ auth()->user()->person->full_address }}
          </div>
        </div>
        <div class="col-xl-4">
          <div class="fs-4 mb-2 fw-bold text-white">{{ __('Sim Number') }}</div>
          <div class="fs-4 text-truncate">
            @if ($sim)
              {{ $sim->number }}
            @else
              <span class="text-white">
                {{ __('No Data') }}
              </span>
            @endif
          </div>
        </div>
        <div class="col-xl-4 pb-2">
          <div class="fs-4 mb-2 fw-bold text-white">{{ __('Sim Expire') }}</div>
          <div class="fs-4 text-truncate">
            @if ($sim)
              {{ $sim->expire }}
            @else
              <span class="text-white">
                {{ __('No Data') }}
              </span>
            @endif
          </div>
        </div>
        <div class="col-xl-4">
          <div class="fs-4 mb-2 fw-bold text-white">{{ __('Sim Image') }}</div>
          <img
            src="{{ $sim ? asset("/storage/$sim->image") : 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6c/No_image_3x4.svg/1280px-No_image_3x4.svg.png' }}"
            class="img-fluid rounded shadow" alt="">
        </div>
      </div>
    </div>
  </div>
@endsection
