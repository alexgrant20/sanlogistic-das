@extends('admin.layouts.index-custom')

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
          Last Status
        </h2>
      </div>
    </div>
    <section class="container-fluid">
      <div class="row gy-3 mb-5">
        <div class="col-xxl-4">
          <div class="row gy-3">
            <div class="col-12">
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
            <div class="col-12">
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
            <div class="col-12">
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
            <div class="col-12">
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
          </div>

        </div>
        <div class="col-xxl-8">
          <div class="card rounded h-100">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-dark text-center" data-display="datatables">
                  <thead>
                    <tr>
                      <th>View</th>
                      <th>ODO</th>
                      <th>Location</th>
                      <th>Vehicle Conditon</th>
                      <th>Created At</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($vehicleChecklists as $item)
                      @if ($item['id'] == $vehicleChecklist__ori['id'] ? 'table-primary' : '')
                        @continue
                      @endif
                      <tr>
                        <td>
                          <a href="{{ route('admin.vehicleChecklist.show', $item['id']) }}"
                            class="btn btn-primary">See</a>
                        </td>
                        <td>{{ $item->get('odo') }}</td>
                        <td>{{ $item->get('address')['name'] }}</td>
                        <td>{{ $item->get('vehicle_condition') }}%</td>
                        <td>{{ $item->get('created_at') }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="row g-4">
        @foreach ($vehicleChecklist as $key => $checklistConf)
          @php
            $summary = $checklistConf['summary'];
            $config = $checklistConf['config'];
          @endphp
          <div class="col-sm-12 col-md-6 col-xl-6 col-xxl-4" @class([
              'order-1' => $summary['broken'],
          ])>
            <div class="card rounded h-100">
              <div class="card-header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div>
                    <i class="{{ $config['icon'] }} fs-1 mb-3"></i>
                    <h3 class="fs-3">{{ $key }}</h3>
                  </div>
                </div>
                <div class="progress">
                  <div class="progress-bar bg-success fs-6" role="progressbar"
                    style="width: {{ getPercentage($summary['ok'], $summary['total']) }}%"
                    aria-valuenow="{{ getPercentage($summary['ok'], $summary['total']) }}" aria-valuemin="0"
                    aria-valuemax="100">
                    @if ($summary['ok'] != 0)
                      {{ getPercentage($summary['ok'], $summary['total']) }}%
                    @endif
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row g-3">
                  @foreach ($checklistConf['items'] as $key => $item)
                    @php
                      $checklistVal = checkChecklist($item);
                      $order = $item == 1 ? '1' : '2';
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
        @if ($vehicleChecklist__ori->vehicleChecklistImage->isNotEmpty())
          <div class="col-md-4">
            <div class="card rounded h-100">
              <div class="card-header">
                Other Desc
              </div>
              <div class="card-body">
                <div id="carousel" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-indicators">
                    @foreach ($vehicleChecklist__ori->vehicleChecklistImage as $checklistImage)
                      <button type="button" data-bs-target="#carousel" data-bs-slide-to="{{ $loop->index }}"
                        @class(['active' => $loop->iteration == 1]) aria-current="{{ $loop->iteration == 1 }}"
                        aria-label="Slide {{ $loop->iteration }}"></button>
                    @endforeach
                  </div>
                  <div class="carousel-inner">
                    @foreach ($vehicleChecklist__ori->vehicleChecklistImage as $checklistImage)
                      <div @class(['carousel-item', 'active' => $loop->iteration == 1])>
                        <div style="width: auto; height: 300px; max-height: 300px">
                          <img src="{{ asset("storage/$checklistImage->image") }}" class="d-block m-auto w-100 h-100"
                            alt="">
                        </div>
                        @if ($checklistImage->description)
                          <div class="carousel-caption d-none d-md-block" style="background: rgba(0, 0, 0, 1)">
                            <p class="d-inline">{{ $checklistImage->description }}</p>
                          </div>
                        @endif
                      </div>
                    @endforeach
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        @endif
      </div>
    </section>
  </div>
@endsection

@section('add_footJS')
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const table = $('table').DataTable({
        order: [],
        responsive: true,
        columnDefs: [{
          targets: [0],
          searchable: false,
          orderable: false,
        }],
        pageLength: 5,
        lengthMenu: [
          [5],
          [5]
        ]
      });
    });
  </script>
@endsection
