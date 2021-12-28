  <!-- Required vendors -->
  <script src="{{ asset ("/assets/motaadmin/vendor/global/global.min.js") }}"></script>
	<script src="{{ asset ("/assets/motaadmin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js") }} "></script>
  <script src="{{ asset ("/assets/motaadmin/vendor/chart.js/Chart.bundle.min.js") }}"></script>
  <script src="{{ asset ("/assets/motaadmin/js/custom.min.js") }}"></script>
	<script src="{{ asset ("/assets/motaadmin/js/deznav-init.js") }}"></script>

  <script src="{{ asset ("/assets/motaadmin/vendor/chart.js/Chart.bundle.min.js") }}"></script>
  <script src="{{ asset ("/assets/motaadmin/js/custom.min.js") }}"></script>
  <script src="{{ asset ("/assets/motaadmin/js/deznav-init.js") }}"></script>
	<!-- Apex Chart -->
	<script src="{{ asset ("/assets/motaadmin/vendor/apexchart/apexchart.js") }}"></script>

  <script src="{{ asset ("/assets/motaadmin/vendor/moment/moment.min.js") }}"></script>

  <script src="{{ asset ("/assets/motaadmin/vendor/pickadate/picker.js") }}"></script>
  <script src="{{ asset ("/assets/motaadmin/vendor/pickadate/picker.time.js") }}"></script>
  <script src="{{ asset ("/assets/motaadmin/vendor/pickadate/picker.date.js") }}"></script>
  <!-- Pickdate -->
  <!-- <script src="{{ asset ("/assets/motaadmin/js/plugins-init/pickadate-init.js") }}"></script> -->

	<!-- Svganimation scripts -->
    <script src="{{ asset ("/assets/motaadmin/vendor/svganimation/vivus.min.js") }}"></script>
    <script src="{{ asset ("/assets/motaadmin/vendor/svganimation/svg.animation.js") }}"></script>

    <script src="{{ asset ("/assets/node_modules/@popperjs/core/dist/umd/popper.min.js") }}"></script>
    <script src="{{ asset ("/assets/node_modules/gijgo/js/gijgo.min.js") }}"></script>
    <script src="{{ asset ("/assets/node_modules/jquery-toast-plugin/dist/jquery.toast.min.js") }}"></script>
    <script src="{{ asset ("/assets/node_modules/autonumeric/dist/autoNumeric.min.js") }}"></script>
    <script src="{{ asset ("/assets/bootstrap/dist/js/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ asset ("/assets/bower_components/jquery-validation/dist/jquery.validate.min.js") }}"></script>
    <script src="{{ asset ("/assets/bower_components/select2/dist/js/select2.full.min.js") }}"></script>
    
    <script src="{{ asset ("/assets/datatables/js/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset ("/assets/datatables/js/dataTables.buttons.min.js") }}"></script>
    
    <script src="{{ asset ("/assets/datatables/js/jquery.dataTables.colResize.js") }}"></script>

    <script src="{{ asset ("/assets/cto/js/cakrudtemplate.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/cto_loadinganimation.min.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/dateformatvalidation.min.js") }}"></script>

<script>
  $(function () {
    
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
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
      buttons: [
            {
                text: "Tambah User <span class='btn-icon-right'><i class='fa fa-plus'></i></span>",
                className: "btn btn-primary",
                init: function(api, node, config) {
                  $(node).removeClass('dt-button')
                },
                action: function ( e, dt, node, config ) {
                  window.location.href = "/create{{$page_data["page_data_urlname"]}}";
                }
            },
        ],
          "autoWidth": false,
          dom: 'Bfrtip',
          "scrollX" : true,
          "colResize": {
            isEnabled: true,
            hoverClass: 'dt-colresizable-hover',
            hasBoundCheck: true,
            minBoundClass: 'dt-colresizable-bound-min',
            maxBoundClass: 'dt-colresizable-bound-max',
            isResizable: function(column) { 
              return true;
            },
            onResize: function(column) {
              //console.log('...resizing...');
            },
            onResizeEnd: function(column, columns) {
              $('#user').DataTable().draw();
            }
          },
          "processing" : true,
          "serverSide" : true,
          "pagingType": "full_numbers",
          "pageLength": 20,
          "order": [[ 1, "asc" ]],
          "ajax" : {
          url:"{{ env('APP_URL') }}/getlist{{$page_data["page_data_urlname"]}}",
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
          'url': "{{ env('APP_URL') }}/delete{{$page_data["page_data_urlname"]}}",
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
</script>