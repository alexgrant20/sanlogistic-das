<div class="btn-hover">
  <a href="{{ $link }}" class="d-flex align-items-center gap-4 {{ $backgroundColor }} rounded p-3">
    <div>
      <i class="{{ $icon }} display-5 display-sm-6 text-gray-400"></i>
    </div>
    <div class="d-flex flex-column mw-100 overflow-hidden gap-1">
      <span class="fw-bold fs-3 text-gray-300">{{ $label }}</span>
      <span class="fs-5 text-gray-500 clipping">{{ $description }}</span>
    </div>
  </a>
</div>
