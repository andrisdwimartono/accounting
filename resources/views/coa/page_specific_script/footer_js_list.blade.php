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
    
  function fetch_data(category_filter, coa_parent_id = null){
    cto_loading_show();
    var target = [];
    $('#example1 thead tr th').each(function(i, obj) {
        target.push(i);
    });
    target.shift();
    $('#example1').DataTable().destroy();
    var dataTable = $('#example1').DataTable({
      language: { search: "" , searchPlaceholder: "Search..."},
      //"searching": false,
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
                  var val = convertCode(data);
                  return "<span>"+val+"</span>";
              },
              createdCell: function (td, cellData, rowData, row, col) {
                var padd = ((parseInt(rowData[3])-1)*10)+"px";
                $(td).css('padding-left', padd);
                $(td).addClass('asset_value');
                $(td).addClass('caktext');
                $(td).addClass('coa_code_column');
                $(td).attr('data-id', rowData[0]);
              }
            },
            {
              aTargets: [2],
              mRender: function (data, type, full){
                  data = data.toString();
                  return "<span>"+data+"</span>";
              },
              createdCell: function (td, cellData, rowData, row, col) {
                $(td).addClass('asset_value');
                $(td).addClass('caktext');
                $(td).attr('data-id', rowData[0]);
              }
            },
            {
              aTargets: [0,3,4,5,6,7,8,9],
              createdCell: function (td, cellData, rowData, row, col) {
                $(td).addClass('column-hidden');
              }
            },
          ],
          "autoWidth": false,
          dom: 'Bfrtip',
          "scrollX" : true,
          "processing" : true,
          "serverSide" : true,
          "pagingType": "full_numbers",
          "pageLength": 2000,
          "order": [[ 1, "asc" ]],
          "ajax" : {
          url:"/getlist{{$page_data["page_data_urlname"]}}",
          type:"POST",
          data:{
            _token: $("input[name=_token]").val(),
            category_filter: category_filter,
            coa_parent_id: coa_parent_id
          }
        }
   });
   cto_loading_hide();
   table = dataTable;
  //  table.column(0).visible(false);
  //  table.column(3).visible(false);
  //  table.column(4).visible(false);
  //  table.column(5).visible(false);
  //  table.column(6).visible(false);
  //  table.column(7).visible(false);
  //  table.column(8).visible(false);
  //  table.column(9).visible(false);

    $('#example1').on('click', 'span', function() {
      var $e = $(this).parent();
      var id_td = $e.attr('data-id');
      var val = $(this).html();

      if($e.hasClass("coa_code_column")){
        val = val.replace(/-/g, '');
      }

      if($e.hasClass("caktext")){
        $e.html('<input type="text" value="" />');
        var $newE = $e.find('input');
        $newE.focus();
        $newE.val(val);
        $newE.on('blur', function() {
          if($e.hasClass("coa_code_column")){
            var value = convertCode($(this).val());
          }else{
            var value = $(this).val();
          }
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

    var child_table_data = ["", '<input type="text" value="" />', '<input type="text" value="" />', 2, "data.data()[0]", "data.data()[1]", "data.data()[6]", "data.data()[7]", "", "on", "ok"];
    table.row.add(child_table_data).draw(false)
    // $('#example1').on( 'click', '.row-add-child', function (e) {
    //   var data = table.row( $(this).parents('tr') );
    //   newRow(data, e);
    //   var id = data.data()[0];
      
    // });

    // function newRow(data, e){
    //   var dttb = $('#example1').DataTable();
    //   var child_table_data = ["", '<input type="text" value="" />', '<input type="text" value="" />', parseInt(data.data()[3])+1, data.data()[0], data.data()[1], data.data()[6], data.data()[7], "", "on", "ok"];

    //   if(dttb.row.add(child_table_data).draw(false)){
    //     console.log("aaa");
    //   }
    //   // var child_table_data = ["", '<input type="text" value="" />', '<input type="text" value="" />'];

    //   // if(validatequickModalForm_transaction_detail()){
    //   //     if(dttb.row.add(child_table_data).draw( false )){
    //   //         //$('#staticBackdrop_transaction_detail').modal('hide');
    //   //     }
    //   // }
    // }

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
    }); 
     
 });

  function convertCode(data){
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
 }

 function submitform(val_arr){
  var field_arr = ["id", "coa_code", "coa_name", "level_coa", "coa", "coa_label", "category", "category_label", "fheader", "factive"];
  cto_loading_show();

  var values = "_token="+$("input[name=_token]").val();
  for(var x = 0; x < field_arr.length; x++){
    values = values+"&"+field_arr[x]+"="+val_arr[x];
  }
  var ajaxRequest;
  ajaxRequest = $.ajax({
      url: "/updatecoa/"+val_arr[0],
      type: "post",
      data: values,
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
 }
</script>