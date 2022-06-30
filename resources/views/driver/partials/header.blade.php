<header class="d-flex justify-content-between align-items-center p-3">
  <span style="cursor: pointer;" onclick="history.back()">
    @if (!Request::is('/'))
      <i class='bi bi-caret-left-fill fs-3'></i>
    @endif
  </span>
  <span class="fs-4 fw-bold text-center" style="flex: 1">
    {{ $title }}
  </span>
  @if (Request::is('/'))
    <form action="/logout" method="POST">
      @csrf
      <button class="btn btn-primary" type="submit"><i class="bi bi-box-arrow-right"></i></button>
    </form>
  @endif

  </div>
</header>
