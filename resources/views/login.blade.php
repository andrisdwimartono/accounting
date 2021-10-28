<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset ("/assets/cto/img/favicon.ico") }}">

    <title>Signin Template for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset ("/assets/bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{ asset ("/assets/cto/css/cakrudtemplate-signin.css") }}">

    <!-- Font Awesome JS -->
    <script defer src="{{ asset ("assets/fontawesome/js/solid.js") }}"></script>
    <script defer src="{{ asset ("assets/fontawesome/js/fontawesome.js") }}"></script>

  </head>

  <body class="text-center">
    <form action="{{ route('login') }}" method="post" class="form-signin">
      <img class="mb-4" src="{{ asset ("/assets/cto/img/apple-touch-icon.png") }}" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Sign In</h1>
      @csrf
      @if(session('errors'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Something it's wrong:
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
              <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
              </ul>
          </div>
      @endif
      @if (Session::has('success'))
          <div class="alert alert-success">
              {{ Session::get('success') }}
          </div>
      @endif
      @if (Session::has('error'))
          <div class="alert alert-danger">
              {{ Session::get('error') }}
          </div>
      @endif
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted"><span class="text-muted">&#169; <a href="www.maos.info">maos.info</a> @2021</span><br>
            <span class="text-muted"><i class="fas fa-facebook"></i> <a href="#">maos info</a> | <i class="fas fa-instagram"></i><a href="https://www.instagram.com/maosinfo">maosinfo</a> | <i class="fas fa-twitter"></i><a href="#">@maosinfo</a></span></p>

    </form>
  </body>
</html>
