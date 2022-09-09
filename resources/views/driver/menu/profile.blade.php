@extends('driver.layouts.main')

@section('content')
  <section>
    <div class="card text-center bg-dash-dark-3 rounded">
      <div class="card-header d-flex justify-content-between align-items-center bg-dash-dark-3 rounded">
        <img src="{{ $personImage ? asset('/storage/' . $personImage) : asset('/img/default.jpg') }}"
          class="rounded-circle shadow" alt="" width="75" height="75">
        <span class="fs-3">{{ auth()->user()->person->name }}</span>
      </div>
      <div class="card-body border-top pt-5">
        <div class="row gy-4">
          <div class="col-xl-4">
            <div class="fs-4 mb-2 fw-bold ">{{ __('Sim Number') }}</div>
            <div class="fs-4 text-truncate">
              @if ($sim)
                {{ $sim->number }}
              @else
                <span>
                  {{ __('No Data') }}
                </span>
              @endif
            </div>
          </div>
          <div class="col-xl-4 pb-2">
            <div class="fs-4 mb-2 fw-bold">{{ __('Sim Expire') }}</div>
            <div class="fs-4 text-truncate">
              @if ($sim)
                {{ $sim->expire }}
              @else
                <span>
                  {{ __('No Data') }}
                </span>
              @endif
            </div>
          </div>
          <div class="col-xl-4">
            <div class="fs-4 mb-2 fw-bold ">{{ __('Sim Image') }}</div>
            <img src="{{ $sim ? asset("/storage/$sim->image") : asset('/img/default.jpg') }}"
              class="img-fluid rounded shadow" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
