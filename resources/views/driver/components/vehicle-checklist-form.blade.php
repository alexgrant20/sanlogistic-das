<div class="accordion" id="checklist_container">
  {{-- Lamp --}}
  <div class="accordion-item mb-5">
    <h2 class="accordion-header" id="lamp-heading">
      <button class="accordion-button d-flex justify-content-center" type="button" data-bs-toggle="collapse"
        data-bs-target="#lamp-btn" aria-expanded="true" aria-controls="lamp-btn">
        <i class="fa-solid fa-lightbulb fa-1x border-end border-secondary pe-3"></i>
        <span class="fw-bold fs-5 ms-3">{{ __('Vehicle Lamp') }}</span>
        <span class="fw-bold fs-5 ms-1" id="lamp-text"></span>
      </button>
    </h2>
    <div id="lamp-btn" class="accordion-collapse collapse show" aria-labelledby="lamp-heading">
      <div class="accordion-body">
        <div class="row row-cols-2 row-cols-xxl-4 g-5" id="lamp">
          <x-input.checklist-switch id="lampu_besar" />
          <x-input.checklist-switch id="lampu_kota" />
          <x-input.checklist-switch id="lampu_rem" />
          <x-input.checklist-switch id="lampu_sein" />
          <x-input.checklist-switch id="lampu_mundur" />
          <x-input.checklist-switch id="lampu_kabin" />
          <x-input.checklist-switch id="lampu_senter" />
        </div>
        <hr>
        <label for="lamp_notes" class="form-label fs-5 text-primary">Catatan</label>
        <textarea class="form-control" id="lamp_notes" name="lamp_notes" rows="3"></textarea>
      </div>
    </div>
  </div>

  {{-- Glass --}}
  <div class="accordion-item mb-5">
    <h2 class="accordion-header" id="glass-heading">
      <button class="accordion-button d-flex justify-content-center" type="button" data-bs-toggle="collapse"
        data-bs-target="#glass-btn" aria-expanded="true" aria-controls="glass-btn">
        <i class="fa-solid fa-car-rear fa-1x border-end border-secondary pe-3"></i>
        <span class="fw-bold fs-5 ms-3">{{ __('Vehicle Glass') }}</span>
        <span class="fw-bold fs-5 ms-1" id="glass-text"></span>
      </button>
    </h2>
    <div id="glass-btn" class="accordion-collapse collapse show" aria-labelledby="glass-heading">
      <div class="accordion-body">
        <div class="row row-cols-2 row-cols-xxl-4 g-5" id="glass">
          <x-input.checklist-switch id="kaca_depan" />
          <x-input.checklist-switch id="kaca_samping" />
          <x-input.checklist-switch id="kaca_belakang" />
        </div>
        <hr>
        <label for="glass_notes" class="form-label fs-5 text-primary">Catatan</label>
        <textarea class="form-control" id="glass_notes" name="glass_notes" rows="3"></textarea>
      </div>
    </div>
  </div>

  {{-- Tire --}}
  <div class="accordion-item mb-5">
    <h2 class="accordion-header" id="tire-heading">
      <button class="accordion-button d-flex justify-content-center" type="button" data-bs-toggle="collapse"
        data-bs-target="#tire-btn" aria-expanded="true" aria-controls="tire-btn">
        <i class="fa-solid fa-circle fa-1x border-end border-secondary pe-3"></i>
        <span class="fw-bold fs-5 ms-3">{{ __('Vehicle Tire') }}</span>
        <span class="fw-bold fs-5 ms-1" id="tire-text"></span>
      </button>
    </h2>
    <div id="tire-btn" class="accordion-collapse collapse show" aria-labelledby="tire-heading">
      <div class="accordion-body">
        <div class="row row-cols-2 row-cols-xxl-4 g-5" id="tire">
          <x-input.checklist-switch id="ban_depan" />
          <x-input.checklist-switch id="ban_belakang_dalam" />
          <x-input.checklist-switch id="ban_belakang_luar" />
          <x-input.checklist-switch id="ban_serep" />
          <x-input.checklist-switch id="tekanan_angin_ban_depan" />
          <x-input.checklist-switch id="tekanan_angin_ban_belakang_dalam" />
          <x-input.checklist-switch id="tekanan_angin_ban_belakang_luar" />
          <x-input.checklist-switch id="tekanan_angin_ban_serep" />
          <x-input.checklist-switch id="velg_ban_depan" />
          <x-input.checklist-switch id="velg_ban_belakang_dalam" />
          <x-input.checklist-switch id="velg_ban_belakang_luar" />
          <x-input.checklist-switch id="velg_ban_serep" />
          <x-input.checklist-switch id="ganjal_ban" />
        </div>
        <hr>
        <label for="tire_notes" class="form-label fs-5 text-primary">Catatan</label>
        <textarea class="form-control" id="tire_notes" name="tire_notes" rows="3"></textarea>
      </div>
    </div>
  </div>

  {{-- Equipment --}}
  <div class="accordion-item mb-5">
    <h2 class="accordion-header" id="equipment-heading">
      <button class="accordion-button d-flex justify-content-center" type="button" data-bs-toggle="collapse"
        data-bs-target="#equipment-btn" aria-expanded="true" aria-controls="equipment-btn">
        <i class="fa-solid fa-screwdriver-wrench fa-1x border-end border-secondary pe-3"></i>
        <span class="fw-bold fs-5 ms-3">{{ __('Equipment') }}</span>
        <span class="fw-bold fs-5 ms-1" id="equipment-text"></span>
      </button>
    </h2>
    <div id="equipment-btn" class="accordion-collapse collapse show" aria-labelledby="equipment-heading">
      <div class="accordion-body">
        <div class="row row-cols-2 row-cols-xxl-4 g-5" id="equipment">
          <x-input.checklist-switch id="dongkrak" />
          <x-input.checklist-switch id="kunci_roda" />
          <x-input.checklist-switch id="stang_kunci_roda" />
          <x-input.checklist-switch id="pipa_bantu" />
          <x-input.checklist-switch id="kotak_p3k" label="Kotak P3K" />
          <x-input.checklist-switch id="apar" />
          <x-input.checklist-switch id="emergency_triangle" />
          <x-input.checklist-switch id="tool_kit" />
        </div>
        <hr>
        <label for="equipment_notes" class="form-label fs-5 text-primary">Catatan</label>
        <textarea class="form-control" id="equipment_notes" name="equipment_notes" rows="3"></textarea>
      </div>
    </div>
  </div>

  {{-- Gear --}}
  <div class="accordion-item mb-5">
    <h2 class="accordion-header" id="gear-heading">
      <button class="accordion-button d-flex justify-content-center" type="button" data-bs-toggle="collapse"
        data-bs-target="#gear-btn" aria-expanded="true" aria-controls="gear-btn">
        <i class="fa-solid fa-toolbox fa-1x border-end border-secondary pe-3"></i>
        <span class="fw-bold fs-5 ms-3">{{ __('Gear') }}</span>
        <span class="fw-bold fs-5 ms-1" id="gear-text"></span>
      </button>
    </h2>
    <div id="gear-btn" class="accordion-collapse collapse show" aria-labelledby="gear-heading">
      <div class="accordion-body">
        <div class="row row-cols-2 row-cols-xxl-4 g-5" id="gear">
          <x-input.checklist-switch id="seragam" />
          <x-input.checklist-switch id="safety_shoes" />
          <x-input.checklist-switch id="driver_license" />
          <x-input.checklist-switch id="kartu_keur" />
          <x-input.checklist-switch id="stnk" />
          <x-input.checklist-switch id="helmet" />
          <x-input.checklist-switch id="tatakan_menulis" />
          <x-input.checklist-switch id="ballpoint" />
          <x-input.checklist-switch id="straples" />
        </div>
        <hr>
        <label for="gear_notes" class="form-label fs-5 text-primary">Catatan</label>
        <textarea class="form-control" id="gear_notes" name="gear_notes" rows="3"></textarea>
      </div>
    </div>
  </div>

  {{-- Other --}}
  <div class="accordion-item mb-5">
    <h2 class="accordion-header" id="other-heading">
      <button class="accordion-button d-flex justify-content-center" type="button" data-bs-toggle="collapse"
        data-bs-target="#other-btn" aria-expanded="true" aria-controls="other-btn">
        <i class="fa-solid fa-ellipsis fa-1x border-end border-secondary pe-3"></i>
        <span class="fw-bold fs-5 ms-3">{{ __('Other') }}</span>
        <span class="fw-bold fs-5 ms-1" id="other-text"></span>
      </button>
    </h2>
    <div id="other-btn" class="accordion-collapse collapse show" aria-labelledby="other-heading">
      <div class="accordion-body">
        <div class="row row-cols-2 row-cols-xxl-4 g-5" id="other">
          <x-input.checklist-switch id="exhaust_brake" />
          <x-input.checklist-switch id="spion" />
          <x-input.checklist-switch id="wiper" />
          <x-input.checklist-switch id="tangki_bahan_bakar" />
          <x-input.checklist-switch id="tutup_tangki_bahan_bakar" />
          <x-input.checklist-switch id="tutup_radiator" />
          <x-input.checklist-switch id="accu" />
          <x-input.checklist-switch id="oli_mesin" />
          <x-input.checklist-switch id="minyak_rem" />
          <x-input.checklist-switch id="minyak_kopling" />
          <x-input.checklist-switch id="oli_hidraulic" />
          <x-input.checklist-switch id="klakson" />
          <x-input.checklist-switch id="panel_speedometer" />
          <x-input.checklist-switch id="panel_bahan_bakar" />
          <x-input.checklist-switch id="sunvisor" />
          <x-input.checklist-switch id="jok" />
          <x-input.checklist-switch id="air_conditioner" />
        </div>
        <hr>
        <label for="other_notes" class="form-label fs-5 text-primary">Catatan</label>
        <textarea class="form-control" id="other_notes" name="other_notes" rows="3"></textarea>
      </div>
    </div>
  </div>

  {{-- Image --}}
  <div class="accordion-item mb-5">
    <h2 class="accordion-header" id="image-header">
      <button class="accordion-button d-flex justify-content-center" type="button" data-bs-toggle="collapse"
        data-bs-target="#image" aria-expanded="true" aria-controls="image">
        <i class="fa-solid fa-images fa-1x border-end border-secondary pe-3"></i>
        <span class="fw-bold fs-5 ms-3">{{ __('Image') }}</span>
      </button>
    </h2>
    <div id="image" class="accordion-collapse collapse show" aria-labelledby="image-header">
      <div class="accordion-body" id="image-container">
        <div class="mb-5">
          <x-input-image id="image_1" :label="__('Image')" />
          <div class="mt-5">
            <label class="form-label fs-5 text-primary"
              for="image_1_description">{{ __('Image Description') }}</label>
            <textarea class="form-control" name="image_1_description" id="image_1_description"></textarea>
          </div>
        </div>
      </div>
    </div>
    <div class="d-grid">
      <button type="button" id="add-image" class="btn btn-lg btn-info">
        <i class="fa-solid fa-plus fa-1x me-2"></i>
        {{ __('Add Image') }}
      </button>
    </div>
  </div>
</div>
