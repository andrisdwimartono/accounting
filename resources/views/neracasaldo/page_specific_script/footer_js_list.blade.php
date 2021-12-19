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

    <script src="{{ asset ("/assets/cto/js/cakrudtemplate.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/cto_loadinganimation.min.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/dateformatvalidation.min.js") }}"></script>

<script>
  $(document).ready(function(){
    
    $("#neracasaldo").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#neracasaldo_wrapper .col-md-6:eq(0)');

    fetch_data();

    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#startDate').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy',
            formatSubmit: 'yyyy-mm-dd',
            iconsLibrary: 'fontawesome',
            maxDate: function () {
                return $('#endDate').val();
            },
            onStart: function(){
                var date = new Date();
                    this.set('select', date.getFullYear()+"-"+(date.getMonth()+1)+"-"+ date.getDate(), { format: 'yyyy-mm-dd' });
            }
        });
        $('#endDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            format: 'dd/mm/yyyy',
            formatSubmit: 'yyyy-mm-dd',
            minDate: function () {
                return $('#startDate').val();
            },
            onStart: function(){
                var date = new Date();
                    this.set('select', date.getFullYear()+"-"+(date.getMonth()+1)+"-"+ date.getDate(), { format: 'yyyy-mm-dd' });
            }
        });

	  var table = null;
    var dataTable;
  
    function fetch_data(){
      cto_loading_show();
      var target = [];
      $('#neracasaldo thead tr th').each(function(i, obj) {
          target.push(i);
      });
      target.shift();
      $('#neracasaldo').DataTable().destroy();
      dataTable = $('#neracasaldo').DataTable({
          "autoWidth": false,
          dom: 'Brtip',
          buttons: [
                {
                    text: "PDF <span class='btn-icon-right'><i class='fa fa-print'></i></span>",
                    className: "btn btn-primary",
                    init: function(api, node, config) {
                      $(node).removeClass('dt-button')
                    },
                    action: function ( e, dt, node, config ) {
                      var url = '/neracasaldo/print';
                      var form = $('<form action="' + url + '" target="_blank" method="post">' +
                        '<input type="hidden" name="_token" value="'+$("input[name=_token]").val()+'" />' +
                        '<input type="hidden" name="search[bulan_periode]" value="'+$("#bulan_periode").val()+'" />' +
                        '<input type="hidden" name="search[tahun_periode]" value="'+$("#tahun_periode").val()+'" />' +
                        '</form>');
                      $('body').append(form);
                      form.submit();
                    },
                },
            ],
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
              search : {
                bulan_periode: $("#bulan_periode").val(),
                tahun_periode: $("#tahun_periode").val()
              },  
              _token: $("input[name=_token]").val()
            },
          },
          
          "footerCallback": function ( row, data, start, end, display ) {
              var api = this.api(), data;
              var api2 = this.api(), data;
  
              var intVal = function ( i ) {
                  return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ?i : 0;
              };
              
              debet = 0;
              kredit = 0;

              for(var i = 0; i < data.length; i++){
                if(data[i][6] == 1){ // if level_coa < 1
                  debet = debet+intVal(data[i][3]);
                  kredit = kredit+intVal(data[i][4]);
                }
              }

              saldo = debet-kredit
              saldo_debet = "";
              saldo_kredit = "";
              if(saldo<0) saldo_debet = formatRupiahWNegative(saldo,".");
              else saldo_kredit = formatRupiahWNegative(saldo,".");

              // Update footer
              $( api.column( 2 ).footer() ).html("JUMLAH");
              $( api.column( 3 ).footer() ).html(formatRupiahWNegative(debet,"."));
              $( api.column( 4 ).footer() ).html(formatRupiahWNegative(kredit,"."));
              // $( 'tr:eq(1) td:eq(0)', api.table().footer() ).html("SALDO");
              // $( 'tr:eq(1) td:eq(1)', api.table().footer() ).html(saldo_debet);
              // $( 'tr:eq(1) td:eq(2)', api.table().footer() ).html(saldo_kredit);
            },
            "columnDefs": [
              { 
                "targets": 0,
                "class" : "column-hidden"
              },
              { 
                "targets": 1,
                "width" : 150,
                "render":  function ( data, type, row, meta ) {
                  var code = convertCode(row[1].split(" ")[0]);
                  if(row[7]=='on'){
                    return "<b>"+code+"</b>";
                  } else {
                    return code;
                  }
                },
                createdCell: function (td, cellData, rowData, row, col) {
                  var padd = (10+(parseInt(rowData[6])-1)*12)+"px";
                  $(td).css('padding-left', padd);
                }
              },
              { 
                "targets": 2,
                "width" : 250,
                "render":  function ( data, type, row, meta ) {
                  if(row[7]=='on'){
                    return "<b>"+row[2]+"</b>";
                  } else {
                    return row[2];
                  }
                },
                createdCell: function (td, cellData, rowData, row, col) {
                  var padd = (10+(parseInt(rowData[6])-1)*12)+"px";
                  $(td).css('padding-left', padd);
                }
              },
              { 
                "targets": 3,
                "width" : 130,
                "render":  function ( data, type, row, meta ) {
                  if(row[7]!='on'){
                    return formatRupiahWNegative(row[3],".") ;
                  } else {
                    return "";
                  }
                }
              },
              { 
                "targets": 4,
                "width" : 130,
                "render":  function ( data, type, row, meta ) {
                    if(row[7]!='on'){
                      return formatRupiahWNegative(row[4],".") ;
                    } else {
                      return "";
                    }
                }
              },
              { 
                "targets": 5,
                "class" : "column-hidden",
              },
              { 
                "targets": 6,
                "class" : "column-hidden",
              },
              { 
                "targets": 7,
                "class" : "column-hidden",
              }
            ],
        });
      cto_loading_hide();
      table = dataTable;
    }

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

    $("#bulan_periode").on("change", function() {
      fetch_data();
    });

    $("#tahun_periode").on("change", function() {
      fetch_data();
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