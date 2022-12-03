@extends('admin.layouts.main')

@section('headCSS')
  <link href="{{ asset('/vendor/zoom/zoom.css') }}" rel="stylesheet">
@endsection

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Create Company</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.companies.store') }}" id="form" method="post" enctype="multipart/form-data">
        @csrf

        @include('admin.companies.utils.form-ce')

      </form>
      <button type="submit" class="btn btn-lg btn-primary" id="submit">Create Company</button>
    </section>
  </div>
@endsection

@section('footJS')
  {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreCompanyRequest', 'form') !!}
@endsection
