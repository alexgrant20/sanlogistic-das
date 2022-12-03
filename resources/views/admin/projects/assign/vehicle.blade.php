@extends('admin.layouts.main')


@section('container')
  <div class="page-content">
    @include('admin.projects.assign.components.header')
    @include('admin.projects.assign.components.main-section')
  </div>
  <script type="text/javascript" defer>
    $(document).ready(function() {

      const toast = new bootstrap.Toast(document.getElementById('toast'))

      $('#keywordNotInProject').on('keyup', function() {
        getData($(this).val() || "%", "listNotInProject", "notInProject");
      })

      $('#keywordInProject').on('keyup', function() {
        getData($(this).val() || "%", "listInProject", "inProject");
      })

      let projectId = getCookie('project_id');

      function getData(keyword, templateId, type) {
        $.ajax({
          url: "{{ route('admin.projects.vehicles') }}",
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
                            <div class="card-body m-auto text-uppercase fs-3">
                                No Data
                            </div>
                        </div>
                    </div>`;
            } else {

              $.each(data, function(index, item) {
                const inSameProject = item.project_id == projectId;

                const value = inSameProject ? "Remove" : "Assign";

                let btnIcon = 'fa-solid '.concat(inSameProject ? "fa-xmark" : "fa-add");

                let className;

                if (inSameProject) {
                  className = 'btn-danger';
                } else if (item.project_id) {
                  className = 'btn-secondary';
                } else {
                  className = 'btn-success'
                }

                const plateColor = item.vehicles_license_plate_color.id == '1' ? "#fff" : "#9b870c";

                const kir = item.vehicles_documents.find(e => e.type === 'kir');
                const stnk = item.vehicles_documents.find(e => e.type === 'stnk');

                let kir_month = "XX";
                let kir_year = "XX";

                if (kir && kir.expire) {
                  const expire = kir.expire.split("-")
                  kir_month = expire[1];
                  kir_year = expire[0].slice(-2);
                }

                let stnk_month = "XX";
                let stnk_year = "XX";

                if (stnk && stnk.expire) {
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
                              <a target="_blank" href="/admin/vehicles/${item.license_plate}/edit" class="d-flex flex-column align-items-center mw-100 text-truncate p-2">
                                  <span class="text-dark fs-4 fw-bold mb-1 text-truncate text-center w-75" id="plateNumber">${item.license_plate}</span>
                                  <hr class="w-100 border border-white border-5 m-0 mb-1">
                                  <div class="d-flex justify-content-between w-100">
                                    <span class="text-dark" id="kirYear">${kir_month}.${kir_year}</span>
                                    <span class="text-dark" id="stnkYear">${stnk_month}.${stnk_year}</span>
                                  </div>
                              </a>
                            </div>
                            <form action="#" method="POST" class="d-flex align-items-center justify-content-center h-100" listener="false">
                              @csrf
                              <input type="hidden" name="vehicle_id" value="${item.id}">
                              <input type="hidden" name="action" value="${value.toLowerCase()}">
                              <button type="submit" class="btn ${className} d-flex align-items-center justify-content-center" style="width:35px; height:35px;">
                                <i class="${btnIcon}"></i>
                              </button>
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
        $('button').prop("disabled", true);

        request = $.ajax({
          url: "{{ route('admin.projects.assign.vehicles') }}",
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
          $('#toast-body-toast').text(res.message);
          toast.show();
        });
      }

      getData("%", "listNotInProject", "notInProject");
      getData("%", "listInProject", "inProject");

      $('#project_name').on('change', function(e) {
        const project_name = e.target.value;
        let url = window.location.href;
        url = url.replace(/\/[^\/]*$/, `/${project_name}`);
        window.location.href = url;
      });
    })
  </script>
@endsection
