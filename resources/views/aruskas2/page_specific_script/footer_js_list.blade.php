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

  $(document).ready(function(){

    $("#aruskas").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#aruskas_wrapper .col-md-6:eq(0)');

    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

	  var table = null;
    var dataTable;
  
    function fetch_data(){
      var e = document.getElementById("coa");
      coa = e.options[e.selectedIndex].text;
      cat = coa.substring(0, coa.indexOf("-")); 

      cto_loading_show();
      var target = [];
      $('#aruskas thead tr th').each(function(i, obj) {
          target.push(i);
      });
      target.shift();
      $('#aruskas').DataTable().destroy();
      dataTable = $('#aruskas').DataTable({
          "autoWidth": false,
          dom: 'Bfrtip',
          buttons: [
                {
                    text: "PDF <span class='btn-icon-right'><i class='fa fa-print'></i></span>",
                    className: "btn btn-primary",
                    init: function(api, node, config) {
                      $(node).removeClass('dt-buttons')
                      $(node).removeClass('dt-button')
                    },
                    action: function ( e, dt, node, config ) {
                      var url = '/aruskas/print';
                      var form = $('<form action="' + url + '" target="_blank" method="post">' +
                        '<input type="hidden" name="_token" value="'+$("input[name=_token]").val()+'" />' +
                        '<input type="hidden" name="search[bulan_periode]" value="'+$("#bulan_periode").val()+'" />' +
                        '<input type="hidden" name="search[tahun_periode]" value="'+$("#tahun_periode").val()+'" />' +
                        '<input type="hidden" name="search[coa_code]" value="'+$("#coa").val()+'" />' +
                        '</form>');
                      $('body').append(form);
                      form.submit();
                    },
                },
            ],
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
              $('#aruskas').DataTable().draw();
            }
          },
          "processing" : true,
          "serverSide" : true,
          "pagingType": "full_numbers",
          "pageLength": 20,
          "order": [[ 1, "asc" ]],
          "fixedColumns": true,
          "ajax" : {
            url:"/getlist{{$page_data["page_data_urlname"]}}",
            type:"POST",
            data:{
              search : {
                coa_code: $("#coa").val(),
                  bulan_periode: formatDate($("#bulan_periode").val()),
                  tahun_periode: formatDate($("#tahun_periode").val()),
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
              debet = api.column( 4 ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
              kredit = api.column( 5 ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
              saldo_debet = "";
              saldo_kredit = "";
              
              if(cat == 1 || cat == 5|| cat == 6){
                saldo = debet-kredit
                if(saldo>0) saldo_kredit = formatRupiah(saldo,".");
                else saldo_debet = formatRupiah(saldo,".");
              } else {
                saldo = kredit-debet
                if(saldo>0) saldo_debet = formatRupiah(saldo,".");
                else saldo_kredit = formatRupiah(saldo,".");
              }
                

              // Update footer
              $( api.column( 3 ).footer() ).html("JUMLAH");
              $( api.column( 4 ).footer() ).html(formatRupiah(debet,"."));
              $( api.column( 5 ).footer() ).html(formatRupiah(kredit,"."));
              $( 'tr:eq(1) td:eq(3)', api.table().footer() ).html("SALDO");
              $( 'tr:eq(1) td:eq(4)', api.table().footer() ).html(saldo_debet);
              $( 'tr:eq(1) td:eq(5)', api.table().footer() ).html(saldo_kredit);
              
            },
            "columnDefs": [
              { 
                "targets": 0,
                "class" : "column-hidden",
                "width": 30, 
              },
              { 
                "targets": 1,
                "width": 50, 
              },
              { 
                "targets": 2,
                "width": 50, 
              },
              { 
                "targets": 3,
                "width": 250, 
              },
              { 
                "targets": 4,
                "width": 130,
                "render":  function ( data, type, row, meta ) {
                  return formatRupiah(row[4],".") ;
                }
              },
              { 
                "targets": 5,
                "width": 130,
                "render":  function ( data, type, row, meta ) {
                  return formatRupiah(row[5],".") ;
                }
              },
              
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

    function get_saldo_awal(){
      $.ajax({
        url: "/getsaldoawalaruskas",
        type: "post",
        dataType: "json",
        data: {
          coa: $("#coa").val(),
          bulan_periode: formatDate($("#bulan_periode").val()),
          tahun_periode: formatDate($("#tahun_periode").val()),
          _token: $("input[name=_token]").val()
        },
        success: function (data, params) {
         
          saldo_debet = "";
          saldo_kredit = "";
            
          if(typeof(data.data[0]) != "undefined"){
            debet = data.data[0].total_debet;
            kredit = data.data[0].total_credit;
            saldo = 0;
                
            if(cat == 1 || cat == 5|| cat == 6){
              saldo = debet-kredit
              if(saldo>0) saldo_kredit = formatRupiah(saldo,".");
              else saldo_debet = formatRupiah(saldo,".");
            } else {
              saldo = kredit-debet
              if(saldo>0) saldo_debet = formatRupiah(saldo,".");
              else saldo_kredit = formatRupiah(saldo,".");
            }
          }  
          $( 'tr:eq(2) td:eq(1)', $('#aruskas').dataTable().api().table().footer() ).html(saldo_debet);
          $( 'tr:eq(2) td:eq(2)', $('#aruskas').dataTable().api().table().footer() ).html(saldo_kredit);        
        },

        cache: true
      })
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
      fetch_data();
      // get_saldo_awal();
    });

    $("#bulan_periode").on("change", function() {
      fetch_data();
      // get_saldo_awal();
    });

    $("#tahun_periode").on("change", function() {
      fetch_data();
      // get_saldo_awal();
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
          results: function (data, params) {
                    params.page = params.page || 1;
                    for(var i = 0; i < data.items.length; i++){
                        var te = data.items[i].text.split(" ");
                        text = data.items[i].text;
                        data.items[i].text = convertCode(te[0])+" "+text.replace(te[0]+" ", "");
                    }
                    return {
                        results: data.items
                    };
            },
          cache: true
      },
      theme : "bootstrap4"
    });
    
    var menu = "laporan"
    var submenu = "aruskas"
  });

  


</script>