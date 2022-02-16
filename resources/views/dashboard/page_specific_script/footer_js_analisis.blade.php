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
  <script src="{{ asset ("/assets/jspdf.debug.js") }}"></script>
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

  var myChart;


  (function($) {
    "use strict"

    $("#neraca").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#neraca_wrapper .col-md-6:eq(0)');

    //basic bar chart
    if(jQuery('#laporanChart').length > 0 ){
        //gradient bar chart
        const barChart_2 = document.getElementById("laporanChart").getContext('2d');
        //generate gradient
        const barChart_2gradientStroke = barChart_2.createLinearGradient(0, 0, 500, 0);
        barChart_2gradientStroke.addColorStop(0, "rgba(58, 122, 254, 1)");
        barChart_2gradientStroke.addColorStop(1, "rgba(58, 122, 254, 0.7)");
        const barChart_2gradientStroke2 = barChart_2.createLinearGradient(0, 0, 500, 0);
        barChart_2gradientStroke2.addColorStop(0, "rgba(190, 212, 255, 1)");
        barChart_2gradientStroke2.addColorStop(1, "rgba(190, 212, 255, 0.7)");

        barChart_2.height = 150;

        myChart = new Chart(barChart_2, {
            type: 'bar',
            data: {
                defaultFontFamily: 'Poppins',
            },
            options: {
              responsive: true,
              scales: {
                  xAxes : [{
                      ticks : {
                          min : 0,
                      }
                  }],
              },
              tooltips: {
                enabled: true,
                mode: 'index',
                // callbacks: {
                //     label: function(tooltipItems, data, i) {
                //       return data.datasets[tooltipItems.datasetIndex].label + ' : ' + data.datasets[tooltipItems.datasetIndex].nominal[tooltipItems.datasetIndex] + ' (' + data.datasets[tooltipItems.datasetIndex].percent[tooltipItems.datasetIndex].toString() + "%)";
                //     }
                // }
              },
            },
        });
    }
  })(jQuery);

  

  $(document).ready(function(){
    
    var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
         };

    function fetch_data(){
      bulan = parseInt($("#bulan_periode").val())
      tahun = parseInt($("#tahun_periode").val())
      console.log(myChart);
      $.ajax({
        url: '/dashboard/get_analisis',
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
          console.log("PRINT")
          console.log(data)
          // for(i=0;i<data.length;i++){
            // add new label and data point to chart's underlying data structures
            // console.log(data)
            myChart.data.labels = data.bulan.reverse();
            myChart.data.datasets = [{
              label : 'ROA',
              data : data.roa.reverse(),
              backgroundColor : dynamicColors()
            },{
              label : 'ROI',
              data : data.roi.reverse(),
              backgroundColor : dynamicColors()
            },{
              label : 'ROE',
              data : data.roe.reverse(),
              backgroundColor : dynamicColors()
            }]
            // myChart.data.datasets[i].data = data[i].data;
            // myChart.data.datasets[i].nominal = data[i].nominal;
            // myChart.data.datasets[i].percent = data[i].percent;
            // myChart.data.datasets[i].label = data[i].bulan + " " + data[i].tahun;
            
            // myChart.legend.legendItems[i].text = data[i].bulan + " " + data[i].tahun;
            
          // }
          // myChart.height = (data[0].data.length)*100;
          // var canvas = document.getElementById("output")
          // canvas.height = (data[0].data.length)*100;
          // re-render the chart
          myChart.update();
        }
      });
    }

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
  


    function convertCode(data){
      var val = "";
      for(var i = 0; i < data.length; i++){
          if(i == 2 || i == 6){
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

    $("#child_level").on("change", function() {
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

    $('#downloadPdf').click(function(event) {
      // get size of report page
      var reportPageHeight = $('.card').innerHeight();
      var reportPageWidth = $('.card').innerWidth();
      
      // create a new canvas object that we will populate with all other canvas objects
      var pdfCanvas = $('<canvas />').attr({
        id: "canvaspdf",
        width: reportPageWidth,
        height: reportPageHeight
      });
      
      // keep track canvas position
      var pdfctx = $(pdfCanvas)[0].getContext('2d');
      var pdfctxX = 0;
      var pdfctxY = 0;
      var buffer = 100;
      
      // for each chart.js chart
      $("canvas").each(function(index) {
        // get the chart height/width
        var canvasHeight = $(this).innerHeight();
        var canvasWidth = $(this).innerWidth();
        
        // draw the chart into the new canvas
        pdfctx.drawImage($(this)[0], pdfctxX, pdfctxY, canvasWidth, canvasHeight);
        pdfctxX += canvasWidth + buffer;
        
        // our report page is in a grid pattern so replicate that in the new canvas
        if (index % 2 === 1) {
          pdfctxX = 0;
          pdfctxY += canvasHeight + buffer;
        }
      });
      
      // create new pdf and add our new canvas as an image
      var pdf = new jsPDF('l', 'pt', [reportPageWidth, reportPageHeight]);
      pdf.addImage($(pdfCanvas)[0], 'PNG', 0, 0);
      
      // download the pdf
      pdf.save('filename.pdf');
    });
  });

</script>
