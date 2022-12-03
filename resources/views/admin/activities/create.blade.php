@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Create Activity</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.activities.store') }}" method="post" enctype="multipart/form-data" id="form">
        @csrf

        @include('admin.activities.utils.form-ce')
      </form>
      <button type="submit" class="btn btn-lg btn-primary" id="submit">Create Activity</button>
    </section>
  </div>
@endsection

@section('footJS')
  {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreActivityRequest', 'form') !!}
@endsection
