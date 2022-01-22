<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
      @if(isset($globalsetting->logo_instansi))
        <link rel="icon" href="{{ asset ('/logo_instansi/'.$globalsetting->logo_instansi) }}">
      @else
        <link rel="icon" href="{{ asset ('/assets/images/logo_default.png') }}">
      @endif
    <title>Sistem Informasi Akuntansi Login Page</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset ("/assets/bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{ asset ("/assets/cto/css/cakrudtemplate-signin.css") }}">

    <!-- Font Awesome JS -->
    <script defer src="{{ asset ("assets/fontawesome/js/solid.js") }}"></script>
    <script defer src="{{ asset ("assets/fontawesome/js/fontawesome.js") }}"></script>
    <link href="{{ asset ("/assets/node_modules/jquery-toast-plugin/dist/jquery.toast.min.css") }}" rel="stylesheet" />

    <style>
      body {
        background : url("{{ asset ('/main_background/'.$globalsetting->main_background) }}") rgba(0, 0, 0, 0.5);
        background-size: cover;
        background-blend-mode: multiply;
      }  
    </style>
    
  </head>

  <body class="text-center">
    <h4 style="position:absolute;top:80px;"><span style="white-space: pre-line; color:#ddd;">{{$globalsetting->nama_sia}}</span></h4>

    <form action="{{ route('login') }}" method="post" class="form-signin">
      @if($globalsetting->logo_sia)
        <!-- <img class="mb-4" src="{{ asset ('/logo_sia/'.$globalsetting->logo_sia) }}" alt="" height="80"> -->
      @else
        <!-- <img class="mb-4" src="{{ asset ('/assets/images/logo_sia_default.png') }}" alt="" height="80"> -->
      @endif
      
      <h1 class="h5 mb-3 font-weight-normal" style="color:#fafafa;">Sign In</h1>
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
      @csrf
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
      <button class="btn btn-lg btn-primary btn-default" id="send_otp" type="button">Send OTP</button>
      <br><br>
      <label for="inputOTP" class="sr-only">Email OTP</label>
      <input type="text" id="inputOtp" class="form-control" name="otp" placeholder="OTP" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
    <script src="{{ asset ("/assets/motaadmin/vendor/global/global.min.js") }}"></script>
    <script src="{{ asset ("/assets/node_modules/jquery-toast-plugin/dist/jquery.toast.min.js") }}"></script>
    <script>
        $("#send_otp").on("click", function(data){
          $.ajax({
            url: "/send_otp",
            type: "post",
            data: {
              _token: $('input[name=_token]').val(),
              email: $("#inputEmail").val(),
              password: $("#inputPassword").val()
            },
            success: function(data){
              $.toast({
                    text: "OTP is Sent! Check your email!",
                    heading: 'Status',
                    icon: 'success',
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 10000,
                    position: 'mid-center',
                    textAlign: 'left'
                });
            },
            error: function (err) {
                if (err.status >= 400 && err.status <= 500) {
                    $.toast({
                        text: "Email Password Salah!",
                        heading: 'Status',
                        icon: 'warning',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        position: 'mid-center',
                        textAlign: 'left'
                    });
                }else if(err.status >= 200 && err.status <= 299){
                  $.toast({
                    text: "OTP is Sent! Check your email!",
                    heading: 'Status',
                    icon: 'success',
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 10000,
                    position: 'mid-center',
                    textAlign: 'left'
                });
                }
              }
          });
        });
      </script>
  </body>
</html>
