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

    anObject["nominalbiaya"].settings.minimumValue = 0;


$(function () {

   
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
    //$('#iku').val('').trigger('change');
    plafonanggaran();
});

$('input[name=tanggal_kegiatan]').on("change", function(){
    plafonanggaran();
});

// $("#tahun").on("change", function() {
//     $("#tahun_label").val($("#tahun option:selected").text());
//     $('#iku').val('').trigger('change');
// });

$("#programkerja").on("change", function() {
    $("#programkerja_label").val($("#programkerja option:selected").text());
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

$("#programkerja").select2({
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
                field: "programkerja",
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
        programkerja :{
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
        programkerja :{
            required: "Program Kerja harus diisi!!"
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
    var table_ct2_approval = $("#ctct2_approval").DataTable({
        bFilter: false,
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
    table_ct2_approval.column(9).visible(false);

    $("#staticBackdropClose_ct2_approval").click(function(){
        $("#staticBackdrop_ct2_approval").modal("hide");
    });

    $("#approverka").click(function(){
        $("#modal-accept").modal("show");
    });

    $("#approvepengajuan").click(function(){
        $("#modal-accept").modal("show");
    });
    
    $("#rejectrka").click(function(){
        $("#alasan_tolak_error").val("");
        $("#modal-reject").modal("show");
    });

    @if($page_data["page_method_name"] == "Update" || $page_data["page_method_name"] == "View")
    $("#historyrka").click(function(){
        $("#modal-history").modal("show");
        $("#historykegiatan").addClass("spinner-border");
        $.ajax({
            url: "/getdatakegiatanhistory",
            type: "post",
            data: {
                id: {{$page_data["id"]}},
                _token: $("#quickForm input[name=_token]").val()
            },
            success: function(data){
                $("#historykegiatan").removeClass("spinner-border");
                $("#historykegiatan").html("");
                $("#historykegiatan").append("<table class=\"table table-stripped\" style=\"width: 100%\">");
                $("#historykegiatan").append("<thead class=\"thead-dark\">");
                $("#historykegiatan").append("<tr>");
                $("#historykegiatan").append("<th style=\"width: 30%\">Kode Rekening</th>");
                $("#historykegiatan").append("<th style=\"width: 20%\">Deskripsi</th>");
                $("#historykegiatan").append("<th style=\"width: 20%\">Nominal</th>");
                $("#historykegiatan").append("<th style=\"width: 10%\">Status</th>");
                $("#historykegiatan").append("<th style=\"width: 20%\">Komentar Revisi</th>");
                $("#historykegiatan").append("</tr>");
                $("#historykegiatan").append("</thead>");
                var ab = "";
                for(var x = 0; x < data.data.ct1_detailbiayakegiatan.length; x++){
                    if(ab != data.data.ct1_detailbiayakegiatan[x].archivedby){
                        $("#historykegiatan").append("<tr>");
                        var role_label = "";
                        for(var y = 0; y < data.data.ct2_approval.length; y++){
                            if(data.data.ct1_detailbiayakegiatan[x].archivedby == data.data.ct2_approval[y].role){
                                role_label = data.data.ct2_approval[y].role_label;
                            }
                        }
                        $("#historykegiatan").append("<td colspan=\"5\"><b>"+role_label+"</b></td>");
                        $("#historykegiatan").append("</tr>");
                    }
                    ab = data.data.ct1_detailbiayakegiatan[x].archivedby;
                    $("#historykegiatan").append("<tr>");
                    $("#historykegiatan").append("<td>"+data.data.ct1_detailbiayakegiatan[x].coa_label+"</td>");
                    $("#historykegiatan").append("<td>"+data.data.ct1_detailbiayakegiatan[x].deskripsibiaya+"</td>");
                    $("#historykegiatan").append("<td>"+formatRupiahWNegative(data.data.ct1_detailbiayakegiatan[x].nominalbiaya, "Rp")+"</td>");
                    $("#historykegiatan").append("<td>"+data.data.ct1_detailbiayakegiatan[x].status+"</td>");
                    var comm = data.data.ct1_detailbiayakegiatan[x].komentarrevisi?data.data.ct1_detailbiayakegiatan[x].komentarrevisi:"";
                    $("#historykegiatan").append("<td>"+comm+"</td>");
                    $("#historykegiatan").append("</tr>");
                }
                $("#historykegiatan").append("</table>");
            },
            error: function (err) {
                $("#historykegiatan").removeClass("spinner-border");
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
            }
        });
    });
    @endif

    $("#rejectrka-confirmed").click(function(){
        if($("#alasan_tolak").val() == ""){
            $("#alasan_tolak_error").html("Harus diisi");
            $("#alasan_tolak_error").removeClass("d-none");
            return false;
        }
        $("#modal-reject").modal("hide");
        $("#alasan_tolak_error").val("");
        cto_loading_show();
        processapprove("reject", $("#alasan_tolak").val());
    });

    $("#rejectpengajuan-confirmed").click(function(){
        if($("#alasan_tolak").val() == ""){
            $("#alasan_tolak_error").html("Harus diisi");
            $("#alasan_tolak_error").removeClass("d-none");
            return false;
        }
        $("#modal-reject").modal("hide");
        $("#alasan_tolak_error").val("");
        cto_loading_show();
        processapprove_pengajuan("reject", $("#alasan_tolak").val());
    });

    $("#approverka-confirmed").click(function(){
        $("#modal-accept").modal("hide");
        cto_loading_show();
        processapprove("approve");
    });

    $("#approvepengajuan-confirmed").click(function(){
        $("#modal-accept").modal("hide");
        cto_loading_show();
        processapprove_pengajuan("approve");
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
            for(var i = 0; i < Object.keys(data.data.kegiatan).length; i++){
                if(Object.keys(data.data.kegiatan)[i] == "unit_pelaksana" || Object.keys(data.data.kegiatan)[i] == "iku"){
                    if(data.data.kegiatan[Object.keys(data.data.kegiatan)[i]]){
                        var newState = new Option(data.data.kegiatan[Object.keys(data.data.kegiatan)[i]+"_label"], data.data.kegiatan[Object.keys(data.data.kegiatan)[i]], true, false);
                        $("#"+Object.keys(data.data.kegiatan)[i]).append(newState).trigger("change");
                    }
                }else{
                    if(["ewfsdfsafdsafasdfasdferad"].includes(Object.keys(data.data.kegiatan)[i])){
                        $("input[name="+Object.keys(data.data.kegiatan)[i]+"]").prop("checked", data.data.kegiatan[Object.keys(data.data.kegiatan)[i]]);
                    }else{
                        try{
                            anObject[Object.keys(data.data.kegiatan)[i]].set(data.data.kegiatan[Object.keys(data.data.kegiatan)[i]]);
                        }catch(err){
                            $("input[name="+Object.keys(data.data.kegiatan)[i]+"]").val(data.data.kegiatan[Object.keys(data.data.kegiatan)[i]]);
                        }
                        $("textarea[name="+Object.keys(data.data.kegiatan)[i]+"]").val(data.data.kegiatan[Object.keys(data.data.kegiatan)[i]]);
                        if(["proposal"].includes(Object.keys(data.data.kegiatan)[i])){
                            if(data.data.kegiatan[Object.keys(data.data.kegiatan)[i]] != null){
                                $("#btn_"+Object.keys(data.data.kegiatan)[i]+"").removeAttr("disabled");
                                $("#btn_"+Object.keys(data.data.kegiatan)[i]+"").addClass("btn-success text-white");
                                $("#btn_"+Object.keys(data.data.kegiatan)[i]+"").removeClass("btn-primary");
                                var filename = Object.keys(data.data.kegiatan)[i];
                                $("label[for=upload_"+Object.keys(data.data.kegiatan)[i]+"]").html(filename);
                                $("#btn_"+Object.keys(data.data.kegiatan)[i]+"").html("Download");
                            }
                        }
                    }
                    $("select[name="+Object.keys(data.data.kegiatan)[i]+"]").val(data.data.kegiatan[Object.keys(data.data.kegiatan)[i]]).change();
                }
            }
            
            $("#ctct2_approval").DataTable().clear().draw();
            if(data.data.ct2_approval.length > 0){
                for(var i = 0; i < data.data.ct2_approval.length; i++){
                    var dttb = $('#ctct2_approval').DataTable();
                    var child_table_data = [data.data.ct2_approval[i].no_seq, data.data.ct2_approval[i].role, data.data.ct2_approval[i].role_label, data.data.ct2_approval[i].jenismenu, data.data.ct2_approval[i].user, data.data.ct2_approval[i].user_label, data.data.ct2_approval[i].komentar, data.data.ct2_approval[i].status_approval, data.data.ct2_approval[i].status_approval_label, data.data.ct2_approval[i].role=='<?= Auth::user()->role ?>'?'<div class="row-show"><i class="fa fa-list" style="color:blue;cursor: pointer;"></i></div>':'', data.data.ct2_approval[i].id];
                    if(dttb.row.add(child_table_data).draw( false )){

                    }
                }
            }
            
            if(data.data.ct1_detailbiayakegiatan.length > 0){
                $("#caktable1 > tbody > tr").each(function(index){
                    var row_index = parseInt($(this).attr("row-seq"));
                    if(row_index == 1){
                        $("#caktable1 > tbody > tr[row-seq="+row_index+"]").find("td:eq(0)").text("");
                        $("select[name='coa_"+row_index+"']").empty();
                        $("#caktable1 > tbody > tr[row-seq=1]").find("td:eq(0)").text("");

                        $("input[name='deskripsi_"+row_index+"']").val("");

                        $("input[name='nom_"+row_index+"']").val("0");
                        $("#caktable1 > tbody > tr[row-seq="+row_index+"]").find("td:eq(7)").text("");
                        return true;
                    }
                    $(this).remove();
                });
                
                for(var i = 0; i < data.data.ct1_detailbiayakegiatan.length; i++){
                    addRow();
                    $.ajax({
                        url: "/getoptions{{$page_data["page_data_urlname"]}}",
                        type: "post",
                        indexValue: i+1,
                        datass: data,
                        data: {
                            fieldname: "status",
                            _token: $("#quickForm input[name=_token]").val()
                        },
                        success: function(data){
                            for(var x = 0; x < data.length; x++){
                                if(data[x].name){
                                    var newState = new Option(data[x].label, data[x].name, true, false);
                                    $("#status_"+this.indexValue).append(newState);
                                }
                            }
                        },
                        error: function (err) {
                            if (err.status == 422) {
                                $.each(err.responseJSON.errors, function (x, error) {
                                    var validator = $("#quickForm").validate();
                                    var errors = {}
                                    errors[x] = error[0];
                                    validator.showErrors(errors);
                                });
                            }
                        }
                    }).then(function(){
                        $("#status_"+(parseInt(this.datass.data.ct1_detailbiayakegiatan[this.indexValue-1].no_seq)+1)+"").val(this.datass.data.ct1_detailbiayakegiatan[this.indexValue-1].status);

                        
                        $("#status_"+(parseInt(this.datass.data.ct1_detailbiayakegiatan[this.indexValue-1].no_seq)+1)).val(this.datass.data.ct1_detailbiayakegiatan[this.indexValue-1].status).select2().trigger("change");
                    });

                    $("#caktable1 > tbody").find("[row-seq="+(parseInt(data.data.ct1_detailbiayakegiatan[i].no_seq)+1)+"]").find("td:eq(0)").text(data.data.ct1_detailbiayakegiatan[i].coa);
                    $("select[name='coa_"+(parseInt(data.data.ct1_detailbiayakegiatan[i].no_seq)+1)+"']").empty();
                    var newState = new Option(data.data.ct1_detailbiayakegiatan[i].coa_label, data.data.ct1_detailbiayakegiatan[i].coa, true, false);
                    $("#coa_"+(parseInt(data.data.ct1_detailbiayakegiatan[i].no_seq)+1)+"").append(newState).trigger('change');
                    // @if($page_data["page_method_name"] == "View")
                    //     $("#coa_"+(parseInt(data.data.ct1_detailbiayakegiatan[i].no_seq)+1)+"").attr("disabled", true); 
                    // @endif

                    $("input[name='deskripsi_"+(parseInt(data.data.ct1_detailbiayakegiatan[i].no_seq)+1)+"']").val(data.data.ct1_detailbiayakegiatan[i].deskripsibiaya);

                    //console.log(data.data.ct1_detailbiayakegiatan[i].nominalbiaya);
                    AutoNumeric.getAutoNumericElement('#nom_'+(parseInt(data.data.ct1_detailbiayakegiatan[i].no_seq)+1)).set(data.data.ct1_detailbiayakegiatan[i].nominalbiaya);
                    $("input[name='nom_"+(parseInt(data.data.ct1_detailbiayakegiatan[i].no_seq)+1)+"']").trigger("change");
                    $("#caktable1 > tbody > tr[row-seq="+(parseInt(data.data.ct1_detailbiayakegiatan[i].no_seq)+1)+"]").find("td:eq(7)").text(data.data.ct1_detailbiayakegiatan[i].id);
                    
                    $("input[name='komentarrevisi_"+(parseInt(data.data.ct1_detailbiayakegiatan[i].no_seq)+1)+"']").val(data.data.ct1_detailbiayakegiatan[i].komentarrevisi);
                }
            }

            if(data.data.ct3_outputrka.length > 0){
                $("#caktable3 > tbody > tr").each(function(index){
                    $(this).remove();
                });
                
                for(var i = 0; i < data.data.ct3_outputrka.length; i++){
                    addRow3();
                    $("#caktable3 > tbody").find("[row-seq="+(parseInt(data.data.ct3_outputrka[i].no_seq)+1)+"]").find("td:eq(0)").text(data.data.ct3_outputrka[i].iku);
                    $("select[name='iku_"+(parseInt(data.data.ct3_outputrka[i].no_seq)+1)+"']").empty();
                    var newState = new Option(data.data.ct3_outputrka[i].iku_label, data.data.ct3_outputrka[i].iku, true, false);
                    $("#iku_"+(parseInt(data.data.ct3_outputrka[i].no_seq)+1)+"").append(newState).trigger('change');

                    $("input[name='indikator_"+(parseInt(data.data.ct3_outputrka[i].no_seq)+1)+"']").val(data.data.ct3_outputrka[i].indikator);

                    $("input[name='keterangan_"+(parseInt(data.data.ct3_outputrka[i].no_seq)+1)+"']").val(data.data.ct3_outputrka[i].keterangan);

                    //console.log(data.data.ct3_outputrka[i].target);
                    AutoNumeric.getAutoNumericElement('#nom3_'+(parseInt(data.data.ct3_outputrka[i].no_seq)+1)).set(data.data.ct3_outputrka[i].target);
                    $("input[name='nom3_"+(parseInt(data.data.ct3_outputrka[i].no_seq)+1)+"']").trigger("change");
                    $("input[name='satuan_target_"+(parseInt(data.data.ct3_outputrka[i].no_seq)+1)+"']").val(data.data.ct3_outputrka[i].satuan_target);
                    $("#caktable3 > tbody > tr[row-seq="+(parseInt(data.data.ct3_outputrka[i].no_seq)+1)+"]").find("td:eq(7)").text(data.data.ct3_outputrka[i].id);
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

    @if($page_data["page_method_name"] != "View")
    $("#"+childtablename+" .modal-footer").html('<button type="button" id="staticBackdropAdd_ct1_detailbiayakegiatan" class="btn btn-primary">Add Row</button>');
    @endif

    $("#staticBackdropAdd_ct1_detailbiayakegiatan").click(function(e){
        e.preventDefault;
        // var dttb = $('#ctct1_detailbiayakegiatan').DataTable();

        var no_seq = dttb.rows().count();
        var coa = $("select[name='coa'] option").filter(':selected').val();
        if(!coa){
            coa = null;
        }
        var coa_label = $("input[name='coa_label']").val();
        var deskripsibiaya = $("textarea[name='deskripsibiaya']").val();
        var nominalbiaya = anObject["nominalbiaya"].rawValue;

        var child_table_data = [no_seq+1, coa, coa_label, deskripsibiaya, nominalbiaya, '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>     <div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>', null];

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
        // var dttb = $('#ctct2_approval').DataTable();

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

function processapprove(status, komentar = ""){
    <?php if($page_data["page_method_name"] == "View"){ ?>
    var stop_submit = false;
    var ctct1_detailbiayakegiatan = [];
    $("#caktable1 > tbody > tr").each(function(index, tr){
        if(AutoNumeric.getNumber("#nom_"+$(tr).attr("row-seq")) <= 0 && $("#coa_"+$(tr).attr("row-seq")).val() != null){
            $("#nom_"+$(tr).attr("row-seq")).addClass("border-danger");
            cto_loading_hide();
            stop_submit = true;
            return;
        }
        
        var iku = 0;
        var iku_label = $("#iku").val();
        //var tanggal = $("input[name=tanggal_jurnal]").val();
        var coa = 0;
        var coa_label = "";
        var deskripsibiaya = "";
        var nominalbiaya = 0;
        var id = "";
        var komentarrevisi = "";
        var status = "";
        $(tr).find("td").each(function(index, td){
            if(index == 0){
                coa = $(td).text();
            }else if(index == 1){
                coa_label = $(td).find("select").text();
                // coa_label = "";
            }else if(index == 2){
                deskripsibiaya = $(td).find("input").val();
            }else if(index == 3){
                nominalbiaya = AutoNumeric.getNumber("#nom_"+$(tr).attr("row-seq"));
            }else if(index == 7){
                id = $(td).text();
                console.log(id);
            }else if(index == 6){
                komentarrevisi = $(td).find("input").val();
            }else if(index == 5){
                status = $(td).find("select").val();
            }
            console.log(index);
            console.log(td);
        });
        if(coa != '')
            ctct1_detailbiayakegiatan.push({"no_seq": index, "coa": coa, "coa_label": coa_label, "deskripsibiaya": deskripsibiaya, "nominalbiaya": nominalbiaya, "id": id, "komentarrevisi": komentarrevisi, "status": status});
    });

    
    if(stop_submit){
        return;
    }
    
    var ct1_detailbiayakegiatan = JSON.stringify(ctct1_detailbiayakegiatan);

    stop_submit = false;
    var ctct3_outputrka = [];
    $("#caktable3 > tbody > tr").each(function(index, tr){
        if(AutoNumeric.getNumber("#nom3_"+$(tr).attr("row-seq")) <= 0){
            $("#nom3_"+$(tr).attr("row-seq")).addClass("border-danger");
            cto_loading_hide();
            stop_submit = true;
            return;
        }
        
        var iku = 0;
        var iku_label = "";
        var indikator = "";
        var keterangan = "";
        var target = 0;
        var satuan_target = "";
        var id = 0;
        $(tr).find("td").each(function(index, td){
            if(index == 0){
                iku = $(td).text();
            }else if(index == 1){
                iku_label = $(td).find("select").text();
            }else if(index == 2){
                indikator = $(td).find("input").val();
            }else if(index == 3){
                keterangan = $(td).find("input").val();
            }else if(index == 4){
                target = AutoNumeric.getNumber("#nom3_"+$(tr).attr("row-seq"));
            }else if(index == 5){
                satuan_target = $(td).find("input").val();
            }else if(index == 7){
                id = $(td).text();
            }
        });
        if(coa != '')
            ctct3_outputrka.push({"no_seq": index, "iku" : iku, "iku_label" : iku_label, "indikator": indikator, "keterangan": keterangan, "target": target, "satuan_target": satuan_target, "id": id});
    });

    
    if(stop_submit){
        return;
    }
    
    var ct3_outputrka = JSON.stringify(ctct3_outputrka);

    var status_approval_label = "";
    $("#status_approval option").each(function(i, x){
        if(status == $(x).val())
            status_approval_label = $(x).text();
    });

    $.ajax({
        url:"/processapprove",
        method:"POST",
        data: {
            _token                  : $("#quickForm input[name=_token]").val(),
            status_approval         : status,
            status_approval_label   : status_approval_label,
            komentar                : komentar,
            id                      : {{$page_data["id"]}},
            ct1_detailbiayakegiatan : ct1_detailbiayakegiatan,
            ct3_outputrka           : ct3_outputrka
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
    }).then(function(){
        location.reload();
    });
    cto_loading_hide();
    <?php } ?>
}

function processapprove_pengajuan(status, komentar = ""){
    <?php if($page_data["page_method_name"] == "View"){ ?>
    var stop_submit = false;
    var ctct1_detailbiayakegiatan = [];
    $("#caktable1 > tbody > tr").each(function(index, tr){
        if(AutoNumeric.getNumber("#nom_"+$(tr).attr("row-seq")) <= 0 && $("#coa_"+$(tr).attr("row-seq")).val() != null){
            $("#nom_"+$(tr).attr("row-seq")).addClass("border-danger");
            cto_loading_hide();
            stop_submit = true;
            return;
        }
        
        var iku = 0;
        var iku_label = $("#iku").val();
        //var tanggal = $("input[name=tanggal_jurnal]").val();
        var coa = 0;
        var coa_label = "";
        var deskripsibiaya = "";
        var nominalbiaya = 0;
        var id = "";
        var komentarrevisi = "";
        var status = "";
        $(tr).find("td").each(function(index, td){
            if(index == 0){
                coa = $(td).text();
            }else if(index == 1){
                coa_label = $(td).find("select").text();
                // coa_label = "";
            }else if(index == 2){
                deskripsibiaya = $(td).find("input").val();
            }else if(index == 3){
                nominalbiaya = AutoNumeric.getNumber("#nom_"+$(tr).attr("row-seq"));
            }else if(index == 7){
                id = $(td).text();
                console.log(id);
            }else if(index == 6){
                komentarrevisi = $(td).find("input").val();
            }else if(index == 5){
                status = $(td).find("select").val();
            }
            console.log(index);
            console.log(td);
        });
        if(coa != '')
            ctct1_detailbiayakegiatan.push({"no_seq": index, "coa": coa, "coa_label": coa_label, "deskripsibiaya": deskripsibiaya, "nominalbiaya": nominalbiaya, "id": id, "komentarrevisi": komentarrevisi, "status": status});
    });

    
    if(stop_submit){
        return;
    }
    
    var ct1_detailbiayakegiatan = JSON.stringify(ctct1_detailbiayakegiatan);

    stop_submit = false;
    var ctct3_outputrka = [];
    $("#caktable3 > tbody > tr").each(function(index, tr){
        if(AutoNumeric.getNumber("#nom3_"+$(tr).attr("row-seq")) <= 0){
            $("#nom3_"+$(tr).attr("row-seq")).addClass("border-danger");
            cto_loading_hide();
            stop_submit = true;
            return;
        }
        
        var iku = 0;
        var iku_label = "";
        var indikator = "";
        var keterangan = "";
        var target = 0;
        var satuan_target = "";
        var id = 0;
        $(tr).find("td").each(function(index, td){
            if(index == 0){
                iku = $(td).text();
            }else if(index == 1){
                iku_label = $(td).find("select").text();
            }else if(index == 2){
                indikator = $(td).find("input").val();
            }else if(index == 3){
                keterangan = $(td).find("input").val();
            }else if(index == 4){
                target = AutoNumeric.getNumber("#nom3_"+$(tr).attr("row-seq"));
            }else if(index == 5){
                satuan_target = $(td).find("input").val();
            }else if(index == 7){
                id = $(td).text();
            }
        });
        if(coa != '')
            ctct3_outputrka.push({"no_seq": index, "iku": iku, "iku_label" : iku_label, "indikator": indikator, "keterangan": keterangan, "target": target, "satuan_target": satuan_target, "id": id});
    });

    
    if(stop_submit){
        return;
    }
    
    var ct3_outputrka = JSON.stringify(ctct3_outputrka);

    var status_approval_label = "";
    $("#status_approval option").each(function(i, x){
        if(status == $(x).val())
            status_approval_label = $(x).text();
    });

    $.ajax({
        url:"/processapprovepengajuan",
        method:"POST",
        data: {
            _token                  : $("#quickForm input[name=_token]").val(),
            status_approval         : status,
            status_approval_label   : status_approval_label,
            komentar                : komentar,
            id                      : {{$page_data["id"]}},
            ct1_detailbiayakegiatan : ct1_detailbiayakegiatan,
            ct3_outputrka           : ct3_outputrka
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
    }).then(function(){
        location.reload();
    });
    cto_loading_hide();
    <?php } ?>
}

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

// ========== INLINE TABLE ==========
$(document).keydown(function(event) {
    var rowlen = 0;
    

    if((event.ctrlKey || event.metaKey) && event.which == 66) {
        addRow()
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

    $(".row-delete3").click(function(){
        var $td = $(this).parent();
        var $tr = $($td).parent();
        $($tr).remove();
    });

    $(".addnewrowselect").select2({
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

    $(".addnewrowselect").on("change", function() {
        var $td = $(this).parent();
        var $tr = $($td).parent();
        $($tr).find("td:eq(0)").text($(this).val());
    });

    // $(".cakautonumeric").on("change", function(){
    //     if(AutoNumeric.getNumber("#nom_"+$(this).attr("id").split("_")[1]) > 0){
    //         $("#nom_"+$(this).attr("id").split("_")[1]).addClass("border-danger");
    //     }else{
    //         $("#nom_"+$(this).attr("id").split("_")[1]).removeClass("border-danger");
    //     }
    //     calcTotal();
    // });

    $("#addrow").click(function(){
        addRow();
    });

    $("#addrow3").click(function(){
        addRow3();
    });

    function addRow(){
        rowlen = 1;
        if($('#caktable1 > tbody > tr').length > 0){
            rowlen = parseInt($('#caktable1 > tbody > tr:last').attr('row-seq'))+1;
        }
         

        var rowaddlen = 0;
        $("#caktable1").find('tbody')
            .append(
                @if($page_data["page_method_name"] == "View")
                    "<tr row-seq=\""+rowlen+"\" class=\"addnewrow\">"
                    +"<td class=\"column-hidden\"></td>"
                    +"<td class=\"p-0\"><select name=\"coa_"+rowlen+"\" id=\"coa_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%; overflow: hidden; white-space: nowrap;\"></select></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"deskripsi_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"deskripsi_"+rowlen+"\"></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"nom_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"nom_"+rowlen+"\" placeholder=\"Enter Nominal\"></td>"
                    +"<td class=\"column-hidden\"></td>"
                    +"<td class=\"p-0\"><select name=\"status_"+rowlen+"\" id=\"status_"+rowlen+"\" class=\"status_acc form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%;\"></select></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"komentarrevisi_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"komentarrevisi_"+rowlen+"\"></td>"
                    +"<td class=\"column-hidden\"></td>"
                    // +"<td class=\"p-0 text-center\"><button type=\"button\" id=\"row_show_history_"+rowlen+"\" class=\"bg-white border-0 row-show-history\"><i class=\"text-info fas fa-list\" style=\"cursor: pointer;\"></i></button></td>"
                    +"</tr>"
                @else 
                    "<tr row-seq=\""+rowlen+"\" class=\"addnewrow\">"
                    +"<td class=\"column-hidden\"></td>"
                    +"<td class=\"p-0\"><select name=\"coa_"+rowlen+"\" id=\"coa_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%; overflow: hidden; white-space: nowrap;\"></select></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"deskripsi_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"deskripsi_"+rowlen+"\"></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"nom_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"nom_"+rowlen+"\" placeholder=\"Enter Nominal\"></td>"
                    +"<td class=\"p-0 text-center\"><button id=\"row_delete_"+rowlen+"\" class=\"bg-white border-0\"><i class=\"text-danger fas fa-minus-circle row-delete\" style=\"cursor: pointer;\"></i></button></td>"
                    +"<td class=\"column-hidden\"></td>"
                    +"</tr>"
                @endif
            );
        rowaddlen = $('#caktable1 tr.addnewrow').length

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

        var noms = new AutoNumeric("#nom_"+rowlen, {
            currencySymbol : 'Rp ',
            decimalCharacter : ',',
            digitGroupSeparator : '.',
            minimumValue : 0,
            decimalPlaces : 2,
            unformatOnSubmit : true
        });

        $("#nom_"+rowlen+"").on("change", function(){
            calcTotal();
        });

        $("#coa_"+rowlen+"").select2({
            width: '100%',
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

        @if($page_data["page_method_name"] == "View")
        // $("#caktable1 > tbody > tr").each(function(index, tr){
        //     var rownum = $(tr).attr("row-seq");
        //     var dts = [];
        //     $("#status_"+rownum+"").on("change", function(){
        //         if($("#status_"+rownum+"").val() == "revisi"){
        //             $("#coa_"+rownum+"").prop("disabled", false);
        //             $("#deskripsi_"+rownum+"").prop("readonly", false);
        //             $("#nom_"+rownum+"").prop("readonly", false);
        //             $("#komentarrevisi_"+rownum+"").prop("readonly", false);

        //             var dt = [];
        //             dt["coa"] = $("#coa_"+rownum+"").val();
        //             dt["coa_label"] = $("#coa_"+rownum+"").text();
        //             dt["deskripsi"] = $("#deskripsi_"+rownum+"").val();
        //             dt["nom"] = $("#nom_"+rownum+"").val();
        //             dt["komentarrevisi"] = $("#komentarrevisi_"+rownum+"").val();
        //             dts[rownum] = dt;
        //         }else{
        //             if(rownum && dts[rownum]){
        //                 var dt = dts[rownum];
        //                 $("#coa_"+rownum+"").val(dt["coa"]).trigger("change");
        //                 //dt["coa_label"] = $("#coa_"+rownum+"").text();
        //                 $("#deskripsi_"+rownum+"").val(dt["deskripsi"]);
        //                 AutoNumeric.getAutoNumericElement("#nom_"+rownum+"").set(dt["nom"]);
        //                 calcTotal();
        //                 $("#komentarrevisi_"+rownum+"").val(dt["komentarrevisi"]);
        //             }

        //             $("#coa_"+rownum+"").prop("disabled", true);
        //             $("#deskripsi_"+rownum+"").prop("readonly", true);
        //             $("#nom_"+rownum+"").prop("readonly", true);
        //             $("#komentarrevisi_"+rownum+"").prop("readonly", true);                   
        //         }
        //     });
        // });
        @endif
    }

    function addRow3(){
        rowlen = 1;
        if($('#caktable3 > tbody > tr').length > 0){
            rowlen = parseInt($('#caktable3 > tbody > tr:last').attr('row-seq'))+1;
        }
         

        var rowaddlen = 0;
        $("#caktable3").find('tbody')
            .append(
                @if($page_data["page_method_name"] == "View")
                    "<tr row-seq=\""+rowlen+"\" class=\"addnewrow3\">"
                    +"<td class=\"column-hidden\"></td>"
                    +"<td class=\"p-0\"><select name=\"iku_"+rowlen+"\" id=\"iku_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%; overflow: hidden; white-space: nowrap;\"></select></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"indikator_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"indikator_"+rowlen+"\"></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"keterangan_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"keterangan_"+rowlen+"\"></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"nom3_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"nom3_"+rowlen+"\" placeholder=\"Enter Nominal\"></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"satuan_target_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"satuan_target_"+rowlen+"\"></td>"
                    +"<td class=\"p-0 text-center\"><button id=\"row_delete3_"+rowlen+"\" class=\"bg-white border-0\"><i class=\"text-danger fas fa-minus-circle row-delete\" style=\"cursor: pointer;\"></i></button></td>"
                    +"<td class=\"column-hidden\"></td>"
                    +"</tr>"
                @else 
                    "<tr row-seq=\""+rowlen+"\" class=\"addnewrow3\">"
                    +"<td class=\"column-hidden\"></td>"
                    +"<td class=\"p-0\"><select name=\"iku_"+rowlen+"\" id=\"iku_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%; overflow: hidden; white-space: nowrap;\"></select></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"indikator_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"indikator_"+rowlen+"\"></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"keterangan_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"keterangan_"+rowlen+"\"></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"nom3_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"nom3_"+rowlen+"\" placeholder=\"Enter Nominal\"></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"satuan_target_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"satuan_target_"+rowlen+"\"></td>"
                    +"<td class=\"p-0 text-center\"><button id=\"row_delete3_"+rowlen+"\" class=\"bg-white border-0\"><i class=\"text-danger fas fa-minus-circle row-delete\" style=\"cursor: pointer;\"></i></button></td>"
                    +"<td class=\"column-hidden\"></td>"
                    +"</tr>"
                @endif
            );
        rowaddlen = $('#caktable3 tr.addnewrow3').length

        $("#row_delete3_"+rowlen).on('click', function(){
            var $td = $(this).parent();
            var $tr = $($td).parent();
            $($tr).remove();
        });

        var noms = new AutoNumeric("#nom3_"+rowlen, {
            decimalCharacter : ',',
            digitGroupSeparator : '.',
            minimumValue : 0,
            decimalPlaces : 2,
            unformatOnSubmit : true
        });

        $("#iku_"+rowlen+"").on("change", function() {
            var $td = $(this).parent();
            var $tr = $($td).parent();
            $($tr).find("td:eq(0)").text($(this).val());
        });

        $("#iku_"+rowlen+"").select2({
            width: '100%',
            ajax: {
                url: "/getlinkskegiatan",
                type: "post",
                dataType: "json",
                data: function(params) {
                    return {
                        term: params.term || "",
                        page: params.page,
                        field: "iku",
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

    }
    
    
    $("#staticBackdropClose_transaksi").click(function(){
        $("#staticBackdrop_transaksi").modal("hide");
    });

    

    function calcTotal(){
        var totalnom = 0;
        $("#caktable1 > tbody > tr").each(function(index, tr){
            totalnom += AutoNumeric.getNumber("#nom_"+$(tr).attr("row-seq"));
        });
        $("#totalnom").text('Rp '+totalnom.toLocaleString('id'));
    }
    
    $('input[name=tanggal_kegiatan]').pickadate({
        format: 'dd/mm/yyyy',
        formatSubmit: 'yyyy-mm-dd',
        //hiddenName: true,
        onStart: function(){
            var date = new Date();
                this.set('select', date.getFullYear()+"-"+(date.getMonth()+1)+"-"+ date.getDate(), { format: 'yyyy-mm-dd' });
        },
        onOpen: function(){
            var $input = $('.datepicker-default');
            if ($input.hasClass('picker__input--target')) {
                $input.pickadate().pickadate('picker').close(true);
            }
        }
    });

    $('input[name=tanggal_pencairan]').pickadate({
        format: 'dd/mm/yyyy',
        formatSubmit: 'yyyy-mm-dd',
        //hiddenName: true,
        onStart: function(){
            var date = new Date();
                this.set('select', date.getFullYear()+"-"+(date.getMonth()+1)+"-"+ date.getDate(), { format: 'yyyy-mm-dd' });
        },
        onOpen: function(){
            var $input = $('.datepicker-default');
            if ($input.hasClass('picker__input--target')) {
                $input.pickadate().pickadate('picker').close(true);
            }
        }
    });

    $.validator.setDefaults({
        submitHandler: function (form, event) {
            event.preventDefault();
            cto_loading_show();
            var quickForm = $("#quickForm");
            var ctct1_detailbiayakegiatan = [];

            var unitpelaksana = $("#unitpelaksana").val();
            var unitpelaksana_label = $("#unitpelaksana_label").val();
            var stop_submit = false;
            $("#caktable1 > tbody > tr").each(function(index, tr){
                if(AutoNumeric.getNumber("#nom_"+$(tr).attr("row-seq")) <= 0 && $("#coa_"+$(tr).attr("row-seq")).val() != null){
                    $("#nom_"+$(tr).attr("row-seq")).addClass("border-danger");
                    cto_loading_hide();
                    stop_submit = true;
                    return;
                }
                
                
                var iku = 0;
                var iku_label = $("#iku").val();
                //var tanggal = $("input[name=tanggal_jurnal]").val();
                var coa = 0;
                var coa_label = "";
                var deskripsibiaya = "";
                var nominalbiaya = 0;
                var id = "";
                $(tr).find("td").each(function(index, td){
                    if(index == 0){
                        coa = $(td).text();
                    }else if(index == 1){
                        coa_label = $(td).find("select").text();
                        // coa_label = "";
                    }else if(index == 2){
                        deskripsibiaya = $(td).find("input").val();
                    }else if(index == 3){
                        nominalbiaya = AutoNumeric.getNumber("#nom_"+$(tr).attr("row-seq"));
                    }else if(index == 7){
                        id = $(td).text();
                    }
                });
                if(coa != '')
                    ctct1_detailbiayakegiatan.push({"no_seq": index, "coa": coa, "coa_label": coa_label, "deskripsibiaya": deskripsibiaya, "nominalbiaya": nominalbiaya, "id": id});
            });

            
            if(stop_submit){
                return;
            }
            
            $("#ct1_detailbiayakegiatan").val(JSON.stringify(ctct1_detailbiayakegiatan));
                
            stop_submit = false;
            var ctct3_outputrka = [];
            $("#caktable3 > tbody > tr").each(function(index, tr){
                if(AutoNumeric.getNumber("#nom3_"+$(tr).attr("row-seq")) <= 0){
                    $("#nom3_"+$(tr).attr("row-seq")).addClass("border-danger");
                    cto_loading_hide();
                    stop_submit = true;
                    return;
                }
                
                var iku = 0;
                var iku_label = "";
                var indikator = "";
                var keterangan = "";
                var target = 0;
                var satuan_target = "";
                var id = 0;
                $(tr).find("td").each(function(index, td){
                    if(index == 0){
                        iku = $(td).text();
                    }else if(index == 1){
                        iku_label = $(td).find("select").text();
                    }else if(index == 2){
                        indikator = $(td).find("input").val();
                    }else if(index == 3){
                        keterangan = $(td).find("input").val();
                    }else if(index == 4){
                        target = AutoNumeric.getNumber("#nom3_"+$(tr).attr("row-seq"));
                    }else if(index == 5){
                        satuan_target = $(td).find("input").val();
                    }else if(index == 7){
                        id = $(td).text();
                    }
                });
                if(coa != '')
                    ctct3_outputrka.push({"no_seq": index, "iku": iku, "iku_label": iku_label, "indikator": indikator, "keterangan": keterangan, "target": target, "satuan_target": satuan_target, "id": id});
            });

            
            if(stop_submit){
                return;
            }
            
            var ct3_outputrka = JSON.stringify(ctct3_outputrka);
            $("#ct3_outputrka").val(JSON.stringify(ctct3_outputrka));

            // var id_jurnal = 0;
            var values = $("#quickForm").serializeArray();
            // for (index = 0; index < values.length; ++index) {
            //     if (values[index].name == "tanggal_kegiatan") {
            //         values[index].value = $("input[name=tanggal_kegiatan]").val().split("/")[2]+"-"+ $("input[name=tanggal_jurnal]").val().split("/")[1]+"-"+ $("input[name=tanggal_jurnal]").val().split("/")[0];
            //         break;
            //     }
            // }

            values = jQuery.param(values);

            var ajaxRequest;
            // var urlpage = "{{ env('APP_URL') }}/storejurnal";
            // if($("#is_edit").val() == 1){
            //     urlpage = "{{ env('APP_URL') }}/updatejurnal/"+$("#id_jurnal").val();
            // }
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
                        id_jurnal = data.data.id;
                        // $("#id_jurnal").val(data.data.id);
                        $("#is_edit").val(1);
                        // $("#no_jurnal").val(data.data.no_jurnal);
                        
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
                },
                error: function (err) {
                    if (err.status == 422) {
                        $.each(err.responseJSON.errors, function (i, error) {
                            var validator = $("#quickForm").validate();
                            var errors = {};
                            if(i == "coa" || i == "coa_label" || i == "deskripsibiaya" || i == "nominalbiaya"){
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
            }).then(function(){
                //location.reload();
            });
        }
    });

    function plafonanggaran(){
        var uk = $("#unit_pelaksana").val();
        var tk = $("input[name=tanggal_kegiatan]").val();

        if(!tk || !uk){
            return;
        }
        $.ajax({
            url: "/getdatakegiatanplafon",
            type: "post",
            data: {
                unitkerja: uk,
                tanggal_kegiatan: tk,
                _token: $("#quickForm input[name=_token]").val()
            },
            success: function(data){
                $("#valplafon").text(formatNumber(parseFloat(data.data.valplafon), ''));
                $("#valprocess").text(formatNumber(parseFloat(data.data.valprocess), ''));
                $("#valapproved").text(formatNumber(parseFloat(data.data.valapproved), ''));
                $("#valsubmitted").text(formatNumber(parseFloat(data.data.valsubmitted), ''));
                $("#valpaid").text(formatNumber(parseFloat(data.data.valpaid), ''));
                $("#valpjkprocess").text(formatNumber(parseFloat(data.data.valpjkprocess), ''));
                $("#valpjkapproved").text(formatNumber(parseFloat(data.data.valpjkapproved), ''));
                $("#valsisa").text(formatNumber(parseFloat(data.data.valsisa), ''));
            },
            error: function (err) {
                $("#historykegiatan").removeClass("spinner-border");
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
            }
        });
    }
 
</script>