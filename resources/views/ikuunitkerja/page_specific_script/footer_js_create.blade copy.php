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

    <!-- <script src="{{ asset ("/assets/jquery/js/jquery-3.6.0.min.js") }}"></script> -->
    <script src="{{ asset ("/assets/node_modules/@popperjs/core/dist/umd/popper.min.js") }}"></script>
    <script src="{{ asset ("/assets/node_modules/gijgo/js/gijgo.min.js") }}"></script>
    <script src="{{ asset ("/assets/node_modules/jquery-toast-plugin/dist/jquery.toast.min.js") }}"></script>
    <script src="{{ asset ("/assets/node_modules/autonumeric/dist/autoNumeric.min.js") }}"></script>
    <script src="{{ asset ("/assets/bootstrap/dist/js/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ asset ("/assets/bower_components/jquery-validation/dist/jquery.validate.min.js") }}"></script>
    <script src="{{ asset ("/assets/bower_components/select2/dist/js/select2.full.min.js") }}"></script>
    <script src="{{ asset ("/assets/datatables/js/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset ("/assets/datatables/js/dataTables.bootstrap4.min.js") }}"></script>
    <script src="{{ asset ("/assets/datatables/js/dataTables.rowReorder.min.js") }}"></script>
    <script src="{{ asset ("/assets/datatables/js/dataTables.buttons.min.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/cakrudtemplate.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/cto_loadinganimation.min.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/dateformatvalidation.min.js") }}"></script>
    <script>
    var editor;
    const anElementInt = AutoNumeric.multiple('.cakautonumeric-integer', {
        decimalCharacter : ',',
        digitGroupSeparator : '.',
        minimumValue : 0,
        decimalPlaces : 0,
        unformatOnSubmit : true
    });

    anObject = {};
    for(var i = 0; i < anElementInt.length; i++){
        anObject[anElementInt[i].domElement.name] = anElementInt[i];
    }

    anObject["nilai_standar"].settings.minimumValue = 0;
    anObject["nilai_baseline"].settings.minimumValue = 0;
    anObject["nilai_renstra"].settings.minimumValue = 0;
    anObject["nilai_target_tahunan"].settings.minimumValue = 0;

    function reRunAutonumeric(){
        Object.keys(anObject).forEach(function(key) {
            anObject[key].set(anObject[key].rawValue);
            $("#"+anObject[key].domElement.name).trigger("change");
        });
    }


$(function () {

    $.validator.setDefaults({
        submitHandler: function (form, event) {
            event.preventDefault();
            cto_loading_show();
            var quickForm = $("#quickForm");

            var values = $('#quickForm').serialize();
            var ajaxRequest;
            ajaxRequest = $.ajax({
                @if($page_data["page_method_name"] == "Update")
                url: "/update{{$page_data["page_data_urlname"]}}/{{$page_data["id"]}}",
                @else
                url: "/store{{$page_data["page_data_urlname"]}}",
                @endif
                type: "post",
                data: values,
                success: function(data){
                    if(data.status >= 200 && data.status <= 299){
                        id_{{$page_data["page_data_urlname"]}} = data.data.id;
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
                    @if($page_data["page_method_name"] == "Update")
                    getdata();
                    @endif
                },
                error: function (err) {
                    if (err.status == 422) {
                        $.each(err.responseJSON.errors, function (i, error) {
                            var validator = $("#quickForm").validate();
                            var errors = {};
                            errors[i] = error[0];
                            validator.showErrors(errors);
                    });
                }
                cto_loading_hide();
            }
        });
    }
});

$("select").select2({
    placeholder: "Pilih satu",
    allowClear: true,
    theme: "bootstrap4" @if($page_data["page_method_name"] == "View"),
    disabled: true @endif
});

$("#jenis_iku").on("change", function() {
    $("#jenis_iku_label").val($("#jenis_iku option:selected").text());
});

$("#unit_pelaksana").on("change", function() {
    $("#unit_pelaksana_label").val($("#unit_pelaksana option:selected").text());
});

$("#unit_pendukung").on("change", function() {
    $("#unit_pendukung_label").val($("#unit_pendukung option:selected").text());
});

$("#nilai_standar_opt").on("change", function() {
    $("#nilai_standar_opt_label").val($("#nilai_standar_opt option:selected").text());
});

$("#satuan_nilai_standar").on("change", function() {
    $("#satuan_nilai_standar_label").val($("#satuan_nilai_standar option:selected").text());
});

$("#nilai_baseline_opt").on("change", function() {
    $("#nilai_baseline_opt_label").val($("#nilai_baseline_opt option:selected").text());
});

$("#satuan_nilai_baseline").on("change", function() {
    $("#satuan_nilai_baseline_label").val($("#satuan_nilai_baseline option:selected").text());
});

$("#nilai_renstra_opt").on("change", function() {
    $("#nilai_renstra_opt_label").val($("#nilai_renstra_opt option:selected").text());
});

$("#satuan_nilai_renstra").on("change", function() {
    $("#satuan_nilai_renstra_label").val($("#satuan_nilai_renstra option:selected").text());
});

$("#nilai_target_tahunan_opt").on("change", function() {
    $("#nilai_target_tahunan_opt_label").val($("#nilai_target_tahunan_opt option:selected").text());
});

$("#satuan_nilai_target_tahunan").on("change", function() {
    $("#satuan_nilai_target_tahunan_label").val($("#satuan_nilai_target_tahunan option:selected").text());
});
var fields = $("#quickForm").serialize();

$.ajax({
    url: "/getoptions{{$page_data["page_data_urlname"]}}",
    type: "post",
    data: {
        fieldname: "jenis_iku",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                var newState = new Option(data[i].label, data[i].name, true, false);
                $("#jenis_iku").append(newState).trigger("change");
            }
        }
    },
    error: function (err) {
        if (err.status == 422) {
            $.each(err.responseJSON.errors, function (i, error) {
                var validator = $("#quickForm").validate();
                var errors = {}
                errors[i] = error[0];
                validator.showErrors(errors);
            });
        }
    }
});

$.ajax({
    url: "/getoptions{{$page_data["page_data_urlname"]}}",
    type: "post",
    data: {
        fieldname: "nilai_standar_opt",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                var newState = new Option(data[i].label, data[i].name, true, false);
                $("#nilai_standar_opt").append(newState).trigger("change");
            }
        }
    },
    error: function (err) {
        if (err.status == 422) {
            $.each(err.responseJSON.errors, function (i, error) {
                var validator = $("#quickForm").validate();
                var errors = {}
                errors[i] = error[0];
                validator.showErrors(errors);
            });
        }
    }
});

