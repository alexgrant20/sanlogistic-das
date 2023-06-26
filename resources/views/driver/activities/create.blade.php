@extends('driver.layouts.main')

@section('title', 'Buat Aktivitas')

@section('content')
  <x-modal id="assure-modal" size="modal-lg">
    <x-slot:body>
      <div class="d-flex flex-column align-items-center mb-3">
        <i class="bi bi-exclamation-circle display-1 text-warning"></i>
        <p class="display-6 text-white mb-1 fw-bold">Apakah anda yakin?</p>
        <p class="fs-3 text-gray-600">Pastikan data aktivitas yang dimasukan sudah sesuai</p>
      </div>
      <div class="d-grid gap-2 w-100">
        <button type="submit" id="submit" class="btn btn-lg btn-primary">Buat Aktivitas</button>
        <button type="button" class="btn btn-lg" data-bs-dismiss="modal">Tutup</button>
      </div>
    </x-slot:body>
  </x-modal>
  <section>
    <form method="POST" action="{{ route('driver.activity.store') }}" enctype="multipart/form-data" id="form">
      @csrf

      <div class="row gy-5 mb-5">
        @livewire('driver.activity.vehicle-form', ['projectId' => $projectId, 'vehicles' => $vehicles])
        <div class="col-xl-8">
          <h4>File</h4>
          <hr>
          <div class="row g-3">
            <div class="col-md-6">
              <x-input-image id="do_image" label="Gambar DO" :required="true" />
            </div>

            <div class="col-md-6">
              <x-input-image id="departure_odo_image" label="Gambar ODO" :required="true" />
            </div>
          </div>
        </div>

        {{-- VEHICLE CHECKLIST --}}
        <div class="col-12">
          @include('driver.components.vehicle-checklist-form')
        </div>

        <div class="col-12">
          <div class="d-grid">
            <button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#assure-modal">
              Kirim
            </button>
          </div>
        </div>
      </div>
    </form>
  </section>
@endsection

@section('footJS')
  {!! JsValidator::formRequest('App\Http\Requests\Driver\StoreActivityRequest', 'form') !!}
  <script>
    $(document).ready(function() {
      let totalImage = 1;
      getVehicleLastStatus()

      $("#add-image").click((e) => {
        totalImage++;
        $("#image-container")
          .last()
          .append(
            `
            <div class="mb-5">
              <x-input-image id="image_${totalImage}" label="Gambar" />
              <div class="mt-5">
                <label class="form-label fs-5 text-primary" for="image_${totalImage}_description">Deskripsi Gambar</label>
                <textarea class="form-control" name="image_${totalImage}_description" id="image_${totalImage}_description"></textarea>
              </div>
            </div>
          `
          );

        // Check if exeeding
        if (totalImage === 4) {
          $("#add-image").remove();
          return;
        }
      });
    });
  </script>
@endsection
