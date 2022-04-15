<div class="{{ $size ?? 'col-md-3 col-sm-6' }}">
  <a href="{{ $link ?? '#' }}" class="card mb-0 bg-dark {{ $customCardClass ?? '' }}">
    <div class="card-body p-0">
      <div class="d-flex align-items-end justify-content-between mb-2 p-4">
        <div class="me-2">
          <i class="bi {{ $icon }} svg-icon svg-icon-sm svg-icon-heavy text-gray-600 mb-2"></i>
          <p class="text-sm text-uppercase text-gray-600 lh-1 mb-0">{{ $summaryTitle ?? '' }}</p>
        </div>
        <p class="text-xxl lh-1 mb-0 {{ $summaryTotalColor ?? 'text-dash-color-1' }}" id="{{ $id }}-value">
          {{ $summaryTotal }}</p>
      </div>
      {{-- Pake detail bila memang ada detail --}}
      <div class="d-flex bg-gray-800 {{ $detail ?? 'd-none' }}">
        <a class="d-flex text-center px-4 py-2" data-bs-toggle="collapse" href="#{{ $id }}">
          See More
        </a>
      </div>
    </div>
  </a>
  <div class="collapse {{ $detail ?? 'd-none' }} px-4 py-3 bg-dark" id="{{ $id }}">
    {{ $details ?? '' }}
  </div>
</div>
