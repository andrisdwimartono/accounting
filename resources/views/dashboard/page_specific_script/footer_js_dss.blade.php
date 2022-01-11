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

  <script src="{{ asset ("/assets/webdatarocks/webdatarocks.js") }}"></script>
  <script src="{{ asset ("/assets/webdatarocks/webdatarocks.toolbar.min.js") }}"></script>

<script>

var pivot = new WebDataRocks({
	container: "#wdr-component",
	toolbar: true,
	report: {
		dataSource: {
			filename: "https://cdn.webdatarocks.com/data/data.csv"
		}
	}
});
</script>
