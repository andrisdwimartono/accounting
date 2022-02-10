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

  /* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    var table = ''
    table += '<table cellpadding="5" cellspacing="0" border="0" style="margin-left:50px;width:100%;">'
    table += '<tr><th>Kode Rekening</th><th>Deskripsi</th><th>Nominal</th></tr>'

    for(var i=0; i<d[6].length; i++){
      table += '<tr>'
      table += '<td>'+d[6][i].coa_label+'</td>'
      table += '<td>'+d[6][i].deskripsibiaya+'</td>'
      table += '<td>'+d[6][i].nominalbiaya+'</td>'
      table += '</tr>'
    }
    table += '</table>';
    return table
}

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
        "columns": [
        { "width": "5px" },
        { "width": "300px" },
        { "width": "50px" },
        { "width": "300px" },
        { "width": "300px" },
        ],
        aoColumnDefs: [
            { 
              "targets": [5,6],
              "class" : "column-hidden",
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
            url:"/getlistlaporan{{$page_data["page_data_urlname"]}}",
            type:"POST",
            data:{
              search : {
                  bulan_periode: $("#bulan_periode").val(),
                  tahun_periode: $("#tahun_periode").val(),
                  unitkerja: $("#unitkerja").val(),
              }, 
              _token: $("input[name=_token]").val()
            }
          }
   });

   // Add event listener for opening and closing details
   $('#example1 tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );

    $('#example1').on('init.dt', function(e, settings){
      var api = new $.fn.dataTable.Api( settings );
      api.rows().every( function () {
          var tr = $(this.node());
          this.child(format(this.data())).show();
          tr.addClass('shown');
      });
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

  $("#unitkerja").on("change", function() {
      $("#unitkerja_label").val($("#unitkerja option:selected").text());
  });

  $("#unitkerja").select2({
    ajax: {
        url: "/getlinks{{$page_data["page_data_urlname"]}}",
        type: "post",
        dataType: "json",
        data: function(params) {
            return {
                term: params.term || "",
                page: params.page,
                field: "unit_pelaksana",
                _token: $("input[name=_token]").val()
            }
        },
        processResults: function (data, params) {
            params.page = params.page || 1;
            return {
                results: data.items,
                pagination: {
                more: (params.page * 25) < data.total_count
                }
            };
        },
        cache: true
    }
  });

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

  var urlaction = "/updatekegiatan/"+val_arr[0];
  if(action == 'create'){
    urlaction = "/storekegiatan";
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