@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Create Project</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.projects.store') }}" class="mb-5" method="post" id="form">
        @csrf

        @include('admin.projects.components.form-ce')
      </form>
      <button type="submit" id="submit" class="btn btn-lg btn-primary">Create Project</button>
    </section>
  </div>
@endsection

@section('footJS')
  {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreProjectRequest', 'form') !!}
@endsection
