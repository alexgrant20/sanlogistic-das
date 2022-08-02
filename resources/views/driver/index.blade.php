@extends('driver.layouts.main')

@section('content')
  <div class="container-fluid">
    <div class="row row-cols-2 row-cols-xxl-4 g-5 mb-5">
      @php
        $activityId = is_null(session()->get('activity_id'));
        $activityBg = is_null(session()->get('activity_id')) ? 'bg-blue' : 'bg-green';
        $activityIcon = 'bi' . $activityId ? 'bi-clipboard-plus-fill' : 'bi-flag';
        $activityLink = $activityId ? route('driver.activity.create') : route('driver.activity.edit', session()->get('activity_id'));
      @endphp

      {{-- Activity --}}
      <x-ui.menu-item :backgroundColor="$activityBg" :icon="$activityIcon" :label="__('Activity')" :link="$activityLink" />

      {{-- Location --}}
      <x-ui.menu-item backgroundColor="bg-purplish" icon="bi bi-map" :label="__('Location')" :link="route('driver.menu.location')" />

      {{-- Checklist --}}
      <x-ui.menu-item backgroundColor="bg-brown" icon="bi bi-clipboard-check-fill" :label="__('Checklist')" :link="route('driver.menu.checklist')" />

      {{-- Finance(TODO) --}}
      {{-- <x-ui.menu-item backgroundColor="bg-darkGreen" icon="bi bi-cash-coin" :label="__('Finance')" link="#" /> --}}
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
      <a href="{{ route('driver.activity.index') }}" class="w-100 btn btn-primary"
        style="border-top-left-radius: 0; border-top-right-radius: 0;">
        <span class="fw-bold">See All Activity</span>
      </a>
    @endif
  </div>
@endsection
