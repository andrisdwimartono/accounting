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

$("#tahun").select2({
    placeholder: "Pilih satu",
    allowClear: true,
    theme: "bootstrap4" @if($page_data["page_method_name"] == "View"),
    disabled: false @endif
});

$.fn.modal.Constructor.prototype._enforceFocus = function() {

};

$("#tahun").on("change", function() {
    $("#tahun_label").val($("#tahun option:selected").text());
    $('#iku').val('').trigger('change');
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
        tahun :{
            required: true
        },
    },
    messages: {
        tahun :{
            required: "Tahun harus diisi!!"
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
            for(var i = 0; i < Object.keys(data.data.settingpagupendapatan).length; i++){
                if(Object.keys(data.data.settingpagupendapatan)[i] == "unit_pelaksana" || Object.keys(data.data.settingpagupendapatan)[i] == "iku"){
                    if(data.data.settingpagupendapatan[Object.keys(data.data.settingpagupendapatan)[i]]){
                        var newState = new Option(data.data.settingpagupendapatan[Object.keys(data.data.settingpagupendapatan)[i]+"_label"], data.data.settingpagupendapatan[Object.keys(data.data.settingpagupendapatan)[i]], true, false);
                        $("#"+Object.keys(data.data.settingpagupendapatan)[i]).append(newState).trigger("change");
                    }
                }else{
                    if(["ewfsdfsafdsafasdfasdferad"].includes(Object.keys(data.data.settingpagupendapatan)[i])){
                        $("input[name="+Object.keys(data.data.settingpagupendapatan)[i]+"]").prop("checked", data.data.settingpagupendapatan[Object.keys(data.data.settingpagupendapatan)[i]]);
                    }else{
                        try{
                            anObject[Object.keys(data.data.settingpagupendapatan)[i]].set(data.data.settingpagupendapatan[Object.keys(data.data.settingpagupendapatan)[i]]);
                        }catch(err){
                            $("input[name="+Object.keys(data.data.settingpagupendapatan)[i]+"]").val(data.data.settingpagupendapatan[Object.keys(data.data.settingpagupendapatan)[i]]);
                        }
                        $("textarea[name="+Object.keys(data.data.settingpagupendapatan)[i]+"]").val(data.data.settingpagupendapatan[Object.keys(data.data.settingpagupendapatan)[i]]);
                        if(["proposal"].includes(Object.keys(data.data.settingpagupendapatan)[i])){
                            if(data.data.settingpagupendapatan[Object.keys(data.data.settingpagupendapatan)[i]] != null){
                                $("#btn_"+Object.keys(data.data.settingpagupendapatan)[i]+"").removeAttr("disabled");
                                $("#btn_"+Object.keys(data.data.settingpagupendapatan)[i]+"").addClass("btn-success text-white");
                                $("#btn_"+Object.keys(data.data.settingpagupendapatan)[i]+"").removeClass("btn-primary");
                                var filename = Object.keys(data.data.settingpagupendapatan)[i];
                                $("label[for=upload_"+Object.keys(data.data.settingpagupendapatan)[i]+"]").html(filename);
                                $("#btn_"+Object.keys(data.data.settingpagupendapatan)[i]+"").html("Download");
                            }
                        }
                    }
                    $("select[name="+Object.keys(data.data.settingpagupendapatan)[i]+"]").val(data.data.settingpagupendapatan[Object.keys(data.data.settingpagupendapatan)[i]]).change();
                }
            }
            
            // if(data.data.ct1_nilaipagu.length > 0){
            //     $("#caktable1 > tbody > tr").each(function(index){
            //         $(this).remove();
            //     });
            //     console.log(data.data)
            //     for(var i = 0; i < data.data.ct1_nilaipagu.length; i++){
            //         addRow();
                    

            //         $("#caktable1 > tbody").find("[row-seq="+(parseInt(data.data.ct1_nilaipagu[i].no_seq)+1)+"]").find("td:eq(0)").text(data.data.ct1_nilaipagu[i].unitkerja);
            //         $("select[name='unitkerja_"+(parseInt(data.data.ct1_nilaipagu[i].no_seq)+1)+"']").empty();
            //         var newState = new Option(data.data.ct1_nilaipagu[i].unitkerja_label, data.data.ct1_nilaipagu[i].unitkerja, true, false);
            //         $("#unitkerja_"+(parseInt(data.data.ct1_nilaipagu[i].no_seq)+1)+"").append(newState).trigger('change');
                    

            //         //console.log(data.data.ct1_nilaipagu[i].maxbiaya);
            //         console.log($("#nom_"+(parseInt(data.data.ct1_nilaipagu[i].no_seq)+1)).val())
            //         //AutoNumeric.getAutoNumericElement('#nom_'+(parseInt(data.data.ct1_nilaipagu[i].no_seq)+1)).set(data.data.ct1_nilaipagu[i].maxbiaya);
            //         $("input[name='nom_"+(parseInt(data.data.ct1_nilaipagu[i].no_seq)+1)+"']").trigger("change");
            //         $("#caktable1 > tbody > tr[row-seq="+(parseInt(data.data.ct1_nilaipagu[i].no_seq)+1)+"]").find("td:eq(4)").text(data.data.ct1_nilaipagu[i].id);
            //     }
            // }

            if(data.data.ct2_potensipendapatan.length > 0){
                $("#caktable2 > tbody > tr").each(function(index){
                    $(this).remove();
                });
                
                for(var i = 0; i < data.data.ct2_potensipendapatan.length; i++){
                    addRow2();
                    console.log("added "+i)
                    console.log(data.data.ct2_potensipendapatan[i])
                    $("#caktable2 > tbody").find("[row-seq="+(parseInt(data.data.ct2_potensipendapatan[i].no_seq)+1)+"]").find("td:eq(0)").text(data.data.ct2_potensipendapatan[i].unitkerja2);
                    $("select[name='unitkerja2_"+(parseInt(data.data.ct2_potensipendapatan[i].no_seq)+1)+"']").empty();
                    var newState = new Option(data.data.ct2_potensipendapatan[i].unitkerja2_label, data.data.ct2_potensipendapatan[i].unitkerja2, true, false);
                    $("#unitkerja2_"+(parseInt(data.data.ct2_potensipendapatan[i].no_seq)+1)+"").append(newState).trigger('change');

                    $("#caktable2 > tbody").find("[row-seq="+(parseInt(data.data.ct2_potensipendapatan[i].no_seq)+1)+"]").find("td:eq(2)").text(data.data.ct2_potensipendapatan[i].coa);
                    $("select[name='coa_"+(parseInt(data.data.ct2_potensipendapatan[i].no_seq)+1)+"']").empty();
                    var newState = new Option(data.data.ct2_potensipendapatan[i].coa_label, data.data.ct2_potensipendapatan[i].coa, true, false);
                    $("#coa_"+(parseInt(data.data.ct2_potensipendapatan[i].no_seq)+1)+"").append(newState).trigger('change');

                    //console.log(data.data.ct2_potensipendapatan[i].nominalpendapatan);
                    try{
                        AutoNumeric.getAutoNumericElement('#nom2_'+(parseInt(data.data.ct2_potensipendapatan[i].no_seq)+1)).set(data.data.ct2_potensipendapatan[i].nominalpendapatan);    
                    }catch{
                        $("input[name='nom2_"+(parseInt(data.data.ct2_potensipendapatan[i].no_seq)+1)+"']").val(data.data.ct2_potensipendapatan[i].nominalpendapatan);
                    }
                    //AutoNumeric.getAutoNumericElement('#nom2_'+(parseInt(data.data.ct2_potensipendapatan[i].no_seq)+1)).set(data.data.ct2_potensipendapatan[i].nominalpendapatan);
                    $("input[name='nom2_"+(parseInt(data.data.ct2_potensipendapatan[i].no_seq)+1)+"']").trigger("change");
                    $("#caktable2 > tbody > tr[row-seq="+(parseInt(data.data.ct2_potensipendapatan[i].no_seq)+1)+"]").find("td:eq(6)").text(data.data.ct2_potensipendapatan[i].id);
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

    $(".row-delete2").click(function(){
        var $td = $(this).parent();
        var $tr = $($td).parent();
        $($tr).remove();
        calcTotal2();
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

    $("#addrow2").click(function(){
        addRow2();
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
                    +"<td class=\"p-0\"><select name=\"unitkerja_"+rowlen+"\" id=\"unitkerja_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%;\"></select></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"nom_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"nom_"+rowlen+"\" placeholder=\"Enter Nominal\"></td>"
                    +"<td class=\"p-0\"></td>"
                    +"<td class=\"column-hidden\"></td>"
                    +"</tr>"
                @else 
                "<tr row-seq=\""+rowlen+"\" class=\"addnewrow\">"
                    +"<td class=\"column-hidden\"></td>"
                    +"<td class=\"p-0\"><select name=\"unitkerja_"+rowlen+"\" id=\"unitkerja_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%;\"></select></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"nom_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"nom_"+rowlen+"\" placeholder=\"Enter Nominal\"></td>"
                    +"<td class=\"p-0\"></td>"
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

        $("#unitkerja_"+rowlen+"").on("change", function() {
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

        $("#unitkerja_"+rowlen+"").select2({
            ajax: {
                url: "/getlinkssettingpagupendapatan",
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
                    // for(var i = 0; i < data.items.length; i++){
                    //     var te = data.items[i].text.split(" ");
                    //     text = data.items[i].text;
                    //     data.items[i].text = convertCode(te[0])+" "+text.replace(te[0]+" ", "");
                    // }
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

    function addRow2(){
        rowlen = 1;
        if($('#caktable2 > tbody > tr').length > 0){
            rowlen = parseInt($('#caktable2 > tbody > tr:last').attr('row-seq'))+1;
        }
         

        var rowaddlen = 0;
        $("#caktable2").find('tbody')
            .append(
                @if($page_data["page_method_name"] == "View")
                    "<tr row-seq=\""+rowlen+"\" class=\"addnewrow\">"
                    +"<td class=\"column-hidden\"></td>"
                    +"<td class=\"p-0\"><select name=\"unitkerja2_"+rowlen+"\" id=\"unitkerja2_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%;\"></select></td>"
                    +"<td class=\"column-hidden\"></td>"
                    +"<td class=\"p-0\"><select name=\"coa_"+rowlen+"\" id=\"coa_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%;\"></select></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"nom2_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"nom2_"+rowlen+"\" placeholder=\"Enter Nominal\"></td>"
                    +"<td class=\"p-0\"></td>"
                    +"<td class=\"column-hidden\"></td>"
                    +"</tr>"
                @else 
                "<tr row-seq=\""+rowlen+"\" class=\"addnewrow\">"
                    +"<td class=\"column-hidden\"></td>"
                    +"<td class=\"p-0\"><select name=\"unitkerja2_"+rowlen+"\" id=\"unitkerja2_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%;\"></select></td>"
                    +"<td class=\"column-hidden\"></td>"
                    +"<td class=\"p-0\"><select name=\"coa_"+rowlen+"\" id=\"coa_"+rowlen+"\" class=\"form-control form-control-sm select2bs4staticBackdrop addnewrowselect\" data-row=\""+rowlen+"\" style=\"width: 100%;\"></select></td>"
                    +"<td class=\"p-0\"><input type=\"text\" name=\"nom2_"+rowlen+"\" value=\"0\" class=\"form-control form-control-sm cakautonumeric cakautonumeric-float text-right\" id=\"nom2_"+rowlen+"\" placeholder=\"Enter Nominal\"></td>"
                    +"<td class=\"p-0\"></td>"
                    +"<td class=\"column-hidden\"></td>"
                    +"</tr>"
                @endif
            );
        rowaddlen = $('#caktable2 tr.addnewrow').length

        $("#row_delete_"+rowlen).on('click', function(){
            var $td = $(this).parent();
            var $tr = $($td).parent();
            $($tr).remove();
            calcTotal2();
        });

        $("#unitkerja2_"+rowlen+"").on("change", function() {
            var $td = $(this).parent();
            var $tr = $($td).parent();
            $($tr).find("td:eq(0)").text($(this).val());
        });

        $("#coa_"+rowlen+"").on("change", function() {
            var $td = $(this).parent();
            var $tr = $($td).parent();
            $($tr).find("td:eq(2)").text($(this).val());
        });

        var noms = new AutoNumeric("#nom2_"+rowlen, {
            currencySymbol : 'Rp ',
            decimalCharacter : ',',
            digitGroupSeparator : '.',
            minimumValue : 0,
            decimalPlaces : 2,
            unformatOnSubmit : true
        });

        $("#nom2_"+rowlen+"").on("change", function(){
            calcTotal2();
        });

        $("#unitkerja2_"+rowlen+"").select2({
            ajax: {
                url: "/getlinkssettingpagupendapatan",
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
                    // for(var i = 0; i < data.items.length; i++){
                    //     var te = data.items[i].text.split(" ");
                    //     text = data.items[i].text;
                    //     data.items[i].text = convertCode(te[0])+" "+text.replace(te[0]+" ", "");
                    // }
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
                url: "/getlinkssettingpagupendapatan",
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
        console.log("adding "+rowlen);
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

    function calcTotal2(){
        var totalnom = 0;
        $("#caktable2 > tbody > tr").each(function(index, tr){
            totalnom += AutoNumeric.getNumber("#nom2_"+$(tr).attr("row-seq"));
        });
        $("#totalnom2").text('Rp '+totalnom.toLocaleString('id'));
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
            var ctct1_nilaipagu = [];
            var ctct2_potensipendapatan = [];

            var stop_submit = false;
            $("#caktable1 > tbody > tr").each(function(index, tr){
                if(AutoNumeric.getNumber("#nom_"+$(tr).attr("row-seq")) <= 0 && $("#unitkerja_"+$(tr).attr("row-seq")).val() != null){
                    $("#nom_"+$(tr).attr("row-seq")).addClass("border-danger");
                    cto_loading_hide();
                    stop_submit = true;
                    return;
                }
                
                var unitkerja = 0;
                var unitkerja_label = "";
                var deskripsibiaya = "";
                var maxbiaya = 0;
                var id = "";
                $(tr).find("td").each(function(index, td){
                    if(index == 0){
                        unitkerja = $(td).text();
                    }else if(index == 1){
                        unitkerja_label = $(td).find("select").text();
                    }else if(index == 2){
                        maxbiaya = AutoNumeric.getNumber("#nom_"+$(tr).attr("row-seq"));
                    }else if(index == 4){
                        id = $(td).text();
                    }
                });
                if(unitkerja != '')
                    ctct1_nilaipagu.push({"no_seq": index, "unitkerja": unitkerja, "unitkerja_label": unitkerja_label, "maxbiaya": maxbiaya, "id": id});
            });

            var stop_submit = false;
            $("#caktable2 > tbody > tr").each(function(index, tr){
                if(AutoNumeric.getNumber("#nom2_"+$(tr).attr("row-seq")) <= 0 && $("#coa_"+$(tr).attr("row-seq")).val() != null && $("#unitkerja2_"+$(tr).attr("row-seq")).val() != null){
                    $("#nom2_"+$(tr).attr("row-seq")).addClass("border-danger");
                    cto_loading_hide();
                    stop_submit = true;
                    return;
                }
                
                var unitkerja = 0;
                var unitkerja_label = "";
                var coa = 0;
                var coa_label = "";
                var nominalpendapatan = 0;
                var id = "";
                $(tr).find("td").each(function(index, td){
                    if(index == 0){
                        unitkerja = $(td).text();
                    }else if(index == 1){
                        unitkerja_label = $(td).find("select").text();
                    }else if(index == 2){
                        coa = $(td).text();
                    }else if(index == 3){
                        coa_label = $(td).find("select").text();
                    }else if(index == 4){
                        nominalpendapatan = AutoNumeric.getNumber("#nom2_"+$(tr).attr("row-seq"));
                    }else if(index == 6){
                        id = $(td).text();
                    }
                });
                if(unitkerja != '')
                    ctct2_potensipendapatan.push({"no_seq": index, "unitkerja2": unitkerja, "unitkerja2_label": unitkerja_label, "coa": coa, "coa_label": coa_label, "nominalpendapatan": nominalpendapatan, "id": id});
            });

            
            if(stop_submit){
                return;
            }
            
            $("#ct1_nilaipagu").val(JSON.stringify(ctct1_nilaipagu));
            $("#ct2_potensipendapatan").val(JSON.stringify(ctct2_potensipendapatan));
                
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
                            if(i == "unitkerja" || i == "unitkerja_label" || i == "maxbiaya"){
                                errors["ct1_nilaipagu"] = error[0];
                            }else if(i == "unitkerja" || i == "unitkerja_label" || i == "coa" || i == "coa_label" || i == "nominalpendapatan"){
                                errors["ct2_potensipendapatan"] = error[0];
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