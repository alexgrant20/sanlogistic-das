@extends('layouts.index_custom')

@section('add_headJS')
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const table = $('table[data-display="datatables"]').DataTable({
        responsive: {
          details: {
            display: $.fn.dataTable.Responsive.display.modal({
              header: function(row) {
                const data = row.data();
                return "Details for " + data[1];
              },
            }),
            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
              tableClass: "table",
            }),
          },
        },
        columnDefs: [{
          targets: [0],
          visible: false,
          searchable: false,
        }],
      });

      $.fn.dataTable.Buttons.defaults.dom.button.className =
        "btn";

      const totalRow = table.rows().data().length;

      new $.fn.dataTable.Buttons(table, {
        buttons: [{
            extend: "collection",
            text: "Export",
            className: "btn-outline-primary",
            buttons: [{
                text: "Excel",
              },
              {
                extend: "pdfHtml5",
                exportOptions: {
                  columns: [":visible"],
                },
              },
            ],
          },
          {
            extend: "searchBuilder",
            className: "btn-outline-primary",
          },
          {
            extend: "colvis",
            className: "btn-outline-primary",
          },
        ],
      });

      if (totalRow) {
        table.button().add(0, {
          text: "Pay Activity",
          className: "btn-success",
          action: async function(e, dt, button, config) {
            const ids = [];
            table.rows().data().map((e) => ids.push(e[0]));
            const uniqueIds = [...new Set(ids)];

            const data = JSON.stringify(uniqueIds);

            console.log(data);

            await fetch("/finances/pay", {
              method: "post",
              headers: {
                "X-CSRF-Token": $("input[name=_token]").val(),
              },
              body: data,
            });

            location.reload();
          },
        })
      }

      table.buttons(0, null).containers().appendTo("#actionContainer");
    });
  </script>
@endsection

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Activities</h2>
      </div>
    </div>
    <section class="container-fluid">
      @include('partials.index_response')
      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <table class="table table-hover text-center  table-dark nowrap" style="width: 100%" data-display="datatables">
        <thead>
          <tr class="header">
            <th>User ID</th>
            <th>Action</th>
            <th>Project</th>
            <th>Nama Pengendara</th>
            <th>BBM</th>
            <th>Toll</th>
            <th>Parkir</th>
            <th>Rertibusi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($activities as $activity)
            <tr>
              <td>{{ $activity->user_id }}</td>
              <td>
                <form action="{{ url('/finances/reject') }}" method="POST">
                  @csrf
                  <input type="hidden" name="project_id" value="{{ $activity->project_id }}">
                  <input type="hidden" name="user_id" value="{{ $activity->user_id }}">
                  <button class="btn badge bg-primary fs-6 me-2">
                    Deny
                  </button>
                </form>
              </td>
              <td>{{ $activity->project_name }}</td>
              <td>{{ $activity->person_name }}</td>
              <td>@money($activity->total_bbm)</td>
              <td>@money($activity->total_toll)</td>
              <td>@money($activity->total_park)</td>
              <td>@money($activity->total_retribution)</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </div>
@endsection
