<header class="d-flex justify-content-between align-items-center ba-secondary p-3">
  <span style="cursor: pointer;" onclick="history.back()">
    @if (!Request::is('/'))
      <i class='bi bi-caret-left-fill fs-3'></i>
    @endif
  </span>
  <span class="fs-4 fw-bold text-center" style="flex: 1">
    {{ $title }}
  </span>
  <div class="d-flex align-items-center justify-content-end">
    <div class="dropdown">
      <a class="dropdown-toggle" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        {{ auth()->user()->username }}
      </a>

      <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <li>
          <form action="/logout" method="POST">
            @csrf
            <button class="btn text-start w-100" type="submit">Logout</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</header>
