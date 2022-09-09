@extends('admin.layouts.main')

@php
function checkChecklist($checklist)
{
    if (gettype($checklist) !== 'integer') {
        return ['text-warning', 'Error'];
    }
    $label = $checklist == 1 ? 'fa-x' : 'fa-check';
    $textColor = $checklist == 1 ? 'text-red-400' : 'text-green-400';

    return [$textColor, $label];
}

@endphp

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">
          Vehicle Last Status
        </h2>
      </div>
    </div>
    <section class="container-fluid">
      <div class="row gy-3 mb-5">
        <div class="col-md-4">
          <div class="card rounded">
            <div class="card-body">
              <div class="row gy-3">
                <div class="col-3">
                  <i class="bi bi-kanban display-5 text-gray-700"></i>
                </div>
                <div class="col-9 text-end">
                  <p class="text-gray-600 text-uppercase fs-6 mb-0">License Plate</p>
                  <p class="fs-4 mb-0 text-gray-500 text-truncate"> {{ $vehicle->license_plate }} </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card rounded">
            <div class="card-body">
              <div class="row gy-3">
                <div class="col-3">
                  <i class="bi bi-speedometer2 display-5 text-gray-700"></i>
                </div>
                <div class="col-9 text-end">
                  <p class="text-gray-600 text-uppercase fs-6 mb-0">Odo</p>
                  <p class="fs-4 mb-0 text-gray-500 text-truncate">{{ $vehicle->odo }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card rounded">
            <div class="card-body">
              <div class="row gy-3">
                <div class="col-3">
                  <i class="bi bi-geo-alt display-5 text-gray-700"></i>
                </div>
                <div class="col-9 text-end">
                  <p class="text-gray-600 text-uppercase fs-6 mb-0">Lokasi</p>
                  <p class="fs-4 mb-0 text-gray-500 text-truncate">{{ $vehicle->address->name }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-4 flex-1">
          <div class="card rounded h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                  <p class="fs-4 text-gray-600">Vehicle condition is</p>
                  <p class="text-{{ $okItemPercentage == 100 ? 'green' : 'red' }}-700 fs-3 fw-bold mb-0">
                    {{ $okItemPercentage == 100 ? 'Good' : 'Critical' }}
                  </p>
                </div>
                <div class="display-4 fw-bold text-light">
                  {{ $okItemPercentage }}%
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-8">
          <div class="card rounded">
            <div class="card-body">
              <p class="fs-6 text-gray-600 text-uppercase">Latest Report Condition</p>
              <div class="row g-5 mb-4">
                <div class="col-auto">
                  <div class="mb-1 fs-6 text-primary text-uppercase">Lampu</div>
                  <div class="fs-5 text-gray-500 fw-bold">{{ $latestSummary['lamp'] }}%</div>
                </div>
                <div class="col-auto">
                  <div class="mb-1 fs-6 text-primary text-uppercase">Oil</div>
                  <div class="fs-5 text-gray-500 fw-bold">{{ $latestSummary['oil'] }}%</div>
                </div>
                <div class="col-auto">
                  <div class="mb-1 fs-6 text-primary text-uppercase">Ban</div>
                  <div class="fs-5 text-gray-500 fw-bold">{{ $latestSummary['tire'] }}%</div>
                </div>
                <div class="col-auto">
                  <div class="mb-1 fs-6 text-primary text-uppercase">Velg</div>
                  <div class="fs-5 text-gray-500 fw-bold">{{ $latestSummary['velg'] }}%</div>
                </div>
                <div class="col-auto">
                  <div class="mb-1 fs-6 text-primary text-uppercase">Ban(P)</div>
                  <div class="fs-5 text-gray-500 fw-bold">{{ $latestSummary['tirePreasure'] }}%</div>
                </div>
                <div class="col-auto">
                  <div class="mb-1 fs-6 text-primary text-uppercase">Kaca</div>
                  <div class="fs-5 text-gray-500 fw-bold">{{ $latestSummary['glass'] }}%</div>
                </div>
                <div class="col-auto">
                  <div class="mb-1 fs-6 text-primary text-uppercase">Other(O)</div>
                  <div class="fs-5 text-gray-500 fw-bold">{{ $latestSummary['otherOutside'] }}%</div>
                </div>
                <div class="col-auto">
                  <div class="mb-1 fs-6 text-primary text-uppercase">Other(I)</div>
                  <div class="fs-5 text-gray-400 fw-bold">{{ $latestSummary['otherInside'] }}%</div>
                </div>
              </div>
              <div class="text-center">
                <a href="{{ route('admin.vehicles-checklists.show', $latestVehicleChecklist['id']) }}"
                  class="text-gray-500 fs-6 link">See
                  All Report <i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-4">
        @foreach ($lastStatusesData as $key => $lastStatusData)
          @php
            $summary = $lastStatusData['summary'];
            $config = $lastStatusData['config'];
          @endphp
          <div class="col-sm-12 col-md-6 col-xl-6 col-xxl-4 flex-1" @class([
              'order-1' => $summary['broken'],
          ])>
            <div class="card rounded h-100">
              <div class="card-header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div>
                    <i class="{{ $config['icon'] }} fs-1 mb-3"></i>
                    <h3 class="fs-3">{{ $key }}</h3>
                  </div>
                  @if ($summary['broken'])
                    <div class="text-warning d-flex align-items-end">
                      <i class="fa-solid fa-triangle-exclamation fs-3 me-1"></i>
                      <span class="fs-6 fw-bold">Repair Immediately</span>
                    </div>
                  @endif
                </div>
                <div class="progress">
                  <div class="progress-bar bg-success fs-6" role="progressbar"
                    style="width: {{ getPercentage($summary['ok'], $summary['total']) }}%" aria-valuenow="11"
                    aria-valuemin="0" aria-valuemax="100">
                    @if ($summary['ok'] != 0)
                      {{ getPercentage($summary['ok'], $summary['total']) }}%
                    @endif
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row g-3">
                  @foreach ($lastStatusData['items'] as $key => $lastStatus)
                    @php
                      $checklistVal = checkChecklist($lastStatus);
                      $order = $lastStatus == 1 ? '1' : '2';
                    @endphp
                    <div class="col-12 d-flex justify-content-between order-{{ $order }}">
                      <span class="text-red-100">{{ ucwords(Str::replace('_', ' ', $key)) }}</span>
                      <span class="{{ $checklistVal[0] }}">
                        <i class="fa-solid {{ $checklistVal[1] }} fs-4"></i>
                      </span>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </section>
  </div>
@endsection
