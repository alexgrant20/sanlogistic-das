@extends('admin.layouts.main')

@section('container')
   <div class="page-content">
      <div class="bg-dash-dark-2 py-4">
         <div class="container-fluid">
            <h2 class="h5 mb-0">Register</h2>
         </div>
      </div>
      <section class="container-fluid">
         <form action="{{ route('admin.driver.update-last-location', $driver->id) }}" method="POST" id="form">
            @csrf
            @method('PUT')
            <div class="mb-5">
               <div class="row g-2 mb-2">
                  <div class="col-xl-4">
                     <label for="last_location_id" class="form-label">Lokasi Terahkir</label>
                     <select name="last_location_id"
                        class="form-select form-select-lg form-control @error('last_location_id') is-invalid @enderror"
                        id="last_location_id">
                        <option value="" hidden></option>
                        @foreach ($addressess as $address)
                           <option value="{{ $address->id }}" @selected($address->id == $last_location_id)>
                              {{ $address->name }}
                           </option>
                        @endforeach
                     </select>

                     @error('last_location_id')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                     @enderror
                  </div>
               </div>
            </div>
         </form>
         <button type="submit" class="btn btn-lg btn-primary" id="submit">Submit</button>
      </section>
   </div>
@endsection
