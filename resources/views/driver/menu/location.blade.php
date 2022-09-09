@extends('driver.layouts.main')

@section('content')
  <section>
    <label for="address" class="form-label fs-5 text-primary">Pilih Lokasi</label>
    <select id="address" name="address" class="form-dark form-select form-select-lg mb-3">
      <option value="">Select Address</option>
      @foreach ($addresses as $address)
        {{-- TO-DO: Change to current activity destination address --}}
        @if (isset($addressData) && $addressData->id === $address->id)
          <option value="{{ $address->id }}" selected>{{ $address->name }}</option>
        @else
          <option value="{{ $address->id }}">{{ $address->name }}</option>
        @endif
      @endforeach
    </select>

    @if (isset($addressData))
      <iframe
        src="https://maps.google.com/maps?q={{ $addressData->latitude }},{{ $addressData->longitude }}&hl=id;z=14&amp;output=embed"
        frameborder="0" width="100%" height="500"></iframe>
    @endif
  </section>
@endsection

@section('footJS')
  <script>
    $('#address').on('change', (e) => {
      window.location.href = `/driver/location/${e.target.value}`;
    })
  </script>
@endsection
