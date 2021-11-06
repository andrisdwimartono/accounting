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

  <!-- hijgo for date dan datetime picker -->
  <link href="{{ asset ("/assets/node_modules/gijgo/css/gijgo.min.css") }}" rel="stylesheet" />
  
  <!-- datatables -->
  <!-- <link href="{{ asset ("/assets/motaadmin//vendor/datatables/css/jquery.dataTables.min.css") }} " rel="stylesheet"> -->
  <link href="{{ asset ("/assets/datatables/css/dataTables.bootstrap4.min.css") }}" rel="stylesheet" />
  <link href="{{ asset ("/assets/datatables/css/rowReorder.dataTables.min.css") }}" rel="stylesheet" />
  <link href="{{ asset ("/assets/datatables/css/buttons.dataTables.min.css") }}" rel="stylesheet" />

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
      width: 20%;
      float: right;
      text-align: right;
    }
    table.dataTable thead tr th {
      color:white;
      text-align:center;
    }
    table.dataTable tbody tr td {
      font-size: 14px;
      padding-top: 1px;
      padding-bottom: 1px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding : 0px;
        margin-left: 0px;
        display: inline;
        border: 0px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        border: 0px;
    }
    .column-hidden{
      display:none;
    }
    td { 
      border: 1px solid #aaa; 
      height: 30px; 
      text-align: left; 
      width: 100px; 
    }
    td > span{
      display: inline-block;
      width: 100%;
    }
    input:not([type=checkbox]), input:not([type=checkbox]):hover, input:not([type=checkbox])focus { 
      width: 100%; 
      height: 30px; 
      box-sizing: border-box;
      outline: none; 
      background-color: #fff; 
    }
  </style>