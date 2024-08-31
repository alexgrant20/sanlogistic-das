@extends('admin.layouts.main')

@section('container')
   <div class="page-content">
      <!-- Page Header-->
      <div class="bg-dash-dark-2 py-4">
         <div class="container-fluid">
            <h2 class="h5 mb-0">Activities</h2>
         </div>
      </div>
      <section class="container-fluid">
         <div class="row mb-4 g-3">
            @foreach ($box as $status => $totalActivity)
               <x-summary-box summaryTitle="{{ $status != '' ? $status : 'Total Activity' }}"
                  summaryTotal="{{ $totalActivity }}" icon="bi bi-journal-check" id="total-{{ $status }}-activity"
                  link="{{ route('admin.activities.index') . '?status=' . $status }}" :active="Request::getQueryString() === 'status=' . $status ? true : false" />
            @endforeach
         </div>

         {{-- EXCEL MODAL --}}
         <x-modal id="exportExcel" size="modal-lg" title="Export">
            <x-slot:body>
               <form id="exportExcelForm" method="post" action="{{ route('admin.activities.export.excel') }}">
                  @csrf

                  <div class="mb-3">
                     <label for="start_date" class="form-label">Start Date</label>
                     <input type="date" class="form-control" id="start_date" name="start_date">
                  </div>

                  <div class="mb-3">
                     <label for="end_date" class="form-label">End Date</label>
                     <input type="date" class="form-control" id="end_date" name="end_date">
                  </div>
               </form>
            </x-slot:body>
            <x-slot:footer>
               <button type="button" class="btn btn-success" onclick="$('#exportExcelForm').submit()">Export</button>
            </x-slot:footer>
         </x-modal>

         <x-modal id="logModal" title="Activity Log" size="modal-lg">
            <x-slot:body>
               <table class="table table-hover table-dark text-center nowrap" style="widths: 100%">
                  <thead>
                     <tr>
                        <th>Status</th>
                        <th>By</th>
                        <th>Time</th>
                        <th>Role</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </x-slot:body>
            <x-slot:footer>
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </x-slot:footer>
         </x-modal>

         <h4 class="text-primary fw-bold">Action</h4>
         <hr>
         <input type="hidden" id="tableName" value="activities">

         <div class="d-flex mb-5" id="actionContainer">
            <button class="btn btn-primary" type="button" id="exportExcelBtn">Export Excel</button>
         </div>

         <h4 class="text-primary fw-bold">Table</h4>
         <hr>
         <div class="table-responsive">
            <table class="table table-striped table-dark text-center" id="activities">
               <thead>
                  <tr class="header">
                     <th>ID</th>
                     <th>Tanggal</th>
                     <th>Nama Pengendara</th>
                     <th>Project</th>
                     <th>Nomor Kendaraan</th>
                     <th>Nomor DO</th>
                     <th>Lokasi Keberangkatan</th>
                     <th>Lokasi Tujuan</th>
                     <th>Jenis Aktifitas</th>
                     <th>Status</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
      </section>
   </div>
@endsection

@section('headJS')
   <script>
      document.addEventListener("DOMContentLoaded", function() {
         $('#activities').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('admin.activities.list', $queryStatus) }}",
            columns: [{
                  data: 'action',
                  searchable: 'false',
                  orderable: false,
                  render: function(row, display, data) {
                     let edit = "{{ route('admin.activities.edit', 'id') }}";
                     edit = edit.replace('id', data.id);

                     let templateActionForm = `
              <div class="dropdown">
                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('activity-edit')
                      <li>
                          <a href="${edit}" class="dropdown-item">
                            Edit
                          </a>
                      </li>
                    @endcan
                    <li>
                      <form method="post" class="logForm">
                        @csrf
                        <input type="hidden" name="id" value=${data.id} />
                        <button class="dropdown-item">
                            History Log
                        </button>
                      </form>
                    </li>
                    {addon}
                </ul>
              </div>`

                     let replaceTemp = '';

                     if (data.status === 'draft') {
                        replaceTemp = `
                  <li>
                    <button class="dropdown-item abort-btn" data-id="${data.id}">
                        Abort Activity
                    </button>
                  </li>
                `
                     }

                     templateActionForm = templateActionForm.replace('{addon}', replaceTemp);
                     return templateActionForm;
                  }
               },
               {
                  data: 'departure_date',
                  name: 'departure_date'
               },
               {
                  data: 'person_name',
                  name: 'person_name'
               },
               {
                  data: 'project_name',
                  name: 'project_name'
               },
               {
                  data: 'license_plate',
                  name: 'license_plate'
               },
               {
                  data: 'do_number',
                  name: 'do_number'
               },
               {
                  data: 'departure_name',
                  name: 'departure_name'
               },
               {
                  data: 'arrival_name',
                  name: 'arrival_name'
               },
               {
                  data: 'type',
                  name: 'type'
               },
               {
                  data: 'status',
                  name: 'status'
               },
            ],
            "drawCallback": function(settings) {
               $('.logForm').on('submit', async function(e) {
                  e.preventDefault();
                  const id = $(this).serializeArray()[1].value;
                  let url = "{{ route('admin.activities.logs', 'id') }}";
                  url = url.replace('id', id);

                  const res = await $.ajax({
                     method: 'GET',
                     url,
                  })

                  $('#logModal tbody').empty();

                  let template = '';

                  res.forEach(el => {
                     template += `<tr>
                    <td>${el.status} </td>
                    <td>${el.name}</td>
                    <td>${el.created_at}</td>
                    <td>${el.role}</td>
                  </tr>`
                  });

                  $('#logModal tbody').append(template);

                  $('#logModal').modal('show');
               });

               $('.abort-btn').click(function(e) {
                  e.preventDefault();
                  Swal.fire({
                     title: "Apakah Anda Yakin?",
                     color: "#ddd",
                     icon: "warning",
                     text: "Anda tidak dapat membatalkan aksi ini",
                     confirmButtonText: "Kirim",
                     showCancelButton: true,
                  }).then(async (result) => {
                     if (result.isConfirmed) {
                        const activity_id = $(this).attr('data-id');

                        await $.post("{{ route('admin.activities.cancel') }}", {
                           activity_id,
                           _token: "{{ csrf_token() }}"
                        });

                        $('#activities').DataTable().ajax.reload();

                        Swal.fire({
                           title: "Activity Successfully Canceled",
                           icon: "success"
                        });
                     }
                  });
               })
            }
         });

         $('#exportExcelBtn').click(function() {
            $('#exportExcel').modal('show');
         })
      });
   </script>
@endsection
