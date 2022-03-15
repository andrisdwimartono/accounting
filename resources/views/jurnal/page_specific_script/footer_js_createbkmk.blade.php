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
    <!-- <script src="{{ asset ("/assets/datatables/js/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset ("/assets/datatables/js/dataTables.bootstrap4.min.js") }}"></script>
    <script src="{{ asset ("/assets/datatables/js/dataTables.rowReorder.min.js") }}"></script>
    <script src="{{ asset ("/assets/datatables/js/dataTables.buttons.min.js") }}"></script> -->
    <script src="{{ asset ("/assets/cto/js/cakrudtemplate.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/cto_loadinganimation.min.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/dateformatvalidation.min.js") }}"></script>
<script>
    var app_url = '{{ env('APP_URL') }}';
    var editor;
    const anElement = AutoNumeric.multiple('.cakautonumeric-float', {
        currencySymbol : 'Rp ',
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

    // anObject["debet"].settings.minimumValue = 0;
    // anObject["credit"].settings.minimumValue = 0;

$(function () {
    $('input[name=tanggal_jurnal], input[name=tanggal_jurnal_from], input[name=tanggal_jurnal_to]').pickadate({
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

    $(".print").click(function(){
        var url = '/jurnalbkmk/print';
        var form = $('<form action="' + url + '" target="_blank" method="post">' +
                      '<input type="hidden" name="_token" value="'+$("input[name=_token]").val()+'" />' +
                      '<input type="hidden" name="search[tanggal_jurnal_from]" value="'+$("#tanggal_jurnal_from").val()+'" />' +
                      '<input type="hidden" name="search[tanggal_jurnal_to]" value="'+$("#tanggal_jurnal_to").val()+'" />' +
                      '<input type="hidden" name="search[no_jurnal_search]" value="'+$("#no_jurnal_search").val()+'" />' +
                      '<input type="hidden" name="search[ordering]" value="'+$("#column_no_jurnal").attr("data-ordering")+'" />'+
                      '<input type="hidden" name="search[jurnal_type]" value="'+$("#jurnal_type").val()+'" />' +
                      '</form>');
                   $('body').append(form);
                   form.submit();
    });

    $(".excel").click(function(){
        var url = '/jurnalbkmk/excel';
        var form = $('<form action="' + url + '" target="_blank" method="post">' +
                      '<input type="hidden" name="_token" value="'+$("input[name=_token]").val()+'" />' +
                      '<input type="hidden" name="search[tanggal_jurnal_from]" value="'+$("#tanggal_jurnal_from").val()+'" />' +
                      '<input type="hidden" name="search[tanggal_jurnal_to]" value="'+$("#tanggal_jurnal_to").val()+'" />' +
                      '<input type="hidden" name="search[no_jurnal_search]" value="'+$("#no_jurnal_search").val()+'" />' +
                      '<input type="hidden" name="search[ordering]" value="'+$("#column_no_jurnal").attr("data-ordering")+'" />'+
                      '<input type="hidden" name="search[jurnal_type]" value="'+$("#jurnal_type").val()+'" />' +
                      '</form>');
                   $('body').append(form);
                   form.submit();
    });

    $.validator.setDefaults({
        submitHandler: function (form, event) {
            event.preventDefault();
            cto_loading_show();
            var quickForm = $("#quickForm");
            var cttransaksi = [];
            
            // if(parseFloat($("#totalselisih").text().replace("Rp ", "").replace(".", "").replace(",", ".")) != 0){
            //     $("#caktable1_message").html("Debet Kredit masih ada selisih!");
            //     $("#caktable1_message").removeClass("d-none");
            //     cto_loading_hide();
            //     return;
            // }else{
            //     $("#caktable1_message").html("");
            //     $("#caktable1_message").addClass("d-none");
            // }

            var unitkerja = $("#unitkerja").val();
            var unitkerja_label = $("#unitkerja_label").val();
            var stop_submit = false;
            $("#caktable1 > tbody > tr").each(function(index, tr){
                if((AutoNumeric.getNumber("#debet_"+$(tr).attr("row-seq")) > 0 && AutoNumeric.getNumber("#kredit_"+$(tr).attr("row-seq")) > 0) || (AutoNumeric.getNumber("#debet_"+$(tr).attr("row-seq")) <= 0 && AutoNumeric.getNumber("#kredit_"+$(tr).attr("row-seq")) <= 0 && $("#coa_"+$(tr).attr("row-seq")).val() != null)){
                    $("#debet_"+$(tr).attr("row-seq")).addClass("border-danger");
                    $("#kredit_"+$(tr).attr("row-seq")).addClass("border-danger");
                    cto_loading_hide();
                    stop_submit = true;
                    return;
                }

                if(AutoNumeric.getNumber("#debet_"+$(tr).attr("row-seq")) == 0 && AutoNumeric.getNumber("#kredit_"+$(tr).attr("row-seq")) == 0 && $("#coa_"+$(tr).attr("row-seq")).val() == null){
                    return true;
                }
                
                
                var anggaran = 0;
                var anggaran_label = $("#anggaran_label").val();
                //var tanggal = $("input[name=tanggal_jurnal]").val();
                var coa = 0;
                var coa_label = "";
                var keterangan = "";
                var deskripsi = "";
                var jenisbayar = 0;
                var jenisbayar_label = "";
                var nim = "";
                var kode_va = "";
                var fheader = "";
                var debet = 0;
                var credit = 0;
                var id = "";
                $(tr).find("td").each(function(index, td){
                    if(index == 0){
                        coa = $(td).text();
                    }else if(index == 1){
                        //coa_label = $(td).find("select").text();
                        coa_label = "";
                    }else if(index == 2){
                        deskripsi = $(td).find("input").val();
                    }else if(index == 3){
                        debet = AutoNumeric.getNumber("#debet_"+$(tr).attr("row-seq"));
                    }else if(index == 4){
                        credit = AutoNumeric.getNumber("#kredit_"+$(tr).attr("row-seq"));
                    }else if(index == 6){
                        id = $(td).text();
                    }
                });
                cttransaksi.push({"no_seq": index, "unitkerja": unitkerja, "unitkerja_label": unitkerja_label, "anggaran": anggaran, "anggaran_label": anggaran_label, "no_jurnal": "", "keterangan": keterangan, "jenis_transaksi": "", "coa": coa, "coa_label": coa_label, "deskripsi": deskripsi, "jenisbayar": jenisbayar, "jenisbayar_label": jenisbayar_label, "nim": nim, "kode_va": kode_va, "fheader": fheader, "debet": debet, "credit": credit, "id": id});
            });
            
            if(stop_submit){
                return;
            }
            
            $("#transaksi").val(JSON.stringify(cttransaksi));
            
            var id_jurnal = 0;
            var values = $("#quickForm").serializeArray();
            for (index = 0; index < values.length; ++index) {
                if (values[index].name == "tanggal_jurnal") {
                    values[index].value = $("input[name=tanggal_jurnal]").val().split("/")[2]+"-"+ $("input[name=tanggal_jurnal]").val().split("/")[1]+"-"+ $("input[name=tanggal_jurnal]").val().split("/")[0];
                    break;
                }
            }

            values = jQuery.param(values);

            var ajaxRequest;
            var urlpage = "{{ env('APP_URL') }}/storejurnalbkmk";
            if($("#is_edit").val() == 1){
                urlpage = "{{ env('APP_URL') }}/updatejurnalbkmk/"+$("#id_jurnal").val();
            }
            ajaxRequest = $.ajax({
                url: urlpage,
                type: "post",
                data: values,
                success: function(data){
                    if(data.status >= 200 && data.status <= 299){
                        id_jurnal = data.data.id;
                        $("#id_jurnal").val(data.data.id);
                        $("#is_edit").val(1);
                        $("#no_jurnal").val(data.data.no_jurnal);
                        
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
                    getlist();
                },
                error: function (err) {
                    if (err.status == 422) {
                        $.each(err.responseJSON.errors, function (i, error) {
                            var validator = $("#quickForm").validate();
                            var errors = {};
                            if(i == "unitkerja" || i == "unitkerja_label" || i == "anggaran" || i == "anggaran_label" || i == "no_jurnal" || i == "tanggal" || i == "keterangan" || i == "jenis_transaksi" || i == "coa" || i == "coa_label" || i == "deskripsi" || i == "jenisbayar" || i == "jenisbayar_label" || i == "nim" || i == "kode_va" || i == "fheader" || i == "debet" || i == "credit"){
                                errors["transaksi"] += error[0];
                            }else{
                                errors[i] = error[0];
                            }
                            if(errors["transaksi"] != ""){
                                $.toast({
                                    text: errors["transaksi"],
                                    heading: 'Status',
                                    icon: 'Warning',
                                    showHideTransition: 'fade',
                                    allowToastClose: true,
                                    hideAfter: 3000,
                                    position: 'mid-center',
                                    textAlign: 'left'
                                });
                            }
                            validator.showErrors(errors);
                        });
                    }else{
                        $.toast({
                            text: err.responseJSON.message,
                            heading: err.responseJSON.statusText,
                            icon: 'Warning',
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

$("#bank_kas").on("change", function() {
    $("#bank_kas_label").val($("#bank_kas option:selected").text());
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
        url: "{{ env('APP_URL') }}/getlinksjurnal",
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
        url: "{{ env('APP_URL') }}/getlinksjurnal",
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

$("#bank_kas").select2({
    ajax: {
        url: "{{ env('APP_URL') }}/getlinksjurnal",
        type: "post",
        dataType: "json",
        data: function(params) {
            return {
                term: params.term || "",
                page: params.page,
                field: "coa",
                jurnal_type: $("#jurnal_type").val(),
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

$("#jenisbayar").select2({
    ajax: {
        url: "{{ env('APP_URL') }}/getlinksjurnal",
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
    //<?=isset($page_data["page_job"])?" ".$page_data["page_job"]:""?>
    getlist();
    $("#no_jurnal_search, #tanggal_jurnal_from, #tanggal_jurnal_to").change(function(){
        getlist();
    });

    $("#column_no_jurnal").click(function(){
        if($(this).attr("data-ordering") == "desc"){
            $(this).attr("data-ordering", "asc");
            $("#logo_column_no_jurnal").text("↟");
        }else{
            $(this).attr("data-ordering", "desc");
            $("#logo_column_no_jurnal").text("↡");
        }
        getlist();
    });

    $(document).keydown(function(event) {
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
            url: "{{ env('APP_URL') }}/getlinksjurnal",
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

    $("#addrow").click(function(){
        var rowlen = 0;
        if($('#caktable1 > tbody > tr').length > 0){
            rowlen = parseInt($('#caktable1 > tbody > tr:last').attr('row-seq'))+1;
        }
         

        var rowaddlen = 0;
        $("#caktable1").find('tbody')
            .append("<tr row-seq=\""+rowlen+"\" class=\"addnewrow\">"
                +"<td class=\"column-hidden\"></td>"
                +"<td class=\"p-0\"><select name=\"coa_"+rowlen+"\" id=\"coa_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%;\"></select></td>"
                +"<td class=\"p-0\"><input type=\"text\" name=\"deskripsi_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"deskripsi_"+rowlen+"\"></td>"
                +"<td class=\"p-0<?=$page_data["page_job"]=="KM"||$page_data["page_job"]=="BM"?" column-hidden":""?>\"><input type=\"text\" name=\"debet_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"debet_"+rowlen+"\" placeholder=\"Enter Debet\"></td>"
                +"<td class=\"p-0<?=$page_data["page_job"]=="KK"||$page_data["page_job"]=="BK"?" column-hidden":""?>\"><input type=\"text\" name=\"kredit_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"kredit_"+rowlen+"\" placeholder=\"Enter Kredit\"></td>"
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
        var kredits = new AutoNumeric("#kredit_"+rowlen, {
            currencySymbol : 'Rp ',
            decimalCharacter : ',',
            digitGroupSeparator : '.',
            minimumValue : 0,
            decimalPlaces : 2,
            unformatOnSubmit : true
        });

        $("#debet_"+rowlen+", #kredit_"+rowlen).on("change", function(){
            if(debets.rawValue > 0 && kredits.rawValue > 0){
                $("#debet_"+rowlen).addClass("border-danger");
                $("#kredit_"+rowlen).addClass("border-danger");
            }else{
                $("#debet_"+rowlen).removeClass("border-danger");
                $("#kredit_"+rowlen).removeClass("border-danger");
            }
            calcTotal();
        });

        $("#coa_"+rowlen+"").select2({
            ajax: {
                url: "{{ env('APP_URL') }}/getlinksjurnal",
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
    });    
    
    $("#createnew").click(function(){
        $("#id_jurnal").val(0);
        $("#is_edit").val(0);
        $('#unitkerja').val(null).trigger('change');
        $("#anggaran_label").val("");
        $("#no_jurnal").val("<?=$page_data["page_job"]?>#######");
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

    $("#simpan_kas_bank").click(function(){
        <?php if($page_data["page_job"]=="KM"){ ?>
            localStorage.setItem("simpan_kas_bank_km_id", $("input[name=bank_kas]").val());
            localStorage.setItem("simpan_kas_bank_km_label", $("input[name=bank_kas_label]").val());
        <?php }elseif($page_data["page_job"]=="KK"){ ?>
            localStorage.setItem("simpan_kas_bank_kk_id", $("input[name=bank_kas]").val());
            localStorage.setItem("simpan_kas_bank_kk_label", $("input[name=bank_kas_label]").val());
        <?php }elseif($page_data["page_job"]=="BM"){ ?>
            localStorage.setItem("simpan_kas_bank_bm_id", $("input[name=bank_kas]").val());
            localStorage.setItem("simpan_kas_bank_bm_label", $("input[name=bank_kas_label]").val());
        <?php }elseif($page_data["page_job"]=="BK"){ ?>
            localStorage.setItem("simpan_kas_bank_bk_id", $("input[name=bank_kas]").val());
            localStorage.setItem("simpan_kas_bank_bk_label", $("input[name=bank_kas_label]").val());
        <?php } ?>
    });

    var simpan_kas_bank_km_id = null;
    var simpan_kas_bank_km_label = null;
    <?php if($page_data["page_job"]=="KM"){ ?>
        simpan_kas_bank_km_id = localStorage.getItem("simpan_kas_bank_km_id");
        simpan_kas_bank_km_label = localStorage.getItem("simpan_kas_bank_km_label");
    <?php }elseif($page_data["page_job"]=="KK"){ ?>
        simpan_kas_bank_km_id = localStorage.getItem("simpan_kas_bank_kk_id");
        simpan_kas_bank_km_label = localStorage.getItem("simpan_kas_bank_kk_label");
    <?php }elseif($page_data["page_job"]=="BM"){ ?>
        simpan_kas_bank_km_id = localStorage.getItem("simpan_kas_bank_bm_id");
        simpan_kas_bank_km_label = localStorage.getItem("simpan_kas_bank_bm_label");
    <?php }elseif($page_data["page_job"]=="BK"){ ?>
        simpan_kas_bank_km_id = localStorage.getItem("simpan_kas_bank_bk_id");
        simpan_kas_bank_km_label = localStorage.getItem("simpan_kas_bank_bk_label");
    <?php } ?>

    if(simpan_kas_bank_km_id){
        $("select[name='bank_kas']").empty();
        var newState = new Option(simpan_kas_bank_km_label, simpan_kas_bank_km_id, true, false);
        $("#bank_kas").append(newState).trigger('change');
        $("input[name='bank_kas_label']").val(simpan_kas_bank_km_label);
    }

    @if($page_data["page_method_name"] == "Update" || $page_data["page_method_name"] == "View")
    getdata();
    @endif
});

function getdata(){
    cto_loading_show();
    $.ajax({
        url: "{{ env('APP_URL') }}/getdatajurnal_bkmk",
        type: "post",
        data: {
            id: $("#id_jurnal").val(),
            //id: 4,
            _token: $("#quickForm input[name=_token]").val(),
            jurnal_type: $("#jurnal_type").val()
        },
        success: function(data){
            for(var i = 0; i < Object.keys(data.data.jurnal).length; i++){
                if(Object.keys(data.data.jurnal)[i] == "unitkerja" || Object.keys(data.data.jurnal)[i] == "bank_kas"){
                    if(data.data.jurnal[Object.keys(data.data.jurnal)[i]]){
                        if(Object.keys(data.data.jurnal)[i] == "bank_kas"){
                            $("select[name='bank_kas']").empty();
                            var newState = new Option(data.data.jurnal[Object.keys(data.data.jurnal)[i]+"_label"], data.data.jurnal[Object.keys(data.data.jurnal)[i]], true, false);
                            $("#"+Object.keys(data.data.jurnal)[i]).append(newState).trigger("change");

                            $("input[name='bank_kas_label']").val(data.data.jurnal[Object.keys(data.data.jurnal)[i]+"_label"]);
                        }else{
                            $("#"+Object.keys(data.data.jurnal)[i]).empty();
                            var newState = new Option(data.data.jurnal[Object.keys(data.data.jurnal)[i]+"_label"], data.data.jurnal[Object.keys(data.data.jurnal)[i]], true, false);
                            $("#"+Object.keys(data.data.jurnal)[i]).append(newState).trigger("change");
                        }
                    }
                }else{
                    if(["ewfsdfsafdsafasdfasdferad"].includes(Object.keys(data.data.jurnal)[i])){
                        $("input[name="+Object.keys(data.data.jurnal)[i]+"]").prop("checked", data.data.jurnal[Object.keys(data.data.jurnal)[i]]);
                    }else if(Object.keys(data.data.jurnal)[i] == "tanggal_jurnal"){
                        $("input[name=tanggal_jurnal]").val(data.data.jurnal["tanggal_jurnal"].split("-")[2]+"/"+data.data.jurnal["tanggal_jurnal"].split("-")[1]+"/"+data.data.jurnal["tanggal_jurnal"].split("-")[0]);
                    }else{
                        try{
                            anObject[Object.keys(data.data.jurnal)[i]].set(data.data.jurnal[Object.keys(data.data.jurnal)[i]]);
                        }catch(err){
                            $("input[name="+Object.keys(data.data.jurnal)[i]+"]").val(data.data.jurnal[Object.keys(data.data.jurnal)[i]]);
                        }
                        $("textarea[name="+Object.keys(data.data.jurnal)[i]+"]").val(data.data.jurnal[Object.keys(data.data.jurnal)[i]]);
                    }
                    $("select[name="+Object.keys(data.data.jurnal)[i]+"]").val(data.data.jurnal[Object.keys(data.data.jurnal)[i]]).change();
                }
            }

            if(data.data.transaksi.length > 0){
                $("#caktable1 > tbody > tr").each(function(index){
                    var row_index = parseInt($(this).attr("row-seq"));
                    if(row_index == 1){
                        $("#caktable1 > tbody > tr[row-seq="+row_index+"]").find("td:eq(0)").text("");
                        $("select[name='coa_"+row_index+"']").empty();
                        $("#caktable1 > tbody > tr[row-seq=1]").find("td:eq(0)").text("");

                        $("input[name='deskripsi_"+row_index+"']").val("");

                        $("input[name='debet_"+row_index+"']").val("0");
                        $("input[name='kredit_"+row_index+"']").val("0");
                        $("#caktable1 > tbody > tr[row-seq="+row_index+"]").find("td:eq(6)").text("");
                        return true;
                    }
                    $(this).remove();
                });
                $("#addrow").trigger("click");
                $("#addrow").trigger("click");
                $("#addrow").trigger("click");
                for(var i = 0; i < data.data.transaksi.length-1; i++){
                    $("input[name=anggaran_label]").val(data.data.transaksi[i].anggaran_label);
                    if(data.data.transaksi[i].no_seq > 3){
                        var trexist = $("#caktable1 > tbody > tr[row-seq="+(parseInt(data.data.transaksi[i].no_seq)+1)+"]").length;
                        while(!trexist){
                            $("#addrow").trigger("click");
                            trexist = $("#caktable1 > tbody > tr[row-seq="+(parseInt(data.data.transaksi[i].no_seq)+1)+"]").length;
                        }
                    }
                    $("#caktable1 > tbody").find("[row-seq="+(parseInt(data.data.transaksi[i].no_seq)+1)+"]").find("td:eq(0)").text(data.data.transaksi[i].coa);
                    $("select[name='coa_"+(parseInt(data.data.transaksi[i].no_seq)+1)+"']").empty();
                    var newState = new Option(data.data.transaksi[i].coa_label, data.data.transaksi[i].coa, true, false);
                    $("#coa_"+(parseInt(data.data.transaksi[i].no_seq)+1)+"").append(newState).trigger('change');

                    $("input[name='deskripsi_"+(parseInt(data.data.transaksi[i].no_seq)+1)+"']").val(data.data.transaksi[i].deskripsi);

                    AutoNumeric.getAutoNumericElement('#debet_'+(parseInt(data.data.transaksi[i].no_seq)+1)).set(data.data.transaksi[i].debet);
                    $("input[name='debet_"+(parseInt(data.data.transaksi[i].no_seq)+1)+"']").trigger("change");
                    AutoNumeric.getAutoNumericElement('#kredit_'+(parseInt(data.data.transaksi[i].no_seq)+1)).set(data.data.transaksi[i].credit);
                    $("input[name='kredit_"+(parseInt(data.data.transaksi[i].no_seq)+1)+"']").trigger("change");
                    $("#caktable1 > tbody > tr[row-seq="+(parseInt(data.data.transaksi[i].no_seq)+1)+"]").find("td:eq(6)").text(data.data.transaksi[i].id);
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

function getlist(){
    cto_loading_show();
    $.ajax({
        url: "{{ env('APP_URL') }}/getlistjurnal_bkmk",
        type: "post",
        data: {
            _token: $("#quickForm input[name=_token]").val(),
            start: 0,
            // length: $("#countcaktable2").val(),
            no_jurnal_search: $("#no_jurnal_search").val(),
            tanggal_jurnal_to: $("input[name=tanggal_jurnal_to]").val().split("/")[2]+"-"+ $("input[name=tanggal_jurnal_to]").val().split("/")[1]+"-"+ $("input[name=tanggal_jurnal_to]").val().split("/")[0],
            tanggal_jurnal_from: $("input[name=tanggal_jurnal_from]").val().split("/")[2]+"-"+$("input[name=tanggal_jurnal_from]").val().split("/")[1]+"-"+$("input[name=tanggal_jurnal_from]").val().split("/")[0],
            ordering: $("#column_no_jurnal").attr("data-ordering"),
            jurnal_type: $("#jurnal_type").val(),
        },
        success: function(data){
            $("#caktable2").find('tbody').empty();
            const dat = JSON.parse(data);
            for(var i = 0; i < dat.data.length; i++){
                $("#caktable2").find('tbody')
                    .append("<tr row-id=\""+dat.data[i][0]+"\" class=\"addnewrow2\" style=\"cursor: pointer;\">"
                        +"<td class=\"column-hidden\">"+dat.data[i][0]+"</td>"
                        +"<td class=\"p-1\">"+dat.data[i][1].split("-")[2]+"/"+dat.data[i][1].split("-")[1]+"/"+dat.data[i][1].split("-")[0]+"</td>"
                        +"<td class=\"p-1\">"+dat.data[i][2]+"</td>"
                        +"<td class=\"p-1\">"+dat.data[i][3]+"</td>"
                        // +"<td class=\"p-0\">"+dat.data[i][4]+"</td>"
                        +"<td class=\"p-0 text-center\"><button id=\"row_delete_"+dat.data[i][0]+"\" type=\"button\" class=\"row-delete-jurnal bg-white border-0\"><i class=\"text-danger fas fa-minus-circle\" style=\"cursor: pointer;\"></i></button></td>"
                        +"<td class=\"column-hidden\"></td>"
                    +"</tr>");
            }
            $(".row-delete-jurnal").click(function(){
                $("#alasan_hapus").removeClass("border-danger");
                $("#alasan_hapus_error").text("");
                $("#alasan_hapus_error").addClass("d-none");
                $("#modal-delete").modal({"show": true});
            });

            $(".addnewrow2").click(function(){
                $("#id_jurnal").val($(this).attr("row-id"));
                $("#is_edit").val(1);
                getdata();
            });

            $(".row-delete-confirmed").click(function(){
                var id_jurnal = $("#id_jurnal").val();
                if($("#alasan_hapus").val() == ""){
                    $("#alasan_hapus").addClass("border-danger");
                    $("#alasan_hapus_error").text("Alasan harus diisi!");
                    $("#alasan_hapus_error").removeClass("d-none");
                    return;
                }else{
                    $("#alasan_hapus").removeClass("border-danger");
                    $("#alasan_hapus_error").text("");
                    $("#alasan_hapus_error").addClass("d-none");
                }
                if(deleting_jurnal(id_jurnal)){
                    getlist();
                    $("#modal-delete").modal('hide');
                }
            });

            
        cto_loading_hide();
    },
        error: function (err) {
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

 function calcTotal(){
     var totaldebet = 0;
     var totalkredit = 0;
     $("#caktable1 > tbody > tr").each(function(index, tr){
        totaldebet += AutoNumeric.getNumber("#debet_"+$(tr).attr("row-seq"));
        totalkredit += AutoNumeric.getNumber("#kredit_"+$(tr).attr("row-seq"));
     });
     $("#totaldebet").text('Rp '+totaldebet.toLocaleString('id'));
     $("#totalkredit").text('Rp '+totalkredit.toLocaleString('id'));
     $("#totalselisih").text('Rp '+(totaldebet-totalkredit).toLocaleString('id'));
     if(totaldebet-totalkredit != 0){
        $("#totalselisih").addClass("border-danger");
        $("#totalselisih").addClass("text-danger");
     }else{
        $("#totalselisih").removeClass("border-danger");
        $("#totalselisih").removeClass("text-danger");
     }
 }

function deleting_jurnal(id_jurnal){
    return $.ajax({
        url: "{{ env('APP_URL') }}/deletejurnal",
        type: "post",
        data: {
            _token: $("input[name=_token]").val(),
            id: id_jurnal,
            alasan_hapus : $("#alasan_hapus").val()
        },
        success: function(data){
            if(data.status >= 200 && data.status <= 299){
                $("#id_jurnal").val(0);
                $("#is_edit").val(0);
                $("#no_jurnal").val("");
                
                $.toast({
                    text: data.message,
                    stack: 1,
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
            return true;
        },
        error: function (err) {
            $.toast({
                text: data.message,
                stack: 1,
                heading: 'Status',
                icon: 'danger',
                showHideTransition: 'fade',
                allowToastClose: true,
                hideAfter: 3000,
                position: 'mid-center',
                textAlign: 'left'
            });
            cto_loading_hide();
            return false;
        }
    });
}
</script>