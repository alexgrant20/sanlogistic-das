@extends('driver.layouts.main')

@section('content')
  <div class="container-fluid">
    <div class="row row-cols-2 row-cols-xxl-4 g-5 mb-5">
      <x-menu-item>
        <x-slot name="backgroundColor">{{ is_null(session()->get('activity_id')) ? 'bg-blue' : 'bg-green' }}</x-slot>
        <x-slot name="icon">{{ is_null(session()->get('activity_id')) ? 'bi-clipboard-plus-fill' : 'bi-flag' }}
        </x-slot>
        <x-slot name="text">Activity</x-slot>
        <x-slot name="link">
          {{ is_null(session()->get('activity_id')) ? '/driver/activities/create' : '/driver/activities/' . session()->get('activity_id') . '/edit' }}
        </x-slot>
      </x-menu-item>
      <x-menu-item>
        <x-slot name="backgroundColor">bg-purplish</x-slot>
        <x-slot name="icon">bi-map</x-slot>
        <x-slot name="text">{{ __('Location') }}</x-slot>
        <x-slot name="link">{{ route('driver.menu.location') }}</x-slot>
      </x-menu-item>
      {{-- TO-DO --}}
      <x-menu-item>
        <x-slot name="backgroundColor">bg-brown</x-slot>
        <x-slot name="icon">bi-clipboard2-check-fill</x-slot>
        <x-slot name="text">{{ __('Checklist') }}</x-slot>
        <x-slot name="link">#</x-slot>
      </x-menu-item>
      {{-- TO-DO --}}
      <x-menu-item>
        <x-slot name="backgroundColor">bg-darkGreen</x-slot>
        <x-slot name="icon">bi-cash-coin</x-slot>
        <x-slot name="text">{{ __('Finance') }}</x-slot>
        <x-slot name="link">#</x-slot>
      </x-menu-item>
    </div>
    @if (!is_null($activity))
      <div class="bg-dash-dark-3 p-3 rounded">
        <span class="text-bold fs-4 fw-bold">Last Activity</span>
        <hr>
        <div class="text-center mb-3">
          <div class="fs-5 fw-bolder text-truncate">
            {{ $activity->departureLocation->name }}
          </div>
          <div class="m-auto my-3">
            <i class="fa-solid fa-truck-arrow-right fa-2x"></i>
          </div>
          <div class=" fs-5 fw-bolder text-truncate">
            {{ $activity->arrivalLocation->name }}
          </div>
        </div>
        <div class="d-flex justify-content-between">
          <div>
            <div>{{ __('Status') }}</div>
            <div class="">
              {{ ucfirst($activity->activityStatus->status) }}
            </div>
          </div>
          <div>
            @if ($activity->arrival_date)
              <div class="text-muted">{{ __('Arrival Date') }}</div>
              <div class="text-muted">{{ \Carbon\Carbon::parse($activity->arrival_date)->diffForHumans() }}</div>
            @else
              <div class="text-muted">{{ __('Departure Date') }}</div>
              <div class="text-muted">{{ \Carbon\Carbon::parse($activity->departure_date)->diffForHumans() }}</div>
            @endif
          </div>
        </div>

      </div>
      <a href="{{ route('driver.activity.index') }}" class="w-100 btn btn-info"
        style="border-top-left-radius: 0; border-top-right-radius: 0;">
        <span class="fw-bold">See All Activity</span>
      </a>
    @endif
  </div>
@endsection
