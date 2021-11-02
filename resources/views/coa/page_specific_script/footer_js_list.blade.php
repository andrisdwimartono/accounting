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

<script src="{{ asset ("/assets/datatables/js/dataTables.bootstrap4.min.js") }}"></script>
<script src="{{ asset ("/assets/datatables/js/dataTables.rowReorder.min.js") }}"></script>
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
    fetch_data("aset");
    
  function fetch_data(category_filter){
    cto_loading_show();
    var target = [];
    $('#example1 thead tr th').each(function(i, obj) {
        target.push(i);
    });
    target.shift();
    $('#example1').DataTable().destroy();
    var dataTable = $('#example1').DataTable({
      // language: { search: "" , searchPlaceholder: "Search..."},
      "searching": false,
      buttons: [
            {
                text: "+",
                className: "bg-success text-white m-0",
                action: function ( e, dt, node, config ) {
                  window.location.href = "/create{{$page_data["page_data_urlname"]}}";
                }
            },
            {
                text: "Aset",
                className: category_filter=="aset"?"bg-secondary text-white m-0":"bg-success text-white m-0",
                action: function ( e, dt, node, config ) {
                  fetch_data("aset");
                }
            },
            {
                text: "Hutang",
                className: category_filter=="hutang"?"bg-secondary text-white m-0":"bg-success text-white m-0",
                action: function ( e, dt, node, config ) {
                  fetch_data("hutang");
                }
            },
            {
                text: "Modal",
                className: category_filter=="modal"?"bg-secondary text-white m-0":"bg-success text-white m-0",
                action: function ( e, dt, node, config ) {
                  fetch_data("modal");
                }
            },
            {
                text: "Pendapatan",
                className: category_filter=="pendapatan"?"bg-secondary text-white m-0":"bg-success text-white m-0",
                action: function ( e, dt, node, config ) {
                  fetch_data("pendapatan");
                }
            },
            {
                text: "Biaya",
                className: category_filter=="biaya"?"bg-secondary text-white m-0":"bg-success text-white m-0",
                action: function ( e, dt, node, config ) {
                  fetch_data("biaya");
                }
            },
            {
                text: "Biaya Lainnya",
                className: category_filter=="biaya_lainnya"?"bg-secondary text-white m-0":"bg-success text-white m-0",
                action: function ( e, dt, node, config ) {
                  fetch_data("biaya_lainnya");
                }
            },
            {
                text: "Pendapatan Lainnya",
                className: category_filter=="pendapatan_lainnya"?"bg-secondary text-white m-0":"bg-success text-white m-0",
                action: function ( e, dt, node, config ) {
                  fetch_data("pendapatan_lainnya");
                }
            },
        ],
      aoColumnDefs: [{
            aTargets: [1],
            mRender: function (data, type, full){
                data = data.toString();
                var val = "";
                for(var i = 0; i < data.length; i++){
                    if(i == 0){
                      val = val+data.charAt(i)+"-";
                    }else if(i == 2 || i == 4){
                      val = val+data.charAt(i)+"-";
                    }else if(i > 4 && (i-4)%3 == 0 && i != data.length-1){
                      val = val+data.charAt(i)+"-";
                    }else{
                      val = val+data.charAt(i);
                    }
                }
                return val;
            },
            createdCell: function (td, cellData, rowData, row, col) {
              var padd = ((parseInt(rowData[3])-1)*10)+"px";
              $(td).css('padding-left', padd);
            }
        }],
          "autoWidth": false,
          dom: 'Bfrtip',
          "scrollX" : true,
          "processing" : true,
          "serverSide" : true,
          "pagingType": "full_numbers",
          "pageLength": 20,
          "order": [[ 1, "asc" ]],
          "ajax" : {
          url:"/getlist{{$page_data["page_data_urlname"]}}",
          type:"POST",
          data:{
            _token: $("input[name=_token]").val(),
            category_filter: category_filter
          }
        }
   });
   cto_loading_hide();
   table = dataTable;
   table.column(0).visible(false);
   table.column(3).visible(false);
   table.column(4).visible(false);
   table.column(5).visible(false);
   table.column(6).visible(false);
   table.column(7).visible(false);
   table.column(8).visible(false);
   table.column(9).visible(false);

   var name = "";
   $('#example1 tbody').on('click', 'tr', function () {
        $(this).toggleClass('selected');
        $(this).toggleClass('editable');
        if($(this).hasClass('editable')){
          if(!$(this).find("td:eq(1)").find('input').length){
            name = $(this).find("td:eq(1)").text();
          }
          $(this).find("td:eq(1)").html("<input type='text' id='input-inline-name' value='"+name+"' style='width: 100%; box-sizing: border-box;'>");
          $("#input-inline-name").focus();
        }else{
          $(this).find("td:eq(1)").html(name);
        }
        //showChildTable_transaction_detail("staticBackdrop_transaction_detail", table_transaction_detail.row( this ));
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
</script>