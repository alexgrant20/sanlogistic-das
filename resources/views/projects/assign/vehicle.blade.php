@extends('layouts.main')

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Create Project</h2>
      </div>
    </div>
    <section class="container-fluid">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-5">
            <span class="fs-4 fw-bold">Project <?= mb_convert_case('dsa', MB_CASE_TITLE, 'UTF-8') ?></span>

          </div>
          <div class="pb-5">
            <div class="d-flex align-items-center justify-content-between">
              <h3 style="font-weight:500" class="text-info">Vehicle in Project</h3>
              <div class="input-group mb-3 w-25">
                <span class="input-group-text" id="keywoardInProjectDesc"><i class="fas fa-search"></i></span>
                <input type="text" name="keywordInProject" id="keywordInProject" class="form-control keywoard"
                  placeholder="Search" aria-label="Search" aria-describedby="keywoardInProjectDesc">
              </div>
            </div>
            <div class="card bg-dark" style="max-height: 530px; overflow-y:auto;">
              <div class="card-body">
                <div class="row g-2" id="listInProject"></div>
              </div>
            </div>
          </div>
          <div class="pt-5">
            <div class="d-flex align-items-center justify-content-between">
              <h3 style="font-weight:500" class="text-info">Assign to Project</h3>
              <div class="input-group mb-3 w-25">
                <span class="input-group-text" id="keywoardNotInProject"><i class="fas fa-search"></i></span>
                <input type="text" name="keywordNotInProject" id="keywordNotInProject" class="form-control keywoard"
                  placeholder="Search" aria-label="Search" aria-describedby="keywoardNotInProject">
              </div>
            </div>
            <div class="card bg-dark" style="max-height: 530px; overflow-y:auto;">
              <div class="card-body">
                <div class="row g-2" id="listNotInProject"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>
@endsection
