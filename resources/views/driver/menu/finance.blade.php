@extends('driver.layouts.main')

@section('title', 'Keuangan')

@section('content')
  <section>
    <div class="row g-3 mb-3">
      @forelse ($activities as $activity)
        <div class="col-xl-4">
          <div class="d-flex align-items-center py-2 px-3 gap-3 rounded" style="background-color: #495057;">
            <div class="rounded-circle d-flex align-items-center justify-content-center p-2"
              style="background-color: #212529">
              <i class="fa-solid fa-clipboard-list text-gray-500" style="width: 24px; height: 24px;"></i>
            </div>
            <div class="d-flex justify-content-between w-100">
              <div class="d-flex flex-column">
                <span class="fs-5 fw-bold text-gray-400">Pembayaran Aktivitas</span>
                <span class="fs-5 text-gray-600">Cash</span>
              </div>
              <div class="d-flex flex-column text-end">
                <span class="fs-5 fw-bold text-green-500 text-truncate">Rp.
                  {{ $activity->total_cost ? number_format($activity->total_cost, 0, ',', '.') : 0 }}</span>
                <span class="fs-5 text-gray-300">{{ date('M d, Y', strtotime($activity->updated_at)) }}</span>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col card bg-dash-dark-3">
          <div class="card-body text-center">
            <h1>Tidak Ada <span class="text-primary">Aktivitas</span></h1>
          </div>
        </div>
      @endforelse
    </div>
    {{ $activities->links() }}
  </section>
@endsection
