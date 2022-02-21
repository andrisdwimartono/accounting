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
    const anElementInt = AutoNumeric.multiple('.cakautonumeric-float', {
        decimalCharacter : ',',
        digitGroupSeparator : '.',
        minimumValue : 0,
        decimalPlaces : 2,
        unformatOnSubmit : true
    });

    anObject = {};
    for(var i = 0; i < anElementInt.length; i++){
        anObject[anElementInt[i].domElement.name] = anElementInt[i];
    }
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
        var ctct1_iku = [];
        var table = $("#ctct1_iku").DataTable().rows().data();
        for(var i = 0; i < table.length; i++){
            ctct1_iku.push({"no_seq": table[i][0], "jenis_iku": table[i][1], "jenis_iku_label": table[i][2], "iku_name": table[i][3], "unit_pelaksana": $("#iku_unit_pelaksana").val(), "unit_pelaksana_label": $("#iku_unit_pelaksana_label").val(), "tahun": $("#iku_tahun").val(), "unit_pendukung": table[i][7], "unit_pendukung_label": table[i][8], "nilai_standar_opt": table[i][9], "nilai_standar_opt_label": table[i][10], "nilai_standar": table[i][11], "satuan_nilai_standar": table[i][12], "satuan_nilai_standar_label": table[i][13], "nilai_baseline_opt": table[i][14], "nilai_baseline_opt_label": table[i][15], "nilai_baseline": table[i][16], "satuan_nilai_baseline": table[i][17], "satuan_nilai_baseline_label": table[i][18], "nilai_renstra_opt": table[i][19], "nilai_renstra_opt_label": table[i][20], "nilai_renstra": table[i][21], "satuan_nilai_renstra": table[i][22], "satuan_nilai_renstra_label": table[i][23], "nilai_target_tahunan_opt": table[i][24], "nilai_target_tahunan_opt_label": table[i][25], "nilai_target_tahunan": table[i][26], "satuan_nilai_target_tahunan": table[i][27], "satuan_nilai_target_tahunan_label": table[i][28], "keterangan": table[i][29], "sumber_data": table[i][30], "rujukan": table[i][31], "upload_detail": table[i][32], "id": table[i][table.columns().header().length-1]});
        }
        $("#ct1_iku").val(JSON.stringify(ctct1_iku));
        var id_{{$page_data["page_data_urlname"]}} = 0;
        var values = $("#quickForm").serialize();

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
                        if(i == "jenis_iku" || i == "jenis_iku_label" || i == "iku_name" || i == "unit_pelaksana" || i == "unit_pelaksana_label" || i == "tahun" || i == "unit_pendukung" || i == "unit_pendukung_label" || i == "nilai_standar_opt" || i == "nilai_standar_opt_label" || i == "nilai_standar" || i == "satuan_nilai_standar" || i == "satuan_nilai_standar_label" || i == "nilai_baseline_opt" || i == "nilai_baseline_opt_label" || i == "nilai_baseline" || i == "satuan_nilai_baseline" || i == "satuan_nilai_baseline_label" || i == "nilai_renstra_opt" || i == "nilai_renstra_opt_label" || i == "nilai_renstra" || i == "satuan_nilai_renstra" || i == "satuan_nilai_renstra_label" || i == "nilai_target_tahunan_opt" || i == "nilai_target_tahunan_opt_label" || i == "nilai_target_tahunan" || i == "satuan_nilai_target_tahunan" || i == "satuan_nilai_target_tahunan_label" || i == "keterangan" || i == "sumber_data" || i == "rujukan" || i == "upload_detail"){
                            errors["ct1_iku"] = error[0];
                        }else{
                            errors[i] = error[0];
                        }
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

$.fn.modal.Constructor.prototype._enforceFocus = function() {

};

$("#iku_tahun").on("change", function() {
$("#iku_tahun_label").val($("#iku_tahun option:selected").text());
});

$("#iku_unit_pelaksana").on("change", function() {
$("#iku_unit_pelaksana_label").val($("#iku_unit_pelaksana option:selected").text());
});

