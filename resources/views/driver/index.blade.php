@extends('driver.layouts.main')

@section('content')
  <div class="container-fluid">
    <div class="row row-cols-sm-3 row-cols-md-4 row-cols-xxl-5 g-4">
      <x-menu-item>
        <x-slot name="backgroundColor">{{ is_null(session()->get('activity_id')) ? 'bg-blue' : 'bg-green' }}</x-slot>
        <x-slot name="icon">{{ is_null(session()->get('activity_id')) ? 'bi-clipboard-plus-fill' : 'bi-flag' }}
        </x-slot>
        <x-slot name="text">Activity</x-slot>
        <x-slot name="link">
          {{ is_null(session()->get('activity_id')) ? '/driver/activities/create' : '/driver/activities/' . session()->get('activity_id') . '/edit' }}
        </x-slot>
      </x-menu-item>
      {{-- TO-DO --}}
      {{-- <x-menu-item>
        <x-slot name="backgroundColor">bg-brown</x-slot>
        <x-slot name="icon">bi-clipboard2-check-fill</x-slot>
        <x-slot name="text">Checklist</x-slot>
        <x-slot name="link">#</x-slot>
      </x-menu-item> --}}
      <x-menu-item>
        <x-slot name="backgroundColor">bg-purplish</x-slot>
        <x-slot name="icon">bi-arrow-clockwise</x-slot>
        <x-slot name="text">Perjalanan</x-slot>
        <x-slot name="link">{{ route('driver.activity.index') }}</x-slot>
      </x-menu-item>
      {{-- TO-DO --}}
      {{-- <x-menu-item>
        <x-slot name="backgroundColor">bg-darkGreen</x-slot>
        <x-slot name="icon">bi-cash-coin</x-slot>
        <x-slot name="text">Keuangan</x-slot>
        <x-slot name="link">#</x-slot>
      </x-menu-item> --}}
      <x-menu-item>
        <x-slot name="backgroundColor">bg-green</x-slot>
        <x-slot name="icon">bi-map</x-slot>
        <x-slot name="text">{{ __('All Location') }}</x-slot>
        <x-slot name="link">{{ route('driver.menu.location') }}</x-slot>
      </x-menu-item>
    </div>
  </div>
@endsection
