<div class="modal fade {{ $class ?? '' }}" tabindex="-1" role="dialog" aria-modal="true" id={{ $id }}>
  <div class="modal-dialog modal-dialog-centered {{ $size }} modal-dialog-scrollable" role="document">
    <div class="modal-content shadow">
      <div class="modal-header">
        @if (!empty($title))
          <h5 class="modal-title" id="{{ Str::slug($title) }}-title">{{ $title }}</h5>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      @if (!empty($body))
        <div class="modal-body">
          {{ $body }}
        </div>
      @endif
      @if (!empty($footer))
        <div class="modal-footer">
          {{ $footer }}
        </div>
      @endif
    </div>
  </div>
</div>
