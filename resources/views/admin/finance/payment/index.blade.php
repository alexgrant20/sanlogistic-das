@extends('admin.layouts.index-custom')

@section('add_headJS')
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const table = $('table[data-display="datatables"]').DataTable({
        responsive: true,
        columnDefs: [{
          targets: [0],
          visible: false,
        }, {
          targets: [0, 1, 2],
          searchable: false,
          orderable: false,
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
              text: "PDF",
              action: function() {
                $("#exportPDF").modal("show");
              }
            },
          ],
        }, ],
      });

      if (totalRow) {
        table.button().add(0, {
          text: "Pay Activity",
          className: "btn-primary",
          action: function(e, dt, button, config) {
            $("#modal").modal("show");

            $('#modal button.ok').off().on('click', function() {
              $('#modal').modal('hide');

              paidHandler(e)
            });
          },
        })
      }
      table.buttons(0, null).containers().appendTo("#actionContainer");

      async function paidHandler(e) {
        const ids = [];
        table.rows().data().map((e) => ids.push(e[0]));
        const uniqueIds = [...new Set(ids)];

        const data = JSON.stringify(uniqueIds);

        await fetch("{{ route('admin.finances.pay') }}", {
          method: "post",
          headers: {
            "X-CSRF-Token": $("input[name=_token]").val(),
          },
          body: data,
        });

        location.reload();

      }
    });
  </script>
@endsection

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Pay Activity</h2>
      </div>
    </div>

    {{-- MAKE SURE MODAL --}}
    <x-modal id="modal" size="modal-lg">
      <x-slot:body>
        <div class="container-fluid text-center pt-3">
          <div class="mb-4">
            <i class="bi bi-exclamation-circle text-danger display-1"></i>
          </div>
          <p class="display-6 text-white mb-1 fw-bold">Paid Those Activity?</p>
          <p class="fs-3 text-gray-700">You will not able to recover it</p>
        </div>
      </x-slot:body>
      <x-slot:footer>
        <button type="button" class="btn btn-success ok">Submit</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </x-slot:footer>
    </x-modal>

    {{-- EXCEL MODAL --}}
    <x-modal id="exportExcel" size="modal-lg" title="Export">
      <x-slot:body>
        <form id="exportExcelForm" method="post" action="{{ route('admin.finances.export.excel') }}"
          enctype="multipart/form-data">
          @csrf

          {{-- <div class="mb-3">
            <label class="form-label">Pilih Bulan</label>
            <div class="form-group">
              <select class="form-select" name="month">
                <option value="{{ now()->format('m') }}">{{ now()->format('F') }}</option>
                <option value="{{ now()->submonth(1)->format('m') }}">{{ now()->submonth(1)->format('F') }}
                </option>
              </select>
            </div>
          </div> --}}

          <label class="form-label">Pilih Project</label>
          <div class="form-group">
            <select class="form-select" name="project_id">
              @foreach ($projects as $project_id => $project_name)
                <option value="{{ $project_id }}">{{ $project_name }}</option>
              @endforeach
            </select>
          </div>
        </form>
      </x-slot:body>
      <x-slot:footer>
        <button type="button" class="btn btn-success" onclick="$('#exportExcelForm').submit()">Export</button>
      </x-slot:footer>
    </x-modal>

    {{-- EXCEL PDF --}}
    <x-modal id="exportPDF" size="modal-lg" title="Export">
      <x-slot:body>
        <form id="exportPDFForm" method="post" action="{{ route('admin.finances.export.pdf') }}"
          enctype="multipart/form-data">
          @csrf

          <label class="form-label">Pilih Project</label>
          <div class="form-group">
            <select class="form-select" name="project_id">
              @foreach ($projects as $project_id => $project_name)
                <option value="{{ $project_id }}">{{ $project_name }}</option>
              @endforeach
            </select>
          </div>
        </form>
      </x-slot:body>
      <x-slot:footer>
        <button type="button" class="btn btn-success" onclick="$('#exportPDFForm').submit()">Export</button>
      </x-slot:footer>
    </x-modal>

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
            <th></th>
            <th></th>
            <th>Project</th>
            <th>Nama Pengendara</th>
            <th>BBM</th>
            <th>Toll</th>
            <th>Parkir</th>
            <th>Load</th>
            <th>Unload</th>
            <th>Maintenance</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($activities as $activity)
            <tr>
              <td>{{ $activity->user_id }}</td>
              <td></td>
              <td>
                <form action="{{ route('admin.finances.reject') }}" method="POST">
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
              <td>@money($activity->total_load)</td>
              <td>@money($activity->total_unload)</td>
              <td>@money($activity->total_maintenance)</td>
              <td>@money($activity->total_bbm + $activity->total_toll + $activity->total_park + $activity->total_load + $activity->total_unload + $activity->total_maintenance)</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </div>
@endsection
