@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Role</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.roles.update', $role->id) }}" method="post" id="form" class="mb-5">
        @method('PUT')
        @csrf
        <div class="mb-4">
          <label for="name" class="form-label">Role Name</label>
          <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name"
            name="name" value="{{ old('name', $role->name) }}">
          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
        <div>
          <h3 class="border-start border-primary ps-3 fs-2">Role Permission</h3>
          <p class="fs-3">Manage Role Permission</p>
          <input class="form-check-input" type="checkbox" onclick="checkAlls(this, 'checkbox')" id="check-all">
          <label for="check-all">Check All</label>
          <hr>

          <div class="row g-2">
            @foreach ($permissions as $permission)
              <div class="col-sm-3">
                <label for="{{ $permission->name }}">{!! ucwords(str_replace('-', ' ', $permission->name)) !!}</label>
                <input type="checkbox" name="{{ $permission->name }}" id="{{ $permission->name }}"
                  class="form-check-input" @if ($role->hasPermissionTo($permission->name)) checked @endif value="1">
                {{-- <label for="{{ $permission->name }}">{!! ucwords(str_replace('-', ' ', $permission->name)) !!}</label> --}}
              </div>
            @endforeach
          </div>
        </div>
      </form>
      <button type="submit" class="btn btn-primary" id="submit">Update Role</button>
    </section>
  </div>
@endsection

@section('footJS')
  <script>
    function checkAlls(bx, classEl) {
      const checked = $(bx).is(":checked");
      const cbs = document.querySelectorAll("." + classEl);
      $('input:checkbox').not(this).prop('checked', checked);
    }
  </script>
@endsection
