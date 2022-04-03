<!DOCTYPE html>
<html>

<head>
  <title>DAS Login</title>

  <!-- Script -->
  <script src="https://kit.fontawesome.com/2d78a8b052.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
  <script type='text/javascript' src="{{ asset('/vendor/jquery/jquery-3.6.0.min.js') }}"></script>
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/login.css') }}" />
</head>

<body>
  <div class="loginContainer">
    <img src="{{ asset('/img/SAN LOGO.png') }}" class="logo" alt="" />
    <div class="imageBackground"></div>
    <div class="login">
      <div class="wrapper">
        <div class="header">
          <h1>DS LOGIN</h1>
          <p>
            Sejumlah godaan akan datang kepada mereka yang tekun dan rajin, tapi seluruh godaan akan menyerang mereka
            yang bermalas-malasan.
          </p>
        </div>
        @if (session()->has('error'))
          <div class="alert alert-danger" role="alert">
            {{ session('error') }}
          </div>
        @endif
        <form action="{{ url('/login') }}" method="post" class="loginForm needs-validation" id="loginForm">
          @csrf
          <div class="inputControl mb-2">
            <label for="username"><i class="fas fa-user-alt"></i></label>
            <input class="form-control @error('username') is-invalid @enderror" type="text" name="username"
              id="username" value="{{ old('username') }}" placeholder="Username" required autofocus />
            @error('username')
              <div class="invalid-feedback mb-2">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div class="inputControl">
            <label for="password"><i class="fas fa-lock"></i></label>
            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password"
              id="password" placeholder="Password" required />
            @error('password')
              <div class="invalid-feedback mb-2">
                {{ $message }}
              </div>
            @enderror
          </div>
          <input class="submitBtn my-5" type="submit" name="login" value="Login" />
        </form>
      </div>
    </div>
  </div>
</body>

<script>
  $('#loginForm').on('submit', () => {
    $('.submitBtn').attr('disabled', true);
  })
</script>

</html>
