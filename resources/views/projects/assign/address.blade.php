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
              <x-slot name="customCardClass">disabled</x-slot>
              <x-slot name="link">/projects/assign/vehicle/{{ $projectName }}</x-slot>
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

    </section>
  </div>
  <script type="text/javascript" defer>
    $(document).ready(function() {
      $('#keywordNotInProject').on('keyup', function() {
        getData($(this).val() || "%", "listNotInProject", "notInProject");
      })

      $('#keywordInProject').on('keyup', function() {
        getData($(this).val() || "%", "listInProject", "inProject");
      })

      let projectId = getCookie('project_id');

      function getData(keyword, templateId, type) {
        $.ajax({
          url: '/api/project/address',
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

                console.log(item)

                const inSameProject = item.project_id == projectId;

                const value = inSameProject ? "Remove" : "Assign";

                const className = inSameProject ? "btn-secondary" : "btn-primary";

                let iconClass;

                switch (Number(item.address_type_id)) {
                  case 1:
                    iconClass = 'far fa-building';
                    break;

                  case 2:
                    iconClass = 'fas fa-dolly';
                    break;

                  case 3:
                    iconClass = 'fas fa-toolbox';
                    break;

                  case 4:
                    iconClass = 'fas fa-gas-pump';
                    break;

                  case 5:
                    iconClass = 'fas fa-hammer';
                    break;

                  case 6:
                    iconClass = 'fas fa-id-card';
                    break;

                  default:
                    iconClass = 'far fa-question-circle';
                }

                str +=
                  `
                    <div class="col-xxl-3">
                        <div class="card">
                          <div class="card-body d-flex align-items-center">
                          <i class="${iconClass} fa-3x me-2"></i>
                            <span class="text-truncate me-2">${item.name}</span>
                            <form action="" method="POST" class="ms-auto">
                              <input type="hidden" name="address_id" value="${item.address_id}">
                              <input type="hidden" name="action" value="${value.toLowerCase()}">
                              <input type="submit" value="${value}" class="btn ${className}">
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
          } else {
            console.log("false")
          }
        });

        request.fail(function(jqXHR, textStatus, errorThrown) {
          console.error(
            'ERROR'
          );
        });

        request.always(function() {
          inputs.prop("disabled", false);
        });
      }

      getData("%", "listNotInProject", "notInProject");
      getData("%", "listInProject", "inProject");
    })
  </script>
@endsection
