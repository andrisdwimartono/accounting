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

    //anObject["standarbiaya"].settings.minimumValue = 0;


$(function () {

   
$("select").select2({
    placeholder: "Pilih satu",
    allowClear: true,
    theme: "bootstrap4" @if($page_data["page_method_name"] == "View"),
    disabled: true @endif
});

$("#unit_pelaksana").on("change", function() {
    $("#unit_pelaksana_label").val($("#unit_pelaksana option:selected").text());
    getdata();
});

$("#tahun").on("change", function() {
    $("#tahun_label").val($("#tahun option:selected").text());
    getdata();
});

$.ajax({
    url: "/getoptions{{$page_data["page_data_urlname"]}}",
    type: "post",
    data: {
        fieldname: "tahun",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        var newState = new Option("", "", true, false);
        $("#tahun").append(newState).trigger("change");
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                newState = new Option(data[i].label, data[i].name, true, false);
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

$.fn.modal.Constructor.prototype._enforceFocus = function() {

};

$("#quickForm").validate({
    rules: {
        tahun :{
            required: true
        },
        unit_pelaksana :{
            required: true
        },
    },
    messages: {
        tahun :{
            required: "Tahun harus diisi!!"
        },
        unit_pelaksana :{
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
    @if($page_data["page_method_name"] == "Update" || $page_data["page_method_name"] == "View")
    $("select[name='tahun']").empty();
    var newState = new Option({{$page_data['tahun_label']}}, {{$page_data['tahun']}}, true, false);
    $("#tahun").append(newState).trigger('change');
    $("select[name='unit_pelaksana']").empty();
    var newState2 = new Option('{{$page_data['unit_pelaksana_label']}}', {{$page_data['unit_pelaksana']}}, true, false);
    $("#unit_pelaksana").append(newState2).trigger('change');
    getdata();
    @endif
});

function getdata(){
    if($("#tahun").val() != "" && $("#tahun").val() != null && $("#unit_pelaksana").val() != "" && $("#unit_pelaksana").val() != null){

    }else{
        return;
    }
    cto_loading_show();
    $.ajax({
        url: "/getdata{{$page_data["page_data_urlname"]}}",
        type: "post",
        data: {
            tahun: $("#tahun").val(),
            unit_pelaksana: $("#unit_pelaksana").val(),
            _token: $("#quickForm input[name=_token]").val()
        },
        success: function(data){
            $("#caktable1 > tbody > tr").each(function(index){
                $(this).remove();
                calcTotal();
            });
            if(data.data.ct1_detailbiayakegiatan.length > 0){
                for(var i = 0; i < data.data.ct1_detailbiayakegiatan.length; i++){
                    addRow();

                    $("#caktable1 > tbody").find("[row-seq="+(i+1)+"]").find("td:eq(0)").text(data.data.ct1_detailbiayakegiatan[i].programkerja);

                    $("select[name='programkerja_"+(i+1)+"']").empty();
                    var newState = new Option(data.data.ct1_detailbiayakegiatan[i].programkerja_label, data.data.ct1_detailbiayakegiatan[i].programkerja, true, false);
                    $("#programkerja_"+(i+1)+"").append(newState).trigger('change');

                    $("input[name='kegiatan_name_"+(i+1)+"']").val(data.data.ct1_detailbiayakegiatan[i].kegiatan_name);

                    $("input[name='deskripsi_"+(i+1)+"']").val(data.data.ct1_detailbiayakegiatan[i].deskripsi);

                    $("select[name='coa_"+(i+1)+"']").empty();
                    var newState = new Option(data.data.ct1_detailbiayakegiatan[i].coa_label, data.data.ct1_detailbiayakegiatan[i].coa, true, false);
                    $("#coa_"+(i+1)+"").append(newState).trigger('change');
                    
                    AutoNumeric.getAutoNumericElement('#plafon_'+(i+1)).set(data.data.ct1_detailbiayakegiatan[i].plafon);
                    $("input[name='plafon_"+(i+1)+"']").trigger("change");

                    $("#caktable1 > tbody").find("[row-seq="+(i+1)+"]").find("td:eq(8)").text(data.data.ct1_detailbiayakegiatan[i].id);
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

    function addRow(){
        rowlen = 1;
        if($('#caktable1 > tbody > tr').length > 0){
            rowlen = parseInt($('#caktable1 > tbody > tr:last').attr('row-seq'))+1;
        }
         
        var rowaddlen = 0;
        $("#caktable1").find('tbody')
            .append(
                "<tr row-seq=\""+rowlen+"\" class=\"addnewrow\">"
                +"<td class=\"column-hidden\"></td>"
                +"<td class=\"p-0\"><select name=\"programkerja_"+rowlen+"\" id=\"programkerja_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%; overflow: hidden; white-space: nowrap;\"></select></td>"
                +"<td class=\"p-0\"><input type=\"text\" name=\"kegiatan_name_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"kegiatan_name_"+rowlen+"\"></td>"
                +"<td class=\"p-0\"><input type=\"text\" name=\"deskripsi_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"deskripsi_"+rowlen+"\"></td>"
                +"<td class=\"column-hidden\"></td>"
                +"<td class=\"p-0\"><select name=\"coa_"+rowlen+"\" id=\"coa_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%; overflow: hidden; white-space: nowrap;\"></select></td>"
                +"<td class=\"p-0\"><input type=\"text\" name=\"plafon_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"plafon_"+rowlen+"\" placeholder=\"Enter Nominal\"></td>"
                +"<td class=\"p-0 text-center\"><button id=\"row_delete_"+rowlen+"\" class=\"bg-white border-0\"><i class=\"text-danger fas fa-minus-circle row-delete\" style=\"cursor: pointer;\"></i></button></td>"
                +"<td class=\"column-hidden\"></td>"
                +"</tr>"
            );
        rowaddlen = $('#caktable1 tr.addnewrow').length

        $("#row_delete_"+rowlen).on('click', function(){
            var $td = $(this).parent();
            var $tr = $($td).parent();
            $($tr).remove();
            calcTotal();
        });

        $("#programkerja_"+rowlen+"").on("change", function() {
            var $td = $(this).parent();
            var $tr = $($td).parent();
            $($tr).find("td:eq(0)").text($(this).val());
        });

        $("#coa_"+rowlen+"").on("change", function() {
            var $td = $(this).parent();
            var $tr = $($td).parent();
            $($tr).find("td:eq(4)").text($(this).val());
        });

        var noms = new AutoNumeric("#plafon_"+rowlen, {
            currencySymbol : 'Rp ',
            decimalCharacter : ',',
            digitGroupSeparator : '.',
            minimumValue : 0,
            decimalPlaces : 2,
            unformatOnSubmit : true
        });

        $("#plafon_"+rowlen+"").on("change", function(){
            var plafon = AutoNumeric.getNumber("#plafon_"+rowlen+"");
            calcTotal();
        });

        $("#programkerja_"+rowlen+"").select2({
            ajax: {
                url: "/getlinksplafon_kegiatan",
                type: "post",
                dataType: "json",
                data: function(params) {
                    return {
                        term: params.term || "",
                        page: params.page,
                        field: "programkerja",
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

        $("#coa_"+rowlen+"").select2({
            ajax: {
                url: "/getlinksplafon_kegiatan",
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
    

    function calcTotal(){
        var totalnom = 0;
        $("#caktable1 > tbody > tr").each(function(index, tr){
            totalnom += AutoNumeric.getNumber("#plafon_"+$(tr).attr("row-seq"));
        });
        $("#totalnom").text('Rp '+totalnom.toLocaleString('id'));
    }

    $.validator.setDefaults({
        submitHandler: function (form, event) {
            event.preventDefault();
            cto_loading_show();
            var quickForm = $("#quickForm");
            var ctct1_detailbiayakegiatan = [];

            var stop_submit = false;
            $("#caktable1 > tbody > tr").each(function(index, tr){
                if($("#programkerja_"+$(tr).attr("row-seq")).find("option:selected").val() == "" || $("#programkerja_"+$(tr).attr("row-seq")).find("option:selected").val() == null){
                    $("#programkerja_"+$(tr).attr("row-seq")).addClass("border-danger");
                    cto_loading_hide();
                    stop_submit = true;
                    return;
                }

                if(AutoNumeric.getNumber("#plafon_"+$(tr).attr("row-seq")) <= 0){
                    $("#plafon_"+$(tr).attr("row-seq")).addClass("border-danger");
                    cto_loading_hide();
                    stop_submit = true;
                    return;
                }

                if($("#coa_"+$(tr).attr("row-seq")).find("option:selected").val() == "" || $("#coa_"+$(tr).attr("row-seq")).find("option:selected").val() == null){
                    $("#coa_"+$(tr).attr("row-seq")).addClass("border-danger");
                    cto_loading_hide();
                    stop_submit = true;
                    return;
                }
                
                if($("#kegiatan_name_"+$(tr).attr("row-seq")).val() == ""){
                    $("#kegiatan_name_"+$(tr).attr("row-seq")).addClass("border-danger");
                    cto_loading_hide();
                    stop_submit = true;
                    return;
                }
                
                var programkerja = 0;
                var programkerja_label = "";
                var kegiatan_name = "";
                var deskripsi = "";
                var coa = 0;
                var coa_label = "";
                var plafon = 0;
                var id = "";
                var no_seq = $(tr).attr("row-seq");
                $(tr).find("td").each(function(index, td){
                    if(index == 0){
                        programkerja = $(td).text();
                    }else if(index == 1){
                        programkerja_label = $(td).find("select option:selected").text();
                    }else if(index == 2){
                        kegiatan_name = $(td).find("input").val();
                    }else if(index == 3){
                        deskripsi = $(td).find("input").val();
                    }else if(index == 4){
                        coa = $(td).text();
                    }else if(index == 5){
                        coa_label = $(td).find("select option:selected").text();
                    }else if(index == 6){
                        plafon = AutoNumeric.getNumber("#plafon_"+$(tr).attr("row-seq"));
                    }else if(index == 8){
                        id = $(td).text();
                    }
                });
                
                ctct1_detailbiayakegiatan.push({"no_seq": no_seq, "programkerja": programkerja, "programkerja_label": programkerja_label, "kegiatan_name": kegiatan_name, "deskripsi": deskripsi, "coa": coa, "coa_label": coa_label, "plafon": plafon, "id": id});
            });

            
            if(stop_submit){
                return;
            }
            
            $("#ct1_detailbiayakegiatan").val(JSON.stringify(ctct1_detailbiayakegiatan));
            var values = $("#quickForm").serializeArray();
            values = jQuery.param(values);
            var ajaxRequest;
            ajaxRequest = $.ajax({
                url: "/store{{$page_data["page_data_urlname"]}}",
                type: "post",
                data: values,
                success: function(data){
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
                    $("#modal-trysubmit").modal("hide");
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
                            if(i == "satuan" || i == "satuan_label" || i == "detailbiayaproker_name" || i == "standarbiaya"){
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

</script>