@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Update Vehicle</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ url("/admin/vehicles/$vehicle->license_plate") }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('admin.vehicles.utils.form-ce')

        <button type="submit" class="btn btn-lg btn-primary">Submit</button>
      </form>
    </section>
  </div>
@endsection

@section('footJS')
  <script src="{{ asset('/js/vehicle.js') }}"></script>
@endsection
