<!-- Required vendors -->
<script src="{{ asset ("/assets/motaadmin/vendor/global/global.min.js") }}"></script>
	<script src="{{ asset ("/assets/motaadmin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js") }} "></script>
    <script src="{{ asset ("/assets/motaadmin/vendor/chart.js/Chart.bundle.min.js") }}"></script>
    <script src="{{ asset ("/assets/motaadmin/js/custom.min.js") }}"></script>
	<script src="{{ asset ("/assets/motaadmin/js/deznav-init.js") }}"></script>
	<!-- Apex Chart -->
	<script src="{{ asset ("/assets/motaadmin/vendor/apexchart/apexchart.js") }}"></script>
    
	<!-- Svganimation scripts -->
    <script src="{{ asset ("/assets/motaadmin/vendor/svganimation/vivus.min.js") }}"></script>
    <script src="{{ asset ("/assets/motaadmin/vendor/svganimation/svg.animation.js") }}"></script>

    <!-- Datatable -->
    <script src="{{ asset ("/assets/datatables/js/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset ("/assets/motaadmin/js/plugins-init/datatables.init.js") }} "></script>

<!-- <script src="{{ asset ("/assets/jquery/js/jquery-3.6.0.min.js") }}"></script> -->
<script src="{{ asset ("/assets/node_modules/@popperjs/core/dist/umd/popper.min.js") }}"></script>
<script src="{{ asset ("/assets/node_modules/jquery-toast-plugin/dist/jquery.toast.min.js") }}"></script>
<script src="{{ asset ("/assets/bootstrap/dist/js/bootstrap.bundle.min.js") }}"></script>

<script src="{{ asset ("/assets/datatables/js/dataTables.buttons.min.js") }}"></script>
<script src="{{ asset ("/assets/cto/js/cakrudtemplate.js") }}"></script>
<script src="{{ asset ("/assets/cto/js/cto_loadinganimation.min.js") }}"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  $(document).ready(function(){
	  var table = null;
    fetch_data();
    
  function fetch_data(){
    cto_loading_show();
    var target = [];
    $('#example1 thead tr th').each(function(i, obj) {
        target.push(i);
    });
    target.shift();
    $('#example1').DataTable().destroy();
    var dataTable = $('#example1').DataTable({
      // language: { search: "" , searchPlaceholder: "Search..."},
      //"searching": false,
      buttons: [
            {
                text: "Tambah Role <span class='btn-icon-right'><i class='fa fa-plus'></i></span>",
                className: "btn btn-primary",
                init: function(api, node, config) {
                  $(node).removeClass('dt-button')
                },
                action: function ( e, dt, node, config ) {
                  window.location.href = "/create{{$page_data["page_data_urlname"]}}";
                }
            },
        ],
        // "columns": [
        // { "width": "5px" },
        // { "width": "5px" },
        // { "width": "550px" },
        // { "width": "20px" },
        // ],
        aoColumnDefs: [{
              aTargets: [1, 2],
              mRender: function (data, type, row){
                data = data.toString();
                return "<span>"+data+"</span>";
              },
              createdCell: function (td, cellData, rowData, row, col) {
                $(td).addClass('asset_value');
                $(td).addClass('caktext');
                $(td).attr('data-id', rowData[0]);
              }
            }
            ],
          "autoWidth": false,
          dom: 'Bfrtip',
          "scrollX" : true,
          "processing" : true,
          "serverSide" : true,
          "pagingType": "simple_numbers",
          "pageLength": 20,
          "order": [[ 1, "asc" ]],
          "ajax" : {
          url:"/getlist{{$page_data["page_data_urlname"]}}",
          type:"POST",
          data:{
            _token: $("input[name=_token]").val()
          }
        }
   });
   cto_loading_hide();
   table = dataTable;

   var name = "";
   $('#example1 tbody').on('click', 'tr', function () {
        $(this).toggleClass('selected');
    });

    $('#example1').on('click', 'span', function() {
      var $e = $(this).parent();
      var id_td = $e.attr('data-id');
      var val = $(this).html();

      if($e.hasClass("caktext")){
        $e.html('<input type="text" value="" size="34"/>');
        
        var $newE = $e.find('input');
        $newE.focus();
        $newE.val(val);
        $newE.on('blur', function() {
          var value = $(this).val();
          
          $(this).parent().html('<span>'+value+'</span>');
          if(val != $(this).val()){
            var tr = $e.parent();
            var val_arr = [];
            tr.find('td').each(function(index, value){
              if(index == 1){
                val_arr.push($(value).text().replace(/-/g, ''));
              }else{
                val_arr.push($(value).text());
              }
            });
            submitform(val_arr);
          }
        });
      }
    });
  }

  $('#example1 tbody').on( 'click', '.row-delete', function () {
      $("#modal-delete").modal({'show': true});
      var data = table.row( $(this).parents('tr') );
      var id = data.data()[0];
      $(".row-delete-confirmed").on('click', function(){
        cto_loading_show();
        $.ajax({
          'async': false,
          'type': "POST",
          'global': false,
          'dataType': 'json',
          'url': "/delete{{$page_data["page_data_urlname"]}}",
          'data': { 'id':  id, '_token': $("input[name=_token]").val()},
          'success': function (data) {
            cto_loading_hide();
            $.toast({
                text: data.message,
                heading: 'Status',
                icon: 'success',
                showHideTransition: 'fade',
                allowToastClose: true,
                hideAfter: 3000,
                position: 'mid-center',
                textAlign: 'left'
            });
            fetch_data();
          },
          'error': function (err) {    
            $.toast({
                text: err.status+"\n"+err.responseJSON.message,
                heading: 'Status',
                icon: 'warning',
                showHideTransition: 'fade',
                allowToastClose: true,
                hideAfter: 3000,
                position: 'mid-center',
                textAlign: 'left'
            });
            cto_loading_hide();
          }
        });
        $("#modal-delete").modal('hide');
      })
  } ); 
 });

 function submitform(val_arr, action = 'update'){
  var field_arr = ["id", "nama", "alias"];
  cto_loading_show();

  var urlaction = "/updaterole/"+val_arr[0];
  if(action == 'create'){
    urlaction = "/storerole";
  }

  var values = "_token="+$("input[name=_token]").val();
  for(var x = 0; x < field_arr.length; x++){
    values = values+"&"+field_arr[x]+"="+val_arr[x];
  }
  var ajaxRequest;
  var id_coa = 0;
  ajaxRequest = $.ajax({
      url: urlaction,
      type: "post",
      data: values,
      async: false,
      success: function(data){
          if(data.status >= 200 && data.status <= 299){
              id_coa = data.data.id;
              $.toast({
                  text: data.message,
                  heading: 'Status',
                  icon: 'success',
                  showHideTransition: 'fade',
                  allowToastClose: true,
                  hideAfter: 3000,
                  position: 'mid-center',
                  textAlign: 'left'
              });
          }
          cto_loading_hide();
      },
      error: function (err) {
          if (err.status == 422) {
              var errors = "";
              $.each(err.responseJSON.errors, function (i, error) {
                  //var validator = $("#quickForm").validate();
                  // var errors = {};
                  // errors[i] = error[0];
                  //validator.showErrors(errors);
                  errors += error[0];
              });
              $.toast({
                    text: errors,
                    heading: 'Status',
                    icon: 'danger',
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 3000,
                    position: 'mid-center',
                    textAlign: 'left'
                });
          }
        cto_loading_hide();
      }
  });

  return id_coa;
 }
</script>