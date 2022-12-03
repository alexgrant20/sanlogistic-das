@extends('driver.layouts.main')

@section('content')
  <div class="row g-4">
    @foreach ($checlists as $checklist)
      <div class="col-md-4">
        <div class="card rounded">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="fs-3">{{ $checklist->license_plate }}</span>
              <span class="fs-6 text-gray-500">{{ $checklist->created_at }}</span>
            </div>
            <div>
              <p class="mb-0">Vehicle Condition</p>
              <span class="fs-3"><span class="fs-2 fw-bold">{{ (int) $checklist->percentage }}</span>%</span>
            </div>
          </div>
          <div class="card-footer p-0">
            <a href="{{ route('driver.checklists.show', $checklist->id) }}" class="btn btn-primary w-100">
              See Detail
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection
