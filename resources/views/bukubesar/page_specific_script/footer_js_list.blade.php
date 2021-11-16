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
<script src="{{ asset ("/assets/bower_components/select2/dist/js/select2.full.min.js") }}"></script>

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
    var dataTable;
    fetch_data();
  
    function fetch_data(){
      cto_loading_show();
      var target = [];
      $('#example1 thead tr th').each(function(i, obj) {
          target.push(i);
      });
      target.shift();
      $('#example1').DataTable().destroy();
      dataTable = $('#example1').DataTable({
          buttons: [
              {
                  text: "+",
                  className: "bg-success text-white m-0",
                  action: function ( e, dt, node, config ) {
                    window.location.href = "/create{{$page_data["page_data_urlname"]}}";
                  }
              },
          ],
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
              _token: $("input[name=_token]").val()
            }
          }
        });
    }
    cto_loading_hide();
    table = dataTable;

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


    $("select").select2({
      placeholder: "Pilih satu",
      allowClear: true,
      theme: "bootstrap4" @if($page_data["page_method_name"] == "View"),
      disabled: true @endif
    });

    $.fn.modal.Constructor.prototype._enforceFocus = function() {

    };

    $("#coa").on("change", function() {
        $("#coa_code").val($("#coa option:selected").val());
    });

    $("#coa").select2({
      ajax: {
          url: "/getlinks{{$page_data["page_data_urlname"]}}",
          type: "post",
          dataType: "json",
          data: function(params) {
              return {
                  term: params.term || "",
                  page: params.page,
                  field: "coa",
                  _token: $("input[name=_token]").val()
              }
          },
          processResults: function (data, params) {
                    params.page = params.page || 1;
                    for(var i = 0; i < data.items.length; i++){
                        var te = data.items[i].text.split(" ");
                        text = data.items[i].text;
                        data.items[i].text = convertCode(te[0])+" "+text.replace(te[0]+" ", "");
                    }
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
  });
</script>