$.ajax({
    url: "/getoptions{{$page_data["page_data_urlname"]}}",
    type: "post",
    data: {
        fieldname: "satuan_nilai_standar",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                var newState = new Option(data[i].label, data[i].name, true, false);
                $("#satuan_nilai_standar").append(newState).trigger("change");
            }
        }
    },
    error: function (err) {
        if (err.status == 422) {
            $.each(err.responseJSON.errors, function (i, error) {
                var validator = $("#quickForm").validate();
                var errors = {}
                errors[i] = error[0];
                validator.showErrors(errors);
            });
        }
    }
});

$.ajax({
    url: "/getoptions{{$page_data["page_data_urlname"]}}",
    type: "post",
    data: {
        fieldname: "nilai_baseline_opt",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                var newState = new Option(data[i].label, data[i].name, true, false);
                $("#nilai_baseline_opt").append(newState).trigger("change");
            }
        }
    },
    error: function (err) {
        if (err.status == 422) {
            $.each(err.responseJSON.errors, function (i, error) {
                var validator = $("#quickForm").validate();
                var errors = {}
                errors[i] = error[0];
                validator.showErrors(errors);
            });
        }
    }
});

$.ajax({
    url: "/getoptions{{$page_data["page_data_urlname"]}}",
    type: "post",
    data: {
        fieldname: "satuan_nilai_baseline",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                var newState = new Option(data[i].label, data[i].name, true, false);
                $("#satuan_nilai_baseline").append(newState).trigger("change");
            }
        }
    },
    error: function (err) {
        if (err.status == 422) {
            $.each(err.responseJSON.errors, function (i, error) {
                var validator = $("#quickForm").validate();
                var errors = {}
                errors[i] = error[0];
                validator.showErrors(errors);
            });
        }
    }
});

$.ajax({
    url: "/getoptions{{$page_data["page_data_urlname"]}}",
    type: "post",
    data: {
        fieldname: "nilai_renstra_opt",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                var newState = new Option(data[i].label, data[i].name, true, false);
                $("#nilai_renstra_opt").append(newState).trigger("change");
            }
        }
    },
    error: function (err) {
        if (err.status == 422) {
            $.each(err.responseJSON.errors, function (i, error) {
                var validator = $("#quickForm").validate();
                var errors = {}
                errors[i] = error[0];
                validator.showErrors(errors);
            });
        }
    }
});

$.ajax({
    url: "/getoptions{{$page_data["page_data_urlname"]}}",
    type: "post",
    data: {
        fieldname: "satuan_nilai_renstra",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                var newState = new Option(data[i].label, data[i].name, true, false);
                $("#satuan_nilai_renstra").append(newState).trigger("change");
            }
        }
    },
    error: function (err) {
        if (err.status == 422) {
            $.each(err.responseJSON.errors, function (i, error) {
                var validator = $("#quickForm").validate();
                var errors = {}
                errors[i] = error[0];
                validator.showErrors(errors);
            });
        }
    }
});

$.ajax({
    url: "/getoptions{{$page_data["page_data_urlname"]}}",
    type: "post",
    data: {
        fieldname: "nilai_target_tahunan_opt",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                var newState = new Option(data[i].label, data[i].name, true, false);
                $("#nilai_target_tahunan_opt").append(newState).trigger("change");
            }
        }
    },
    error: function (err) {
        if (err.status == 422) {
            $.each(err.responseJSON.errors, function (i, error) {
                var validator = $("#quickForm").validate();
                var errors = {}
                errors[i] = error[0];
                validator.showErrors(errors);
            });
        }
    }
});

