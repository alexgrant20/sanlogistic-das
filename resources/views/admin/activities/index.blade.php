@extends('admin.layouts.index')

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Activities</h2>
      </div>
    </div>
    <section class="container-fluid">
      <div class="row mb-4 g-3">
        <x-summary-box summaryTitle="Total Activity" summaryTotal="{{ $activities->count() }}" icon="bi bi-journal-text"
          id="total-activity" link="{{ route('admin.activities.index') }}" :active="empty(Request::getQueryString()) ? true : false" />

        <x-summary-box summaryTitle="On Going"
          summaryTotal="{{ $activities->filter(fn($item) => $item->status === 'draft')->count() }}"
          icon="bi bi-journal-arrow-up" id="total-ongoing-activity"
          link="{{ route('admin.activities.index') . '?status=draft' }}" :active="Request::getQueryString() === 'status=draft' ? true : false" />

        <x-summary-box summaryTitle="Pending"
          summaryTotal="{{ $activities->filter(fn($item) => $item->status === 'pending')->count() }}"
          icon="bi bi-journal-medical" id="total-pending-activity"
          link="{{ route('admin.activities.index') . '?status=pending' }}" :active="Request::getQueryString() === 'status=pending' ? true : false" />

        <x-summary-box summaryTitle="Approved"
          summaryTotal="{{ $activities->filter(fn($item) => $item->status === 'approved')->count() }}"
          icon="bi bi-journal-check" id="total-approved-activity"
          link="{{ route('admin.activities.index') . '?status=approved' }}" :active="Request::getQueryString() === 'status=approved' ? true : false" />

        <x-summary-box summaryTitle="Rejected"
          summaryTotal="{{ $activities->filter(fn($item) => $item->status === 'rejected')->count() }}"
          icon="bi bi-journal-x" id="total-rejected-activity"
          link="{{ route('admin.activities.index') . '?status=rejected' }}" :active="Request::getQueryString() === 'status=rejected' ? true : false" />

        <x-summary-box summaryTitle="Paid"
          summaryTotal="{{ $activities->filter(fn($item) => $item->status === 'paid')->count() }}"
          icon="bi bi-wallet-fill" id="total-paid-activity" link="{{ route('admin.activities.index') . '?status=paid' }}"
          :active="Request::getQueryString() === 'status=paid' ? true : false" />
      </div>

      @include('admin.partials.import')

      @if (session()->has('log_data'))
        <x-modal id="my-modal" title="Activity Log" class="openModal" size="modal-lg">
          <x-slot:body>
            <table class="table table-hover table-dark text-center nowrap" style="widths: 100%">
              <tr>
                <th>Status</th>
                <th>By</th>
                <th>Time</th>
                <th>Role</th>
              </tr>
              @foreach (session('log_data') as $log)
                <tr>
                  <td>{{ $log->status }}</td>
                  <td>{{ $log->name }}</td>
                  <td>{{ $log->created_at }}</td>
                  <td>{{ $log->role }}</td>
                </tr>
              @endforeach
            </table>
          </x-slot:body>
          <x-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </x-slot:footer>
        </x-modal>
      @endif

      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <input type="hidden" id="tableName" value="activities">
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <div class="table-responsive">
        <table class="table table-striped table-dark text-center" data-display="datatables">
          <thead>
            <tr class="header">
              <th>ID</th>
              <th></th>
              <th></th>
              <th>Tanggal</th>
              <th>Nama Pengendara</th>
              <th>Nomor Kendaraan</th>
              <th>Nomor DO</th>
              <th>Lokasi Keberangkatan</th>
              <th>Lokasi Tujuan</th>
              <th>Jenis Aktifitas</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($activities_filtered as $activity)
              <tr>
                <td>{{ $activity->id }}</td>
                <td></td>
                <td>
                  <div class="dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu">
                      @can('activity-edit')
                        <li>
                          <a href="{{ route('admin.activities.edit', $activity->id) }}" class="dropdown-item">
                            Edit
                          </a>
                        </li>
                      @endcan
                      <li>
                        <a href="{{ route('admin.activities.logs', $activity->id) }}" class="dropdown-item">
                          History Log
                        </a>
                      </li>
                    </ul>
                  </div>
                </td>
                <td>{{ $activity->departure_date }}</td>
                <td>{{ $activity->person_name }}</td>
                <td>{{ $activity->license_plate }}</td>
                <td>{{ $activity->do_number }}</td>
                <td>{{ $activity->departure_name }}</td>
                <td>{{ $activity->arrival_name }}</td>
                <td>{{ $activity->type }}</td>
                <td>{{ $activity->status }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>
  </div>
@endsection
