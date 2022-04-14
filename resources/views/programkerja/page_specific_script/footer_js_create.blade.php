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

$.fn.modal.Constructor.prototype._enforceFocus = function() {

};

$("#quickForm").validate({
    rules: {
        programkerja_name :{
            required: true
        },
    },
    messages: {
        programkerja_name :{
            required: "Nama Program Kerja harus diisi!!"
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

$("#quickModalForm_ct1_detailbiayaproker").validate({
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
    getdata();
    @endif    
});

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
                        if(["proposal"].includes(Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i])){
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
            
            if(data.data.ct1_detailbiayaproker.length > 0){
                $("#caktable1 > tbody > tr").each(function(index){
                    $(this).remove();
                });
                
                for(var i = 0; i < data.data.ct1_detailbiayaproker.length; i++){
                    addRow();

                    $("input[name='detailbiayaproker_name_"+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"']").val(data.data.ct1_detailbiayaproker[i].detailbiayaproker_name);

                    $("input[name='deskripsibiaya_"+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"']").val(data.data.ct1_detailbiayaproker[i].deskripsibiaya);
                    
                    AutoNumeric.getAutoNumericElement('#volume_'+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))).set(data.data.ct1_detailbiayaproker[i].volume);
                    $("input[name='volume_"+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"']").trigger("change");

                    
                    $("#caktable1 > tbody").find("[row-seq="+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"]").find("td:eq(3)").text(data.data.ct1_detailbiayaproker[i].satuan);

                    $("select[name='satuan_"+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"']").empty();
                    var newState = new Option(data.data.ct1_detailbiayaproker[i].satuan_label, data.data.ct1_detailbiayaproker[i].satuan, true, false);
                    $("#satuan_"+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"").append(newState).trigger('change');

                    AutoNumeric.getAutoNumericElement('#biayasatuan_'+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))).set(data.data.ct1_detailbiayaproker[i].standarbiaya/data.data.ct1_detailbiayaproker[i].volume);
                    $("input[name='biayasatuan_"+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"']").trigger("change");

                    AutoNumeric.getAutoNumericElement('#standarbiaya_'+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))).set(data.data.ct1_detailbiayaproker[i].standarbiaya);
                    $("input[name='standarbiaya_"+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"']").trigger("change");

                    $("#caktable1 > tbody > tr[row-seq="+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"]").find("td:eq(8)").text(data.data.ct1_detailbiayaproker[i].id);
                    

                    // $("#caktable1 > tbody").find("[row-seq="+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"]").find("td:eq(0)").text(data.data.ct1_detailbiayaproker[i].kegiatan);

                    // $("select[name='kegiatan_"+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"']").empty();
                    // var newState = new Option(data.data.ct1_detailbiayaproker[i].kegiatan_label, data.data.ct1_detailbiayaproker[i].kegiatan, true, false);
                    // $("#kegiatan_"+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"").append(newState).trigger('change');
                    // // @if($page_data["page_method_name"] == "View")
                    // //     $("#kegiatan_"+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"").attr("disabled", true); 
                    // // @endif

                    // //console.log(data.data.ct1_detailbiayaproker[i].nominalbiaya);
                    // AutoNumeric.getAutoNumericElement('#nom_'+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))).set(data.data.ct1_detailbiayaproker[i].nominalbiaya);
                    // $("input[name='nom_"+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"']").trigger("change");
                    // $("#caktable1 > tbody > tr[row-seq="+(parseInt(data.data.ct1_detailbiayaproker[i].no_seq))+"]").find("td:eq(6)").text(data.data.ct1_detailbiayaproker[i].id);
                }

                $(".row-show-history").on("click", function() {
                    


                });
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
                +"<td class=\"p-0\"><input type=\"text\" name=\"detailbiayaproker_name_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"detailbiayaproker_name_"+rowlen+"\"></td>"
                +"<td class=\"p-0\"><input type=\"text\" name=\"deskripsibiaya_"+rowlen+"\" class=\"form-control form-control-sm\" id=\"deskripsibiaya_"+rowlen+"\"></td>"
                +"<td class=\"p-0\"><input type=\"text\" name=\"volume_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"volume_"+rowlen+"\" placeholder=\"Enter Nominal\"></td>"
                +"<td class=\"column-hidden\"></td>"
                +"<td class=\"p-0\"><select name=\"satuan_"+rowlen+"\" id=\"satuan_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%;\"></select></td>"
                +"<td class=\"p-0\"><input type=\"text\" name=\"biayasatuan_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"biayasatuan_"+rowlen+"\" placeholder=\"Enter Nominal\"></td>"
                +"<td class=\"p-0\"><input type=\"text\" name=\"standarbiaya_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"standarbiaya_"+rowlen+"\" placeholder=\"Enter Nominal\"></td>"
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

        $("#satuan_"+rowlen+"").on("change", function() {
            var $td = $(this).parent();
            var $tr = $($td).parent();
            $($tr).find("td:eq(3)").text($(this).val());
        });

        var noms = new AutoNumeric("#biayasatuan_"+rowlen, {
            currencySymbol : 'Rp ',
            decimalCharacter : ',',
            digitGroupSeparator : '.',
            minimumValue : 0,
            decimalPlaces : 2,
            unformatOnSubmit : true
        });

        var noms = new AutoNumeric("#standarbiaya_"+rowlen, {
            currencySymbol : 'Rp ',
            decimalCharacter : ',',
            digitGroupSeparator : '.',
            minimumValue : 0,
            decimalPlaces : 2,
            unformatOnSubmit : true,
            readOnly: true
        });        

        var noms = new AutoNumeric("#volume_"+rowlen, {
            currencySymbol : '',
            decimalCharacter : ',',
            digitGroupSeparator : '.',
            minimumValue : 0,
            decimalPlaces : 2,
            unformatOnSubmit : true
        });

        $("#volume_"+rowlen+"").on("change", function(){
            var volume = AutoNumeric.getNumber("#volume_"+rowlen+"");
            var biayasatuan = AutoNumeric.getNumber("#biayasatuan_"+rowlen+"");
            AutoNumeric.getAutoNumericElement('#standarbiaya_'+rowlen).set(volume*biayasatuan);
            $("input[name='standarbiaya_"+rowlen+"']").trigger("change");

            calcTotal();
        });

        $("#biayasatuan_"+rowlen+"").on("change", function(){
            var volume = AutoNumeric.getNumber("#volume_"+rowlen+"");
            var biayasatuan = AutoNumeric.getNumber("#biayasatuan_"+rowlen+"");
            AutoNumeric.getAutoNumericElement('#standarbiaya_'+rowlen).set(volume*biayasatuan);
            $("input[name='standarbiaya_"+rowlen+"']").trigger("change");

            calcTotal();
        });

        $("#standarbiaya_"+rowlen+"").on("change", function(){
            // var volume = AutoNumeric.getNumber("#volume_"+rowlen+"");
            // var standarbiaya = AutoNumeric.getNumber("#standarbiaya_"+rowlen+"");
            // AutoNumeric.getAutoNumericElement('#biayasatuan_'+rowlen).set(standarbiaya/volume);
            // $("input[name='biayasatuan_"+rowlen+"']").trigger("change");

            calcTotal();
        });

        $("#satuan_"+rowlen+"").select2({
            ajax: {
                url: "/getlinksprogramkerja",
                type: "post",
                dataType: "json",
                data: function(params) {
                    return {
                        term: params.term || "",
                        page: params.page,
                        field: "satuan",
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
    

    function calcTotal(){
        var totalnom = 0;
        $("#caktable1 > tbody > tr").each(function(index, tr){
            totalnom += AutoNumeric.getNumber("#standarbiaya_"+$(tr).attr("row-seq"));
        });
        $("#totalnom").text('Rp '+totalnom.toLocaleString('id'));
    }

    $.validator.setDefaults({
        submitHandler: function (form, event) {
            event.preventDefault();
            cto_loading_show();
            var quickForm = $("#quickForm");
            var ctct1_detailbiayaproker = [];

            var stop_submit = false;
            $("#caktable1 > tbody > tr").each(function(index, tr){
                if(AutoNumeric.getNumber("#standarbiaya_"+$(tr).attr("row-seq")) <= 0 && $("#satuan_"+$(tr).attr("row-seq")).val() != null){
                    $("#standarbiaya_"+$(tr).attr("row-seq")).addClass("border-danger");
                    cto_loading_hide();
                    stop_submit = true;
                    return;
                }
                
                var detailbiayaproker_name = "";
                var deskripsibiaya = "";
                var volume = 0;
                var satuan = 0;
                var satuan_label = "";
                var standarbiaya = 0;
                var id = "";
                var no_seq = $(tr).attr("row-seq");
                $(tr).find("td").each(function(index, td){
                    if(index == 0){
                        detailbiayaproker_name = $(td).find("input").val();
                    }else if(index == 1){
                        deskripsibiaya = $(td).find("input").val();
                    }else if(index == 2){
                        volume = AutoNumeric.getNumber("#volume_"+$(tr).attr("row-seq"));
                    }else if(index == 3){
                        satuan = $(td).text();
                    }else if(index == 4){
                        satuan_label = $(td).find("select option:selected").text();
                    }else if(index == 6){
                        standarbiaya = AutoNumeric.getNumber("#standarbiaya_"+$(tr).attr("row-seq"));
                    }else if(index == 8){
                        id = $(td).text();
                    }
                });
                
                ctct1_detailbiayaproker.push({"no_seq": no_seq, "detailbiayaproker_name": detailbiayaproker_name, "deskripsibiaya": deskripsibiaya, "volume": volume, "satuan": satuan, "satuan_label": satuan_label, "standarbiaya": standarbiaya, "id": id});
            });

            
            if(stop_submit){
                return;
            }
            
            $("#ct1_detailbiayaproker").val(JSON.stringify(ctct1_detailbiayaproker));
            var values = $("#quickForm").serializeArray();
            values = jQuery.param(values);
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
                                errors["ct1_detailbiayaproker"] = error[0];
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