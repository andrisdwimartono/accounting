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
    <script src="{{ asset ("/assets/motaadmin/js/plugins-init/datatables.init.js") }} "></script>
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

    anObject["debet"].settings.minimumValue = 0;
    anObject["credit"].settings.minimumValue = 0;


$(function () {
    var dt = new Date();
    var tgl = (dt.getDate()<10?"0"+dt.getDate():dt.getDate())+"/"+((dt.getMonth()+1)<10?"0"+(dt.getMonth()+1):(dt.getMonth()+1))+"/"+dt.getFullYear();
    @if($page_data["page_method_name"] != "View")
    $("#transaction_date").datepicker({
        format:"dd/mm/yyyy",
        modal: true,
        footer: true,
        uiLibrary: 'bootstrap'@if($page_data["page_method_name"] == "Create"),
        value: tgl @endif
    });
    @endif

    $("#submitform").click(function(){
        $("#quickForm").submit();
    });

    $.validator.setDefaults({
        submitHandler: function (form, event) {
            event.preventDefault();
            cto_loading_show();
            var quickForm = $("#quickForm");
            var cttransaction_detail = [];
            var table = $("#cttransaction_detail").DataTable().rows().data();
            for(var i = 0; i < table.length; i++){
                cttransaction_detail.push({"no_seq": table[i][0], "coa": table[i][1], "coa_label": table[i][2], "description": table[i][3], "debet": table[i][4], "credit": table[i][5], "va_code": table[i][6], "id": table[i][table.columns().header().length-1]});
            }
            $("#transaction_detail").val(JSON.stringify(cttransaction_detail));
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
                            if(i == "coa" || i == "coa_label" || i == "description" || i == "debet" || i == "credit" || i == "va_code"){
                                errors["transaction_detail"] = error[0];
                            }else{
                                errors[i] = error[0];
                            }
                            validator.showErrors(errors);
                        });
                    }
                    if (err.status >= 400 && err.status != 422) {
                        $.toast({
                            text: err.responseJSON.message,
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

$.fn.modal.Constructor.prototype._enforceFocus = function() {

};

$("#unitkerja").on("change", function() {
    $("#unitkerja_label").val($("#unitkerja option:selected").text());
});

$("#transaction_type").on("change", function() {
    $("#transaction_type_label").val($("#transaction_type option:selected").text());
});

$("#coa").on("change", function() {
    $("#coa_label").val($("#coa option:selected").text());
});
var fields = $("#quickForm").serialize();

$.ajax({
    url: "/getoptions{{$page_data["page_data_urlname"]}}",
    type: "post",
    data: {
        fieldname: "transaction_type",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                var newState = new Option(data[i].label, data[i].name, true, false);
                $("#transaction_type").append(newState).trigger("change");
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

$("#unitkerja").select2({
    ajax: {
        url: "/getlinks{{$page_data["page_data_urlname"]}}",
        type: "post",
        dataType: "json",
        data: function(params) {
            return {
                term: params.term || "",
                page: params.page,
                field: "unitkerja",
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
        unitkerja :{
            required: true
        },
        journal_number :{
            required: true,
            minlength:1,
            maxlength:25
        },
        anggaran_name :{
            maxlength:255
        },
        transaction_date :{
            required: true,
            dateFormat_1: true
        },
    },
    messages: {
        unitkerja :{
            required: "Unit Kerja harus diisi!!"
        },
        journal_number :{
            required: "Nomor Jurnal harus diisi!!",
            minlength: "Nomor Jurnal minimal 1 karakter!!",
            maxlength: "Nomor Jurnal maksimal 25 karakter!!"
        },
        anggaran_name :{
            maxlength: "Nama Anggaran maksimal 255 karakter!!"
        },
        transaction_date :{
            required: "Tanggal harus diisi!!",
            dateFormat_1: "Format tanggal Tanggal salah!!"
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

$("#quickModalForm_transaction_detail").validate({
    rules: {
        coa :{
            required: true
        },
        description :{
            maxlength:255
        },
        debet :{
            required: true
        },
        credit :{
            required: true
        },
        va_code :{
            maxlength:255
        },
    },
    messages: {
        coa :{
            required: "COA harus diisi!!"
        },
        description :{
            maxlength: "Deskripsi maksimal 255 karakter!!"
        },
        debet :{
            required: "Debet harus diisi!!"
        },
        credit :{
            required: "Kredit harus diisi!!"
        },
        va_code :{
            maxlength: "Kode VA maksimal 255 karakter!!"
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
    addChildTable_transaction_detail("staticBackdrop_transaction_detail");
    var table_transaction_detail = $("#cttransaction_detail").DataTable({
        @if($page_data["page_method_name"] != "View")
        rowReorder: true,
        @endif
        aoColumnDefs: [{
            aTargets: [4, 5],
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
                    //$("#staticBackdrop_transaction_detail").modal({"show": true});
                    addChildTable_transaction_detail("staticBackdrop_transaction_detail");
                }
            }
        ]
        @endif
    });

    table_transaction_detail.column(table_transaction_detail.columns().header().length-1).visible(false);
    table_transaction_detail.column(1).visible(false);

    $("#cttransaction_detail tbody").on( "click", ".row-show", function () {
        //$("#staticBackdrop_transaction_detail").modal({"show": true});
        showChildTable_transaction_detail("staticBackdrop_transaction_detail", table_transaction_detail.row( $(this).parents("tr") ));
    } );

    $("#staticBackdropClose_transaction_detail").click(function(){
        //$("#staticBackdrop_transaction_detail").modal("hide");
    });

    table_transaction_detail.on( "row-reorder", function ( e, diff, edit ) {
            var result = "Reorder started on row: "+edit.triggerRow.data()[1]+"<br>";
            for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                var rowData = table_transaction_detail.row( diff[i].node ).data();
                result += rowData[1]+" updated to be in position "+
                    diff[i].newData+" (was "+diff[i].oldData+")<br>";
            }
        $("#result").html( "Event result:<br>"+result );
    } );
    $("#cttransaction_detail tbody").on("click", ".row-delete", function () {
        table_transaction_detail.row($(this).parents("tr")).remove().draw();
    });

    $('#cttransaction_detail tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
        showChildTable_transaction_detail("staticBackdrop_transaction_detail", table_transaction_detail.row( this ));
    } );

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
                if(Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i] == "unitkerja"){
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

            $("#cttransaction_detail").DataTable().clear().draw();
            if(data.data.transaction_detail.length > 0){
                for(var i = 0; i < data.data.transaction_detail.length; i++){
                    var dttb = $('#cttransaction_detail').DataTable();
                    var child_table_data = [data.data.transaction_detail[i].no_seq, data.data.transaction_detail[i].coa, data.data.transaction_detail[i].coa_label, data.data.transaction_detail[i].description, data.data.transaction_detail[i].debet, data.data.transaction_detail[i].credit, data.data.transaction_detail[i].va_code, @if($page_data["page_method_name"] != "View") '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>' @else '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>' @endif, data.data.transaction_detail[i].id];
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
function addChildTable_transaction_detail(childtablename){
    $("select[name='coa']").empty();
    $("input[name='coa_label']").val("");
    $("input[name='description']").val("");
    $("input[name='debet']").val("");
    $("input[name='credit']").val("");
    $("input[name='va_code']").val("");

    @if($page_data["page_method_name"] != "View")
    $(".modal-footer-child").html('<button type="button" id="staticBackdropAdd_transaction_detail" class="btn btn-primary">Add Row</button>');
    @endif

    $("#staticBackdropAdd_transaction_detail").click(function(e){
        e.preventDefault;
        var dttb = $('#cttransaction_detail').DataTable();

        var no_seq = dttb.rows().count();
        var coa = $("select[name='coa'] option").filter(':selected').val();
        if(!coa){
            coa = null;
        }
        var coa_label = $("input[name='coa_label']").val();
        var description = $("input[name='description']").val();
        var debet = anObject["debet"].rawValue;
        var credit = anObject["credit"].rawValue;
        var va_code = $("input[name='va_code']").val();

        var child_table_data = [no_seq+1, coa, coa_label, description, debet, credit, va_code, '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>', null];

        if(validatequickModalForm_transaction_detail()){
            if(dttb.row.add(child_table_data).draw( false )){
                //$('#staticBackdrop_transaction_detail').modal('hide');
            }
        }
        addChildTable_transaction_detail(childtablename);
    });
}

function showChildTable_transaction_detail(childtablename, data){
    $("select[name='coa']").empty();
    var newState = new Option(data.data()[2], data.data()[1], true, false);
    $("#coa").append(newState).trigger('change');
    $("input[name='coa_label']").val(data.data()[2]);
    $("input[name='description']").val(data.data()[3]);
    anObject["debet"].set(data.data()[4]);
    anObject["credit"].set(data.data()[5]);
    $("input[name='va_code']").val(data.data()[6]);

    @if($page_data["page_method_name"] != "View")
    $(".modal-footer-child").html('<button type="button" id="staticBackdropUpdate_transaction_detail" class="btn btn-primary">Update</button>');
    @endif

    $("#staticBackdropUpdate_transaction_detail").click(function(e){
        var temp = data.data();
        temp[1] = $("select[name='coa'] option").filter(':selected').val();
        if(!coa){
            coa = null;
        }
        temp[2] = $("input[name='coa_label']").val();
        temp[3] = $("input[name='description']").val();
        temp[4] = anObject["debet"].rawValue;
        temp[5] = anObject["credit"].rawValue;
        temp[6] = $("input[name='va_code']").val();
        if( validatequickModalForm_transaction_detail() ){
            data.data(temp).invalidate();
            //$("#staticBackdrop_transaction_detail").modal("hide");
        }
    });
}

function validatequickModalForm_transaction_detail(){
    var validation = $("#quickModalForm_transaction_detail").validate({
    rules: {
        coa :{
            required: true
        },
        description :{
            maxlength:255
        },
        debet :{
            required: true
        },
        credit :{
            required: true
        },
        va_code :{
            maxlength:255
        },
    },
    messages: {
        coa :{
            required: "COA harus diisi!!"
        },
        description :{
            maxlength: "Deskripsi maksimal 255 karakter!!"
        },
        debet :{
            required: "Debet harus diisi!!"
        },
        credit :{
            required: "Kredit harus diisi!!"
        },
        va_code :{
            maxlength: "Kode VA maksimal 255 karakter!!"
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

</script>