@extends('driver.layouts.main')

@section('content')
  <form method="POST" action="{{ route('driver.activity.store') }}" enctype="multipart/form-data" onsubmit="">
    @csrf

    <div class="row gy-5">
      @livewire('driver.activity.vehicle-form', ['projectId' => $projectId, 'vehicles' => $vehicles])
      <div class="col-xl-8">
        <h4>Input Image</h4>
        <hr>
        <div class="row g-3">
          <div class="col-md-6">
            @livewire('component.image-input', ['name' => 'do_image', 'label' => 'Do Image'])
          </div>

          <div class="col-md-6">
            @livewire('component.image-input', ['name' => 'departure_odo_image', 'label' => 'ODO Image'])
          </div>
        </div>
      </div>
      <span class="col-12 d-grid mt-5">
        <button type="submit" class="btn btn-lg btn-success">
          Create
        </button>
      </span>
    </div>
  </form>
@endsection

@section('footJS')
@endsection
