@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Audit Activity</h2>
      </div>
    </div>
    <section class="container-fluid">
      <div class="mb-5">
        <h4 class="text-primary fw-bold">Detail Aktivitas</h4>
        <hr>

        <div class="row g-2 mb-5">
          <div class="col-xl-4">
            <label for="do_number" class="form-label fs-4 fw-bold">Nama Pengendara</label>
            <p class="fs-4" id="do_number">{{ $activity->driver->person->name }}</p>
          </div>
          <div class="col-xl-4">
            <label for="do_number" class="form-label fs-4 fw-bold">DO Number</label>
            <p class="fs-4" id="do_number">{{ $activity->do_number }}</p>
          </div>
        </div>

      </div>

      <form action="{{ url("/admin/finances/acceptance/$activity->id") }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-5">
          <h4 class="text-primary fw-bold">Pengeluaran</h4>
          <hr>
          <div class="row g-2 mb-5">
            <div class="col-xl-4">
              <label for="bbm_amount" class="form-label">BBM</label>
              <input type="text" class="form-control form-control-lg @error('bbm_amount') is-invalid @enderror"
                id="bbm_amount" name="bbm_amount"
                value="{{ old('bbm_amount', $activity->activityStatus->activityPayment->bbm_amount) }}" data="money">

              @error('bbm_amount')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror

              <img src="{{ asset('storage/' . $activity['bbm_image']) }}"
                class="img-fluid rounded zoom mw-100 mx-auto d-block mt-5" style="max-height: 200px"
                id="bbm_image-preview" alt="" data-action="zoom">
            </div>

            <div class="col-xl-4">
              <label for="toll_amount" class="form-label">Toll</label>
              <input type="text" class="form-control form-control-lg @error('toll_amount') is-invalid @enderror"
                id="toll_amount" name="toll_amount"
                value="{{ old('toll_amount', $activity->activityStatus->activityPayment->toll_amount) }}" data="money">

              @error('toll_amount')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror

              <img src="{{ asset('storage/' . $activity['toll_image']) }}"
                class="img-fluid rounded zoom mw-100 mx-auto d-block mt-5" style="max-height: 200px"
                id="toll_image-preview" alt="" data-action="zoom">
            </div>

            <div class="col-xl-4">
              <label for="retribution_amount" class="form-label">Retribusi</label>
              <input type="text" class="form-control form-control-lg @error('retribution_amount') is-invalid @enderror"
                id="retribution_amount" name="retribution_amount"
                value="{{ old('retribution_amount', $activity->activityStatus->activityPayment->retribution_amount) }}"
                data="money">

              @error('retribution_amount')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror

              <img src="{{ asset('storage/' . $activity['retribution_image']) }}"
                class="img-fluid rounded zoom mw-100 mx-auto d-block mt-5" style="max-height: 200px"
                id="retribution_image-preview" alt="" data-action="zoom">
            </div>

            <div class="col-xl-4">
              <label for="parking" class="form-label">Parkir</label>
              <input type="text" class="form-control form-control-lg @error('parking') is-invalid @enderror" id="parking"
                name="parking" value="{{ old('parking', $activity->activityStatus->activityPayment->parking_amount) }}"
                data="money">

              @error('parking')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror

              <img src="{{ asset('storage/' . $activity['parking_image']) }}"
                class="img-fluid rounded zoom mw-100 mx-auto d-block mt-5" style="max-height: 200px"
                id="parking_image-preview" alt="" data-action="zoom">
            </div>

          </div>
          <button type="submit" class="btn btn-lg btn-primary">Submit</button>
      </form>
    </section>
  </div>
@endsection

@section('footJS')
  <script src="{{ asset('/vendor/currency/currency.js') }}"></script>
@endsection
