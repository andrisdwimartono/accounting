  
  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="{{ asset ("/assets/bootstrap/dist/css/bootstrap.min.css") }}">

  <!-- Font Awesome JS -->
  <script defer src="{{ asset ("/assets/fontawesome/js/solid.js") }}"></script>
  <script defer src="{{ asset ("/assets/fontawesome/js/fontawesome.js") }}"></script>
  
  <link href="{{ asset ("/assets/motaadmin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css") }}" rel="stylesheet">
  <link href="{{ asset ("/assets/motaadmin/css/style.css") }}" rel="stylesheet">

  <link href="{{ asset ("/assets/node_modules/jquery-toast-plugin/dist/jquery.toast.min.css") }}" rel="stylesheet" />
  <link href="{{ asset ("/assets/cto/css/cto_loadinganimation.min.css") }}" rel="stylesheet" />

  <!-- PivotTable -->
  <link href="{{ asset ("/assets/pivottable/c3.min.css") }}" rel="stylesheet">
  <link href="{{ asset ("/assets/pivottable/pivot.css") }}" rel="stylesheet">
  
  <style>
    .select2-close-mask{
        z-index: 2099;
    }
    .select2-dropdown{
        z-index: 3051;
    }
    
    #example1_processing{
      z-index:1;
      height:80px;
      background:none;
    }

    table.dataTable thead tr th {
      background:#d2e1ff;
      text-align:center;
    }
    table.dataTable tbody tr td {
      font-size: 14px;
      padding-top: 1px;
      padding-bottom: 1px;
    }

    table.dataTable tfoot tr td {
      font-size: 14px;
      padding: 5px 10px !important;
    }
    
    .column-hidden{
      display:none;
    }

    .left{
      float:left;
      text-align : left;
    }

    .right{
      float:right;
      text-align : left;
    }

    .text-grey {
      color : #000;
    }

    td { 
      height: 30px; 
      text-align: left; 
      width: 100px; 
      color:#404040;
    }

    .column-hidden{
      display:none;
    }
    input:not([type=checkbox]), input:not([type=checkbox]):hover, input:not([type=checkbox])focus { 
      width: 100%; 
      height: 30px; 
      box-sizing: border-box;
      outline: none; 
      background-color: #fff; 
    }
    .nav-link{
      color: white;
    }

    .cak-rp{
        float: left;
    }
    .cak-nom{
        float: right;
    }
    .coa-header{
      font-weight: bold;
    }
    .coa-code{
      color : #919191;
    }
    .card-header{
      background : #f1f5ff;
    }
    .text-grey{
      color : #8b8b8b;
      padding : 10px 0px;
    }

    .total {
      font-weight: bold;
    }

    .dt-buttons {
      margin-bottom:15px;
    }

    body {font-family: Verdana;}
    .node {
      border: solid 1px white;
      font: 10px sans-serif;
      line-height: 12px;
      overflow: hidden;
      position: absolute;
      text-indent: 2px;
    }
    .c3-line, .c3-focused {stroke-width: 3px !important;}
    .c3-bar {stroke: white !important; stroke-width: 1;}
    .c3 text { font-size: 12px; color: grey;}
    .tick line {stroke: white;}
    .c3-axis path {stroke: grey;}
    .c3-circle { opacity: 1 !important; }
    .c3-xgrid-focus {visibility: hidden !important;}
  </style>

  <script>    
  var menu="laporan"
  </script>
