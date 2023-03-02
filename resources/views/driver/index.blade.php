@extends('driver.layouts.main')

@section('content')
  <section>
    <div class="row row-cols-sm-2 row-cols-xxl-4 gx-5 gy-4">
      @php
        $activityId = is_null(session()->get('activity_id'));
        $activityBg = $activityId ? 'bg-blue' : 'bg-green';
        $activityDesc = $activityId ? 'Track your driving actvitiy' : 'Finalize your activity';
        $activityLabel = $activityId ? 'Create Actvitiy' : 'Finish Actvitiy';
        $activityIcon = 'bi' . $activityId ? 'bi-clipboard-plus-fill' : 'bi-flag';
        $activityLink = $activityId ? route('driver.activity.create') : route('driver.activity.edit', session()->get('activity_id'));
      @endphp

      @can('activity-create')
        {{-- Activity --}}
        <x-ui.menu-item :backgroundColor="$activityBg" :icon="$activityIcon" :label="__($activityLabel)" :description="$activityDesc" :link="$activityLink" />


        {{-- Location --}}
        <x-ui.menu-item backgroundColor="bg-purplish" icon="bi bi-map" :label="__('Location')" description="All delivery locations"
          :link="route('driver.menu.location')" />

        {{-- Location --}}
        <x-ui.menu-item backgroundColor="bg-primary" icon="fa-solid fa-motorcycle" :label="__('Public Transport')"
          description="Only use if using public transport" :link="route('driver.activity.create-gojek')" />

        {{-- Finance --}}
        <x-ui.menu-item backgroundColor="bg-darkGreen" icon="bi bi-cash-coin" :label="__('Finance')"
          description="Payments already paid" :link="route('driver.menu.finance')" />
      @endcan

      @canany(['checklist-create', 'activity-create'])
        {{-- Create Checklist --}}
        <x-ui.menu-item backgroundColor="bg-brown" icon="bi bi-clipboard-check-fill" :label="__('Create Checklist')"
          description="Markdown vehicle condition" :link="route('driver.checklists.create')" />
      @endcanany

      @can('checklist-view')
        {{-- View Checklist --}}
        <x-ui.menu-item backgroundColor="bg-brown" icon="fa-solid fa-timeline" :label="__('View Checklist')"
          description="View your checklist history" :link="route('driver.checklists.index')" />
      @endcan

    </div>
  </section>

  @can('activity-create')
    @if (!is_null($activity))
      <section>
        <h2 class="fs-3 mb-4 text-ocean-100">Recent Activity</h2>
        <div class="bg-dash-dark-3 p-3 rounded">
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
      </section>
    @endif
  @endcan

@endsection