$.ajax({
    url: "/getoptions{{$page_data["page_data_urlname"]}}",
    type: "post",
    data: {
        fieldname: "satuan_nilai_target_tahunan",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                var newState = new Option(data[i].label, data[i].name, true, false);
                $("#satuan_nilai_target_tahunan").append(newState).trigger("change");
            }
        }
    },
    error: function (err) {
        if (err.status == 422) {
            $.each(err.responseJSON.errors, function (i, error) {
                var validator = $("#quickForm").validate();
                var errors = {}
                errors[i] = error[0];
                validator.showErrors(errors);
            });
        }
    }
});

$("#unit_pelaksana").select2({
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

$("#unit_pendukung").select2({
    ajax: {
        url: "/getlinks{{$page_data["page_data_urlname"]}}",
        type: "post",
        dataType: "json",
        data: function(params) {
            return {
                term: params.term || "",
                page: params.page,
                field: "unit_pendukung",
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

$("#quickForm").validate({
    rules: {
        jenis_iku :{
            required: true
        },
        iku_name :{
            required: true
        },
        unit_pelaksana :{
            required: true
        },
        nilai_standar_opt :{
            required: true
        },
        nilai_standar :{
            required: true
        },
        nilai_baseline_opt :{
            required: true
        },
        nilai_baseline :{
            required: true
        },
        nilai_renstra_opt :{
            required: true
        },
        nilai_renstra :{
            required: true
        },
        nilai_target_tahunan_opt :{
            required: true
        },
        nilai_target_tahunan :{
            required: true
        },
    },
    messages: {
        jenis_iku :{
            required: "Jenis IKU harus diisi!!"
        },
        iku_name :{
            required: "Nama harus diisi!!"
        },
        unit_pelaksana :{
            required: "Unit Pelaksana harus diisi!!"
        },
        nilai_standar_opt :{
            required: "Nilai Standar Tanda harus diisi!!"
        },
        nilai_standar :{
            required: "Nilai Standar harus diisi!!"
        },
        nilai_baseline_opt :{
            required: "Nilai Baseline Tanda harus diisi!!"
        },
        nilai_baseline :{
            required: "Nilai Baseline harus diisi!!"
        },
        nilai_renstra_opt :{
            required: "Nilai Renstra Tanda harus diisi!!"
        },
        nilai_renstra :{
            required: "Nilai Renstra harus diisi!!"
        },
        nilai_target_tahunan_opt :{
            required: "Nilai Target TahunanTanda harus diisi!!"
        },
        nilai_target_tahunan :{
            required: "Nilai Target Tahunan harus diisi!!"
        },
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
        error.addClass("invalid-feedback");
        element.closest(".cakfield").append(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass("is-invalid");
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass("is-invalid");
    }
    });

});
$(document).ready(function() {
    @if($page_data["page_method_name"] == "Update" || $page_data["page_method_name"] == "View")
    getdata();
    @endif
} );

@if($page_data["page_method_name"] == "Update" || $page_data["page_method_name"] == "View")
function getdata(){
    cto_loading_show();
    $.ajax({
        url: "/getdata{{$page_data["page_data_urlname"]}}",
        type: "post",
        data: {
            id: {{$page_data["id"]}},
            _token: $("#quickForm input[name=_token]").val()
        },
        success: function(data){
            for(var i = 0; i < Object.keys(data.data.{{$page_data["page_data_urlname"]}}).length; i++){
                if(Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i] == "unit_pelaksana" || Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i] == "unit_pendukung"){
                    if(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]){
                        var newState = new Option(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"_label"], data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]], true, false);
                        $("#"+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]).append(newState).trigger("change");
                    }
                }else{
                    if(["ewfsdfsafdsafasdfasdferad"].includes(Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i])){
                        $("input[name="+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"]").prop("checked", data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]);
                    }else{
                    try{
                        anObject[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]].set(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]);
                    }catch(err){
                        $("input[name="+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"]").val(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]);
                    }
                        $("textarea[name="+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"]").val(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]);
                        if(["ewfsdfsafdsafasdfasdferad"].includes(Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i])){
                            if(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]] != null){
                                $("#btn_"+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"").removeAttr("disabled");
                                $("#btn_"+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"").addClass("btn-success text-white");
                                $("#btn_"+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"").removeClass("btn-primary");
                                var filename = Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i];
                                $("label[for=upload_"+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"]").html(filename);
                                $("#btn_"+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"").html("Download");
                            }
                        }
                    }
                    $("select[name="+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"]").val(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]).change();
                }
                }

        cto_loading_hide();
    },
        error: function (err) {
            // console.log(err);
            if (err.status >= 400 && err.status <= 500) {
                $.toast({
                    text: err.status+" "+err.responseJSON.message,
                    heading: 'Status',
                    icon: 'warning',
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
    @endif
</script>