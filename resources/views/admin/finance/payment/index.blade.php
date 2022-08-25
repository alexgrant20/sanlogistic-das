@extends('admin.layouts.index-custom')

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
                action: function() {
                  $("#exportExcel").modal("show");
                }
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

            await fetch("/admin/finances/pay", {
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

    <!-- Import Modal -->
    <div class="modal fade" id="exportExcel" tabindex="-1" aria-labelledby="importExcelLabel" aria-hidden="true">
      <form method="post" action="{{ route('admin.finance.export.excel.accepted') }}" enctype="multipart/form-data">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="importExcelLabel">Import</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              @csrf

              <div class="mb-3">
                <label class="form-label">Pilih Bulan</label>
                <div class="form-group">
                  <select class="form-select" name="month">
                    <option value="{{ now()->format('m') }}">{{ now()->format('F') }}</option>
                    <option value="{{ now()->submonth(1)->format('m') }}">{{ now()->submonth(1)->format('F') }}
                    </option>
                  </select>
                </div>
              </div>

              <label class="form-label">Pilih Project</label>
              <div class="form-group">
                <select class="form-select" name="project_id">
                  @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Export</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <section class="container-fluid">
      <div class="row mb-4 g-3">
        <x-summary-box summaryTitle="Approved" summaryTotal="{{ $activities->count() }}" icon="bi bi-journal-check"
          id="total-approved-activity" disabled />
      </div>
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
                <form action="{{ route('admin.finance.reject') }}" method="POST">
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
