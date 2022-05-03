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
            <h3 class="fw-bold text-primary">Project <?= mb_convert_case('dsa', MB_CASE_TITLE, 'UTF-8') ?></h3>
          </div>
          <div class="row mb-4">
            <x-summary-box>
              <x-slot name="summaryTitle">Total Vehicle</x-slot>
              <x-slot name="summaryTotal">{{ $totalVehicle }}</x-slot>
              <x-slot name="icon">bi-truck</x-slot>
              <x-slot name="id">total-vehicle</x-slot>
              <x-slot name="summaryTotalColor">text-primary</x-slot>
            </x-summary-box>
            <x-summary-box>
              <x-slot name="summaryTitle">Total Person</x-slot>
              <x-slot name="summaryTotal">{{ $totalPerson }}</x-slot>
              <x-slot name="icon">bi-person</x-slot>
              <x-slot name="id">total-person</x-slot>
              <x-slot name="summaryTotalColor">text-dash-color-1</x-slot>
              <x-slot name="customCardClass">disabled</x-slot>
              <x-slot name="link">/projects/assign/person/{{ $projectName }}</x-slot>
            </x-summary-box>
            <x-summary-box>
              <x-slot name="summaryTitle">Total Address</x-slot>
              <x-slot name="summaryTotal">{{ $totalAddress }}</x-slot>
              <x-slot name="icon">bi-house-door</x-slot>
              <x-slot name="id">total-address</x-slot>
              <x-slot name="summaryTotalColor">text-dash-color-2</x-slot>
              <x-slot name="customCardClass">disabled</x-slot>
              <x-slot name="link">/projects/assign/address/{{ $projectName }}</x-slot>
            </x-summary-box>
          </div>
          <div class="pb-5">
            <div class="d-flex align-items-center justify-content-between">
              <h4 class="text-secondary fw-bold">In Project</h4>
              <div class="input-group mb-3 w-25">
                <span class="input-group-text" id="keywoardInProjectDesc"><i class="bi bi-search"></i></span>
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
              <h4 class="text-secondary fw-bold">Assign</h4>
              <div class="input-group mb-3 w-25">
                <span class="input-group-text" id="keywoardNotInProject"><i class="bi bi-search"></i></span>
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

      <x-basic-toast>
        <x-slot name="id">vehicle-project-toast</x-slot>
      </x-basic-toast>

    </section>
  </div>
  <script type="text/javascript" defer>
    $(document).ready(function() {

      const toast = new bootstrap.Toast(document.getElementById('vehicle-project-toast'))

      $('#keywordNotInProject').on('keyup', function() {
        getData($(this).val() || "%", "listNotInProject", "notInProject");
      })

      $('#keywordInProject').on('keyup', function() {
        getData($(this).val() || "%", "listInProject", "inProject");
      })

      let projectId = getCookie('project_id');

      function getData(keyword, templateId, type) {
        $.ajax({
          url: '/project/vehicle',
          type: 'GET',
          data: {
            keyword,
            projectId,
            type
          },

          success: function(result) {
            let data = JSON.parse(result);
            let str = "";
            if (data.length === 0) {

              str = `
                    <div class="col-xl-16 m-auto">
                        <div class="card">
                            <div class="card-body m-auto fw-bold text-danger fs-3">
                                No Data
                            </div>
                        </div>
                    </div>`;
            } else {

              $.each(data, function(index, item) {
                const inSameProject = item.project_id == projectId;

                const value = inSameProject ? "Remove" : "Assign";

                let className = "";

                if (inSameProject) {
                  labelName = "Remove";
                  className = 'btn-secondary';
                } else if (item.project_id) {
                  labelName = "Assigned";
                  className = 'btn-warning';
                } else {
                  labelName = "Assign";
                  className = 'btn-success'
                }

                const plateColor = item.vehicles_license_plate_color.name == 'black' ? "#000" : "#9b870c";
                const textColor = item.vehicles_license_plate_color.name == 'black' ? "text-white" :
                  "text-dark";

                const kir = item.vehicles_documents.find(e => e.type === 'kir');
                const stnk = item.vehicles_documents.find(e => e.type === 'stnk');

                let kir_month = "XX";
                let kir_year = "XX";

                if (kir.expire) {
                  const expire = kir.expire.split("-")
                  kir_month = expire[1];
                  kir_year = expire[0].slice(-2);
                }

                let stnk_month = "XX";
                let stnk_year = "XX";

                if (stnk.expire) {
                  const expire = stnk.expire.split("-")
                  stnk_month = expire[1];
                  stnk_year = expire[0].slice(-2);
                }

                str +=
                  `
                    <div class="col-xxl-4">
                      <div class="card">
                          <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="w-50 rounded shadow-lg" style="background-color: ${plateColor}">
                              <a href="/vehicles/${item.license_plate}/edit" class="d-flex flex-column align-items-center mw-100 text-truncate p-2">
                                  <span class="${textColor} fw-bold mb-1 text-truncate text-center w-75" id="plateNumber">${item.license_plate}</span>
                                  <hr class="w-100 border border-white border-5 m-0 mb-1">
                                  <div class="d-flex justify-content-between w-100">
                                    <span class="${textColor}" id="kirYear">${kir_month}.${kir_year}</span>
                                    <span class="${textColor}" id="stnkYear">${stnk_month}.${stnk_year}</span>
                                  </div>
                              </a>
                            </div>
                            <form action="#" method="POST" class="d-flex align-items-center justify-content-center h-100" listener="false">
                              @csrf
                              <input type="hidden" name="vehicle_id" value="${item.id}">
                              <input type="hidden" name="action" value="${value.toLowerCase()}">
                              <input type="submit" value="${labelName}" class="btn btn-sm text-white fw-bold ${className}">
                            </form>
                        </div>
                      </div>
                    </div>
                  `;
              })
            }


            $(`#${templateId}`).html(str);
            const element = document.querySelectorAll('form');

            // #TO-DO -> FIND MORE EFFECTIENT WAY TO ADD LISTENER
            element.forEach(element => {
              if (element.getAttribute('listener') === 'false') {
                element.addEventListener('submit', formSubmitHandler);
              }
            });

          }
        })
      }

      function formSubmitHandler(e) {
        e.preventDefault();
        const elementClicked = e.target;
        elementClicked.setAttribute('listener', 'true');
        const form = $(this);
        const inputs = form.find("input");
        let serializedData = form.serialize();
        serializedData += `&project_id=${projectId}`

        inputs.prop("disabled", true);

        request = $.ajax({
          url: "/projects/assign/vehicle",
          type: "post",
          data: serializedData
        });

        request.done(function(response, textStatus, jqXHR) {
          const res = JSON.parse(response);
          if (res.status) {
            // the row element
            getData("%", "listNotInProject", "notInProject");
            getData("%", "listInProject", "inProject");
            $('.keywoard').val('')

            // Change Card Value
            const textValue = $('#total-vehicle-value').text();
            $('#total-vehicle-value').text((Number(textValue) + (res.action == 'assign' ? 1 : -1)))
          }
          $('#toast-body-vehicle-project-toast').text(res.message);
          toast.show();
        });
      }

      getData("%", "listNotInProject", "notInProject");
      getData("%", "listInProject", "inProject");
    })
  </script>
@endsection
