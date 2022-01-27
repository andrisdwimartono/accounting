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

  <script src="{{ asset ("/assets/cto/js/cakrudtemplate.js") }}"></script>
  <script src="{{ asset ("/assets/cto/js/cto_loadinganimation.min.js") }}"></script>

  <!-- Pivottable -->
  <script src="{{ asset ("/assets/pivottable/jquery.min.js") }}"></script>
  <script src="{{ asset ("/assets/pivottable/jquery.ui.touch-punch.min.js") }}"></script>
  <script src="{{ asset ("/assets/pivottable/jquery-ui.min.js") }}"></script>
  <script src="{{ asset ("/assets/pivottable/pivot.js") }}"></script>
  <script src="{{ asset ("/assets/pivottable/c3.min.js") }}"></script>
  <script src="{{ asset ("/assets/pivottable/c3_renderers.js") }}"></script>
  <script src="{{ asset ("/assets/pivottable/d3.min.js") }}"></script>
  <script src="{{ asset ("/assets/pivottable/d3_renderers.min.js") }}"></script>
  <script src="{{ asset ("/assets/pivottable/export_renderers.js") }}"></script>
  

<script>
    var APP_URL = {!! json_encode(url('/')) !!}
    var category = "{{$page_data['category']}}"
    // This example has all the renderers loaded,
    // and should work with touch devices.

    $(function(){
        

            
      

        });

      $("#bulan_periode").on("change", function() {
        fetch_data();
      });

      $("#tahun_periode").on("change", function() {
        fetch_data();
      });

      $("#child_level").on("change", function() {
        fetch_data();
      });

      fetch_data();


      function fetch_data(){
        var derivers = $.pivotUtilities.derivers;

        var renderers = $.extend(
            $.pivotUtilities.renderers,
            $.pivotUtilities.c3_renderers,
            $.pivotUtilities.d3_renderers,
            $.pivotUtilities.export_renderers
            );

        bulan = parseInt($("#bulan_periode").val())
        tahun = parseInt($("#tahun_periode").val())
        $.ajax({
            url: '/dashboard/get_transaction',
            type:"POST",
            data:{
              category: category,
              search : {
                bulan_periode: bulan,
                tahun_periode: tahun
              },
              _token: $("input[name=_token]").val()
            },
            success: function(data) {
              
              data = JSON.parse(data);
              $('#output-header').html(data.periode);
              console.log(data.data);

              $("#output").pivotUI(data.data, {
                renderers: renderers,
                aggregatorName: "Integer Sum",
                vals: ["Nominal"],
                cols: ["Tahun","Bulan"], rows: ["COA"],
                sorters: {"type": function(a,b){ return string_a.localeCompare(string_b) }},
                rendererName: "Table",
                rowOrder: "value_a_to_z", 
                colOrder: "value_a_to_z",
              });
            }
          });

          function addClass(id,data){
        var value = ""
        var badge = ""

        if(data==0){
          value="rendah";
          badge="badge-danger";
        } else if(data==1){
          value="sedang";
          badge="badge-warning";
        } else if(data==2){
          value="tinggi";
          badge="badge-success";
        }
        $(id).html(value).addClass(badge);

      }

      $(document).ready(function(){
          $.ajax({
            url: '/dashboard/klasifikasi',
            type:"POST",
            data:{
              search : {
                bulan_periode: bulan,
                tahun_periode: tahun
              },
              _token: $("input[name=_token]").val()
            },
            success: function(data) {
              data = JSON.parse(data)
              console.log(data.value)
              $("#valueofroa").html(data.roa.value);
              addClass("#classroa",data.roa.klasifikasi)
              
              $("#valueofroe").html(data.roe.value);
              addClass("#classroe",data.roe.klasifikasi)

              $("#valueofroi").html(data.roi.value);
              addClass("#classroi",data.roi.klasifikasi)

              $("#valueofklasifikasi").html(data.kebijakan);
            }
          });
        });

        function exportTableToExcel(tableID, filename = ''){
            var rightNow = new Date();
            var res = rightNow.toISOString();

            filename=filename+res;
            
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

            filename = filename?filename+'.xls':'excel_data.xls';
            downloadLink = document.createElement("a");

            document.body.appendChild(downloadLink);

            if(navigator.msSaveOrOpenBlob){
              var blob = new Blob(['\ufeff', tableHTML], {
                type: dataType
              });
              navigator.msSaveOrOpenBlob( blob, filename);
            }else{

              downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

              downloadLink.download = filename;

              downloadLink.click();
            }
          }
      }

        

    

</script>
