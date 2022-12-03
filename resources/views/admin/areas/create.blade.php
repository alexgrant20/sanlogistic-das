@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Create Area</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.areas.store') }}" id="form" method="post">
        @csrf

        @include('admin.areas.components.form-ce')

      </form>
      <button type="submit" class="btn btn-lg btn-primary" id="submit">Create Area</button>
    </section>
  </div>
  <div class="bg-primary">
    @php
      print_r('test');
    @endphp
  </div>
@endsection

@section('footJS')
  {{-- {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreAreaRequest', 'form') !!} --}}
@endsection
