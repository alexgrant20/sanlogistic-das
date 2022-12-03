@extends('admin.layouts.main')

@section('headCSS')
  <link href="{{ asset('/vendor/zoom/zoom.css') }}" rel="stylesheet">
@endsection

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Update Company</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.companies.update', $company->name) }}" method="POST" enctype="multipart/form-data"
        id="form">
        @csrf
        @method('PUT')

        @include('admin.companies.utils.form-ce')

      </form>
      <button type="submit" class="btn btn-lg btn-primary" id="submit">Update Company</button>
    </section>
  </div>
@endsection

@section('footJS')
  {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateCompanyRequest', 'form') !!}
@endsection
