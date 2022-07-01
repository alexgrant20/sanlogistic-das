<header class="d-flex justify-content-between align-items-center p-3">
  @if (!Request::is('/'))
    <a href="{{ url()->previous() }}" style="cursor: pointer;">
      <i class='bi bi-caret-left-fill fs-3 text-primary'></i>
    </a>
  @endif
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
