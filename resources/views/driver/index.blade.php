@extends('driver.layouts.main')

@section('title', 'Beranda')

@section('content')
   <section>
      <div class="row row-cols-sm-2 row-cols-xxl-4 gx-5 gy-4">
         @php
            $isActivityActive = session()->get('activity_id');
            $activityBg = $isActivityActive ? 'bg-green' : 'bg-blue';
            $activityDesc = $isActivityActive ? 'Akhiri Aktivitas Mengendarai Anda Disini' : 'Buatlah Aktivitas Mengendarai Anda Disini';
            $activityLabel = $isActivityActive ? 'Selesaikan Aktivitas' : 'Buat Aktivitas';
            $activityIcon = 'bi' . $isActivityActive ? 'bi-flag' : 'bi-clipboard-plus-fill';
            $activityLink = $isActivityActive ? route('driver.activity.edit', session()->get('activity_id')) : route('driver.activity.create');
         @endphp

         @can('activity-create')
            <x-ui.menu-item :backgroundColor="$activityBg" :icon="$activityIcon" :label="__($activityLabel)" :description="$activityDesc" :link="$activityLink" />

            <x-ui.menu-item backgroundColor="bg-purplish" icon="bi bi-map" label="Lokasi Pengantaran"
               description="Seluruh Lokasi Pengantaran" :link="route('driver.menu.location')" />

            @if (!$isActivityActive)
               <x-ui.menu-item backgroundColor="bg-primary" icon="fa-solid fa-motorcycle" label="Kendaraan Umum"
                  description="Aktivitas Dengan Kendaraan Umum" :link="route('driver.activity.create-public-transport')" />
            @endif

            <x-ui.menu-item backgroundColor="bg-darkGreen" icon="bi bi-cash-coin" label="Keuangan"
               description="Rincian Aktivitas Yang Sudah Terbayar" :link="route('driver.menu.finance')" />
         @endcan

         @canany(['checklist-create', 'activity-create'])
            <x-ui.menu-item backgroundColor="bg-brown" icon="bi bi-clipboard-check-fill" label="Daftar Periksa Kendaraan"
               description="Buatlah Ceklist Kendaraan" :link="route('driver.checklists.create')" />
         @endcanany

         @can('checklist-view')
            <x-ui.menu-item backgroundColor="bg-brown" icon="fa-solid fa-timeline" :label="__('View Checklist')"
               description="View your checklist history" :link="route('driver.checklists.index')" />
         @endcan

      </div>
   </section>

   @can('activity-create')
      @if (!is_null($activity))
         <section>
            <h2 class="fs-3 mb-4 text-ocean-100">Aktivitas Terbaru</h2>
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
                        <div class="text-muted">Waktu Kedatangan</div>
                        <div class="text-muted">{{ \Carbon\Carbon::parse($activity->arrival_date)->diffForHumans() }}</div>
                     @else
                        <div class="text-muted">Waktu Keberangkatan</div>
                        <div class="text-muted">{{ \Carbon\Carbon::parse($activity->departure_date)->diffForHumans() }}</div>
                     @endif
                  </div>
               </div>
            </div>
            <a href="{{ route('driver.activity.index') }}" class="w-100 btn btn-primary"
               style="border-top-left-radius: 0; border-top-right-radius: 0;">
               <span class="fw-bold">Lihat Semua Aktivitas</span>
            </a>
         </section>
      @endif
   @endcan

   @if ($mypertamina && $isActivityActive)
      <section>
         <div class="card">
            <div class="card-body">
               <h2 class="fs-3 mb-4 text-ocean-100">QR MyPertamina</h2>
               <img class="w-100" src="{{ asset('storage/' . $mypertamina) }}" alt="" style="aspect-ratio:1; max-width: 500px">
            </div>
         </div>
      </section>
   @endif

@endsection
