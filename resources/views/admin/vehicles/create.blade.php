@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Create Vehicle</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form class="mb-5" action="{{ route('admin.vehicle.store') }}" method="post" enctype="multipart/form-data"
        id="form">
        @csrf

        @include('admin.vehicles.utils.form-ce')

      </form>
      <button type="submit" class="btn btn-lg btn-primary" id="submit">Create Vehicle</button>
    </section>
  </div>
@endsection

@section('footJS')
  <script src="{{ asset('/js/vehicle.js') }}"></script>
  {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreVehicleRequest', 'form') !!}
@endsection
