<div class="bg-dash-dark-2 py-4">
  <div class="container-fluid">
    <h2 class="h5 mb-0" style="letter-spacing: 0.5px">
      Assign
      @if (Request::is('*/assign/address/*'))
        Address
      @elseif (Request::is('*/assign/vehicle/*'))
        Vehicle
      @elseif (Request::is('*/assign/person/*'))
        Person
      @endif
      <select name="project_name" id="project_name" class="fs-5 text-primary ms-1 form-select w-auto d-inline">
        @foreach ($projects as $project_opt)
          <option value="{{ $project_opt->name }}" @selected($project_opt->name == $project->name)>
            {{ $project_opt->name }}
          </option>
        @endforeach
      </select>
    </h2>
  </div>
</div>
