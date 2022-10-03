@extends('driver.layouts.main')

@section('content')
  <section>
    @include('driver.components.vehicle-checklist-form')

    @role('mechanic')
      <div class="mb-3">
        <input type="checkbox" name="periodic_maintenance" id="periodic_maintenance" value="1">
        <label for="periodic_maintenance">Periodic Maintenance</label>
      </div>
    @endrole
    </form>


  </section>
@endsection

@section('footJS')
  <script>
    $(document).ready(function() {
      let totalImage = 1;
      getVehicleLastStatus()
      $("#add-image").click((e) => {
        totalImage++;
        $("#image-container")
          .last()
          .append(
            `
            <div class="mb-5">
              <x-input-image id="image_${totalImage}" :label="__('Image')" />
              <div class="mt-5">
                <label class="form-label fs-5 text-primary" for="image_${totalImage}_description">{{ __('Image Description') }}</label>
                <textarea class="form-control" name="image_${totalImage}_description" id="image_${totalImage}_description"></textarea>
              </div>
            </div>
          `
          );

        // Check if exeeding
        if (totalImage === 4) {
          $("#add-image").remove();
          return;
        }
      });
    });
  </script>
@endsection
