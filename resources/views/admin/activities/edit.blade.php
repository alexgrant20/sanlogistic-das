@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Update Activity</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.activity.update', $activity->id) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        @include('admin.activities.utils.form-ce')

        <button type="submit" class="btn btn-lg btn-primary">Update</button>
      </form>
    </section>
  </div>
@endsection

@section('footJS')
  <script src="{{ asset('/vendor/currency/currency.js') }}"></script>
@endsection
