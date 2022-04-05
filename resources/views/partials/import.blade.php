@if (session()->has('importErrorList'))
  <div class="modal openModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title text-primary fw-bold">Erorr List</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-danger">
            <tr>
              <th>Row</th>
              <th>Attribute</th>
              <th>Errors</th>
              <th>Value</th>
            </tr>
            @foreach (session()->get('importErrorList') as $validation)
              <tr>
                <td>{{ $validation->row() }}</td>
                <td>{{ $validation->attribute() }}</td>
                <td>
                  <ul>
                    @foreach ($validation->errors() as $e)
                      <li>{{ $e }}</li>
                    @endforeach
                  </ul>
                </td>
                <td>
                  {{ $validation->values()[$validation->attribute()] }}
                </td>
              </tr>
            @endforeach
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endif

<!-- Import Modal -->
<div class="modal fade" id="importExcel" tabindex="-1" aria-labelledby="importExcelLabel" aria-hidden="true">
  <form method="post" action="{{ url($importPath) }}" enctype="multipart/form-data">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="importExcelLabel">Import</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @csrf

          <label class="form-label">Pilih file excel</label>
          <div class="form-group">
            <input class="form-control" type="file" name="file" required="required">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Import</button>
        </div>
      </div>
    </div>
  </form>
</div>
