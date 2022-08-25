<section class="container-fluid">
  <div class="p-5">
    <div class="row mb-4 g-3">
      <x-summary-box summaryTitle="Total Vehicle" summaryTotal="{{ $totalVehicle }}" icon="bi bi-truck" id="total-vehicle"
        link="{{ route('admin.project.index.assign.vehicle', $project->name) }}" :active="Request::is('*/vehicle/*') ? true : false" />

      <x-summary-box summaryTitle="Total Person" summaryTotal="{{ $totalPerson }}" icon="bi bi-person" id="total-person"
        link="{{ route('admin.project.index.assign.person', $project->name) }}" :active="Request::is('*/person/*') ? true : false" />

      <x-summary-box summaryTitle="Total Address" summaryTotal="{{ $totalAddress }}" icon="bi bi-house-door"
        id="total-address" link="{{ route('admin.project.index.assign.address', $project->name) }}" :active="Request::is('*/address/*') ? true : false" />
    </div>
    <div class="my-5">
      <div class="d-flex text-muted align-items-center justify-content-between">
        <h3 class="fs-4 text-uppercase">In Project</h3>
        <div class="input-group mb-3 w-25">
          <span class="input-group-text" id="keywoardInProjectDesc"><i class="bi bi-search"></i></span>
          <input type="text" name="keywordInProject" id="keywordInProject" class="form-control keywoard"
            placeholder="Search" aria-label="Search" aria-describedby="keywoardInProjectDesc">
        </div>
      </div>
      <div class="border border-secondary rounded p-2" style="max-height: 530px; overflow-y:auto;">
        <div class="row g-3" id="listInProject"></div>
      </div>
    </div>
    <div class="pt-5">
      <div class="d-flex text-muted align-items-center justify-content-between">
        <h3 class="fs-4 text-uppercase">Assign</h3>
        <div class="input-group mb-3 w-25">
          <span class="input-group-text" id="keywoardNotInProject"><i class="bi bi-search"></i></span>
          <input type="text" name="keywordNotInProject" id="keywordNotInProject" class="form-control keywoard"
            placeholder="Search" aria-label="Search" aria-describedby="keywoardNotInProject">
        </div>
      </div>
      <div class="border border-secondary rounded p-2" style="max-height: 530px; overflow-y:auto;">
        <div class="row g-3" id="listNotInProject"></div>
      </div>
    </div>
  </div>

  <x-basic-toast>
    <x-slot name="id">toast</x-slot>
  </x-basic-toast>
</section>
