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

    <!-- Datatable -->
    <script src="{{ asset ("/assets/datatables/js/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset ("/assets/motaadmin/js/plugins-init/datatables.init.js") }} "></script>

<!-- <script src="{{ asset ("/assets/jquery/js/jquery-3.6.0.min.js") }}"></script> -->
<script src="{{ asset ("/assets/node_modules/@popperjs/core/dist/umd/popper.min.js") }}"></script>
<script src="{{ asset ("/assets/node_modules/jquery-toast-plugin/dist/jquery.toast.min.js") }}"></script>
<script src="{{ asset ("/assets/bootstrap/dist/js/bootstrap.bundle.min.js") }}"></script>

<script src="{{ asset ("/assets/datatables/js/dataTables.bootstrap4.min.js") }}"></script>
<script src="{{ asset ("/assets/datatables/js/dataTables.rowReorder.min.js") }}"></script>
<script src="{{ asset ("/assets/datatables/js/dataTables.buttons.min.js") }}"></script>
<script src="{{ asset ("/assets/cto/js/cakrudtemplate.js") }}"></script>
<script src="{{ asset ("/assets/cto/js/cto_loadinganimation.min.js") }}"></script>

  <script src="{{ asset ("/assets/node_modules/gijgo/js/gijgo.min.js") }}"></script>
  <script src="{{ asset ("/assets/node_modules/autonumeric/dist/autoNumeric.min.js") }}"></script>
  <script src="{{ asset ("/assets/bower_components/jquery-validation/dist/jquery.validate.min.js") }}"></script>
  <script src="{{ asset ("/assets/bower_components/select2/dist/js/select2.full.min.js") }}"></script>
  <script src="{{ asset ("/assets/cto/js/dateformatvalidation.min.js") }}"></script>

