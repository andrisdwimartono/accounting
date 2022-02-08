  
  <link href="{{ asset ("/assets/motaadmin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css") }}" rel="stylesheet">
  <link href="{{ asset ("/assets/motaadmin/css/style.css") }}" rel="stylesheet">

  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="{{ asset ("/assets/bootstrap/dist/css/bootstrap.min.css") }}">

  <!-- Font Awesome JS -->
  <script defer src="{{ asset ("/assets/fontawesome/js/solid.js") }}"></script>
  <script defer src="{{ asset ("/assets/fontawesome/js/fontawesome.js") }}"></script>

  <!-- select2 -->
  <link href="{{ asset ("/assets/bower_components/select2/dist/css/select2.min.css") }}" rel="stylesheet" />
  <link href="{{ asset ("/assets/node_modules/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css") }}" rel="stylesheet" />

<!-- datatables -->
<link href="{{ asset ("/assets/motaadmin/vendor/datatables/css/jquery.dataTables.min.css") }} " rel="stylesheet">
  
  <link href="{{ asset ("/assets/motaadmin/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css") }}" rel="stylesheet">
  <!-- Pick date -->
  <link rel="stylesheet" href="{{ asset ("/assets/motaadmin/vendor/pickadate/themes/default.css") }}">
  <link rel="stylesheet" href="{{ asset ("/assets/motaadmin/vendor/pickadate/themes/default.date.css") }}">

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
    .column-hidden{
      display:none;
    }
    td { 
      border: 1px solid #aaa; 
      height: 30px; 
      text-align: left; 
      /* width: 100px;  */
    }
    td > span{
      display: inline-block;
      /* width: 100%; */
    }
    input:not([type=checkbox]), input:not([type=checkbox]):hover, input:not([type=checkbox])focus { 
      width: 100%; 
      height: 30px; 
      box-sizing: border-box;
      outline: none; 
      background-color: #fff; 
    }

    .form-group {
      margin-bottom: 0.5rem !important;
    }

    table thead tr th {
      background:#d2e1ff;
      text-align:center;
      word-wrap: break-word;
      word-break: break-all;
      color : #000;
      line-height: 40px;
      text-align: center;
    }

    table tbody tr td {
      font-size: 14px;
      padding-top: 1px;
      padding-bottom: 1px;
    }

    td { 
      /* border-top: 1px solid #aaa;  */
      height: 30px; 
      text-align: left; 
      width: 100px; 
      color:#404040;
    }
    td > span{
      display: inline-block;
      width: 100%;
    }

    .properties {
      padding:10px;
    }

    .properties button{
      margin : 5px 3px;
    }

  </style>