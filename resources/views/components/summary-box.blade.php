<div class="{{ $size }}">
  <a href="{{ $link }}"
    class="btn w-100 mb-0 {{ $active ? 'btn-primary disabled' : 'btn-secondary' }} {{ $customCardClass }} {{ $disabled ? 'disabled' : '' }} rounded">
    <div class="d-flex align-items-end justify-content-between mb-2 p-4">
      <div class="me-2 text-start">
        <i class="{{ $icon }} svg-icon svg-icon-sm svg-icon-heavy mb-4 fs-3"></i>
        <p class="text-sm text-uppercase lh-1 mb-0">{{ $summaryTitle }}</p>
      </div>
      <p class="text-xxl lh-1 mb-0" id="{{ $id }}-value">
        {{ $summaryTotal }}</p>
    </div>
    @if ($detail)
      <div class="d-flex bg-gray-800">
        <a class="d-flex text-center px-4 py-2" data-bs-toggle="collapse" href="#{{ $id }}">
          See More
        </a>
      </div>
    @endif
  </a>
  @if ($detail)
    <div class="collapse px-4 py-3 bg-dark" id="{{ $id }}">
      {{ $detailContent }}
    </div>
  @endif
</div>
