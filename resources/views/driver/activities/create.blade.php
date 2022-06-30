@extends('driver.layouts.main')

@section('content')
  <form method="POST" action="{{ route('driver.activity.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="row gy-5">
      @livewire('driver.activity.vehicle-form', ['projectId' => $projectId, 'vehicles' => $vehicles])
      <div class="col-xl-8">
        <h4 class="text-blue">Input Image</h4>
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
      <span class="col-md-12 d-flex justify-content-end mt-5">
        <button type="submit" class="btn btn-lg btn-primary">
          Create
        </button>
      </span>
    </div>
  </form>
@endsection

@section('footJS')
@endsection
