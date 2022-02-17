<!-- Required vendors -->
<script src="{{ asset ("/assets/motaadmin/vendor/global/global.min.js") }}"></script>
	<!-- <script src="{{ asset ("/assets/motaadmin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js") }} "></script> -->
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
    <script src="{{ asset ("/assets/datatables/js/dataTables.bootstrap4.min.js") }}"></script>
    <script src="{{ asset ("/assets/datatables/js/dataTables.rowReorder.min.js") }}"></script>
    <script src="{{ asset ("/assets/datatables/js/dataTables.buttons.min.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/cakrudtemplate.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/cto_loadinganimation.min.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/dateformatvalidation.min.js") }}"></script>


<script>
    var editor;


$(function () {

    $.validator.setDefaults({
        submitHandler: function (form, event) {
            event.preventDefault();
            cto_loading_show();
            var quickForm = $("#quickForm");
            var ctct1_bank_va = [];
            var table = $("#ctct1_bank_va").DataTable().rows().data();
            for(var i = 0; i < table.length; i++){
                ctct1_bank_va.push({"no_seq": table[i][0], "kode_va": table[i][1], "coa": table[i][2], "coa_label": table[i][3], "id": table[i][table.columns().header().length-1]});
            }
            $("#ct1_bank_va").val(JSON.stringify(ctct1_bank_va));

            var ctct2_approval_setting = [];
            var table = $("#ctct2_approval_setting").DataTable().rows().data();
            for(var i = 0; i < table.length; i++){
                ctct2_approval_setting.push({"no_seq": table[i][0], "role": table[i][1], "role_label": table[i][2], "jenismenu": table[i][3], "id": table[i][table.columns().header().length-1]});
            }
            var table = $("#ctct2_approval_settingpjk").DataTable().rows().data();
            for(var i = 0; i < table.length; i++){
                ctct2_approval_setting.push({"no_seq": table[i][0], "role": table[i][1], "role_label": table[i][2], "jenismenu": table[i][3], "id": table[i][table.columns().header().length-1]});
            }
            var table = $("#ctct2_approval_setting_pengajuan").DataTable().rows().data();
            for(var i = 0; i < table.length; i++){
                ctct2_approval_setting.push({"no_seq": table[i][0], "role": table[i][1], "role_label": table[i][2], "jenismenu": table[i][3], "id": table[i][table.columns().header().length-1]});
            }
            $("#ct2_approval_setting").val(JSON.stringify(ctct2_approval_setting));
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
                            if(i == "kode_va" || i == "coa" || i == "coa_label"){
                                errors["ct1_bank_va"] = error[0];
                            }else if(i == "role" || i == "role_label" || i == "jenismenu"){
                                errors["ct2_approval_setting"] = error[0];
                                errors["ct2_approval_settingpjk"] = error[0];
                                errors["ct2_approval_setting_pengajuan"] = error[0];
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

$("#bulan_tutup_tahun").on("change", function() {
    $("#bulan_tutup_tahun_label").val($("#bulan_tutup_tahun option:selected").text());
});

$("#coa").on("change", function() {
    $("#coa_label").val($("#coa option:selected").text());
});
$("#role").on("change", function() {
    $("#role_label").val($("#role option:selected").text());
});
var fields = $("#quickForm").serialize();

$.ajax({
    url: "/getoptions{{$page_data["page_data_urlname"]}}",
    type: "post",
    data: {
        fieldname: "bulan_tutup_tahun",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                var newState = new Option(data[i].label, data[i].name, true, false);
                $("#bulan_tutup_tahun").append(newState).trigger("change");
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

$("#role").select2({
    ajax: {
        url: "/getlinks{{$page_data["page_data_urlname"]}}",
        type: "post",
        data: {
            field: "role",
            _token: $("#quickForm input[name=_token]").val()
        },
        success: function(data){
            var newState = new Option("", "", true, false);
            $("#role").append(newState).trigger("change");
            for(var i = 0; i < data.length; i++){
                if(data[i].name){
                    newState = new Option(data[i].label, data[i].name, true, false);
                    $("#role").append(newState).trigger("change");
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
    }
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
        nama_instansi :{
            required: true,
            minlength:2,
            maxlength:255
        },
        bulan_tutup_tahun :{
            required: true
        },
    },
    messages: {
        nama_instansi :{
            required: "Nama Instansi harus diisi!!",
            minlength: "Nama Instansi minimal 2 karakter!!",
            maxlength: "Nama Instansi maksimal 255 karakter!!"
        },
        bulan_tutup_tahun :{
            required: "Bulan Tutup Tahun harus diisi!!"
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

$("#quickModalForm_ct1_bank_va").validate({
    rules: {
        kode_va :{
            required: true,
            minlength:1,
            maxlength:255
        },
        coa :{
            required: true
        },
    },
    messages: {
        kode_va :{
            required: "Nomor VA harus diisi!!",
            minlength: "Nomor VA minimal 1 karakter!!",
            maxlength: "Nomor VA maksimal 255 karakter!!"
        },
        coa :{
            required: "No. Kode Rekening harus diisi!!"
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

    $("#quickModalForm_ct2_approval_setting").validate({
    rules: {
        role :{
            required: true
        },
        jenismenu :{
            required: true
        },
    },
    messages: {
        role :{
            required: "Jabatan harus diisi!!"
        },
        jenismenu :{
            required: "Menu harus diisi!!"
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
    var table_ct1_bank_va = $("#ctct1_bank_va").DataTable({
        @if($page_data["page_method_name"] != "View")
        rowReorder: true,
        @endif
        aoColumnDefs: [{
            aTargets: [],
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
                    $("#staticBackdrop_ct1_bank_va").modal({"show": true});
                    addChildTable_ct1_bank_va("staticBackdrop_ct1_bank_va");
                }
            }
        ]
        @endif
    });

    table_ct1_bank_va.column(table_ct1_bank_va.columns().header().length-1).visible(false);
    table_ct1_bank_va.column(2).visible(false);

    $("#ctct1_bank_va tbody").on( "click", ".row-show", function () {
        $("#staticBackdrop_ct1_bank_va").modal({"show": true});
        showChildTable_ct1_bank_va("staticBackdrop_ct1_bank_va", table_ct1_bank_va.row( $(this).parents("tr") ));
    } );

    $("#staticBackdropClose_ct1_bank_va").click(function(){
        $("#staticBackdrop_ct1_bank_va").modal("hide");
    });

    table_ct1_bank_va.on( "row-reorder", function ( e, diff, edit ) {
            var result = "Reorder started on row: "+edit.triggerRow.data()[1]+"<br>";
            for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                var rowData = table_ct1_bank_va.row( diff[i].node ).data();
                result += rowData[1]+" updated to be in position "+
                    diff[i].newData+" (was "+diff[i].oldData+")<br>";
            }
        $("#result").html( "Event result:<br>"+result );
    } );
    $("#ctct1_bank_va tbody").on("click", ".row-delete", function () {
        table_ct1_bank_va.row($(this).parents("tr")).remove().draw();
    });

    // =================================================================
    // =========================== SETTING =============================
    // =================================================================

    var table_ct2_approval_setting = $("#ctct2_approval_setting").DataTable({
        @if($page_data["page_method_name"] != "View")
        rowReorder: true,
        @endif
        aoColumnDefs: [{
            aTargets: [],
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
                    $("#staticBackdrop_ct2_approval_setting").modal({"show": true});
                    addChildTable_ct2_approval_setting("staticBackdrop_ct2_approval_setting");
                }
            }
        ]
        @endif
    });

    table_ct2_approval_setting.column(table_ct2_approval_setting.columns().header().length-1).visible(false);
    table_ct2_approval_setting.column(1).visible(false);
    table_ct2_approval_setting.column(3).visible(false);

    $("#ctct2_approval_setting tbody").on( "click", ".row-show", function () {
        $("#staticBackdrop_ct2_approval_setting").modal({"show": true});
        showChildTable_ct2_approval_setting("staticBackdrop_ct2_approval_setting", table_ct2_approval_setting.row( $(this).parents("tr") ));
    } );

    $("#staticBackdropClose_ct2_approval_setting").click(function(){
        $("#staticBackdrop_ct2_approval_setting").modal("hide");
    });

    table_ct2_approval_setting.on( "row-reorder", function ( e, diff, edit ) {
            var result = "Reorder started on row: "+edit.triggerRow.data()[1]+"<br>";
            for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                var rowData = table_ct2_approval_setting.row( diff[i].node ).data();
                result += rowData[1]+" updated to be in position "+
                    diff[i].newData+" (was "+diff[i].oldData+")<br>";
            }
        $("#result").html( "Event result:<br>"+result );
    } );
    $("#ctct2_approval_setting tbody").on("click", ".row-delete", function () {
        table_ct2_approval_setting.row($(this).parents("tr")).remove().draw();
    });

    // =================================================================
    // ========================== SETTING PJK ==========================
    // =================================================================
    
    var table_ct2_approval_settingpjk = $("#ctct2_approval_settingpjk").DataTable({
        @if($page_data["page_method_name"] != "View")
        rowReorder: true,
        @endif
        aoColumnDefs: [{
            aTargets: [],
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
                    $("#staticBackdrop_ct2_approval_setting").modal({"show": true});
                    addChildTable_ct2_approval_settingpjk("staticBackdrop_ct2_approval_setting");
                }
            }
        ]
        @endif
    });

    table_ct2_approval_settingpjk.column(table_ct2_approval_settingpjk.columns().header().length-1).visible(false);
    table_ct2_approval_settingpjk.column(1).visible(false);
    table_ct2_approval_settingpjk.column(3).visible(false);

    $("#ctct2_approval_settingpjk tbody").on( "click", ".row-show", function () {
        $("#staticBackdrop_ct2_approval_setting").modal({"show": true});
        showChildTable_ct2_approval_settingpjk("staticBackdrop_ct2_approval_setting", table_ct2_approval_settingpjk.row( $(this).parents("tr") ));
    } );

    $("#staticBackdropClose_ct2_approval_settingpjk").click(function(){
        $("#staticBackdrop_ct2_approval_setting").modal("hide");
    });

    table_ct2_approval_settingpjk.on( "row-reorder", function ( e, diff, edit ) {
            var result = "Reorder started on row: "+edit.triggerRow.data()[1]+"<br>";
            for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                var rowData = table_ct2_approval_settingpjk.row( diff[i].node ).data();
                result += rowData[1]+" updated to be in position "+
                    diff[i].newData+" (was "+diff[i].oldData+")<br>";
            }
        $("#result").html( "Event result:<br>"+result );
    } );
    $("#ctct2_approval_settingpjk tbody").on("click", ".row-delete", function () {
        table_ct2_approval_settingpjk.row($(this).parents("tr")).remove().draw();
    });

    // =================================================================
    // ====================== SETTING Pengajuan ========================
    // =================================================================
    
    var table_ct2_approval_setting_pengajuan = $("#ctct2_approval_setting_pengajuan").DataTable({
        @if($page_data["page_method_name"] != "View")
        rowReorder: true,
        @endif
        aoColumnDefs: [{
            aTargets: [],
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
                    $("#staticBackdrop_ct2_approval_setting").modal({"show": true});
                    addChildTable_ct2_approval_setting_pengajuan("staticBackdrop_ct2_approval_setting");
                }
            }
        ]
        @endif
    });

    table_ct2_approval_setting_pengajuan.column(table_ct2_approval_setting_pengajuan.columns().header().length-1).visible(false);
    table_ct2_approval_setting_pengajuan.column(1).visible(false);
    table_ct2_approval_setting_pengajuan.column(3).visible(false);

    $("#ctct2_approval_setting_pengajuan tbody").on( "click", ".row-show", function () {
        $("#staticBackdrop_ct2_approval_setting").modal({"show": true});
        showChildTable_ct2_approval_setting_pengajuan("staticBackdrop_ct2_approval_setting", table_ct2_approval_setting_pengajuan.row( $(this).parents("tr") ));
    } );

    $("#staticBackdropClose_ct2_approval_setting_pengajuan").click(function(){
        $("#staticBackdrop_ct2_approval_setting").modal("hide");
    });

    table_ct2_approval_setting_pengajuan.on( "row-reorder", function ( e, diff, edit ) {
            var result = "Reorder started on row: "+edit.triggerRow.data()[1]+"<br>";
            for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                var rowData = table_ct2_approval_setting_pengajuan.row( diff[i].node ).data();
                result += rowData[1]+" updated to be in position "+
                    diff[i].newData+" (was "+diff[i].oldData+")<br>";
            }
        $("#result").html( "Event result:<br>"+result );
    } );
    $("#ctct2_approval_setting_pengajuan tbody").on("click", ".row-delete", function () {
        table_ct2_approval_setting_pengajuan.row($(this).parents("tr")).remove().draw();
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
        },
        success: function(data){
            for(var i = 0; i < Object.keys(data.data.{{$page_data["page_data_urlname"]}}).length; i++){
                if(["ewfsdfsafdsafasdfasdferad"].includes(Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i])){
                    $("input[name="+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"]").prop("checked", data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]);
                }else{
                    try{
                        anObject[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]].set(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]);
                    }catch(err){
                        $("input[name="+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"]").val(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]);
                    }
                    $("textarea[name="+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"]").val(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]);
                        if(["logo_instansi"].includes(Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i])){
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

            $("#ctct1_bank_va").DataTable().clear().draw();
            if(data.data.ct1_bank_va.length > 0){
                for(var i = 0; i < data.data.ct1_bank_va.length; i++){
                    var dttb = $('#ctct1_bank_va').DataTable();
                    var child_table_data = [data.data.ct1_bank_va[i].no_seq, data.data.ct1_bank_va[i].kode_va, data.data.ct1_bank_va[i].coa, data.data.ct1_bank_va[i].coa_label, @if($page_data["page_method_name"] != "View") '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>' @else '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>' @endif, data.data.ct1_bank_va[i].id];
                    if(dttb.row.add(child_table_data).draw( false )){

                    }
                }
            }
            $("#ctct2_approval_setting").DataTable().clear().draw();
            if(data.data.ct2_approval_setting.length > 0){
                for(var i = 0; i < data.data.ct2_approval_setting.length; i++){
                    var dttb = $('#ctct2_approval_setting').DataTable();
                    var child_table_data = [data.data.ct2_approval_setting[i].no_seq, data.data.ct2_approval_setting[i].role, data.data.ct2_approval_setting[i].role_label, data.data.ct2_approval_setting[i].jenismenu, @if($page_data["page_method_name"] != "View") '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>' @else '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>' @endif, data.data.ct2_approval_setting[i].id];
                    if(dttb.row.add(child_table_data).draw( false )){

                    }
                }
            }

            $("#ctct2_approval_settingpjk").DataTable().clear().draw();
            if(data.data.ct2_approval_settingpjk.length > 0){
                for(var i = 0; i < data.data.ct2_approval_settingpjk.length; i++){
                    var dttb = $('#ctct2_approval_settingpjk').DataTable();
                    var child_table_data = [data.data.ct2_approval_settingpjk[i].no_seq, data.data.ct2_approval_settingpjk[i].role, data.data.ct2_approval_settingpjk[i].role_label, data.data.ct2_approval_settingpjk[i].jenismenu, @if($page_data["page_method_name"] != "View") '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>' @else '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>' @endif, data.data.ct2_approval_settingpjk[i].id];
                    if(dttb.row.add(child_table_data).draw( false )){

                    }
                }
            }

            $("#ctct2_approval_setting_pengajuan").DataTable().clear().draw();
            if(data.data.ct2_approval_setting_pengajuan.length > 0){
                for(var i = 0; i < data.data.ct2_approval_setting_pengajuan.length; i++){
                    var dttb = $('#ctct2_approval_setting_pengajuan').DataTable();
                    var child_table_data = [data.data.ct2_approval_setting_pengajuan[i].no_seq, data.data.ct2_approval_setting_pengajuan[i].role, data.data.ct2_approval_setting_pengajuan[i].role_label, data.data.ct2_approval_setting_pengajuan[i].jenismenu, @if($page_data["page_method_name"] != "View") '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>' @else '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>' @endif, data.data.ct2_approval_setting_pengajuan[i].id];
                    if(dttb.row.add(child_table_data).draw( false )){

                    }
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
function addChildTable_ct1_bank_va(childtablename){
    $("input[name='kode_va']").val("");
    $("select[name='coa']").empty();
    $("input[name='coa_label']").val("");

    @if($page_data["page_method_name"] != "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropAdd_ct1_bank_va" class="btn btn-primary">Add Row</button>');
    @endif

    $("#staticBackdropAdd_ct1_bank_va").click(function(e){
        e.preventDefault;
        var dttb = $('#ctct1_bank_va').DataTable();

        var no_seq = dttb.rows().count();
        var kode_va = $("input[name='kode_va']").val();
        var coa = $("select[name='coa'] option").filter(':selected').val();
        if(!coa){
            coa = null;
        }
        var coa_label = $("input[name='coa_label']").val();

        var child_table_data = [no_seq+1, kode_va, coa, coa_label, '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>', null];

        if(validatequickModalForm_ct1_bank_va()){
            if(dttb.row.add(child_table_data).draw( false )){
                $('#staticBackdrop_ct1_bank_va').modal('hide');
            }
        }
    });
}

function showChildTable_ct1_bank_va(childtablename, data){
    $("input[name='kode_va']").val(data.data()[1]);
    $("select[name='coa']").empty();
    var newState = new Option(data.data()[3], data.data()[2], true, false);
    $("#coa").append(newState).trigger('change');
    $("input[name='coa_label']").val(data.data()[3]);

    @if($page_data["page_method_name"] != "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropUpdate_ct1_bank_va" class="btn btn-primary">Update</button>');
    @endif

    $("#staticBackdropUpdate_ct1_bank_va").click(function(e){
        var temp = data.data();
        temp[1] = $("input[name='kode_va']").val();
        temp[2] = $("select[name='coa'] option").filter(':selected').val();
        if(!coa){
            coa = null;
        }
        temp[3] = $("input[name='coa_label']").val();
        if( validatequickModalForm_ct1_bank_va() ){
            data.data(temp).invalidate();
            $("#staticBackdrop_ct1_bank_va").modal("hide");
        }
    });
}

function addChildTable_ct2_approval_setting(childtablename){
    $("select[name='role']").val(null).trigger('change')
    $("input[name='role_label']").val("");
    $("input[name='jenismenu']").val("RKA");

    @if($page_data["page_method_name"] != "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropAdd_ct2_approval_setting" class="btn btn-primary">Add Row</button>');
    @endif

    $("#staticBackdropAdd_ct2_approval_setting").click(function(e){
        e.preventDefault;
        var dttb = $('#ctct2_approval_setting').DataTable();

        var no_seq = dttb.rows().count();
        var role = $("select[name='role'] option").filter(':selected').val();
        if(!role){
            role = null;
        }
        var role_label = $("input[name='role_label']").val();
        var jenismenu = $("input[name='jenismenu']").val();

        var child_table_data = [no_seq+1, role, role_label, jenismenu, '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>', null];

        if(validatequickModalForm_ct2_approval_setting()){
            if(dttb.row.add(child_table_data).draw( false )){
                $('#staticBackdrop_ct2_approval_setting').modal('hide');
            }
        }
    });
}

function showChildTable_ct2_approval_setting(childtablename, data){
    $("select[name='role']").val(data.data()[1]);
    $("select[name='role']").select2().trigger('change');
    $("input[name='role_label']").val(data.data()[2]);
    $("input[name='jenismenu']").val(data.data()[3]);

    @if($page_data["page_method_name"] != "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropUpdate_ct2_approval_setting" class="btn btn-primary">Update</button>');
    @endif

    $("#staticBackdropUpdate_ct2_approval_setting").click(function(e){
        var temp = data.data();
        temp[1] = $("select[name='role'] option").filter(':selected').val();
        if(!role){
            role = null;
        }
        temp[2] = $("input[name='role_label']").val();
        temp[3] = $("input[name='jenismenu']").val();
        if( validatequickModalForm_ct2_approval_setting() ){
            data.data(temp).invalidate();
            $("#staticBackdrop_ct2_approval_setting").modal("hide");
        }
    });
}

function addChildTable_ct2_approval_settingpjk(childtablename){
    $("select[name='role']").val(null).trigger('change')
    $("input[name='role_label']").val("");
    $("input[name='jenismenu']").val("PJK");

    @if($page_data["page_method_name"] != "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropAdd_ct2_approval_setting" class="btn btn-primary">Add Row</button>');
    @endif

    $("#staticBackdropAdd_ct2_approval_setting").click(function(e){
        e.preventDefault;
        var dttb = $('#ctct2_approval_settingpjk').DataTable();

        var no_seq = dttb.rows().count();
        var role = $("select[name='role'] option").filter(':selected').val();
        if(!role){
            role = null;
        }
        var role_label = $("input[name='role_label']").val();
        var jenismenu = $("input[name='jenismenu']").val();

        var child_table_data = [no_seq+1, role, role_label, jenismenu, '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>', null];

        if(validatequickModalForm_ct2_approval_setting()){
            if(dttb.row.add(child_table_data).draw( false )){
                $('#staticBackdrop_ct2_approval_setting').modal('hide');
            }
        }
    });
}

function showChildTable_ct2_approval_settingpjk(childtablename, data){
    $("select[name='role']").val(data.data()[1]);
    $("select[name='role']").select2().trigger('change');
    $("input[name='role_label']").val(data.data()[2]);
    $("input[name='jenismenu']").val(data.data()[3]);

    @if($page_data["page_method_name"] != "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropUpdate_ct2_approval_setting" class="btn btn-primary">Update</button>');
    @endif

    $("#staticBackdropUpdate_ct2_approval_setting").click(function(e){
        var temp = data.data();
        temp[1] = $("select[name='role'] option").filter(':selected').val();
        if(!role){
            role = null;
        }
        temp[2] = $("input[name='role_label']").val();
        temp[3] = $("input[name='jenismenu']").val();
        if( validatequickModalForm_ct2_approval_setting() ){
            data.data(temp).invalidate();
            $("#staticBackdrop_ct2_approval_setting").modal("hide");
        }
    });
}

function addChildTable_ct2_approval_setting_pengajuan(childtablename){
    $("select[name='role']").val(null).trigger('change')
    $("input[name='role_label']").val("");
    $("input[name='jenismenu']").val("pengajuan");

    @if($page_data["page_method_name"] != "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropAdd_ct2_approval_setting" class="btn btn-primary">Add Row</button>');
    @endif

    $("#staticBackdropAdd_ct2_approval_setting").click(function(e){
        e.preventDefault;
        var dttb = $('#ctct2_approval_setting_pengajuan').DataTable();

        var no_seq = dttb.rows().count();
        var role = $("select[name='role'] option").filter(':selected').val();
        if(!role){
            role = null;
        }
        var role_label = $("input[name='role_label']").val();
        var jenismenu = $("input[name='jenismenu']").val();

        var child_table_data = [no_seq+1, role, role_label, jenismenu, '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>', null];

        if(validatequickModalForm_ct2_approval_setting()){
            if(dttb.row.add(child_table_data).draw( false )){
                $('#staticBackdrop_ct2_approval_setting').modal('hide');
            }
        }
    });
}

function showChildTable_ct2_approval_setting_pengajuan(childtablename, data){
    $("select[name='role']").val(data.data()[1]);
    $("select[name='role']").select2().trigger('change');
    $("input[name='role_label']").val(data.data()[2]);
    $("input[name='jenismenu']").val(data.data()[3]);

    @if($page_data["page_method_name"] != "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropUpdate_ct2_approval_setting" class="btn btn-primary">Update</button>');
    @endif

    $("#staticBackdropUpdate_ct2_approval_setting").click(function(e){
        var temp = data.data();
        temp[1] = $("select[name='role'] option").filter(':selected').val();
        if(!role){
            role = null;
        }
        temp[2] = $("input[name='role_label']").val();
        temp[3] = $("input[name='jenismenu']").val();
        if( validatequickModalForm_ct2_approval_setting() ){
            data.data(temp).invalidate();
            $("#staticBackdrop_ct2_approval_setting").modal("hide");
        }
    });
}

function validatequickModalForm_ct1_bank_va(){
    var validation = $("#quickModalForm_ct1_bank_va").validate({
    rules: {
        kode_va :{
            required: true,
            minlength:1,
            maxlength:255
        },
        coa :{
            required: true
        },
    },
    messages: {
        kode_va :{
            required: "Nomor VA harus diisi!!",
            minlength: "Nomor VA minimal 1 karakter!!",
            maxlength: "Nomor VA maksimal 255 karakter!!"
        },
        coa :{
            required: "No. Kode Rekening harus diisi!!"
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

function validatequickModalForm_ct2_approval_setting(){
    var validation = $("#quickModalForm_ct2_approval_setting").validate({
    rules: {
        role :{
            required: true
        },
        jenismenu :{
            required: true
        },
    },
    messages: {
        role :{
            required: "Jabatan harus diisi!!"
        },
        jenismenu :{
            required: "Menu harus diisi!!"
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

$("#upload_logo_instansi").on('change', function(){
        $("#btn_logo_instansi").attr("disabled", true);
        $("#btn_logo_instansi").removeClass("btn-primary text-white");
        
        var uploadfile = document.getElementById("upload_logo_instansi").files[0];
        var name = uploadfile.name;
        var form_data = new FormData();
        var ext = name.split('.').pop().toLowerCase();
        if(jQuery.inArray(ext, ['png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG']) == -1){
            $.toast({
                text: "Format file harus ''",
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
            form_data.append("menname", "logo_instansi");
            $.ajax({
                url:"/uploadfileglobalsetting",
                method:"POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend:function(){
                    $("label[for=upload_logo_instansi]").html("Uploading <i class=\"fas fa-spinner fa-pulse\"></i>");
                },
                success:function(data){
                    if(data.status >= 200 && data.status <= 299){
                        $("label[for=upload_logo_instansi]").html("Finished upload file");
                        $("#logo_instansi").val(data.filename);
                        $("#btn_logo_instansi").attr("disabled", false);
                        $("#btn_logo_instansi").addClass("btn-success text-white");
                        $("#btn_logo_instansi").html("Download");
                        $("#preview_logo_instansi").attr('src','/logo_instansi/' + data.filename);
                        console.log('/logo_instansi/' + data.filename);
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
});

$("#upload_logo_sia").on('change', function(){
    
        $("#btn_logo_sia").attr("disabled", true);
        $("#btn_logo_sia").removeClass("btn-primary text-white");
        
        var uploadfile = document.getElementById("upload_logo_sia").files[0];
        var name = uploadfile.name;
        var form_data = new FormData();
        var ext = name.split('.').pop().toLowerCase();
        if(jQuery.inArray(ext, ['png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG']) == -1){
            $.toast({
                text: "Format file harus ''",
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
            form_data.append("menname", "logo_sia");
            $.ajax({
                url:"/uploadfileglobalsetting",
                method:"POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend:function(){
                    $("label[for=upload_logo_sia]").html("Uploading <i class=\"fas fa-spinner fa-pulse\"></i>");
                },
                success:function(data){
                    if(data.status >= 200 && data.status <= 299){
                        $("label[for=upload_logo_sia]").html("Finished upload file");
                        $("#logo_sia").val(data.filename);
                        $("#btn_logo_sia").attr("disabled", false);
                        $("#btn_logo_sia").addClass("btn-success text-white");
                        $("#btn_logo_sia").html("Download");
                        $("#preview_logo_sia").attr('src','/logo_sia/' + data.filename);
                        console.log('/logo_sia/' + data.filename);
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
});

$("#upload_main_background").on('change', function(){
    
    $("#btn_main_backgrounda").attr("disabled", true);
    $("#btn_main_background").removeClass("btn-primary text-white");
    
    var uploadfile = document.getElementById("upload_main_background").files[0];
    var name = uploadfile.name;
    var form_data = new FormData();
    var ext = name.split('.').pop().toLowerCase();
    if(jQuery.inArray(ext, ['png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG']) == -1){
        $.toast({
            text: "Format file harus ''",
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
    if(fsize > 25000000){
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
        form_data.append("menname", "main_background");
        $.ajax({
            url:"/uploadfileglobalsetting",
            method:"POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(){
                $("label[for=upload_main_background]").html("Uploading <i class=\"fas fa-spinner fa-pulse\"></i>");
            },
            success:function(data){
                if(data.status >= 200 && data.status <= 299){
                    $("label[for=upload_main_background]").html("Finished upload file");
                    $("#main_background").val(data.filename);
                    $("#btn_main_background").attr("disabled", false);
                    $("#btn_main_background").addClass("btn-success text-white");
                    $("#btn_main_background").html("Download");
                    $("#preview_main_background").attr('src','/main_background/' + data.filename);
                    console.log('/main_background/' + data.filename);
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
});

</script>