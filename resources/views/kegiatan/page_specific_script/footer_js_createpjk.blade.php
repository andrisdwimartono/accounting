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
    const anElement = AutoNumeric.multiple('.cakautonumeric-float', {
        decimalCharacter : ',',
        digitGroupSeparator : '.',
        minimumValue : 0,
        decimalPlaces : 2,
        unformatOnSubmit : true
    });

    anObject = {};
    for(var i = 0; i < anElement.length; i++){
        anObject[anElement[i].domElement.name] = anElement[i];
    }

    anObject["nominalbiaya"].settings.minimumValue = 0;


$(function () {

    $.validator.setDefaults({
        submitHandler: function (form, event) {
            event.preventDefault();
            cto_loading_show();
            var quickForm = $("#quickForm");
            var ctct1_detailbiayakegiatan = [];
            var table = $("#ctct1_detailbiayakegiatan").DataTable().rows().data();
            for(var i = 0; i < table.length; i++){
                ctct1_detailbiayakegiatan.push({"no_seq": table[i][0], "coa": table[i][1], "coa_label": table[i][2], "deskripsibiaya": table[i][3], "nominalbiaya": table[i][4], "desc_detail": table[i][5], "id": table[i][table.columns().header().length-1]});
            }
            $("#ct1_detailbiayakegiatan").val(JSON.stringify(ctct1_detailbiayakegiatan));
            var id_{{$page_data["page_data_urlname"]}} = 0;
            var values = $("#quickForm").serialize();

            var values = $('#quickForm').serialize();
            var ajaxRequest;
            ajaxRequest = $.ajax({
                @if($page_data["page_method_name"] == "Update")
                url: "/updatepjk/{{$page_data["id"]}}",
                @else
                url: "/storepjk",
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
                            if(i == "coa" || i == "coa_label" || i == "deskripsibiaya" || i == "nominalbiaya" || i == "desc_detail"){
                                errors["ct1_detailbiayakegiatan"] = error[0];
                            }else{
                                errors[i] = error[0];
                            }
                            validator.showErrors(errors);
                        });
                    }else{
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
});

$("select").select2({
    placeholder: "Pilih satu",
    allowClear: true,
    theme: "bootstrap4" @if($page_data["page_method_name"] == "View"),
    disabled: true @endif
});

$("#status_approval").select2({
    placeholder: "Pilih satu",
    allowClear: true,
    theme: "bootstrap4" @if($page_data["page_method_name"] == "View"),
    disabled: false @endif
});

$.fn.modal.Constructor.prototype._enforceFocus = function() {

};

$("#unit_pelaksana").on("change", function() {
    $("#unit_pelaksana_label").val($("#unit_pelaksana option:selected").text());
    $('#iku').val('').trigger('change');
});

$("#tahun").on("change", function() {
    $("#tahun_label").val($("#tahun option:selected").text());
    $('#iku').val('').trigger('change');
});

$("#iku").on("change", function() {
    $("#iku_label").val($("#iku option:selected").text());
});

$("#coa").on("change", function() {
    $("#coa_label").val($("#coa option:selected").text());
});

$("#role").on("change", function() {
    $("#role_label").val($("#role option:selected").text());
});

$("#status_approval").on("change", function() {
    $("#status_approval_label").val($("#status_approval option:selected").text());
});
var fields = $("#quickForm").serialize();

$.ajax({
    url: "/getoptions{{$page_data["page_data_urlname"]}}",
    type: "post",
    data: {
        fieldname: "tahun",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                var newState = new Option(data[i].label, data[i].name, true, false);
                $("#tahun").append(newState).trigger("change");
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
        fieldname: "status_approval",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        var newState = new Option("", "", true, false);
        $("#status_approval").append(newState).trigger("change");
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                newState = new Option(data[i].label, data[i].name, true, false);
                $("#status_approval").append(newState).trigger("change");
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
        fieldname: "role",
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
});

$("#iku").select2({
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
                field: "iku",
                unit_pelaksana: $("#unit_pelaksana").val(),
                tahun: $("#tahun").val(),
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

$("#coa").select2({
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

$("#quickForm").validate({
    rules: {
        unit_pelaksana :{
            required: true
        },
        tahun :{
            required: true
        },
        iku :{
            required: true
        },
        kegiatan_name :{
            required: true
        },
    },
    messages: {
        unit_pelaksana :{
            required: "Unit Pelaksana harus diisi!!"
        },
        tahun :{
            required: "Tahun harus diisi!!"
        },
        iku :{
            required: "IKU harus diisi!!"
        },
        kegiatan_name :{
            required: "Nama harus diisi!!"
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

$("#quickModalForm_ct1_detailbiayakegiatan").validate({
    rules: {
        coa :{
            required: true
        },
        nominalbiaya :{
            required: true
        },
    },
    messages: {
        coa :{
            required: "Kode Rek. Biaya harus diisi!!"
        },
        nominalbiaya :{
            required: "Nominal Pengajuan harus diisi!!"
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
    var table_ct1_detailbiayakegiatan = $("#ctct1_detailbiayakegiatan").DataTable({
        @if($page_data["page_method_name"] != "View")
        rowReorder: true,
        @endif
        aoColumnDefs: [{
            aTargets: [4],
            mRender: function (data, type, full){
                var formattedvalue = parseFloat(data).toFixed(2);
                formattedvalue = formattedvalue.toString().replace(".", ",");
                formattedvalue = formattedvalue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                return formattedvalue;
            }
        }],
        //add button
        dom: "Bfrtip" @if($page_data["page_method_name"] != "View") ,
        buttons: [
            {
                text: "New",
                action: function ( e, dt, node, config ) {
                    $("#staticBackdrop_ct1_detailbiayakegiatan").modal({"show": true});
                    addChildTable_ct1_detailbiayakegiatan("staticBackdrop_ct1_detailbiayakegiatan");
                }
            }
        ]
        @endif
    });

    table_ct1_detailbiayakegiatan.column(table_ct1_detailbiayakegiatan.columns().header().length-1).visible(false);
    table_ct1_detailbiayakegiatan.column(1).visible(false);

    $("#ctct1_detailbiayakegiatan tbody").on( "click", ".row-show", function () {
        $("#staticBackdrop_ct1_detailbiayakegiatan").modal({"show": true});
        showChildTable_ct1_detailbiayakegiatan("staticBackdrop_ct1_detailbiayakegiatan", table_ct1_detailbiayakegiatan.row( $(this).parents("tr") ));
    } );

    $("#staticBackdropClose_ct1_detailbiayakegiatan").click(function(){
        $("#staticBackdrop_ct1_detailbiayakegiatan").modal("hide");
    });

    table_ct1_detailbiayakegiatan.on( "row-reorder", function ( e, diff, edit ) {
            var result = "Reorder started on row: "+edit.triggerRow.data()[1]+"<br>";
            for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                var rowData = table_ct1_detailbiayakegiatan.row( diff[i].node ).data();
                result += rowData[1]+" updated to be in position "+
                    diff[i].newData+" (was "+diff[i].oldData+")<br>";
            }
        $("#result").html( "Event result:<br>"+result );
    } );
    $("#ctct1_detailbiayakegiatan tbody").on("click", ".row-delete", function () {
        table_ct1_detailbiayakegiatan.row($(this).parents("tr")).remove().draw();
    });

    var table_ct2_approval = $("#ctct2_approval").DataTable({
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
                    $("#staticBackdrop_ct2_approval").modal({"show": true});
                    addChildTable_ct2_approval("staticBackdrop_ct2_approval");
                }
            }
        ]
        @endif
    });

    table_ct2_approval.column(table_ct2_approval.columns().header().length-1).visible(false);
    table_ct2_approval.column(1).visible(false);
    table_ct2_approval.column(3).visible(false);
    table_ct2_approval.column(4).visible(false);
    table_ct2_approval.column(7).visible(false);

    $("#ctct2_approval tbody").on( "click", ".row-show", function () {
        $("#staticBackdrop_ct2_approval").modal({"show": true});
        showChildTable_ct2_approval("staticBackdrop_ct2_approval", table_ct2_approval.row( $(this).parents("tr") ));
    } );

    $("#staticBackdropClose_ct2_approval").click(function(){
        $("#staticBackdrop_ct2_approval").modal("hide");
    });

    table_ct2_approval.on( "row-reorder", function ( e, diff, edit ) {
            var result = "Reorder started on row: "+edit.triggerRow.data()[1]+"<br>";
            for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                var rowData = table_ct2_approval.row( diff[i].node ).data();
                result += rowData[1]+" updated to be in position "+
                    diff[i].newData+" (was "+diff[i].oldData+")<br>";
            }
        $("#result").html( "Event result:<br>"+result );
    } );
    $("#ctct2_approval tbody").on("click", ".row-delete", function () {
        table_ct2_approval.row($(this).parents("tr")).remove().draw();
    });

    @if($page_data["page_method_name"] == "Update" || $page_data["page_method_name"] == "View")
    getdata();
    @endif
} );

@if($page_data["page_method_name"] == "Update" || $page_data["page_method_name"] == "View")
function getdata(){
    cto_loading_show();
    $.ajax({
        url: "/getdatapjk",
        type: "post",
        data: {
            id: {{$page_data["id"]}},
            _token: $("#quickForm input[name=_token]").val()
        },
        success: function(data){
            for(var i = 0; i < Object.keys(data.data.{{$page_data["page_data_urlname"]}}).length; i++){
                if(Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i] == "unit_pelaksana" || Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i] == "iku"){
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
                        if(["proposal", "laporan_pjk"].includes(Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i])){
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

            $("#ctct1_detailbiayakegiatan").DataTable().clear().draw();
            if(data.data.ct1_detailbiayakegiatan.length > 0){
                for(var i = 0; i < data.data.ct1_detailbiayakegiatan.length; i++){
                    var dttb = $('#ctct1_detailbiayakegiatan').DataTable();
                    var child_table_data = [data.data.ct1_detailbiayakegiatan[i].no_seq, data.data.ct1_detailbiayakegiatan[i].coa, data.data.ct1_detailbiayakegiatan[i].coa_label, data.data.ct1_detailbiayakegiatan[i].deskripsibiaya, data.data.ct1_detailbiayakegiatan[i].nominalbiaya, data.data.ct1_detailbiayakegiatan[i].desc_detail, @if($page_data["page_method_name"] != "View") '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>' @else '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>' @endif, data.data.ct1_detailbiayakegiatan[i].id];
                    if(dttb.row.add(child_table_data).draw( false )){

                    }
                }
            }
            $("#ctct2_approval").DataTable().clear().draw();
            if(data.data.ct2_approval  != null){
                for(var i = 0; i < data.data.ct2_approval.length; i++){
                    var dttb = $('#ctct2_approval').DataTable();
                    var child_table_data = [data.data.ct2_approval[i].no_seq, data.data.ct2_approval[i].role, data.data.ct2_approval[i].role_label, data.data.ct2_approval[i].jenismenu, data.data.ct2_approval[i].user, data.data.ct2_approval[i].user_label, data.data.ct2_approval[i].komentar, data.data.ct2_approval[i].status_approval, data.data.ct2_approval[i].status_approval_label, data.data.ct2_approval[i].role=='<?= Auth::user()->role ?>'?'<div class="row-show"><i class="fa fa-list" style="color:blue;cursor: pointer;"></i></div>':'', data.data.ct2_approval[i].id];
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
function addChildTable_ct1_detailbiayakegiatan(childtablename){
    $("select[name='coa']").empty();
    $("input[name='coa_label']").val("");
    $("textarea[name='deskripsibiaya']").val("");
    $("input[name='nominalbiaya']").val("");
    $("textarea[name='desc_detail']").val("");

    @if($page_data["page_method_name"] != "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropAdd_ct1_detailbiayakegiatan" class="btn btn-primary">Add Row</button>');
    @endif

    $("#staticBackdropAdd_ct1_detailbiayakegiatan").click(function(e){
        e.preventDefault;
        var dttb = $('#ctct1_detailbiayakegiatan').DataTable();

        var no_seq = dttb.rows().count();
        var coa = $("select[name='coa'] option").filter(':selected').val();
        if(!coa){
            coa = null;
        }
        var coa_label = $("input[name='coa_label']").val();
        var deskripsibiaya = $("textarea[name='deskripsibiaya']").val();
        var nominalbiaya = anObject["nominalbiaya"].rawValue;
        var desc_detail = $("textarea[name='desc_detail']").val();

        var child_table_data = [no_seq+1, coa, coa_label, deskripsibiaya, nominalbiaya, desc_detail, '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>', null];

        if(validatequickModalForm_ct1_detailbiayakegiatan()){
            if(dttb.row.add(child_table_data).draw( false )){
                $('#staticBackdrop_ct1_detailbiayakegiatan').modal('hide');
            }
        }
    });
}

function showChildTable_ct1_detailbiayakegiatan(childtablename, data){
    $("select[name='coa']").empty();
    var newState = new Option(data.data()[2], data.data()[1], true, false);
    $("#coa").append(newState).trigger('change');
    $("input[name='coa_label']").val(data.data()[2]);
    $("textarea[name='deskripsibiaya']").val(data.data()[3]);
    anObject["nominalbiaya"].set(data.data()[4]);
    $("textarea[name='desc_detail']").val(data.data()[5]);

    @if($page_data["page_method_name"] != "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropUpdate_ct1_detailbiayakegiatan" class="btn btn-primary">Update</button>');
    @endif

    $("#staticBackdropUpdate_ct1_detailbiayakegiatan").click(function(e){
        var temp = data.data();
        temp[1] = $("select[name='coa'] option").filter(':selected').val();
        if(!coa){
            coa = null;
        }
        temp[2] = $("input[name='coa_label']").val();
        temp[3] = $("textarea[name='deskripsibiaya']").val();
        temp[4] = anObject["nominalbiaya"].rawValue;
        temp[5] = $("textarea[name='desc_detail']").val();
        if( validatequickModalForm_ct1_detailbiayakegiatan() ){
            data.data(temp).invalidate();
            $("#staticBackdrop_ct1_detailbiayakegiatan").modal("hide");
        }
    });
}

function addChildTable_ct2_approval(childtablename){
    $("select[name='role']").val(null).trigger('change')
    $("input[name='role_label']").val("");
    $("input[name='jenismenu']").val("");
    $("select[name='user']").empty();
    $("input[name='user_label']").val("");
    $("textarea[name='komentar']").val("");
    $("select[name='status_approval']").val(null).trigger('change')
    $("input[name='status_approval_label']").val("");

    @if($page_data["page_method_name"] != "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropAdd_ct2_approval" class="btn btn-primary">Add Row</button>');
    @endif

    $("#staticBackdropAdd_ct2_approval").click(function(e){
        e.preventDefault;
        var dttb = $('#ctct2_approval').DataTable();

        var no_seq = dttb.rows().count();
        var role = $("select[name='role'] option").filter(':selected').val();
        if(!role){
            role = null;
        }
        var role_label = $("input[name='role_label']").val();
        var jenismenu = $("input[name='jenismenu']").val();
        var user = $("select[name='user'] option").filter(':selected').val();
        if(!user){
            user = null;
        }
        var user_label = $("input[name='user_label']").val();
        var komentar = $("textarea[name='komentar']").val();
        var status_approval = $("select[name='status_approval'] option").filter(':selected').val();
        if(!status_approval){
            status_approval = null;
        }
        var status_approval_label = $("input[name='status_approval_label']").val();

        var child_table_data = [no_seq+1, role, role_label, jenismenu, user, user_label, komentar, status_approval, status_approval_label, '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>', null];

        if(validatequickModalForm_ct2_approval()){
            if(dttb.row.add(child_table_data).draw( false )){
                $('#staticBackdrop_ct2_approval').modal('hide');
            }
        }
    });
}

function showChildTable_ct2_approval(childtablename, data){
    $("select[name='role']").val(data.data()[1]);
    $("select[name='role']").select2().trigger('change');
    $("input[name='role_label']").val(data.data()[2]);
    $("input[name='jenismenu']").val(data.data()[3]);
    $("select[name='user']").empty();
    var newState = new Option('<?= Auth::user()->name ?>', <?= Auth::user()->id ?>, true, false);
    $("#user").append(newState).trigger('change');
    $("input[name='user_label']").val('<?= Auth::user()->name ?>');
    $("textarea[name='komentar']").val(data.data()[6]);
    $("select[name='status_approval']").val(data.data()[7]);
    $("select[name='status_approval']").select2().trigger('change');
    $("input[name='status_approval_label']").val(data.data()[8]);

    @if($page_data["page_method_name"] == "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropUpdate_ct2_approval" class="btn btn-primary">Update</button>');
    @endif

    $("#staticBackdropUpdate_ct2_approval").click(function(e){
        var temp = data.data();
        temp[1] = $("select[name='role'] option").filter(':selected').val();
        if(!role){
            role = null;
        }
        temp[2] = $("input[name='role_label']").val();
        temp[3] = $("input[name='jenismenu']").val();
        temp[4] = $("select[name='user'] option").filter(':selected').val();
        if(!user){
            user = null;
        }
        temp[5] = $("input[name='user_label']").val();
        temp[6] = $("textarea[name='komentar']").val();
        temp[7] = $("select[name='status_approval'] option").filter(':selected').val();
        if(!status_approval){
            status_approval = null;
        }
        temp[8] = $("input[name='status_approval_label']").val();
        if( validatequickModalForm_ct2_approval() ){
            processapprove(temp);
            data.data(temp).invalidate();
            $("#staticBackdrop_ct2_approval").modal("hide");
        }
    });
}

function validatequickModalForm_ct1_detailbiayakegiatan(){
    var validation = $("#quickModalForm_ct1_detailbiayakegiatan").validate({
    rules: {
        coa :{
            required: true
        },
        nominalbiaya :{
            required: true
        },
    },
    messages: {
        coa :{
            required: "Kode Rek. Biaya harus diisi!!"
        },
        nominalbiaya :{
            required: "Nominal Pengajuan harus diisi!!"
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

function validatequickModalForm_ct2_approval(){
    var validation = $("#quickModalForm_ct2_approval").validate({
    rules: {
        role :{
            required: true
        },
        jenismenu :{
            required: true
        },
        user :{
            required: true
        },
        status_approval :{
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
        user :{
            required: "Pejabat harus diisi!!"
        },
        status_approval :{
            required: "Status Approval harus diisi!!"
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

$("#btn_proposal").on('click', function(){
    if($("#proposal").val() != ""){
        fetch('{{ asset ("/proposal/") }}/'+$("#proposal").val()).then(resp => resp.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = $("#proposal").val();
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
        $("#btn_proposal").attr("disabled", true);
        $("#btn_proposal").removeClass("btn-primary text-white");
        
        var uploadfile = document.getElementById("upload_proposal").files[0];
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
            form_data.append("menname", "proposal");
            $.ajax({
                url:"/uploadfilekegiatan",
                method:"POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend:function(){
                    $("label[for=upload_proposal]").html("Uploading <i class=\"fas fa-spinner fa-pulse\"></i>");
                },
                success:function(data){
                    if(data.status >= 200 && data.status <= 299){
                        $("label[for=upload_proposal]").html("Finished upload file");
                        $("#proposal").val(data.filename);
                        $("#btn_proposal").attr("disabled", false);
                        $("#btn_proposal").addClass("btn-success text-white");
                        $("#btn_proposal").html("Download");
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

$("#btn_laporan_pjk").on('click', function(){
    if($("#laporan_pjk").val() != ""){
        fetch('{{ asset ("/laporan_pjk/") }}/'+$("#laporan_pjk").val()).then(resp => resp.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = $("#laporan_pjk").val();
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
        $("#btn_laporan_pjk").attr("disabled", true);
        $("#btn_laporan_pjk").removeClass("btn-primary text-white");
        
        var uploadfile = document.getElementById("upload_laporan_pjk").files[0];
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
            form_data.append("menname", "laporan_pjk");
            $.ajax({
                url:"/uploadfilekegiatan",
                method:"POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend:function(){
                    $("label[for=upload_laporan_pjk]").html("Uploading <i class=\"fas fa-spinner fa-pulse\"></i>");
                },
                success:function(data){
                    if(data.status >= 200 && data.status <= 299){
                        $("label[for=upload_laporan_pjk]").html("Finished upload file");
                        $("#laporan_pjk").val(data.filename);
                        $("#btn_laporan_pjk").attr("disabled", false);
                        $("#btn_laporan_pjk").addClass("btn-success text-white");
                        $("#btn_laporan_pjk").html("Download");
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

function processapprove(temp){
    <?php if($page_data["page_method_name"] == "View"){ ?>
    $.ajax({
        url:"/processapprovepjk",
        method:"POST",
        data: {
            _token                  : $("#quickForm input[name=_token]").val(),
            no_seq                  : temp[0],
            role                    : temp[1],
            role_label              : temp[2],
            jenismenu               : temp[3],
            user                    : temp[4],
            user_label              : temp[5],
            komentar                : temp[6],
            status_approval         : temp[7],
            status_approval_label   : temp[8],
            id                      : {{$page_data["id"]}}
        },
        cache: false,
        success:function(data){
            if(data.status >= 200 && data.status <= 299){
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
        },
        error: function (err) {
            if (err.status >= 400) {
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
        }
    });
    <?php } ?>
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

// ========== INLINE TABLE ==========
    $(document).keydown(function(event) {
    var rowlen = 0;
    

    if((event.ctrlKey || event.metaKey) && event.which == 66) {
        $("#addrow").trigger("click");
        return false;
    };
    if((event.ctrlKey || event.metaKey) && event.which == 83) {
        $("#quickForm").submit();
            return false;
        };
    });

    $("#submit-form").click(function(){
        $("#quickForm").submit();
    });

    $(".row-delete").click(function(){
        var $td = $(this).parent();
        var $tr = $($td).parent();
        $($tr).remove();
        calcTotal();
    });
    
    $(".addnewrowselect").select2({
        ajax: {
            url: "/getlinksjurnal",
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

    $(".addnewrowselect").on("change", function() {
        var $td = $(this).parent();
        var $tr = $($td).parent();
        $($tr).find("td:eq(0)").text($(this).val());
    });

    $(".cakautonumeric").on("change", function(){
        if(AutoNumeric.getNumber("#debet_"+$(this).attr("id").split("_")[1]) > 0 && AutoNumeric.getNumber("#kredit_"+$(this).attr("id").split("_")[1]) > 0){
            $("#debet_"+$(this).attr("id").split("_")[1]).addClass("border-danger");
            $("#kredit_"+$(this).attr("id").split("_")[1]).addClass("border-danger");
        }else{
            $("#debet_"+$(this).attr("id").split("_")[1]).removeClass("border-danger");
            $("#kredit_"+$(this).attr("id").split("_")[1]).removeClass("border-danger");
        }
        calcTotal();
    });

    addRow();
    $("#addrow").click(function(){
        addRow();
    });  

    function addRow(){
        rowlen = 0;
        if($('#caktable1 > tbody > tr').length > 0){
            rowlen = parseInt($('#caktable1 > tbody > tr:last').attr('row-seq'))+1;
        }
         

        var rowaddlen = 0;
        $("#caktable1").find('tbody')
            .append("<tr row-seq=\""+rowlen+"\" class=\"addnewrow\">"
                +"<td class=\"column-hidden\"></td>"
                +"<td class=\"p-0\"><select name=\"coa_"+rowlen+"\" id=\"coa_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%;\"></select></td>"
                +"<td class=\"p-0\"><input type=\"text\" name=\"deskripsi_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"deskripsi_"+rowlen+"\"></td>"
                +"<td class=\"p-0\"><input type=\"text\" name=\"debet_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"debet_"+rowlen+"\" placeholder=\"Enter Debet\"></td>"
                +"<td class=\"p-0\"><input type=\"text\" name=\"kredit_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm \" id=\"kredit_"+rowlen+"\" placeholder=\"Enter Kredit\"></td>"
                +"<td class=\"p-0 text-center\"><button id=\"row_delete_"+rowlen+"\" class=\"bg-white border-0\"><i class=\"text-danger fas fa-minus-circle row-delete\" style=\"cursor: pointer;\"></i></button></td>"
                +"<td class=\"column-hidden\"></td>"
            +"</tr>");
        rowaddlen = $('#caktable1 tr.addnewrow').length;
        
        $("#row_delete_"+rowlen).on('click', function(){
            var $td = $(this).parent();
            var $tr = $($td).parent();
            $($tr).remove();
            calcTotal();
        });

        $("#coa_"+rowlen+"").on("change", function() {
            var $td = $(this).parent();
            var $tr = $($td).parent();
            $($tr).find("td:eq(0)").text($(this).val());
        });

        var debets = new AutoNumeric("#debet_"+rowlen, {
            currencySymbol : 'Rp ',
            decimalCharacter : ',',
            digitGroupSeparator : '.',
            minimumValue : 0,
            decimalPlaces : 2,
            unformatOnSubmit : true
        });

        $("#debet_"+rowlen).on("change", function(){
            if(debets.rawValue > 0 && kredits.rawValue > 0){
                $("#debet_"+rowlen).addClass("border-danger");
            }else{
                $("#debet_"+rowlen).removeClass("border-danger");
            }
            calcTotal();
        });

        $("#coa_"+rowlen+"").select2({
            ajax: {
                url: "getlinkskegiatan",
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

        <?php if(isset($page_data["page_job"]) && $page_data["page_job"] == "Saldo Awal"){ ?>
            $("input[name=deskripsi_1]").val("Saldo Awal");
            $("input[name=deskripsi_1]").prop("readonly", true);
            $("input[name=deskripsi_"+rowlen+"]").val("Saldo Awal");
            $("input[name=deskripsi_"+rowlen+"]").prop("readonly", true);
        <?php } ?>

        $("#coa_"+rowlen+"").select2({
            ajax: {
                url: "/getlinkskegiatan",
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
    }

    $("#createnew").click(function(){
        $("#id_jurnal").val(0);
        $("#is_edit").val(0);
        $('#unitkerja').val(null).trigger('change');
        $("#anggaran_label").val("");
        $("#no_jurnal").val("JU#######");
        $('input[name=tanggal_jurnal]').val("");
        $('#coa_1').val(null).trigger('change');
        $('#deskripsi_1').val("");
        AutoNumeric.getAutoNumericElement('#debet_1').set(0);
        AutoNumeric.getAutoNumericElement('#kredit_1').set(0);
        var last_row = $('#caktable1 > tbody > tr:last').attr('row-seq');
        if(parseInt(last_row) > 1){
            for(var i = 2; i <= last_row; i++){
                $("#row_delete_"+i).trigger("click");
            }
        }
        calcTotal();
        $("#addrow").trigger("click");
        $("#addrow").trigger("click");
        $("#addrow").trigger("click");
    });

    $("#createnew").trigger("click");

    $("#staticBackdropClose_transaksi").click(function(){
        $("#staticBackdrop_transaksi").modal("hide");
    });

    @if($page_data["page_method_name"] == "Update" || $page_data["page_method_name"] == "View")
    getdata();
    @endif
    
</script>