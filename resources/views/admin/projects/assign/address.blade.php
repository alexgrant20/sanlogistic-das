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
          url: '/admin/project/address',
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
                                No data
                            </div>
                        </div>
                    </div>`;
            } else {

              $.each(data, function(index, item) {

                const inSameProject = item.project_id == projectId;

                const value = inSameProject ? "Remove" : "Assign";
                const btnIcon = 'fa-solid '.concat(inSameProject ? "fa-xmark" : "fa-add");

                const className = inSameProject ? "btn-danger" : "btn-success";

                let iconClass;

                switch (Number(item.address_type_id)) {
                  case 1:
                    // Main Office
                    iconClass = 'bi bi-building';
                    break;

                  case 2:
                    // Delivery Location
                    iconClass = 'bi bi-geo-alt';
                    break;

                  case 3:
                    // Pool
                    iconClass = 'bi bi-house-fill';
                    break;

                  case 4:
                    // Station
                    iconClass = 'bi bi-lightning-charge-fill';
                    break;

                  case 5:
                    // Workshop
                    iconClass = 'bi bi-tools';
                    break;

                  case 6:
                    // Pkb/Samsat
                    iconClass = 'bi bi-card-text';
                    break;

                  default:
                    iconClass = 'bi bi-question-circle-fill';
                }

                str +=
                  `
                    <div class="col-xxl-3">
                        <div class="card">
                          <div class="card-body d-flex align-items-center">
                          <i class="${iconClass} fs-3 me-2"></i>
                            <span class="text-truncate me-2">${item.name}</span>
                            <form method="POST" class="ms-auto" listener="false">
                              @csrf
                              <input type="hidden" name="address_id" value="${item.id}">
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
          url: "/admin/assign/address",
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
            const textValue = $('#total-address-value').text();
            $('#total-address-value').text((Number(textValue) + (res.action == 'assign' ? 1 : -1)))
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
