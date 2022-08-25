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
          url: '/admin/project/person',
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

                let className,
                  labelName;

                if (inSameProject) {
                  labelName = "Remove";
                  className = 'btn-danger';
                } else if (item.project_id) {
                  labelName = "Assigned";
                  className = 'btn-secondary';
                } else {
                  labelName = "Assign";
                  className = 'btn-success'
                }


                str +=
                  `
                    <div class="col-xxl-3">
                      <div class="card">
                        <div class="card-body d-flex align-items-center">
                          <span class="w-50 text-truncate">${item.name}</span>
                          <form action="#" method="POST" class="ms-auto" listener="false">
                            @csrf
                            <input type="hidden" name="person_id" value="${item.id}">
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
          url: "/admin/assign/person",
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
            const textValue = $('#total-person-value').text();
            $('#total-person-value').text((Number(textValue) + (res.action == 'assign' ? 1 : -1)))
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
