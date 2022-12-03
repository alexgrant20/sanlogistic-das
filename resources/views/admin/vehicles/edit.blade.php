@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Update Vehicle</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form class="mb-5" action="{{ route('admin.vehicles.update', $vehicle->license_plate) }}" method="POST"
        enctype="multipart/form-data" id="form">
        @csrf
        @method('PUT')

        @include('admin.vehicles.utils.form-ce')

      </form>
      <button type="submit" class="btn btn-lg btn-primary" id="submit">Update Vehicle</button>
    </section>
  </div>
@endsection

@section('footJS')
  <script>
    $(document).ready(function() {
      console.log($('#vehicle_license_plate_color_id').val());
      plateNumberHandler($('#license_plate').val() || "X XXX XE", 'number');
      plateNumberHandler($('#vehicle_license_plate_color_id').val() || 1, 'color');
      plateNumberHandler($('#kir_expire').val() || null, 'kir');
      plateNumberHandler($('#stnk_expire').val() || null, 'stnk');
    });
  </script>
  <script src="{{ asset('/js/vehicle.js') }}"></script>
  {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateVehicleRequest', 'form') !!}
@endsection
