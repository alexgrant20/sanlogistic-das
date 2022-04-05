<div class="modal fade {{ $class ?? '' }}" tabindex="-1" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-dialog-centered {{ $size ?? '' }} modal-dialog-scrollable" role="document">
    <div class="modal-content shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="{{ Str::slug($title) }}-title">{{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{ $body }}
      </div>
      <div class="modal-footer">
        {{ $footer }}
      </div>
    </div>
  </div>
</div>
