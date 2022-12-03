@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Edit Project</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.projects.update', $project->name) }}" classs="mb-5" method="POST" id="form">
        @csrf
        @method('PUT')

        @include('admin.projects.components.form-ce')

      </form>
      <button type="submit" class="btn btn-lg btn-primary" id="submit">Update Project</button>
    </section>
  </div>
@endsection


@section('footJS')
  {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateProjectRequest', 'form') !!}
@endsection
