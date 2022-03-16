@extends('layouts.main')

@section('headCSS')
  <link href="/vendor/zoom/zoom.css" rel="stylesheet">
@endsection

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Create Company</h2>
      </div>
    </div>
    <section class="container-fluid">

      @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
          {{ session('error') }}
        </div>
      @endif

      <form action="/companies" id="create-company" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-5">
          <h4 class="text-primary fw-bold">Data Perusahaan</h4>
          <hr>
          <div class="row g-2 mb-2">

            <div class="col-xl-4">
              <label for="name" class="form-label">Nama Perusahaan</label>
              <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name"
                name="name" value="{{ old('name') }}" autofocus>

              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-4">
              <label for="company_type_id" class="form-label">Tipe</label>
              <select class='form-select form-select-lg  @error('company_type_id') is-invalid @enderror'
                name='company_type_id' id="company_type_id">
                <option value='' class="d-none"></option>
                @foreach ($companiesTypes as $companyType)
                  @if ($companyType->id == old('companyType_id'))
                    <option value='{{ $companyType->id }}' selected>{{ $companyType->name }}</option>
                  @else
                    <option value='{{ $companyType->id }}'>{{ $companyType->name }}</option>
                  @endif
                @endforeach
              </select>

              @error('company_type_id')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-4">
              <label for="phone_number" class="form-label">Nomor Telepon</label>
              <input type="text" class="form-control form-control-lg @error('phone_number') is-invalid @enderror"
                id="phone_number" name="phone_number" value="{{ old('phone_number') }}">

              @error('phone_number')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-4">
              <label for="fax" class="form-label">Fax</label>
              <input type="text" class="form-control form-control-lg @error('fax') is-invalid @enderror" id="fax"
                name="fax" value="{{ old('fax') }}">

              @error('fax')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-4">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email') }}">

              @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-4">
              <label for="website" class="form-label">Website</label>
              <input type="text" class="form-control form-control-lg @error('website') is-invalid @enderror" id="website"
                name="website" value="{{ old('website') }}">

              @error('website')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-4">
              <label for="director" class="form-label">Nama Direktur</label>
              <input type="text" class="form-control form-control-lg @error('director') is-invalid @enderror"
                id="director" name="director" value="{{ old('director') }}">

              @error('director')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-4">
              <label for="npwp" class="form-label">NPWP</label>
              <input type="text" class="form-control form-control-lg @error('npwp') is-invalid @enderror" id="npwp"
                name="npwp" value="{{ old('npwp') }}">

              @error('npwp')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-4">
              <label for="address_id" class="form-label">Alamat</label>
              <select class='form-select form-select-lg @error('address_id') is-invalid @enderror' name='address_id'>
                <option value='' class="d-none"></option>
                @foreach ($addresses as $address)
                  @if ($address->id == old('address_id'))
                    <option value="{{ $address->id }}" selected>{{ $address->name }}</option>
                  @else
                    <option value="{{ $address->id }}">{{ $address->name }}</option>
                  @endif
                @endforeach
              </select>
              @error('address_id')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

          </div>
        </div>
        <div class="row g-2 mb-5">
          <div class="col-xl-6">
            <h4 class="text-primary fw-bold">SIUP</h4>
            <hr>
            <div class="row g-2">

              <div class="col-xl-6">
                <label for="siup" class="form-label">Nomor SIUP</label>
                <input type="text" class="form-control form-control-lg  @error('siup') is-invalid @enderror" id="siup"
                  name="siup" value="{{ old('siup') }}">

                @error('siup')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="col-xl-6">
                <label for="siup_expire" class="form-label">Masa Beralaku SIUP</label>
                <input type="date" class="form-control form-control-lg @error('siup_expire') is-invalid @enderror"
                  id="siup_expire" name="siup_expire" value="{{ old('siup_expire') }}">

                @error('siup_expire')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="col-xl-12">
                <label for="siup_image" class="form-label">Gambar SIUP</label>
                <input class="form-control form-control-lg @error('siup_image') is-invalid @enderror" type="file"
                  accept="image/*" name="siup_image" id="siup_image" onchange="previewImage('siup_image')">

                @error('siup_image')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="col-xl mt-5">
                <div class="w-100 h-100 d-flex justify-content-center align-items-center"
                  style="background-color: transparent;">
                  <img class="img-fluid rounded zoom mw-100" style="max-height: 200px" id="siup_image-preview" alt=""
                    data-action="zoom">
                </div>
              </div>

            </div>
          </div> <!-- EOC SIUP -->
          <div class="col-xl-6">
            <h4 class="text-primary fw-bold">SIPA</h4>
            <hr>
            <div class="row g-2">

              <div class="col-xl-6">
                <label for="sipa" class="form-label">Nomor SIPA</label>
                <input type="text" class="form-control form-control-lg @error('sipa') is-invalid @enderror" id="sipa"
                  name="sipa" value="{{ old('sipa') }}">

                @error('sipa')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="col-xl-6">
                <label for="sipa_expire" class="form-label">Masa Beralaku SIPA</label>
                <input type="date" class="form-control form-control-lg @error('sipa_expire') is-invalid @enderror"
                  id="sipa_expire" name="sipa_expire" value="{{ old('sipa_expire') }}">

                @error('sipa_expire')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="col-xl-12">
                <label for="sipa_image" class="form-label">Gambar SIPA</label>
                <input class="form-control form-control-lg @error('sipa_image') is-invalid @enderror" type="file"
                  accept="image/*" name="sipa_image" id="sipa_image" onchange="previewImage('sipa_image')">

                @error('sipa_image')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="col-xl mt-5">
                <div class="w-100 h-100 d-flex justify-content-center align-items-center"
                  style="background-color: transparent;">
                  <img src="" class="img-fluid rounded zoom mw-100" style="max-height: 200px" id="sipa_image-preview"
                    alt="" data-action="zoom">
                </div>
              </div>

            </div>
          </div> <!-- EOC SIPA -->
        </div>

        <div class="form-floating mb-3">
          <textarea class="form-control" placeholder="Leave a comment here" id="note" name="note"
            style="height: 100px">{{ old('note') }}</textarea>
          <label for="note">Comments</label>
        </div>

        <button type="submit" class="btn btn-lg btn-primary">Submit</button>

      </form>
    </section>
  </div>
@endsection

@section('footJS')
  <script src="/vendor/zoom/zoom.js"></script>
@endsection
