@extends('admin.layouts.main')

@section('headCSS')
  <link href="{{ asset('/vendor/zoom/zoom.css') }}" rel="stylesheet">
@endsection

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Create Company</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.company.store') }}" id="create-company" method="post" enctype="multipart/form-data">
        @csrf

        @include('admin.companies.utils.form-ce')

        <button type="submit" class="btn btn-lg btn-primary">Submit</button>
      </form>
    </section>
  </div>
@endsection

@section('footJS')
  <script src="{{ asset('/vendor/zoom/zoom.js') }}"></script>
@endsection
