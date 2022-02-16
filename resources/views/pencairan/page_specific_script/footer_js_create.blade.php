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

$.fn.modal.Constructor.prototype._enforceFocus = function() {

};

$("#kegiatan").on("change", function() {
    $("#kegiatan_label").val($("#kegiatan option:selected").text());
});

var fields = $("#quickForm").serialize();

$("#kegiatan").select2({
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
                field: "kegiatan",
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
        tanggal_pencairan :{
            required: true
        },
    },
    messages: {
        tanggal_pencairan :{
            required: "Tanggal Pencairan harus diisi!!"
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
            
            if(data.data.ct1_pencairanrka.length > 0){
                $("#caktable1 > tbody > tr").each(function(index){
                    var row_index = parseInt($(this).attr("row-seq"));
                    if(row_index == 1){
                        $("#caktable1 > tbody > tr[row-seq="+row_index+"]").find("td:eq(0)").text("");
                        $("select[name='kegiatan_"+row_index+"']").empty();
                        $("#caktable1 > tbody > tr[row-seq=1]").find("td:eq(0)").text("");

                        $("input[name='nom_"+row_index+"']").val("0");
                        $("#caktable1 > tbody > tr[row-seq="+row_index+"]").find("td:eq(6)").text("");
                        return true;
                    }
                    $(this).remove();
                });
                
                for(var i = 0; i < data.data.ct1_pencairanrka.length; i++){
                    addRow();

                    $("#caktable1 > tbody").find("[row-seq="+(parseInt(data.data.ct1_pencairanrka[i].no_seq)+1)+"]").find("td:eq(0)").text(data.data.ct1_pencairanrka[i].kegiatan);
                    $("select[name='kegiatan_"+(parseInt(data.data.ct1_pencairanrka[i].no_seq)+1)+"']").empty();
                    var newState = new Option(data.data.ct1_pencairanrka[i].kegiatan_label, data.data.ct1_pencairanrka[i].kegiatan, true, false);
                    $("#kegiatan_"+(parseInt(data.data.ct1_pencairanrka[i].no_seq)+1)+"").append(newState).trigger('change');
                    // @if($page_data["page_method_name"] == "View")
                    //     $("#kegiatan_"+(parseInt(data.data.ct1_pencairanrka[i].no_seq)+1)+"").attr("disabled", true); 
                    // @endif

                    //console.log(data.data.ct1_pencairanrka[i].nominalbiaya);
                    AutoNumeric.getAutoNumericElement('#nom_'+(parseInt(data.data.ct1_pencairanrka[i].no_seq)+1)).set(data.data.ct1_pencairanrka[i].nominalbiaya);
                    $("input[name='nom_"+(parseInt(data.data.ct1_pencairanrka[i].no_seq)+1)+"']").trigger("change");
                    $("#caktable1 > tbody > tr[row-seq="+(parseInt(data.data.ct1_pencairanrka[i].no_seq)+1)+"]").find("td:eq(6)").text(data.data.ct1_pencairanrka[i].id);
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
            ct1_detailbiayakegiatan : ct1_detailbiayakegiatan
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
                @if($page_data["page_method_name"] == "View")
                    "<tr row-seq=\""+rowlen+"\" class=\"addnewrow\">"
                    +"<td class=\"column-hidden\"></td>"
                    +"<td class=\"p-0\"><select name=\"kegiatan_"+rowlen+"\" id=\"kegiatan_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%;\"></select></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"nom_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"nom_"+rowlen+"\" placeholder=\"Enter Nominal\" readonly></td>"
                    +"<td class=\"column-hidden\"></td>"
                    +"</tr>"
                @else 
                    "<tr row-seq=\""+rowlen+"\" class=\"addnewrow\">"
                    +"<td class=\"column-hidden\"></td>"
                    +"<td class=\"p-0\"><select name=\"kegiatan_"+rowlen+"\" id=\"kegiatan_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%;\"></select></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"nom_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"nom_"+rowlen+"\" placeholder=\"Enter Nominal\" readonly></td>"
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

        $("#kegiatan_"+rowlen+"").on("change", function() {
            var $td = $(this).parent();
            var $tr = $($td).parent();
            cto_loading_show();
            $($tr).find("td:eq(0)").text($(this).val());
            $.ajax({
                url: "/getbiayakegiatan",
                type: "post",
                rowlen: rowlen,
                data: {
                    id: $(this).val(),
                    _token : $("input[name=_token]").val()
                },
                success: function(data){
                    if(data.status >= 200 && data.status <= 299){
                        AutoNumeric.getAutoNumericElement('#nom_'+(parseInt(this.rowlen))).set(data.data.total_biaya);
                        calcTotal();
                    }
                    cto_loading_hide();
                },
                error: function (err) {
                    console.log(err);
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
                    cto_loading_hide();
                }
            });
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

        $("#kegiatan_"+rowlen+"").select2({
            ajax: {
                url: "/getlinkspencairan",
                type: "post",
                dataType: "json",
                data: function(params) {
                    return {
                        term: params.term || "",
                        page: params.page,
                        field: "kegiatan",
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

    $('input[name=tanggal_pencairan_start]').pickadate({
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
    
    $('input[name=tanggal_pencairan_finish]').pickadate({
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
                    @if($page_data["page_method_name"] == "Update")
                    getdata();
                    @endif
                    // getlist();
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
            });
        }
    });

    $("#filterkegiatan").on("click", function(){
        getlistrka();
    });

    function getlistrka(){
        cto_loading_show();
        $.ajax({
            url: "/getlistrka",
            type: "post",
            data: {
                _token: $("#quickForm input[name=_token]").val(),
                tanggal_pencairan_start: $("input[name=tanggal_pencairan_start]").val().split("/")[2]+"-"+ $("input[name=tanggal_pencairan_start]").val().split("/")[1]+"-"+ $("input[name=tanggal_pencairan_start]").val().split("/")[0],
                tanggal_pencairan_finish : $("input[name=tanggal_pencairan_finish]").val().split("/")[2]+"-"+ $("input[name=tanggal_pencairan_finish]").val().split("/")[1]+"-"+ $("input[name=tanggal_pencairan_finish]").val().split("/")[0]
            },
            success: function(data){
                if(data.data.ct1_pencairanrka.length > 0){
                    $("#caktable1 > tbody > tr").each(function(index){
                        var row_index = parseInt($(this).attr("row-seq"));
                        $(this).remove();
                    });
                    
                    for(var i = 0; i < data.data.ct1_pencairanrka.length; i++){
                        addRow();

                        $("#caktable1 > tbody").find("[row-seq="+(parseInt(data.data.ct1_pencairanrka[i].no_seq))+"]").find("td:eq(0)").text(data.data.ct1_pencairanrka[i].kegiatan);
                        $("select[name='kegiatan_"+(parseInt(data.data.ct1_pencairanrka[i].no_seq))+"']").empty();
                        var newState = new Option(data.data.ct1_pencairanrka[i].kegiatan_label, data.data.ct1_pencairanrka[i].kegiatan, true, false);
                        $("#kegiatan_"+(parseInt(data.data.ct1_pencairanrka[i].no_seq))+"").append(newState).trigger('change');
                        // @if($page_data["page_method_name"] == "View")
                        //     $("#kegiatan_"+(parseInt(data.data.ct1_pencairanrka[i].no_seq))+"").attr("disabled", true); 
                        // @endif

                        // console.log(data.data.ct1_pencairanrka[i].nominalbiaya);
                        // AutoNumeric.getAutoNumericElement('#nom_'+(parseInt(data.data.ct1_pencairanrka[i].no_seq))).set("312331");
                        // $("input[name='nom_"+(parseInt(data.data.ct1_pencairanrka[i].no_seq))+"']").trigger("change");
                        $("#caktable1 > tbody > tr[row-seq="+(parseInt(data.data.ct1_pencairanrka[i].no_seq))+"]").find("td:eq(6)").text(data.data.ct1_pencairanrka[i].id);
                    }
                }else{
                    $.toast({
                        text: "Tidak ada Data!",
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
 
</script>