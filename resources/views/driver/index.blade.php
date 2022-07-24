@extends('driver.layouts.main')

@section('content')
  <div class="container-fluid">
    <div class="row row-cols-sm-12 row-cols-md-12 row-cols-xxl-12 g-4">
      <x-menu-item>
        <x-slot name="backgroundColor">{{ is_null(session()->get('activity_id')) ? 'bg-blue' : 'bg-green' }}</x-slot>
        <x-slot name="icon">{{ is_null(session()->get('activity_id')) ? 'bi-clipboard-plus-fill' : 'bi-flag' }}
        </x-slot>
        <x-slot name="text">Activity</x-slot>
        <x-slot name="link">
          {{ is_null(session()->get('activity_id')) ? '/driver/activities/create' : '/driver/activities/' . session()->get('activity_id') . '/edit' }}
        </x-slot>
      </x-menu-item>
      {{-- TO-DO --}}
      {{-- <x-menu-item>
        <x-slot name="backgroundColor">bg-brown</x-slot>
        <x-slot name="icon">bi-clipboard2-check-fill</x-slot>
        <x-slot name="text">Checklist</x-slot>
        <x-slot name="link">#</x-slot>
      </x-menu-item> --}}
      <div>
        <div class="card bg-dash-dark-3">
          <div class="card-body">
            <span class="text-bold fs-4 fw-bold">Last Activity</span>
            <hr>
            @forelse ($activities as $activity)
              <div class="d-flex justify-content-between">
                @if ($activity->arrival_date)
                  <span class="text-muted">{{ __('Arrival Date') }}</span>
                @else
                  <span class="text-muted">{{ __('Departure Date') }}</span>
                @endif
              </div>
              <div class="mb-2">
                @if ($activity->arrival_date)
                  {{ \Carbon\Carbon::parse($activity->arrival_date)->diffForHumans() }}
                @else
                  {{ \Carbon\Carbon::parse($activity->departure_date)->diffForHumans() }}
                @endif
              </div>
              <div class="text-center">
                <div class="fs-5 fw-bolder text-truncate">
                  {{ $activity->departureLocation->name }}
                </div>
                <div class="d-flex align-items-center justify-content-center">
                  <i class="fa-solid fa-truck-arrow-right fa-2x"></i>
                </div>
                <div class=" fs-5 fw-bolder text-truncate text-primary">
                  {{ $activity->arrivalLocation->name }}
                </div>
              </div>
              <div class="mt-2">
                <div class="fs-6">{{ __('Status') }}</div>
                <div class="badge fs-6 rounded-pill text-uppercase {{ $activity->activityStatusColor ?? 'bg-primary' }}">
                  {{ $activity->activityStatus->status }}
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
            @if ($activities->isNotEmpty())
              <hr>
              <div class="mt-3">
                {{ $activities->links('pagination::bootstrap-4') }}
              </div>
            @endif
          </div>
        </div>
      </div>
      {{-- TO-DO --}}
      {{-- <x-menu-item>
        <x-slot name="backgroundColor">bg-darkGreen</x-slot>
        <x-slot name="icon">bi-cash-coin</x-slot>
        <x-slot name="text">Keuangan</x-slot>
        <x-slot name="link">#</x-slot>
      </x-menu-item> --}}
      <x-menu-item>
        <x-slot name="backgroundColor">bg-green</x-slot>
        <x-slot name="icon">bi-map</x-slot>
        <x-slot name="text">{{ __('All Location') }}</x-slot>
        <x-slot name="link">{{ route('driver.menu.location') }}</x-slot>
      </x-menu-item>
    </div>
  </div>
@endsection
