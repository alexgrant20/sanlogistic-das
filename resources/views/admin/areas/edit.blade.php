@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Update Area</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.areas.update', $area->id) }}" id="form" method="post">
        @csrf
        @method('PUT')
        @include('admin.areas.components.form-ce')

      </form>
      <button type="submit" class="btn btn-lg btn-primary" id="submit">Update Area</button>
    </section>
  </div>
@endsection

@section('footJS')
  {{-- {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateAreaRequest', 'form') !!} --}}
@endsection
