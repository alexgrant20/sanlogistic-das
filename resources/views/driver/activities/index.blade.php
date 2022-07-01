@extends('driver.layouts.main')

@section('content')
  <div class="row gy-5">
    @forelse ($activities as $activity)
      <div class="col-xxl-4">
        <div class="card rounded">
          <div class="card-header rounded">
            <div class="d-flex justify-content-between">
              <span class="text-muted">{{ __('Departure Date') }}</span>
              <span class="text-muted">{{ __('Arrival Date') }}</span>
            </div>
            <div class="row align-items-center mb-2">
              <div class="col-6 text-truncate">
                {{ $activity->departure_date }}
              </div>
              <div class="col-6 text-end text-truncate @if (!$activity->arrival_date) text-danger @endif">
                {{ $activity->arrival_date ?? 'On Going' }}
              </div>
            </div>
            <div class="row align-items-center">
              <div class="col-5 fs-5 fw-bolder text-truncate">
                {{ $activity->departure_name }}
              </div>
              <div class="col-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-arrow-right-long fa-2x"></i>
              </div>
              <div class="col-5 text-end fs-5 fw-bolder text-truncate">
                {{ $activity->arrival_name }}
              </div>
            </div>
          </div>
          <div class="card-body border-top border-gray">
            <div class="row align-items-center gy-3">
              <div class="col-4">
                <div class="fs-6">{{ __('Status') }}</div>
                <div class="badge rounded-pill text-uppercase {{ $activity->activityStatusColor ?? 'bg-primary' }}">
                  {{ $activity->status }}
                </div>
              </div>
              <div class="col-4">
                <div class="fs-6 w-100 text-truncate text-center">{{ __('DO Number') }}</div>
                <div class="w-100 text-truncate text-center">{{ $activity->do_number }}</div>
              </div>
              <div class="col-4">
                <div class="fs-6 w-100 text-truncate text-end">Total Cost</div>
                <div class="fs-3 w-100 text-truncate text-end">Rp
                  {{ $activity->total_cost ? number_format($activity->total_cost, 0, ',', '.') : 0 }}</div>
              </div>
              <div class="col-6 d-flex align-items-center justify-content-center">
                <i class="bi bi-geo-alt fs-1"></i>
                <div class="ms-2 text-truncate">
                  <div class="text-muted text-truncate">Total Distance</div>
                  <div class="fw-bold text-truncate @if (!$activity->distance) text-danger @endif">
                    {{ $activity->distance ? number_format($activity->distance, 0, ',', '.') . ' Km' : 'On Going' }}
                  </div>
                </div>
              </div>
              <div class="col-6 d-flex align-items-center justify-content-center">
                <i class="bi bi-truck fs-1"></i>
                <div class="ms-2 text-truncate">
                  <div class="text-muted text-truncate">License Plate</div>
                  <div class="fw-bold text-truncate">
                    {{ $activity->license_plate }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col card bg-dash-dark-3">
        <div class="card-body text-center">
          <i class="fa-solid fa-heart-crack fa-3x fa-beat text-primary mb-3"></i>
          <h1>No <span class="text-primary">Activity</span></h1>
          <p>No Activity, Go Create One Right Now!</p>
        </div>
      </div>
    @endforelse
    {{ $activities->links() }}
  </div>
@endsection
