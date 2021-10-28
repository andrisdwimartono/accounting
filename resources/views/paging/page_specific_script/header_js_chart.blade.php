  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="{{ asset ("/assets/bootstrap/dist/css/bootstrap.min.css") }}">
  <!-- Our Custom CSS -->
  <link rel="stylesheet" href="{{ asset ("/assets/cto/css/cakrudtemplate.css") }}">
  <link rel="stylesheet" href="{{ asset ("/assets/cto/css/cakrudtemplate-chart.css") }}">

  <!-- Font Awesome JS -->
  <script defer src="{{ asset ("/assets/fontawesome/js/solid.js") }}"></script>
  <script defer src="{{ asset ("/assets/fontawesome/js/fontawesome.js") }}"></script>

  <!-- select2 -->
  <link href="{{ asset ("/assets/bower_components/select2/dist/css/select2.min.css") }}" rel="stylesheet" />
  <link href="{{ asset ("/assets/node_modules/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css") }}" rel="stylesheet" />

  <!-- hijgo for date dan datetime picker -->
  <link href="{{ asset ("/assets/node_modules/gijgo/css/gijgo.min.css") }}" rel="stylesheet" />

  <link href="{{ asset ("/assets/node_modules/jquery-toast-plugin/dist/jquery.toast.min.css") }}" rel="stylesheet" />
  <link href="{{ asset ("/assets/cto/css/cto_loadinganimation.min.css") }}" rel="stylesheet" />
  <style>
    .select2-close-mask{
        z-index: 2099;
    }
    .select2-dropdown{
        z-index: 3051;
    }
    .dataTables_filter {
      width: 50%;
      float: right;
      text-align: right;
    }
  </style>