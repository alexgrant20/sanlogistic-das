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
        }],
      });

      table.buttons(0, null).containers().appendTo("#actionContainer");

      $(".selectable input[type='checkbox']").on("click", function() {
        $(this).closest("tr").toggleClass("selected");

        const totalSelected = table.rows(".selected").data().length;
        const buttonExists = $(".acceptBtn").length;

        if (totalSelected && !buttonExists) {
          table.button().add(0, {
            action: function(e, dt, button, config) {
              $("#modal").modal("show");

              $('#modal button.ok').off().on('click', function() {
                $('#modal').modal('hide');

                acceptanceHandler(e)
              });
            },
            text: "Accept",
            className: "acceptBtn btn-primary",
          });
        } else if (totalSelected == 0 && buttonExists) {
          table.button("0").remove();
        }

        async function acceptanceHandler(e) {
          const ids = [];
          table
            .rows(".selected")
            .data()
            .map((e) => ids.push(e[0]));

          const data = JSON.stringify(ids);

          await fetch("/admin/finances/approve", {
            method: "post",
            headers: {
              "X-CSRF-Token": $("input[name=_token]").val(),
            },
            body: data,
          });

          location.reload();
        }
      });
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
      <x-modal id="modal" size="modal-lg">
        <x-slot:body>
          <div class="container-fluid text-center pt-3">
            <div class="mb-4">
              <i class="bi bi-exclamation-circle text-warning display-1"></i>
            </div>
            <p class="display-6 text-white mb-1 fw-bold">Approve Those Activity?</p>
            <p class="fs-3 text-gray-700">You will not able to recover it</p>
          </div>
        </x-slot:body>
        <x-slot:footer>
          <button type="button" class="btn btn-success ok">Submit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </x-slot:footer>
      </x-modal>
      <div class="row mb-4 g-3">
        <x-summary-box summaryTitle="Total" summaryTotal="{{ $activities->count() }}" icon="bi bi-journal-text"
          id="total-activity" link="{{ route('admin.finances.approval') }}" :active="empty(Request::getQueryString()) ? true : false" />

        <x-summary-box summaryTitle="Pending"
          summaryTotal="{{ $activities->filter(fn($item) => $item->status === 'pending')->count() }}"
          icon="bi bi-journal-medical" id="total-pending-activity"
          link="{{ route('admin.finances.approval') . '?status=pending' }}" :active="Request::getQueryString() === 'status=pending' ? true : false" />

        <x-summary-box summaryTitle="Rejected"
          summaryTotal="{{ $activities->filter(fn($item) => $item->status === 'rejected')->count() }}"
          icon="bi bi-journal-x" id="total-rejected-activity"
          link="{{ route('admin.finances.approval') . '?status=rejected' }}" :active="Request::getQueryString() === 'status=rejected' ? true : false" />
      </div>
      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <div class="table-responsive">
        <table class="table table-responsive table-hover text-center  table-dark nowrap" style="width: 100%"
          data-display="datatables">
          <thead>
            <tr class="header">
              <th>ID</th>
              <th></th>
              <th>Check</th>
              <th>Action</th>
              <th>Tanggal</th>
              <th>Nomor DO</th>
              <th>Nama Pengendara</th>
              <th>BBM</th>
              <th>Toll</th>
              <th>Parkir</th>
              <th>Retribusi</th>
            </tr>
          </thead>
          <tbody class="selectable align-items-center">
            @foreach ($activities_filtered as $activity)
              <tr class="my-auto">
                <td>{{ $activity->id }}</td>
                <td></td>
                <td>
                  <input type="checkbox" id="btncheck1" class="form-check-input">
                </td>
                <td>
                  <a href="{{ route('admin.finances.approval.edit', $activity->id) }}" class="badge bg-primary fs-6">
                    <i class="bi bi-currency-dollar"></i>
                  </a>
                </td>
                <td>{{ $activity->departure_date }}</td>
                <td>{{ $activity->do_number }}</td>
                <td>{{ $activity->name }}</td>
                <td>@money($activity->bbm_amount)</td>
                <td>@money($activity->toll_amount)</td>
                <td>@money($activity->parking_amount)</td>
                <td>@money($activity->retribution_amount)</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>
  </div>
@endsection