<script>
  $("#tabaset").click(function(){
    window.location.href = "/coa/aset/list";
  });
  $("#tabhutang").click(function(){
    window.location.href = "/coa/hutang/list";
  });
  $("#tabmodal").click(function(){
    window.location.href = "/coa/modal/list";
  });
  $("#tabpendapatan").click(function(){
    window.location.href = "/coa/pendapatan/list";
  });
  $("#tabbiaya").click(function(){
    window.location.href = "/coa/biaya/list";
  });
  $("#tabbiaya_lainnya").click(function(){
    window.location.href = "/coa/biaya_lainnya/list";
  });
  $("#tabpendapatan_lainnya").click(function(){
    window.location.href = "/coa/pendapatan_lainnya/list";
  });
  var cat_fil = "";
  $(document).ready(function(){
	  var table = null;
    fetch_data1();
    cat_fil = "{{$page_data['category']}}";
    
  function fetch_data1(){
    cto_loading_show();
    
    var dataTable = $('#example1').DataTable({
      language: { search: "" , searchPlaceholder: "Search..."},
      //"searching": false,
      buttons: [
            {
                text: "+",
                className: "bg-success text-white m-0",
                action: function ( e, dt, node, config ) {
                  //window.location.href = "/create{{$page_data["page_data_urlname"]}}";
                  $("#modal-add-new-coa").modal({'show': true});
                }
            },
        ],
          aoColumnDefs: [{
              aTargets: [1],
              mRender: function (data, type, full){
                  data = data.toString();
                  var val = convertCode(data);
                  return "<span>"+val+"</span>";
                 
              },
              createdCell: function (td, cellData, rowData, row, col) {
                var padd = ((parseInt(rowData[3])-1)*10)+"px";
                $(td).css('padding-left', padd);
                $(td).addClass('asset_value');
                $(td).addClass('caktext');
                $(td).addClass('coa_code_column');
                $(td).attr('data-id', rowData[0]);
              }
            },
            {
              aTargets: [2],
              mRender: function (data, type, full){
                  data = data.toString();
                  return "<span>"+data+"</span>";
              },
              createdCell: function (td, cellData, rowData, row, col) {
                $(td).addClass('asset_value');
                $(td).addClass('caktext');
                $(td).attr('data-id', rowData[0]);
              }
            },
            {
              aTargets: [0,3,4,5,6,7,9],
              createdCell: function (td, cellData, rowData, row, col) {
                $(td).addClass('column-hidden');
              }
            }
          ],
          "autoWidth": false,
          dom: 'Bfrtip',
          "scrollX" : true,
          "processing" : true,
          "serverSide" : true,
          "pagingType": "full_numbers",
          "pageLength": 2000,
          "order": [[ 1, "asc" ]],
          "ajax" : {
          url:"/getlist{{$page_data["page_data_urlname"]}}",
          type:"POST",
          data:{
            _token: $("input[name=_token]").val(),
            category_filter: "{{$page_data['category']}}"
          }
        },
        "drawCallback": function(settings) {
          $("#example1").on("click",".row-add-child", function (event) {
            var data = [];
            $tr = $(this).parents('tr');
            $($tr).find('td').each(function(index, value) {
              if(index == 2){
                data[index] = $(this).find('span').html();
              }
              data[index] = $(this).html();
            });
            var newRow = $("<tr>");
            var cols = "";
            cols += '<td class="column-hidden"></td>';
            cols += '<td><input type="text" name="add_new_coa_code" tabindex="1" size="12"/></td>';
            cols += '<td><input type="text" name="add_new_coa_name" tabindex="2"/></td>';
            cols += '<td class="column-hidden">'+(parseInt(data[3])+1)+'</td>';
            cols += '<td class="column-hidden">'+data[0]+'</td>';
            cols += '<td class="column-hidden">'+data[2]+'</td>';
            cols += '<td class="column-hidden">'+data[6]+'</td>';
            cols += '<td class="column-hidden">'+data[7]+'</td>';
            cols += '<td><label class="form-check-label"><input type="checkbox" name="add_new_header" tabindex="3"> Header?</label></td>';
            cols += '<td class="column-hidden">on</td>';
            cols += '<td><i class="add-row-save fas fa-check text-success" style="cursor: pointer;"></i> &nbsp;&nbsp;&nbsp;&nbsp;<i class="add-row-cancel fas fa-times text-danger" style="cursor: pointer;"></i></td>';
            newRow.append(cols);
            newRow.insertAfter($(this).parents().closest('tr'));
            $("input[name=add_new_coa_code]").focus();
          });
        }
   });

   cto_loading_hide();
   table = dataTable;

   $('#example1').on('click', '.add-row-save', function(event) {
      event.stopPropagation();
      var $p = $(this).parent();
      var tr = $($p).parent();
      var val_arr = [];
      var category = "hutang";
      tr.find('td').each(function(index, value){
        if(index == 1 || index == 2){
          var $inp = $(this).find('input');
          value = $inp.val();
          if(index == 1){
            val_arr.push(value.replace(/-/g, ''));
          }else{
            val_arr.push(value);
          }
        }else if(index == 8){
          var $inp = $(this).find('input');
          if($inp.is(":checked")){
            val_arr.push("on");
          }else{
            val_arr.push("");
          }
        }else{
          val_arr.push($(value).text());
        }
        if(index == 6){
          category = $(value).text();
        }
      });
      var id_coa = submitform(val_arr, 'create');
      if(id_coa == 0){
        return;
      }
      $td = $(this).parent();
      $tr = $($td).parent();
      $($tr).find('td').each(function(index, value){
        if(index == 0){
          $(this).html(id_coa);
        }else if(index == 1){
          var padd = ((parseInt($($tr).find("td:eq(3)").text())-1)*10)+"px";
          $(this).css('padding-left', padd);
          $(this).addClass('asset_value');
          $(this).addClass('caktext');
          $(this).addClass('coa_code_column');
          $(this).attr('data-id', id_coa);
          $(this).html("<span>"+convertCode($(this).find('input').val())+"</span>");
        }else if(index == 2){
          $(this).addClass('asset_value');
          $(this).addClass('caktext');
          $(this).attr('data-id', id_coa);
          $(this).html("<span>"+$(this).find('input').val()+"</span>");
        }else if(index == 8){
          if($(this).find('input').is(":checked")){
            $(this).html("<span>on</span>");
          }else{
            $(this).html("");
          }
        }else if(index == 10){
          $(this).html('<button type="button" class="row-delete"> <i class="fas fa-minus-circle text-danger"></i> </button>');
          if($($tr).find("td:eq(8)").text() == "on"){
            $(this).append(' <button type="button" class="row-add-child"> <i class="fas fa-plus text-info"></i> </button>');
          }
        }
      });
    });

    $('#example1').on('click', 'span', function() {
      var $e = $(this).parent();
      var id_td = $e.attr('data-id');
      var val = $(this).html();

      if($e.hasClass("coa_code_column")){
        val = val.replace(/-/g, '');
      }

      if($e.hasClass("caktext")){
        if($e.hasClass("coa_code_column")){
          $e.html('<input type="text" value="" />');
        }else{
          $e.html('<input type="text" value="" size="34"/>');
        }
        var $newE = $e.find('input');
        $newE.focus();
        $newE.val(val);
        $newE.on('blur', function() {
          if($e.hasClass("coa_code_column")){
            var value = convertCode($(this).val());
          }else{
            var value = $(this).val();
          }
          $(this).parent().html('<span>'+value+'</span>');
          if(val != $(this).val()){
            var tr = $e.parent();
            var val_arr = [];
            tr.find('td').each(function(index, value){
              if(index == 1){
                val_arr.push($(value).text().replace(/-/g, ''));
              }else{
                val_arr.push($(value).text());
              }
            });
            submitform(val_arr);
          }
        });
      }
    });
 }

  $('#example1 tbody').on( 'click', '.row-delete', function () {
      $("#modal-delete").modal({'show': true});
      var data = table.row( $(this).parents('tr') );
      var id = data.data()[0];
      $(".row-delete-confirmed").on('click', function(){
        cto_loading_show();
        $.ajax({
          'async': false,
          'type': "POST",
          'global': false,
          'dataType': 'json',
          'url': "/delete{{$page_data["page_data_urlname"]}}",
          'data': { 'id':  id, '_token': $("input[name=_token]").val()},
          'success': function (data) {
            cto_loading_hide();
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
            fetch_data1();
          },
          'error': function (err) {    
            $.toast({
                text: err.status+"\n"+err.responseJSON.message,
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
        $("#modal-delete").modal('hide');
      })
    }); 
     
 });

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

 function submitform(val_arr, action = 'update'){
  var field_arr = ["id", "coa_code", "coa_name", "level_coa", "coa", "coa_label", "category", "category_label", "fheader", "factive"];
  cto_loading_show();

  var urlaction = "/updatecoa/"+val_arr[0];
  if(action == 'create'){
    urlaction = "/storecoa";
  }

  var values = "_token="+$("input[name=_token]").val();
  for(var x = 0; x < field_arr.length; x++){
    values = values+"&"+field_arr[x]+"="+val_arr[x];
  }
  var ajaxRequest;
  var id_coa = 0;
  ajaxRequest = $.ajax({
      url: urlaction,
      type: "post",
      data: values,
      async: false,
      success: function(data){
          if(data.status >= 200 && data.status <= 299){
              id_coa = data.data.id;
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
              var errors = "";
              $.each(err.responseJSON.errors, function (i, error) {
                  //var validator = $("#quickForm").validate();
                  // var errors = {};
                  // errors[i] = error[0];
                  //validator.showErrors(errors);
                  errors += error[0];
              });
              $.toast({
                    text: errors,
                    heading: 'Status',
                    icon: 'danger',
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

  return id_coa;
 }

var editor;


$(function () {
    $.validator.setDefaults({
        submitHandler: function (form, event) {
            event.preventDefault();
            cto_loading_show();
            var quickForm = $("#quickForm");

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
                    fetch_data1();
                },
                error: function (err) {
                    if (err.status == 422) {
                        $.each(err.responseJSON.errors, function (i, error) {
                            var validator = $("#quickForm").validate();
                            var errors = {};
                            errors[i] = error[0];
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

$("#coa").on("change", function() {
    $("#coa_label").val($("#coa option:selected").text());
});

$("#category").on("change", function() {
    $("#category_label").val($("#category option:selected").text());
});
var fields = $("#quickForm").serialize();

$.ajax({
    url: "/getoptions{{$page_data["page_data_urlname"]}}",
    type: "post",
    data: {
        fieldname: "category",
        _token: $("#quickForm input[name=_token]").val()
    },
    success: function(data){
        for(var i = 0; i < data.length; i++){
            if(data[i].name){
                var newState = new Option(data[i].label, data[i].name, true, false);
                $("#category").append(newState).trigger("change");
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
        coa_code :{
            required: true,
            minlength:5,
            maxlength:20
        },
        coa_name :{
            required: true,
            minlength:2,
            maxlength:255
        },
        level_coa :{
            required: true,
            minlength:1,
            maxlength:4
        },
        category :{
            required: true
        },
        fheader :{
            
        },
        factive :{
            required: true
        },
    },
    messages: {
        coa_code :{
            required: "Kode COA harus diisi!!",
            minlength: "Kode COA minimal 5 karakter!!",
            maxlength: "Kode COA maksimal 20 karakter!!"
        },
        coa_name :{
            required: "Nama COA harus diisi!!",
            minlength: "Nama COA minimal 2 karakter!!",
            maxlength: "Nama COA maksimal 255 karakter!!"
        },
        level_coa :{
            required: "Level COA harus diisi!!",
            minlength: "Level COA minimal 1 karakter!!",
            maxlength: "Level COA maksimal 4 karakter!!"
        },
        category :{
            required: "Kategori harus diisi!!"
        },
        fheader :{
            
        },
        factive :{
            required: "Aktif? harus diisi!!"
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
                if(Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i] == "coa"){
                    if(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]){
                        var newState = new Option(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"_label"], data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]], true, false);
                        $("#"+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]).append(newState).trigger("change");
                    }
                }else{
                    if(["fheader", "factive"].includes(Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i])){
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
</script>