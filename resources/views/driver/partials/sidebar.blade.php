<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-body">
    <img class="rounded-circle mb-3"
      src="{{ optional(auth()->user()->person)->image ? asset('/storage/' . auth()->user()->person->image) : asset('/img/default.jpg') }}"
      alt="" width="75" height="75">
    <h4>{{ optional(auth()->user()->person)->name }}</h4>
    <hr class="mb-5">

    <a href="{{ route('index') }}"
      class="d-flex align-items-center mb-4 py-2 px-3 {{ Request::is('/') ? 'bg-primary' : '' }}  fs-4 rounded fw-bold">
      <i class="bi bi-house-door fs-3 me-5"></i>
      Beranda
    </a>

    <a href="{{ route('driver.menu.profile') }}"
      class="d-flex align-items-center mb-4 py-2 px-3 {{ Request::is('driver/profile') ? 'bg-primary' : '' }} fs-4 rounded fw-bold">
      <i class="bi bi-person fs-3 me-5"></i>
      Profil
    </a>

    @can('activity-create')
      <a href="{{ route('driver.activity.index') }}"
        class="d-flex align-items-center mb-4 py-2 px-3 {{ Request::is('driver/activities') ? 'bg-primary' : '' }} fs-4 rounded fw-bold">
        <i class="fa-solid fa-clock-rotate-left fs-3 me-5"></i>
        Riwayat Aktivitas
      </a>

      @php
        $activityId = is_null(session()->get('activity_id'));
      @endphp
      <a href="{{ $activityId ? route('driver.activity.create') : route('driver.activity.edit', session()->get('activity_id')) }}"
        class="d-flex align-items-center mb-4 py-2 px-3 {{ Request::is('driver/activities/*') ? 'bg-primary' : '' }} fs-4 rounded fw-bold">
        <i class="{{ $activityId ? 'bi-clipboard-plus-fill' : 'bi-flag' }} fs-3 me-5"></i>
        Aktivitas
      </a>

      <a href="{{ route('driver.menu.location') }}"
        class="d-flex align-items-center mb-4 py-2 px-3 {{ Request::is('driver/location') ? 'bg-primary' : '' }} fs-4 rounded fw-bold">
        <i class="bi bi-map fs-3 me-5"></i>
        Lokasi Pengantaran
      </a>

      <a href="{{ route('driver.menu.finance') }}"
        class="d-flex align-items-center mb-4 py-2 px-3 {{ Request::is('driver/finance') ? 'bg-primary' : '' }} fs-4 rounded fw-bold">
        <i class="bi bi-cash-coin fs-3 me-5"></i>
        Keuangan
      </a>
    @endcan

    @canany(['checklist-create', 'activity-create'])
      <a href="{{ route('driver.checklists.create') }}"
        class="d-flex align-items-center mb-4 py-2 px-3 {{ Request::is('driver/checklist/create') ? 'bg-primary' : '' }} fs-4 rounded fw-bold">
        <i class="bi bi-clipboard2-check-fill fs-3 me-5"></i>
        Periksa Kendaraan
      </a>
    @endcan

    @can('checklist-view')
      <a href="{{ route('driver.checklists.index') }}"
        class="d-flex align-items-center mb-4 py-2 px-3 {{ Request::is('driver/checklist') ? 'bg-primary' : '' }} fs-4 rounded fw-bold">
        <i class="bi bi-clipboard2-check-fill fs-3 me-5"></i>
        Lihat Hasil Pemeriksaan Kendaraan
      </a>
    @endcan

    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button class="btn fs-4 fw-bold text-white py-2 px-3">
        <i class="bi bi-box-arrow-right fs-3 me-5"></i>
        Logout
      </button>
    </form>
  </div>
</div>
