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
    <!-- <script src="{{ asset ("/assets/node_modules/gijgo/js/gijgo.min.js") }}"></script> -->
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

    anObject["debet"].settings.minimumValue = 0;
    anObject["credit"].settings.minimumValue = 0;


$(function () {
    $('.datepicker-default').pickadate({
        format: 'dd/mm/yyyy',
        formatSubmit: 'yyyy-mm-dd',
        hiddenName: true
    })   
    // @if($page_data["page_method_name"] != "View")
    // $("#reservationdate_tanggal_jurnal").datepicker({
    //     format:"dd/mm/yyyy",
    //     modal: true,
    //     footer: true
    // });
    // @endif
    // @if($page_data["page_method_name"] != "View")
    // $("#reservationdate_tanggal").datepicker({
    //     format:"",
    //     modal: true,
    //     footer: true
    // });
    // @endif

    $.validator.setDefaults({
        submitHandler: function (form, event) {
            event.preventDefault();
            cto_loading_show();
            var quickForm = $("#quickForm");
            var cttransaksi = [];
            var table = $("#cttransaksi").DataTable().rows().data();
            for(var i = 0; i < table.length; i++){
                cttransaksi.push({"no_seq": table[i][0], "unitkerja": table[i][1], "unitkerja_label": table[i][2], "anggaran": table[i][3], "anggaran_label": table[i][4], "no_jurnal": table[i][5], "tanggal": table[i][6], "keterangan": table[i][7], "jenis_transaksi": table[i][8], "coa": table[i][9], "coa_label": table[i][10], "deskripsi": table[i][11], "jenisbayar": table[i][12], "jenisbayar_label": table[i][13], "nim": table[i][14], "kode_va": table[i][15], "fheader": table[i][16], "debet": table[i][17], "credit": table[i][18], "id": table[i][table.columns().header().length-1]});
            }
            $("#transaksi").val(JSON.stringify(cttransaksi));
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
                            if(i == "unitkerja" || i == "unitkerja_label" || i == "anggaran" || i == "anggaran_label" || i == "no_jurnal" || i == "tanggal" || i == "keterangan" || i == "jenis_transaksi" || i == "coa" || i == "coa_label" || i == "deskripsi" || i == "jenisbayar" || i == "jenisbayar_label" || i == "nim" || i == "kode_va" || i == "fheader" || i == "debet" || i == "credit"){
                                errors["transaksi"] = error[0];
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

$("#unitkerja").on("change", function() {
    $("#unitkerja_label").val($("#unitkerja option:selected").text());
});

$("#anggaran").on("change", function() {
    $("#anggaran_label").val($("#anggaran option:selected").text());
});

$("#coa").on("change", function() {
    $("#coa_label").val($("#coa option:selected").text());
});

$("#jenisbayar").on("change", function() {
    $("#jenisbayar_label").val($("#jenisbayar option:selected").text());
});
var fields = $("#quickForm").serialize();

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

$("#anggaran").select2({
    ajax: {
        url: "/getlinks{{$page_data["page_data_urlname"]}}",
        type: "post",
        dataType: "json",
        data: function(params) {
            return {
                term: params.term || "",
                page: params.page,
                field: "anggaran",
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

$("#jenisbayar").select2({
    ajax: {
        url: "/getlinks{{$page_data["page_data_urlname"]}}",
        type: "post",
        dataType: "json",
        data: function(params) {
            return {
                term: params.term || "",
                page: params.page,
                field: "jenisbayar",
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
        no_jurnal :{
            required: true,
            minlength:1,
            maxlength:25
        },
        tanggal_jurnal :{
            required: true,
            dateFormat_1: true
        },
    },
    messages: {
        unitkerja :{
            required: "Unit Kerja harus diisi!!"
        },
        no_jurnal :{
            required: "Nomor Jurnal harus diisi!!",
            minlength: "Nomor Jurnal minimal 1 karakter!!",
            maxlength: "Nomor Jurnal maksimal 25 karakter!!"
        },
        tanggal_jurnal :{
            required: "Tanggal Jurnal harus diisi!!",
            dateFormat_1: "Format tanggal Tanggal Jurnal salah!!"
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

$("#quickModalForm_transaksi").validate({
    rules: {
        unitkerja :{
            required: true
        },
        tanggal :{
            required: true
        },
        coa :{
            required: true
        },
        debet :{
            required: true
        },
        credit :{
            required: true
        },
    },
    messages: {
        unitkerja :{
            required: "Unit Kerja harus diisi!!"
        },
        tanggal :{
            required: "Tanggal harus diisi!!"
        },
        coa :{
            required: "No. Rek. Akuntansi harus diisi!!"
        },
        debet :{
            required: "Debet harus diisi!!"
        },
        credit :{
            required: "Kredit harus diisi!!"
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
    $("#forcaktable1").append($("table")
        .attr("id", "caktable1")
        .attr("width", "100%")
        .append($("thead")
            .append($("th")
                .attr("id", "caktable1-coa")
                .text("No. Rek. Akuntansi")
            )
            .append($("th")
                .attr("id", "caktable1-deskripsi")
                .text("Deskripsi")
            )
            .append($("th")
                .attr("id", "caktable1-debit")
                .text("Debit")
            )
            .append($("th")
                .attr("id", "caktable1-kredit")
                .text("Kredit")
            )
        )
        .append($("tbody")
            .append($("td")
                .text("1")
            )
            .append($("td")
                .text("Deskripsi")
            )
            .append($("td")
                .text("Debit")
            )
            .append($("td")
                .text("Kredit")
            )
        )
    );

    var table_transaksi = $("#cttransaksi").DataTable({
        @if($page_data["page_method_name"] != "View")
        rowReorder: true,
        @endif
        aoColumnDefs: [{
            aTargets: [17, 18],
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
                    $("#staticBackdrop_transaksi").modal({"show": true});
                    addChildTable_transaksi("staticBackdrop_transaksi");
                }
            }
        ]
        @endif
    });

    table_transaksi.column(table_transaksi.columns().header().length-1).visible(false);
    table_transaksi.column(0).visible(false);
    table_transaksi.column(1).visible(false);
    table_transaksi.column(2).visible(false);
    table_transaksi.column(3).visible(false);
    table_transaksi.column(4).visible(false);
    table_transaksi.column(5).visible(false);
    table_transaksi.column(6).visible(false);
    table_transaksi.column(7).visible(false);
    table_transaksi.column(9).visible(false);
    table_transaksi.column(11).visible(false);
    table_transaksi.column(12).visible(false);
    table_transaksi.column(13).visible(false);
    table_transaksi.column(14).visible(false);
    table_transaksi.column(15).visible(false);

    $("#cttransaksi tbody").on( "click", ".row-show", function () {
        $("#staticBackdrop_transaksi").modal({"show": true});
        showChildTable_transaksi("staticBackdrop_transaksi", table_transaksi.row( $(this).parents("tr") ));
    } );

    $("#staticBackdropClose_transaksi").click(function(){
        $("#staticBackdrop_transaksi").modal("hide");
    });

    table_transaksi.on( "row-reorder", function ( e, diff, edit ) {
            var result = "Reorder started on row: "+edit.triggerRow.data()[1]+"<br>";
            for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                var rowData = table_transaksi.row( diff[i].node ).data();
                result += rowData[1]+" updated to be in position "+
                    diff[i].newData+" (was "+diff[i].oldData+")<br>";
            }
        $("#result").html( "Event result:<br>"+result );
    } );
    $("#cttransaksi tbody").on("click", ".row-delete", function () {
        table_transaksi.row($(this).parents("tr")).remove().draw();
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

            $("#cttransaksi").DataTable().clear().draw();
            if(data.data.transaksi.length > 0){
                for(var i = 0; i < data.data.transaksi.length; i++){
                    var dttb = $('#cttransaksi').DataTable();
                    var child_table_data = [data.data.transaksi[i].no_seq, data.data.transaksi[i].unitkerja, data.data.transaksi[i].unitkerja_label, data.data.transaksi[i].anggaran, data.data.transaksi[i].anggaran_label, data.data.transaksi[i].no_jurnal, data.data.transaksi[i].tanggal, data.data.transaksi[i].keterangan, data.data.transaksi[i].jenis_transaksi, data.data.transaksi[i].coa, data.data.transaksi[i].coa_label, data.data.transaksi[i].deskripsi, data.data.transaksi[i].jenisbayar, data.data.transaksi[i].jenisbayar_label, data.data.transaksi[i].nim, data.data.transaksi[i].kode_va, data.data.transaksi[i].fheader, data.data.transaksi[i].debet, data.data.transaksi[i].credit, @if($page_data["page_method_name"] != "View") '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>' @else '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>' @endif, data.data.transaksi[i].id];
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
function addChildTable_transaksi(childtablename){
    $("select[name='anggaran']").empty();
    $("input[name='anggaran_label']").val("");
    $("input[name='no_jurnal']").val("");
    $("input[name='tanggal']").val("");
    $("textarea[name='keterangan']").val("");
    $("input[name='jenis_transaksi']").val("");
    $("select[name='coa']").empty();
    $("input[name='coa_label']").val("");
    $("textarea[name='deskripsi']").val("");
    $("select[name='jenisbayar']").empty();
    $("input[name='jenisbayar_label']").val("");
    $("input[name='nim']").val("");
    $("input[name='kode_va']").val("");
    $("input[name='fheader']").val("");
    $("input[name='debet']").val("");
    $("input[name='credit']").val("");

    @if($page_data["page_method_name"] != "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropAdd_transaksi" class="btn btn-primary">Add Row</button>');
    @endif

    $("#staticBackdropAdd_transaksi").click(function(e){
        e.preventDefault;
        var dttb = $('#cttransaksi').DataTable();

        var no_seq = dttb.rows().count();
        var unitkerja = $("select[name='unitkerja'] option").filter(':selected').val();
        if(!unitkerja){
            unitkerja = null;
        }
        var unitkerja_label = $("input[name='unitkerja_label']").val();
        var anggaran = $("select[name='anggaran'] option").filter(':selected').val();
        if(!anggaran){
            anggaran = null;
        }
        var anggaran_label = $("input[name='anggaran_label']").val();
        var no_jurnal = $("input[name='no_jurnal']").val();
        var tanggal = $("input[name='tanggal']").val();
        var keterangan = $("textarea[name='keterangan']").val();
        var jenis_transaksi = $("input[name='jenis_transaksi']").val();
        var coa = $("select[name='coa'] option").filter(':selected').val();
        if(!coa){
            coa = null;
        }
        var coa_label = $("input[name='coa_label']").val();
        var deskripsi = $("textarea[name='deskripsi']").val();
        var jenisbayar = $("select[name='jenisbayar'] option").filter(':selected').val();
        if(!jenisbayar){
            jenisbayar = null;
        }
        var jenisbayar_label = $("input[name='jenisbayar_label']").val();
        var nim = $("input[name='nim']").val();
        var kode_va = $("input[name='kode_va']").val();
        var fheader = $("input[name='fheader']").val();
        var debet = anObject["debet"].rawValue;
        var credit = anObject["credit"].rawValue;

        var child_table_data = [no_seq+1, unitkerja, unitkerja_label, anggaran, anggaran_label, no_jurnal, tanggal, keterangan, jenis_transaksi, coa, coa_label, deskripsi, jenisbayar, jenisbayar_label, nim, kode_va, fheader, debet, credit, '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>', null];

        if(validatequickModalForm_transaksi()){
            if(dttb.row.add(child_table_data).draw( false )){
                $('#staticBackdrop_transaksi').modal('hide');
            }
        }
    });
}

function showChildTable_transaksi(childtablename, data){
    $("select[name='anggaran']").empty();
    var newState = new Option(data.data()[4], data.data()[3], true, false);
    $("#anggaran").append(newState).trigger('change');
    $("input[name='anggaran_label']").val(data.data()[4]);
    $("input[name='no_jurnal']").val(data.data()[5]);
    $("input[name='tanggal']").val(data.data()[6]);
    $("textarea[name='keterangan']").val(data.data()[7]);
    $("input[name='jenis_transaksi']").val(data.data()[8]);
    $("select[name='coa']").empty();
    var newState = new Option(data.data()[10], data.data()[9], true, false);
    $("#coa").append(newState).trigger('change');
    $("input[name='coa_label']").val(data.data()[10]);
    $("textarea[name='deskripsi']").val(data.data()[11]);
    $("select[name='jenisbayar']").empty();
    var newState = new Option(data.data()[13], data.data()[12], true, false);
    $("#jenisbayar").append(newState).trigger('change');
    $("input[name='jenisbayar_label']").val(data.data()[13]);
    $("input[name='nim']").val(data.data()[14]);
    $("input[name='kode_va']").val(data.data()[15]);
    $("input[name='fheader']").val(data.data()[16]);
    anObject["debet"].set(data.data()[17]);
    anObject["credit"].set(data.data()[18]);

    @if($page_data["page_method_name"] != "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropUpdate_transaksi" class="btn btn-primary">Update</button>');
    @endif

    $("#staticBackdropUpdate_transaksi").click(function(e){
        var temp = data.data();
        temp[1] = $("select[name='unitkerja'] option").filter(':selected').val();
        if(!unitkerja){
            unitkerja = null;
        }
        temp[2] = $("input[name='unitkerja_label']").val();
        temp[3] = $("select[name='anggaran'] option").filter(':selected').val();
        if(!anggaran){
            anggaran = null;
        }
        temp[4] = $("input[name='anggaran_label']").val();
        temp[5] = $("input[name='no_jurnal']").val();
        temp[6] = $("input[name='tanggal']").val();
        temp[7] = $("textarea[name='keterangan']").val();
        temp[8] = $("input[name='jenis_transaksi']").val();
        temp[9] = $("select[name='coa'] option").filter(':selected').val();
        if(!coa){
            coa = null;
        }
        temp[10] = $("input[name='coa_label']").val();
        temp[11] = $("textarea[name='deskripsi']").val();
        temp[12] = $("select[name='jenisbayar'] option").filter(':selected').val();
        if(!jenisbayar){
            jenisbayar = null;
        }
        temp[13] = $("input[name='jenisbayar_label']").val();
        temp[14] = $("input[name='nim']").val();
        temp[15] = $("input[name='kode_va']").val();
        temp[16] = $("input[name='fheader']").val();
        temp[17] = anObject["debet"].rawValue;
        temp[18] = anObject["credit"].rawValue;
        if( validatequickModalForm_transaksi() ){
            data.data(temp).invalidate();
            $("#staticBackdrop_transaksi").modal("hide");
        }
    });
}

function validatequickModalForm_transaksi(){
    var validation = $("#quickModalForm_transaksi").validate({
    rules: {
        unitkerja :{
            required: true
        },
        tanggal :{
            required: true
        },
        coa :{
            required: true
        },
        debet :{
            required: true
        },
        credit :{
            required: true
        },
    },
    messages: {
        unitkerja :{
            required: "Unit Kerja harus diisi!!"
        },
        tanggal :{
            required: "Tanggal harus diisi!!"
        },
        coa :{
            required: "No. Rek. Akuntansi harus diisi!!"
        },
        debet :{
            required: "Debet harus diisi!!"
        },
        credit :{
            required: "Kredit harus diisi!!"
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