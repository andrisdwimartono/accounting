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
    // This example has all the renderers loaded,
    // and should work with touch devices.

    $(function(){
        var derivers = $.pivotUtilities.derivers;

        var renderers = $.extend(
            $.pivotUtilities.renderers,
            $.pivotUtilities.c3_renderers,
            $.pivotUtilities.d3_renderers,
            $.pivotUtilities.export_renderers
            );

        // $.getJSON(APP_URL+"/assets/pivottable/mps.json", function(mps) {
        //     $("#output").pivotUI(mps, {
        //         renderers: renderers,
        //         cols: ["Party"], rows: ["Province"],
        //         rendererName: "Horizontal Stacked Bar Chart",
        //         rowOrder: "value_z_to_a", colOrder: "value_z_to_a",
        //         rendererOptions: {
        //             c3: { data: {colors: {
        //                 Liberal: '#dc3912', Conservative: '#3366cc', NDP: '#ff9900',
        //                 Green:'#109618', 'Bloc Quebecois': '#990099'
        //             }}}
        //         }
        //     });
        // });

        $.ajax({
        url: '/dashboard/get_transaction',
        type:"POST",
        data:{
          _token: $("input[name=_token]").val()
        },
        success: function(data) {
          
          data = JSON.parse(data)
          console.log(data.data);

          $("#output").pivotUI(data.data, {
            renderers: renderers,
            aggregatorName: "Sum",
            vals: ["Nominal"],
            rendererName: "Table",
            rowOrder: "value_a_to_z", colOrder: "value_a_to_z",
          });

          $(".output-header").html("Data Transaksi Periode " + data.periode);
        }
      });
     });

</script>
