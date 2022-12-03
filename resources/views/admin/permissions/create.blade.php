@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Permission</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.permissions.store') }}" method="post" id="form">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Permission Name</label>
          <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name"
            name="name" value="{{ old('name') }}">
          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </form>
      <button class="btn btn-primary" id="submit">Create Permission</button>
    </section>
  </div>
@endsection