$("#jenis_iku").on("change", function() {
$("#jenis_iku_label").val($("#jenis_iku option:selected").text());
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

$("#unit_pelaksana").on("change", function() {
    $("#unit_pelaksana_label").val($("#unit_pelaksana option:selected").text());
});


var fields = $("#quickForm").serialize();

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


$.ajax({
url: "/getoptions{{$page_data["page_data_urlname"]}}",
type: "post",
data: {
    fieldname: "jenis_iku",
    _token: $("#quickForm input[name=_token]").val()
},
success: function(data){
    var newState = new Option("", "", true, false);
    $("#jenis_iku").append(newState).trigger("change");
    for(var i = 0; i < data.length; i++){
        if(data[i].name){
            newState = new Option(data[i].label, data[i].name, true, false);
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
    var newState = new Option("", "", true, false);
    $("#nilai_standar_opt").append(newState).trigger("change");
    for(var i = 0; i < data.length; i++){
        if(data[i].name){
            newState = new Option(data[i].label, data[i].name, true, false);
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
    var newState = new Option("", "", true, false);
    $("#satuan_nilai_standar").append(newState).trigger("change");
    for(var i = 0; i < data.length; i++){
        if(data[i].name){
            newState = new Option(data[i].label, data[i].name, true, false);
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
    var newState = new Option("", "", true, false);
    $("#nilai_baseline_opt").append(newState).trigger("change");
    for(var i = 0; i < data.length; i++){
        if(data[i].name){
            newState = new Option(data[i].label, data[i].name, true, false);
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
    var newState = new Option("", "", true, false);
    $("#satuan_nilai_baseline").append(newState).trigger("change");
    for(var i = 0; i < data.length; i++){
        if(data[i].name){
            newState = new Option(data[i].label, data[i].name, true, false);
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
    var newState = new Option("", "", true, false);
    $("#nilai_renstra_opt").append(newState).trigger("change");
    for(var i = 0; i < data.length; i++){
        if(data[i].name){
            newState = new Option(data[i].label, data[i].name, true, false);
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
    var newState = new Option("", "", true, false);
    $("#satuan_nilai_renstra").append(newState).trigger("change");
    for(var i = 0; i < data.length; i++){
        if(data[i].name){
            newState = new Option(data[i].label, data[i].name, true, false);
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
    var newState = new Option("", "", true, false);
    $("#nilai_target_tahunan_opt").append(newState).trigger("change");
    for(var i = 0; i < data.length; i++){
        if(data[i].name){
            newState = new Option(data[i].label, data[i].name, true, false);
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
    var newState = new Option("", "", true, false);
    $("#satuan_nilai_target_tahunan").append(newState).trigger("change");
    for(var i = 0; i < data.length; i++){
        if(data[i].name){
            newState = new Option(data[i].label, data[i].name, true, false);
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

$("#iku_unit_pelaksana").select2({
placeholder: "Pilih satu",
allowClear: true,
theme: "bootstrap4", @if($page_data["page_method_name"] == "View")
disabled: true, @endif
ajax: {
    url: "/getlinks{{$page_data["page_data_urlname"]}}",
    type: "post",
    dataType: "json",
    data: function(params) {
        return {
            term: params.term || "",
            page: params.page,
            field: "iku_unit_pelaksana",
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
placeholder: "Pilih satu",
allowClear: true,
theme: "bootstrap4", @if($page_data["page_method_name"] == "View")
disabled: true, @endif
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
    iku_tahun :{
        required: true
    },
    iku_unit_pelaksana :{
        required: true
    },
},
messages: {
    iku_tahun :{
        required: "Tahun harus diisi!!"
    },
    iku_unit_pelaksana :{
        required: "Unit Pelaksana harus diisi!!"
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

$("#quickModalForm_ct1_iku").validate({
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
    unit_pelaksana_label :{
        required: true
    },
    tahun :{
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
    unit_pelaksana_label :{
        required: "Unit Pelaksana harus diisi!!"
    },
    tahun :{
        required: "Tahun harus diisi!!"
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
var table_ct1_iku = $("#ctct1_iku").DataTable({
    @if($page_data["page_method_name"] != "View")
    rowReorder: true,
    @endif
    aoColumnDefs: [{
        aTargets: [11, 16, 21, 26],
        mRender: function (data, type, full){
            var formattedvalue = parseFloat(data).toFixed(2);
            formattedvalue = formattedvalue.toString().replace(".", ",");
            formattedvalue = formattedvalue.toString().replace(/(\d+)(\d{3})/, '$1'+'.'+'$2');
            return formattedvalue;
        }
    }],
    //add button
    dom: "Bfrtip" @if($page_data["page_method_name"] != "View") ,
    buttons: [
        {
            text: "New",
            action: function ( e, dt, node, config ) {
                $("#staticBackdrop_ct1_iku").modal({"show": true});
                addChildTable_ct1_iku("staticBackdrop_ct1_iku");
            }
        }
    ]
    @endif
});

table_ct1_iku.column(table_ct1_iku.columns().header().length-1).visible(false);
table_ct1_iku.column(1).visible(false);
table_ct1_iku.column(4).visible(false);
table_ct1_iku.column(5).visible(false);
table_ct1_iku.column(6).visible(false);
table_ct1_iku.column(7).visible(false);
table_ct1_iku.column(8).visible(false);
table_ct1_iku.column(9).visible(false);
table_ct1_iku.column(10).visible(false);
table_ct1_iku.column(12).visible(false);
table_ct1_iku.column(13).visible(false);
table_ct1_iku.column(14).visible(false);
table_ct1_iku.column(15).visible(false);
table_ct1_iku.column(17).visible(false);
table_ct1_iku.column(18).visible(false);
table_ct1_iku.column(19).visible(false);
table_ct1_iku.column(20).visible(false);
table_ct1_iku.column(22).visible(false);
table_ct1_iku.column(23).visible(false);
table_ct1_iku.column(24).visible(false);
table_ct1_iku.column(25).visible(false);
table_ct1_iku.column(27).visible(false);
table_ct1_iku.column(28).visible(false);
table_ct1_iku.column(29).visible(false);
table_ct1_iku.column(30).visible(false);
table_ct1_iku.column(31).visible(false);
table_ct1_iku.column(32).visible(false);

$("#ctct1_iku tbody").on( "click", ".row-show", function () {
    $("#staticBackdrop_ct1_iku").modal({"show": true});
    showChildTable_ct1_iku("staticBackdrop_ct1_iku", table_ct1_iku.row( $(this).parents("tr") ));
} );

$("#staticBackdropClose_ct1_iku").click(function(){
    $("#staticBackdrop_ct1_iku").modal("hide");
});

table_ct1_iku.on( "row-reorder", function ( e, diff, edit ) {
        var result = "Reorder started on row: "+edit.triggerRow.data()[1]+"<br>";
        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            var rowData = table_ct1_iku.row( diff[i].node ).data();
            result += rowData[1]+" updated to be in position "+
                diff[i].newData+" (was "+diff[i].oldData+")<br>";
        }
    $("#result").html( "Event result:<br>"+result );
} );
$("#ctct1_iku tbody").on("click", ".row-delete", function () {
    table_ct1_iku.row($(this).parents("tr")).remove().draw();
});

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
        @if(isset($page_data["ikt"]) && $page_data["ikt"])
        ,is_ikt: 'on'
        @endif
    },
    success: function(data){
        for(var i = 0; i < Object.keys(data.data.{{$page_data['page_data_urlname']}}).length; i++){
                if(Object.keys(data.data.{{$page_data['page_data_urlname']}})[i] == "unit_pelaksana" ){
                    if(data.data.{{$page_data['page_data_urlname']}}[Object.keys(data.data.{{$page_data['page_data_urlname']}})[i]]){
                        var newState = new Option(data.data.{{$page_data['page_data_urlname']}}[Object.keys(data.data.{{$page_data['page_data_urlname']}})[i]+"_label"], data.data.{{$page_data['page_data_urlname']}}[Object.keys(data.data.{{$page_data['page_data_urlname']}})[i]], true, false);
                        $("#"+Object.keys(data.data.{{$page_data['page_data_urlname']}})[i]).append(newState).trigger("change");
                    }
                }else{
                    $("textarea[name="+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"]").val(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]);
                    $("input[name="+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"]").val(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]);
                        if(["photo_profile"].includes(Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i])){
                            if(Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i] != ""){
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
function addChildTable_ct1_iku(childtablename){
$("select[name='jenis_iku']").val(null).trigger('change')
$("input[name='jenis_iku_label']").val("");
$("input[name='iku_name']").val("");
$("input[name='unit_pelaksana']").val("");
$("input[name='unit_pelaksana_label']").val("");
$("input[name='tahun']").val("");
$("select[name='unit_pendukung']").empty();
$("input[name='unit_pendukung_label']").val("");
$("select[name='nilai_standar_opt']").val(null).trigger('change')
$("input[name='nilai_standar_opt_label']").val("");
$("input[name='nilai_standar']").val("");
$("select[name='satuan_nilai_standar']").val(null).trigger('change')
$("input[name='satuan_nilai_standar_label']").val("");
$("select[name='nilai_baseline_opt']").val(null).trigger('change')
$("input[name='nilai_baseline_opt_label']").val("");
$("input[name='nilai_baseline']").val("");
$("select[name='satuan_nilai_baseline']").val(null).trigger('change')
$("input[name='satuan_nilai_baseline_label']").val("");
$("select[name='nilai_renstra_opt']").val(null).trigger('change')
$("input[name='nilai_renstra_opt_label']").val("");
$("input[name='nilai_renstra']").val("");
$("select[name='satuan_nilai_renstra']").val(null).trigger('change')
$("input[name='satuan_nilai_renstra_label']").val("");
$("select[name='nilai_target_tahunan_opt']").val(null).trigger('change')
$("input[name='nilai_target_tahunan_opt_label']").val("");
$("input[name='nilai_target_tahunan']").val("");
$("select[name='satuan_nilai_target_tahunan']").val(null).trigger('change')
$("input[name='satuan_nilai_target_tahunan_label']").val("");
$("textarea[name='keterangan']").val("");
$("textarea[name='sumber_data']").val("");
$("input[name='rujukan']").val("");
$("input[name='upload_detail']").val("");
$("#btn_upload_detail").attr("disabled", true);
$("#btn_upload_detail").removeClass("btn-success text-white");
$("label[for=upload_upload_detail]").html("Pilih file Upload File Pendukung");
$("#btn_upload_detail").html("Upload");

@if($page_data["page_method_name"] != "View")
$("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropAdd_ct1_iku" class="btn btn-primary">Add Row</button>');
@endif

$("#staticBackdropAdd_ct1_iku").click(function(e){
    e.preventDefault;
    var dttb = $('#ctct1_iku').DataTable();

    var no_seq = dttb.rows().count();
    var jenis_iku = $("select[name='jenis_iku'] option").filter(':selected').val();
    if(!jenis_iku){
        jenis_iku = null;
    }
    var jenis_iku_label = $("input[name='jenis_iku_label']").val();
    var iku_name = $("input[name='iku_name']").val();
    var unit_pelaksana = $("input[name='unit_pelaksana']").val();
    var unit_pelaksana_label = $("input[name='unit_pelaksana_label']").val();
    var tahun = $("input[name='tahun']").val();
    var unit_pendukung = $("select[name='unit_pendukung'] option").filter(':selected').val();
    if(!unit_pendukung){
        unit_pendukung = null;
    }
    var unit_pendukung_label = $("input[name='unit_pendukung_label']").val();
    var nilai_standar_opt = $("select[name='nilai_standar_opt'] option").filter(':selected').val();
    if(!nilai_standar_opt){
        nilai_standar_opt = null;
    }
    var nilai_standar_opt_label = $("input[name='nilai_standar_opt_label']").val();
    var nilai_standar = anObject["nilai_standar"].rawValue;
    var satuan_nilai_standar = $("select[name='satuan_nilai_standar'] option").filter(':selected').val();
    if(!satuan_nilai_standar){
        satuan_nilai_standar = null;
    }
    var satuan_nilai_standar_label = $("input[name='satuan_nilai_standar_label']").val();
    var nilai_baseline_opt = $("select[name='nilai_baseline_opt'] option").filter(':selected').val();
    if(!nilai_baseline_opt){
        nilai_baseline_opt = null;
    }
    var nilai_baseline_opt_label = $("input[name='nilai_baseline_opt_label']").val();
    var nilai_baseline = anObject["nilai_baseline"].rawValue;
    var satuan_nilai_baseline = $("select[name='satuan_nilai_baseline'] option").filter(':selected').val();
    if(!satuan_nilai_baseline){
        satuan_nilai_baseline = null;
    }
    var satuan_nilai_baseline_label = $("input[name='satuan_nilai_baseline_label']").val();
    var nilai_renstra_opt = $("select[name='nilai_renstra_opt'] option").filter(':selected').val();
    if(!nilai_renstra_opt){
        nilai_renstra_opt = null;
    }
    var nilai_renstra_opt_label = $("input[name='nilai_renstra_opt_label']").val();
    var nilai_renstra = anObject["nilai_renstra"].rawValue;
    var satuan_nilai_renstra = $("select[name='satuan_nilai_renstra'] option").filter(':selected').val();
    if(!satuan_nilai_renstra){
        satuan_nilai_renstra = null;
    }
    var satuan_nilai_renstra_label = $("input[name='satuan_nilai_renstra_label']").val();
    var nilai_target_tahunan_opt = $("select[name='nilai_target_tahunan_opt'] option").filter(':selected').val();
    if(!nilai_target_tahunan_opt){
        nilai_target_tahunan_opt = null;
    }
    var nilai_target_tahunan_opt_label = $("input[name='nilai_target_tahunan_opt_label']").val();
    var nilai_target_tahunan = anObject["nilai_target_tahunan"].rawValue;
    var satuan_nilai_target_tahunan = $("select[name='satuan_nilai_target_tahunan'] option").filter(':selected').val();
    if(!satuan_nilai_target_tahunan){
        satuan_nilai_target_tahunan = null;
    }
    var satuan_nilai_target_tahunan_label = $("input[name='satuan_nilai_target_tahunan_label']").val();
    var keterangan = $("textarea[name='keterangan']").val();
    var sumber_data = $("textarea[name='sumber_data']").val();
    var rujukan = $("input[name='rujukan']").val();
    var upload_detail = $("input[name='upload_detail']").val();

    var child_table_data = [no_seq+1, jenis_iku, jenis_iku_label, iku_name, unit_pelaksana, unit_pelaksana_label, tahun, unit_pendukung, unit_pendukung_label, nilai_standar_opt, nilai_standar_opt_label, nilai_standar, satuan_nilai_standar, satuan_nilai_standar_label, nilai_baseline_opt, nilai_baseline_opt_label, nilai_baseline, satuan_nilai_baseline, satuan_nilai_baseline_label, nilai_renstra_opt, nilai_renstra_opt_label, nilai_renstra, satuan_nilai_renstra, satuan_nilai_renstra_label, nilai_target_tahunan_opt, nilai_target_tahunan_opt_label, nilai_target_tahunan, satuan_nilai_target_tahunan, satuan_nilai_target_tahunan_label, keterangan, sumber_data, rujukan, upload_detail, '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>', null];

    if(validatequickModalForm_ct1_iku()){
        if(dttb.row.add(child_table_data).draw( false )){
            $('#staticBackdrop_ct1_iku').modal('hide');
        }
    }
});
}

function showChildTable_ct1_iku(childtablename, data){
    $("select[name='jenis_iku']").val(data.data()[1]);
    $("select[name='jenis_iku']").select2().trigger('change');
    $("input[name='jenis_iku_label']").val(data.data()[2]);
    $("input[name='iku_name']").val(data.data()[3]);
    $("input[name='unit_pelaksana']").val(data.data()[4]);
    $("input[name='unit_pelaksana_label']").val(data.data()[5]);
    $("input[name='tahun']").val(data.data()[6]);
    $("select[name='unit_pendukung']").empty();
    var newState = new Option(data.data()[8], data.data()[7], true, false);
    $("#unit_pendukung").append(newState).trigger('change');
    $("input[name='unit_pendukung_label']").val(data.data()[8]);
    $("select[name='nilai_standar_opt']").val(data.data()[9]);
    $("select[name='nilai_standar_opt']").select2().trigger('change');
    $("input[name='nilai_standar_opt_label']").val(data.data()[10]);
    anObject["nilai_standar"].set(data.data()[11]);
    $("select[name='satuan_nilai_standar']").val(data.data()[12]);
    $("select[name='satuan_nilai_standar']").select2().trigger('change');
    $("input[name='satuan_nilai_standar_label']").val(data.data()[13]);
    $("select[name='nilai_baseline_opt']").val(data.data()[14]);
    $("select[name='nilai_baseline_opt']").select2().trigger('change');
    $("input[name='nilai_baseline_opt_label']").val(data.data()[15]);
    anObject["nilai_baseline"].set(data.data()[16]);
    $("select[name='satuan_nilai_baseline']").val(data.data()[17]);
    $("select[name='satuan_nilai_baseline']").select2().trigger('change');
    $("input[name='satuan_nilai_baseline_label']").val(data.data()[18]);
    $("select[name='nilai_renstra_opt']").val(data.data()[19]);
    $("select[name='nilai_renstra_opt']").select2().trigger('change');
    $("input[name='nilai_renstra_opt_label']").val(data.data()[20]);
    anObject["nilai_renstra"].set(data.data()[21]);
    $("select[name='satuan_nilai_renstra']").val(data.data()[22]);
    $("select[name='satuan_nilai_renstra']").select2().trigger('change');
    $("input[name='satuan_nilai_renstra_label']").val(data.data()[23]);
    $("select[name='nilai_target_tahunan_opt']").val(data.data()[24]);
    $("select[name='nilai_target_tahunan_opt']").select2().trigger('change');
    $("input[name='nilai_target_tahunan_opt_label']").val(data.data()[25]);
    anObject["nilai_target_tahunan"].set(data.data()[26]);
    $("select[name='satuan_nilai_target_tahunan']").val(data.data()[27]);
    $("select[name='satuan_nilai_target_tahunan']").select2().trigger('change');
    $("input[name='satuan_nilai_target_tahunan_label']").val(data.data()[28]);
    $("textarea[name='keterangan']").val(data.data()[29]);
    $("textarea[name='sumber_data']").val(data.data()[30]);
    $("input[name='rujukan']").val(data.data()[31]);
    $("input[name='upload_detail']").val(data.data()[32]);
    if(data.data()[32] != ""){
        $("#btn_upload_detail").removeAttr("disabled");
        $("#btn_upload_detail").addClass("btn-success text-white");
        $("#btn_upload_detail").removeClass("btn-primary");
        var filename = data.data()[32];
        $("label[for=upload_upload_detail]").html(filename);
        $("#btn_upload_detail").html("Download");
    }

    <?php if($page_data["page_method_name"] != "View"){ ?>
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropUpdate_ct1_iku" class="btn btn-primary">Update</button>');
    <?php } ?>

    $("#staticBackdropUpdate_ct1_iku").click(function(e){
        var temp = data.data();
        temp[1] = $("select[name='jenis_iku'] option").filter(':selected').val();
        if(!jenis_iku){
            jenis_iku = null;
        }
        temp[2] = $("input[name='jenis_iku_label']").val();
        temp[3] = $("input[name='iku_name']").val();
        temp[4] = $("input[name='unit_pelaksana']").val();
        temp[5] = $("input[name='unit_pelaksana_label']").val();
        temp[6] = $("input[name='tahun']").val();
        temp[7] = $("select[name='unit_pendukung'] option").filter(':selected').val();
        if(!unit_pendukung){
            unit_pendukung = null;
        }
        temp[8] = $("input[name='unit_pendukung_label']").val();
        temp[9] = $("select[name='nilai_standar_opt'] option").filter(':selected').val();
        if(!nilai_standar_opt){
            nilai_standar_opt = null;
        }
        temp[10] = $("input[name='nilai_standar_opt_label']").val();
        temp[11] = anObject["nilai_standar"].rawValue;
        temp[12] = $("select[name='satuan_nilai_standar'] option").filter(':selected').val();
        if(!satuan_nilai_standar){
            satuan_nilai_standar = null;
        }
        temp[13] = $("input[name='satuan_nilai_standar_label']").val();
        temp[14] = $("select[name='nilai_baseline_opt'] option").filter(':selected').val();
        if(!nilai_baseline_opt){
            nilai_baseline_opt = null;
        }
        temp[15] = $("input[name='nilai_baseline_opt_label']").val();
        temp[16] = anObject["nilai_baseline"].rawValue;
        temp[17] = $("select[name='satuan_nilai_baseline'] option").filter(':selected').val();
        if(!satuan_nilai_baseline){
            satuan_nilai_baseline = null;
        }
        temp[18] = $("input[name='satuan_nilai_baseline_label']").val();
        temp[19] = $("select[name='nilai_renstra_opt'] option").filter(':selected').val();
        if(!nilai_renstra_opt){
            nilai_renstra_opt = null;
        }
        temp[20] = $("input[name='nilai_renstra_opt_label']").val();
        temp[21] = anObject["nilai_renstra"].rawValue;
        temp[22] = $("select[name='satuan_nilai_renstra'] option").filter(':selected').val();
        if(!satuan_nilai_renstra){
            satuan_nilai_renstra = null;
        }
        temp[23] = $("input[name='satuan_nilai_renstra_label']").val();
        temp[24] = $("select[name='nilai_target_tahunan_opt'] option").filter(':selected').val();
        if(!nilai_target_tahunan_opt){
            nilai_target_tahunan_opt = null;
        }
        temp[25] = $("input[name='nilai_target_tahunan_opt_label']").val();
        temp[26] = anObject["nilai_target_tahunan"].rawValue;
        temp[27] = $("select[name='satuan_nilai_target_tahunan'] option").filter(':selected').val();
        if(!satuan_nilai_target_tahunan){
            satuan_nilai_target_tahunan = null;
        }
        temp[28] = $("input[name='satuan_nilai_target_tahunan_label']").val();
        temp[29] = $("textarea[name='keterangan']").val();
        temp[30] = $("textarea[name='sumber_data']").val();
        temp[31] = $("input[name='rujukan']").val();
        temp[32] = $("input[name='upload_detail']").val();
        if( validatequickModalForm_ct1_iku() ){
            data.data(temp).invalidate();
            $("#staticBackdrop_ct1_iku").modal("hide");
        }
    });
}

function validatequickModalForm_ct1_iku(){
var validation = $("#quickModalForm_ct1_iku").validate({
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
    unit_pelaksana_label :{
        required: true
    },
    tahun :{
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
    unit_pelaksana_label :{
        required: "Unit Pelaksana harus diisi!!"
    },
    tahun :{
        required: "Tahun harus diisi!!"
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

validation.form();
if(validation.errorList.length > 0){
    return false;
}else{
    return true;
}
}

function selectingfile(fieldid){
$("#btn_"+fieldid).removeAttr("disabled");
$("#btn_"+fieldid).addClass("btn-primary text-white");
$("#btn_"+fieldid).removeClass("btn-success");
var filename = document.getElementById("upload_"+fieldid).files[0].name;
$("label[for=upload_"+fieldid+"]").html(filename);
$("#btn_"+fieldid).html("Upload");
$("#"+fieldid).val("");
}

$("#btn_upload_dokumen").on('click', function(){
if($("#upload_dokumen").val() != ""){
    fetch('{{ asset ("/upload_dokumen/") }}/'+$("#upload_dokumen").val()).then(resp => resp.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = $("#upload_dokumen").val();
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
    })
    .catch(() => {
        $.toast({
            text: 'Download gagal',
            heading: 'Status',
            icon: 'warning',
            showHideTransition: 'fade',
            allowToastClose: true,
            hideAfter: 3000,
            position: 'mid-center',
            textAlign: 'left'
        });
    });
}else{
    $("#btn_upload_dokumen").attr("disabled", true);
    $("#btn_upload_dokumen").removeClass("btn-primary text-white");
    
    var uploadfile = document.getElementById("upload_upload_dokumen").files[0];
    var name = uploadfile.name;
    var form_data = new FormData();
    var ext = name.split('.').pop().toLowerCase();
    if(jQuery.inArray(ext, ['pdf','PDF','doc','DOC','docx','DOCX','xls','XLS','xlsx','XLSX','jpg','JPG','jpeg','JPEG','png','PNG','zip','ZIP','rar','RAR']) == -1){
        $.toast({
            text: "Format file harus '.pdf','.PDF','.doc','.DOC','.docx','.DOCX','.xls','.XLS','.xlsx','.XLSX','.jpg','.JPG','.jpeg','.JPEG','.png','.PNG','.zip','.ZIP','.rar','.RAR'",
            heading: 'Status',
            icon: 'warning',
            showHideTransition: 'fade',
            allowToastClose: true,
            hideAfter: 3000,
            position: 'mid-center',
            textAlign: 'left'
        });
        return;
    }
    var oFReader = new FileReader();
    oFReader.readAsDataURL(uploadfile);
    var f = uploadfile;
    var fsize = f.size||f.fileSize;
    if(fsize > 2000000){
        $.toast({
            text: "Ukuran file terlalu bersar",
            heading: 'Status',
            icon: 'warning',
            showHideTransition: 'fade',
            allowToastClose: true,
            hideAfter: 3000,
            position: 'mid-center',
            textAlign: 'left'
        });
    }else{
        form_data.append("file", uploadfile);
        form_data.append("_token", $("#quickForm input[name=_token]").val());
        form_data.append("menname", "upload_dokumen");
        $.ajax({
            url:"/uploadfileikuunitkerja",
            method:"POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(){
                $("label[for=upload_upload_dokumen]").html("Uploading <i class=\"fas fa-spinner fa-pulse\"></i>");
            },
            success:function(data){
                if(data.status >= 200 && data.status <= 299){
                    $("label[for=upload_upload_dokumen]").html("Finished upload file");
                    $("#upload_dokumen").val(data.filename);
                    $("#btn_upload_dokumen").attr("disabled", false);
                    $("#btn_upload_dokumen").addClass("btn-success text-white");
                    $("#btn_upload_dokumen").html("Download");
                }
            },
            error: function (err) {
                if (err.status >= 400) {
                    $.toast({
                        text: "Gagal upload",
                        heading: 'Status',
                        icon: 'warning',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        position: 'mid-center',
                        textAlign: 'left'
                    });
                }
            }
        });
    }
}
});

$("#btn_upload_detail").on('click', function(){
if($("#upload_detail").val() != ""){
    fetch('{{ asset ("/upload_detail/") }}/'+$("#upload_detail").val()).then(resp => resp.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = $("#upload_detail").val();
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
    })
    .catch(() => {
        $.toast({
            text: "Download gagal",
            heading: 'Status',
            icon: 'warning',
            showHideTransition: 'fade',
            allowToastClose: true,
            hideAfter: 3000,
            position: 'mid-center',
            textAlign: 'left'
        });
    });
}else{
    $("#btn_upload_detail").attr("disabled", true);
    $("#btn_upload_detail").removeClass("btn-primary text-white");
    
    var uploadfile = document.getElementById("upload_upload_detail").files[0];
    var name = uploadfile.name;
    var form_data = new FormData();
    var ext = name.split('.').pop().toLowerCase();
    if(jQuery.inArray(ext, ['pdf','PDF','doc','DOC','docx','DOCX','xls','XLS','xlsx','XLSX','jpg','JPG','jpeg','JPEG','png','PNG','zip','ZIP','rar','RAR']) == -1){
        $.toast({
            text: "Format file harus '.pdf','.PDF','.doc','.DOC','.docx','.DOCX','.xls','.XLS','.xlsx','.XLSX','.jpg','.JPG','.jpeg','.JPEG','.png','.PNG','.zip','.ZIP','.rar','.RAR'",
            heading: 'Status',
            icon: 'warning',
            showHideTransition: 'fade',
            allowToastClose: true,
            hideAfter: 3000,
            position: 'mid-center',
            textAlign: 'left'
        });
        return;
    }
    var oFReader = new FileReader();
    oFReader.readAsDataURL(uploadfile);
    var f = uploadfile;
    var fsize = f.size||f.fileSize;
    if(fsize > 2000000){
        $.toast({
            text: "Ukuran file terlalu bersar",
            heading: 'Status',
            icon: 'warning',
            showHideTransition: 'fade',
            allowToastClose: true,
            hideAfter: 3000,
            position: 'mid-center',
            textAlign: 'left'
        });
    }else{
        form_data.append("file", uploadfile);
        form_data.append("_token", $("#quickForm input[name=_token]").val());
        form_data.append("menname", "upload_detail");
        $.ajax({
            url:"/uploadfileikuunitkerja",
            method:"POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(){
                $("label[for=upload_upload_detail]").html("Uploading <i class=\"fas fa-spinner fa-pulse\"></i>");
            },
            success:function(data){
                if(data.status >= 200 && data.status <= 299){
                    $("label[for=upload_upload_detail]").html("Finished upload file");
                    $("#upload_detail").val(data.filename);
                    $("#btn_upload_detail").attr("disabled", false);
                    $("#btn_upload_detail").addClass("btn-success text-white");
                    $("#btn_upload_detail").html("Download");
                }
            },
            error: function (err) {
                if (err.status >= 400) {
            $.toast({
                text: "Gagal upload",
                heading: 'Status',
                icon: 'warning',
                showHideTransition: 'fade',
                allowToastClose: true,
                hideAfter: 3000,
                position: 'mid-center',
                textAlign: 'left'
            });
                }
            }
        });
    }
}
});

</script>